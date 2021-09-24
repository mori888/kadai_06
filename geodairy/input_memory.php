<?php
if (
    !isset($_POST['name']) || $_POST['name']==''
) {
    exit('ParamError');
  }

$name = $_POST['name'];

include('funcs.php');
$pdo = db_connect();

$sql = 'SELECT date FROM `php_sample2` WHERE name=:name ORDER BY date ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
  } else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    $date = "";
    foreach ($result as $record) {
        if($date !== $record["date"]){
            $output .= "<p>";
            $output .= '<a href="memory.php?name='.$name.'&date='.$record["date"].'">';
            $output .= $record['date'];
            $output .= "</a>";
            $output .= "</p>";
            $date = $record["date"];
        } 
    }
  }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    

</head>
<body>
  <form action="?" method="POST">
    <fieldset>
      <legend>現在地情報</legend>
      <button type="button" id="getPosition">現在位置取得</button>
      <div>
        名前<input type="text" name="name">
      </div>
      <div>
        緯度<input type="text"  id="lat" name="lat">
      </div>
      <div>
        経度<input type="text" id="lng" name="lng">
      </div>
      <button type="submit" formaction="location.php">保存</button>
    </fieldset>
  </form>

    <fieldset>
        <?= $output ?>
    </fieldset>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script> 
    function p(position){
      console.log(position);
      $('#lat').val(position.coords.latitude);
      $('#lng').val(position.coords.longitude);
    }

    $('#getPosition').on('click', function(){
      navigator.geolocation.getCurrentPosition(p);
    });
</script>
</body>
</html>