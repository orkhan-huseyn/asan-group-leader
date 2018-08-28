<?php
    session_start();
    require_once 'dbconfig.php';
    $connection = Database::connect();
    if (isset($_POST['department_name']) && !empty($_POST['department_name'])){
        $department_name = $_POST['department_name'];
        $department_type = $_POST['department_type'];
        $query = $connection->prepare("INSERT INTO departments (department_name, department_type) VALUES (?,?)");
        $query->bind_param("ss", $department_name, $department_type);
        if ($query->execute()==true){
            $_SESSION["success"]="Yeni şöbə <strong>$department_name</strong> uğurla bazaya yazıldı!";
            header("location:../next_php/lists/listDept");
        }
        else {
            $_SESSION["err"]="Səhv baş verdi, zəhmət olmasa bir daha yoxlayın!";
            header("location:../next_php/lists/listDept");
        }
    }
    else {
        $_SESSION["err"]="Şöbə adını yazmağınız xahiş olunur!";
        header("location:../next_php/lists/listDept");
    }
    $connection->close();
?>