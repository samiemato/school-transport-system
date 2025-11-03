<?php
session_start();
include 'db.php';

if (!isset($_GET['booking_id'])) {
    exit("<p class='text-danger'>❌ Booking ID missing</p>");
}
$booking_id = $_GET['booking_id'];

// Fetch payment details
$stmt = $pdo->prepare("SELECT * FROM payments WHERE booking_id = ?");
$stmt->execute([$booking_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">💳 Payment Status</h4>
                    <hr>

                    <div id="payment-details">
                        <?php if ($payment): ?>
                            <?php if ($payment['payment_status'] === 'completed'): ?>
                                <div class="alert alert-success text-center">✅ Payment Completed!</div>
                            <?php endif; ?>

                            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking_id); ?></p>
                            <p><strong>Amount:</strong> Ksh <?php echo number_format($payment['amount'], 2); ?></p>
                            <p>
                                <strong>Status:</strong>
                                <span class="badge 
                                    <?php 
                                    switch($payment['payment_status']) {
                                        case 'completed': echo 'bg-success'; break;
                                        case 'pending': echo 'bg-warning text-dark'; break;
                                        case 'failed': echo 'bg-danger'; break;
                                        default: echo 'bg-secondary';
                                    }
                                    ?>">
                                    <?php echo ucfirst($payment['payment_status']); ?>
                                </span>
                            </p>

                            <?php if (!empty($payment['payment_method'])): ?>
                                <p><strong>Method:</strong> <?php echo ucfirst($payment['payment_method']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($payment['transaction_code'])): ?>
                                <p><strong>Transaction Code:</strong> <?php echo htmlspecialchars($payment['transaction_code']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($payment['payment_date'])): ?>
                                <p><strong>Date:</strong> <?php echo date('F j, Y g:i A', strtotime($payment['payment_date'])); ?></p>
                            <?php endif; ?>

                        <?php else: ?>
                            <p class="text-center text-muted">No payment information found for this booking.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Auto-refresh payment status every 10 seconds if still pending
function checkStatus() {
    fetch("payment_status_partial.php?booking_id=<?php echo $booking_id; ?>")
        .then(response => response.text())
        .then(html => {
            document.getElementById("payment-details").innerHTML = html;

            // If still pending, keep refreshing
            if (html.includes("Pending")) {
                setTimeout(checkStatus, 10000);
            }

            // If completed, redirect after 3 seconds
            if (html.includes("Completed")) {
                setTimeout(() => {
                    window.location.href = "booking_confirmed.php?booking_id=<?php echo $booking_id; ?>";
                }, 3000);
            }
        })
        .catch(err => console.error("Error fetching status:", err));
}

// Start refreshing after 10s if pending
setTimeout(checkStatus, 10000);
</script>

</body>
</html>
