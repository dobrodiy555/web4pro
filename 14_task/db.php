<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = 'task14';

function create_db ($servername, $username, $password, $dbname)
{
    $conn = mysqli_connect($servername, $username, $password) or die("Connection failed: " . mysqli_connect_error());
    $sql = "CREATE DATABASE $dbname";
    $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
    mysqli_close($conn);
}

function create_table ($servername, $username, $password, $dbname)
{
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
    $sql = "CREATE TABLE `user` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `photo` LONGBLOB,
    `name` VARCHAR(50),
    `surname` VARCHAR(50),
    `email` VARCHAR(50),
    `birthday` DATE,
    PRIMARY KEY (`id`)
)";
    $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
    mysqli_close($conn);
}

// inserting data if validation passed
function insert_data ($servername, $username, $password, $dbname, $photo, $name, $surname, $email, $birthday)
{
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
    $sql = "INSERT INTO `user` (`photo`, `name`, `surname`, `email`, `birthday`)
                        VALUES ('$photo', '$name', '$surname', '$email', '$birthday')";
    $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
    mysqli_close($conn);
}

