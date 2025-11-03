<?php
session_start();
require 'db_connect.php'; // include the DB connection

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['user_type'] = $user['user_type'];

        // Redirect to dashboard based on role
        if ($user['user_type'] === 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['user_type'] === 'driver') {
            header("Location: driver/dashboard.php");
        } elseif ($user['user_type'] === 'user') {
            header("Location: user/dashboard.php");
        } else {
            // fallback if role is unknown
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

include 'header.php';
?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Login to Your Account</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="register.php">Register here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
