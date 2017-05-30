<?php
require 'php/database.req.php';
require 'php/functions.req.php';

$db = new DatabaseWrapper();
session_start();

if(ses_isLoggedIn()) {
	redirect('index.php');
}

$action = getPost('action');
$error = "";

if($action) {
	$user = getPost('user');
	$mail = getPost('mail');
	$pass = getPost('pass');
	$pass2 = getPost('pass_confirm');
	
	if(!($user && $mail && $pass && $pass2)) {
		$error = "Es wurden nicht alle Felder ausgef&uuml;llt. Bitte &uuml;berpr&uuml;fe Deine Eingabe!";
		include 'html/register.html';
		exit();
	}
	if($pass != $pass2) {
		$error = "Die Passw&ouml;rter stimmen nicht &uuml;berein!";
		include 'html/register.html';
		exit();
	}
	
	if(!$db->isUserFree($user)) {
		$error = "Der gew&auml;hlte Benutzername ist bereits vergeben!";
		include 'html/register.html';
		exit();
	}
	
	$db->createUser($user, $mail, $pass);
	redirect('login.php');
} else {
	include 'html/register.html';
}


?>
