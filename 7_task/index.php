<?php

$url = 'https://fakerapi.it/api/v1/'; // базовый Url к которому будем присобачивать параметры
$arr_of_types = ['addresses', 'books', 'companies', 'credit_cards', 'images', 'persons', 'texts', 'users',  'products', 'places'];
$arr_of_locale = ['uk_UA'=>'Ukrainian', 'en_US'=>'English', 'de_DE'=>'German', 'fr_FR'=>'French'];
$arr_of_format = ['JsonFileGenerator'=>'JSON', 'CsvFileGenerator'=>'CSV', 'ARRAY'=>'ARRAY'];
$quantity = 100;  // будет стоять по умолчанию при первом открытии страницы
$locale = '';
$typeOfData = '';
$formatOfData = '';

if (isset($_GET['locale'])) {
    if (!empty($_GET['locale'])) {
        $locale = $_GET['locale'];
    }
}
if (isset($_GET['quantity'])) {
    if (!empty($_GET['quantity'])) {
        $quantity = $_GET['quantity'];
    }
}
if (isset($_GET['typeOfData'])) {
    if (!empty($_GET['typeOfData'])) {
        $typeOfData = $_GET['typeOfData'];
    }
}
if (isset($_GET['formatOfData'])) {
    if (!empty($_GET['formatOfData'])) {
        $formatOfData = $_GET['formatOfData'];
    }
}

function generateArrayFile($url)
{
    $js_str = file_get_contents($url);
    if (!empty($js_str)) {
        $arr = json_decode($js_str, true);
        $filename = 'file.php';
        if (file_put_contents($filename, print_r($arr, return: true))) {
            echo "<p><a href='download.php?path=file.php'>Скачать файл ARRAY</a></p>";
        } else {
            echo "File generating failed!";
        }
    }
}

function generateJsonFile($url) {
    $filename = 'file.json';
    if (file_put_contents($filename, file_get_contents($url))) {
        echo "<p><a href='download.php?path=file.json'>Скачать файл JSON</a></p>";
    } else {
        echo "File generating failed!";
    }
}

function generateCsvFile($url)
{
    $js_str = file_get_contents($url);
    if (!empty($js_str)) {
        $arr = json_decode($js_str, true)['data'];
        $out = '';
        $header = false;
        foreach ($arr as $arrays) {
            if (!$header) {
                $out .= implode(",", array_keys($arrays)) . "\n"; // выводим заголовки
                $header = true;
            }
            $out .= @implode(",", $arrays) . "\n";
        }
        $filename = 'file.csv';
        if (file_put_contents($filename, $out)) {
            echo "<p><a href='download.php?path=file.csv'>Скачать файл CSV</a></p>";
        } else {
            echo "File generating failed!";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Fake Random Data File Generator</h1>
<form action="" method="get">
    <span>Choose type of data:</span>
    <select name="typeOfData">
        <?php foreach ($arr_of_types as $value) : ?>
            <option value="<?= $value ?>" <?= ($typeOfData == $value) ? "selected" : ""; ?>> <?= ucfirst($value); ?></option>
        <?php endforeach; ?>
    </select>
    </select>
    <br><br>
    <span>Choose number of records: </span>
        <input type="number" min="1" max="1000" name="quantity" value="<?= $quantity ?? '';?>" required>
    <br><br>
    <span>Choose language:</span>
    <select name="locale">
        <?php foreach ($arr_of_locale as $key=>$value) : ?>
            <option value="<?= $key ?>" <?= ($locale == $key) ? "selected" : ""; ?>><?= $value; ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <span>Choose format:</span>
    <select name="formatOfData">
        <?php foreach ($arr_of_format as $key=>$value) : ?>
            <option value="<?= $key ?>" <?= ($formatOfData == $key) ? "selected" : ""; ?>><?= $value; ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <input name="generateButton" type="submit" value="Generate" />  <!-- при нажатии присвоит переменные, сгенерирует файл и выведет ссылку для скачивания -->
</form>
</body>
</html>

<?php
$url .= $typeOfData . '?_quantity=' . $quantity . '&_locale=' . $locale; // присобачиваем нужные параметры к базовому url
if(array_key_exists('generateButton', $_GET)) {  // если нажата кнопка Generate
    switch ($formatOfData) { // выбираем ф-цию в зависимости от значения кнопки
        case 'JsonFileGenerator':
            generateJsonFile($url);
            break;
        case 'CsvFileGenerator':
            generateCsvFile($url);
            break;
        default:
            generateArrayFile($url);
    }
}
?>



