<?php

// Написать функцию сортировки простого численного массива, не используя стандартные функции сортировки.
// В качестве аргументов передавать сам массив и тип сортировки ASC/DESC.

function sorting_array($array, $sorting_type)
{
  if ($sorting_type == 0) {
    for ($x = 0; $x < count($array) - 1; $x++) {
      for ($i = 0; $i < count($array) - $x - 1; $i++) {
        if ($array[$i] > $array[$i + 1]) {
          $tmp_var = $array[$i + 1];
          $array[$i + 1] = $array[$i];
          $array[$i] = $tmp_var;
        }
      }
    }
    print_r($array);
  } elseif ($sorting_type == 1) {
    for ($x = 0; $x < count($array) - 1; $x++) {
      for ($i = 0; $i < count($array) - $x - 1; $i++) {
        if ($array[$i] < $array[$i + 1]) {
          $tmp_var = $array[$i + 1];
          $array[$i + 1] = $array[$i];
          $array[$i] = $tmp_var;
        }
      }
    }
    print_r($array);
  } else {
    echo ("You didn't enter valid number!");
  }
}

// спрашиваем у пользователя значения массива через пробел и метод сортировки 

$array = explode(' ', readline("Enter array values through spaces and hit Enter: "));
$sorting_type = readline("Choose sorting type: enter '0' for ascending, '1' for descending: ");
sorting_array($array, $sorting_type);
