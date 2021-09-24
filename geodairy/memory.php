<?php
if (
    !isset($_GET['name']) || $_GET['name']=='' ||
    !isset($_GET['date']) || $_GET['date']==''
) {
    exit('ParamError');
  }

$name = $_GET['name'];
$date = $_GET['date'];

include('funcs.php');
$pdo = db_connect();

$sql = 'SELECT * FROM `php_sample2` WHERE name=:name AND date=:date';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$status = $stmt->execute();


if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
  } else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
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
<div id="map"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://www.bing.com/api/maps/mapcontrol?key=AvbgFrHm4hy7jJao7wpdxLnt5BipW46hguArdITgArJi3AobqqhhPv5VLRAQrBPa' async defer></script>
<script>
    const location_array = <?=$json;?>;
    console.log(location_array)

    function mapsInit(position) {
      const latitude = location_array[0].latitude;
      const longitude = location_array[0].longitude;
      map = new Microsoft.Maps.Map('#map', {
        center: {
          latitude: latitude, longitude: longitude
        },
        zoom: 15,
      });

      location_array.forEach(function(locations){
        const lat = locations.latitude;
        const lng = locations.longitude;
        const time = locations.time
        pushPin(lat, lng, map);
        generateInfobox(lat, lng, map, time);
      });
    };

    function pushPin(lat, lng, map) {
      const location = new Microsoft.Maps.Location(lat, lng)
      const pin = new Microsoft.Maps.Pushpin(location, {
        color: 'red', 
        draggable:true,
        enableClickedStyle:true,
        enableHoverStyle:true,
        visible:true 
      });
      map.entities.push(pin);
    };

    function generateInfobox(lat, lng, map, time) {
      const location = new Microsoft.Maps.Location(lat, lng)
      const infobox = new Microsoft.Maps.Infobox(location, {
        title: time,
      });
      infobox.setMap(map);
      console.log('ok');
    };

    

    function showError (error) {
      const errorMessages = [
        '位置情報が許可されてません',
        '現在位置を特定できません',
        '位置情報を取得する前にタイムアウトになりました',
      ];
      alert(`error:${errorMessages[error.code - 1]}`);
    }

    const option = {
      enableHighAccuracy: true,
      maximumAge: 20000,
      timeout: 1000000,
    };

    window.onload = function(){
      navigator.geolocation.getCurrentPosition(mapsInit, showError, option);
    }
</script>
</body>
</html>