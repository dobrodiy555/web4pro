<?php

class Collection
{
  protected $url = '';
  public function getItems(): array
  {
    $data = file_get_contents($this->url); //преобразуем данные в строку json php
    if (!empty($data)) { // проверка на ошибки
      $arr = json_decode($data, true); // преобразует json строку php в array php
    } else {
      die("Error: no json file!"); // завершить в случае ошибки
    }
    if ($arr === null) {
      die("Error: bad json!");
    }
    return $arr;
  }
}
