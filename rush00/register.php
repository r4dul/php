<form method="post">
	Username: <input type="text" name="username" value=""><br>
	Password: <input type="text" name="password" value=""><br>
	<input type="submit" name="submit" value="Create user">
</form>
<?php
	require_once('create_user.php');
	if (!isset($_POST['username'], $_POST['password'], $_POST['submit']))
		echo "Please enter an username and a password\n";
	else
	{
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$sql = "SELECT name from users WHERE name='".$_POST['username']."'";
		$list_names = mysqli_query($conn, $sql);
		if (!(mysqli_num_rows($list_names) >= 1))
		{
			create_user($_POST['username'], $_POST['password']);
			echo "<br>User and password created\n";

		}
		else
		{
			echo "Please choos another username";
		}
	}
?>
<br>
<a href="index.php">Go back to webshop</a>