<?php
session_start();
if (isset($_SESSION['user'])) {
	if ($_SESSION['user'] != "admin") {
		header('Location: user.php');
	}
} else {
	header('Location: index.php');
}
require_once('config/database.php');
	// fetching from database the forms
	$conn = database_connect2();
	$sql = "SELECT * FROM formular";
	$result = mysqli_query($conn, $sql);
	$resultArray = array();
	$index = 0;
	while ($row = mysqli_fetch_assoc($result)) {
		$resultArray[$index] = $row;
		$index++;
	}
	$index--;

	//setting some variables to store the form values
	$descriptionForm = "";
	$titleForm = "";
	$genderForm = "";
	$fileForm = "";
	$username = "";
	$email = "";
	$userId = NULL;
	$formId = NULL;

	//fetching form data using 'title'
	if (isset($_POST['formlist'])) {
		$title = $_POST['formlist'];
		$sql = "SELECT id, user_id, description, title, uploaded_file, title, gender FROM formular WHERE title='$title'";
		$result = mysqli_query($conn, $sql);
		$table = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$descriptionForm = $table[0]['description'];
		$titleForm = $table[0]['title'];
		$genderForm = $table[0]['gender'];
		$fileForm = $table[0]['uploaded_file'];
		$userId = $table[0]['user_id'];
		$formId = $table[0]['id'];

		//making a inner join by formular.user_id info from users table
		$sql = "SELECT username, email FROM users INNER JOIN formular ON users.id = '$userId'";
		$result = mysqli_query($conn, $sql);
		$table = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$username = $table[0]['username'];
		$email = $table[0]['email'];
		}
		//delete entire form from database when form is selected and delete button pressed
		if (isset($_POST['delete'])) {
			$tmp = $_POST['title'];
			$sql = "DELETE FROM formular WHERE title='$tmp'";
			mysqli_query($conn, $sql);
		}
		if (isset($_POST['save'])){
			//mage changes in formular table
			$title = $_POST['title'];
			$description = $_POST['description'];
			$gender = $_POST['gender'];
			$file = $_POST['fileForm'];
/*			$userId = $_POST['userId'];*/
			$formId = $_POST['formId'];
			$sql = "UPDATE formular SET title='$title', description='$description', gender='$gender', uploaded_file='$file' WHERE id='$formId'";
			mysqli_query($conn, $sql);
			$em = $_POST['email'];
			$us = $_POST['username'];
			$id = $_POST['userId'];
			//make changes in users table
			$sql = "UPDATE users SET email='$em', username='$us' WHERE id='$id'";
			mysqli_query($conn, $sql);
			echo '<meta http-equiv="refresh" content="0;url=admin.php" />';
		}
		mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin Section</title>
	<?php 
	include 'header.php';
	?>
</head>
<body>
	<form method="post" action="admin.php">
	<div class="form-group">
	<label for="formlist">Forms Submited</label>
	<select name="formlist" class="form-control">
	<option value="" selected disabled hidden>Choose a form to edit:</option>
	<?php
	//here we will list all the availabe forms from database from the last form added to the last
	$i = 0;
	while ($index >= 0) {
		echo "<option id='" . $i . "' " . "onclick='fill_fields()'>" . $resultArray[$index]['title'] . "</option><br>";
		echo $i;
		$i++;
		$index--;
	}
	?>
	</select>
	<br>
	<center>
	<button class="btn btn-info">Select</button>
	</center>
	</div>
	</form>



	<form enctype="multipart/form-data" method="post" action="admin.php">
  	<div class="form-group">

    <label for="title">Title</label>
    <input type="text" class="form-control" name='title' value="<?php echo $titleForm;?>" id="title">

 	<label for="description">Description</label>
    <textarea class="form-control" name="description" rows="3"><?php echo $descriptionForm; ?></textarea><br>

    <label for="gender">Gender (male/female)</label>
    <input type="text" class="form-control" name='gender' value="<?php echo $genderForm; ?>" id="gender">

    <label for="gender">Username</label>
    <input type="text" class="form-control" name='username' value="<?php echo $username; ?>" id="username">

    <label for="email">Email</label>
    <input type="text" class="form-control" name='email' value="<?php echo $email; ?>" id="email">

    <label for="fileForm">Rename file in database:</label>
    <input type="text" class="form-control" name='fileForm' value="<?php echo $fileForm; ?>" id="fileForm">

    <label for="formId">Form ID</label>
    <input type="text" class="form-control" name='formId' value="<?php echo $formId; ?>" id="formId" readonly>

    <label for="userId">User ID</label>
    <input type="text" class="form-control" name='userId' value="<?php echo $userId; ?>" id="userId" readonly>
    
    <br><br>
  	<center>
  		<button type="submit" name="save" class="btn btn-primary">Save</button> 
  		<button type="submit" name="delete" class="btn btn-primary">Delete entire form from database</button></center>
    </div>
</form>
</body>
</html>

<?php
	include ('footer.php');
?>