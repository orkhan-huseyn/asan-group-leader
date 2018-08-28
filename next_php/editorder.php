<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
                require_once '../config_php/dbconfig.php';
                $connection= Database::connect();
                if (isset($_GET['id'])){
                    $id = intVal($_GET['id']);
                    $sql = $connection->prepare("SELECT * FROM appointments WHERE id=?");
                    $sql->bind_param("s", $id);
                    $sql->execute();
                    $res=$sql->get_result();
                    $row = $res->fetch_array();
                    $query = $connection->prepare("SELECT * FROM departments");
                    $query->execute();
                    $result = $query->get_result();
                }
            }
        else {
            header("location:../user_php/logout");
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Əmri Dəyiş</title>
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
            .myDiv {width: 100%; height: 512px; text-align: center; background-image: url('../images/bg.png'); 
                   color: #457; padding: 10px;}
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
            <a href="lists/supervision?shift=<?php echo intVal($_GET['shift']);?>" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
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
            <form action="../config_php/changeorder" method="POST">
                <table class="form-group" align="center">
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Könüllü:</b></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
                            <input type="hidden" name="volunteer_id" value="<?php echo $row['volunteer_id'];?>"/>
                            <input type="hidden" name="shift" value="<?php echo intVal($_GET['shift']);?>">
                            <input type="text" name="volunteer" placeholder="könüllünün tam adı"
                                   class="form-control" value="<?php echo $row['volunteer'];?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Şöbə:</b></td>
                        <td>
                            <select name="dept" class="form-control">
                                <?php
                                    while ($depts = $result->fetch_array()){
                                ?>
                                    <option value="<?php echo $depts[1]?>:<?php echo $depts[4];?>"
                                        <?php if ($row['department']==$depts[1]){echo "selected";}?>>
                                        <?php echo $depts[1]?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Bitmə vaxtı:</b></td>
                        <td><input type="time" name="end_time" placeholder="bitmə vaxtı" 
                                   class="form-control" value="<?php echo $row['end_time'];?>"></td>
                    </tr>
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
<?php
    $connection->close();
?>