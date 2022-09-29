<?php // моя основная страница

require "Collection.php";
require "CollectionExport.php";
require "UsersCollection.php";
require "ProductsCollection.php";
require "PlacesCollection.php";
require "JsonCollectionExport.php";
require "CsvCollectionExport.php";

$resultOfExport = "";
$collection = ""; // чтоб не ругалось что нет переменных при первом запуске страницы

if (isset($_POST['Collection'])) {
  if (!empty($_POST['Collection'])) {
    $collection = $_POST['Collection'];
  }
  if (!empty($_POST['TypeExport'])) {
    $export = $_POST['TypeExport'];   // присваиваем значение переменных из value методом post если value не пусто
  }

  $collectionToExport = new $collection(); // создаем обьект класса PlacesCollection, ProductsCollection или UsersCollection
  $exportMechanizm = new $export(); // создаем обьект класса CsvCollectionExport или JsonCollectionExport
  $resultOfExport = $exportMechanizm->transform_array($collectionToExport); // вызываем метод transform_array родительского класса
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
  <form action="" method="post">
    <select name="Collection">
      <option value="UsersCollection" <?= ($collection == "UsersCollection") ? "selected" : ""; ?>>UsersCollection</option>
      <option value="ProductsCollection" <?= ($collection == "ProductsCollection") ? "selected" : ""; ?>>ProductsCollection</option>
      <option value="PlacesCollection" <?= ($collection == "PlacesCollection") ? "selected" : ""; ?>>PlacesCollection</option>
    </select>
    <br><br>
    <div>
      <input name="TypeExport" type="submit" value="CsvCollectionExport" />
      <input name="TypeExport" type="submit" value="JsonCollectionExport" />
    </div>
    <br>
    <div>

      <span><?= $resultOfExport ?></span>

    </div>
  </form>
</body>

</html>