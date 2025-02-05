<?php
$id = $_POST['id'];
$surname = $_POST['surname'];
$name = $_POST['name'];
$secname = $_POST['secname'];
$fullName = $name.' '.$secname;
$rank = $_POST['rank'];
$dolj = $_POST['doljValues'];
$job = $dolj[0];
$pr2 = $dolj[1];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "UPDATE shtat SET
rank_fact = '". $rank ."',
surname = '". $surname ."',
name = '". $fullName ."',
job = '". $job ."',
pr2 = '". $pr2 ."'
WHERE id = $id";

$result = $conn->query($sql);
?>