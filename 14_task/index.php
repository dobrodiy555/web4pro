<?php
require_once 'vendor/autoload.php'; // чтобы видело все загруженные через composer библиотеки
require_once 'db.php'; // ф-ции бд
use Imagecow\image; // подключим пространство имен биб-к
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

$photo_err = $name_err = $surname_err = $email_err = $birthday_err = '';
$photo = $name = $surname = $email = $birthday = '';
$photo_valid = $name_valid = $surname_valid = $email_valid = $birthday_valid = $all_valid = false;
$today = new DateTime();
$today_date = $today->format('Y-m-d');
$min_date = $today->modify('-18 years');
$min_date = $min_date->format('Y-m-d'); // потому что POST сохраняет в таком формате

if (isset($_POST['save'])) { // при нажатии кнопки Save

  // photo validation
  if (!file_exists($_FILES['photo']['tmp_name'])) {
    $photo_err = 'You need to upload a photo!';
  } else {
    $photo_info = getimagesize($_FILES['photo']['tmp_name']);
    $width = $photo_info[0];
    $height = $photo_info[1];
    $allowed_extensions = ['png', 'jpg'];
    $photo_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    if (!in_array($photo_extension, $allowed_extensions)) {
      $photo_err = 'Only PNG and JPG formats are allowed!';
    } else if (($_FILES['photo']['size'] > 1000000)) { // если больше 1 мб
      $photo_err = 'Photo size exceeds 1MB!';
    } else {
      $target_file = 'images/' . basename($_FILES['photo']['name']);
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $image = Image::fromFile($target_file);
        if ($image->getWidth() > 300 || $image->getHeight() > 300) {
            $image->resizeCrop(300, 300);
            $image->save('images/resized_cropped_user_photo.png'); // сохраняю чтоб вывести внизу и для передачи в бд
            $photo = addslashes(file_get_contents('images/resized_cropped_user_photo.png')); // считываем сохраненный обрезанный файл для передачи в бд
            $photo_valid = true;
        } else {
            $photo_err = 'Error occurred while resizing the photo';
        }
      } else {
        $photo_err = 'Problem in uploading image file.';
      }
    }
  }

  // text data validation
  if (empty($_POST['name'])) {
    $name_err = 'Name is required!';
  } else {
    $name = test_input($_POST['name']);
    if (!preg_match("/^[А-Яа-яёїa-zA-Z-' ]*$/u", $name)) {
      $name_err = 'Only latin or cyrillic letters and whitespace are allowed!';
    } else {
      $name_valid = true;
    }
  }

  if (empty($_POST['surname'])) {
    $surname_err = 'Surname is required!';
  } else {
    $surname = test_input($_POST['surname']);
    if (!preg_match("/^[А-Яа-яёїa-zA-Z-' ]*$/u", $surname)) {
      $surname_err = 'Only latin or cyrillic letters and whitespace are allowed!';
    } else {
      $surname_valid = true;
    }
  }

  if (empty($_POST["email"])) {
    $email_err = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    } else {
      $email_valid = true;
    }
  }

  if (empty($_POST["birthday"])) {
    $birthday_err = "Birthday is required";
  } else {
    $birthday = test_input($_POST["birthday"]);  // почему то он нужен
    if ($birthday > $min_date) {
      $birthday_err = "You must be at least 18 years old!";
    } else {
      $birthday_valid = true;
    }
  }

  // если всё введено правильно
  if ($photo_valid && $name_valid && $surname_valid && $email_valid && $birthday_valid) {
    $all_valid = true;
    // save data in database
    insert_data($servername, $username, $password, $dbname, $photo, $name, $surname, $email, $birthday);
    // send email to new user
    $mail = new PHPMailer(true); // true enables exceptions
      try {
          $mail->SMTPDebug = 0; // чтоб не показывало ход отправки письма
          $mail->CharSet = 'UTF-8'; // чтоб адекватно передавались кирилл символы
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'andmih666@gmail.com';
          $mail->Password = 'yfxaotnzyjhxaqzb'; // одноразовый пароль для приложений google
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;
          $mail->setFrom("andmih666@gmail.com", 'Facebook');
          $mail->addAddress($email);
          $mail->addAttachment('images/resized_cropped_user_photo.png');
          $mail->isHTML(true);
          $mail->Subject = 'Successful form submission';
          $mail->Body = " <h1> Thank you for registering in our resourse! </h1>
            <h3> Your data: </h3>
            <p><b>Name:</b> $name </p>
            <p><b>Surname:</b> $surname </p>
            <p><b>Email:</b> $email </p>
            <p><b>Birthday:</b> $birthday </p> ";
          $mail->send();
      } catch(Exception $e) {
          echo "error: " . $mail->ErrorInfo;
      }
  }

}

function test_input($data)  // убрать лишние символы, пробелы итп.
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST['export']) ) { // при нажатии кнопки Export as pdf
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    //  создаем pdf файл
    $dompdf = new Dompdf(["chroot" => __DIR__]); // to display image correctly
    $html = "<img src='images/resized_cropped_user_photo.png' style='float:right'>";
    $html .= "<h1>Your data: </h1>";
    $html .= "<p><b>Name:</b> $name </p>";
    $html .= "<p><b>Surname:</b> $surname </p>";
    $html .= "<p><b>Email:</b> $email </p>";
    $html .= "<p><b>Birthday:</b> $birthday </p>";
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream('yourData.pdf'); // to download pdf
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .error {
      color: red;
    }
  </style>
</head>

<body>
  <h1>My Account</h1>
  <h3>Registration form</h3>
  <p><span class="error">* required field</span></p>
  <form action='' method='post' enctype="multipart/form-data">
    <!-- multipart/form-data нужно обязательно когда отправляем файл -->
    Photo: <input type="file" name="photo">
    <span class="error">* <?= $photo_err; ?></span>
    <br><br>
    Name: <input name="name" type="text" value="<?= $name; ?>">
    <span class="error">* <?= $name_err; ?></span>
    <br><br>
    Surname: <input name="surname" type="text" value="<?= $surname; ?>">
    <span class="error">* <?= $surname_err; ?></span>
    <br><br>
    Email: <input name="email" type="text" value="<?= $email; ?>">
    <span class="error">* <?= $email_err; ?></span>
    <br><br>
    Birthday: <input name="birthday" min='1900-01-01' max='<?= $today_date; ?>' type="date" value="<?= $birthday; ?>">
    <span class=" error">* <?= $birthday_err; ?></span>
    <br><br>
    <input type="submit" name="save" value="Save">
    <input type="submit" name="export" value="Export as PDF" <?php if(!$all_valid) { ?> disabled <?php } ?> >
  </form>

  <?php
  // выводит данные формы тут же на странице если всё прошло валидацию
  if ($all_valid) {
    echo "<h2>Your data was successfully saved:</h2>";
    echo '<img src="images/resized_cropped_user_photo.png" width="80px" height="80px">';
    echo "<br>";
    echo $name;
    echo "<br>";
    echo $surname;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $birthday;
    echo "<br>";
  }
  ?>

</body>
</html>