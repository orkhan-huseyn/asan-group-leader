<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
        //it's ok
        require_once '../config_php/dbconfig.php';
        $connection= Database::connect();
    }
    else {
        header("location:index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Qrup Rəhbəri Seçimi</title>
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
            .myDiv {width: 100%; height: auto; min-height: 512px; text-align: center;
                   background-image: url('../images/bg.png');}
            .formDiv {position: relative; top: 50px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {border-collapse: collapse; border-top: 5px solid #3399ff; width: 50%;
                   background-color: #f9f9f9;}
            tr, td {padding: 15px 15px; text-align: center; vertical-align: top;}
            tr:hover{background-color:#f4f4f4}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../images/logo.png"/>
            <a href="../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
            <a href="welcome" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
        </div>
        <div class="myDiv">
            <h1 style="padding:30px; margin:0; color: #456">
                Qrup Rəhbərləri
            </h1>
            <?php 
                if(!empty($_SESSION["err"])){
                    echo "<div class=\"alert alert-danger fade in\" style=\"font-size: 110%\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["err"];
                    echo "</div>";
                    unset($_SESSION["err"]);
                } else if (!empty($_SESSION["success"])){
                    echo "<div class=\"alert alert-success fade in\" style=\"font-size: 110%\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["success"];
                    echo "</div>";
                    unset($_SESSION["success"]);
                }
            ?>
            <table align="center">
                <?php for ($i = 1; $i<=3; $i++){?>
                <tr>
                    <form action="../config_php/setleader" method="POST">
                        <td><b style="letter-spacing: 3px; font-size: 150%; color:#556;">
                                <?php for ($j=0; $j<$i; $j++){
                                    echo "I";
                                } ?>
                                NÖVBƏ
                            </b></td>
                        <td>
                            <select name="leader" class="form-control">
                                <?php
                                    $query = $connection->prepare("SELECT id, CONCAT(last_name, ' ', first_name, ' ', fathers_name), privilege FROM "
                                            . "volunteers WHERE shift=?");
                                    $query->bind_param("s", $i);
                                    $query->execute();
                                    $res = $query->get_result();
                                    while($row = $res->fetch_array()){
                                ?>
                                    <option value="<?php echo $row[0];?>:<?php echo $i;?>" <?php if ($row[2]==1) {echo "selected";}?>>
                                        <?php echo $row[1];?>
                                    </option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" value="Təsdiq" class="btn btn-success"/>
                        </td>
                    </form>
                </tr>
                <?php 
                    }
                ?>
            </table>
        </div>
        <div class="footerDiv">
            <font class="info">
                &copy; 2016
            </font>
        </div>
    </body>
</html>
<?php
    $connection->close();
?>