<?php

class CsvCollectionExport extends CollectionExport
{
  public function implode_into_csv($arr)
  {
    $out = "";
    $header = false;
    foreach ($arr as $arrays) {
      if (!$header) {
        $out .= implode(",", array_keys($arrays)) . "<br>"; // выводим заголовки
        $header = true;
      }
      $out .= implode(",", $arrays) . "<br>";
    }
    return $out;
  }

  public function transform_array($arr)
  {
    return $this->implode_into_csv(parent::transform_array($arr));
  }
}
