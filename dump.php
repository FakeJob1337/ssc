<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/test.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<?php 
	$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
	$sql = "SELECT `col1`,`col2`,`col3`,`col6`,`col7`,`col8`,`col9`,`col10`,`col23` FROM `Countract` WHERE 1";
	$result = $conn->query($sql);
	while($row = $result->fetch()){
		$n = $row["col10"];
		$id = $row['col1'];
		$sql = "UPDATE `shtat` SET `years_in_army` = '$n' WHERE `id` = '$id'";
		$res = $conn->query($sql);
	}
// 	while($row = $result->fetch()){
// 		$id = $row["col1"];
// 		$rank_fact = $row["col2"];
// 		$rank_shtat = $row["col3"];
// 		$surname = $row["col6"];
// 		$name = $row['col7'];
// 		$job = $row['col8'];
// 		$pr2 = $row['col9'];
// 		$birthday_str = str_replace('.','-',$row['col23']);
// 		$birthday_time = strtotime($birthday_str);
// 		$birthday = date('Y-m-d', $birthday_time);
// 		$sql = "INSERT INTO `shtat`(`id`, `surname`, `name`, `rank_shtat`, `rank_fact`, `job`, `sr`, `pr1`, `pr2`, `pr3`, `pr4`, `pr5`, `birthday`, `sex`) 
// 		VALUES ('$id','$surname','$name',
// 		'$rank_shtat','$rank_fact','$job',
// 		'','','$pr2',
// 		'','','',
// 		'$birthday','М')";
// 		$result_ins = $conn->query($sql);
// 		while($row_ins = $result_ins->fetch()){
// 			$row_ins;
// 		}
// 	}
// #

?>

</body>
</html>