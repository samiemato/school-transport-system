<?php
// DB connection
$pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get callback data
$data = file_get_contents("php://input");
$callbackData = json_decode($data, true);

// Log raw response for debugging
file_put_contents("mpesa_callback_log.txt", $data . PHP_EOL, FILE_APPEND);

if (isset($callbackData['Body']['stkCallback'])) {
    $stkCallback = $callbackData['Body']['stkCallback'];
    $resultCode = $stkCallback['ResultCode'];

    $booking_id = null;
    $amount = 0;
    $mpesaCode = null;

    // Extract metadata
    if (isset($stkCallback['CallbackMetadata']['Item'])) {
        foreach ($stkCallback['CallbackMetadata']['Item'] as $item) {
            if ($item['Name'] == 'Amount') {
                $amount = $item['Value'];
            }
            if ($item['Name'] == 'MpesaReceiptNumber') {
                $mpesaCode = $item['Value'];
            }
            if ($item['Name'] == 'AccountReference') {
                $booking_id = $item['Value']; // Use booking id directly
            }
        }
    }

    if ($resultCode == 0 && $booking_id) {
        // ✅ Payment success
        $stmt = $pdo->prepare("UPDATE payments 
                               SET payment_status='completed', transaction_code=?, payment_date=NOW()
                               WHERE booking_id=?");
        $stmt->execute([$mpesaCode ?? "TEST_RECEIPT", $booking_id]);

        $stmt = $pdo->prepare("UPDATE bookings SET status='confirmed' WHERE id=?");
        $stmt->execute([$booking_id]);
    } else {
        // ❌ Payment failed or cancelled
        if ($booking_id) {
            $stmt = $pdo->prepare("UPDATE payments SET payment_status='failed' WHERE booking_id=?");
            $stmt->execute([$booking_id]);

            $stmt = $pdo->prepare("UPDATE bookings SET status='failed' WHERE id=?");
            $stmt->execute([$booking_id]);
        }
    }
}

// Send back acknowledgment to Safaricom
echo json_encode(["ResultCode" => 0, "ResultDesc" => "Callback received successfully"]);
?>
yes