<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/RSZ.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<title></title>
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
			<h1>Развернутая строевая записка CСЦ на <?php echo $_GET['date']; ?></h1>
		</header>
		<div>
			<div class="menu">
				<button type="button" class="btn btn-secondary" id="rsz">Развернутая строевая</button>
				<button type="button" class="btn btn-secondary" id="rszFull">Самая развернутая</button>
				<button type="button" class="btn btn-secondary" id="rashod">Расход</button>
				<button type="button" class="btn btn-success" id="btnExel">
					<i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Exel</p>
				</button>
				<button type="button" class="btn btn-info" id="btnWord">
					<i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Word</p>
				</button>
				<div class="dropdown">
					<div class="check">
						<p class="m-0 p-1">Принадлежность<span class="arrow" style="float: right;">&#9660</span></p>
					</div>
					<div class="popup">
						<label><input type='checkbox' name='departament' class="all" disabled><b>Выбрать все</b></label>
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
				
			</div>
			<table class="table table-hover table-scroll mt-3" id="output">
			</table>
			<table class="iksweb" id="iksweb">
			</table>
		</div>
	</div>
<script>
	const url = new URLSearchParams(window.location.search)
    const date = url.get('date');
	$('#rsz').on('click',()=>{
		$.ajax({
			type:"POST",
			url:"php_scripts/rsz_card_select.php",
			data:{"date": date,"full": 1},
			cache: false,
			success: function(responce){
				$('table#iksweb').empty()
				$('table#output').html(responce);
			}
		})
	})

	$('#rszFull').on('click',()=>{
		$.ajax({
			type:"POST",
			url:"php_scripts/rszFull_card_select.php",
			data:{"date": date,"full": 0},
			cache: false,
			success: function(responce){
				$('table#iksweb').empty()
				$('table#output').html(responce);
			}
		})
	})

	$('#rashod').on('click',()=>{
		depsArray = new Array();
		$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
		$.ajax({
			type:"POST",
			url:"php_scripts/select_rashod.php",
			data:{"date": date, "departament[]":depsArray},
			cache: false,
			success: function(responce){
				$('table#output').empty();
				$('table#iksweb').html(responce);
				// $('.ans').each(()=>{
				// 	let td = $(this).text();
				// 	if (!td) {
				// 		$(this).text("0");
				// 	}
				// })
			}
		})
	})


$('#controls_dep input:checkbox').click(function(){
					if($(this).is(':checked')){
						$('#checkbox_dep').prop('checked',false);
					} else{
						$('#checkbox_dep').prop('checked',false);
					}
				});
				$('#checkbox_dep').click(function(){
					if ($(this).is(':checked')){
						$('#controls_dep input:checkbox').prop('checked', true);
					} else {
						$('#controls_dep input:checkbox').prop('checked', false);
					}
				});

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

function exportTableToExcel(tableId, filename = 'рсз на '+date+'.xls') {
    let dataType = 'application/vnd.ms-exel';
    let tableSelect = document.getElementById(tableId);
    let tableHTML = encodeURIComponent(tableSelect.outerHTML.replace(/ or .*?>/g, '>'));
    let link = document.createElement("a");
    link.href = `data:${dataType}, ${tableHTML}`;
    link.download = filename;
    link.click();
}

function exportTableToWord(tableId, filename = 'рсз на '+date+'.docx') {
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