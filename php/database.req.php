<?php

class DatabaseWrapper {
	private $dbo;
	
	function __construct() {
		try {
			$this->dbo = new PDO('mysql:host=localhost;dbname=thwitter', 'root', '');
		} catch (Exception $e) {
			echo "Konnte keine Verbindung zur Datenbank herstellen!";
			exit();
		}
	}
	
	/* Fügt dem System einen neuen Benutzer hinzu */
	public function createUser($user, $mail, $pass) {
		$user = htmlentities($user);
		$pass = sha1($pass);
		
		$stmt = $this->dbo->prepare('INSERT INTO users (Username, Password, Mail) VALUES (:name, :pass, :mail)');
		$stmt->bindParam(':name', $user);
		$stmt->bindParam(':pass', $pass);
		$stmt->bindParam(':mail', $mail);
		
		return $stmt->execute() == 1;
	}
	
	/* Liefert true, wenn kein Benutzer mit dem übergebenen Namen existiert */
	public function isUserFree($user) {
		$user = htmlentities($user);
		
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Anz FROM users WHERE Username LIKE :name');
		$stmt->bindParam(':name', $user);
		$stmt->execute();
		
		return $stmt->fetch()['Anz'] == 0;
	}
	
	/* Überprüft, ob eine Benutzer/Passwort-Kombination gültig ist */
	public function isLoginValid($user, $pass) {
		$user = htmlentities($user);
		
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Anz, ID, Username, Password FROM users WHERE Username LIKE :name');
		$stmt->bindParam(':name', $user);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result['Anz'] > 0) {
			if(sha1($pass) == $result['Password']) {
				return array($result['ID'], $result['Username']);
			}
		} else {
			return null;
		}
	}
	
	/* Erstellt einen neuen Post für den gegebenen Benutzer */
	public function createPost($userId, $text) {
		$time = time();
		
		$stmt = $this->dbo->prepare('INSERT INTO posts (User, Timestamp, Text) VALUES (:user, :time, :text)');
		$stmt->bindParam(':user', $userId);
		$stmt->bindParam(':time', $time);
		$stmt->bindParam(':text', $text);
		
		return $stmt->execute();
	}
	
	/* Liefert ein Feld mit allen verfügbaren Posts zurück */
	public function getPosts() {
		$prepString = '
			SELECT p.ID AS PID, u.ID AS UID, u.Username AS User, u.Image AS Image, p.Timestamp as Timestamp, p.Text as Text 
			FROM posts p 
				INNER JOIN users u 
					ON p.User = u.ID
			ORDER BY p.Timestamp DESC';
				
		$stmt = $this->dbo->prepare($prepString);	
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	/* Liefert die UserID für eine Post ID */
	public function getPostAuthor($postId) {
		$stmt = $this->dbo->prepare('Select User FROM posts WHERE ID= :id');
		$stmt->bindParam(':id',$postId);
		$stmt->execute();
		
		return $stmt->fetch()['User'];
	}
	
	/* Liefert die Anzahl aller Likes für einen gegebenen Post */
	public function getLikes($postId) {
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Likes FROM likes WHERE Post = :post');
		$stmt->bindParam(':post', $postId);
		$stmt->execute();
		
		return $stmt->fetch()['Likes'];
	}
	
	/* Überprüft ob ein gegebener Beitrag von einem gegebenen Benutzer geliked wurde */
	public function isLiked($userId, $postId) {
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Liked FROM likes WHERE Post = :post AND User = :user');
		$stmt->bindParam(':post', $postId);
		$stmt->bindParam(':user', $userId);
		$stmt->execute();
		
		return $stmt->fetch()['Liked'];
	}
	
	/* Fügt einem Post einen Like des gegebenen Benutzers hinzu - Ein Benutzer kann einen Post nicht mehrfach liken */
	public function addLike($userId, $postId) {
		$stmt = $this->dbo->prepare('INSERT INTO likes (User, Post) VALUES (:user, :post)');
		$stmt->bindParam(':user', $userId);
		$stmt->bindParam(':post', $postId);
		
		return $stmt->execute();
	}

	/* Entfernt einen Like von einem Post */
	public function removeLike($userId, $postId) {
		$stmt = $this->dbo->prepare('DELETE FROM likes WHERE User = :user AND Post = :post');
		$stmt->bindParam(':user', $userId);
		$stmt->bindParam(':post', $postId);
		
		return $stmt->execute();
	}
}
?>