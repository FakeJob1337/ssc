<?php
session_start();
$login = $_POST['login'];
$password = $_POST['password'];
$permissions = $_POST['permissions'];
$permissions = json_encode(explode(",", $permissions), JSON_UNESCAPED_UNICODE);
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "INSERT INTO `Users`(`login`, `password`, `permission`) VALUES ('$login','$password','$permissions')";
$result = $conn->query($sql);
$row = $result->fetch();
