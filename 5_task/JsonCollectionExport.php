<?php

class JsonCollectionExport extends CollectionExport
{

  public function transform_into_json($result)
  {
    $result = json_encode($result);
    return $result;
  }
}
