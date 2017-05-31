<!DOCTYPE html>
<html>
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>THwitter - Timeline</title>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" type="text/css" href="css/scheme.css">
	<script type='text/javascript' language='javascript' src="js/post.js"></script>
  </head>
  <body>
  
	<nav>
		<ul>
			<li class="left">
				<a href="index.php">THwitter</a>
			</li>
			<li class="right">
				<a href="logout.php">Logout</a>
			</li>
			<li class="right">
				<a href="javascript:showModal();">Beitrag verfassen</a>
			</li>
		</ul>
	</nav>
	
	<div id="postModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" onclick="closeModal()">&times;</span>
				<h2>Beitrag verfassen</h2>
			</div>
			<div class="modal-body">
				<form onsubmit="return postValid()" method="POST">
					<input type="hidden" name="action" value="post">
					<textarea id="postText" name="text" placeholder="..."></textarea>
					<input id="postBtn" class="button" type="Submit" value="Posten">
				</form>
			</div>
		</div>
	</div>
	
	<main>
		<section id="home">
		  <?php
				foreach($posts as $post) {
					displayPost($post);
				}
			?>
		</section>
	</main>
	<footer>
		<span class="left">THwitter | <a href="#">Impressum</a></span>
		<span class="right">&copy; 2017</span>
	</footer>
  </body>
</html>
