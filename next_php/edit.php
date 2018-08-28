<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
                require_once '../config_php/dbconfig.php';
                $connection=Database::connect();
                if (isset($_GET['id'])){
                    $id = intVal($_GET['id']);
                    $sql = $connection->prepare("SELECT * FROM volunteers WHERE id=?");
                    $sql->bind_param("s", $id);
                    $sql->execute();
                    $res = $sql->get_result();
                    $row = $res->fetch_array();
                    $grp = substr($row['group_num'], 1, 2);
                }
            }
        else {
            header("location:../user_php/logout");
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Məlumat Dəyişikliyi</title>
        <link rel="icon" href="../images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; height: 512px; text-align: center; background-image: url('../images/bg.png'); color: #457;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {position: relative; top: 10px; width: 30%; border-top: 3px solid #3399ff; background-color: #f9f9f9;}
            tr, td {padding: 5px 10px;}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../images/logo.png"/>
            <a href="lists/listVolunteers?shift=<?php echo intVal($_GET['shift']);?>" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
            <a href="../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
        </div>
        <div class="myDiv">
            <form action="../config_php/update" method="POST">
                <table class="form-group" align="center">
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Soyad:</b></td>
                        <td><input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
                            <input type="text" name="surname" placeholder="könüllünün soyadı" 
                                   class="form-control" value="<?php echo $row['last_name'];?>"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Ad:</b></td>
                        <td><input type="text" name="name" placeholder="adı" 
                                   class="form-control" value="<?php echo $row['first_name'];?>"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Ata adı:</b></td>
                        <td><input type="text" name="fthName" placeholder="ata adı" 
                                   class="form-control" value="<?php echo $row['fathers_name'];?>"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Əlaqə telefonu:</b></td>
                        <td><input type="number" placeholder="+994XXXXXXXXX" name="phone_number" 
                                   class="form-control" value="<?php echo $row['phone_number'];?>"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Qrup nömrəsi:</b></td>
                        <td><input type="number" min="0" placeholder="KXXM1" name="group" 
                                   class="form-control" value="<?php echo $grp;?>"></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">İstirahət günü:</b></td>
                        <td>
                            <select name="rest_day" class="form-control">
                                <option value="1" <?php if ($row['rest_day']==1){echo "selected";}?>>Bazar</option>
                                <option value="2" <?php if ($row['rest_day']==2){echo "selected";}?>>Bazar ertəsi</option>
                                <option value="3" <?php if ($row['rest_day']==3){echo "selected";}?>>Çərşəbə axşamı</option>
                                <option value="4" <?php if ($row['rest_day']==4){echo "selected";}?>>Çərşəbə</option>
                                <option value="5" <?php if ($row['rest_day']==5){echo "selected";}?>>Cümə axşamı</option>
                                <option value="6" <?php if ($row['rest_day']==6){echo "selected";}?>>Cümə</option>
                                <option value="7" <?php if ($row['rest_day']==7){echo "selected";}?>>Şənbə</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Növbə:</b></td>
                        <td>
                            <select name="shift" class="form-control">
                                <option value="1">I Növbə</option>
                                <option value="2">II Növbə</option>
                                <option value="3">III Növbə</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-success" name="" style="padding: 10px 20px;">Təsdiq</button>
                        </td>
                    </tr>
                </table
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