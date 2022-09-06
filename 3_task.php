<!-- // Реализовать форму Time Ago. Форма будет содержать поле ввода даты и кнопку ‘Calculate’.
// При клике на кнопку, будет рассчитываться сколько лет, дней, часов, минут прошло от введенного времени, до текущего.
// Например, пользователь вводит дату, 12/12/2021 15:17 и нажимает кнопку. 
// В результате, под формой должна появится информация:
// Years ago: 0
// Days ago: 48
// Hours ago: 1152
// Minutes ago: 69120 -->


<h2>Time ago form</h2>
<form action="" method="post">
  <!-- execute on this page -->
  Enter your date: <input type="datetime-local" name="userdate" value="<?php echo $_POST['userdate'] ?? ''; ?>"><br><br>
  <!--сохранит дату после нажатия кнопки -->
  <input type="submit" value="Calculate">
</form>

<?php

if (isset($_POST['userdate'])) { // check if form was submitted
  $userdate = $_POST['userdate'];
  $now = time();
  $user_time_unix = strtotime($userdate);
  if ($user_time_unix > $now) { // check that date entered by user is smaller than today's date
    echo "<span>Error: your date is bigger than now!</span>";
  } else {
    $datediff = abs($now - $user_time_unix);
    echo "<span>Years ago: </span>";
    echo floor($datediff / (365 * 60 * 60 * 24));
    echo "<br>";
    echo "<span>Days ago: </span>";
    echo round($datediff / (60 * 60 * 24));
    echo "<br>";
    echo "<span> Hours ago: </span>";
    echo round($datediff / (60 * 60));
    echo "<br>";
    echo "<span>Minutes ago: </span>";
    echo round($datediff / 60);
    echo "<br>";
  }
}
?>
