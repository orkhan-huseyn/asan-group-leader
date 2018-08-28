<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true && $_SESSION["user"]=="admin"){
        require_once '../../config_php/dbconfig.php';
        $connection= Database::connect();
        $stmt = $connection->prepare("SELECT * FROM departments");
        $stmt->execute();
        $result = $stmt->get_result();
        $index = 1;
    }
    else {
        header("location:../../index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Şöbələr</title>
        <link rel="icon" href="../../images/asan.ico"/>
        <script src="../../js/jquery-3.1.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/script.js"></script>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; height: auto; min-height: 512px; text-align: center; 
                   background-image: url('../../images/bg.png'); padding: 0 0 15px 0;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6);
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            .err {color: #ff6666; font-size: 130%;}
            table {border-collapse: collapse; border-top: 2px solid #3399ff; width: 50%; 
                   background-color: #f9f9f9; font-size: 120%;}
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
            <a href="#" style="float:right; margin: 100px 6px 0 0;" class="btn btn-success" data-toggle="modal" data-target="#addDept">
                Şöbə Əlavə Et
            </a>
        </div>
        <div class="modal fade" id="addDept" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../../config_php/newdept" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title" align="center">Şöbə Əlavə Et</h3>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="department_name" class="form-control"/><br/>
                            <select name="department_type" class="form-control">
                                <option value="s">Tək könüllü</option>
                                <option value="m">Çox könüllü</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" style="margin: auto" value="Təsdiq"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="myDiv">
            <h1 style="margin:0; padding: 10px; color: #456" class="text">Şöbələr</h1>
            <?php 
                if(!empty($_SESSION["success"])){
                    echo "<div class=\"alert alert-success fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["success"];
                    echo "</div>";
                    unset($_SESSION["success"]);
                } else if (!empty($_SESSION["err"])){
                    echo "<div class=\"alert alert-danger fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["err"];
                    echo "</div>";
                    unset($_SESSION["err"]);
                }
            ?>
            <table align="center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Şöbənin adı</th>
                        <th>Şöbə növü</th>
                        <th colspan="2">Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = $result->fetch_array()){
                        ?>
                        <tr>
                            <td><?php echo $index; $index++; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td>
                                <?php
                                    if($row[4]=="s"){
                                        echo "Tək könüllü";
                                    }
                                    else {
                                        echo "Çox könüllü";
                                    }
                                ?>
                            </td>
                            <td><a href="../../config_php/removeDept?id=<?php echo $row[0];?>"><button class="btn btn-danger ch"   >Sil</button></a></td>
                            <td><a href="../editDepartment?id=<?php echo $row[0];?>"><button class="btn btn-primary ch">Dəyişdir</button></a></td>
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