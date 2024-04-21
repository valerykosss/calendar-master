<?php

//update.php

try {
    $connect = new PDO('mysql:host=localhost;dbname=lotos', 'root', 'root');
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST["id"])) {
        $query = "UPDATE master_timetable 
                  SET id_master=:id_master, start=:start, end=:end 
                  WHERE id=:id";

        $statement = $connect->prepare($query);
        $result = $statement->execute(
            array(
                ':id_master'  => $_POST['id_master'],
                ':start'      => $_POST['start'],
                ':end'        => $_POST['end'],
                ':id'         => $_POST['id']
            )
        );

        if($result) {
            echo json_encode(['status' => 'success', 'message' => 'Event updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update event']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event ID is missing']);
    }
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

echo $_POST['id_master'];
echo $_POST['start'];
echo $_POST['end'];
echo $_POST['id'];

?>
