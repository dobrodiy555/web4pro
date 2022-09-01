<?php
  function get_profile( $id ){
   $profile = get_user_by( ‘id’, $id );
   return  $profile;
  }
?>
