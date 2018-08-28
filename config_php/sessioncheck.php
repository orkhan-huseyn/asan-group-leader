<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
        if ($_SESSION["user"]=="admin"){
            print "admin";
        }
        else {
            print "user";
        }
    }
    else {
        header("location:../index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>