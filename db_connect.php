<?php
$servername = "localhost";
$username = "root";
$password = "";  // leave empty for XAMPP/WAMP
$dbname = "school_transport"; // your local DB name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // optional test
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
