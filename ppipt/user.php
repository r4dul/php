<?php
session_start();
require_once('config/database.php');
	//if submit button is clicked we will check user input, all fields must be filled before we upload user input into database
	if (isset($_POST['submit'])) {
		if (($_POST['title'] != "") && ($_POST['description'] != "") && ($_POST['radiobutton'] != "") &&  !(empty($_FILES['uploadfile']))) {
			
			//we can now save data into database
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
			$upfile = basename($_FILES["uploadfile"]["name"]);
			$uploadOk = 1;
			//check if the file is too large
			if ($_FILES["uploadfile"]["size"] > 500000) {
			    echo "<center><span style='color:red'>Sorry, your file is too large.</span></center><br>";
			    $uploadOk = 0;
			}
			// we will upload the files into /uploads/ folder
			//since we don't know what types of files we will allow I won't add any other checks and we will allow everything. Not
			// recommended I know.
			if ($uploadOk != 0) {
				if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
        			echo "<center><span style='color:red'>The file '". basename( $_FILES["uploadfile"]["name"]). "' has been uploaded.</span></center><br>";
    		} else {
        		echo "<center><span style='color:red'>Sorry, there was an error uploading your file.</span></center><br>";
    			}
			}
			// we will now save the other fields in database_connect2
			$conn = database_connect2();
			$tit = mysqli_real_escape_string($conn, $_POST['title']);
			$des = mysqli_real_escape_string($conn, $_POST['description']);
			$gen = mysqli_real_escape_string($conn, $_POST['radiobutton']);
			$id = $_SESSION['user_id'];
			mysqli_query($conn, "INSERT INTO formular(user_id, title, description, uploaded_file, gender) VALUES('$id', '$tit', '$des', '$upfile', '$gen')");
			echo "<center><span style='color:red'>Your formular has been submited.</span></center><br>";
			mysqli_close($conn);
		} else {
			echo "<center><span style='color:red'>You must fill all fields</span></center><br>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Crearea formularului</title>
	<?php 
	include 'header.php';
	?>
</head>
<body>
	<form enctype="multipart/form-data" method="post" action="user.php">
  	<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name='title'>
 	<label for="description">Description</label>
    <textarea class="form-control" name="description" rows="4"></textarea><br>
    <label for="uploadfile">Add file</label>
    <input type="file" class="uploadfile" name="uploadfile"><br><br>
    <label for="radiobutton">Select Gender</label><br>
    <input class="form-check-input" type="radio" name="radiobutton" value="male">
  	<label class="form-check-label" for="radiobutton"> Male </label> <br>
  	<input class="form-check-input" type="radio" name="radiobutton" value="female">
  	<label class="form-check-label" for="radiobutton"> Female </label><br><br>
  	<center><button type="submit" name="submit" class="btn btn-primary">Submit</button></center>
    </div>
</form>

</body>
</html>

<?php
	include ('footer.php');
?>