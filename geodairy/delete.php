<?php
session_start();
include('funcs.php');

$name = $_SESSION['username'];
$date = $_GET['date'];

$pdo = db_connect();

$sql = 'DELETE FROM php_sample2 WHERE name=:name and date=:date';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:input_memory.php");
  exit();
}