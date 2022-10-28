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
        value VARCHAR(30),
        views INT NOT NULL 
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
    $sql = "INSERT INTO key_and_value (id, value, views)
    VALUES (123, 'Hello Bob', 0),
       (345, 'Hello Tom', 0),
       (567, 'Hello Vasya', 0),
       (789, 'Hello Kostya', 0),
       (901, 'Hello Misha', 0)";
    if (!mysqli_query($conn, $sql)) {
        die("error: " . mysqli_error($conn));
    }
    mysqli_close($conn);
}

function select_value_from_database_and_count ($key) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = 'task12';
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("connection failed!");
    }
    $sql = "SELECT value FROM key_and_value WHERE id = $key";
    $sql1 = "UPDATE key_and_value SET views = views + 1 WHERE id = $key";
    $query = mysqli_query($conn, $sql); // вытащит значение по ключу из бд
    $query1 = mysqli_query($conn, $sql1); // увеличит views на единицу
    if (!$query){
        die("query " . $query . " failed!");
    }
    if (!$query1) {
        die("query " . $query1 . " failed!");
    }
    $result = mysqli_fetch_assoc($query); // выводит рез-т в виде массива
    $result_string = $result['value'] ?? null; // верни значение или если такого ключа нет то null
    return $result_string;
}


