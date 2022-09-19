<?php


$ourData = file_get_contents("posts.json"); // извекли Json из отдельного файла в переменную php в виде строки

if (!empty($ourData)) { // проверка на ошибки
  $arr = json_decode($ourData, true); // преобразует json в array php
} else {
  echo "Error: no json file!";
}

if ($arr === null) {
  echo "Error: bad json!";
}

error_reporting(E_ERROR | E_PARSE);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5; // кол-во записей на странице
$offset = $limit * ($page - 1);
$arr1 = $arr['data']; // array с которым мы будем работать
foreach ($arr1 as $k => &$v) {
  unset($v['genre']); // удалим 'genre' из нашего array
}
$total = count($arr1); // сколько всего будет постов
$total_pages = ceil($total / $limit); // всего страниц

function showPosts($arr1, $offset, $limit) // вывод нужного кол-ва постов
{
  $posts = array_splice($arr1, $offset, $limit);
  $i = 0;
  foreach ($posts as $k => $v) {
    if ($i % 2 == 0) {
      echo "<table border='1'><tr><td><b>Title: </b><br>" .  $v['title'] . "</td><br> <td><b>Author: </b><br>" . $v['author'] . "</td><br><td><b>Content: </b><br>" . $v['content'] . "</td></tr></table>";
    } else {
      echo "<table border='1' bgcolor='yellowgreen'><tr><td><b>Title: </b><br>" .  $v['title'] . "</td><br> <td><b>Author: </b><br>" . $v['author'] . "</td><br><td><b>Content: </b><br>" . $v['content'] . "</td></tr></table>";
    }
    $i++;
  }
}

function loopPag()  // вывод пагинации через цикл
{
  global $total_pages;
  for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $_GET['page']) {
      echo "<a class='page-link active disabled' href=?page=$i>$i </a>";
    } else {
      echo "<a class='page-link' href=?page=$i>$i </a>";
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
  <?php showPosts($arr1, $offset, $limit); ?>
  <div class="pagination"> <?php loopPag();  ?> </div>

</body>

</html>