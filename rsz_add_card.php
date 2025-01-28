<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/style_rsz_add_card.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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
            <h1>Развернутая строевая записка ССЦ новая</h1>
        </header>
            <div class="menu">
                <div class="form-group row m-2">
                    <div class="col-2">
                        <label for="date">Выбрать дату:</label>
                        <input type="date" class="form-control datepicker" id="date" name="date">
                    </div>
                    <div class="col-4"><label>Выберите подразделение:</label>
                        <?php  
            				session_start();
                            $conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
                            $sql = "SELECT DISTINCT pr2 FROM shtat  ORDER BY `shtat`.`pr2` ASC";
                            $result = $conn->query($sql);
                            echo"<select class='form-select' id='selectDep'><option readonly>Выберите подразделение</option>";
                            while($row = $result->fetch()){
                                if (stristr($_SESSION['status'],"admin")) {
                                    echo "<option name='dep' value='$row[0]'>$row[0]</option>";
                                    continue;
                                }
                                if (stristr($_SESSION['status'],$row[0])) {
                                    echo "<option name='dep' value='$row[0]'>$row[0]</option>";
                                } else{
                                echo "<option name='dep' value='$row[0]' disabled>$row[0]</option>";
                                }
                            }
                            echo "<option name='dep' style='display: none;' value='Управление'>Управление</option></select>"; 
                        ?>
                    </div>
                    <button class="btn btn-secondary btn-sm col-1 mt-3" id="sub">Отправить</button>
                </div>
                
            </div>
                <table class="table table-hover table-scroll mt-5" id="output">
                </table>
    </div>
</div>

<script>

const now = new Date();
const d = now.getDate();
const m = now.getMonth()+1;
const y = now.getFullYear();

document.querySelector('#date').value = y+'-'+m+'-'+d;

$('#selectDep').on('change', function() {
    const dep = $(this).val();
    $.ajax({
        type:"POST",
        url:"php_scripts/select_pers_rsz.php",
        data: {"departament":dep},
        cache: false,
        success: function(responce){ 
            $('table#output').html(responce);
        }
    })
});

document.querySelector('#sub').addEventListener('click',()=>{

    const date = document.querySelector('#date').value;
    const dep = document.querySelector('#selectDep').value;

    let duty = [];
    let trip = [];
    let hospital = [];
    let ill = [];
    let mission = [];
    let other = [];
    let layoff = [];
    let arrest = [];
    $('.rsz option:selected').each(function() {
        let val = $(this).val();
        if (val.split(' ')[0] == 'Отпуск') {
            duty.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Командировка'){
            trip.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Госпиталь'){
            hospital.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Болен'){
            ill.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Наряд'){
            mission.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Прочее'){
            other.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Увольнение'){
            layoff.push(val.split(' ')[1]);
        }
        else if (val.split(' ')[0] == 'Арест'){
            arrest.push(val.split(' ')[1]);
        }
        
    });
    
    $.ajax({
        type:"POST",
        url:"php_scripts/add_dep_rsz.php",
        data: {"dep":dep,"date":date,"duty[]":duty,"trip[]":trip,"hospital[]":hospital,"ill[]":ill,"mission[]":mission, "other[]": other,
            "layoff[]":layoff, "arrest[]":arrest
        },
        cache: false,
        success: function(responce){ 
            alert('РСЗ для '+dep+' на '+date+' успешно добавлено.');
            $('table#output').html(responce);
        }
    })
})

</script>
</body>
</html>