<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["user"] == "admin") {
        //ok
        require_once 'dbconfig.php';
        $connection= Database::connect();
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $shift = intVal($_GET['list']);
            $id = $_GET['id'];
            $sql = $connection->prepare("DELETE FROM volunteers WHERE id=?");
            $sql->bind_param("s", $id);
            if ($sql->execute()==true) {
                $_SESSION["success"]="Məlumat bazadan uğurla silindi!";
                header("location:../next_php/lists/listVolunteers?shift=$shift");
            }
        }
    } else {
        header("location:../user_php/logout");
    }
    $connection->close();
//69996
?>