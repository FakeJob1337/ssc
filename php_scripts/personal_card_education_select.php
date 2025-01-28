<?php

$id = $_POST['id'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id FROM shtat WHERE id = '$id'";

$result = $conn->query($sql);

$row = $result->fetch();

echo "
<div><h3>Образование</h3></div>
<div class='form-group row'>
    <div class='col-2'>
        <label for=''>Специальность:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-2'>
        <label for=''>Учереждение:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-2'>
        <label for=''>Год окончания:</label>
        <input type='date' class='form-control' id='' readonly value=''>
    </div>
    <div class='col-2'>
        <label for=''>Ксерокопии:</label>
        <input type='file' class='form-control' id='' readonly value=''>
    </div>
</div>
<div><h3>Доп. образование</h3></div>
";
?>