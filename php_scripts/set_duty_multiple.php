<?php
$id = $_POST['id'];
$starts = $_POST['dates'];
$days = $_POST['days'];
$specs = $_POST['specs'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
for ($i=0; $i < count($starts); $i++) { 
    $spec = $specs[$i];
    $bdid = $id[$i];
    $start = $starts[$i];
    $day = $days[$i];
    if ($start == "" or $day == "") {
        continue;
    }
    $end = date('Y-m-d', strtotime($start . " + ".$day." day"));
    $sql = "SELECT `years_in_army` FROM `shtat` WHERE `id` = '$bdid'";
    $res = $conn->query($sql);
    $row = $res->fetch();
    $years = $row["years_in_army"];
    $sql = "SELECT days_num, remains_day, spec FROM `duty` WHERE person_id = '$bdid' ORDER BY remains_day ASC";
    $res = $conn->query($sql);
    $row = $res->fetch();

    if ($row['days_num']) {
        $day_need = $row['days_num'];
    } 
    else {
        if ($years <= 10) {
            $day_need = 35;
        }

        if (10 < $years and $years < 15) {
            $day_need = 40;
        } 
        if (15 < $years and $years < 20) {
            $day_need = 45;
        }
        if ($years >= 20) {
            $day_need = 50;
        }
    }

    // if ($row['remains_day']) {
    //     $rem_days = $row['remains_day'] - $day;
    // }
    // else{
    //     $rem_days = $day_need - $day;
    // }
    // if ($spec == ""){
    //     $spec = null;
    //     if ($rem_days < 0) {
    //         die("Лишних дней отпуска"."$rem_days");
    //     }
    // }
    $rem_days = 100;
  
    $sql = "INSERT INTO `duty`(`person_id`, `start`, `end`, `days_num`, `remains_day`, `spec`) VALUES ('$bdid','$start','$end','$day','$rem_days', '$spec')";
    $result = $conn->query($sql);
    $eh = $result->fetch();
    echo 'Успешно';
}
