<?php 
	session_start();
	include 'header2.php';
	include 'config/database.php';
	//function to check if input password it's the same as pass from database;
	function validate_pass($pass) {
		$user = $_SESSION['login_user'];
		$sql = "SELECT id FROM users WHERE user = '$user'";
		$conn = database_connect();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()) {
			$sth = $conn->prepare("SELECT pass FROM users WHERE user = '$user'");
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			if (password_verify($pass, $result['pass'])) {
				return (1);
			}
		}
		return (0);
	}

	function user_exists($str){
		$sql = "SELECT id FROM users WHERE user = '$str'";
		$conn = database_connect();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()) {
			return (0);
		} else {
		return (1);
		}
	}

	function email_exists($str){
		$sql = "SELECT id FROM users WHERE email = '$str'";
		$conn = database_connect();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()) {
			return (0);
		} else {
			return (1);
		}
	}

	if(isset($_SESSION['login_user'])) {
		if (isset($_POST['changepass'])) {
			$pass = htmlspecialchars($_POST['pass']);
			$pass1 = htmlspecialchars($_POST['pass1']);
			$pass2 = htmlspecialchars($_POST['pass2']);
			if ($pass != "" && $pass1 != "" && $pass2 != ""){
			if (validate_pass($pass)) {
				if ($pass1 == $pass2) {
					$conn = database_connect();
					$user = $_SESSION['login_user'];
					$hashpass = password_hash($pass1, PASSWORD_DEFAULT);
					$sql = "UPDATE users SET pass = '$hashpass' WHERE user='$user'";
					$conn->exec($sql);
					echo "<br><br><span style='color:red'; id='sp';>Your password was changed!</span><br>";
				} else {
					echo "<br><br><span style='color:red'; id='sp';>New password do not match!</span><br>";
				}
			} else {
				echo "<br><br><span style='color:red'; id='sp';>You typed a wrong password!</span><br>";
			}
		} else {
			echo "<br><br><span style='color:red'; id='sp';>You must fill all the fields!</span><br>";
		}
		}
		if (isset($_POST['changeuser'])) {
			$pass = htmlspecialchars($_POST['pass']);
			$user = htmlspecialchars($_POST['user']);
			if ($pass != "" && $user != "") {
				if (validate_pass($pass)) {
					if (user_exists($user)) {
					$conn = database_connect();
					$usersession = $_SESSION['login_user'];
					$sql = "UPDATE users SET user = '$user' WHERE user='$usersession'";
					$conn->exec($sql);
					echo "<br><br><span style='color:red'; id='sp';>Your user was changed!</span><br>";
					$_SESSION['login_user'] = $user;
				} else {
					echo "<br><br><span style='color:red'; id='sp';>Pick another username. This one already exists!</span><br>";
				}
			} else {
				echo "<br><br><span style='color:red'; id='sp';>You typed a wrong password!</span><br>";
			}
			} else {
				echo "<br><br><span style='color:red'; id='sp';>You must fill all the fields!</span><br>";
			}
		}

		if (isset($_POST['changeemail'])) {
			$pass = htmlspecialchars($_POST['pass']);
			$email = htmlspecialchars($_POST['email']);
			if ($pass != "" && $email != "") {
				if (validate_pass($pass)) {
					if (email_exists($email)) {
						$conn = database_connect();
						$user = $_SESSION['login_user'];
						$sql = "UPDATE users SET email = '$email' WHERE user='$user'";
						$conn->exec($sql);
						echo "<br><br><span style='color:red'; id='sp';>Your email was changed!</span><br>";
					} else {
						echo "<br><br><span style='color:red'; id='sp';>This email was already used!</span><br>";
					}
				} else {
					echo "<br><br><span style='color:red'; id='sp';>You typed a wrong password!</span><br>";
				}
			} else {
				echo "<br><br><span style='color:red'; id='sp';>You must fill all the fields!</span><br>";
			}
		}

		if (isset($_POST['deactivate'])){
			$conn = database_connect();
			$user = $_SESSION['login_user'];
			$sql = "UPDATE users SET emailpref = '0' WHERE user='$user'";
			$conn->exec($sql);
		}

		if (isset($_POST['activate'])){
			$conn = database_connect();
			$user = $_SESSION['login_user'];
			$sql = "UPDATE users SET emailpref = '1' WHERE user='$user'";
			$conn->exec($sql);
		}

		if (isset($_POST['delete'])){
			$conn = database_connect();
			$image = $_POST['delete'];
			$user = $_SESSION['login_user'];
			$sql = "DELETE FROM images where image='$image' AND user='$user'";
			$conn->exec($sql);
		}

	}
	else {
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
		<form method='post' accept-charset="UTF-8" id="body2">
		<fieldset>
			<legend>Change password:</legend>
			<label for="pass">Old Pass*:</label>
			<input type="password" name="pass" maxlength="50">
			<label for="pass1">New Pass*:</label>
			<input type="password" name="pass1" maxlength="50">
			<label for="pass2">New Pass again*:</label>
			<input type="password" name="pass2" maxlength="50">
			<input type="submit" name="changepass" value="Change">
		</fieldset>
		</form>

		<form method='post' accept-charset="UTF-8" id="body2">
		<fieldset>
			<legend>Change user:</legend>
			<label for="pass">Your Pass*:</label>
			<input type="password" name="pass" maxlength="50">
			<label for="pass">New user*:</label>
			<input type="text" name="user" maxlength="50">
			<input type="submit" name="changeuser" value="Change">
		</fieldset>
		</form>

		<form method='post' accept-charset="UTF-8" id="body2">
		<fieldset>
			<legend>Change email:</legend>
			<label for="pass">Your Pass*:</label>
			<input type="password" name="pass" maxlength="50">
			<label for="pass">New Email*:</label>
			<input type="text" name="email" maxlength="70">
			<input type="submit" name="changeemail" value="Change">
		</fieldset>
		</form>
		<form method='post' id='body2' accept-charset="UTF-8">
			<fieldset>
				<legend>Activate or deactivate emails</legend>
				<center>
					<button name="deactivate">Deactivate Emails</button>
					<button name="activate">Activate Emails</button>
				</center>
			</fieldset>
		</form>


			<fieldset>
				<legend id='body2'>Choose a picture to delete: </legend>
				<?php
					$user = $_SESSION['login_user'];
					$conn = database_connect();
					$sql = "SELECT image FROM images  WHERE user='$user' ORDER BY id DESC LIMIT 10";
					foreach ($conn->query($sql) as $row) {
						echo "<form method='post' id='body2'>";
						echo '<img name="image" value="' . $row['image'] . '" ' . 'src="uploads/' . $row['image'] . '">';
						echo "<button value='" . $row['image'] . "'" . "name='delete'>Delete</button>";
						echo "</form>";
					}
				?>
			</fieldset>

</body>
</html>

<?php 
include ("footer.php");
?>