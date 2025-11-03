<?php
$host = "localhost";
$dbname = "school_transport";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("DB Error: " . $e->getMessage());
}

if (isset($_GET['route_id'])) {
    $route_id = (int)$_GET['route_id'];
    $stmt = $pdo->prepare("SELECT price FROM routes WHERE id = ?");
    $stmt->execute([$route_id]);
    $route = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $route ? $route['price'] : '';
}
