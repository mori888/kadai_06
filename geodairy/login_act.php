<?php
// データ受け取り
session_start();
include('funcs.php');

$username = $_POST['username'];
$password = $_POST['password'];

// DB接続
$pdo = db_connect();

// SQL実行
$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// ユーザ有無で条件分岐
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    $val = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$val) {
      echo "<p>ログイン情報に誤りがあります</p>";
      echo "<a href=login.php>ログイン</a>";
      exit();
    } else {
      $_SESSION = array();
      $_SESSION['session_id'] = session_id();
      $_SESSION['is_admin'] = $val['is_admin'];
      $_SESSION['username'] = $val['username'];
      header("Location:input.php");
      exit();
    }
  }
  