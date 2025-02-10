<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Добавить доп сведения</title>
    <link rel="stylesheet" href="css/style_info.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php

$id = $_GET['id'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT surname, (SELECT SUBSTRING_INDEX(`name`, ' ', 1)), (SELECT SUBSTRING_INDEX(`name`, ' ', -1)), birthday from shtat WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch();
?>

<div class="container-fluid row h-100">
    <div class="sidenav col-2 h-100 p-0">
        <img src="image/mchs.png" width ="70px" class="mx-auto d-block mb-3 mt-3">
        <div class="menuhref d-flex align-items-center p-2"><a href="main.html" id="first">Главная страница</a></div>
        <div class="menuhref d-flex align-items-center p-2"><a href="info.php">Информация о военнослужащих</a></div>
        <div class="menuhref d-flex align-items-center p-2"><a href="#">Учет служебного времени</a></div>
        <div class="menuhref d-flex align-items-center p-2"><a href="duty.php">График отпусков</a></div>
        <div class="menuhref d-flex align-items-center p-2"><a href="RSZ.php">Расход л/с подразделений</a></div>
        <div class="menuhref d-flex align-items-center p-2"><a href="index.php">Выход</a></div>
    </div>
    <div class="content col-10 p-4">
        <div class="form-group row m-1 align-items-center">
             <div>
                <h2>Служебная информация</h2>
            </div>
            <div class="col-2">
                <label for="job_assignment_date">Дата присвоения должности</label>
                <input type="date" class="form-control" id="job_assignment_date" value="">
            </div>
            <div class="col-2">
                <label for="job_order_number">Номер приказа присвоения должности</label>
                <input type="text" class="form-control" id="job_order_number" value="">
            </div>
            <div class="col-2">
                <label for="rank_assignment_date">Дата присвоения звания</label>
                <input type="date" class="form-control" id="rank_assignment_date" value="">
            </div>
            <div class="col-2">
                <label for="rank_order_number">Номер приказа присвоения звания</label>
                <input type="text" class="form-control" id="rank_order_number" value="">
            </div>
            <div class="col-2">
                <label for="contract_date">Дата контракта (начало и конец)</label>
                <input type="text" class="form-control" id="contract_date" placeholder="dd-mm-yyyy,dd-mm-yyyy" value="">
                
            </div>
            <div class="col-2">
                <label for="qualification_title">Квалификационное звание</label>
                <input type="text" class="form-control" id="qualification_title" value="">
            </div>
            <div class="col-2">
                <label for="is_talent_pool">В кадровом резерве</label>
                <input type="text" class="form-control" id="is_talent_pool" value="">
            </div>
            <!-- <div class="col-2">
                <label for="participation_in_operations">Участие в операциях</label>
                <input type="text" class="form-control" id="participation_in_operations" value="">
            </div> -->
            <div class="col-2">
                <label for="admission">Допуск</label>
                <input type="text" class="form-control" id="admission" value="">
            </div>

            <div>
                <h2>Личные данные</h2>
            </div>
            <div class="col-2">
                <label for="personal_number">Личный номер</label>
                <input type="text" class="form-control" id="personal_number" value="">
            </div>
            <div class="col-2">
                <label for="place_of_birth">Место рождения</label>
                <input type="text" class="form-control" id="place_of_birth" value="">
            </div>
            <div class="col-2">
                <label for="nationality">Национальность</label>
                <input type="text" class="form-control" id="nationality" value="">
            </div>
            <div class="col-2">
                <label for="marital_status">Семейное положение</label>
                <input type="text" class="form-control" id="marital_status" value="">
            </div>
            <div class="col-2">
                <label for="telephone_number">Номер телефона</label>
                <input type="text" class="form-control" id="telephone_number" value="">
            </div>
            <div>
                <h2>Документы</h2>
            </div>
            <div class="col-2">
                <label for="snills">СНИЛС</label>
                <input type="text" class="form-control" id="snills" value="">
            </div>
            <div class="col-2">
                <label for="passport_series">Серия паспорта</label>
                <input type="text" class="form-control" id="passport_series" value="">
            </div>
            <div class="col-2">
                <label for="passport_numbers">Номер паспорта</label>
                <input type="text" class="form-control" id="passport_numbers" value="">
            </div>
            <div class="col-2">
                <label for="passport_issued_by">Кем выдан паспорт</label>
                <input type="text" class="form-control" id="passport_issued_by" value="">
            </div>
            <div class="col-2">
                <label for="military_card">Военный билет</label>
                <input type="text" class="form-control" id="military_card" value="">
            </div>

            <div>
                <h2>Образование и квалификация</h2>
            </div>
            <div class="col-2">
                <label for="speciality">Специальность</label>
                <input type="text" class="form-control" id="speciality" value="">
            </div>
            <div class="col-2">
                <label for="institution">Учреждение</label>
                <input type="text" class="form-control" id="institution" value="">
            </div>
            <div class="col-2">
                <label for="academic_degree">Ученая степень</label>
                <input type="text" class="form-control" id="academic_degree" value="">
            </div>
            <div class="col-2">
                <label for="year_of_graduation">Год окончания обучения</label>
                <input type="date" class="form-control" id="year_of_graduation" value="">
            </div>
            <div class="col-2">
                <label for="type_of_education">Вид образования</label>
                <input type="text" class="form-control" id="type_of_education" value="">
            </div>
            <div class=>
                <button type="button" class="btn btn-primary" id="add">Добавить</button>
            </div>
<!--        
            <div>
                <h2>История работы</h2>
            </div>
            <div class="col-2">
                <label for="history_of_work">Айди на историю работы</label>
                <input type="text" class="form-control" id="history_of_work" value="">
            </div> -->
        </div>
          <footer>
          </footer>
        </div>
    </div>
<script>
const submitBtn = document.getElementById('add');
submitBtn.onclick = () => {
    const inputElements = document.querySelectorAll('input')
    const inputValues = {}
    const url = new URLSearchParams(window.location.search)
    let id = url.get('id');
    inputValues["shtat_id"] = id;
    inputElements.forEach(input => { inputValues[input.id] = input.value;})
    console.log(inputValues);
    $.ajax({
        type:"POST",
        url:"php_scripts/add_personal_info.php",
        data: {data:JSON.stringify(inputValues)},
        cache: false,
        success: function(responce){
        	alert("Добавлено")
        }
    })
}
</script>
</body>