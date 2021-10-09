<?php

	class User {
		protected $pdo;

		function __construct($pdo){
			$this->pdo = $pdo;
		}
		public function checkInput($varb)
		{
			$varb = htmlspecialchars($varb);
			$varb = trim($varb);
			$varb = stripcslashes($varb);
			return $varb;
		}

		public function preventAccess($request, $currentFile, $currently){
			if ($request == "GET" && $currentFile == $currently) {
				header('Location: '.BASE_URL.'index.php');
			}
		}

		public function search($search){
			$stmt = $this->pdo->prepare("SELECT `id`, `username`, `screenName`, `profileimage`, `profilecover` FROM `users` WHERE `username` LIKE ? OR `screenName` LIKE ?");
			$stmt->bindValue(1, $search.'%', PDO::PARAM_STR);
			$stmt->bindValue(2, $search.'%', PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function login($email, $password){
			$stmt = $this->pdo->prepare("SELECT id, role FROM users WHERE email = :email AND password = :password");
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_OBJ);
			$role = $user->role;
			$count = $stmt->rowCount();
			if($count > 0){
				$_SESSION['id'] = $user->id;
				if ($role =="admin") {
					header('Location: ../admin/home.php');
				}elseif ($role == "employee") {
					header('Location: ../employee/home.php');
				}elseif ($role == "user") {
					header('Location: ../home.php');
				}else{
					return "false";
				}

			}
		}

		public function userData($id){
			$stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id ");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function getAllList(){
			$stmt = $this->pdo->prepare("SELECT * FROM users ");
			$stmt->execute();
			$users = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $users;

			// return mysqli_query($connect->connString,$sql);
		}

		public function logout(){
			$_SESSION = array();
			session_destroy();
			header('Location: '.BASE_URL.'index.php');
		}

		public function checkEmail($email){
			$stmt = $this->pdo->prepare("SELECT `email` FROM users WHERE email = :email ");
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			if ($count > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function checkUsername($username){
			$stmt = $this->pdo->prepare("SELECT `username` FROM `users` WHERE `username` = :username ");
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			if ($count > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function checkPassword($password){
			$stmt = $this->pdo->prepare("SELECT `password` FROM `users` WHERE `password` = :password ");
			$stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			if ($count > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function loginCheck(){
			return (isset($_SESSION['id'])) ? true : false;
		}

		public function register($email,$screenName, $password){
			// $usernaming = explode(' ', $screenName);
			// $use = $usernaming[0];

			$stmt = $this->pdo->prepare("INSERT INTO `users`(`username`, `email`, `password`, `screenName`, `profileimage`, `profilecover`) VALUES (:screenName, :email, :password, :screenName, 'assets/images/defaultprofileimage.PNG', 'assets/images/defaultCoverImage.png')");
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
			$stmt->bindParam(":screenName", ($screenName), PDO::PARAM_STR);
			$stmt->execute();
			$id = $this->pdo->lastInsertId();
			$_SESSION['id'] = $id;
		}

		public function create($table, $fields = array()){
			$columns = implode(',', array_keys($fields));
			$values = ':' .implode(', :', array_keys($fields));
			$sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
			if($stmt = $this->pdo->prepare($sql)){
				foreach ($fields as $key => $data) {
					$stmt->bindValue(':' .$key, $data);
				}
				$stmt->execute();
				return $this->pdo->lastInsertId();
			}
		}

		public function update($table, $id, $fields = array()){
			$columns = '';
			$i = 1;
			foreach ($fields as $name => $value) {
				$columns .= "`{$name}` = :{$name}";
				if($i < count($fields)){
					$columns .= ', ';
				}
				$i++;
			}
			$sql = "UPDATE {$table} SET {$columns} WHERE `id` = {$id}";
			if ($stmt = $this->pdo->prepare($sql)) {
				foreach ($fields as $key => $value) {
					$stmt->bindValue(':'.$key, $value);
				}
				$stmt->execute();
			}
		}

		public function uploadImage($file){
			$filename = basename($file['name']);
			$fileTmp = $file['tmp_name'];
			$fileSize = $file['size'];
			$error = $file['error'];
			$ext = explode('.', $filename);
			$ext = strtolower(end($ext));
			$allowed_ext = array('png','jpg','jped', 'ico');
			if(in_array($ext, $allowed_ext) === true){
				if ($error === 0) {
					if ($fileSize <= 209272152) {
						$fileRoot = 'users/' . $filename;
						move_uploaded_file($fileTmp, $_SERVER['DOCUMENT_ROOT'].'/addischat/'. $fileRoot);
						return $fileRoot;

					}else{
				$GLOBALS['imageError'] = 'the image is too large!';

					}
				}
			}else{
				$GLOBALS['imageError'] = 'the image is not supported!';
			}
		}

		public function idByUser($username){
			$stmt = $this->pdo->prepare("SELECT `id` FROM `users` WHERE username = :username ");
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_OBJ);
			return $user->id;
		}
		public function delete($table, $array){
			$sql = "DELETE FROM `{$table}`";
			$where =" WHERE ";
			foreach ($array as $name => $value) {
				$sql .= "{$where} `{$name}` = :{$name}";
				$where = " AND ";
			}
			if ($stmt = $this->pdo->prepare($sql)) {
				foreach ($array as $name => $value) {
					$stmt->bindValue(':'.$name, $value);
				}
				// var_dump($sql);
				$stmt->execute();
			}

		}

		public function timeAgo($datetime){
			$time = strtotime($datetime);
			$current = time();
			$seconds = $current - $time;
			$minutes = round($seconds / 60);
			$hours = round($seconds / 3600);
			$months = round($seconds / 2600640);
			if ($seconds <= 60) {
				if ($seconds == 0) {
					return 'Now';
				}else {
					return $seconds.'s ago';
				}
				}else if ($minutes <= 60) {
					return $minutes.'m ago';
				}else if ($hours <= 24) {
					return $hours.'h ago';
				}else if ($months <= 12) {
					return date('M j', $time);
				}else {
					return date('Y - m - j', $time);
				}
		}
	}
 ?>
