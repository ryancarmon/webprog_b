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
	
	public function createUser($user, $mail, $pass) {
		$pass = sha1($pass);
		
		$stmt = $this->dbo->prepare('INSERT INTO users (Username, Password, Mail) VALUES (:name, :pass, :mail)');
		$stmt->bindParam(':name', $user);
		$stmt->bindParam(':pass', $pass);
		$stmt->bindParam(':mail', $mail);
		
		return $stmt->execute() == 1;
	}
	
	public function isUserFree($user) {
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Anz FROM users WHERE Username LIKE :name');
		$stmt->bindParam(':name', $user);
		$stmt->execute();
		
		return $stmt->fetch()['Anz'] == 0;
	}
	
	public function isLoginValid($user, $pass) {
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
	
	public function createPost($userId, $text) {
		$time = time();
		
		$stmt = $this->dbo->prepare('INSERT INTO posts (User, Timestamp, Text) VALUES (:user, :time, :text)');
		$stmt->bindParam(':user', $userId);
		$stmt->bindParam(':time', $time);
		$stmt->bindParam(':text', $text);
		
		return $stmt->execute() == 1;
	}
	
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
	
	public function getLikes($postId) {
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Likes FROM likes WHERE Post = :post');
		$stmt->bindParam(':post', $postId);
		$stmt->execute();
		
		return $stmt->fetch()['Likes'];
	}
	
	public function isLiked($userId, $postId) {
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Liked FROM likes WHERE Post = :post AND User = :user');
		$stmt->bindParam(':post', $postId);
		$stmt->bindParam(':user', $userId);
		$stmt->execute();
		
		return $stmt->fetch()['Liked'];
	}
	
	public function addLike($userId, $postId) {
		$stmt = $this->dbo->prepare('INSERT INTO likes (User, Post) VALUES (:user, :post)');
		$stmt->bindParam(':user', $userId);
		$stmt->bindParam(':post', $postId);
		
		return $stmt->execute() == 1;
	}
	
	public function removeLike($userId, $postId) {
		$stmt = $this->dbo->prepare('DELETE FROM likes WHERE User = :user AND Post = :post');
		$stmt->bindParam(':user', $userId);
		$stmt->bindParam(':post', $postId);
		
		return $stmt->execute() == 1;
	}
}
?>