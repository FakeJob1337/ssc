<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Добавить Семеное положение</title>
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/abroad.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
    <div class="all" style="display: -webkit-inline-box;">
    <div class="form p-2">
            <h2>Cемейное положение</h2>
            <div class="col-12">
                <label for="relation">Кем является</label>
                <input type="text" class="form-control relation" value="">
            </div>
            <div class="col-12">
                <label for="information">Информация:</label>
                <textarea class="form-control information" rows="10"></textarea>
            </div>
        </div>
    </div>
        <div class="col-6 p-1">
        <button type="button" class="btn btn-primary" id="add" onclick="add_to_db()">Добавить к профилю</button>
        </div>
        <div class="col-6 p-1">
        <button type="button" class="btn btn-primary" id="add_to_db">Доп</button>
        </div>
    </div>
</div>
</body>
<script>
    document.querySelector("#add_to_db").addEventListener("click", function(){
        let sec_edu = document.querySelector(".form")
        let clone = sec_edu.cloneNode(true)
        let allEducation = document.querySelector(".all")
        allEducation.appendChild(clone)
    })

    // Переименовать в общий интерфейс для всего, не только образования.
    function add_to_db() {
        let searchParams = new URLSearchParams(window.location.search);
        let id = searchParams.get("id");
        let education = {}
        let educationList = []
        let allEducation = document.querySelectorAll(".form")
        allEducation.forEach(element => {
            let inputs = element.querySelectorAll(".form-control")
            inputs.forEach(inp => {
                education[inp.classList[1]] = inp.value
            });
            educationList.push(education)
        });
        console.log(educationList);
        $.ajax({
        type:"POST",
        url:"php_scripts/set_marital_status.php",
        data: {data:JSON.stringify(educationList), id},
        cache: false,
        success: function(responce){ 
            alert('Добавлено');
        }
    })
    }
</script>
</html>