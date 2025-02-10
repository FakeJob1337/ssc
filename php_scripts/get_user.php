<?php
session_start();
$login = $_POST['login'];
$password = $_POST['password'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id, permission FROM `Users` WHERE `login` = '$login' and `password` = '$password'";
$result = $conn->query($sql);
$row = $result->fetch();

$_SESSION['status'] = $row['permission'];

if ($row) {
    echo '+';
}
else{
    echo '-';
}