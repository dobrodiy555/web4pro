<?php

function loadmore($conn, $limit, $page)
{
  $offset = $limit * ($page - 1); // считаем начиная с какой записи нужно показать, по аналогу с пагинацией
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


