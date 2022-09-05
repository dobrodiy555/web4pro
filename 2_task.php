<?php

// Написать функцию сортировки простого численного массива, не используя стандартные функции сортировки.
// В качестве аргументов передавать сам массив и тип сортировки ASC/DESC.

function sorting_array($array, $sorting_type)
{
  for ($x = 0; $x < count($array) - 1; $x++) {
    for ($i = 0; $i < count($array) - $x - 1; $i++) {
      if ($sorting_type == "asc") {
        $y = ($array[$i] > $array[$i + 1]);
      } else if ($sorting_type == "desc") {
        $y = ($array[$i] < $array[$i + 1]);
      }
      if ($y) {
        $tmp_var = $array[$i + 1];
        $array[$i + 1] = $array[$i];
        $array[$i] = $tmp_var;
      }
    }
  }
  return $array;
}

// проверяем работу ф-ции
// $array = [4, 3, 6, 2];
// $sorting_type = "desc";
// sorting_array($array, $sorting_type);
// print_r(sorting_array($array, $sorting_type));


// теперь та же ф-ция но короче, с использованием тернарного оператора
function sorting_array_ternary($array, $sorting_type)
{
  for ($x = 0; $x < count($array) - 1; $x++) {
    for ($i = 0; $i < count($array) - $x - 1; $i++) {
      $y = $sorting_type == 'asc' ? $array[$i] > $array[$i + 1] : $array[$i] < $array[$i + 1];
      if ($y) {
        $tmp_var = $array[$i + 1];
        $array[$i + 1] = $array[$i];
        $array[$i] = $tmp_var;
      }
    }
  }
  return $array;
}

// проверяем работу ф-ции
// $array = [4, 3, 6, 2];
// $sorting_type = "asc";
// sorting_array_ternary($array, $sorting_type);
// print_r(sorting_array_ternary($array, $sorting_type));


// еще один способ
function sort_array_1($array, $t)
{
  $array1 = [];
  foreach ($array as $i) {
    $x = $t == 'asc' ? min($array) : max($array);
    unset($array[array_search($x, $array)]);
    $array1[] = $x;
  }
  return $array1;
}

// // проверяем работу
// $array = [4, 5, 3, 1];
// $t = 'asc';
// print_r(sort_array_1($array, $t));
