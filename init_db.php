<?php
// Database configuration
$host = "localhost";
$dbname = "school_transport";
$username = "root";
$password = "";

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            user_type ENUM('admin', 'student', 'driver') DEFAULT 'student',
            full_name VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            address TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS vehicles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            vehicle_number VARCHAR(20) NOT NULL UNIQUE,
            vehicle_type VARCHAR(50) NOT NULL,
            capacity INT NOT NULL,
            driver_id INT,
            status ENUM('active', 'inactive', 'maintenance') DEFAULT 'active',
            FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE SET NULL
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS routes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            route_name VARCHAR(100) NOT NULL,
            start_point VARCHAR(100) NOT NULL,
            end_point VARCHAR(100) NOT NULL,
            stops TEXT,
            distance DECIMAL(5,2),
            estimated_time TIME
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT NOT NULL,
            route_id INT NOT NULL,
            vehicle_id INT,
            service_type ENUM('daily', 'event', 'special', 'group') NOT NULL,
            booking_date DATE NOT NULL,
            journey_date DATE NOT NULL,
            pickup_time TIME,
            dropoff_time TIME,
            status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
            FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE SET NULL
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            booking_id INT NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            payment_method VARCHAR(50),
            payment_status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
            transaction_id VARCHAR(100),
            payment_date DATETIME,
            FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
        )
    ");
    
    // Insert sample data
    // Create admin user
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (username, password, email, user_type, full_name) 
                VALUES ('admin', '$hashed_password', 'admin@schooltrans.com', 'admin', 'Administrator')");
    
    // Create sample driver
    $hashed_password = password_hash('driver123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (username, password, email, user_type, full_name, phone) 
                VALUES ('driver1', '$hashed_password', 'driver@schooltrans.com', 'driver', 'John Driver', '555-1234')");
    
    // Create sample student
    $hashed_password = password_hash('student123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (username, password, email, user_type, full_name, phone, address) 
                VALUES ('student1', '$hashed_password', 'student@example.com', 'student', 'Jane Student', '555-5678', '123 Student St, City')");
    
    // Get driver ID
    $driver_id = $pdo->query("SELECT id FROM users WHERE username = 'driver1'")->fetchColumn();
    
    // Create sample vehicle
    $pdo->exec("INSERT IGNORE INTO vehicles (vehicle_number, vehicle_type, capacity, driver_id) 
                VALUES ('SCH-001', 'Minibus', 15, $driver_id)");
    
    // Create sample routes
    $pdo->exec("INSERT IGNORE INTO routes (route_name, start_point, end_point, stops, distance, estimated_time) 
                VALUES 
                ('Route A', 'City Center', 'School Campus', 'Stop 1, Stop 2, Stop 3', 5.2, '00:25:00'),
                ('Route B', 'North District', 'School Campus', 'Stop 4, Stop 5', 7.8, '00:35:00'),
                ('Route C', 'South District', 'School Campus', 'Stop 6, Stop 7, Stop 8', 10.5, '00:45:00')");
    
    echo "Database initialized successfully!";
    
} catch (PDOException $e) {
    die("Database initialization failed: " . $e->getMessage());
}
?>