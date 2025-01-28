<?php
$o_ar = array("рядовой","ефрейтор", "мл. сержант","сержант", "ст. сержант", 'старшина');
$p_ar = ["прапорщик","ст. прапорщик"];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT `id`, `rank_fact` FROM `shtat` WHERE `sr` = 'Офицеры'";
$result = $conn->query($sql);
while($row = $result->fetch(PDO::FETCH_NUM)){
    $id = $row[0];
    $rank_fact = $row[1];
    if (in_array($row[1], $o_ar)) {
        $sql = "UPDATE `shtat` SET `sr`='Солдаты и сержанты' WHERE `id` = '$id'";
        $upd_result = $conn->query($sql);
        $upd_row = $upd_result->fetch();
    }
    elseif (in_array($row[1], $p_ar)) {
        $sql = "UPDATE `shtat` SET `sr`='Прапорщики' WHERE `id` = '$id'";
        $upd_result = $conn->query($sql);
        $upd_row = $upd_result->fetch();
    }
    else {
        $sql = "UPDATE `shtat` SET `sr`='Офицеры' WHERE `id` = '$id'";
        $upd_result = $conn->query($sql);
        $upd_row = $upd_result->fetch();
    }
}