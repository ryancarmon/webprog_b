<?php
require 'php/database.req.php';
require 'php/functions.req.php';

$db = new DatabaseWrapper();
session_start();
date_default_timezone_set('Europe/Berlin');


if(getPost('action') && ses_isLoggedIn()) {
	$id = ses_getId();
	$text = htmlentities(getPost('text'), ENT_HTML5);
		
	$db->createPost($id, $text);
}

if(getGet('action') && ses_isLoggedIn()) {
	$id = ses_getId();
	$post = getGet('pid');
	
	if($db->isLiked($id, $post)) {
		$db->removeLike($id, $post);
	} else {
		$db->addLike($id, $post);
	}
	
	redirect('index.php#post'.$post);
}

if(ses_isLoggedIn()) {
	$posts = $db->getPosts();
		
	include 'html/home.html';
} else {
	include 'html/index.html';
}


?>