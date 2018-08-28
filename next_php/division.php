<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
        require_once '../config_php/dbconfig.php';
        $connection = Database::connect();
    }
    else {
        header("location:index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bölgü</title>
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
                   background-image: url('../images/bg.png'); padding-bottom: 10px; padding-top: 10px;}
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
            <a href="shiftdivision" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
	<a href="lists/listVolunteers?shift=<?php echo $_GET['shift'];?>" class="btn btn-success" style="float:left; margin: 100px 0 0 5px;">Könüllü Siyahısı</a>
            <a href="lists/supervision?shift=<?php echo $_GET['shift'];?>" class="btn btn-info" style="float:right; margin: 100px 6px 0 0;">Nəzarət</a>
        </div>
        <div class="myDiv">
            <?php if(!empty($_SESSION["err"])){
                    echo "<div class=\"alert alert-danger fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["err"];
                    echo "</div>";
                    unset($_SESSION["err"]);
            }?>
            <table align="center">
                <tr>
                    <td colspan="4"><b style="letter-spacing: 3px; font-size: 150%; color:#556;">ŞÖBƏLƏR</b></td>
                </tr>
                    <?php
                        $get_depts = $connection->prepare("SELECT department_name, department_type FROM departments");
                        $get_depts->execute();
                        $res_dept = $get_depts->get_result();
                        while ($dept_row = $res_dept->fetch_array()){
                    ?>
                    <form action="../config_php/appoint" method="POST">
                    <tr>
                        <td><b><?php echo $dept_row[0];?></b></td>
                        <?php
                        $query = $connection->prepare("SELECT busy FROM departments WHERE department_name=?");
                        $query->bind_param("s", $dept_row[0]);
                        $query->execute();
                        $res = $query->get_result();
                        $myrow = $res->fetch_array();
                        $getVolunteer = $connection->prepare("SELECT volunteer, end_time FROM appointments WHERE "
                                . "volunteer_id=(SELECT volunteer_id FROM departments WHERE department_name=?)");
                        $getVolunteer->bind_param("s", $dept_row[0]);
                        $getVolunteer->execute();
                        $resVol = $getVolunteer->get_result();
                        $rowVol = $resVol->fetch_array();
                        ?>
                        <td>
                            <select name="volunteer" class="form-control" <?php if($myrow[0]==1){echo"disabled";}?>>
                                <option><?php echo $rowVol[0];?></option>
                            <?php
                                $shift = intVAl($_GET['shift']);
                                $sql = $connection->prepare("SELECT id, CONCAT(last_name, ' ', first_name, ' ', fathers_name) "
                                        . "FROM volunteers WHERE shift=? AND status=0 AND privilege=0 "
                                        . "AND rest_day != DAYOFWEEK(now()) ORDER BY last_name");
                                $sql->bind_param("s", $shift);
                                $sql->execute();
                                $result = $sql->get_result();
                                while ($row=$result->fetch_array()){
                            ?>
                                <option value="<?php echo $row[1]?>:<?php echo $row[0]?>"><?php echo $row[1]?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="shift" value="<?php echo $_GET['shift'];?>"/>
                            <input type="hidden" name="dept" value="<?php echo $dept_row[0];?>" class="form-control"/>
                            <input type="hidden" name="dept_type" value="<?php echo $dept_row[1];?>" class="form-control"/>
                            <input type="time" name="end_time" value="<?php echo $rowVol[1];?>" class="form-control" <?php if($myrow[0]==1){echo"disabled";}?>/>
                        </td>
                        <td>
                            <input type="submit" value="Göndər" class="btn btn-success" <?php if($myrow[0]==1){echo"disabled";}?>/>
                        </td>
                    </tr>
                </form>
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