<?php

$date = $_POST['date'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

if ($date == '') {
	$sql= "SELECT `date`,SUM(shtat),SUM(spisok),GROUP_CONCAT(miss),GROUP_CONCAT(duty),GROUP_CONCAT(trip),GROUP_CONCAT(hospital),GROUP_CONCAT(ill), GROUP_CONCAT(mission) FROM rsz
	GROUP BY `date`";
}

else{
	$sql= "SELECT `date`,SUM(shtat),SUM(spisok),GROUP_CONCAT(miss),GROUP_CONCAT(duty),GROUP_CONCAT(trip),GROUP_CONCAT(hospital),GROUP_CONCAT(ill), GROUP_CONCAT(mission) FROM rsz
	WHERE `date` = '$date'";
}

$result = $conn->query($sql);


echo '<thead class="table-dark">
		<tr>
			<th scope="col" style="width:50px;">№</th>
			<th scope="col">Дата</th>
			<th scope="col">По штату</th>
			<th scope="col">По списку</th>
			<th scope="col">На лицо</th>
			<th scope="col">Отсутствуют</th>
			<th scope="col">Отпуск</th>
			<th scope="col">Командировка</th>
			<th scope="col">Госпиталь</th>
			<th scope="col">Болен</th>
			<th scope="col">Наряд</th>
		</tr>
	</thead><tbody>';

$i = 1;
while($row = $result->fetch()){
	$lenMiss = count(preg_split('/[\ \n\,]+/', $row[3], -1, PREG_SPLIT_NO_EMPTY));
	$lenDuty = count(preg_split('/[\ \n\,]+/', $row[4], -1, PREG_SPLIT_NO_EMPTY));
	$lenTrip = count(preg_split('/[\ \n\,]+/', $row[5], -1, PREG_SPLIT_NO_EMPTY));
	$lenHospital = count(preg_split('/[\ \n\,]+/', $row[6], -1, PREG_SPLIT_NO_EMPTY));
	$lenIll = count(preg_split('/[\ \n\,]+/', $row[7], -1, PREG_SPLIT_NO_EMPTY));
	$lenMission = count(preg_split('/[\ \n\,]+/', $row[8], -1, PREG_SPLIT_NO_EMPTY));
	$face = $row[2] - $lenMiss;
	echo '<tr class="table_row">';
	echo '<th scope="row" style="width:50px;">' . $i . "</th>";
	echo '<td class="item">' . $row[0] . "</td>";
	echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
		echo '<td>' . $face . '</td>';
	echo '<td>' . $lenMiss . '</td>';
	echo '<td>' . $lenDuty . "</td>";
	echo '<td>' . $lenTrip . "</td>";
	echo '<td>' . $lenHospital . "</td>";
	echo '<td>' . $lenIll . "</td>";
	echo '<td>' . $lenMission . "</td>";
	echo "</tr>";
	$i = $i+1;
}
echo "</tbody>";
?>
