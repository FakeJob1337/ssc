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
            <h1>Добавить Вакансию</h1>
        </header>
        <div class="form">
            <div class="form-group row">
                <div class="col-3">
                    <label for="job">Должность</label>
                    <input type="text" class="form-control" id="job">
                </div>
                <div class="col-3">
                    <label for="rank_shtat">Звание</label>
                    <input type="text" class="form-control" id="rank_shtat">
                </div>
                <div class="col-3">
                    <label for="pr2">Подразделение</label>
                    <input type="text" class="form-control" id="pr2">
                </div>
                <div class="col-3">
                    <label for="sr">Тип службы</label>
                    <input type="text" class="form-control" id="sr">
                </div>
            </div>
            <div class="mt-4 form-group row">
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
  const inputElements = document.querySelectorAll('input')
  const inputValues = {}
  inputElements.forEach(input => { inputValues[input.id] = input.value;})
  $.ajax({
      type:"POST",
      url:"php_scripts/add_vacancy.php",
      data: {data:JSON.stringify(inputValues)},
      cache: false,
      success: function(responce){
      	alert("Добавлено")
      }
  })
}


</script>
</body>
</html>
