<?php
    session_start();
    require_once 'dbconfig.php';
    $connection= Database::connect();
    $id = $_POST['id'];
    $department_name = $_POST['department_name'];
    $dept_type = $_POST['dept_type'];
    $query = $connection->prepare("UPDATE departments SET department_name=?, department_type=? WHERE id=?");
    $query->bind_param("sss", $department_name, $dept_type, $id);
    if ($query->execute()==true){
        $_SESSION["success"]="Məlumat uğurla yeniləndi!";
        header("location:../next_php/lists/listDept");
    }
    else {
        echo "MySQL error";
    }
    $connection->close();
?>