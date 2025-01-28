<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/3.1.0/chartjs-plugin-annotation.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

	<title>График отпусков</title>
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/duty.css">
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
			<h1>График отпусков</h1>
		</header>
		<div class="menu p-3">
			<button type="button" id="add" class="btn btn-primary">
				<i class="fa fa-plus fa-2x" aria-hidden="true"></i><br><p class="mb-0">Добавить</p>
			</button>
			<a id="download"
        download="ChartImage.jpg" 
        href=""
        class="btn btn-primary float-right bg-flat-color-1"
        title="Скачать График">

        <!-- Download Icon -->
 <i class="fa fa-download"></i>
 </a>
		</div>
			<div class="view">
				<button id="select_duty" onclick="get_duty_tb()">Таблица</button>
				<button id="select_graph" onclick="selectDuty_graph()">График</button>
				<!-- <button id="select_pers_graph" onclick="selectDutyGraphPers()">л/c</button> -->
			</div>
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
				<!-- <div class="dropdown">
					<div class="check">
						<p class="m-0 p-1">Принадлежность<span class="arrow" style="float: right;">&#9660</span></p>
					</div>
					<div class="popup">
						<label><input type='checkbox' name='departament' class="all"><b>Выбрать все</b></label>
							<?php  
								$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
								$sql = "SELECT DISTINCT pr2 FROM shtat ORDER BY `shtat`.`pr2` ASC";
								$result = $conn->query($sql);
								while($row = $result->fetch()){
									echo "<label><input type='checkbox' name='departament' value='$row[0]'>$row[0]</label>";
								}
							?>
					</div>
				</div> -->


				<div class="spisok">
					<table class="iksweb" id="output">
					</table>
				</div>
				<div id="div-canv">
						<canvas id="myChart"></canvas>
				</div>
			</div>		
				<br>
				<br>
		</div>
	</div>
</div>
<script>
// function selectDutyGraphPers(arguments) {
// 	depsArray = new Array();
// 	$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});

// }

function selectDuty_graph(){
	$(".spisok").hide();
	depsArray = new Array();
	$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
	$.ajax({
		type:"POST",
		url:"php_scripts/get_shtat.php",
		data: {"departament[]": depsArray},
		cache: false,
		success: function(response){ 
			window.shtat = response
			$.ajax({
		type:"POST",
		url:"php_scripts/get_duty_dates.php",
		data: {"departament[]": depsArray},
		cache: false,
		success: function(response){ 
			let people = window.shtat
			var data = JSON.parse(response);
			let keys = Object.keys(data);
			let values = Object.values(data);
			var ctx = document.getElementById('myChart').getContext('2d');
				window.myChart = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: keys,
			        datasets: [{
			            label: "График отпусков",
			            backgroundColor: 'rgb(227,38,54)',
			            borderColor: 'grey',
			            data: values,
			            pointBackgroundColor:'rgb(227,38,54)',
			        },
					{
			            label: depsArray.length < 12 ? depsArray : "Весь центр",
			            backgroundColor: 'white',
			            borderColor: 'white',
			            data: 0,
			            pointBackgroundColor:'rgb(0,0,0)',
			        },
					{
			            label: "10%" + " - "+ Math.ceil(people * 0.1),
			            backgroundColor: 'rgb(54,218,61)',
			            borderColor: 'grey',
			            data: Math.ceil(people * 0.1),
			            pointBackgroundColor:'rgb(54,218,61)',
			        },
					{
			            label: "20%" + " - "+ Math.ceil(people * 0.2),
			            backgroundColor: 'rgb(16,41,234)',
			            borderColor: 'grey',
			            data: Math.ceil(people * 0.1),
			            pointBackgroundColor:'rgb(16,41,234)',
			        },
					{
			            label: "25%" + " - "+ Math.ceil(people * 0.25),
			            backgroundColor: 'rgb(163,69,19)',
			            borderColor: 'grey',
			            data: Math.ceil(people * 0.1),
			            pointBackgroundColor:'rgb(163,69,19)',
			        },
					{
			            label: "30%" + " - "+ Math.ceil(people * 0.30),
			            backgroundColor: 'rgb(252,26,26)',
			            borderColor: 'grey',
			            data: Math.ceil(people * 0.1),
			            pointBackgroundColor:'rgb(252,26,26)',
			        }
				]
			    },
			    options: {
					plugins: {
   						annotation: {
      						annotations: {
        						"10_line": {
          							type: 'line',
         							yMin: Math.ceil(people * 0.1),
          							yMax: Math.ceil(people * 0.1),
          							borderColor: 'rgb(54,218,61)',
          							borderWidth: 2,
        						},
								"20_line": {
          							type: 'line',
         							yMin: Math.ceil(people * 0.2),
          							yMax: Math.ceil(people * 0.2),
          							borderColor: 'rgb(16,41,234)',
          							borderWidth: 2,
								
       							},
								"25_line": {
          							type: 'line',
         							yMin: Math.ceil(people * 0.25),
          							yMax: Math.ceil(people * 0.25),
          							borderColor: 'rgb(163,69,19)',
          							borderWidth: 2,
        						},
								"30_line": {
          							type: 'line',
         							yMin: Math.ceil(people * 0.3),
          							yMax: Math.ceil(people * 0.3),
          							borderColor: 'rgb(252,26,26)',
          							borderWidth: 2,
        						},
								"jan": {
          							type: 'line',
									xMin: '30-01-2025',
                                	xMax: '30-01-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Январь",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"feb": {
          							type: 'line',
									xMin: '28-02-2025',
                                	xMax: '28-02-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Февраль",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"march": {
          							type: 'line',
									xMin: '30-03-2025',
                                	xMax: '30-03-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Март",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"april": {
          							type: 'line',
									xMin: '30-04-2025',
                                	xMax: '30-04-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Апрель",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"may": {
          							type: 'line',
									xMin: '30-05-2025',
                                	xMax: '30-05-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Май",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"june": {
          							type: 'line',
									xMin: '30-06-2025',
                                	xMax: '30-06-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Июнь",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"july": {
          							type: 'line',
									xMin: '30-07-2025',
                                	xMax: '30-07-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Июль",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"aug": {
          							type: 'line',
									xMin: '30-08-2025',
                                	xMax: '30-08-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Август",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"sep": {
          							type: 'line',
									xMin: '30-09-2025',
                                	xMax: '30-09-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Сентябрь",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"oct": {
          							type: 'line',
									xMin: '30-10-2025',
                                	xMax: '30-10-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Октябрь",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"nov": {
          							type: 'line',
									xMin: '30-11-2025',
                                	xMax: '30-11-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Ноябрь",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -50,
            						},
        						},
								"dec": {
          							type: 'line',
									xMin: '31-12-2025',
                                	xMax: '31-12-2025',
                                	borderColor: 'rgba(31,29,28, 0.8)',
                               		borderWidth: 2,
									label: {
            							content: "Декабрь",
            							enabled: true,
            							position: "end",
										display : true,
										xAdjust : -20,
            						},
        						},
								label1: {
          							type: 'label',
          							xValue: Math.ceil(data.length) / 2,
          							yValue: Math.ceil(people * 0.3) + Math.ceil(people * 0.05),
									yAdjust: 15,
          							backgroundColor: 'rgba(245,245,245)',
          							content: [], // depsArray.length < 12 ? depsArray : "Весь центр"
          							font: {
          							  size: 18
          							}
								}
      }
    }
  }
				},
			});
			
		}
	})
		}
	}
)
}	

function get_duty_tb(){
	$(".spisok").show()
	if(window.myChart){
		try {
			window.myChart.destroy();
		} catch (error) {
			console.log(error);
		}
	}
	depsArray = new Array();
	$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
	$.ajax({
		type:"POST",
		url:"php_scripts/get_duty_table.php",
		data: {"departament[]":depsArray},
		cache: false,
		success: function(responce){ 
			$('table.iksweb').html(responce);
		}
	})
}
					function exportTableToExcel(tableId, filename = 'График отпусков.xls') {
					    let dataType = 'application/vnd.ms-excel';
					    let tableSelect = document.getElementById(tableId);
					    let tableHTML = encodeURIComponent(tableSelect.outerHTML.replace(/ or .*?>/g, '>'));
					    let link = document.createElement("a");
					    link.href = `data:${dataType}, ${tableHTML}`;
					    link.download = filename;
					    link.click();
					}

					function exportTableToWord(tableId, filename = 'График отпусков.docx') {//docx->xls
					    let dataType = 'application/vnd.ms-word';//word->exel
					    let tableSelect = document.getElementById(tableId);
					    let tableHTML = encodeURIComponent(tableSelect.outerHTML.replace(/ or .*?>/g, '>'));
					    let link = document.createElement("a");
					    link.href = `data:${dataType}, ${tableHTML}`;
					    link.download = filename;
					    link.click();
					}

document.getElementById("download").addEventListener('click', function(){
	// const { jsPDF } = window.jspdf;
	depsArray = new Array();
	$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
	/*Get image of canvas element*/
	let canv = document.getElementById("myChart");
	var url_base64jp = canv.toDataURL("image/jpg");

	/*get download button (tag: <a></a>) */
	var a =  document.getElementById("download");
	/*insert chart image url to download button (tag: <a></a>) */
	a.href = url_base64jp;
	a.download = depsArray + ".jpg";
});



// function editDuty(id){
// 	date_start = prompt('Введите дату начала отпуска', '2024-01-01');
// 	date_end = prompt('Введите дату конца отпуска', '2024-01-01');
// 	$.ajax({
// 	    type:"POST",
// 	    url:"php_scripts/change_duty.php",
// 	    data: {"id":id, "date_start":date_start, "date_end":date_end},
// 	    cache: false,
// 	    success: function(responce){
// 	    	selectDuty();
// 	    }
// 	})
// }
// 	function deleteDuty(id){
// 		$.ajax({
// 	      type:"POST",
// 	      url:"php_scripts/delete_duty.php",
// 	      data: {"id":id,},
// 	      cache: false,
// 	      success: function(responce){ 
// 	      	selectDuty();
// 	      }
// 	    })
		
// 	}

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

$("#add").on( "click", function() {
  window.location.href = "add_duty.php";
} );
</script>
</body>
</html>