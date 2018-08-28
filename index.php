<!DOCTYPE html>
<?php session_start();?>
<html>
    <head>
        <title>Log In</title>
        <link rel="icon" href="images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <script src="js/jquery-3.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; min-height: 512px; height: auto; text-align: center; 
                   background-image: url('images/bg.png'); padding: 40px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6);
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="images/logo.png"/>
        </div>
        <div class="myDiv">
            <div class="formDiv">
                <form action="user_php/login" method="POST" class="form-group">
                    <label><input type="text" name="user" placeholder="istifadəçi adı" class="form-control"/></label><br/>
                    <label><input type="password" name="pass" placeholder="şifrə" class="form-control"/></label><br/>
                    <input type="submit" value="GİRİŞ" class="btn btn-primary"/>
                </form>
            </div>
            <?php 
                if(!empty($_SESSION["err"])){
                    echo "<div class=\"alert alert-danger fade in\" style=\"font-size: 110%\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["err"];
                    echo "</div>";
                    unset($_SESSION["err"]);
                } else if (!empty($_SESSION["goodbye"])){
                    echo "<div class=\"alert alert-info fade in\" style=\"font-size: 110%\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["goodbye"];
                    echo "</div>";
                    unset($_SESSION["goodbye"]);
                }
            ?>
        </div>
        <div class="footerDiv">
            <font class="info">
                &copy; 2016
            </font>
        </div>
    </body>
</html>