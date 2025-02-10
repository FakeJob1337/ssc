<?php
$data = json_decode($_POST['data'], true);

foreach ($data as $key => $value) {
    $columns .= "`$key`,";
    $values .= "'$value',";
}
$columns = substr($columns, 0, strlen($columns) - 1);
$values = substr($values, 0, strlen($values) - 1);
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "INSERT INTO `personal_information` ($columns) VALUES ($values)";
$res = $conn->query($sql)->fetch();
