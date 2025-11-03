<?php
session_start();

// DB connection
$pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE student_id = :user_id ORDER BY created_at DESC");
$stmt->execute([':user_id' => $user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<div class="container my-5">
    <h3>My Bookings</h3>
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Pickup</th>
                <th>Dropoff</th>
                <th>Date</th>
                <th>Time</th>
                <th>No. of Students</th>
                <th>Amount (KES)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($bookings as $b): ?>
            <?php 
                // Calculate rough amount per booking
                switch($b['service_type']){
                    case 'daily':
                        $unit_price = 100;
                        break;
                    case 'event':
                        $unit_price = 200;
                        break;
                    case 'special':
                        $unit_price = 150;
                        break;
                    case 'group':
                        $unit_price = 150;
                        break;
                    default:
                        $unit_price = 100;
                }
                $amount = $unit_price * $b['no_of_students'];
            ?>
            <tr>
                <td><?php echo $b['id']; ?></td>
                <td><?php echo htmlspecialchars($b['pickup_location']); ?></td>
                <td><?php echo htmlspecialchars($b['dropoff_location']); ?></td>
                <td><?php echo $b['journey_date']; ?></td>
                <td><?php echo $b['pickup_time']; ?></td>
                <td><?php echo $b['no_of_students']; ?></td>
                <td><?php echo number_format($amount); ?></td>
                <td>
                    <?php if($b['status'] == 'pending'): ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                    <?php elseif($b['status'] == 'confirmed'): ?>
                        <span class="badge bg-success">Confirmed</span>
                    <?php else: ?>
                        <span class="badge bg-danger"><?php echo htmlspecialchars($b['status']); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($b['status'] == 'pending'): ?>
                        <a href="cancel_booking.php?id=<?php echo $b['id']; ?>" class="btn btn-sm btn-danger mb-1">Cancel</a>
                        <form action="stk_push.php" method="POST" style="display:inline;">
                            <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                            <input type="hidden" name="phone" value="<?php echo $_SESSION['phone'] ?? ''; ?>">
                            <button type="submit" class="btn btn-sm btn-primary mb-1">Pay</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
