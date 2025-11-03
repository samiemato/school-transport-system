<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $phone = $_POST['phone'];

    // Format phone number to 2547XXXXXXXX
    if (substr($phone, 0, 1) == "0") {
        $phone = "254" . substr($phone, 1);
    }

    // ✅ Sandbox credentials
    $consumerKey = "ZG2i6xc84iWBiMbNDcR1nwJs5L5oA8jhoTdh8a3m6yuiFWeO";
    $consumerSecret = "bwNB1Hy5JOtCBDGAAnYCc6Np6jRaivkauyUYqGptmBX6tZ5RgpxZhsfV9SV5vcbR";

    // Sandbox Paybill & Passkey
    $BusinessShortCode = "174379"; 
    $Passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

    // 1. Generate access token
    $credentials = base64_encode($consumerKey . ":" . $consumerSecret);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if (!isset($response->access_token)) {
        die("❌ Failed to get SANDBOX access token. Check your sandbox keys.");
    }

    $access_token = $response->access_token;

    // 2. STK push request
    $Timestamp = date("YmdHis");
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    $stk_data = [
        "BusinessShortCode" => $BusinessShortCode,
        "Password" => $Password,
        "Timestamp" => $Timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => (int)$amount,
        "PartyA" => $phone,
        "PartyB" => $BusinessShortCode,
        "PhoneNumber" => $phone,
        "CallBackURL" => "https://example.com/callback.php", // dummy for sandbox
        "AccountReference" => $booking_id,
        "TransactionDesc" => "School Transport Payment (Sandbox Demo)"
    ];

    $ch = curl_init("https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $access_token
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($stk_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "<pre>";
    echo "✅ SANDBOX MODE: No real money will be deducted.<br>";
    echo "Response: " . $response;
    echo "</pre>";

    // ====== FAKE SUCCESS: Insert or update payment in DB ======
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if payment exists
        $stmt = $pdo->prepare("SELECT id FROM payments WHERE booking_id=?");
        $stmt->execute([$booking_id]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            // Update existing payment
            $stmt = $pdo->prepare("UPDATE payments 
                                   SET payment_status='completed', transaction_code=?, payment_date=NOW() 
                                   WHERE booking_id=?");
            $stmt->execute(["DEMO_RECEIPT_".time(), $booking_id]);
        } else {
            // Insert new payment row
            $stmt = $pdo->prepare("INSERT INTO payments (booking_id, payment_status, transaction_code, payment_date) 
                                   VALUES (?, 'completed', ?, NOW())");
            $stmt->execute([$booking_id, "DEMO_RECEIPT_".time()]);
        }

        // Update booking status
        $stmt = $pdo->prepare("UPDATE bookings SET status='confirmed' WHERE id=?");
        $stmt->execute([$booking_id]);

        echo "<p>✅ Payment marked as completed in demo.</p>";
    } catch (PDOException $e) {
        echo "<p class='text-danger'>❌ Demo DB update failed: ".$e->getMessage()."</p>";
    }
}
?>
