<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
        //it's ok
        require_once '../../config_php/dbconfig.php';
        $connection= Database::connect();
    }
    else {
        header("location:../../index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Nəzarət</title>
        <link rel="icon" href="../../images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css"/>
        <script src="../../js/clock.js"></script>
        <meta charset="UTF-8"/>
        <meta name="author_email" content="ohuseynli2018@ada.edu.az"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .headerDiv {width: 100%; height: 150px; text-align: center; 
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .myDiv {width: 100%; height: auto; min-height: 512px; text-align: center; background-image: url('../../images/bg.png');}
            .formDiv {position: relative; top: 50px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6); 
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {border-collapse: collapse; border-top: 2px solid #3399ff; width: 90%; 
                   background-color: #f9f9f9; position: relative; bottom: 10px;}
            th, td {padding: 10px 20px; text-align: left; border-bottom: 1px solid #d9d9d9;}
            tr:hover{background-color:#f4f4f4}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../../images/logo.png"/>
            <span id="clock" 
                  style="font-weight: bold; font-size: 200%; color: #005580; position: relative; top: 98px; left: 450px;">
            </span>
            <a href="../../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
            <a href="../division?shift=<?php echo $_GET['shift'];?>" class="btn btn-info" style="float:right; margin: 100px 6px 0 0;">Bölgü</a>
            <a href="../shiftsupervision" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
            <a href="listVolunteers?shift=<?php echo $_GET['shift'];?>" class="btn btn-success" style="float:left; margin: 100px 0 0 5px;">Könüllü Siyahısı</a>
        </div>
        <div class="myDiv">
            <h1 style="margin:0; padding: 10px; color: #456" class="text">
                Nəzarət
                <?php
                        if($_GET['shift']==1){
                            echo "I";
                        } else if ($_GET['shift']==2){
                            echo "II";
                        } else if ($_GET['shift']==3){
                            echo "III";
                        }
                    ?> 
                Növbə
            </h1>
            <table align="center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Könüllü</th>
                        <th>Hazırda Fəaliyyətdə Olduğu Şöbə</th>
                        <th>Başlama Vaxtı</th>
                        <th>Bitmə Vaxtı</th>
                        <th colspan="2">Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $shift = intVal($_GET['shift']);
                        $sql = $connection->prepare("SELECT * FROM appointments WHERE shift=? ORDER BY volunteer");
                        $sql->bind_param("s", $shift);
                        $sql->execute();
                        $result = $sql->get_result();
                        $i=1;
                        while ($row = $result->fetch_array()){
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo date("H:i", strtotime($row[3])); ?></td>
                            <td><?php echo date("H:i", strtotime($row[4])); ?></td>
                            <td><a href="../../config_php/free?id=<?php echo $row[0]; ?>&list=<?php echo $row[5];?>&vol=<?php echo $row[1];?>"><button class="btn btn-danger ch">Azad et</button></a></td>
                            <td><a href="../editorder?id=<?php echo $row[0]?>&shift=<?php echo $row[5];?>"><button class="btn btn-primary ch">Dəyişdir</button></a></td>
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