<?php

$dep = $_POST['departament'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$pr = 'pr2';

if ($dep == 'Управление') {
	$pr = 'pr1';
}

$sql = "SELECT id, surname, (SELECT SUBSTRING_INDEX(`name`, ' ', 1)),(SELECT SUBSTRING_INDEX(`name`, ' ', -1)), rank_fact
FROM shtat WHERE $pr = '$dep' AND surname != 'ВАКАНТ'";

$result = $conn->query($sql);
echo 
'<thead class="table-dark">
	<tr>
		<th scope="col" style="width:50px;">№</th>
		<th scope="col" class="item" id="surname">Фамилия</th>
		<th scope="col" class="item" id="name">Имя</th>
		<th scope="col" class="item" id="secname">Отчество</th>
		<th scope="col" class="item" id="rank_shtat">Звание</th>
		<th scope="col" class="item"></th>
	</tr>
</thead><tbody>';

$i = 1;
while($row = $result->fetch()){
	
	echo '<tr class="table_row">';
	echo '<th scope="row" style="width:50px;">' . $i . '</th>';
	echo '<td class="item" id="'.$row[0].'">' . $row[1] . '</td>';
	echo '<td>' . $row[2] . '</td>';
	echo '<td>' . $row[3] . '</td>';
	echo '<td>' . $row[4] . '</td>';
	echo '<td><select class="rsz">
	<option name="rsz" value="Налицо '.$row[0].'">На лицо</option>
	<option name="rsz" value="Отпуск '.$row[0].'">Отпуск</option>
	<option name="rsz" value="Командировка '.$row[0].'">Командировка</option>
	<option name="rsz" value="Госпиталь '.$row[0].'">Госпиталь</option>
	<option name="rsz" value="Болен '.$row[0].'">Болен</option>
	<option name="rsz" value="Наряд '.$row[0].'">Наряд</option>
	<option name="rsz" value="Прочее '.$row[0].'">Прочее</option>
	<option name="rsz" value="Увольнение '.$row[0].'">Увольнение</option>
	<option name="rsz" value="Арест '.$row[0].'">Арест</option>
	</select></td>';
	echo "</tr>";
	$i = $i+1;
}
echo "</tbody>";

?>