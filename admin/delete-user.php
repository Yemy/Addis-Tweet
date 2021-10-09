<?php 

if (isset($_GET['id']) && !empty($_GET['id'])) {
	$recordId = intval($_GET['id']);

	if (is_int($recordId)) {
		require('../includes/php/connect.php');

		$connect = new Connect();
		$connect->connect_DB();

		$sql = "DELETE FROM `user` WHERE `id`={$recordId}";

		$result = mysqli_query($connect->connString,$sql);

		if (mysqli_affected_rows($connect->connString) > 0) {
			header("refresh:5; url=../page/users.php");
			echo "Record Deleted Successfully. You will be redirected in about 5 secs. if NOT click <a href='../page/users.php' >here</a>.";
			exit();
		}
		var_dump(mysqli_error($conn->connString));
		die();
	}
}



?>