<?php

class CollectionExport
{
  function transform_array(Collection $arr)
  {
    return $arr->getItems();
  }
}
