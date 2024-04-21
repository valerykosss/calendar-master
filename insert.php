<?php

//insert.php

$connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');

 $query = "
 INSERT INTO master_timetable 
 (id_master, start, end) 
 VALUES (:id_master, :start, :end)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id_master'  => $_POST['id_master'],
   ':start' => $_POST['start'],
   ':end' => $_POST['end']
  )
 );

 echo $_POST['id_master'];
 echo $_POST['start'];
 echo $_POST['end'];


?>
