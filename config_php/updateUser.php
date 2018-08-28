<?php
    session_start();
    require_once 'dbconfig.php';
    $connection = Database::connect();
    $id = intVal($_POST['id']);
    
    if ((isset($_POST['full_name']) && !empty($_POST["full_name"])) || (isset($_POST['username']) && !empty($_POST["username"]))
            || (isset($_POST['phone_number']) && !empty($_POST["phone_number"])) || (isset($_POST['email']) && !empty($_POST["email"]))) {
        //-------------------------------------------------------
        $fullName = $_POST["full_name"];
        $username = $_POST["username"];
        $pass = $_POST["password"];
        $phone = $_POST["phone_number"];
        $email = $_POST["email"];
        $privilege = intVal($_POST["privilege"]);
        
        $pass_enc = md5($pass);
        
        if ($privilege==1){
            $_SESSION["err"]="Administrator hesabında dəyişiklik edilə bilməz!";
            header("location:../next_php/editUser?id=$id");
        }
        else {
            if (empty($pass)){
            $stmt = $connection->prepare("UPDATE users SET full_name=?, username=?, phone_number=?, email=? WHERE id=?");
            $stmt->bind_param("sssss", $fullName,$username, $phone, $email, $id);
            }
            else {
                $stmt = $connection->prepare("UPDATE users SET full_name=?, username=?, password=?, phone_number=?, email=? WHERE id=?");
                $stmt->bind_param("sssss", $fullName,$username, $pass_enc, $phone, $email, $id);
            }
            if ($stmt->execute()==true){
                $_SESSION["success"]="Məlumat uğurla yeniləndi!";
                header("location:../next_php/lists/listUsers");
            }
            else {
                $_SESSION["err"]="Xahiş edirik bir daha cəhd edin!";
                header("location:../next_php/editUser?id=$id");
            }
        }
    }
    else {
        $_SESSION["err"]="Zəruri xanaları doldurmağınız xahiş olunur!";
        header("location:../next_php/editUser?id=$id");
    }
    $connection->close();
?>