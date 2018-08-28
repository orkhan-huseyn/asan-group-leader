<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
        //it's ok
        require_once '../../config_php/dbconfig.php';
        $connection = Database::connect();
    }
    else {
        header("location:../../index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>İstifadəçi Siyahı</title>
        <link rel="icon" href="../../images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
        <script src="../../js/jquery-3.1.0.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; min-height: 512px; height: auto; 
                   text-align: center; background-image: url('../../images/bg.png');}
            .formDiv {position: relative; top: 50px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {border-collapse: collapse; border-top: 2px solid #3399ff; width: 80%; background-color: #f9f9f9;}
            th, td {padding: 10px 20px; text-align: left; border-bottom: 1px solid #d9d9d9;}
            tr:hover{background-color:#f4f4f4}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../../images/logo.png"/>
            <a href="../../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
            <a href="../welcomeadmin" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
            <a href="../addUser" style="float:right; margin: 100px 6px 0 0;">
                <button class="btn btn-success ch">
                    Yeni İstifadəçi
                </button>
            </a>
        </div>
        <div class="myDiv">
            <h1 style="margin:0; padding: 10px; color: #456" class="text">İstifadəçi Siyahısı</h1>
            <?php if(!empty($_SESSION["success"])){
                    echo "<div class=\"alert alert-success fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["success"];
                    echo "</div>";
                    unset($_SESSION["success"]);
            }?>
            <table align="center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tam adı</th>
                        <th>İstifadəçi adı</th>
                        <th>Əlaqə Telefonu</th>
                        <th>E-poçt</th>
                        <th>Səlahiyyəti</th>
                        <th colspan="2">Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $connection->prepare("SELECT * FROM users WHERE privilege=0");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $i=1;
                        while ($row= $result->fetch_array()){
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo $row[4]; ?></td>
                            <td><?php echo $row[5]; ?></td>
                            <td><?php if ($row[6]==0) { echo "qrup rəhbəri"; } else { echo "admin"; } ?></td>
                            <td><a href="../../config_php/deleteuser?id=<?php echo $row[0]; ?>"><button class="btn btn-danger ch"   >Sil</button></a></td>
                            <td><a href="../editUser?id=<?php echo $row[0]?>"><button class="btn btn-primary ch">Dəyişdir</button></a></td>
                        </tr>
                        <?php
                        }
                    ?>
                </tbody>
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