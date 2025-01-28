
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<title>МЧС</title>
</head>
<body>
<div class="menuhref d-flex align-items-center p-2"><a href="info.php">Главная</a></div>
<div class="menuhref d-flex align-items-center p-2"><a href="registration.php">Регистрация</a></div>

<div class="mainform">
	<form method="POST" id="AuthN">
		<img id ="i" src="image/mchs.png" width ="80px">
		<h3>Авторизация</h3></br>
		<div class="form-cont">
 		<div class="mb-3">
   			<input type="text" class="form-control" name="username" placeholder="Введите логин">
 		</div>
 		<div class="mb-3">
   			<input type="password" class="form-control" name="password" placeholder="Введите пароль">
		</div>
 		</div>
 		<div class="btn-cont">
 		<button type="submit" name="button_id" class="btn btn-primary" id="sub">Войти</button>
 		</div>
	</form>
</div>
<script src="js/index.js"></script>
</body>
</html>
