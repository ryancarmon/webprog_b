<?php
session_start();
require('database.req.php')
$username = $_POST['user'];
$password = $_POST['pass'];
if (function isLoginValid($username, $password) != false)
{
	$_SESSION['ID'] = $username;
	header('home.html');
}
else 
{
	echo 'Eingabe ungültig'
	exit();
}


?>