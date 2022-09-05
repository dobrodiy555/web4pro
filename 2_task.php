<?php

// Написать функцию сортировки простого численного массива, не используя стандартные функции сортировки.
// В качестве аргументов передавать сам массив и тип сортировки ASC/DESC.

function sorting_array($array, $sorting_type)
{
  $array = explode(' ', readline("Enter array values through spaces and hit Enter: "));
  $sorting_type = readline("Choose sorting type: enter 'asc' for ascending, 'desc' for descending: ");
  for ($x = 0; $x < count($array) - 1; $x++) {
    for ($i = 0; $i < count($array) - $x - 1; $i++) {
      if ($sorting_type == 'asc') {
        if ($array[$i] > $array[$i + 1]) {
          $tmp_var = $array[$i + 1];
          $array[$i + 1] = $array[$i];
          $array[$i] = $tmp_var;
        }
      } elseif ($sorting_type == 'desc') {
        if ($array[$i] < $array[$i + 1]) {
          $tmp_var = $array[$i + 1];
          $array[$i + 1] = $array[$i];
          $array[$i] = $tmp_var;
        }
      } else {
        break;
      }
    }
  }
  return $array;
}
