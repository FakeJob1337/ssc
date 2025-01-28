<?php

$id = $_POST['id'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id FROM shtat WHERE id = '$id'";

$result = $conn->query($sql);

$row = $result->fetch();

echo "
<div><h3>Паспорт</h3></div>
<div class='form-group row'>
    <div class='col-2'>
        <label for='pr1'>Серия:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-2'>
        <label for='pr2'>Номер:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-2'>
        <label for='pr3'>Ксерокопии:</label>
        <input type='file' class='form-control' id='' readonly value='-'>
    </div>
</div>
<div><h3>Водительское</h3></div>
<div class='form-group row'>
    <div class='col-2'>
        <label for='job'>Номер:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-2'>
        <label for='job_date'>Действителен с:</label>
        <input type='date' class='form-control' id='' readonly value=''>
    </div>
    <div class='col-2'>
        <label for='job_num'>Действителен по:</label>
        <input type='date' class='form-control' id='' readonly value=''>
    </div>
    <div class='col-2'>
        <label for='job_num'>Категории:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-2'>
        <label for='job_num'>Ксерокопии:</label>
        <input type='file' class='form-control' id='' readonly value=''>
    </div>
</div>
<div><h3>Военный билет</h3></div>
<div class='form-group row'>
    <div class='col-3'>
        <label for='rank_shtat'>Номер:</label>
        <input type='text' class='form-control' id='' readonly value='-'>
    </div>
    <div class='col-3'>
        <label for='rank_fact'>Ксерокопии:</label>
        <input type='file' class='form-control' id='' readonly value=''>
    </div>
</div>
";
?>