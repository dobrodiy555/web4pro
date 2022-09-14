<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "posts";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

function countRow($table)
{
  global $conn;
  $sql = "SELECT COUNT(*) as rowCount from test1";
  $res = mysqli_query($conn, $sql);
  $count = mysqli_fetch_assoc($res); // в виде assoc array
  return $count['rowCount'];
}

function selectPostsFromTable($table, $limit, $offset)
{
  global $conn;
  $sql = "SELECT title, author, content from $table LIMIT $limit OFFSET $offset";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      if ($i % 2 == 0) {
        echo "<table border='1'><tr><td><b>Title: </b><br>" . $row['title'] . "</td><br> <td><b>Author: </b><br>" . $row['author'] . "</td><br><td><b>Content: </b><br>" . $row['content'] . "</td></tr></table>";
      } else {
        echo "<table border='1' bgcolor='yellowgreen'><tr><td><b>Title: </b><br>" . $row['title'] . "</td><br> <td><b>Author: </b><br>" . $row['author'] . "</td><br><td><b> Content: </b><br>" . $row['content'] . "</td></tr></table>";
      }
      $i++;
    }
  }
}
