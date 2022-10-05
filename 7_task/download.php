<?php

if(isset($_GET['path']))
{
//Читать файл
    $filename = $_GET['path'];
//Проверка на существование файла
    if(file_exists($filename)) {

//Определение информации заголовка
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Length: '. filesize($filename));
        header('Pragma: public');

//Очистить выходной буфер системы
        flush();

//Считайте размер файла
        readfile($filename);

//Завершить работу со скриптом
        die();
    }
    else{
        echo "Файл не существует.";
    }
}
else
    echo "Имя файла не определено.";

