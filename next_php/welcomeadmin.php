<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
        //it's ok
    }
    else {
        header("location:../index");
        $_SESSION["err"]="Səhifəni ancaq məsul şəxs görüntüləyə bilər.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Paneli</title>
        <link rel="icon" href="../images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; min-height: 472px; height: auto; text-align: center; 
                   background-image: url('../images/bg.png'); padding: 15px;}
            .formDiv {position: relative; top: 50px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            .links {font-size: 250%; margin: 0 0 10px 0; padding: 20px 5px; width: 500px;}
            .links:hover {color: #286090; background-color: #ebf2fa;}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../images/logo.png"/>
            <a href="../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
            <a href="groupleader" class="btn btn-info" style="float:right; margin: 100px 6px 0 0;">Qrup Rəhbəri</a>
        </div>
        <div class="myDiv">
            <div style="height: auto; width: auto; margin: 0 auto;">
                <a href="lists/listUsers" class="btn btn-primary links">İstifadəçi Siyahısı</a><br/>
                <a href="lists/listDept" class="btn btn-primary links">Şöbələr</a><br/>
                <a href="shiftlist" class="btn btn-primary links">Könüllü Siyahısı</a><br/>
                <a href="shiftdivision" class="btn btn-primary links" >Bölgü</a><br/>
                <a href="shiftsupervision" class="btn btn-primary links">Nəzarət</a>
            </div>
        </div>
        <div class="footerDiv">
            <font class="info">
                &copy; 2016
            </font>
        </div>
    </body>
</html>