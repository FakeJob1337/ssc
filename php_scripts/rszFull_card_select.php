<?php
$date = $_POST['date'];	
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

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
			<th scope="col">Подразделение</th>
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
	</thead><tbody>';

$ci = 1;
while($row = $result->fetch(PDO::FETCH_NUM)){
	$miss = count(preg_split('/[\ \n\,]+/', $row[3], -1, PREG_SPLIT_NO_EMPTY));
	$face = $row[2] - $miss;
	for ($i=3; $i < count($row); $i++) { 
		if (isset($row[$i])) {
			$id_array = explode(" ", $row[$i]);
			$array_with_names = [];
			foreach ($id_array as $value) {
				$sql = "SELECT surname, (SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', 1),1)),(SELECT LEFT(SUBSTRING_INDEX(`name`, ' ', -1),1)) FROM shtat WHERE id = '$value'";
				$id_result = $conn->query($sql);
				$name_str = "";
				while ($data_array = $id_result->fetch(PDO::FETCH_NUM)) {
					foreach ($data_array as $key => $data) {
						$name_str = $name_str." ".$data;

					}
					array_push($array_with_names, $name_str);
				}
			}

			$arr_to_change = &$row[$i];
			$array_with_names = join(", ", $array_with_names);
			$arr_to_change = $array_with_names;
		}
	}
	$value = null;
	// foreach ($row as $value) {
	// 	foreach ($value as $data_array) {
	// 			foreach ($data_array as $key => $data) {
	// 				echo $data;
	// 			}
	// 	}
	// }
			echo '<tr class="table_row">';
	echo '<th scope="row" style="width:50px;">' . $ci . "</th>";
	echo '<td class="item">' . $row[0] . "</td>";
	echo '<td>' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td>' . $face . '</td>';
	echo '<td>' . $miss . '</td>';
	echo '<td>' . $row[4] . "</td>";
	echo '<td>' . $row[5] . "</td>";
	echo '<td>' . $row[6] . "</td>";
	echo '<td>' . $row[7] . "</td>";
	echo '<td>' . $row[8] . "</td>";
	echo '<td>' . $row[9] . "</td>";
	echo '<td>' . $row[10] . "</td>";
	echo '<td>' . $row[11] . "</td>";
	echo "</tr>";
	$ci = $ci+1;
}
echo "</tbody>";
?>