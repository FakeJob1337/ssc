<?php
$value = $_POST['selectValue'];
$select = $_POST['selectId'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

if ($select == 'pr2') {
	$sql = "SELECT DISTINCT pr2 FROM shtat GROUP BY pr2 ASC";
}
elseif ($select == 'pr3') {
	$sql = "SELECT DISTINCT pr3 FROM shtat WHERE pr2 = '$value[0]' GROUP BY pr3 ASC";
}
elseif ($select == 'pr4') {
	$sql = "SELECT DISTINCT pr4 FROM shtat WHERE pr2 = '$value[0]' AND pr3 = '$value[1]' GROUP BY pr4 ASC";
}
elseif ($select == 'pr5') {
	$sql = "SELECT DISTINCT pr5 FROM shtat WHERE pr2 = '$value[0]' AND pr3 = '$value[1]' AND pr4 = '$value[2]' GROUP BY pr5 ASC";
}

else {
	return;
}

$result = $conn->query($sql);
echo "<div class='col-3'>
<select class = 'selectFilter form-select' id = '$select' onchange = 'getNextFilter(this.id)' style='width: 300px;'><option>Выберите подразделение</option>";
while($row = $result->fetch()){
	echo "<option value = '$row[0]'>".$row[0]."</option>";
}
echo "</select></div>";
?>