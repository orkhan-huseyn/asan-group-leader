<?php
    session_start();
    require_once('../config_php/dbconfig.php');

    if ((isset($_POST["user"]) && !empty($_POST["user"])) || (isset($_POST["pass"]) && !empty($_POST["pass"]))) {

        $connection = Database::connect();

        $username = $_POST["user"];
        $password = $_POST["pass"];
        //md5
        $passMD5 = md5($password);

        $stmt = $connection->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $passMD5);

        if ($stmt->execute()==true){

            $result = $stmt->get_result();
            $row = $result->fetch_array();

            if ($row["username"]==$username && $row["password"]==$passMD5 && $row["privilege"]==1){
                $_SESSION["loggedin"]=true;
                $_SESSION["user"]="admin";
                header("location:../next_php/welcomeadmin");
                }
            else if ($row["username"]==$username && $row["password"]==$passMD5 && $row["privilege"]==0) {
                $_SESSION["loggedin"]=true;
                $_SESSION["user"]="user";
                header("location:../next_php/welcome");
            }
            else {
                $_SESSION["loggedin"]=false;
                $_SESSION["err"] = "İstifadəçi adı və ya şifrə yanlışdır! ";
                header("location:../index");
            }
        }
        $connection->close();
    }
    else {
        $_SESSION["loggedin"]=false;
        $_SESSION["err"] = "İstifadəçi adı və şifrəni daxil edin!";
        header("location:../index");
    }
?>
