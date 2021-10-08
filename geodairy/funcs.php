<?php
function h($val){
  return htmlspecialchars($val,ENT_QUOTES);
}

function loginCheck(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    echo "LOGIN Error!";
    exit();
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
}

function db_connect(){
  $dbn ='mysql:dbname=gsacs_d03_00;charset=utf8;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

  try {
    $pdo = new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    exit('データベースに接続できませんでした。'.$e->getMessage());
  }
  return $pdo; 
}
?>
