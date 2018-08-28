<?php
    session_start();
    require_once 'dbconfig.php';
    $connection = Database::connect();
    $shift = intVal($_POST['shift']);
    if ((isset($_POST['surname']) && !empty($_POST["surname"])) || 
        (isset($_POST['name']) && !empty($_POST["name"]))
            || (isset($_POST['phone_number']) && !empty($_POST["phone_number"]))
            || (isset($_POST['group']) && !empty($_POST["group"]))) {
        
        $last_name = $_POST['surname'];
        $first_name = $_POST['name'];
        $fathers_name = $_POST['fthName'];
        $phone_number = $_POST['phone_number'];
        $group = $_POST['group'];
        $rest_day = $_POST['rest_day'];
        
        $sql = $connection->prepare("INSERT INTO volunteers (first_name, last_name, fathers_name, phone_number, group_num, shift, rest_day) "
                . "VALUES (?, ?, ?, ?, CONCAT('K',?,'M1'), ?, ?)");
        $sql->bind_param("sssssss",$first_name, $last_name, $fathers_name, $phone_number, 
                $group, $shift, $rest_day);
        if ($sql->execute()==true){
            $_SESSION["success"]="Məlumat uğurla bazaya yazıldı!<br/> <strong>$last_name $first_name $fathers_name</strong>";
            header("location: ../next_php/lists/listVolunteers?shift=$shift");
        }
        else {
            $_SESSION['err'] = "Xahiş edirik, bir daha cəhd edin!";
            header("location: ../next_php/add?shift=$shift");
        }
    }
    else {
        $_SESSION['err'] = "Müvafiq xanaları doldurmağınız xahiş olunur!";
        header("location: ../next_php/add?shift=$shift");
    }
    $connection->close();
?>