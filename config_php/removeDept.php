<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["user"] == "admin") {
        //ok
        require_once 'dbconfig.php';
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $connection= Database::connect();
            $sql = $connection->prepare("DELETE FROM departments WHERE id=?");
            $sql->bind_param("s", $id);
            if ($sql->execute()==true) {
                $_SESSION["success"]="Şöbə bazadan uğurla silindi!";
                header("location:../next_php/lists/listDept");
            }
        }
    } else {
        header("location:../user_php/logout");
    }
    $connection->close();
//69996
?>