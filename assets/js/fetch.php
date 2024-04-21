<?php

//fetch.php

if(isset($_POST["id"]))
{
    $connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');
    
 $query = "SELECT `id`,`title`,`description`,`start`,`end` from test WHERE id=:id";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
