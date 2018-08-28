<?php
    session_start();
    require_once 'dbconfig.php';
    if ((isset($_POST['full_name']) && !empty($_POST["full_name"])) || (isset($_POST['username']) && !empty($_POST["username"]))
            || (isset($_POST['password']) && !empty($_POST["password"]))
            || (isset($_POST['phone_number']) && !empty($_POST["phone_number"])) || (isset($_POST['email']) && !empty($_POST["email"]))) {
        //-------------------------------------------------------
        
        $connection = Database::connect();
        
        $fullName = $_POST["full_name"];
        $username = $_POST["username"];
        $pass = $_POST["password"];
        $phone = $_POST["phone_number"];
        $email = $_POST["email"];
        
        $pass_enc = md5($pass);
        
        $stmt = $connection->prepare("INSERT INTO users (full_name, username, password, phone_number, email) VALUES (?, ?, ?, CONCAT('+',?), ?)");
        $stmt->bind_param("sssss", $fullName, $username, $pass_enc, $phone, $email);
        
        if ($stmt->execute()==true){
            $_SESSION["success"]="İstifadəçi uğurla bazaya yazıldı!";
            header("location:../next_php/lists/listUsers");
        }
        else {
            $_SESSION["err"]="Xahiş edirik bir daha cəhd edin!";
            header("location:../next_php/addUser");
        }
    }
    else {
        $_SESSION["err"]="Bütün xanaları doldurmağınız xahiş olunur!";
        header("location:../next_php/addUser");
    }
    $connection->close();
?>