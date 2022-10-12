<?php  // выводит резул-т отправки формы 

session_start();

echo '<h2> Dear ' . $_SESSION["name"] . ' ' . $_SESSION["surname"] . ', your account has been created!</h2>';

$_SESSION['registration'] = true;

