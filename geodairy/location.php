<?php
session_start();
include('funcs.php');

$name = $_SESSION['username'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$pdo = db_connect();

$sql = 'INSERT INTO php_sample2 (id, name, latitude, longitude, date, time) VALUES (NULL, :name, :latitude, :longitude, CURDATE(), CURTIME())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':latitude', $lat, PDO::PARAM_STR);
$stmt->bindValue(':longitude', $lng, PDO::PARAM_STR);

$status = $stmt->execute();

header('Location: index.php');
?>

