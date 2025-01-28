<?php
$idFromBtn = $_POST['idFromBtn'];
$idFromCard = $_POST['idFromCard'];	


$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id,pr1,pr2,pr3,pr4,pr5,job FROM shtat WHERE id = $idFromBtn";

$result = $conn->query($sql);
$rowBtn = $result->fetch();

$sql = "SELECT id,pr1,pr2,pr3,pr4,pr5,job FROM shtat WHERE id = $idFromCard";

$result = $conn->query($sql);
$rowCard = $result->fetch();

$sql = "UPDATE shtat SET
pr1 = '". $rowBtn[1] ."',
pr2 = '". $rowBtn[2] ."',
pr3 = '". $rowBtn[3] ."',
pr4 = '". $rowBtn[4] ."',
pr5 = '". $rowBtn[5] ."',
job = '". $rowBtn[6] ."'
WHERE id = $idFromCard";

$result = $conn->query($sql);

$sql = "UPDATE shtat SET
pr1 = '". $rowCard[1] ."',
pr2 = '". $rowCard[2] ."',
pr3 = '". $rowCard[3] ."',
pr4 = '". $rowCard[4] ."',
pr5 = '". $rowCard[5] ."',
job = '". $rowCard[6] ."'
WHERE id = $idFromBtn";

$result = $conn->query($sql);
?>