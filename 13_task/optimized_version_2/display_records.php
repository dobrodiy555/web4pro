<?php

function display_records($conn, $limit)
{
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
}


