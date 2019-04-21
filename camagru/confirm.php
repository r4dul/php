<?php
	function redirect(){
		header('Location: register.php');
	}
	require_once('config/database.php');
	if (!isset($_GET['email']) || !isset($_GET['token'])){
		redirect();
		exit();
	} else {
		$con = database_connect();
		$email = $_GET['email'];
		$token = htmlspecialchars($_GET['token']);
		$sql = "SELECT id FROM users WHERE email = '$email' AND token = '$token' AND activ = '0'";
		$stmt = $con->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()){
			$sql = "UPDATE users SET activ = '1', token='' WHERE email='$email'";
			$con->exec($sql);
			echo "Your email has been verified. You can now log in!<br>";
			echo "You will be redirected to login page in 3 seconds";
			echo '<meta http-equiv="refresh" content="3;url=login.php" />';
		} else {
			redirect();
		}
	}
?>