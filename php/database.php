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
		echo $pass;
		
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
		$stmt = $this->dbo->prepare('SELECT COUNT(*) AS Anz, ID, Password FROM users WHERE Username LIKE :name');
		$stmt->bindParam(':name', $user);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result['Anz'] > 0) {
			if(sha1($pass) == $result['Password']) {
				return $result['ID'];
			}
		} else {
			return false;
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
	
	public function deletePost($postId) {
		$stmt = $this->dbo->prepare('DELETE FROM posts WHERE ID = :id');
		$stmt->bindParam(':id', $postId);
		
		return $stmt->execute() == 1;
	}
	
	public function getPosts() {
		$prepString = '
			SELECT u.Username AS User, p.Timestamp as Timestamp, p.Text as Text 
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

$db = new DatabaseWrapper();

if($db->isUserFree("Testuser")) {
	echo "Testuser frei! <br>";
} else {
	echo "Testuser belegt! <br>";
}
if($db->isUserFree("Bla")) {
	echo "Bla frei!";
	$db->createUser("Bla","abc","124");
} else {
	echo "Bla belegt <br>";
}

echo $db->isLoginValid("Bla", "124");
echo "<br>";
print_r( $db->getPosts());
echo "<br>";
echo $db->getLikes(1);
$db->removeLike(1, 1);
echo "<br>".$db->getLikes(1);
$db->addLike(1, 1);
echo "<br>".$db->getLikes(1);


?>