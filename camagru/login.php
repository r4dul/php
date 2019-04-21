<?php
session_start();
require_once('config/database.php');
include ('header.php');
if (isset($_POST['login']))
{
	if (!($_POST['user'] == "") && !($_POST['pass'] == "")){
		//putting user input in a variable using htmlspecialchars to avoid sql injection.
		$user1 = htmlspecialchars($_POST['user']);
		$pass1 = $_POST['pass'];
		//check if user already exists or not in database
		$conn = database_connect();
		$sql = "SELECT id, pass, activ FROM users WHERE user = '$user1'";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()){
			$sth = $conn->prepare("SELECT id, pass, activ FROM users WHERE user = '$user1'");
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			if (password_verify($pass1, $result['pass'])) {
				if ($result['activ'] == 0) {
					echo "<span id='body2' style='color:red';>Please verify your email!</span><br>";
				} else {
					// here i can create a session
					$_SESSION['login_user'] = $user1;
					/*echo "<span id='body2' style='color:red';>You have been logged in!</span><br>";
					echo "<h1 id='body2'>You will be redirected to homepage in 3 seconds</h1><br>";*/
					echo '<meta http-equiv="refresh" content="0;url=index.php" />';
				}
			} else {
				echo "<span id='body2' style='color:red';>Your user or password do not match!</span><br>";
			}
		}
		else {
			echo "<span id='body2' style='color:red';>Your user or password do not match!</span><br>";
		}
		
	}
	else
	{
		echo "<span style='color:red';>All fields are required!</span><br>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Login Form</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<form id="body2" method='post' action='login.php' accept-charset="UTF-8">
		<fieldset>
			<legend>Login:</legend>
			<label for="user">Username*:</label>
			<input type="text" name="user" maxlength="50">
			<label for="pass">Password*:</label>
			<input type="Password" name="pass" maxlength="50">
			<input type="submit" name="login" value="Login">
		</fieldset>
	</form>
	<a id='body2' href="recover.php">I forgot my password!</a><br>
</body>
</html>

<?php 
include ("footer.php");
?>