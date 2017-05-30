<?php

function ses_isLoggedIn() {
	return isset($_SESSION['id']) && isset($_SESSION['user']);
}

function ses_login($id, $user) {
	$_SESSION['id'] = $id;
	$_SESSION['user'] = $user;
}

function ses_getId() {
	return $_SESSION['id'];
}

function ses_logout() {
	session_destroy();
}

function getPost($var) {
	return isset($_POST[$var])?$_POST[$var]:null;
}

function getGet($var) {
	return isset($_GET[$var])?$_GET[$var]:null;
}

function redirect($path) {
	header('Location: '.$path);
	exit();
}

function displayPost($post) {
	global $db;
	
	$sid = ses_getId();
	$uid = $post['UID'];
	$pid = $post['PID'];
	$user = $post['User'];
	$text = $post['Text'];
	$img = $post['Image'];
	$is_own = ($uid == $sid);
	$is_liked = $db->isLiked($sid, $pid);
	
	$likestring = "";
	
	if(!$is_own) {
		$likestring = ($is_liked)?
			"<img onclick=\"likeClick($pid);\" width=\"20\" height=\"20\" src=\"img/unlike.png\" alt=\"Gef&auml;llt mir nicht mehr\" value=\"Gef&auml;llt mir nicht mehr\">":
			"<img onclick=\"likeClick($pid);\" width=\"20\" height=\"20\" src=\"img/like.png\" alt=\"Gef&auml;llt mir\ alue=\"Gef&auml;llt mir\">";
	}
	
	$likes = $db->getLikes($pid);
	$time = date("d.m.Y h:i", $post['Timestamp']);
	
	$likestring .= " ".$likes." Person";
	
	if($likes != 1) {
		$likestring .= "en";
	}
	
	$likestring .= " gef&auml;llt das";
	
	
	include 'html/post.html';
}
?>