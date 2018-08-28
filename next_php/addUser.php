<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
        //it's ok
    }
    else {
        header("location:../user_php/logout");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>İstifadəçi Əlavə Et</title>
        <link rel="icon" href="../images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
        <script src="../js/jquery-3.1.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; height: 512px; text-align: center; 
                   background-image: url('../images/bg.png'); color: #457; padding: 10px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {width: 30%; border-top: 5px solid #3399ff; 
                   background-color: #f9f9f9;}
            tr, td {padding: 6px 10px;}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../images/logo.png"/>
            <a href="lists/listUsers" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
            <a href="../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
        </div>
        <div class="myDiv">
            <?php if(!empty($_SESSION["err"])){
                    echo "<div class=\"alert alert-danger fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["err"];
                    echo "</div>";
                    unset($_SESSION["err"]);
            }?>
            <form action="../config_php/newuser" method="POST">
                <table class="form-group" align="center">
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Tam adı:</b></td>
                        <td><input type="text" name="full_name" placeholder="istifadəçinin tam adı" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">İstifadəçi adı:</b></td>
                        <td><input type="text" name="username" placeholder="itifadəçi adı" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Şifrə:</b></td>
                        <td><input type="password" name="password" placeholder="şifrə" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Əlaqə telefonu:</b></td>
                        <td><input type="number" placeholder="+994XXXXXXXXX" name="phone_number" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">E-poçt ünvanı:</b></td>
                        <td><input type="email" placeholder="kimsə@nümunə.com" name="email" class="form-control"></td>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-success" name="" style="padding: 10px 20px;">Təsdiq</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="footerDiv">
            <font class="info">
                &copy; 2016
            </font>
        </div>
    </body>
</html>