<?php // моя основная страница

require "Collection.php";
require "CollectionExport.php";
require "UsersCollection.php";
require "ProductsCollection.php";
require "PlacesCollection.php";
require "JsonCollectionExport.php";
require "CsvCollectionExport.php";

$resultOfExport = "";
$collection = "";


if (isset($_POST['Collection'])) {
  if (!empty($_POST['Collection'])) {
    $collection = $_POST['Collection'];
  }
  if (!empty($_POST['TypeExport'])) {
    $export = $_POST['TypeExport'];
  }

  $collectionToExport = new $collection();
  $exportMechanizm = new $export();
  $result = $exportMechanizm->transform_array($collectionToExport);
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
      <option value="UsersCollection" <?php echo ($collection == "UsersCollection") ? "selected" : ""; ?>>UsersCollection</option>
      <option value="ProductsCollection" <?php echo ($collection == "ProductsCollection") ? "selected" : ""; ?>>ProductsCollection</option>
      <option value="PlacesCollection" <?php echo ($collection == "PlacesCollection") ? "selected" : ""; ?>>PlacesCollection</option>
    </select>
    <br><br>
    <div>
      <input name="TypeExport" type="submit" value="CsvCollectionExport" />
      <input name="TypeExport" type="submit" value="JsonCollectionExport" />
    </div>
    <br>
    <div>

      <span><?= print_r($result) ?></span>

    </div>
  </form>
</body>

</html>