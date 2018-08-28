<?php
    session_start();
    require_once 'dbconfig.php';
    $connection= Database::connect();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
        $params = $_POST["leader"];
        $arr = explode(":", $params);
        $id = $arr[0];
        $shift = $arr[1];
        $clear = $connection->prepare("UPDATE volunteers SET privilege=0 WHERE shift=?");
        $clear->bind_param("s", $shift);
        $set = $connection->prepare("UPDATE volunteers SET privilege=1 WHERE id=?");
        $set->bind_param("s", $id);
        if ($clear->execute()==true && $set->execute()==true){
            $_SESSION["success"]="Könüllü uğurla qrup rəhbəri təyin olundu!";
            header("location:../next_php/groupleader");
        }
        else {
            $_SESSION["err"]="Xahiş edirik bir daha cəhd edin!";
            header("location:../next_php/groupleader");
        }
    }
    else {
        header("location:../user_php/logout");
    }
    $connection->close();
?>