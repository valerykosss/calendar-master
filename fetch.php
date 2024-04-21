<?php

//fetch.php

if(isset($_POST["id"]))
{
    $connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');
    
 $query = "SELECT `id`,`id_master`,`start`,`end` from master_timetable WHERE id=:id";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
