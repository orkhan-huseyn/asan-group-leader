<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["user"] == "admin") {
        require_once 'dbconfig.php';
        $connection = Database::connect();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $connection->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("s", $id);
            if($stmt->execute()==true){
                $_SESSION["success"]="İstifadəçi bazadan uğurla silindi!";
                header("location:../next_php/lists/listUsers");
            }
            else {
                $_SESSION["success"]="Xahiş edirik bir daha cəhd edin!";
                header("location:../next_php/lists/listUsers");
            }
        }
    } else {
        header("location:../user_php/logout");
    }
    $connection->close();
?>