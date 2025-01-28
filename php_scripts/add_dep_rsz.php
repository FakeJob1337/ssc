<?php

$dep = $_POST['dep'];
$date = $_POST['date'];
$duty = $_POST['duty'];
$trip = $_POST['trip'];
$hospital = $_POST['hospital'];
$mission = $_POST['mission'];
$ill = $_POST['ill'];
$other = $_POST['other'];
$layoff = $_POST['layoff'];
$arrest = $_POST['arrest'];
// foreach ($_POST as $key => $value) {
// 	if (is_array($value)) {
// 		$miss = $miss + $value[0];
// 	}
// }
$pr = 'pr2';

if ($dep == 'Управление') {
	$pr = 'pr1';
}
$miss = [];
// $miss = count($duty)+count($trip)+count($hospital)+count($mission)+count($ill);
if (!is_null($duty)) {
	$duty = join(" ",$duty);
	array_push($miss, $duty);
}
if (!is_null($trip)) {
	$trip = join(" ",$trip);
	array_push($miss, $trip);
}
if (!is_null($hospital)) {
	$hospital = join(" ",$hospital);
	array_push($miss, $hospital);	
}
if (!is_null($ill)) {
	$ill = join(" ",$ill);
	array_push($miss, $ill);
}
if (!is_null($mission)) {
	$mission = join(" ",$mission);
	array_push($miss, $mission);
}
if (!is_null($other)) {
	$other = join(" ",$other);
	array_push($miss, $other);
}
if (!is_null($layoff)) {
	$layoff = join(" ",$layoff);
	array_push($miss, $layoff);
}
if (!is_null($arrest)) {
	$arrest = join(" ",$arrest);
	array_push($miss, $arrest);
}
$miss = join(" ",$miss); 
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT count(id) FROM shtat WHERE $pr = '$dep'";
$result = $conn->query($sql);
$row = $result->fetch();
$shtat = $row[0];

$sql = "SELECT count(id) FROM shtat WHERE $pr = '$dep' AND surname != 'ВАКАНТ'";
$result = $conn->query($sql);
$row = $result->fetch();
$spisok = $row[0];

$sql = "SELECT count(id) FROM rsz";
$result = $conn->query($sql);
$row = $result->fetch();
$id = $row[0];
if ($miss == "") {
	$miss = 0;
}
$face = $spisok - count(explode(" ", $miss));
$sql = "INSERT INTO `rsz` (`date`, `dep`, `shtat`, `spisok`, `face`, `miss`, `duty`, `trip`, `hospital`, `ill`, `mission`, `other`, `layoff`, `arrest`) 
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$conn->prepare($sql)->execute([$date,$dep,$shtat,$spisok,$face, $miss,$duty,$trip,$hospital,$ill,$mission, $other, $layoff, $arrest]);