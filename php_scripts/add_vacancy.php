<?php
$data = json_decode($_POST['data'], true);
$rank_shtat = $data['rank_shtat'];
$job = $data['job'];
$pr2 = $data['pr2'];
$sr = $data['sr'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "INSERT INTO `shtat`(`rank_shtat`, `job`, `sr`, `pr2`) VALUES ('$rank_shtat','$job','$sr','$pr2')";
$res = $conn->query($sql)->fetch();
