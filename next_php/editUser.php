<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
                $_SESSION["info"]="Şifrəni yeniləmək üçün yeni şifrəni daxil edib təsdiqləməyiniz xahiş olunur! <br/> "
                        . "Əgər şifrədə bir dəyişiklik etmək fikriniz yoxdursa xananı boş buraxın.";
                require_once '../config_php/dbconfig.php';
                $connection = Database::connect();
                if (isset($_GET['id'])){
                    $id = intVal($_GET['id']);
                    $stmt = $connection->prepare("SELECT * FROM users WHERE id=?");
                    $stmt->bind_param("s", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_array();
                    $privilege = $row[6];
                    $num = substr($row['phone_number'], 1);
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
        <script src="../js/jquery-3.1.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; min-height: 512px; height:auto; text-align: center; background-image: url('../images/bg.png'); 
                   color: #457; padding: 10px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {width: 30%; border-top: 3px solid #3399ff; background-color: #f9f9f9;}
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
            <?php 
                if(!empty($_SESSION["err"])){
                    echo "<div class=\"alert alert-danger fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["err"];
                    echo "</div>";
                    unset($_SESSION["err"]);
                }
                else if (!empty ($_SESSION["info"])){
                    echo "<div class=\"alert alert-info fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["info"];
                    echo "</div>";
                    unset($_SESSION["info"]);
                }
            ?>
            <form action="../config_php/updateUser" method="POST">
                <table class="form-group" align="center">
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Tam adı:</b></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
                            <input type="text" name="full_name" placeholder="istifadəçinin tam adı"
                                   class="form-control" value="<?php echo $row['full_name'];?>"
                                   <?php if ($privilege==1) {echo "disabled";} ?>>
                        </td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">İstifadəçi adı:</b></td>
                        <td><input type="text" name="username" placeholder="itifadəçi adı" 
                                   class="form-control" value="<?php echo $row['username'];?>"
                                   <?php if ($privilege==1) {echo "disabled";} ?>></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Şifrə:</b></td>
                        <td><input type="password" name="password" placeholder="yeni şifrə"
                                   class="form-control"
                                   <?php if ($privilege==1) {echo "disabled";} ?>></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">Əlaqə telefonu:</b></td>
                        <td><input type="number" placeholder="+994XXXXXXXXX" name="phone_number" 
                                   class="form-control" value="<?php echo $num;?>"
                                   <?php if ($privilege==1) {echo "disabled";} ?>></td>
                    </tr>
                    <tr>
                        <td><b style="font-size: 130%; font-weight: normal;">E-poçt ünvanı:</b></td>
                        <td><input type="email" placeholder="kimsə@nümunə.com" name="email" 
                                   class="form-control" value="<?php echo $row['email'];?>"
                                   <?php if ($privilege==1) {echo "disabled";} ?>></td>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="privilege" value="<?php echo $privilege?>"/>
                            <button class="btn btn-success" name="" 
                                    style="padding: 10px 20px;"
                                    <?php if ($privilege==1) {echo "disabled";} ?>>
                                Təsdiq
                            </button>
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