<?php
	session_start();
	require_once('config/database.php');
	if (isset($_POST['submit']))
	{
		if (!(empty($_FILES['uploadfile'])))
		{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
		$upfile = basename($_FILES["uploadfile"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		//check if the file is too large
		if ($_FILES["uploadfile"]["size"] > 500000) {
			echo "<center><span style='color:red'>Sorry, your file is too large.</span></center><br>";
			$uploadOk = 0;
		}
		//check if is a fake image
		$check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
    	if($check !== false) {
        	echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    	} else {
        	echo "File is not an image.";
        	$uploadOk = 0;
   		}
   		//check if image is actually an image
   		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
   		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
   		$uploadOk = 0;
		}
		if ($uploadOk != 0) {
			if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
        			echo "<center><span style='color:red'>The file '". basename( $_FILES["uploadfile"]["name"]). "' has been uploaded.</span></center><br>";
    		} else {
        		echo "<center><span style='color:red'>Sorry, there was an error uploading your file.</span></center><br>";
    		}
			}
		// we will now ad the picture into database
		if ($uploadOk != 0) {
			$conn = database_connect();
			$user = $_SESSION['login_user'];
			$linkfile = "http://localhost/uploads/" . $upfile;
			$sql = "INSERT INTO images(image, link, user) VALUES ('$upfile', '$linkfile', '$user')";
			$conn->exec($sql);
			echo "<center><span style='color:red'>Image is stored in database.</span></center><br>";
		}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>File Upload</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		<fieldset>
			<legend id='body2'>Select a picture to upload:</legend>
			<label for="uploadfile">Add file</label>
   			<input type="file" name="uploadfile"><br>
   			<button type="submit" name="submit">Submit</button>
		</fieldset>
	</form>
</body>
</html>