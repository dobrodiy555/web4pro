<?php

class JsonCollectionExport extends CollectionExport
{

  public function transform_array($arr)
  {
    return json_encode(parent::transform_array($arr));
  }
}
