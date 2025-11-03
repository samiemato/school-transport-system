<?php
$host = "localhost";
$dbname = "school_transport";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['school_id'])) {
    $school_id = $_GET['school_id'];
    $stmt = $pdo->prepare("SELECT id, route_name, price FROM routes WHERE school_id = ?");
    $stmt->execute([$school_id]);
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($routes) {
        foreach ($routes as $route) {
            echo '<option value="'.$route['id'].'">'.$route['route_name'].' - Ksh '.$route['price'].' / month</option>';
        }
    } else {
        echo '<option value="">No routes available</option>';
    }
}
?>
