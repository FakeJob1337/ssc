<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
	<title>График отпусков</title>
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
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
			<button type="button" class="btn btn-success" id="btnExel">
				<i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Exel</p>
			</button>

			<button type="button" class="btn btn-info" id="btnWord">
				<i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i><br><p class="mb-0">Word</p>
			</button>
		</div>
			<div class="view"><button id="select_duty" onclick="selectDuty();">Таблица</button><button id="select_graph" onclick="selectDuty_graph()">График</button></div>
				<div class="dropdown">
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
				</div>
				
				<button id="exp_xls" onclick="exportTableToExcel('output')">Экспорт таблицы в Exel</button>	
				<button id="exp_docx" onclick="exportTableToWord('output')">Экспорт таблицы в Word</button>
			</div>		
				<br>
				<br>
			<div class="content">
				<div class="spisok">
					<table class="table" id="output">	
						<div id="div-canv" style="width: 100%;">
							<canvas id="myChart"></canvas>
						</div>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
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

							function selectDuty(){
								var graph = document.getElementById('myChart');
								console.log(graph);
								graph.parentNode.removeChild(graph);
								depsArray = new Array();
								$('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
								$.ajax({
								    type:"POST",
								    url:"php_scripts/select_duty.php",
								    data: {"departament[]":depsArray},
								    cache: false,
								    success: function(responce){ 
							        	$('table#output').html(responce);
			                    	}
								}) 
							}

								function selectDuty_graph(){
									const getDatesArray = (start, end) => {
									    const arr = [];
									    while(start <= end) {
									        arr.push(new Date(start));
									        start.setDate(start.getDate() + 1);
									    }
									    return arr;
									};


									var canvas = document.createElement('canvas');
									div = document.getElementById('div-canv'); 
									canvas.id = "myChart";
									div.appendChild(canvas);
									document.getElementById('output').innerHTML = '';
									var l = 70;
									var line = new Array;
									var date = new Array;
									var count = new Array;
									let year = moment().format('YYYY');
									for (var i = 0; i <= 365; i++) {
									    let s = moment(year+"0101").add(i, 'days').format('DD-MM-YYYY');
									    date.push(s);
									    count.push(Math.floor(Math.random()*30+50));
									    line.push(l);
									}

									let datesArr = [];

									datesArr = getDatesArray();

									var ctx = document.getElementById('myChart').getContext('2d');
									var chart = new Chart(ctx, {
									    type: 'line',
									    data: {
									        labels: date,
									        datasets: [{
									            label: "График отпусков",
									            backgroundColor: 'grey',
									            borderColor: 'grey',
									            data: count,
									            pointBackgroundColor:'rgb(0,0,0)',
									        }, {
									        	label: "Предельное количество отпусков",
									            backgroundColor: 'red',
									            borderColor: 'red',
									            data: line,
									        }]
									    },
									    options: {}
									});
								}

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

function editDuty(id){
	date_start = prompt('Введите дату начала отпуска', '2024-01-01');
	date_end = prompt('Введите дату конца отпуска', '2024-01-01');
	$.ajax({
	    type:"POST",
	    url:"php_scripts/change_duty.php",
	    data: {"id":id, "date_start":date_start, "date_end":date_end},
	    cache: false,
	    success: function(responce){
	    	selectDuty();
	    }
	})
}
	function deleteDuty(id){
		$.ajax({
	      type:"POST",
	      url:"php_scripts/delete_duty.php",
	      data: {"id":id,},
	      cache: false,
	      success: function(responce){ 
	      	selectDuty();
	      }
	    })
		
	}

</script>
</body>
</html>