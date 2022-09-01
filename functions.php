<?php
  function get_user_meta( $id, $key ){
   return get_metadata('user', $user_id, $key, $single);
  }
?>
