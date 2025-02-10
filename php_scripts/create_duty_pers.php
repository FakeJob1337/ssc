<?php
$dep = $_POST['departament'];
$deps = join("', '",$dep);
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT `id`, `surname`,`name` ,`rank_fact`,`job`, `pr2` FROM `shtat` WHERE pr2 IN ('$deps') ORDER BY surname ASC";
$result = $conn->query($sql);

echo "<table class='table table-hover table-scroll mt-5'";
// echo "<thead class='table-dark'>
// 		<tr>
// 			<th scope='col' style='width:50px;'>Подразделение</th>
// 			<th scope='col'>Должность</th>
// 			<th scope='col'>Фамилия</th>
// 			<th scope='col'>Начало</th>
// 			<th scope='col'>Кол-во дней</th>
// 		</tr>
// 	</thead>";
echo '<tbody>';
while($row = $result->fetch(PDO::FETCH_NAMED)){
    $id = $row['id'];
    echo 
        "
        <tr>
            <td class='item' style='display: none;'>".$id."</td> 
            <td class='item'>".$row['pr2']."</td>
            <td class='item'>".$row['job']."</td>
            <td class='item'>".$row['surname']."</td>
            <td class='item'><input type='date' class='form-control' name='start' bdid='$id'></td>
            <td class='item'>
                <input type='text' bdid='$id' class='form-control' name='days'>
                
            </td>
            <td class='add_btn'><button type='button' class='btn btn-info'>+</button></td>
            <td class='spec_btn'><button type='button' class='btn btn-info change'>Особый</button></td>
        </tr>
        ";
}
echo '</tbody>';
echo "</table>";
	