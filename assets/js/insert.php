<?php

//insert.php
$connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');

try {
   $connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');
   $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo 'Соединение установлено';
} catch(PDOException $e) {
   echo 'Ошибка соединения: ' . $e->getMessage();
}

if(isset($_POST['title'])) {
 $query = "
 INSERT INTO `test` 
 (`title`, `description`, `start`, `end`) 
 VALUES (:title, :description, :start, :end)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
    array(
    ':title'  => $_POST['title'],
    ':description' => $_POST['description'],
    ':start' => $_POST['start'],
    ':end' => $_POST['end']
    )
 );
}
?>

