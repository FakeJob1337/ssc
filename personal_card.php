<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Карточка персонала</title>
    <link rel="stylesheet" href="css/style_info.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
     .scroll-container {
            height: 900px;
            overflow: auto;
            margin: 20px;
            padding: 10px;
        }
    </style>
</head>
<body class="min-h-screen">
<?php 



$id = $_GET['id'];
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$id = $_GET['id'];
$sql = "SELECT * FROM `shtat` LEFT JOIN `personal_information` ON shtat.id = personal_information.shtat_id WHERE shtat.id = $id";
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
      <div class="scroll-container">
      <div class="container mx-auto px-4 py-8">
          <!-- Карточка профиля -->
          <div class="bg-white rounded-lg shadow-lg p-6 text-center">
              <!-- Аватар -->
              <a data-fslightbox="profile_photo" href="<?php echo $row['profile_photo'] ?>">
                <img src="<?php echo $row['profile_photo'] ?>" alt="Аватар" class="w-32 h-32 rounded-full mx-auto mb-4">
              </a>
              <div class="mb-3">
              </div>
              <!-- ФИО -->
              <h1 class="text-2xl font-bold text-gray-800"><?php echo $row['surname']." ".$row['name']; ?></h1>
              <!-- Должность -->
              <p class="text-gray-600"><?php echo $row['job'] ?></p>
              <!-- Социальные сети -->
              <div class="mt-4 space-x-4">
                  <a href="#" class="text-blue-500 hover:text-blue-700">Телеграмм</a>
                  <a href="#" class="text-blue-500 hover:text-blue-700">ВК</a>
                  <!-- <a href="#" class="text-blue-500 hover:text-blue-700">LinkedIn</a> -->
              </div>
              <div>
                <p id="load">Загрузить фото профиля</p>
                    <input class="form-control" type="file" id="profile_photo" onchange="set_photo(this)">
              </div>
          </div>

          <!-- Основная информация -->
          <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
              <h2 class="text-xl font-bold text-gray-800 mb-4">Основная информация</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                      <p class="text-gray-600"><strong>Дата рождения:</strong> <?php echo $row['birthday'] ?></p>
                      <p class="text-gray-600"><strong>Пол:</strong> <?php echo $row['sex'] ?></p>
                      <p class="text-gray-600"><strong>Место рождения:</strong> <?php echo $row['place_of_birth'] ?></p>
                  </div>
                  <div>
                      <p class="text-gray-600"><strong>Телефон:</strong> <?php echo $row['telephone_number'] ?></p>
                      <p class="text-gray-600"><strong>Национальнось:</strong> <?php echo $row['nationality'] ?></p>
                      <p class="text-gray-600"><strong>Семейное положение:</strong> <?php echo $row['marital_status'] ?></p>
                  </div>
              </div>
          </div>

          <!-- Рабочая информация -->
          <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
              <h2 class="text-xl font-bold text-gray-800 mb-4">Рабочая информация</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                        <p class="text-gray-600"><strong>Личный номер:</strong> <?php echo $row['personal_number'] ?></p>
                        <p class="text-gray-600"><strong>Подразделение:</strong> <?php echo $row['pr2'] ?></p>
                        <p class="text-gray-600"><strong>Допуск:</strong> <?php echo $row['admission'] ?></p>
                        <p class="text-gray-600"><strong>В кадровом резерве?:</strong> <?php echo $row['is_talent_pool'] ?></p>
                        <p class="text-gray-600"><strong>Квалификационное звание:</strong> <?php echo $row['qualification_title'] ?></p>
                        <p class="text-gray-600"><strong>Дата контракта:</strong> <?php echo $row['contract_date'] ?></p>
                        <p class="text-gray-600"><strong>Должность:</strong> <?php echo $row['job'] ?></p>
                        <p class="text-gray-600"><strong>Дата присвоения:</strong> <?php echo $row['job_assignment_date'] ?></p>
                        <p class="text-gray-600"><strong>Номер приказа:</strong> <?php echo $row['job_order_number'] ?></p>
                  </div>
                  <div>
                        <p class="text-gray-600"><strong>Звание:</strong> <?php echo $row['rank_fact'] ?></p>
                        <p class="text-gray-600"><strong>Дата присвоения:</strong> <?php echo $row['rank_assignment_date'] ?></p>
                        <p class="text-gray-600"><strong>Номер приказа:</strong> <?php echo $row['rank_order_number'] ?></p>
                  </div>
              </div>
          </div>

          <!-- Документы -->
          <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
              <h2 class="text-xl font-bold text-gray-800 mb-4">Документы</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <p class="text-gray-600"><strong>Паспорт</strong></p>
                      <p class="text-gray-600"><strong>Серия:</strong> <?php echo $row['passport_series'] ?></p>
                      <p class="text-gray-600"><strong>Номер:</strong> <?php echo $row['passport_numbers'] ?></p>
                      <p class="text-gray-600"><strong>Кем выдан:</strong> <?php echo $row['passport_issued_by'] ?></p>
                      <p class="text-gray-600"><strong>Ксерокопия:</strong> 
                        <a data-fslightbox="passport_photo" href="<?php echo $row['passport_photo'] ?>">
                            <img src="<?php echo $row['passport_photo'] ?>" alt="Аватар" class="w-32 h-32 mx-auto mb-4">
                        </a>
                      </p>
                    <input class="form-control" type="file" id="passport_photo" onchange="set_photo(this)">
                    </div>
                    <div>
                    <p class="text-gray-600"><strong>Военный билет:</strong> <?php echo $row['military_card'] ?></p>
                    <p class="text-gray-600"><strong>Ксерокопии:</strong> 
                        <a data-fslightbox="military_card_photo" href="<?php echo $row['military_card_photo'] ?>">
                            <img src="<?php echo $row['military_card_photo'] ?>" alt="Аватар" class="w-32 h-32 mx-auto mb-4">
                        </a>
                    </p>
                    <input class="form-control" type="file" id="military_card_photo" onchange="set_photo(this)"> 
                    </div>
                    <div>
                    <p class="text-gray-600"><strong>Водительское удостоверение:</strong> <?php echo $row['drivers_license'] ?></p>
                    <p class="text-gray-600"><strong>Действителен с:</strong> <?php echo $row['drivers_license_sdate'] ?></p>
                    <p class="text-gray-600"><strong>Действителен по:</strong> <?php echo $row['drivers_license_edate'] ?></p>
                    <p class="text-gray-600"><strong>Категории:</strong> <?php echo $row['drivers_license_categories'] ?></p>
                    <p class="text-gray-600"><strong>Ксерокопии:</strong> 
                        <a data-fslightbox="drivers_license_photo" href="<?php echo $row['drivers_license_photo'] ?>">
                            <img src="<?php echo $row['drivers_license_photo'] ?>" alt="Аватар" class="w-32 h-32 mx-auto mb-4">
                        </a>
                    </p>
                    <input class="form-control" type="file" id="drivers_license_photo" onchange="set_photo(this)">
                    </div>
              </div>
          </div> 
          <!-- Образование -->
          <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
              <h2 class="text-xl font-bold text-gray-800 mb-4">Образование</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                      <p class="text-gray-600"><strong>Тип образования:</strong><?php echo $row['type_of_education'] ?></p>
                      <p class="text-gray-600"><strong>Специальность:</strong><?php echo $row['speciality'] ?></p>
                      <p class="text-gray-600"><strong>Учреждение:</strong><?php echo $row['institution'] ?></p>
                      <p class="text-gray-600"><strong>Год окончания:</strong><?php echo $row['year_of_graduation'] ?></p>
                      <p class="text-gray-600"><strong>Ученая степень:</strong> <?php echo $row['academic_degree'] ?></p>
                      <p class="text-gray-600"><strong>Ксерокопии:</strong><p class="text-gray-600"><strong>Ксерокопии:</strong> 
                        <a data-fslightbox="diploma_photo" href="<?php echo $row['diploma_photo'] ?>">
                            <img src="<?php echo $row['diploma_photo'] ?>" alt="Аватар" class="w-32 h-32 mx-auto mb-4">
                        </a>
                      </p>
                      <input class="form-control" type="file" id="diploma_photo" onchange="set_photo(this)">
                  </div>
              </div>
          </div>
      </div>
      <button type="button" onclick="set_inf()" class="btn btn-blue">Добавить информацию</button>
      <button type="button" onclick="" class="btn btn-blue">Добавить образование</button>
      <button type="button" onclick="" class="btn btn-blue">Добавить семейное положение</button>
      <button type="button" onclick="" class="btn btn-blue">Добавить семейное положение</button>
    </div>
</div>
</div>



<!-- Подключение Bootstrap JS и зависимостей -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
function set_inf() { 
    let searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id')
  window.open("personal_info_card_add.php?id="+id, '_blank').focus()
}
function getAge(b){
  const now = new Date();
  const date = new Date(b);
  const addOne = now.getMonth() - date.getMonth() >= 0 && now.getDate() - date.getDate() >= 0
  const diff = now.getFullYear() - date.getFullYear()
  
  return diff - 1 + (addOne ? 1 : 0);
}




function set_photo(f) {  
    let searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id')
    document.cookie = "id=" + id
    document.cookie = "col=" + f.id
    let inp = f
    let files = inp.files;
    let datas = new FormData()
    let file =files[0]
    datas.append('photo', file, file.name)
    $.ajax({
        type:"POST",
        url:"php_scripts/set_profile_photo.php",
        data: datas,
        cache: false,
        contentType : false,
        processData: false,
        success: function(responce){ 
            alert('resp');
        }
    })
}

</script>
<script src="fslightbox.js"></script>
</body>
</html>