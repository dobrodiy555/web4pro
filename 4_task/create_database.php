<?php

require __DIR__ . '/extract_json.php';

// создадим базу данных posts
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE posts";
if (mysqli_query($conn, $sql)) {
  echo "database created successfully!";
} else {
  echo "error: " . mysqli_error($conn);
}

mysqli_close($conn);


// теперь создадим таблицу test1 в базе данных posts
$dbname = "posts";

// Create connection
$conn1 = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn1) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE TABLE test1 (
status VARCHAR(30), 
code INT,
total INT, 
title VARCHAR(30),
author VARCHAR(30), 
genre VARCHAR(30),
content VARCHAR(255)
)";
if (mysqli_query($conn1, $sql)) {
  echo "table posts1 created successfully!";
} else {
  echo "error: " . mysqli_error($conn1);
}

mysqli_close($conn1);

// теперь добавим данные в табл test1

$conn2 = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn2) {
  die("Connection failed: " . mysqli_connect_error());
}

// экранируем кавычки и другие символы
$status = mysqli_real_escape_string($conn2, $status);
$code = mysqli_real_escape_string($conn2, $code);
$total = mysqli_real_escape_string($conn2, $total);
$title = mysqli_real_escape_string($conn2, $title);
$author = mysqli_real_escape_string($conn2, $author);
$genre = mysqli_real_escape_string($conn2, $genre);
$content = mysqli_real_escape_string($conn2, $content);

$sql = "INSERT INTO test1 (status, code, total, title, author, genre, content) VALUES ('$status', '$code', '$total', '$title', '$author', '$genre', '$content')";

if (!mysqli_query($conn2, $sql)) {
  die("error!" . $sql . "<br>" . mysqli_error($conn2));
}

mysqli_close($conn2);
