<?php include_once 'modules/login/login-start.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset=utf-8>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
	<script src='main.js'></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href=".\css\style.css">
	<script src="script.js"></script>
	<title>Авторизация</title>
</head>

<body>
	<div class="signin-container">
		<form class="signin-form" action="" method="POST">
			<div class="signin-content-head">
				<hr>
				<h1>Вход в личный <br> кабинет</h1>
			</div>
			<div class="signin-content-item">
				<img src="images/system_phone.svg" alt="">
				<input type="text" id="username" name="username" placeholder="Имя пользователя">
			</div>
			<div class="signin-content-item">
				<img src="images/system_lock.svg" alt="">
				<input type="password" name="password" id="password" placeholder="Пароль">
			</div>
			<input class="btn-signin" name="signin" value="Войти" type="submit">
		</form>
		<?php include_once 'modules/login/login_error.php'; ?>
	</div>
</body>

</html>