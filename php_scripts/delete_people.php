<?php
$id = $_POST['id'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "INSERT INTO shtat_archive(`surname`,`name`,`rank_fact`,`sex`,`is_conscripts`,`years_in_army`,`shtat_id`, `birthday`)
SELECT `surname`,`name`,`rank_fact`,`sex`,`is_conscripts`,`years_in_army`,`id`, `birthday` FROM shtat
WHERE shtat.id = '$id';";
$res = $conn->query($sql)->fetch();

$sql = "UPDATE `shtat` SET `surname`='Вакант',`name`= NULL,`rank_fact`=NULL,`birthday`=NULL,`sex`=NULL,`is_conscripts`=NULL,`years_in_army`=NULL WHERE shtat.id = '$id'";
$res = $conn->query($sql)->fetch();