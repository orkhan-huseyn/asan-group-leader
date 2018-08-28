<?php
    session_start();
    require_once 'dbconfig.php';
    $connection= Database::connect();
    $shift = intVal($_POST['shift']);
    $id = intVal($_POST['id']);
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
        if (!empty($_POST['volunteer']) && !empty($_POST['dept']) && !empty($_POST['end_time'])) {
            
            $volunteer = $_POST['volunteer'];
            $volunteer_id = $_POST['volunteer_id'];
            $department = $_POST['dept'];
            $end_time = $_POST['end_time'];
            
            $pieces = explode(":", $department);
            $dept = $pieces[0];
            $dept_type = $pieces[1];
            
            $getLast = $connection->prepare("SELECT department FROM appointments WHERE volunteer_id=?");
            $getLast->bind_param("s", $volunteer_id);
            $getLast->execute();
            $getRes = $getLast->get_result();
            $deptrow = $getRes->fetch_array();
            
            $check = $connection->prepare("SELECT busy FROM departments WHERE department_name=?");
            $check->bind_param("s", $dept);
            $setBusy = $connection->prepare("UPDATE departments SET busy=1, volunteer_id=? WHERE department_name=?");
            $setBusy->bind_param("ss", $volunteer_id, $dept);
            $setFree = $connection->prepare("UPDATE departments SET busy=0, volunteer_id=0 WHERE department_name=?");
            $setFree->bind_param("s", $deptrow[0]);
            $sql = $connection->prepare("UPDATE appointments SET department=?, end_time=?, volunteer_id=? WHERE id=?");
            $sql->bind_param("ssss", $dept, $end_time, $volunteer_id, $id);
            //queries end
            $check->execute();
            $result = $check->get_result();
            $row = $result->fetch_array();
            
            if ($row[0]==0){//if not busy
                if ($sql->execute()==true){
                    $setFree->execute();
                    if ($dept_type=="m"){
                        //do nothing, department is never busy
                    }
                    else {
                        $setBusy->execute();
                    }
                    header("location:../next_php/lists/supervision?shift=$shift");
                }
                else {
                    header("location:../next_php/editorder?id=$id&shift=$shift");
                }
            }
            else {
                $_SESSION["err"]="Seçdiyiniz şöbə hazırda məşğuldur!";
                header("location:../next_php/editorder?id=$id&shift=$shift");
            }
        }
        else {
            $_SESSION["err"]="Müvafiq xanaları doldurmağınız xahiş olunur!";
            header("location:../next_php/editorder?id=$id&shift=$shift");
        }
    }
    else {
        header("location:index");
        $_SESSION["err"]="Səhifəni görüntüləmək üçün əvvəlcə hesaba daxil olmalısınız.";
    }
    $connection->close();
?>