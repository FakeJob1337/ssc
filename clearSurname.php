<?php

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT `id`, `surname` FROM `shtat`  WHERE `surname` REGEXP '(^|\s)я'";
$result = $conn->query($sql);
while($row = $result->fetch(PDO::FETCH_NUM)){
    $id = $row[0];
    $sql = "UPDATE `shtat` SET `is_conscripts`='1' WHERE `id` = '$id'";
    $upd_result = $conn->query($sql);
    $res = $upd_result->fetch(PDO::FETCH_ASSOC);
    $sql = "UPDATE `shtat` SET `sr`='Солдаты и сержанты' WHERE `id` = '$id'";
    $upd_result = $conn->query($sql);
    $res = $upd_result->fetch(PDO::FETCH_ASSOC);
}