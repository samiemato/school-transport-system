<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

include 'header.php'; // Include your header

// DB connection
$pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Booking stats
$totalBookings = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE student_id=?");
$totalBookings->execute([$userId]);
$totalBookings = $totalBookings->fetchColumn();

$pendingBookings = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE student_id=? AND status='pending'");
$pendingBookings->execute([$userId]);
$pendingBookings = $pendingBookings->fetchColumn();

$confirmedBookings = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE student_id=? AND status='confirmed'");
$confirmedBookings->execute([$userId]);
$confirmedBookings = $confirmedBookings->fetchColumn();

// Fetch latest bookings
$bookingsStmt = $pdo->prepare("SELECT * FROM bookings WHERE student_id=? ORDER BY created_at DESC");
$bookingsStmt->execute([$userId]);
$bookings = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <!-- Booking Stats -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-dark mb-3">
                <div class="card-body">
                    <h5>Pending Bookings</h5>
                    <h2><?php echo $pendingBookings; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <h5>Total Bookings</h5>
                    <h2><?php echo $totalBookings; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5>Confirmed Bookings</h5>
                    <h2><?php echo $confirmedBookings; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Bookings Table -->
    <div class="card">
        <div class="card-header bg-primary text-white">My Bookings</div>
        <div class="card-body">
            <?php if(count($bookings) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pickup</th>
                        <th>Dropoff</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Students</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Amount (KES)</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $b): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['pickup_location']); ?></td>
                        <td><?php echo htmlspecialchars($b['dropoff_location']); ?></td>
                        <td><?php echo htmlspecialchars($b['journey_date']); ?></td>
                        <td><?php echo htmlspecialchars($b['pickup_time']); ?></td>
                        <td><?php echo htmlspecialchars($b['no_of_students']); ?></td>
                        <td><?php echo htmlspecialchars($b['service_type']); ?></td>
                        <td>
                            <span class="badge <?php 
                                echo ($b['status']=='pending')?'bg-warning text-dark':'bg-success'; 
                            ?>"><?php echo ucfirst($b['status']); ?></span>
                        </td>
                        <td><?php echo number_format($b['amount'],2); ?></td>
                        <td>
                            <?php if($b['payment_status']=='pending'): ?>
                                <form method="POST" action="stk_push.php" class="d-flex">
                                    <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $b['amount']; ?>">
                                    <input type="tel" name="phone" placeholder="07XXXXXXXX" class="form-control me-2" required>
                                    <button type="submit" class="btn btn-primary btn-sm">Pay (Sandbox)</button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-success"><?php echo ucfirst($b['payment_status']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No bookings yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; // Include your footer ?>
