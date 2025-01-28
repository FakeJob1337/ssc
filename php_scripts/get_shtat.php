<?php
$deps = join("', '",$_POST['departament']);
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT COUNT(id) FROM `shtat` where pr2 IN ('$deps') and surname != 'Вакант'"; # "SELECT COUNT(id) FROM `shtat` where pr2 IN ('$deps')"
$res = $conn->query($sql)->fetch();
$all = $res[0];

echo $all;
