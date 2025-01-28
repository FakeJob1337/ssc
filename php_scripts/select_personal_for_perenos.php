<?php
$value = $_POST['selectValue'];
$select = $_POST['selectId'];
$vakant = $_POST['vakant'];

$sqlText = 'SELECT rank_shtat, surname, (SELECT SUBSTRING_INDEX(`name`, " ", 1)), (SELECT SUBSTRING_INDEX(`name`, " ", -1)), job, id
	FROM
	    shtat
	WHERE';


$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sqlVakantText = '';
$btnText = 'Перенести';
if ($vakant) {
	$sqlVakantText = "AND (surname = 'ВАКАНТ' OR surname = '')";
	$btnText = 'Выбрать';
}

if($select == 'pr2'){
    $sql = "".$sqlText." pr2 = '$value[0]' ".$sqlVakantText."";
}

elseif($select == 'pr3'){
    $sql = "".$sqlText." pr2 = '$value[0]' AND pr3 = '$value[1]' ".$sqlVakantText."";
}

elseif($select == 'pr4'){
    $sql = "".$sqlText." pr2 = '$value[0]' AND pr3 = '$value[1]' AND pr4 = '$value[2]' ".$sqlVakantText."";
}

elseif($select == 'pr5'){
    $sql = "".$sqlText." pr2 = '$value[0]' AND pr3 = '$value[1]' AND pr4 = '$value[2]' AND pr5 = '$value[3]' ".$sqlVakantText."";
}

$result = $conn->query($sql);

	echo '<thead class="table-dark">
			<tr>
				<th scope="col">Звание по штату</strong></th>
				<th scope="col">Фамилия</strong></th>
				<th scope="col">Имя</strong></th>
				<th scope="col">Отчество</strong></th>
				<th scope="col">Должность</strong></th>
				<th></th>
			</tr>
			</thead><tbody>';

	while($row = $result->fetch()){
		echo "<tr class='table_row'>
				<td>" . $row[0] . "</td>
				<td>" . $row[1] . "</td>
				<td>" . $row[2] . "</td>
				<td>" . $row[3] . "</td>
				<td>" . $row[4] . "</td>
				<td><button class='btn btn-secondary btn-sm' onclick = 'perenos(this.value)' value='".$row[5]."'>".$btnText."</button></td>
		</tr>";
	}

	echo "</tbody>";
?>