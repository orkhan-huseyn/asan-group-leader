<?php
session_start();
require_once 'dbconfig.php';
$connection = Database::connect();

$shift = intVal($_POST['shift']);
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    if (!empty($_POST['volunteer']) && !empty($_POST['dept']) && !empty($_POST['end_time'])) {
        $dept = $_POST['dept'];
        $dept_type = $_POST['dept_type'];
        $volunteer = $_POST['volunteer'];
        $end_time = $_POST['end_time'];
        $pieces = explode(":", $volunteer);
        $vol = $pieces[0];
        $id = $pieces[1];

        $update = $connection->prepare("UPDATE volunteers SET status=1 WHERE id=?");
        $update->bind_param("s", $id);
        $check = $connection->prepare("SELECT busy FROM departments WHERE department_name=?");
        $check->bind_param("s", $dept);
        $setBusy = $connection->prepare("UPDATE departments SET busy=1, volunteer_id=? WHERE department_name=?");
        $setBusy->bind_param("ss", $id, $dept);
        $sql = $connection->prepare("INSERT INTO appointments (volunteer, department, start_time, end_time, shift, volunteer_id) "
            . "VALUES (?, ?, NOW(), ?, ?, ?)");
        $sql->bind_param("sssss", $vol, $dept, $end_time, $shift, $id);
        //queries end
        $check->execute();
        $result = $check->get_result();
        $row = $result->fetch_array();

        if (date("H:i") < date("H:i", strtotime($end_time))) {
            if ($row[2] == 0) {
                if ($sql->execute() == true) {
                    $update->execute();
                    if ($dept_type == "m") {
                        //do nothing, department is never busy
                    } else {
                        $setBusy->execute();
                    }
                    header("location:../next_php/lists/supervision?shift=$shift");
                } else {
                    header("location:../next_php/division?shift=$shift");
                }
            } else {
                header("location:../next_php/division?shift=$shift");
            }
        } else {
            $_SESSION["err"] = "Bitmə vaxtını düzgün seçməyiniz xahiş olunur";
            header("location:../next_php/division.php?shift=$shift");
        }
    } else {
        $_SESSION["err"] = "Xahiş edirik müvafiq xanaları doldurub daha sonra seçim edəsiniz!";
        header("location:../next_php/division?shift=$shift");
    }
} else {
    header("location:index.php");
    $_SESSION["err"] = "Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
}
$connection->close();
?>