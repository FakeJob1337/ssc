<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Добавить образование</title>
	<link rel="stylesheet" href="css/style_info.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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
    <div class="allEducation" style="display: -webkit-inline-box;">
    <div class="educationForm p-2">
            <h2>Образование и квалификация</h2>
            <div class="col-6">
                <label for="speciality">Специальность</label>
                <input type="text" class="form-control speciality" value="">
            </div>
            <div class="col-6">
                <label for="institution">Учреждение</label>
                <input type="text" class="form-control institution"  value="">
            </div>
            <div class="col-6">
                <label for="academic_degree">Ученая степень</label>
                <input type="text" class="form-control academic_degree" value="">
            </div>
            <div class="col-6">
                <label for="year_of_graduation">Год окончания обучения</label>
                <input type="date" class="form-control year_of_graduation" value="">
            </div>
            <div class="col-6">
                <label for="type_of_education">Вид образования</label>
                <input type="text" class="form-control type_of_education" value="">
            </div>
        </div>
    </div>
    <div class="col-6 p-1">
                <button type="button" class="btn btn-primary" id="add" onclick="add_education()">Добавить к профилю</button>
            </div>
            <div class="col-6 p-1">
            <button type="button" class="btn btn-primary" id="add_to_db">Добавить доп образование</button>
            </div>
</div>

</div>
</body>
<script>
    document.querySelector("#add_to_db").addEventListener("click", function(){
        let sec_edu = document.querySelector(".educationForm")
        let clone = sec_edu.cloneNode(true)
        clone.style.display = "inline-block"
        clone.querySelector("h2").textContent = "Доп образование"
        clone.querySelector("[for=academic_degree]").remove()
        clone.querySelector(".academic_degree").remove()
        let allEducation = document.querySelector(".allEducation")
        allEducation.appendChild(clone)
    })


    function add_education() {
        let searchParams = new URLSearchParams(window.location.search);
        let id = searchParams.get("id");
        let education = {}
        let educationList = []
        let allEducation = document.querySelectorAll(".educationForm")
        allEducation.forEach(element => {
            let inputs = element.querySelectorAll("input")
            inputs.forEach(inp => {
                education[inp.classList[1]] = inp.value
            });
            educationList.push(education)
        });
        console.log(educationList);
        $.ajax({
        type:"POST",
        url:"php_scripts/set_education.php",
        data: {data:JSON.stringify(educationList), id},
        cache: false,
        success: function(responce){ 
            alert('Добавлено');
        }
    })
    }
</script>
</html>