<?php
session_start();
require('database.req.php');
$username = $_POST['user'];
$password = $_POST['pass'];
$mail = $_POST['mail'];

if (function isUserFree ($username) != false)
{
	function createUser($username, $mail, $password)
	header('home.html');
}
else 
{
	exit();
}


?>