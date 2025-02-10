<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
	<title>График отпусков</title>
    <link rel="stylesheet" href="css/add_duty.css">
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="css/duty.css"> -->
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
			<h1>Добавить отпуска</h1>
		</header>
		<div class="menu p-3">
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
                    <button id="create">                  
                         Создать таблицу
                    </button>
                    <button id="add_to_db">
                    Добавить отпуска 
                    </button>
		        </div>
                <div id="spisok" >

                </div>
			</div>		
		</div>
	</div>
</div>
<script>
    function get_pers(){
        depsArray = new Array();
        $('input[name="departament"]:checked').each(function() {depsArray.push(this.value);});
        return depsArray
    }
    
	$("#spisok").on("click", ".add_btn",function (e) {
		e.preventDefault();
		let person = $(this).parent("tr");
		let cl_person =person.clone()
		let fp = $("<tr></tr>").append(cl_person)
		person.after(fp.html())
	});


	$("#spisok").on("click", ".spec_btn",function (e) {
		e.preventDefault();
		let person = $(this).parent("tr");
		let cl_person = person.clone()
		$(this).replaceWith($("<td class='item'><input type='text' class='form-control' name='spec'></td>"));
		let fp = $("<tr></tr>").append(cl_person)
		person.after(fp.html())
	});


    $("#create").click(function (e) { 
        e.preventDefault();
        $.ajax({
		type:"POST",
		url:"php_scripts/create_duty_pers.php",
		data: {"departament[]":get_pers()},
		cache: false,
		success: function(responce){ 
			$('#spisok').html(responce);
	    	}
	    })
    });

    $("#add_to_db").click(function (e) { 
        e.preventDefault();
        let dates = [];
        let days = [];
        let id = [];
		let specs = [];
		
		// $('input[name="start"]').each(function() {
        //     dates[$(this).attr("bdid")] = $(this).val();
        // });

        // $('input[name="days"]').each(function() {
        //     days[$(this).attr("bdid")] = $(this).val();
        // });
		// $('input[name="spec"]').each(function() {
		// 	bdid = $(this).parents("tr").children().html()
		// 	specs[bdid] = $(this).val();
        // });
		$("tr").each(function() {
        	let res1 = $(this).find("input[name='start']").val() ?? 0;
            let res2 = $(this).find("input[name='days']").val() ?? 0;
			let	res3 = $(this).find("input[name='spec']").val() ?? null;
			let	res4 = $(this).find("input[name='start']").attr("bdid") ?? 0;
			dates.push(res1 ?? null);
			days.push(res2 ?? null);
			specs.push(res3 ?? null);
			id.push(res4 ?? null)
		});		
		console.log(days);
        $.ajax({
		type:"POST",
		url:"php_scripts/set_duty_multiple.php",
		data: {"dates[]": dates, "days[]": days, "specs[]": specs, "id[]": id},
		cache: false,
		success: function(responce){ 
			alert(responce);
	    	}
	    })
    });

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

</script>
</body>
</html>