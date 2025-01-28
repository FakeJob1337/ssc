<?php
$id = $_POST['id'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT job,pr1,pr2,pr3,pr4,pr5,id FROM shtat WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch();
echo "<div class = 'text form-group row mb-4' id = '$row[6]'>
<div class='col-2'><input class='form-control' type='text' value='$row[0]' disabled readonly></div>
<div class='col-2'><input class='form-control' type='text' value='$row[2]' disabled readonly></div>
<div class='col-2'><input class='form-control' type='text' value='$row[3]' disabled readonly></div>
<div class='col-2'><input class='form-control' type='text' value='$row[4]' disabled readonly></div>
<div class='col-2'><input class='form-control' type='text' value='$row[5]' disabled readonly></div>
</div>";
?>