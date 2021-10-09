<?php 
/**
 * This is user model class 
 * This class can be easly instantiated with some sort of values
 */

require_once('../includes/php/connect.php');
class User
{

	// here we have global variables which directly maps to relation attributes in <user> table.
	protected $pdo;
	public $first_name, $middle_name,$last_name,$gender, $phone, $username, $password;
	public $recordLoded = false;

	public function login($username, $password){
		$stmt = $this->pdo->prepare("SELECT id FROM user WHERE username = :username AND password = :password");
		$stmt->bindParam(":username", $username, PDO::PARAM_STR);
		$stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		$count = $stmt->rowCount();
		// if($count > 0){
		// 	$_SESSION['id'] = $user->id;
		// 	header('Location: home.php');
		// }else{
		// 	return "false";
		// }
	 }
	
	public function saveRecord(){
		if ($this->recordLoded) {
			
			$sql = "
				INSERT INTO `user`(`first_name`, `middle_name`, `last_name`, `gender`, `phone`, `username`,`password`) 
				VALUES ('$this->first_name','$this->middle_name','$this->last_name','$this->gender','$this->phone','$this->username','$this->password')";

			$connect = new Connect();

			$connect->connect_DB();

			$result = mysqli_query($connect->connString,$sql);

			if (mysqli_affected_rows($connect->connString) > 0) {
				return true;
			}

			return mysqli_error($connect->connString);
		}
	}

	public function updateRecord(){
		if ($this->recordLoded && !empty($this->id)) {
			$this->connectDb();

			$sql = "UPDATE `user` 
					SET 
						`first_name`='$this->first_name',
						`username`='$this->username',
						`middle_name`='$this->middle_name',
						`last_name`='$this->last_name',
						`gender`='$this->gender',
						`phone`='$this->phone'
					WHERE 
						`id`=$this->id"
					;

			$result = mysqli_query($this->connString,$sql);

			if (mysqli_affected_rows($this->connString) > 0) {
				return TRUE;
			}else{
				return mysqli_error($this->connString);
			}
		}
	}


	public function getAssignedRole($userId){
		$this->connectDb();
		$sql = "SELECT * FROM `assignment` where `user_id`={$userId}";

		$roles = mysqli_query($this->connString,$sql);

		$response = "";
		require_once('../logic/assignmentModel.php');
		$assignmentModel = new Assignment();

		if ($roles && mysqli_num_rows($roles) > 0) {
			while ($role = mysqli_fetch_array($roles)) {
				// $roleName = ;
				$response .= "{$assignmentModel->getRoleInfo($role['role_id'])}<br>";
			}
		}else{
			$response = '';
		}

		return $response;
	}

	public function getUserName(){
		return str_replace(' ', '', $this->first_name .'_'. $this->middle_name .'_'. rand(0,99));
	}

	public function getPassword(){
		return "0000";
	}

	public function getAllList(){
		$connect = new Connect();

		$connect->connect_DB();

		$sql = "SELECT * FROM `user`";

		return mysqli_query($connect->connString,$sql);
	}

	public function findRecord($id){
		$this->connectDb();

		$sql = "SELECT * FROM `user` WHERE `id`={$id} LIMIT 1";

		if(($result =  mysqli_query($this->connString,$sql)) != NULL) {
			return mysqli_fetch_array($result);
		}

		vardump(mysqli_error($this->connString));
		die();


	}


	private function connectDb(){

		$connect = new Connect();
		$connect->connect_DB();

		$this->connString = $connect->connString;
	}
}



?>