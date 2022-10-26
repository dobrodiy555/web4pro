<?php

function create_db_task12() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password); // подключаемся
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "CREATE DATABASE task12";  // создаем базу данных
    if (!mysqli_query($conn, $sql)) {
        die("error: " . mysqli_error($conn));
    }
    mysqli_close($conn); // закрываем подключение
}


function create_table_in_db_task12() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = 'task12';
    $conn = mysqli_connect($servername, $username, $password, $dbname); // подключаемся
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "CREATE TABLE key_and_value (
        id INT PRIMARY KEY,
        value VARCHAR(30)
    )";
    if (!mysqli_query($conn, $sql)) {
        die("error: " . mysqli_error($conn));
    }
    mysqli_close($conn);
}

function fill_table_of_task12_with_data() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = 'task12';
    $conn = mysqli_connect($servername, $username, $password, $dbname); // подключаемся
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // заполним таблицу данными
    $sql = "INSERT INTO key_and_value (id, value)
    VALUES (123, 'Hello Bob'),
       (345, 'Hello Tom'),
       (567, 'Hello Vasya'),
       (789, 'Hello Kostya'),
       (901, 'Hello Misha')";
    if (!mysqli_query($conn, $sql)) {
        die("error: " . mysqli_error($conn));
    }
    mysqli_close($conn);
}

$counter = 0;  // создадим счетчик как глобальную переменную для подсчета вызовов след. ф-ции

function select_value_from_database ($key) {
    global $counter;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = 'task12';
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("connection failed!");
    }
    $sql = "SELECT value FROM key_and_value WHERE id = '$key'";
    $query = mysqli_query($conn, $sql); // выполняет запрос в бд
    if (!$query) {
        die("query failed!");
    }
    $result = mysqli_fetch_assoc($query); // выводит рез-т в виде массива
    $result_string = $result['value'];  // рез-т в виде строки
    $counter++; // при каждом вызове ф-ции счетчик увеличивается на единицу
    return $result_string;
}

