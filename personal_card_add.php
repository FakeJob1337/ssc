<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить</title>

    <link rel="stylesheet" href="css/style_info.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
    <div class="content col-10">
        <header class="p-3">
            <h1>Добавить нового военнослужащего</h1>
        </header>
        <div class="form">
            <div class="form-group row">
                <div class="col-3">
                    <label for="surname">Фамилия:</label>
                    <input type="text" class="form-control" id="surname">
                </div>
                <div class="col-3">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="col-3">
                    <label for="secname">Отчество:</label>
                    <input type="text" class="form-control" id="secname">
                </div>
            </div>
            <div class="mt-4 form-group row">
                <div class="col-4">
                  <label>Выберите фактическое звание:</label>
                    <?php  
				        $conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
				        $sql = "SELECT DISTINCT rank_fact FROM shtat ORDER BY `shtat`.`rank_fact` ASC";
				        $result = $conn->query($sql);
				        echo"<select class='form-select' id='selectRank'>";
				        while($row = $result->fetch()){
                            echo "<option type='checkbox' name='rank' value='$row[0]'>$row[0]</option>";	
                        }
				        echo"</select>";
                    ?>
                </div>
            </div>
			<div class="mt-4">
				<label>Выберете должность: </label>
				<div class="mt-1" id="doljText"></div>
			</div>
            <div class="form-group row" id="output"></div>
            <table class="table table-hover table-scroll mt-2" id="output"></table>
        </div>
        <footer class="fixed-bottom text-end">
            <button class="btn btn-primary m-3" id="sub">Добавить</button>
        </footer>
    </div>
</div>

<script>
const submitBtn = document.getElementById('sub');
submitBtn.onclick = () => {
  let doljValues = [];
  const surname = document.getElementById("surname").value;
  const name = document.getElementById("name").value;
  const secname = document.getElementById("secname").value;
  const rank = document.querySelector('#selectRank').value;
  const inputs = document.getElementById("doljText").getElementsByTagName("input");
  const id = document.querySelector('.text').id;
  for (var i = 0, len = inputs.length; i < len; ++i) {
      doljValues.push(inputs[i].value);
  }
  if (!surname || !name || !secname || !rank || !id) {
  	alert('Не все поля заполнены');
  }
  $.ajax({
      type:"POST",
      url:"php_scripts/add_personal.php",
      data: {"id":id,"surname":surname,"name":name,"secname":secname,"rank":rank,"doljValues[]":doljValues},
      cache: false,
      success: function(responce){
      	$('div#output').html(responce);
          alert('военнослужащий успешно добавлен');
      }
  })
}

getFirstFilter();
function getFirstFilter() {
  $.ajax({
      type:"POST",
      url:"php_scripts/filters.php",
      data: {"selectId":'pr2'},
      cache: false,
      success: function(responce){ 
        $('div#output').html(responce);
      }
    })
}

function getNextFilter(selectId) {
  
  let selectValue = [];
  $('.selectFilter').each(function(){
    selectValue.push($(this).val());
  });
  let lastChar = Number(selectId.substr(selectId.length - 1)) + 1;
  selectIdNext = selectId.substring(0, selectId.length-1) + lastChar;
  for(let i = Number(selectId.substr(selectId.length - 1)) + 1; i <= 5; i++){
    $('#pr'+i).remove();
  }
  $.ajax({
      type:"POST",
      url:"php_scripts/filters.php",
      data: {"selectId": selectIdNext, "selectValue[]": selectValue},
      cache: false,
      success: function(responce){ 
        $('div#output').append(responce);
        selectPersonal(selectId,selectValue);
      }
    })
}

function selectPersonal(selectId,selectValue){
	const vakant = true;
  $.ajax({
      type:"POST",
      url:"php_scripts/select_personal_for_perenos.php",
      data: {"selectId": selectId, "selectValue[]": selectValue, "vakant": vakant},
      cache: false,
      success: function(responce){ 
        $('table#output').html(responce);
      }
    })
}

function perenos(idFromBtn){
	$.ajax({
      type:"POST",
      url:"php_scripts/get_dolj_text.php",
      data: {"id": idFromBtn},
      cache: false,
      success: function(responce){ 
        $('div#doljText').html(responce);
      }
    })
}

</script>
</body>
</html>
