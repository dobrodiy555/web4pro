<?php

class Weather
{
    function checkWeather($url, $city, $appid, $units): array
    {
        $url .= '?q=' . $city . '&APPID=' . $appid . '&units=' . $units;
        $json_str = file_get_contents($url);
        if (!empty($json_str)) {
            $arr = json_decode($json_str, true)['main'];
            if ($arr === null) { // если битый json
                die("Error: bad json!");
            }
        } else {
            die("Error: empty json!");
        }

        return $arr;
    }
}


