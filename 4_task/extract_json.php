<?php


$ourData = file_get_contents("posts.json"); // извекли Json из отдельного файла в переменную php в виде строки
$arr = json_decode($ourData, true); // преобразует в array php

// сделаем для каждого столбца переменную php
$status = $arr['status'];
$code = $arr['code'];
$total = $arr['total'];

foreach ($arr['data'] as $key => $val) {
  $title = $val['title'];
  $author = $val['author'];
  $genre = $val['genre'];
  $content = $val['content'];
}
