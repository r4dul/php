<?php
require_once('config/database.php');
include ('header.php');
$ok = 0;
if (isset($_POST['create']))
{
	if (!($_POST['user'] == "") && !($_POST['pass'] == "") && !($_POST['email'] == "")){
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$ok += 1;
		}
		else
		{
			echo "<span id='body2' style='color:red';>Your email is not valid</span><br>";
			$ok = 0;
		}
		if (strlen($_POST['pass']) > 7){
			$ok += 1;
		}
		else{
			echo "<span id='body2' style='color:red';>Your password must be at least 8 characters!</span><br>";
			$ok = 0;
		}
		//putting user input in a variable using htmlspecialchars to avoid sql injection.
		$user1 = htmlspecialchars($_POST['user']);
		$email1 = htmlspecialchars($_POST['email']);
		$pass1 = htmlspecialchars($_POST['pass']);
		//check if user already exists or not in database
		$conn = database_connect();
		$sql = "SELECT id FROM users WHERE user = '$user1'";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()){
			echo "<span id='body2' style='color:red';>The user: '" . $_POST['user'] . "' already exists.</span><br>";
		}
		else {
			$ok += 1;
		}
		//check if email is in database
		$sql = "SELECT id FROM users WHERE email = '$email1'";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()){
			echo "<span id='body2' style='color:red';>The email: '" . $_POST['email'] . "' already exists.</span><br>";
		}
		else {
			$ok += 1;
		}
		if ($ok == 4){
			$token = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
			$token = str_shuffle($token);
			$token = substr($token ,0 , 10);
			echo "<span id='body2' style='color:blue';>Your user: '".$_POST['user']."' was created using your email: '".$_POST['email']."'.</span><br>";
			echo "<span id='body2' style='color:red';>Check your email: '" . $_POST['email'] . "' to confirm your account.</span><br>";
			$subject = "Welcome to Camagru";
			$message = "Please click on the link below to confirm your 'camagru' account: <br><br>
			<a href='http://localhost/confirm.php?email=$email1&token=$token'>Click here to confirm</a>";
			$headers = 'From: admin@camagru.ro' . "\r\n" .
			'Reply-To: admin@camagru.ro' . "\r\n" .
			'X-Mailer: PHP/' . "\r\n" . 'Content-type:text/html;charset=UTF-8';
			mail($email1, $subject, $message, $headers);
			$pass2 = password_hash($pass1, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users (user, pass, email, token, activ) VALUES ('$user1', '$pass2', '$email1', '$token', '0')";
			$conn->exec($sql);
		}
	}
	else
	{
		echo "<span id='body2' style='color:red';>All fields are required!</span><br>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Registration Form</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<form method='post' id='body2' accept-charset="UTF-8">
		<fieldset>
			<legend>Register</legend>
			<label for="email">Email*:</label>
			<input type="text" name="email" maxlength="70">
			<label for="user">Username*:</label>
			<input type="text" name="user" maxlength="50">
			<label for="pass">Password*:</label>
			<input type="Password" name="pass" maxlength="50">
			<input type="submit" name="create" value="create">
		</fieldset>
	</form>
</body>
</html>

<?php 
include ("footer.php");
?>