<?php
require 'php/database.req.php';
require 'php/functions.req.php';

$db = new DatabaseWrapper();
session_start();
date_default_timezone_set('Europe/Berlin');

/* Ist der Benutzer nicht eingeloggt, wird nur die Startseite angezeigt */
if(!ses_isLoggedIn()) {
	include 'html/index.php';
	exit();
}

/* Ist das POST Action-Flag gesetzt, so hat der Benutzer einen neuen Post abgesendet */
if(getPost('action')) {
	$id = ses_getId();
	$rawtext = getPost('text');
	$text = htmlentities($rawtext, ENT_HTML5);
	
	if(strlen($rawtext) <= 180) {
		$db->createPost($id, $text);
	}		
}

/* Ist das GET Action-Flag gesetzt, so hat der Benutzer einen Post geliked */
if(getGet('action')) {
	$id = ses_getId();
	$post = getGet('pid');
	$uid = $db->getPostAuthor($post);
	
	if(ses_getId() != $uid) {
		if($db->isLiked($id, $post)) {
			$db->removeLike($id, $post);
		} else {
			$db->addLike($id, $post);
		}
	}	
	
	redirect('index.php#post'.$post);
}

$posts = $db->getPosts();
	
include 'html/home.php';



?>