<?php

class CollectionExport extends Collection
{
  function transform_array($arr)
  {
    $result = $arr->getItems();
    return $result;
  }
}
