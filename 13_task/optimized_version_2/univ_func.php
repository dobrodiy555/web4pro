<?php
require 'display_records.php';
require 'loadmore.php';
require 'find_by_description.php';
require 'find_by_date.php';
require 'find_title_autocomplete.php';
require 'display_after_autocomplete.php';

function universal_function() {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task13";
    $limit = 30;

    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());  // подключаемся

    display_records($conn, $limit);  // сразу при загрузке страницы 30 записей или сколько нужно

    if (isset($_GET['load']) && isset($_GET['page'])) {
        $page = $_GET['page'];
        loadmore($conn, $limit, $page);
    }

    if (isset($_GET['description'])) {
        $description = $_GET['description'];
        find_by_description($conn, $description);
    }

    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        find_by_date($conn, $from_date, $to_date);
    }

    if (isset($_GET['term']) && (!empty($_GET['term']))) {
        $first_letters = $_GET['term'];
        find_title_autocomplete($conn, $first_letters);
    }

    if (isset($_GET['title'])) {
        $title = $_GET['title'];
        display_after_autocomplete($conn, $title);
    }

    mysqli_close($conn);  // закрываем соединение

}

universal_function();
