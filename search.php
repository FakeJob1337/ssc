<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>main</title>
	<link rel="stylesheet" type="text/css" href="css/search.css">
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
	<div class="content col-10 p-0">
	<div class="dropdown">
				<div class="check">
					<p class="m-0 p-1">Выбор<span class="arrow" style="float: right;">&#9660</span></p>
				</div>
				<div class="popup">
					<label><input disabled type='checkbox' name='column' class="all"><b>Выбрать все</b></label>
					<?php  
						session_start();
						$translator = [
							'surname' => 'Фамилия',
							'name' => 'Имя',
							'rank_shtat' => 'Звание по штату',
							'rank_fact' => 'Звание фактическое',
							'job' => 'Должность',
							'sr' => 'Тип службы',
							'pr2' => 'Подразделение',
							'birthday' => 'Дата рождения',
							'sex' => 'Пол',
							'is_conscripts' => 'Срочник?',
							'years_in_army' => 'Служит в армии лет',
							'job_assignment_date' => 'Дата присвоения должности',
							'job_order_number' => 'Номер приказа присвоения должности',
							'rank_assignment_date' => 'Дата присвоения звания',
							'rank_order_number' => 'Номер приказа присвоения должности',
							'telephone_number' => 'Номер телефона',
							'snills' => 'Снилс',
							'passport_series' => 'Серия паспорта',
							'passport_numbers' => 'Номер паспорта',
							'passport_issued_by' => 'Кем выдан паспорт',
							'military_card' => 'Военный билет',
							'speciality' => 'Специальность',
							'institution' => 'Учреждение',
							'year_of_graduation' => 'Год окончания обучения	',
							'personal_number' => 'Личный номер',
							'place_of_birth' => 'Место рождения',
							'nationality' => 'Национальность',
							'type_of_education' => 'Вид образование',
							'is_talent_pool' => 'В кадровом резерве?',
							'qualification_title' => 'Квалификационное звание',
							'contract_date' => 'Фамилия',
							'admission' => 'Допуск',
							'academic_degree' => 'Ученая степень',
							'marital_status' => 'Семейное положение',
							'drivers_license' => 'Водительское удостоверение номер',
							'drivers_license_sdate' => 'Водительское удостоверение дата с',
							'drivers_license_edate' => 'Водительское удостоверение дата по',
							'drivers_license_categories' => 'Водительское удостоверение категории',
							'contract_date_start' => 'Дата начала контракта',
							'contract_date_end' => 'Дата конца контракта',
						];
						$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
						$sql = "SELECT * FROM `shtat` LEFT JOIN `personal_information` ON shtat.id = personal_information.shtat_id";
						$result = $conn->query($sql);
						$row = $result->fetch(PDO::FETCH_ASSOC);
						
						foreach ($row as $key => $value) {
							$ru_value = $translator[$key];
							if (stristr($_SESSION['status'],"admin")) {
								echo "<label><input type='checkbox' name='column' value='$key' class ='col'>$ru_value</label>";
								continue;
							}
							if (stristr($_SESSION['status'],$row[0])) {
								echo "<label><input type='checkbox' name='column' value='$key' class ='col'>$ru_value</label>";
							} else{
							echo "<label><input disabled type='checkbox' name='column' value='$key' class ='col'>$ru_value</label>";
							}
						}
					?>
				</div>
			</div>
			<div class="dropdown">
				<div class="check">
					<p class="m-0 p-1">Фильтр<span class="arrow" style="float: right;">&#9660</span></p>
				</div>
				<div class="popup">
					<label><input disabled type='checkbox' name='column' class="all"><b>Выбрать все</b></label>
					<?php  
						$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
						$sql = "SELECT * FROM `shtat` LEFT JOIN `personal_information` ON shtat.id = personal_information.shtat_id";
						$result = $conn->query($sql);
						$row = $result->fetch(PDO::FETCH_ASSOC);
						foreach ($row as $key => $value) {
							$ru_value = $translator[$key];
							if (stristr($_SESSION['status'],"admin")) {
								echo "<label><input type='checkbox' name='filter' value='$key' class='filter' id='$key'>$ru_value</label>";
								continue;
							}
							if (stristr($_SESSION['status'],$row["pr2"])) {
								echo "<label><input type='checkbox' name='filter' value='$key' class='filter' id='$key'>$ru_value</label>";
							} else{
							echo "<label><input disabled type='checkbox' name='filter' value='$key' class='filter' id='$key'>$ru_value</label>";
							}
						}
					?>
				</div>
			</div>
			<button class="btn btn-secondary btn-sm" onclick="filter()">Сформировать</button>
			<div class="filterFields"></div>
			<div class="table">
				<table id="output">

				</table>
			</div>
	</div>
</div>
<script>

document.addEventListener("DOMContentLoaded", function() { 
	let filters = document.querySelectorAll('.filter')
	filters.forEach(filter => {
		filter.addEventListener("change",function(e) {
			console.log(this.checked ? createFilterField(this) : deleteFilterField(this));
		})
	}) 
})

// $(".filter").change(function (e) { 
// 	console.log($(this).is(':checked') + $(this).attr('id'));	
// });

function createFilterField(elem) {  
	const filterField = document.createElement('div');
	filterField.innerHTML = `<form>
				<label for="filter-select">Фильтр для ${elem.id}</label>
 				  <select name="col" id="filter-select">
 				    <option value="ASC">Возрастание</option>
 				    <option value="DESC">Убывание</option>
 				    <option value="EQUAL">Равно</option>
					<option value="LIKE">Содержит</option>
 				    <option value="GREATER">Больше</option>
					<option value="LESS">Меньше</option>
 				  </select>
				  <input type="text">
				</form>	
				`
	filterField.classList.add("filterField")
	filterField.classList.add(elem.id)
	content = document.querySelector(".filterFields")
	content.appendChild(filterField);
}

function deleteFilterField(elem) {
	filterField = document.querySelector(`.${elem.id}`)
	filterField.remove()
}

function filter() {
	let depsArray = new Array();
	$('input[name="column"]:checked').each(function() {depsArray.push(this.value);});
	let filters = {
		searchColumn: depsArray,
		filterColumn: [],
		methodColumn: [],
		valueColumn: []
	
	}
	let fields = document.querySelectorAll(".filterField")
	let c = 0
	fields.forEach(field => {
		let select = field.querySelector("select")
		let inp = field.querySelector("input")
		const classlist = field.classList
		let value = select.value
		filters["filterColumn"].push(classlist[1])
		filters["methodColumn"].push(value)
		filters["valueColumn"].push(inp.value)
	});
	$.ajax({
        type:"POST",
        url:"php_scripts/filter.php",
        data: {data:JSON.stringify(filters)},
        cache: false,
        success: function(responce){
        	$('table#output').html(responce);
        }
    })
}

</script>
</body>
</html>