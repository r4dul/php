<?php
session_start();
require_once('config/database.php');
if (!(isset($_SESSION['user']))) {
	header("Location: index.php");
}

function user_exists($user){
	$conn = database_connect2();
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
	if ($result->num_rows) {
		return (0);
	}
	return (1);
}

function check_pass($pass) {
	$conn = database_connect2();
	$user = $_SESSION['user'];
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
	$table = mysqli_fetch_all($result,MYSQLI_ASSOC);
	if (password_verify($pass, $table[0]['password'])){
		return(1);
	}
	return (0);
}

function email_exists($email){
	$conn = database_connect2();
	$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
	if ($result->num_rows) {
		return (0);
	}
	return (1);
}

if (isset($_POST['changeemail'])) {
	$conn = database_connect2();
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, $_POST['pass']);

	if ($pass != "" && $email != "") {
		if (check_pass($pass)) {
			if (email_exists($email)) {
				$user = $_SESSION['user'];
				mysqli_query($conn, "UPDATE users SET email = '$email' WHERE username='$user'");
				echo "<center><span style='color:red'>Your email was change with " . $email . "</span></center><br>";
				} else {
					echo "<center><span style='color:red'>Email " . $email . " is already used for another account</span></center><br>";
				}
		} else {
			echo "<center><span style='color:red'>Invalid password!</span></center><br>";
		}
	} else {
		echo "<center><span style='color:red'>Please fill all the fields!</span></center><br>";
	}
}

if (isset($_POST['changeuser'])) {
	$conn = database_connect2();
	$user = mysqli_real_escape_string($conn, $_POST['user']);
	$pass = mysqli_real_escape_string($conn, $_POST['pass']);
	if ($pass != "" && $user != "") {
		if (check_pass($pass)) {
			if (user_exists($user)) {
			$usersession = $_SESSION['user'];
			mysqli_query($conn, "UPDATE users SET username = '$user' WHERE username='$usersession'");
			echo "<center><span style='color:red'>Your username was changed!</span></center><br>";
			$_SESSION['user'] = $user;
			echo '<meta http-equiv="refresh" content="0;url=settings.php" />';
		} else {
			echo "<center><span style='color:red'>Username " . $user . " is already used for another account</span></center><br>";
		}
	} else {
		echo "<center><span style='color:red'>Your entered a wrong password</span></center><br>";
	}
	} else {
		echo "<center><span style='color:red'>Please fill all the fields!</span></center><br>";
	}
}

if (isset($_POST['changepass'])) {
	$conn = database_connect2();
	$pass = mysqli_real_escape_string($conn, $_POST['pass']);
	$pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
	$pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
	if ($pass != "" && $pass1 != "" && $pass2 != ""){
		if (check_pass($pass)) {
			if ($pass1 == $pass2) {
				$user = $_SESSION['user'];
				$hashpass = password_hash($pass1, PASSWORD_DEFAULT);
				mysqli_query($conn, "UPDATE users SET password = '$hashpass' WHERE username='$user'");
				echo "<center><span style='color:red'>Password changed!</span></center><br>";
				echo '<meta http-equiv="refresh" content="0;url=settings.php" />';
			} else {
				echo "<center><span style='color:red'>Password fields do not match!</span></center><br>";
			}
		} else {
			echo "<center><span style='color:red'>Your provided a wrong password!</span></center><br>";
		}
	} else {
		echo "<center><span style='color:red'>All fields are required!</span></center><br>";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>User Settings</title>
	<?php
		include 'header.php';
	?>
</head>
<body>

	<div class="form-group">
		<div class="border border-primary">
		<legend style="color:blue;">Update User Information:</legend>

		<form method='post' accept-charset="UTF-8" action="settings.php">

		<legend>Change password:</legend>
		<label for="pass">Old Pass*:</label>
		<input type="password" name="pass" maxlength="50">
		<label for="pass1">New Pass*:</label>
		<input type="password" name="pass1" maxlength="50">
		<label for="pass2">New Pass again*:</label>
		<input type="password" name="pass2" maxlength="50">
		<input class="btn btn-info" type="submit" name="changepass" value="Change">
	</form>

	<form method='post' accept-charset="UTF-8" action="settings.php">
		<legend>Change user:</legend>			
		<label for="pass">Your Pass*:</label>
		<input type="password" name="pass" maxlength="50">
		<label for="pass">New user*:</label>
		<input type="text" name="user" maxlength="50">
		<input class="btn btn-info" type="submit" name="changeuser" value="Change">
	</form>

	<form method='post' accept-charset="UTF-8" action="settings.php">
		<legend>Change email:</legend>
		<label for="pass">Your Pass*:</label>
		<input type="password" name="pass" maxlength="50">
		<label for="pass">New Email*:</label>
		<input type="text" name="email" maxlength="70">
		<input class="btn btn-info" type="submit" name="changeemail" value="Change"> <br><br>
	</form>
	</div>
</div>

	
		<?php
		$conn = database_connect2();
		$user = $_SESSION['user'];
		$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
		$table = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$userid = $table[0]['id'];
		$result = mysqli_query($conn, "SELECT * FROM formular WHERE user_id='$userid'");
		$table = mysqli_fetch_all($result, MYSQLI_ASSOC);
		foreach ($table as $row) {
			echo "<fieldset>";
			echo '<center><legend style="color:blue;">Update Form:</legend></center>';
			echo "<div class='form-group'>";
			echo "<form method='post' accept-charset='UTF-8' action='settings.php'>";

			echo "<label for='title'>Title</label>";
			echo "<input type='text' class='form-control' id='title' name='title' value='" . $row['title'] . "'><br>";

			echo "<label for='description'>Description</label>";
			echo "<input type='text' class='form-control' id='description' name='description' value='" . $row['description'] . "'><br>";

			echo "<label for='gender'>Gender(male/female)</label>";
			echo "<input type='text' class='form-control' id='gender' name='gender' value='" . $row['gender'] . "'><br>";

			echo "<label for='gender'>File:</label>";
			echo "<input type='text' class='form-control' readonly id='file' name='file' value='" . $row['uploaded_file'] . "'><br>";
			echo '<a href="uploads/' . $row['uploaded_file'] . '"> View Uploaded File </a><br><br>';
			echo "<label for='date'>Created date:</label>";
			echo "<input type='text' class='form-control' readonly id='date' name='date' value='" . $row['created_date'] . "'><br>";

			echo "<label for='formid'>Id:</label>";
			echo "<input type='text' class='form-control' readonly id='formid' name='formid' value='" . $row['id'] . "'><br>";

			echo '<center><input class="btn btn-info" type="submit" name="update" value="Update"> 
			<input class="btn btn-info" type="submit" name="deletefile" value="Delete Uploaded File">
			<input class="btn btn-info" type="submit" name="deleteform" value="Delete Form">
			</center>  <br>';
			echo "</form></div></fieldset>";
		}

		if (isset($_POST['update'])){
			//mage changes in formular table
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$description = mysqli_real_escape_string($conn, $_POST['description']);
			$gender = mysqli_real_escape_string($conn, $_POST['gender']);
			$id = $_POST['formid'];
			mysqli_query($conn, "UPDATE formular SET title='$title', description='$description', gender='$gender' WHERE id='$id'");
			echo '<meta http-equiv="refresh" content="0;url=settings.php" />';
		}

		if (isset($_POST['deletefile'])) {
			$id = $_POST['formid'];
			$file = "uploads/" . $_POST['file'];
			$dbfile = "";
			unlink($file);
			mysqli_query($conn, "UPDATE formular SET uploaded_file='$dbfile' WHERE id='$id'");
			echo '<meta http-equiv="refresh" content="0;url=settings.php" />';
		}

		if (isset($_POST['deleteform'])) {
			$id = $_POST['formid'];
			mysqli_query($conn, "DELETE FROM formular WHERE id='$id'");
			echo '<meta http-equiv="refresh" content="0;url=settings.php" />';
		}

		?>

</body>
</html>