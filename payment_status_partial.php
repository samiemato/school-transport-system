<?php 
include 'db.php';

if (!isset($_GET['booking_id'])) {
    exit("<p class='text-danger'>❌ Booking ID missing</p>");
}
$booking_id = $_GET['booking_id'];

$stmt = $pdo->prepare("SELECT * FROM payments WHERE booking_id = ?");
$stmt->execute([$booking_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($payment): ?>

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
    <p class="text-center text-muted">No payment information found.</p>
<?php endif; ?>
