<!DOCTYPE html>
<html>
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>THwitter - Login</title>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/scheme.css">
	<script type='text/javascript' language='javascript' src="js/login.js"></script>
  </head>
  <body>
	<nav>
		<ul>
			<li class="left">
				<a href="index.php">THwitter</a>
			</li>
			<li class="right">
				<a href="register.php">Registrieren</a>
			</li>
		</ul>
	</nav>
	<main>
	  <section id="login" class="bg">
		<h3>Login</h3>
		<section id="error">
			<?php echo $error;?>
		</section>
		<form name="loginForm" onsubmit="return valid()" method="POST">
			<input type="hidden" name="action" value="login">
			Benutzername:<br>
			<input class="text" type="Text" name="user" placeholder="Benutzername">
			Passwort:<br>
			<input class="text" type="Password" name="pass" placeholder="Passwort">
			<br>
			<a class="button urlbutton" href="register.php">Registrieren</a>
			<input class="button" type="Submit" value="Login">
		</form>
	  </section>
	</main>
	<footer>
		<span class="left">THwitter | <a href="#">Impressum</a></span>
		<span class="right">&copy; 2017</span>
	</footer>
  </body>
</html>
