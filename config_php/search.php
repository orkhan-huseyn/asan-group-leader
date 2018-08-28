<?php
    session_start();
    require_once 'dbconfig.php';
    $connection = Database::connect();
    $disabled = '';
    if ($_SESSION["user"] == "user") {
        $disabled = "disabled";
    }
    $search = "%".$_POST['searchVal']."%";
    $shift = intVal($_POST['shift']);
    $weekdays = array("Bazar", "Bazar ertəsi", "Çərşənbə axşamı", "Çərşənbə",
        "Cümə axşamı", "Cümə", "Şənbə");

    $searchQuery = null;

    if (empty($search)) {
        $searchQuery = $connection->prepare("SELECT * FROM volunteers WHERE shift=? ORDER BY last_name");
        $searchQuery->bind_param("s", $shift);
    } else {
        $searchQuery = $connection->prepare("SELECT * FROM volunteers WHERE shift=? AND "
                . "(first_name LIKE ? OR last_name LIKE ? OR fathers_name LIKE ?) 
                ORDER BY last_name");
        $searchQuery->bind_param("ssss", $shift, $search, $search, $search);
    }
    $searchQuery->execute();
    $searchRes = $searchQuery->get_result();

    $index = 1;
    while ($row = $searchRes->fetch_array()) {
        echo "<tr>";
        echo "<td>";
        echo $index;
        $index++;
        echo "</td>";
        echo "<td> $row[2] $row[1] $row[3]</td>";
        echo "<td>+$row[4]</td>";
        echo "<td>$row[5]</td>";
        echo "<td>";
        for ($i = 0; $i < count($weekdays); $i++) {
            if ($row[9] == ($i + 1)) {
                echo $weekdays[$i];
            }
        }
        echo "</td>";
        echo "<td>";
        if ($row[6] == 0) {
            echo "<span class=\"glyphicon glyphicon-ok-sign\" style=\"color:green;\"></span>";
        } else {
            echo "<span class=\"glyphicon glyphicon-remove\" style=\"color:red;\"></span>";
        }
        echo "</td>";
        echo "<td>";
        echo "<a href=\"../../config_php/deletefromdb?id=$row[0]&list=$row[7]\"><button class=\"btn btn-danger ch\" $disabled>Sil</button></a>";
        echo "</td>";
        echo "<td>";
        echo "<a href=\"../edit?id=$row[0]&shift=$row[7]\"><button class=\"btn btn-primary ch\" $disabled>Dəyişdir</button></a>";
        echo "</td>";
        echo "</tr>";
    }
    $connection->close();
?>