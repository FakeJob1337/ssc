<?php 
$id = $_POST["id"];
$table = $_POST["table"];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "DELETE FROM `$table` WHERE shtat_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch(); 