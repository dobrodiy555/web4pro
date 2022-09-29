<?php

class JsonCollectionExport extends CollectionExport
{

  public function transform_into_json(Collection $arr)
  {
    return json_encode(parent::transform_array($arr));
  }
}
