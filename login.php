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

/* Wurde das POST-Flag gesetzt, wurde ein Login angefragt */
if($action) {
	$user = getPost('user');
	$pass = getPost('pass');
	
	if(!$user || !$pass) {
		$error = "Es wurden nicht alle Felder ausgef&uuml;llt. Bitte &uuml;berpr&uuml;fe Deine Eingabe!";
		include 'html/login.html';
		exit();
	}
	
	$data = $db->isLoginValid($user, $pass);
	
	if($data) {
		ses_login($data[0], $data[1]);
		redirect('index.php');
	} else {
		$error = "Benutzername oder Passwort falsch. Bitte &uuml;berpr&uuml;fe Deine Eingabe!";
		include 'html/login.html';
		exit();
	}
} else {
	include 'html/login.html';
}