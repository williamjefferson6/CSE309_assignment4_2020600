<?php
    $city = $_GET['city'] ?? 'Dhaka';
    $country = $_GET['country'] ?? 'Bangladesh';

    if($city == "" || $country == ""){
        $city = 'Dhaka';
        $country = 'Bangladesh';
    }

    $url = "http://api.openweathermap.org/data/2.5/forecast?q=" . $city . "," . $country . "&appid=56bf08b0d9522be3ececf8dd981e50b7";

    $contents = file_get_contents($url);
    $climate = json_decode($contents);

    $city = $climate->city->name;
    $country = $climate->city->country;

    $cdata = $climate->list[0];
    $ctemp = $cdata->main->temp - 273.15;
    $chumidity = $cdata->main->humidity;
    $cwindspeed = $cdata->wind->speed;
    $cicon = "http://openweathermap.org/img/wn/" . $cdata->weather[0]->icon . "@4x.png";
    $currentdate = $cdata->dt_txt;
    $cdate = $cdata->dt_txt;
    $cdate = substr($cdate, 9, 1) + 1;

    $counter = 0;
    $temp = array("0", "0", "0", "0");
    $date = array("0", "0", "0", "0");
    $icon= array("0", "0", "0", "0");
    
    for ($i = 1; $i < 40; $i = $i + 1){
        $tdata = $climate->list[$i];
        $tdate = $tdata->dt_txt;
        $tdate = substr($tdate, 8, 2);
        if ($tdate == $cdate){
            $rdate = $tdata->dt_txt;
            $cdate = substr($rdate, 8, 2) + 1;
            $temp[$counter] = $tdata->main->temp - 273.15;
            $sdate = $tdata->dt_txt;
            $date[$counter] = substr($sdate, 8, 2) . "-" . substr($sdate, 5, 2) . "-" . substr($sdate, 0, 4);
            $icon[$counter] = "http://openweathermap.org/img/wn/" . $tdata->weather[0]->icon . "@2x.png";
            $counter = $counter + 1;
        }
    };
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORECAST.EXE</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>

<body>
    <div class="banner">
        <div class="header">
            <h1>forecast.exe</h1>
            <div class="location">
                <img src="location.png">
                <div class="location2">
                    <h5>Current Location:</h5>
                    <p><?= $city . "," . $country ?></p>
                </div>
            </div>
        </div>
        <div class="search">
            <form>
                <input class="inputs" type="text" placeholder="Enter City" name="city">
                <input class="inputs" type="text" placeholder="Enter Country" name="country">
                <button type="submit" value="submit"></button>
            </form>
        </div>
    </div>
    <div class="content">
        <div class="sections">
            <h1>TODAY (<?= substr($currentdate, 8, 2) . "-" . substr($currentdate, 5, 2) . "-" . substr($currentdate, 0, 4) ?>)</h1>
            <div id="today" class="cards">
                <div id="current" class="cicon">
                    <img src="<?= $cicon ?>"> 
                </div>
                <div id="current" class="cdata">
                    <h2>Temperature: <?= $ctemp ?>°C</h2>
                    <h2>Humidity: <?= $chumidity ?>%</h2>
                    <h2>Wind Speed: <?= $cwindspeed ?>m/s</h2>
                </div>
            </div>
        </div>
        <div class="sections">
            <h1>NEXT 4 DAYS</h1>
            <div id="fourdays" class="cards2">
                <div class="smol">
                    <img src="<?= $icon[0] ?>">
                    <p><?= $temp[0] ?>°C</p>
                    <p><?= $date[0] ?></p>
                </div>
                <div class="smol">
                    <img src="<?= $icon[1] ?>">
                    <p><?= $temp[1] ?>°C</p>
                    <p><?= $date[1] ?></p>
                </div>
                <div class="smol">
                    <img src="<?= $icon[2] ?>">
                    <p><?= $temp[2] ?>°C</p>
                    <p><?= $date[2] ?></p>
                </div>
                <div class="smol">
                    <img src="<?= $icon[3] ?>">
                    <p><?= $temp[3] ?>°C</p>
                    <p><?= $date[3] ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>