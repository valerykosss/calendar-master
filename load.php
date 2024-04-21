<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');

$data = array();

$query = "SELECT * FROM master_timetable ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'id_master'   => $row["id_master"],
  'start'   => $row["start"],
  'end'   => $row["end"]
 );
}

echo json_encode($data);

?>
