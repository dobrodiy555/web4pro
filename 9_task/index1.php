<?php

require "Weather.php";
$url = 'https://api.openweathermap.org/data/2.5/weather';
$city = '';
$appid = 'caee20174ec39f94071aff552d2b087c';
$units = 'metric';

if (isset($_GET['checkWeather'])) { // если нажали кнопку
    if (isset($_GET['city'])) {
        if (!empty($_GET['city'])) {
            $city = $_GET['city'];
            $obj_weather = new Weather(); // вызываем обьект класса
            $arr = $obj_weather->checkWeather($url, $city, $appid, $units); // вызываем ф-цию класса
        }
    }
}

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
    <h1>Weather Forecast</h1>
    <form action="" method="get">
        <span>Choose city: </span>
        <select name="city">
            <option value="Kyiv" <?= ($city == "Kyiv") ? "selected" : ""; ?>>Kyiv</option>
            <option value="London" <?= ($city == "London") ? "selected" : ""; ?>>London</option>
            <option value="Madrid" <?= ($city == "Madrid") ? "selected" : ""; ?>>Madrid</option>
        </select>
        <br><br>
        <input type="submit" name="checkWeather" value="Check weather">
    </form>
    <br>
    <div class="info_weather" style="<?= (empty($city)) ? 'display: none' : ''; ?>"> <!-- пока город пустой не отображай эту часть -->
        <p><b>City: </b>  <?= $city ?> </p>
        <p><b>Temperature: </b> <?= $arr['temp'] ?> </p>
        <p><b>Humidity: </b> <?= $arr['humidity'] ?> </p>
    </div>

    </body>
    </html>


