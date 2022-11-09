<?php

function find_title_autocomplete($first_letters) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task13";
    $data = array();

    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
    $sql = "select title from posts where title like '$first_letters%'";
    $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row['title'];
        }
    }
    echo json_encode($data);
    mysqli_close($conn);
}

if (isset($_GET['term']) && (!empty($_GET['term']))) {
    $first_letters = $_GET['term']; // параметр get term передает автокомплит виджет
    find_title_autocomplete($first_letters);
}
