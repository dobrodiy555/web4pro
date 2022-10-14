<?php
session_start();

echo "<h3 style='color:red'>Please try again later!</h3>";
$cookie_name = 'user';
$cookie_value = 'bla';
setcookie($cookie_name, $cookie_value, time() + 20, '/'); // устанавливаем куки на 20 секунд
if (!isset($_COOKIE[$cookie_name])) {  // когда куки пропадут, при обновлении перейдет на главную страницу с формой
    header('Location: index4.php');
    $_SESSION['counter'] = 0;  // счетчик обнуляем чтоб снова можно было три раза нажать на кнопку
}