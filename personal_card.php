<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Карточка персонала</title>
    <link rel="stylesheet" href="css/style_info.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php

$id = $_GET['id'];

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT surname, (SELECT SUBSTRING_INDEX(`name`, ' ', 1)), (SELECT SUBSTRING_INDEX(`name`, ' ', -1)), birthday from shtat WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch();
?>

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
        <div class="form-group row m-1 align-items-center">
            <div class="col-2 p-2">
                <img src="image/mchs.png" id='persImg' width ="120px" class="rounded mx-auto d-block mb-2">
                <input class="form-control form-control-sm" type="file" id="formFile" accept="image/*">
                <button type="button" id="uploadBtn" class="btn btn-primary btn-sm">Загрузить</button>
                <progress id="progressBar" value="0" max="100"></progress>
            </div>
            <div class="col-2">
                <label for="surname">Фамилия:</label>
                <input type="text" class="form-control" id="surname" readonly value="<?php echo($row[0]); ?>">
            </div>
            <div class="col-2">
                <label for="name">Имя:</label>
                <input type="text" class="form-control" id="name" readonly value="<?php echo($row[1]); ?>">
            </div>
            <div class="col-2">
                <label for="secname">Отчество:</label>
                <input type="text" class="form-control" id="secname" readonly value="<?php echo($row[2]); ?>">
            </div>
        </div>
        <div class="form-group row mt-3 m-1">
            <div class="col-2">
                <label for="date">Дата рождения:</label>
                <input type="date" class="form-control datepicker" id="birthday" name="date" readonly value="<?php echo($row[3]); ?>">
            </div>
            <div class="col-2">
                <label for="sex">Пол:</label>
                <select class='form-select' id='sex'>
                    <option>М</option>
                    <option>Ж</option>
                </select>
            </div>
            <div class="col-2">
                <label for="age">Полных лет:</label>
                <input type="text" class="form-control" id="age" name="age" readonly>
            </div>
            <div class="col-2">
                <label for="snils">Снилс:</label>
                <input type="text" class="form-control" name="snils">
            </div>
        </div>
        <div class="form-group row m-1 mt-3">
            <div class="col-2">
                <label for="phone1">Телефон 1:</label>
                <input type="tel" class="form-control" name="phone1">
            </div>
            <div class="col-2">
                <label for="phone2">Телефон 2:</label>
                <input type="tel" class="form-control" name="phone2">
            </div>
        </div>
        <div class="type mt-3">
            <button type="button" class="btn btn-secondary" onclick="get_main_info()">Основные данные</button>
            <button type="button" class="btn btn-secondary" onclick="get_docs()">Документы</button>
            <button type="button" class="btn btn-secondary" onclick="get_education()">Образование</button>
            <button type="button" class="btn btn-secondary" onclick="get_ls()">Личная информация</button>
            <button type="button" class="btn btn-secondary" onclick="get_history()">История</button>
            <button type="button" class="btn btn-secondary" id="dolj" onclick="getFirstFilter()">Перенос</button>
            <button type="button" class="btn btn-success" onclick="set_inf()">Добавить остальную информацию</button>
        </div>

        <div class="bottom">
          <div class="perenos_t row" id="output2">
          <footer>
          </footer>
        </div>
    </div>
</div>
<script>
document.querySelector('#age').value = getAge(document.querySelector('#birthday').value);

let url = new URLSearchParams(window.location.search);
let age = document.querySelector('#age').value;
let id = url.get('id');

window.sessionStorage.setItem("id", id);
window.sessionStorage.setItem("age", age);
    $('#send').click(function(){
        let Data = $('form').serializeArray();
        let start = new Date(Data['0']['value']).toISOString().slice(0, 19).replace('T', ' ');
        let days = Data['1']['value']
        id = window.sessionStorage.getItem("id");
        age = window.sessionStorage.getItem("age");
        $.ajax({
          type:"POST",
          url:"php_scripts/set_duty.php",
          data: {"id": id, "age": age, "start": start, "days": days},
          cache: false,
          success: (response) => {
              alert(response);
          }
        })
    });


function set_inf() {  
  window.open("personal_card.php?id="+id, '_blank').focus()
}


function getAge(b){
  const now = new Date()
  const date = new Date(b);
  const addOne = now.getMonth() - date.getMonth() >= 0 && now.getDate() - date.getDate() >= 0
  const diff = now.getFullYear() - date.getFullYear()
  return diff - 1 + (addOne ? 1 : 0);
}

function get_ls(){
    const url = new URLSearchParams(window.location.search)
    let a = url.get('id');
  $.ajax({
    type:"POST",
    url:"php_scripts/get_ls.php",
    data: {"id": a},
    cache: false,
    success: function(responce){ 
      $('div#output2').html(responce);
    }
  }) 
}

  function del(){
    const url = new URLSearchParams(window.location.search)
        let a = url.get('id');
    $.ajax({
      type:"POST",
      url:"php_scripts/delete.php",
      data:{"id":a},
      cache: false,
      success: function(){
        alert('Сотрудник удален');
      }
    })
  }

  function get_history(){
    const url = new URLSearchParams(window.location.search)
    let a = url.get('id');
    $.ajax({
      type:"POST",
      url:"php_scripts/personal_card_history_select.php",
      data: {"id":a},
      cache: false,
      success: function(responce){ 
        $('div#output2').html(responce);
      }
    })
  }

function get_main_info(){
  const url = new URLSearchParams(window.location.search)
  let a = url.get('id');
  $.ajax({
    type:"POST",
    url:"php_scripts/personal_card_main_info_select.php",
    data: {"id":a},
    cache: false,
    success: function(responce){ 
      $('div#output2').html(responce);
    }
  })
}

      function get_docs(){
        const url = new URLSearchParams(window.location.search)
        let a = url.get('id');
            $.ajax({
              type:"POST",
              url:"php_scripts/personal_card_docs_select.php",
              data: {"id":a},
              cache: false,
              success: function(responce){
                $('div#output2').html(responce);
              }
            })
          }

      function get_education(){
        const url = new URLSearchParams(window.location.search)
        let a = url.get('id');
            $.ajax({
              type:"POST",
              url:"php_scripts/personal_card_education_select.php",
              data: {"id":a},
              cache: false,
              success: function(responce){ 

                $('div#output2').html(responce);
              }
            })
          }
  
function perenos(idFromBtn){
  const url = new URLSearchParams(window.location.search)
  let a = url.get('id');
  $.ajax({
    type:"POST",
    url:"php_scripts/perenos.php",
    data: {"idFromBtn":idFromBtn,"idFromCard":a},
    cache: false,
    success: function(responce){
      alert('Перенос прошел успешно');
      location.reload();
    }
  })

}

  function delet(id){
    $.ajax({
      type:"POST",
      url:"php_scripts/delete_work_history.php",
      data: {"id":id},
      cache: false,
      success: function(responce){ 
        get_history();
      }
    })
  }


function getFirstFilter() {
  $.ajax({
      type:"POST",
      url:"php_scripts/filters.php",
      data: {"selectId":'pr2'},
      cache: false,
      success: function(responce){ 
        $('div#output2').html(responce);
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
        $('div#output2').append(responce);
        selectPersonal(selectId,selectValue);
      }
    })
}

function selectPersonal(selectId,selectValue){
  $.ajax({
      type:"POST",
      url:"php_scripts/select_personal_for_perenos.php",
      data: {"selectId": selectId, "selectValue[]": selectValue},
      cache: false,
      success: function(responce){ 
        $('table#output').html(responce);
      }
    })
}
</script>

</body>
</html>