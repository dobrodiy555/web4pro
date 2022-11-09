<?php

function find_title_autocomplete($conn, $first_letters) {

    $data = array();
    $sql = "select title from posts where title like '$first_letters%'";
    $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row['title'];
        }
    }
    echo json_encode($data);
}

