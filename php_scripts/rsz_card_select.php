<?php
$date = $_POST['date'];	
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$full = $_POST['full'];
$sql= "SELECT `dep` ,SUM(shtat),SUM(spisok),GROUP_CONCAT(miss),GROUP_CONCAT(duty),GROUP_CONCAT(trip),GROUP_CONCAT(hospital),GROUP_CONCAT(ill), GROUP_CONCAT(mission),
GROUP_CONCAT(other), GROUP_CONCAT(layoff), GROUP_CONCAT(arrest)
FROM rsz
WHERE `date` = '$date'
GROUP BY `dep`
ORDER BY `rsz`.`dep` ASC";
$result = $conn->query($sql);
echo '<thead class="table-dark">
		<tr>
			<th scope="col" style="width:50px;">№</th>
			<th scope="col" >Подразделение</th>
			<th scope="col">По штату</th>
			<th scope="col">По списку</th>
			<th scope="col">На лицо</th>
			<th scope="col">Отсутствуют</th>
			<th scope="col">Отпуск</th>
			<th scope="col">Командировка</th>
			<th scope="col">Госпиталь</th>
			<th scope="col">Болен</th>
			<th scope="col">Наряд</th>
			<th scope="col">Другое</th>
			<th scope="col">Увольнение</th>
			<th scope="col">Арест</th>
		</tr>
	</thead><tbody >';
$sumDuty = 0;
$i = 1;
	while($row = $result->fetch()){
	
	if ($full == 1) {
		$miss = count(preg_split('/[\ \n\,]+/', $row[3], -1, PREG_SPLIT_NO_EMPTY));
		$duty = count(preg_split('/[\ \n\,]+/', $row[4], -1, PREG_SPLIT_NO_EMPTY));
		$trip = count(preg_split('/[\ \n\,]+/', $row[5], -1, PREG_SPLIT_NO_EMPTY));
		$hospital = count(preg_split('/[\ \n\,]+/', $row[6], -1, PREG_SPLIT_NO_EMPTY));
		$ill = count(preg_split('/[\ \n\,]+/', $row[7], -1, PREG_SPLIT_NO_EMPTY));
		$mission = count(preg_split('/[\ \n\,]+/', $row[8], -1, PREG_SPLIT_NO_EMPTY));
		$other = count(preg_split('/[\ \n\,]+/', $row[9], -1, PREG_SPLIT_NO_EMPTY));
		$layoff = count(preg_split('/[\ \n\,]+/', $row[10], -1, PREG_SPLIT_NO_EMPTY));
		$arrest = count(preg_split('/[\ \n\,]+/', $row[11], -1, PREG_SPLIT_NO_EMPTY));
		$face = $row[2] - $miss;
		if ($duty === null) {
			$duty = "";
		}
		if ($trip === null) {
			$trip = "";
		}
		if ($hospital === null) {
			$hospital = "";
		}
		if ($ill === null) {
			$ill = "";
		}
		if ($mission === null) {
			$mission = "";
		}
		if ($other === null) {
			$other = "";
		}
		if ($layoff === null) {
			$layoff = "";
		}
		if ($arrest === null) {
			$arrest = "";
		}
	}

	else{
		$dutyArray = explode(' ', $row[4]);
		$duty = '';
		foreach ($dutyArray as $key => $value) {
			$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$value'";
			$res = $conn->query($sql);
			$dutyRow = $res->fetch();
			$duty = $duty.$dutyRow[0].' '.$dutyRow[1].'.'.$dutyRow[2].'.'.'<br>';
		}
		$tripArray = explode(' ', $row[5]);
		$trip = '';
		foreach ($tripArray as $key => $value) {
			$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$value'";	
			$res = $conn->query($sql);
			$tripRow = $res->fetch();
			$trip = $trip.$tripRow[0].' '.$tripRow[1].'.'.$tripRow[2].'.'.'<br>';
		}
		$hospitalArray = explode(' ', $row[6]);
		$hospital = '';
		foreach ($hospitalArray as $key => $value) {
			$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$value'";
			$res = $conn->query($sql);
			$hospitalRow = $res->fetch();
			$hospital = $hospital.$hospitalRow[0].' '.$hospitalRow[1].'.'.$hospitalRow[2].'.'.'<br>';
		}
		$illArray = explode(' ', $row[7]);
		$ill = '';
		foreach ($illArray as $key => $value) {
			$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$value'";
			$res = $conn->query($sql);
			$illRow = $res->fetch();
			$ill = $ill.$illRow[0].' '.$illRow[1].'.'.$illRow[2].'.'.'<br>';
		}
		$missionArray = explode(' ', $row[8]);
		$mission = '';
		foreach ($missionArray as $key => $value) {
			$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$value'";
			$res = $conn->query($sql);
			$missionRow = $res->fetch();
			$mission = $mission.$missionRow[0].' '.$missionRow[1].'.'.$missionRow[2].'.'.'<br>';
		}
	}
	
	
	echo '<tr class="table_row">';
	echo '<th scope="row" style="width:50px;">' . $i . "</th>";
	echo '<td class="item">' . $row[0] . "</td>";
	echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td>' . $face . '</td>';
	echo '<td>' . $miss . '</td>';
	echo '<td>' . $duty . "</td>";
	echo '<td>' . $trip . "</td>";
	echo '<td>' . $hospital . "</td>";
	echo '<td>' . $ill . "</td>";
	echo '<td>' . $mission . "</td>";
	echo '<td>' . $other . "</td>";
	echo '<td>' . $layoff . "</td>";
	echo '<td>' . $arrest . "</td>";
	echo "</tr>";
	$i = $i+1;
	if ($full == 0) {
		$sumShtat = $sumShtat + $row[1];
		$sumSpisok = $sumSpisok + $row[2];
		$sumFace = $sumFace + $face;
		$sumMiss = $sumMiss + $row[3];
		$sumDuty = $sumDuty + $row[4];
		$sumTrip = $sumTrip + $row[5];
		$sumHospital = $sumHospital + $row[6];
		$sumIll = $sumIll + $row[7];
		$sumMission = $sumMission + $mission;
	}
	else {
		$sumShtat = $sumShtat + $row[1];
		$sumSpisok = $sumSpisok + $row[2];
		$sumFace = $sumFace + $face;
		$sumMiss = $sumMiss + $miss;
		$sumDuty = $sumDuty + $duty;
		$sumTrip = $sumTrip + $trip;
		$sumHospital = $sumHospital + $hospital;
		$sumIll = $sumIll + $ill;
		$sumMission = $sumMission + $mission;
		$sumOther = $sumOther + $other;
		$sumLayoff = $sumLayoff + $layoff;
		$sumArrest = $sumArrest + $arrest;
	}
}
	echo '<tr class="table_row">';
	echo '<th scope="row" style="width:50px;">' . $i . "</th>";
	echo '<td class="item">Итого</td>';
	echo '<td>' . $sumShtat . '</td>';
	echo '<td>' . $sumSpisok . '</td>';
	echo '<td>' . $sumFace . '</td>';
	echo '<td>' . $sumMiss . '</td>';
	echo '<td>' . $sumDuty . "</td>";
	echo '<td>' . $sumTrip . "</td>";
	echo '<td>' . $sumHospital . "</td>";
	echo '<td>' . $sumIll . "</td>";
	echo '<td>' . $sumMission . "</td>";
	echo '<td>' . $sumOther . "</td>";
	echo '<td>' . $sumLayoff . "</td>";
	echo '<td>' . $sumArrest . "</td>";
	echo "</tr></tbody>";
?>