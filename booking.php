<?php
session_start();

// DB connection
$pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch pickup (schools) and dropoff (estates)
$pickupLocations = $pdo->query("SELECT name FROM locations WHERE type='pickup' ORDER BY name ASC")->fetchAll(PDO::FETCH_COLUMN);
$dropoffLocations = $pdo->query("SELECT name FROM locations WHERE type='dropoff' ORDER BY name ASC")->fetchAll(PDO::FETCH_COLUMN);

// Handle new booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_booking'])) {
    $pickup = $_POST['pickup'] ?? '';
    $dropoff = $_POST['dropoff'] ?? '';
    $journeyDate = $_POST['journey_date'] ?? '';
    $pickupTime = $_POST['pickup_time'] ?? '';
    $serviceType = $_POST['service_type'] ?? 'daily';
    $noOfStudents = $_POST['no_of_students'] ?? 1;

    // Rough pricing
    $pricing = ['daily'=>50, 'event'=>100, 'special'=>150, 'group'=>200];
    $amount = ($pricing[$serviceType] ?? 50) * $noOfStudents;

    // Insert booking
    $stmt = $pdo->prepare("INSERT INTO bookings 
        (student_id, pickup_location, dropoff_location, journey_date, pickup_time, service_type, status, amount, payment_status, no_of_students) 
        VALUES (:student_id, :pickup, :dropoff, :journey_date, :pickup_time, :service_type, 'pending', :amount, 'pending', :no_of_students)");
    $stmt->execute([
        ':student_id'=>$userId,
        ':pickup'=>$pickup,
        ':dropoff'=>$dropoff,
        ':journey_date'=>$journeyDate,
        ':pickup_time'=>$pickupTime,
        ':service_type'=>$serviceType,
        ':amount'=>$amount,
        ':no_of_students'=>$noOfStudents
    ]);

    // ✅ Redirect to dashboard after booking
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book New Ride</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">

    <div class="card">
        <div class="card-header bg-success text-white">Book a New Ride</div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="new_booking" value="1">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Pickup Location (School)</label>
                        <select name="pickup" class="form-select" required>
                            <option value="">Select School</option>
                            <?php foreach($pickupLocations as $loc): ?>
                                <option value="<?php echo $loc; ?>"><?php echo $loc; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Dropoff Location (Estate)</label>
                        <select name="dropoff" class="form-select" required>
                            <option value="">Select Estate</option>
                            <?php foreach($dropoffLocations as $loc): ?>
                                <option value="<?php echo $loc; ?>"><?php echo $loc; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="journey_date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Pickup Time</label>
                        <input type="time" name="pickup_time" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Number of Students</label>
                        <input type="number" name="no_of_students" class="form-control" value="1" min="1" required>
                    </div>
                </div>

                <label>Service Type</label>
                <select name="service_type" class="form-select mb-3">
                    <option value="daily">Daily</option>
                    <option value="event">Event</option>
                    <option value="special">Special</option>
                    <option value="group">Group</option>
                </select>

                <button type="submit" class="btn btn-success">Confirm Booking</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>
