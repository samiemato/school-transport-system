<?php 
session_start();
include 'header.php';

// DB connection
$pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Get booking ID
if (!isset($_GET['booking_id'])) {
    header("Location: my_bookings.php");
    exit();
}

$booking_id = $_GET['booking_id'];
$user_id = $_SESSION['user_id'];

// ✅ Fetch booking with school + route info
$stmt = $pdo->prepare("SELECT b.*, r.route_name, r.price, s.school_name 
                       FROM bookings b
                       LEFT JOIN routes r ON b.route_id = r.id
                       LEFT JOIN schools s ON b.school_id = s.id
                       WHERE b.id = ? AND b.user_id = ?");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    echo "<div class='alert alert-danger text-center m-5'>Booking not found.</div>";
    include 'footer.php';
    exit();
}
?>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h3 class="mb-4">Complete Payment</h3>

        <!-- Booking Summary -->
        <div class="mb-4">
            <h5>Booking Summary</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>School:</strong> <?= htmlspecialchars($booking['school_name']) ?></li>
                <li class="list-group-item"><strong>Route:</strong> <?= htmlspecialchars($booking['route_name']) ?></li>
                <li class="list-group-item"><strong>Amount:</strong> KES <?= number_format($booking['price'], 2) ?></li>
                <li class="list-group-item"><strong>Status:</strong> <?= ucfirst($booking['status']) ?></li>
            </ul>
        </div>

        <!-- Payment Form -->
        <?php if ($booking['status'] == 'pending') : ?>
        <form action="stk_push.php" method="POST" class="row g-3">
            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
            <input type="hidden" name="amount" value="<?= $booking['price'] ?>">

            <div class="col-md-12">
                <label class="form-label">Enter M-PESA Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="07XXXXXXXX" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success w-100">Proceed to Pay with M-PESA</button>
            </div>
        </form>
        <?php else: ?>
            <div class="alert alert-info">
                This booking is already <strong><?= ucfirst($booking['status']) ?></strong>.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
