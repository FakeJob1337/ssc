<?php
$id = $_POST['id'];
$surname = $_POST['surname'];
$name = $_POST['name'];
$secname = $_POST['secname'];
$fullName = $name.' '.$secname;
$rank = $_POST['rank'];
$dolj = $_POST['doljValues'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "UPDATE shtat SET
rank_fact = '". $rank ."',
surname = '". $surname ."',
name = '". $fullName ."'
WHERE id = $id";

$result = $conn->query($sql);
?>