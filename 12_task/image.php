<?php
require_once('funcs_for_db.php');
//create_db_task12(); // вызываем если база еще не создана
//create_table_in_db_task12(); // вызываем если таблица еще не создана
//fill_table_of_task12_with_data(); // если в таблице нет данных

header('Content-Type: image/png;'); // задаем тип содержимого в заголовках
$image = imagecreate(400, 50); // создаём изображение шириной в 400 и длиной в 50 пикселей
imagecolorallocate($image, 0, 0, 0); // задаём цвет изображения (черный)
$text_color = imagecolorallocate($image, 0, 255, 255); // задаём цвет текста
$user_input_id = $_GET['id']; // считаем get параметр id картинки для поиска по ключу в бд
$result_string = select_value_from_database_and_count($user_input_id);  // ищем в базе нужный текст
$text_on_image = $result_string ?? 'Hello Guest'; // если null то напишет Hello Guest
imagestring($image, 21, 20, 20, $text_on_image, $text_color);
imagepng($image);
imagedestroy($image);
