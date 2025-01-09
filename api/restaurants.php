<?php
require '../db/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = $pdo->query("SELECT * FROM restaurants");
    $restaurants = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($restaurants);
}
?>