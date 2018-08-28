<?php
    session_start();
    unset($_SESSION['user']);
    unset($_SESSION['loggedin']);
    $_SESSION["goodbye"]="Tətbiqetməmizi istifadə etdiyiniz üçün təşəkkürlər! :)";
    header("location:../index");
?>