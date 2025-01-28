<?php

$id = $_POST['id'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id FROM shtat WHERE id = '$id'";

$result = $conn->query($sql);

?>