<?php
if (
    !isset($_POST['name']) || $_POST['name']=='' ||
    !isset($_POST['lat']) || $_POST['lat']==''  ||
    !isset($_POST['lng']) || $_POST['lng']==''
  ) {
    exit('ParamError');
  }

$name = $_POST['name'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

include('funcs.php');
$pdo = db_connect();

$sql = 'INSERT INTO php_sample2 (id, name, latitude, longitude, date, time) VALUES (NULL, :name, :latitude, :longitude, CURDATE(), CURTIME())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':latitude', $lat, PDO::PARAM_STR);
$stmt->bindValue(':longitude', $lng, PDO::PARAM_STR);

$status = $stmt->execute();

header('Location: index.php');
?>

