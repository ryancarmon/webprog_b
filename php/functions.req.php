<?php

/* Überprüft, ob ein Benutzer eingeloggt ist, indem die Sessionvariablen abgeprüft werden */
function ses_isLoggedIn() {
	return isset($_SESSION['id']) && isset($_SESSION['user']);
}

/* Speichert die Benutzerdaten in der aktuellen Session */
function ses_login($id, $user) {
	$_SESSION['id'] = $id;
	$_SESSION['user'] = $user;
}

/* Liefert die ID des aktuell angemeldeten Benutzers */
function ses_getId() {
	return $_SESSION['id'];
}

/* Beendet die Session und meldet den Benutzer dadurch ab */
function ses_logout() {
	session_destroy();
}

/* Überprüft ob eine POST-Variable existiert und liefert diese zurück, sonst null */
function getPost($var) {
	return isset($_POST[$var])?$_POST[$var]:null;
}

/* Überprüft ob eine GET-Variable existiert und liefert diese zurück, sonst null */
function getGet($var) {
	return isset($_GET[$var])?$_GET[$var]:null;
}

/* Leitet den Benutzer auf die gegebene Seite weiter und beendet die Ausführung des Skripts */
function redirect($path) {
	header('Location: '.$path);
	exit();
}

/* Zeigt einen gegebenen Post an */
function displayPost($post) {
	global $db;
	
	$sid = ses_getId();
	$uid = $post['UID'];
	$pid = $post['PID'];
	$user = $post['User'];
	$text = $post['Text'];
	$img = $post['Image'];
	$likes = $db->getLikes($pid);
	$time = date("d.m.Y h:i", $post['Timestamp']);
	$is_own = ($uid == $sid);
	$is_liked = $db->isLiked($sid, $pid);
	
	$likestring = "";
	
	if(!$is_own) {
		$likestring = ($is_liked)?
			"<img onclick=\"likeClick($pid);\" width=\"20\" height=\"20\" src=\"img/unlike.png\" alt=\"Gef&auml;llt mir nicht mehr\" value=\"Gef&auml;llt mir nicht mehr\"> ":
			"<img onclick=\"likeClick($pid);\" width=\"20\" height=\"20\" src=\"img/like.png\" alt=\"Gef&auml;llt mir\" value=\"Gef&auml;llt mir\"> ";
	}
	
	$likestring .= $likes." Person";
	
	if($likes != 1) {
		$likestring .= "en";
	}
	
	$likestring .= " gef&auml;llt das";
	
	include 'html/post.php';
}
?>