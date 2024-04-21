<?php

//update.php

$connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE test
 SET `title`=:title,`description`=:description,`start`=:start,`end`=:end
 WHERE `id`=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
    array(
        ':title'  => $_POST['title'],
        ':description' => $_POST['description'],
        ':start' => $_POST['start'],
        ':end' => $_POST['end'],
        ':id' => $_POST['id']
       )
 );
}

?>
