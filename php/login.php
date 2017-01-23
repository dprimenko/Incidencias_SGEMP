<?php
	include_once('app.php');

	global $app;
	$app = new App();
	
	if (isset($_GET['connecting'])) {
		unset($_GET['connecting']);
		$app->login($_POST['username'], sha1($_POST['password']));
	}
	
	if (!$app->loginIsSet()) {
		echo '
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8" />
				<title>Login - Incidencias en un aula</title>
				<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="../css/style.css" />
			</head>
			<body>
				<div class="wrapper login">
					<div class="login-container">
						<h1 class="welcome-login">Bienvenido al Login</h1>
						<form class="login-form" action="login.php?connecting=true" method="post">
							<div class="row">
								<div class="col-md-12">
									<input class="input-app login-input" placeholder="Usuario" type="text" name="username">
								</div>
								<div class="col-md-12">
									<input class="input-app login-input" placeholder="Contraseña" type="password" name="password">
								</div>
								<div class="col-md-12">
									<input class="button-send button-send-login" type="submit" value="Login" name="send">
									<br/>';
									if (isset($_GET['connect'])) {
										echo '<div class="alert">Los datos introducidos son incorrectos</div>';
										unset($_GET['connect']);
									}
			echo '				</div>
							</div>
						</form>
						
					</div>
				</div>
			</body>
		</html>
		';
	} else {
		echo "<script>window.location='../index.php';</script>";
	}

	
?>