<?php

$servername = "localhost";
$username = "root";
$password = "";

function check_connection($conn) // ф-ция проверки соединения
{
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        echo "Connection established!<br><br>";
    }
}

function check_success_of_query($conn, $sql) // ф-ция проверки успешности sql запроса
{
    if (mysqli_query($conn, $sql)) {
        echo "Query " . $sql. " is successfull!<br><br>";
    } else {
        echo "error: " . mysqli_error($conn);
    }
}

function show_result_of_select_query_on_dates($conn, $sql) { // ф-ция отображения рез-та запросов select с датами
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "book title: " . $row["title"] . "; user surname: " . $row["surname"] . "; user name: " . $row["name"] . "<br>";
        }
    } else {
        echo "0 results<br>";
    }
}

$conn = mysqli_connect($servername, $username, $password); // подключаемся
check_connection($conn); // проверяем подключение
$sql = "CREATE DATABASE library";  // создаем базу данных
check_success_of_query($conn, $sql); // проверяем успешность sql запроса
mysqli_close($conn); // закрываем подключение

$dbname = 'library'; // теперь есть новый параметр для подключения
$conn1 = mysqli_connect($servername, $username, $password, $dbname);  // поэтому подключимся заново
check_connection($conn1);
// создадим нужные таблицы
$sql1 = "CREATE TABLE book (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL
)";
check_success_of_query($conn1, $sql1);

$sql2 = "CREATE TABLE author (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    surname VARCHAR(30) NOT NULL                   
)";
check_success_of_query($conn1, $sql2);

$sql3 = "CREATE TABLE book_author (
    book_id INT UNSIGNED NOT NULL,
    author_id INT UNSIGNED NOT NULL,
    CONSTRAINT FKtoBook FOREIGN KEY (book_id) REFERENCES book(id) on DELETE CASCADE,
    CONSTRAINT FKtoAuthor FOREIGN KEY (author_id) REFERENCES author(id) on DELETE CASCADE 
)";
check_success_of_query($conn1, $sql3);

$sql4 = "CREATE TABLE user (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    surname VARCHAR(30) NOT NULL
)";
check_success_of_query($conn1, $sql4);

$sql5 = "CREATE TABLE taken_book (
    book_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    take_date date NOT NULL,
    return_date date,
    CONSTRAINT FK_TakenBook FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE ,
    CONSTRAINT FK_User FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE 
)";
check_success_of_query($conn1, $sql5);

// теперь заполним таблицы данными
$sql6 = "INSERT INTO book (id, title)
VALUES (1, 'Harry Potter Part 1'),
       (2, 'Lord of the rings'),
       (3, 'Alice in Wonderland'),
       (4, 'Sherlock Holmes'),
       (5, '1984'),
       (6, 'Harry Potter Part 2'),
       (7, 'PHP for kids')";
check_success_of_query($conn1, $sql6);

$sql7 = "INSERT INTO author (id, name, surname)
VALUES (1, 'Joanne', 'Rowling'),
       (2, 'John', 'Tolkien'),
       (3, 'Lewis', 'Carroll'),
       (4, 'Arthur', 'Conan Doyle'),
       (5, 'George', 'Orwell'),
       (6, 'Andrei', 'Miheev'),
       (7, 'Anton', 'Petrov'),
       (8, 'Mark', 'Zuckerberg')";
check_success_of_query($conn1, $sql7);

$sql8 = "INSERT INTO book_author (book_id, author_id)
VALUES (1, 1),
       (2, 2),
       (3, 3),
       (4, 4),
       (5, 5),
       (6, 1),
       (7, 6),
       (7, 7),
       (7, 8)";
check_success_of_query($conn1, $sql8);

$sql9 = "INSERT INTO user (id, name, surname)
VALUES (1, 'Andrei', 'Mihailov'),
       (2, 'Vasiliy', 'Odintsov'),
       (3, 'Petro', 'Petrenko'),
       (4, 'Olga', 'Shevchenko'),
       (5, 'Stepan', 'Boyko')";
check_success_of_query($conn1, $sql9);

$sql10 = "INSERT INTO taken_book (book_id, user_id, take_date, return_date)
VALUES  (4, 2, '2021-10-05', '2021-10-14'),
        (3, 1, '2021-10-19', '2021-10-22'),
        (5, 5, '2022-03-10', '2022-03-16'),
        (1, 3, '2022-09-15', '2022-09-20'),
        (7, 3, '2022-10-10', null),
        (6, 4, '2022-10-12', null),
        (4, 1, '2022-10-18', null),
        (3, 1, '2022-10-18', null)";
// три юзера должны четыре книги. из них двое просрочили срок (взяли по одной книге), один не просрочил (взял две книги)
check_success_of_query($conn1, $sql10);

// теперь пишем запросы указанные в задании
// допустим мы хотим изменить автора 2 части Гарри Поттера из Дж Роулинг на А. Михеев
$sql11 = "UPDATE book_author SET author_id = (SELECT id FROM author WHERE surname = 'Miheev')
WHERE book_id = (SELECT id FROM book WHERE title = 'Harry Potter Part 2')";
check_success_of_query($conn1, $sql11);

// найти книги с тремя соавторами
$sql12 = "SELECT b.title, count(ba.author_id) количество_авторов FROM book_author ba 
JOIN book b ON b.id=ba.book_id
JOIN author a ON ba.author_id = a.id
GROUP BY ba.book_id
HAVING count(ba.author_id) = 3";
$result12 = mysqli_query($conn1, $sql12);
if (mysqli_num_rows($result12) > 0) {
    while($row = mysqli_fetch_assoc($result12)) {
        echo "book title: " . $row["title"] . "; количество авторов: " . $row["количество_авторов"] . "<br>";
    }
} else {
    echo "0 results<br>";
}
check_success_of_query($conn1, $sql12);

//удаление книги определенного автора, допустим хотим удалить книгу Толкиена
$sql13 = "DELETE FROM book WHERE id = (SELECT book_id FROM book_author WHERE author_id =
(SELECT id FROM author WHERE surname = 'Tolkien'))";
check_success_of_query($conn1, $sql13);

// найти книги которые на руках и кто их взял
$sql14 = "SELECT b.title, u.surname, u.name FROM book b JOIN taken_book tb on b.id=tb.book_id
JOIN user u ON u.id=tb.user_id WHERE tb.return_date IS NULL";
show_result_of_select_query_on_dates($conn1, $sql14); // вызываем ф-цию отображения рез-тов
check_success_of_query($conn1, $sql14);

// найти книги у которых истек срок пребывания на руках (больше 7 дней) и у кого они
$sql15 = "SELECT b.title, u.surname, u.name FROM book b JOIN taken_book tb ON b.id=tb.book_id 
JOIN user u ON u.id=tb.user_id where (curdate() - tb.take_date) > 7 AND return_date IS NULL";
show_result_of_select_query_on_dates($conn1, $sql15);
check_success_of_query($conn1, $sql15);

mysqli_close($conn1);

