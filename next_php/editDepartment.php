<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
                require_once '../config_php/dbconfig.php';
                $connection = Database::connect();
                if (isset($_GET['id'])){
                    $id = intVal($_GET['id']);
                    $sql = $connection->prepare("SELECT * FROM departments WHERE id=?");
                    $sql->bind_param("s", $id);
                    $sql->execute();
                    $result=$sql->get_result();
                    $row=$result->fetch_array();
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
            .myDiv {width: 100%; height: auto; min-height: 512px; text-align: center; 
                   background-image: url('../images/bg.png'); padding: 30px 0 15px 0;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6);
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            .err {color: #ff6666; font-size: 130%;}
            table {position: relative; top: 20px; width: 30%; border-top: 3px solid #3399ff; background-color: #f9f9f9;}
            tr, td {padding: 6px 10px;}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../images/logo.png"/>
            <a href="lists/listDept" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
            <a href="../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
        </div>
        <div class="myDiv">
            <form action="../config_php/editDept" method="POST">
                <table class="form-group" align="center">
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Şöbənin adı:</b></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
                            <input type="text" name="department_name" placeholder="şöbənin adı"
                                   class="form-control" value="<?php echo $row['department_name'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Şöbə növü:</b></td>
                        <td>
                            <select name="dept_type" class="form-control">
                                <option value="s" <?php if($row['department_type']=="s"){ echo "selected";}?>>Tək könüllü</option>
                                <option value="m" <?php if($row['department_type']=="m"){ echo "selected";}?>>Çox könüllü</option>
                            </select>
                        </td>
                    </tr>
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
<?php
    $connection->close();
?>