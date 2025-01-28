<?php

$id = $_POST['id'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');

$sql = "SELECT id, rank_fact, pr2, pr3, pr4, pr5, job, rank_shtat FROM shtat WHERE id = '$id'";

$result = $conn->query($sql);

$row = $result->fetch();

echo "
<div><h3>Принадлежность</h3></div>
<div class='form-group row'>
    <div class='col-2'>
        <label for='pr1'>ПР1:</label>
        <input type='text' class='form-control' id='pr1' readonly value='".$row[2]."'>
    </div>
    <div class='col-2'>
        <label for='pr2'>ПР2:</label>
        <input type='text' class='form-control' id='pr2' readonly value='".$row[3]."'>
    </div>
    <div class='col-2'>
        <label for='pr3'>ПР3:</label>
        <input type='text' class='form-control' id='pr3' readonly value='".$row[4]."'>
    </div>
    <div class='col-2'>
        <label for='pr4'>ПР4:</label>
        <input type='text' class='form-control' id='pr4' readonly value='".$row[5]."'>
    </div>
</div>
<div><h3>Должность</h3></div>
<div class='form-group row'>
    <div class='col-2'>
        <label for='job'>Должность:</label>
        <input type='text' class='form-control' id='job' readonly value='".$row[6]."'>
    </div>
    <div class='col-3'>
        <label for='job_date'>Дата присвоения:</label>
        <input type='date' class='form-control' id='job_date' readonly value='".$row[8]."'>
    </div>
    <div class='col-3'>
        <label for='job_num'>Номер приказа:</label>
        <input type='text' class='form-control' id='job_num' readonly value='-'>
    </div>
</div>
<div><h3>Звание</h3></div>
<div class='form-group row'>
    <div class='col-3'>
        <label for='rank_shtat'>Звание по штату:</label>
        <input type='text' class='form-control' id='rank_shtat' readonly value='".$row[7]."'>
    </div>
    <div class='col-3'>
        <label for='rank_fact'>Звание по факту:</label>
        <input type='text' class='form-control' id='rank_fact' readonly value='".$row[1]."'>
    </div>
    <div class='col-3'>
        <label for='rank_date'>Дата присвоения:</label>
        <input type='date' class='form-control' id='rank_date' readonly value='".$row[8]."'>
    </div>
    <div class='col-3'>
        <label for='rank_num'>Номер приказа:</label>
        <input type='text' class='form-control' id='rank_num' readonly value='-'>
    </div>
</div>
";
?>