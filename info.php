<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<title>МЧC</title>
</head>
<body>
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
		<header class="p-3">
			<h1>Информация о военнослужащих</h1>
		</header>
		<div class="menu p-3">
			<button type="button" id="add_people" class="btn btn-primary">
				<i class="fa fa-plus fa-2x" aria-hidden="true"></i><br><p class="mb-0">Человека</p>
			</button>
			<button type="button" id="add_vacancy" class="btn btn-primary">
				<i class="fa fa-plus fa-2x" aria-hidden="true"></i><br><p class="mb-0">Вакансию</p>
			</button>
			<button type="button" class="btn btn-success" id="btnExel">
				<i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Exel</p>
			</button>

			<button type="button" class="btn btn-info" id="btnWord">
				<i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Word</p>
			</button>
		</div>
		<div class="type mt-4 p-3">
			<div class="dropdown">
				<div class="check">
					<p class="m-0 p-1">Принадлежность<span class="arrow" style="float: right;">&#9660</span></p>
				</div>
				<div class="popup">
					<label><input disabled type='checkbox' name='departament' class="all"><b>Выбрать все</b></label>
					<?php  
						session_start();
						$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
						$sql = "SELECT DISTINCT pr2 FROM shtat ORDER BY `shtat`.`pr2` ASC";
						$result = $conn->query($sql);
						while($row = $result->fetch()){
							if (stristr($_SESSION['status'],"admin")) {
								echo "<label><input type='checkbox' name='departament' value='$row[0]'>$row[0]</label>";
								continue;
							}
							if (stristr($_SESSION['status'],$row[0])) {
								echo "<label><input type='checkbox' name='departament' value='$row[0]'>$row[0]</label>";
							} else{
							echo "<label><input disabled type='checkbox' name='departament' value='$row[0]'>$row[0]</label>";
							}
						}
					?>
				</div>
			</div>

			<div class="dropdown">
				<div class="check">
					<p class="m-0 p-1">Звание<span class="arrow" style="float: right;">&#9660</span></p>
				</div>
				<div class="popup">
					<label><input type='checkbox' name='departament' class="all"><b>Выбрать все</b></label>
					<?php  
						$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
						$sql = "SELECT DISTINCT rank_shtat FROM shtat ORDER BY `shtat`.`rank_shtat` ASC";
						$result = $conn->query($sql);
						while($row = $result->fetch()){
							echo "<label><input  type='checkbox' name='rank' value='$row[0]'>$row[0]</label>";
						}
					?>
				</div>
			</div>
			<button class="btn btn-secondary btn-sm" onclick="get_pers()">Сформировать</button>
			<button class="btn btn-secondary btn-sm" id="search">Расширенный поиск</button>
		</div>

		<div class="content mt-3">
			<table class="table table-hover table-scroll" id="output">
			</table>
		</div>
	</div>
</div>
<!-- <script src="js/authZ.js"></script> -->
<script>
$(document).ready(function () {
    $(".all").click(function () {
     	if ($(this).is(':checked')){
        	$(this).parent().parent().children().children().prop('checked', true);
    	}
    	else{
			$(this).parent().parent().children().children().prop('checked', false);
		}
    })
});

$(function () {
  $(".dropdown").hover(onIn, onOut);
});

function onIn() {
	$(this).find('span.arrow').toggleClass('active');
}
function onOut() {
	$(this).find('span.arrow').toggleClass('active');
}

$("#add_people").on( "click", function() {
  window.location.href = "personal_card_add.php";
} );

$("#add_vacancy").on( "click", function() {
  window.location.href = "vacancy_card_add.php";
} );
$("#search").on( "click", function() {
  window.location.href = "search.php";
} );


function get_pers(){
	depsArray = new Array();
	ranksArray = new Array();
	$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
	$('input[name="rank"]:checked').each(function() {ranksArray.push(this.value);});
	$.ajax({
		type:"POST",
		url:"php_scripts/select.php",
		data: {"departament[]":depsArray,"rank[]":ranksArray},
		cache: false,
		success: function(responce){ 
			$('table#output').html(responce);
		}
	})
}

$('#output').css('cursor','pointer');
$('#output').on('click','.table_row',function(){
	a = $(this).find('.item').attr('id');
	window.open("personal_card.php?id="+a, '_blank').focus();
})

$(function(){
	$('#output').on('click','.item',function(){
	a = $(this).attr('id');
	if ($(this).attr('value') != 'DESC') {
		b = 'DESC';
		c = '&#9650;';
	}
	else{
		b = 'ASC';
		c = '&#9660;';
	}
	depsArray = new Array();
	ranksArray = new Array();
	$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
	$('input[name="rank"]:checked').each(function() {ranksArray.push(this.value);});
		$.ajax({
			type:"POST",
			url:"php_scripts/order.php",
			data: {"departament[]":depsArray,"rank[]":ranksArray, "id":a, "type":b, "arrow":c},
			cache: false,
			success: function(responce){ 
				$('table#output').html(responce);
				$('th#'+a).append(c);
				$('th#'+a).attr('value',''+b)
			}
		})
	})
})

$(document).ready(function () {
 $("#btnExel").click(function () {
    exportTableToExcel('output');
 })
});

$(document).ready(function () {
 $("#btnWord").click(function () {
    exportTableToWord('output');
 })
});

function exportTableToExcel(tableId, filename = 'Штат.xls') {
    let dataType = 'application/vnd.ms-exel';
    let tableSelect = document.getElementById(tableId);
    let tableHTML = encodeURIComponent(tableSelect.outerHTML.replace(/ or .*?>/g, '>'));
    let link = document.createElement("a");
    link.href = `data:${dataType}, ${tableHTML}`;
    link.download = filename;
    link.click();
}

function exportTableToWord(tableId, filename = 'Штат.docx') {
    let dataType = 'application/vnd.ms-word';
    let tableSelect = document.getElementById(tableId);
    let tableHTML = encodeURIComponent(tableSelect.outerHTML.replace(/ or .*?>/g, '>'));
    let link = document.createElement("a");
    link.href = `data:${dataType}, ${tableHTML}`;
    link.download = filename;
    link.click();
}
</script>
</body>
</html>