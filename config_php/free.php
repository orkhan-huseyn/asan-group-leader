<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        //ok
        require_once 'dbconfig.php';
        $connection= Database::connect();
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $shift = intVal($_GET['list']);
            $id = intVal($_GET['id']);
            $fullname = $_GET['vol'];
            
            $getLast = $connection->prepare("SELECT volunteer_id, department FROM appointments WHERE volunteer=?");
            $getLast->bind_param("s", $fullname);
            $getLast->execute();
            $getRes = $getLast->get_result();
            $deptrow = $getRes->fetch_array();
            
            $sql = $connection->prepare("DELETE FROM appointments WHERE id=?");
            $sql->bind_param("s", $id);
            $update = $connection->prepare("UPDATE volunteers SET status=0 WHERE id=?");
            $update->bind_param("s", $deptrow[0]);
            $setFree = $connection->prepare("UPDATE departments SET busy=0, volunteer_id=0 WHERE department_name=?");
            $setFree->bind_param("s", $deptrow[1]);
            if ($sql->execute()==true && $update->execute()==true && $setFree->execute()==true) {
                header("location:../next_php/lists/supervision?shift=$shift");
            }
        }
    } else {
        header("location:../user_php/logout");
    }
    $connection->close();
//69996
?>