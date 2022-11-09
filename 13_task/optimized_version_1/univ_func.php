<?php

//универсальную какую-то функцию сделать, которая будет подключаться, выполнять запрос, возвращать данные и закрывать подключение?..

function universal_function() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task13";
    $limit = 30;

    // отображаем первые 30 записей
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
    $sql = "select p.id as 'Post Id', p.title as Title, p.description as Description, concat(a.first_name, ' ', a.last_name) as 'Author (Full name)', p.created as Date from posts p left join authors a on a.id=p.author_id limit $limit";
    $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr class="from_display">
          <td>' . $row["Post Id"] . '</td>
          <td>' . $row["Title"] . '</td>
          <td>' . $row["Description"] . '</td>
          <td>' . $row["Author (Full name)"] . '</td>
          <td>' . $row["Date"] . '</td>
        </tr>';
        }
    } else {
        echo "0 results<br>";
    }

    // для кнопки loadmore
    if (isset($_GET['load']) && isset($_GET['page'])) {
        $page = $_GET['page'];
        $offset = $limit * ($page - 1); // считаем с какой записи нужно показать, по аналогу с пагинацией
        $sql = "select p.id as 'Post Id', p.title as Title, p.description as Description, concat(a.first_name, ' ', a.last_name) as 'Author (Full name)', p.created as Date from posts p left join authors a on a.id=p.author_id limit $limit offset $offset";
        $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr class="from_loadmore">
            <td>' . $row["Post Id"] . '</td>
            <td>' . $row["Title"] . '</td>
            <td>' . $row["Description"] . '</td>
            <td>' . $row["Author (Full name)"] . '</td>
            <td>' . $row["Date"] . '</td>
          </tr>';
            }
        } else {
            echo "0 results<br>";
        }
    }

    // поиск по description
    if (isset($_GET['description'])) {
        $description = $_GET['description'];
        $sql = "select p.id as 'Post Id', p.title as Title, p.description as Description, concat(a.first_name, ' ', a.last_name) as 'Author (Full name)', p.created as Date from posts p left join authors a on a.id=p.author_id where p.description like '%$description%'";
        $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr class="from_description">
              <td>' . $row["Post Id"] . '</td>
              <td>' . $row["Title"] . '</td>
              <td>' . $row["Description"] . '</td>
              <td>' . $row["Author (Full name)"] . '</td>
              <td>' . $row["Date"] . '</td>
            </tr>';
            }
        } else {
            echo "0 results<br>";
        }
    }

    // поиск по дате
    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        $sql = "select p.id as 'Post Id', p.title as Title, p.description as Description, concat(a.first_name, ' ', a.last_name) as 'Author (Full name)', p.created as Date from posts p left join authors a on a.id=p.author_id where p.created between '$from_date' and '$to_date'";
        $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr class="from_date">
              <td>' . $row["Post Id"] . '</td>
              <td>' . $row["Title"] . '</td>
              <td>' . $row["Description"] . '</td>
              <td>' . $row["Author (Full name)"] . '</td>
              <td>' . $row["Date"] . '</td>
            </tr>';
            }
        } else {
            echo "0 results<br>";
        }
    }

    // поиск title для autocomplete
    if (isset($_GET['term']) && (!empty($_GET['term']))) {
        $first_letters = $_GET['term']; // параметр get term передает автокомплит виджет
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

    // поиск записей после выбора title в autocomplete
    if (isset($_GET['title'])) {
        $title = $_GET['title'];
        $sql = "select p.id as 'Post Id', p.title as Title, p.description as Description, concat(a.first_name, ' ', a.last_name) as 'Author (Full name)', p.created as Date from posts p join authors a on a.id=p.author_id where p.title = '$title'";
        $result = mysqli_query($conn, $sql) or die("error: " . mysqli_error($conn));
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr class="from_autocomplete">
          <td>' . $row["Post Id"] . '</td>
          <td>' . $row["Title"] . '</td>
          <td>' . $row["Description"] . '</td>
          <td>' . $row["Author (Full name)"] . '</td>
          <td>' . $row["Date"] . '</td>
        </tr>';
            }
        } else {
            echo "0 results<br>";
        }
    }

   mysqli_close($conn);
}

universal_function();