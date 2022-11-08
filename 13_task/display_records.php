<?php

function display_records()
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "task13";

  $limit = 30;  // если нужно можно изменить

  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "select p.id as 'Post Id', p.title as Title, p.description as Description, concat(a.first_name, ' ', a.last_name) as 'Author (Full name)', p.created as Date from posts p join authors a on a.id=p.author_id limit $limit";
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
  mysqli_close($conn);
}

display_records();
