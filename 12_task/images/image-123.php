<?php
require_once('../funcs_for_db.php'); // .. на одну директорию вниз
//create_db_task12(); // вызываем если база еще не создана
//create_table_in_db_task12(); // вызываем если таблица еще не создана
//fill_table_of_task12_with_data(); // если в таблице нет данных

// Создаём изображение шириной в 400 и длиной в 50 пикселей
$image = imagecreate(400, 50);
// Задаём цвет изображения (RGB)
imagecolorallocate($image, 0, 0, 0);
// Задаём цвет текста
$text_color = imagecolorallocate($image, 0, 255, 255);
$result_string = select_value_from_database('123');
// Добавляем текст на картинку
imagestring($image, 21, 20, 20, $result_string, $text_color);
// Отправляем заголовки серверу
header('Content-Type: image/png;');
//Задаём тип содержимого
imagepng($image);
imagedestroy($image);


