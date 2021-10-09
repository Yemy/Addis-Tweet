<?php 

if (isset($_POST['saveUpdate']) && !empty($_POST['id'])) {
	
	require "userModel.php";

	$user = new User();

	$user->id = intval($_POST['id']);
	$user->first_name = $_POST['first_name'];
	$user->middle_name = $_POST['middle_name'];
	$user->last_name = $_POST['last_name'];
	$user->gender = $_POST['gender'];
	$user->phone = $_POST['phone'];

	$user->recordLoded = true;

	$record = $user->findRecord($user->id);

	if (is_array($record) && count($record) > 0) {
		if (is_null($record['username']) || empty($record['username'])) {
			$user->username = $user->getUserName();

			$user->password = md5($user->getPassword());
		}else{
			$user->username = $record['username'];
		}
	}else{
		echo "Error : Such record NOT found!";
		die();
	}

	// serialize(value)

	$res = $user->updateRecord();

	if ($res == true) {
		header("refresh:5; url=../page/users.php");
		echo "Record Updated Successfully. You will be redirected in about 5 secs. if NOT click <a href='../page/users.php' >here</a>.";
		exit();
	}else{

		echo "Error : {$res}";
		die();
	}
}else{
	print_error('INVALID Operation!');
}



 ?>