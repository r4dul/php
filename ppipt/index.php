<?php
session_start();
if (isset($_SESSION['user'])){
	if ($_SESSION['user'] == admin) {
		header('Location: admin.php');
	} else {
		header('Location: user.php');
	}
}
require_once('config/database.php');
$ok = 0;
	//checking if input data is valid for user registration
	if (isset($_POST['register'])) {
		if (($_POST['user'] != "") && ($_POST['email'] != "") && ($_POST['password'] != "") && ($_POST['password1'] != "")) {
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$ok += 1;
			}
			else
			{
				echo "<center><span style='color:red';>Your email is not valid!</span></center><br>";
				$ok = 0;
			}
			if (strlen($_POST['password']) > 7){
			$ok += 1;
			}
			else{
				echo "<center><span style='color:red';>Your password must be at least 8 characters!</span></center><br>";
				$ok = 0;
			}
			if ($_POST['password'] == $_POST['password1']) {
				$ok += 1;
			} else {
				echo "<center><span style='color:red'>Passwords do not match</span></center><br>";
			}
			//if all the field inputs are valid we will check if there is another account with that username or email.
			if ($ok == 3) {
				$conn = database_connect2();
				//check inputs for security
				$username = mysqli_real_escape_string($conn, $_POST['user']);
				$password = mysqli_real_escape_string($conn, $_POST['password']);
				$email = mysqli_real_escape_string($conn, $_POST['email']);
				//check if username exists in database
				$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
				if ($result->num_rows) {
					echo "<center><span style='color:red'>The username already exists!</span></center><br>";
				} else {
					$ok += 1;
				}
				//check if email exists in database
				$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if ($result->num_rows) {
					echo "<center><span style='color:red'>The is another username using this email!</span></center><br>";
				} else {
					$ok += 1;
				}
				//if everything is ok we will add the data into database
				if ($ok == 5) {
					// hashing the password to store it into database
					$pass = password_hash($password, PASSWORD_DEFAULT);
					mysqli_query($conn, "INSERT INTO users(username, email, password) VALUES ('$username', '$email', '$pass')");
					echo "<center><span style='color:red'>Your username was created. You may now login!</span></center><br>";
					mysqli_close($conn);
				}

			}
		} else {
			echo "<center><span style='color:red'>All fields are required!</span></center><br>";
		}
	} else if (isset($_POST['login'])) {
		if (($_POST['username'] != "") && ($_POST['password'] != "")) {
			//check in database to see if input data coresponds with database data
			$conn = database_connect2();
			//security check
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			//check if username exists in database
			$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
			if ($result->num_rows) {
				//if username exist we will check if input password matches
				$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
				$table = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if (password_verify($password, $table[0]['password'])){
					//user verification complete. we will redirect the user and we will start a session with the user.
					$_SESSION['user'] = $username;
					$_SESSION['user_id'] = $table[0]['id'];
					// here I want the admin user to be sent to the admin page and the user to the user page
					// We could also add another field in database to identify the user role (admin/user) but for this project we 
					// will restrict access to the admin page for 'admin' user only.
					if ($username == "admin") {
						header('Location: admin.php');
					} else {
						header('Location: user.php');
				}
				} else {
					echo "<center><span style='color:red';>Your username or password do not match</span></center><br>";
				}
				} else {
					echo "<center><span style='color:red';>Your username or password do not match</span></center><br>";
				}
		} else {
			echo "<center><span style='color:red';>Your password field or username field was empty. Try again!</span></center><br>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Proba Practica Intensive PHP Training</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top:100px;">
		<center><img src="images/logo.png"></center><br><br>
		<div class="row justify-content-left">

				<div class="col-md-6 col-md-offset-3 align='left'">
					<legend>User registration:</legend>
					<form method="post" action="index.php">
					<input class="form-control" type="text" name="user" placeholder="Username"><br>
					<input class="form-control" type="text" name="email" placeholder="Email"><br>
					<input class="form-control" type="password" name="password" placeholder="Password"><br>
					<input class="form-control" type="password" name="password1" placeholder="Confirm Password"><br>
					<center> <input class="btn btn-info" type="submit" name="register" value="Register"> </center>
				</form>
			</div>
				<div class="col-md-6 col-md-offset-3 align='right'">
					<legend>User Login:</legend>
					<form method="post" action="index.php">
					<input class="form-control" type="text" name="username" placeholder="Username"><br>
					<input class="form-control" type="password" name="password" placeholder="Password"><br>
					<center><input class="btn btn-info" type="submit" name="login" value="Login"><br></center>
					</form>
		</div>
	</div>
</body>
</html>

<?php
	include ('footer.php');
?>