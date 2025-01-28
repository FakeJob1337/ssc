<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/RSZ.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<title>Расход</title>
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
			<h1>Развернутая строевая записка ССЦ</h1>
		</header>
		<div class="menu p-3">
			<button type="button" id="add" class="btn btn-primary">
				<i class="fa fa-plus fa-2x" aria-hidden="true"></i><br><p class="mb-0">Добавить</p>
			</button>
			<button type="button" class="btn btn-success" id="btnExel">
				<i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Exel</p>
			</button>
			<button type="button" class="btn btn-info" id="btnWord">
				<i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Word</p>
			</button>
		</div>
		<div class="form-group row m-2 align-items-end">
			<div class="col-2">
				<label for="date">Выбрать дату:</label>
				<input type="date" class="form-control datepicker" id="date">
			</div>
			<div class="col-2">
				<button class="btn btn-secondary btn-sm" id="sub">Сформировать</button>
			</div>
		</div>
		<table class="table table-hover table-scroll mt-3" id="output">
		</table>
	</div>
</div>

<script>

$("#add").on( "click", function() {
  window.location.href = "rsz_add_card.php";
});

$('#sub').on('click',()=>{
	date = $('#date').val();
	$.ajax({
		type:"POST",
		url:"php_scripts/print_full_rsz.php",
		data: {"date":date},
		cache: false,
		success: function(responce){ 
			$('table#output').html(responce);
		}
	})
})

$('#output').css('cursor','pointer');
$('#output').on('click','.table_row',function(){
	a = $(this).find('.item').attr('id');
	var date = $(this).find('.item').html();
	window.open("rsz_card.php?date="+date).focus();
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

function exportTableToExcel(tableId, filename = 'Рсз общая.xls') {
    let dataType = 'application/vnd.ms-exel';
    let tableSelect = document.getElementById(tableId);
    let tableHTML = encodeURIComponent(tableSelect.outerHTML.replace(/ or .*?>/g, '>'));
    let link = document.createElement("a");
    link.href = `data:${dataType}, ${tableHTML}`;
    link.download = filename;
    link.click();
}

function exportTableToWord(tableId, filename = 'Рсз общая.docx') {
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
