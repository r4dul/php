<?php 
session_start();
include ('header.php');
include_once('config/database.php');
if (isset($_SESSION['token'])) {
	$token = $_SESSION['token'];
	if (isset($_POST['send'])) {
		$pass = $_POST['pass'];
		$pass1 = $_POST['pass2'];
		if ($_POST['code'] == "" || $_POST['pass'] == "" || $_POST['pass2'] == "") {
			echo "<span id='body2' style='color:red';>You must fill all the fields!</span><br>";
		}
		else if ($token != $_POST['code']) {
			echo "<span id='body2' style='color:red';>Your code is incorrect!</span><br>";
		}
		else if ($pass != $pass1) {
			echo "<span id='body2' style='color:red';>Passwords do not match!</span><br>";
		}
		else {
			$user = $_SESSION['user'];
			$con = database_connect();
			$newpass = password_hash($pass, PASSWORD_DEFAULT);
			$sql = "UPDATE users SET pass = '$newpass', token='' WHERE user='$user'";
			$con->exec($sql);
			unset($_SESSION['user']);
			unset($_SESSION['token']);
			echo "<span id='body2' style='color:red';>Your password was successfully changed! You will now be redirected to login page!</span><br>";
			echo '<meta http-equiv="refresh" content="7;url=login.php" />';
		}
	}
} else {
	header ('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset password page</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<form method="post" id='body2' action="reset.php" accept-charset="UTF-8">
		<fieldset>
		<legend>Password Reset</legend>
		<label for="user">Enter the code from your email:</label>
		<input type="text" name="code" maxlength="50">
		<label for="email">Enter your new pass:</label>
		<input type="password" name="pass" maxlength="50">
		<label for="email">Enter again your new pass:</label>
		<input type="password" name="pass2" maxlength="50">
		<input type="submit" value="send" name="send">
		</fieldset>
	</form>
</body>
</html>
<?php
	include ('footer.php');
?>