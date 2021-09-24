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
      <button type="submit" formaction="input_memory.php">保存した位置情報</button>
    </fieldset>
  </form>

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