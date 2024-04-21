<?php

// Подключение к базе данных
$connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');

// Получение id_master из POST-запроса
$id_master = $_POST['id_master'];

// Запрос к базе данных для получения master_name
$query = "SELECT master_name FROM master WHERE id_master = :id";
$statement = $connect->prepare($query);
$statement->execute(['id' => $id_master]);

// Получение результата
$result = $statement->fetch(PDO::FETCH_ASSOC);

// Возвращение результата в JSON-формате
echo json_encode($result);

?>
