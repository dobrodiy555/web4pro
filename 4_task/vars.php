<?php

require __DIR__ . '/funcs1.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5;
$offset = $limit * ($page - 1);
$total = countRow('test1'); // ф-ция подсчета кол-ва постов в базе данных
$total_pages = ceil($total / $limit); // всего страниц
$posts = selectPostsFromTable('test1', $limit, $offset); // ф-ция вывода постов на страницу
