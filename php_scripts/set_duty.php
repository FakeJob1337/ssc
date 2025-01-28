<?php
$id = $_POST['id'];
$start = $_POST['start'];
$end = date('Y-m-d', strtotime($start . " + ".$_POST['days']." day"));
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT `years_in_army` FROM `shtat` WHERE `id` = '$id'";
$res = $conn->query($sql);
$row = $res->fetch();
$years = $row["years_in_army"];
$sql = "SELECT days_num, remains_day FROM `duty` WHERE person_id = '$id' ORDER BY remains_day ASC";
$res = $conn->query($sql);
$row = $res->fetch();
if ($row['days_num']) {
    $days = $row['days_num'];
} 
else {
    if ($years <= 10) {
        $days = 30;
    }
    
    if (10 < $years and $years < 15) {
        $days = 35;
    } 
    if (15 < $years and $years < 20) {
        $days = 40;
    }
    if ($years >= 20) {
        $days = 45;
    }
}
if ($row['remains_day']) {
    $rem_days = $row['remains_day'] - $_POST['days'];
}
else{
    $rem_days = $days - $_POST['days'];
}
if ($rem_days < 0) {
    die("Лишних дней отпуска"."$rem_days");
}

$sql = "INSERT INTO `duty`(`person_id`, `start`, `end`, `days_num`, `remains_day`) VALUES ('$id','$start','$end','$days','$rem_days')";
$result = $conn->query($sql);
$eh = $result->fetch();
echo 'Успешно';