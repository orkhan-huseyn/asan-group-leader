<?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
        require_once '../../config_php/dbconfig.php';
        $connection = Database::connect();
        $shift = intVal($_GET['shift']);
        //count free volunteers
        $countFree = $connection->prepare("SELECT COUNT(*) FROM volunteers WHERE status=0 AND shift=?");
        $countFree->bind_param("s", $shift);
        $countFree->execute();
        $resFree = $countFree->get_result();
        $free = $resFree->fetch_array()[0];
        //count busy volunteers
        $countBusy = $connection->prepare("SELECT COUNT(*) FROM volunteers WHERE status=1 AND shift=?");
        $countBusy->bind_param("s", $shift);
        $countBusy->execute();
        $resBusy=$countBusy->get_result();
        $busy = $resBusy->fetch_array()[0];
    }
    else {
        header("location:../../index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Siyahı</title>
        <link rel="icon" href="../../images/asan.ico"/>
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css"/>
        <script src="../../js/jquery-3.1.0.min.js"></script>
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
                   background-image: url('../../images/bg.png'); padding: 0 30px 5px 30px;}
            .footerDiv {width: 100%; height: 40px; text-align: center;
                       background: linear-gradient(#fafafa 60%, #E6E6E6);
                       border: 2px solid #3399ff;}
            .info {position: relative; top: 10px;}
            table {border-collapse: collapse; border-top: 4px solid #3399ff;
                   background-color: #f9f9f9; position: relative; bottom: 10px;}
            th, td {padding: 10px 20px; text-align: left; border-bottom: 1px solid #d9d9d9;}
            tr:hover{background-color:#f4f4f4}
            img {position: absolute; left: 0; right: 0; margin: 0 auto;}
        </style>
    </head>
    <body>
        <div class="headerDiv">
            <img src="../../images/logo.png"/>
            <a href="../../user_php/logout" class="btn btn-primary" style="float:right; margin: 100px 6px 0 0;">Çıxış</a>
            <a href="../shiftlist" class="btn btn-primary" style="float:left; margin: 100px 0 0 6px;">Geri</a>
            <a href="../division?shift=<?php echo $_GET['shift'];?>" class="btn btn-info" style="float:left; margin: 100px 6px 0 6px;">Bölgü</a>
            <a href="supervision?shift=<?php echo $_GET['shift'];?>" class="btn btn-warning" style="float:left; margin: 100px 0 0 0;">Nəzarət</a>
            <a href="../add?shift=<?php echo $_GET['shift'];?>" style="float:right; margin: 100px 6px 0 0;">
                <button class="btn btn-success ch">
                    Könüllü Əlavə Et
                </button>
            </a>
        </div>
        <div class="myDiv">
            <h1 style="margin:0; padding: 10px; color: #456;" class="text">
                Könüllü Siyahısı
                    <?php
                        if($shift==1){
                            echo "I";
                        } else if ($shift==2){
                            echo "II";
                        } else if ($shift==3){
                            echo "III";
                        }
                    ?>
                Növbə
            </h1>
            <?php if(!empty($_SESSION["success"])){
                    echo "<div class=\"alert alert-success fade in\" style=\"font-size: 110%;\">";
                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" arial-label=\"close\">&times;</a>";
                    echo $_SESSION["success"];
                    echo "</div>";
                    unset($_SESSION["success"]);
            }?>
            <table align="center" class="table">
                <thead>
                    <tr>
                        <td colspan="6">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                                <input type="text" class="form-control" name="search" id="search" placeholder="Axtar..." />
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-success">Azad <span class="badge"><?php echo $free; ?></span></button>
                        </td>
                        <td>
                            <button class="btn btn-danger">Məşğul <span class="badge"><?php echo $busy; ?></span></button>
                        </td>
                    </tr>
                    <tr>
                        <th>#<input type="hidden" id="list_shift" value="<?php echo $shift;?>"/></th>
                        <th>Könüllü</th>
                        <th>Əlaqə Telefonu</th>
                        <th>Qrup</th>
                        <th>İstirahət günü</th>
                        <th>Status</th>
                        <th colspan="2">Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                        $stmt=$connection->prepare("SELECT * FROM volunteers WHERE shift=? ORDER BY last_name");
                        $stmt->bind_param("s", $shift);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $i = 1;
                        while ($row = $result->fetch_array()){
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?php echo $row[2]. " " .$row[1]. " " .$row[3] ?></td>
                            <td>+<?php echo $row[4]; ?></td>
                            <td><?php echo $row[5]; ?></td>
                            <td><?php
                                    $weekdays = array("Bazar", "Bazar ertəsi", "Çərşənbə axşamı", "Çərşənbə",
                                        "Cümə axşamı", "Cümə", "Şənbə");
                                    for ($index=0; $index<count($weekdays);$index++){
                                        if ($row[9]==($index+1))
                                        {
                                            echo $weekdays[$index];
                                        }
                                    }
                                ?>
                            </td>
                            <td><?php
                                    if ($row[6]==0) {
                                        echo "<span class=\"glyphicon glyphicon-ok-sign\" style=\"color:green;\"></span>";
                                    } else {
                                        echo "<span class=\"glyphicon glyphicon-remove\" style=\"color:red;\"></span>";
                                    }
                                ?>
                            </td>
                            <td><a href="../../config_php/deletefromdb?id=<?php echo $row[0]; ?>&list=<?php echo $row[7]?>"><button class="btn btn-danger ch">Sil</button></a></td>
                            <td><a href="../edit?id=<?php echo $row[0]?>&shift=<?php echo $row[7]?>"><button class="btn btn-primary ch">Dəyişdir</button></a></td>
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
