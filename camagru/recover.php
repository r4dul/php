<?php
session_start();
	include ('header.php');
	include_once('config/database.php');
	if (isset($_POST['send'])) {
		$user = htmlspecialchars($_POST['user']);
		$email = htmlspecialchars($_POST['email']);
		if ($user == "" || $email == ""){
			echo "<span id='body2' style='color:red';>User and email fields cannot be empty!</span><br>";
		} else {
			$conn = database_connect();
			$sql = "SELECT id FROM users WHERE (user = '$user' AND email = '$email')";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->fetchColumn()) {
				$token = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
				$token = str_shuffle($token);
				$token = substr($token ,0 , 20);
				$_SESSION['token'] = $token;
				$_SESSION['user'] = $user;
				$subject = "Camagru Password Reset Code";
				$message = "Copy this code and enter it on website: " . $token;
				$headers = 'From: admin@camagru.ro' . "\r\n" .
				'Reply-To: admin@camagru.ro' . "\r\n" .
				'X-Mailer: PHP/' . "\r\n" . 'Content-type:text/html;charset=UTF-8';
				mail($email, $subject, $message, $headers);
				echo "<span id='body2' style='color:red';>Please check your email for a reset code!</span><br>";
				echo "<span id='body2' style='color:red';>You will be redirected to Password Reset Page in 10 seconds!</span><br>";
				echo '<meta http-equiv="refresh" content="10;url=reset.php" />';
			} else {
				echo "<span id='body2' style='color:red';>The username or email you entered does not exist!</span><br>";
			}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Password Recovery Form</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<form method="post" id='body2' action="recover.php" accept-charset="UTF-8">
		<fieldset>
		<legend>Login:</legend>
		<label for="user">Enter your username:</label>
		<input type="text" name="user" maxlength="50">
		<label for="email">Enter your email:</label>
		<input type="text" name="email" maxlength="50">
		<input type="submit" value="send" name="send">
		</fieldset>
	</form>
</body>
</html>

<?php
	include ('footer.php');
?>