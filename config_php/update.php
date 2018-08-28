<?php
session_start();
require_once 'dbconfig.php';
$shift = intVal($_POST['shift']);
$id = intVal($_POST['id']);
$connection= Database::connect();
//------------------------------------------
if ((isset($_POST['surname']) && !empty($_POST["surname"])) ||
        (isset($_POST['name']) && !empty($_POST["name"])) ||
        (isset($_POST['phone_number']) && !empty($_POST["phone_number"])) || (isset($_POST['group']) && !empty($_POST["group"]))) {

    $last_name = $_POST['surname'];
    $first_name = $_POST['name'];
    $fathers_name = $_POST['fthName'];
    $phone_number = $_POST['phone_number'];
    $group = $_POST['group'];
    $rest_day = $_POST['rest_day'];

    $updt = $connection->prepare("UPDATE volunteers SET first_name=?, last_name=?, fathers_name=?, "
            . "phone_number=?, group_num=CONCAT('K',?,'M1'), shift=?, rest_day=? WHERE id=?");
    $updt->bind_param("ssssssss", $first_name, $last_name, $fathers_name, $phone_number, 
            $group, $shift, $rest_day, $id);
    if ($updt->execute()) {
        $_SESSION["success"]="Məlumat uğurla yeniləndi!";
        header("location: ../next_php/lists/listVolunteers?shift=$shift");
    } else {
        $_SESSION['err'] = "Xahiş edirik, bir daha cəhd edin!";
        header("location: ../next_php/edit?id=$id&shift=$shift");
    }
} else {
    $_SESSION['err'] = "Xahiş edirik, bütün xanaları doldurasınız!";
    header("location:../next_php/edit?id=$id&shift=$shift");
}
$connection->close();
?>