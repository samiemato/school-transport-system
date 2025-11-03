<?php include 'header.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->execute([$full_name, $email, $phone, $address, $user_id]);
        
        // Update session variable
        $_SESSION['full_name'] = $full_name;
        
        $success = "Profile updated successfully!";
        
        // Refresh user data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error updating profile: " . $e->getMessage();
    }
}

// Handle password change form submission
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                try {
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$hashed_password, $user_id]);
                    $password_success = "Password changed successfully!";
                } catch (PDOException $e) {
                    $password_error = "Error changing password: " . $e->getMessage();
                }
            } else {
                $password_error = "New password must be at least 6 characters long";
            }
        } else {
            $password_error = "New passwords do not match";
        }
    } else {
        $password_error = "Current password is incorrect";
    }
}
?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="display-5 fw-bold text-primary">My Profile</h1>
                <p class="lead">Manage your account information</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form action="profile.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" value="<?php echo $user['username']; ?>" disabled>
                                    <div class="form-text">Username cannot be changed</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"><?php echo $user['address']; ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Change Password</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($password_success)): ?>
                            <div class="alert alert-success"><?php echo $password_success; ?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($password_error)): ?>
                            <div class="alert alert-danger"><?php echo $password_error; ?></div>
                        <?php endif; ?>
                        
                        <form action="profile.php" method="POST">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <div class="form-text">Password must be at least 6 characters long</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            
                            <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0"><?php echo $user['full_name']; ?></h5>
                                <p class="text-muted mb-0"><?php echo ucfirst($user['user_type']); ?></p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-1"><strong>Member Since:</strong></p>
                            <p class="text-muted"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-1"><strong>Account Status:</strong></p>
                            <p><span class="badge bg-success">Active</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="dashboard.php" class="btn btn-outline-primary">Dashboard</a>
                            <a href="my_bookings.php" class="btn btn-outline-primary">My Bookings</a>
                            <a href="booking.php" class="btn btn-primary">New Booking</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>