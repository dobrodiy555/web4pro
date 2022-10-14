<?php

session_start();

ini_set('log_errors', 'On');
ini_set('error_log', 'D:\xampp\htdocs\web4pro_project\registration_form\logs\errors-log'); // Записываем логи с ошибками в файл

if (!isset($_SESSION['counter'])) {  // вводим переменную сессии для подсчета нажатий кнопки submit
    $_SESSION['counter'] = 0;
}

if (@$_SESSION['registration'] == true) { // в случае уже успешной регистрации будет отображаться это, @ чтоб не ругался в первый раз
    die("<h2>Registration already completed!</h2>");
}

$_SESSION['registration'] = false;
$name_validation = $surname_validation = $email_validation = $password_validation = $confirm_password_validation = $validation = false;
$name = $surname = $email = $password = $confirmPassword = '';
$peopleCollection = array(
    array('id' => 1, 'name' => 'Andrei', 'surname' => 'Miheev', 'email' => 'andmiheev@ukr.net'),
    array('id' => 2, 'name' => 'Ivan', 'surname' => 'Ivanov', 'email' => 'ivanivan@gmail.com'),
    array('id' => 3, 'name' => 'Stepan', 'surname' => 'Stepanov', 'email' => 'stepstep@gmail.com'),
    array('id' => 4, 'name' => 'Petr', 'surname' => 'Petrov', 'email' => 'petrpetr@gmail.com'),
    array('id' => 5, 'name' => 'Dasha', 'surname' => 'Shevchenko', 'email' => 'dashashev@gmail.com')
);

if (isset($_POST['submit'])) { // при нажатии на кнопку submit
    ++$_SESSION['counter']; // включается счетчик

    if (empty($_POST["name"])) {
        echo "<h3>Name is required!</h3>";
        error_log("User left name field blank\n", 3, "logs/errors-log");
    } else {
        $name = test_input($_POST["name"]);  // убирает лишние символы в целях безопасности
        if (!preg_match("/^[А-Яа-яёїa-zA-Z-' ]*$/u", $name)) { // check if name only contains latin/cyrillic letters and whitespace
            echo "<h3>Only latin or cyrillic letters and whitespace in name are allowed</h3>";
            error_log("User didn't use latin or cyrillic letters and whitespace for name\n", 3, "logs/errors-log");  // записать об отдельной ошибке в нужный файл
        } else {
            $name_validation = true;
        }
    }

    if (empty($_POST["surname"])) {
        echo "<h3>Surname is required!</h3>";
        error_log("User left surname field blank\n", 3, "logs/errors-log");
    } else {
        $surname = test_input($_POST["surname"]);
        // check if name only contains latin/cyrillic letters and whitespace
        if (!preg_match("/^[А-Яа-яёїa-zA-Z-' ]*$/u", $surname)) {
            echo "<h3>Only latin or cyrillic letters and white space in surname are allowed!</h3>";
            error_log("User didn't use latin or cyrillic letters and whitespace for surname\n", 3, "logs/errors-log");
        } else {
            $surname_validation = true;
        }
    }

    if (empty($_POST["email"])) {
        echo "<h3>Email is required!</h3>";
        error_log("User left email field blank\n", 3, "logs/errors-log");
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<h3>Invalid email format!</h3>";
            error_log("User typed invalid email format\n", 3, "logs/errors-log");
        } else if (in_array_r($email, $peopleCollection)) { // проверяем есть ли такой email в массиве
            echo "<h3>Such email is already registered!</h3>";
            error_log("User typed already registered email\n");
        } else {
            $email_validation = true;
        }
    }

    if (empty($_POST["password"])) {
        echo "<h3>Password is required!</h3>";
        error_log("User left password field blank\n", 3, "logs/errors-log");
    } else {
        $password = test_input($_POST["password"]);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        // check if password contains right symbols
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            echo '<h3>Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, one number, and one special character!</h3>';
            error_log("User typed invalid format of password\n", 3, "logs/errors-log");
        } else {
            $password_validation = true;
        }
    }

    if (empty($_POST["confirmPassword"])) {
        echo "<h3>You must confirm your password!</h3>";
        error_log("User left confirmation password field blank\n", 3, "logs/errors-log");
    } else {
        $confirmPassword = test_input($_POST["confirmPassword"]);
        if ($confirmPassword != $password) {
            echo "<h3>Confirmation password field doesn't match your password field!</h3>";
            error_log("User typed wrong password in Confirm password field\n", 3, "logs/errors-log");
        } else {
            $confirm_password_validation = true;
        }
    }

    if ($name_validation && $surname_validation && $email_validation && $password_validation && $confirm_password_validation) {
        $validation = true;
        $_SESSION["name"] = $name;
        $_SESSION["surname"] = $surname;
        header('Location: message.php');
    }
}

 if ($_SESSION['counter'] >= 3 && (!$validation)) {  // обязательно указать && !validation, иначе при трех нажатиях кнопки будет переходить на страницу ошибки независимо от результата проверки
     $cookie_name = 'user';
     $cookie_value = 'bla';
     setcookie($cookie_name, $cookie_value, time() + 3600, '/'); // установили cookie на час
     header('Location: error_message.php');
 }

function test_input($data)  // убрать лишние символы, пробелы итп.
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function in_array_r($needle, $haystack, $strict = false)
{ // ф-ция для поиска в многоуровневом массиве
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
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
        .asterix {
            color: red;
        }
        h3 {
            color: red;
        }
    </style>
</head>

<body>
<div class="registration_form">
    <h1>Registration form</h1>
    <p><span class="asterix">* required field</span></p>
    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <input type="text" name="name" value="<?= $name; ?>">
        <span class="asterix">*</span>
        <br><br>
        Surname: <input type="text" name="surname" value="<?= $surname; ?>">
        <span class="asterix">*</span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?= $email; ?>">
        <span class="asterix">*</span>
        <br><br>
        Password: <input type="password" name="password" value="<?= $password; ?>">
        <span class="asterix">*</span>
        <br><br>
        Confirm password: <input type="password" name="confirmPassword" value="<?= $confirmPassword; ?>">
        <span class="asterix">*</span>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

</body>
</html>