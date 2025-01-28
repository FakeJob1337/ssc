<?php
$dep = $_POST['departament'];
$rank = $_POST['rank'];

$deps = join("', '",$dep);
$ranks = join("', '",$rank);
$id = $_POST['id'];
$type = $_POST['type'];
$arrow = $_POST['arrow'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id, surname, (SELECT SUBSTRING_INDEX(`name`, ' ', 1)),(SELECT SUBSTRING_INDEX(`name`, ' ', -1)), rank_shtat, job, pr2, pr3, pr4, pr5, sr
FROM shtat WHERE pr2 IN ('$deps') AND rank_shtat IN ('$ranks')
ORDER BY `$id` $type";

$result = $conn->query($sql);

echo 
'<thead class="table-dark">
	<tr class="table_row_head">
		<th scope="col" style="width:50px;">№</th>
		<th scope="col" class="item" id="surname">Фамилия</th>
		<th scope="col" class="item" id="name">Имя</th>
		<th scope="col" class="item" id="secname">Отчество</th>
		<th scope="col" class="item" id="rank_shtat">Звание</th>
		<th scope="col" class="item" id="job">Должность</th>
		<th scope="col" class="item" id="pr2">Подразделение1</th>
		<th scope="col" class="item" id="pr3">Подразделение2</th>
		<th scope="col" class="item" id="pr4">Подразделение3</th>
		<th scope="col" class="item" id="pr5">Подразделение4</th>
		<th scope="col" class="item" id="sr">Тип службы</th>
	</tr>
</thead><tbody>';
$i = 1;
while($row = $result->fetch()){
	
	echo '<tr class="table_row">';
	echo '<th scope="row" style="width:50px;">' . $i . "</th>";
	echo '<td class="item" id="'.$row[0].'">' . $row[1] . "</td>";
	echo '<td>' . $row[2] . "</td>";
	echo '<td>' . $row[3] . "</td>";
	echo '<td>' . $row[4] . "</td>";
	echo '<td>' . $row[5] . "</td>";
	echo '<td>' . $row[6] . "</td>";
	echo '<td>' . $row[7] . "</td>";
	echo '<td>' . $row[8] . "</td>";
	echo '<td>' . $row[9] . "</td>";
	echo '<td>' . $row[10] . "</td>";
	echo "</tr>";
	$i = $i+1;
}
echo "</tbody>";
?>