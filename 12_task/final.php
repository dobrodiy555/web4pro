<?php
$user_input_id = '';
$error = '';
if (isset($_GET['user_input_id'])) {
    if (preg_match("/^\\d+$/" , $_GET['user_input_id'])) {  // проверка чтоб были только числа
        $user_input_id = $_GET['user_input_id'];
    } else {
        $user_input_id = preg_replace( '/[^0-9]/', '', $user_input_id);  // если юзер вводит не цифры, то заменит на пустое
        $error = 'only single numbers allowed!'; // и покажет ошибку
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
 <h1>Apache Module mod_rewrite corrected version</h1>
 <h3>Please enter id for a text in the picture: </h3>
   <form action="" method="get">
      <input type="text" name="user_input_id" placeholder="type here" value="<?= $user_input_id; ?>" required>
       <span style="color:red"><?=$error;?></span>
       <br><br>
      <input type="submit" name="submit" value="Make a picture">
   </form>

    <div style="<?= empty($user_input_id) ? 'display:none' : ''; ?>"> <!-- пока юзер не ввел айдишник не будет это показывать -->
        <h3>Your image:</h3>
        <img src="image-<?= $user_input_id ?>.png"> <!-- передадим в картинку айдишник введенный пользователем с помощью rewrite -->
    </div>

</body>
</html>