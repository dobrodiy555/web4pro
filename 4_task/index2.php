<?php

$ourData = file_get_contents("posts.json"); // извекли Json из отдельного файла в переменную php в виде строки

if (!empty($ourData)) { // проверка на ошибки
  $arr = json_decode($ourData, true); // преобразует json в array php
} else {
  die("Error: no json file!"); // завершить в случае ошибки
}
if ($arr === null) {
  die("Error: bad json!");
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5; // кол-во записей на странице
$offset = $limit * ($page - 1);
if (!empty($arr['data'])) {  // проверить есть ли данные
  $arr = $arr['data']; // array с которым мы будем работать, перезаписываем переменную
} else {
  die("No such data!");
}
$total = count($arr); // сколько всего будет постов
$total_pages = ceil($total / $limit); // всего страниц
$posts = array_splice($arr, $offset, $limit);
$i = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <style type="text/css">
    body {
      margin: 10px;
    }

    h1 {
      text-align: center;
    }

    nav {
      margin-top: 20px;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
      transition: background-color .3s;
    }

    /* Стиль активной/текущей ссылки */
    .pagination a.active {
      background-color: dodgerblue;
      color: white;
    }

    /* Добавить серый цвет фона при наведении курсора мыши */
    .pagination a:hover:not(.active) {
      background-color: #ddd;
    }

    .pagination {
      justify-content: center;
      margin-top: 30px;
    }
  </style>
  <title>Document</title>
</head>

<body>

  <h1>Pagination page</h1>

  <?php foreach ($posts as $k => $v) : ?>
    <table border='1' bgcolor=<?php if ($i % 2 != 0) {
                                echo "yellowgreen";
                              } ?>>
      <tr>
        <td><b>Title: </b><br> <?= $v['title'] ?> </td><br>
        <td><b>Author: </b><br> <?= $v['author'] ?> </td><br>
        <td><b>Content: </b><br> <?= $v['content'] ?> </td>
      </tr>
    </table>
  <?php $i++;
  endforeach; ?>

  <div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
      <a class='page-link <?php if ($i == $page) {
                            echo "active disabled";
                          } ?>' href=?page=<?= $i ?>> <?= $i ?> </a>
    <?php endfor; ?>
  </div>

</body>

</html>