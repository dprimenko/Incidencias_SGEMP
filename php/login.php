<?php
	include_once('app.php');

	global $app;
	$app = new App();

	$username = $_POST['username'];
	$username = $_POST['password'];

	$app->login($username, $password);
?>