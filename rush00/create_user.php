<?php
	function create_user($user, $password)
	{
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$insertuser = "INSERT INTO users (name, password, role) VALUES ('$user', '$password', 0)";
		if (mysqli_query($conn, $insertuser))
			echo "Userul ".$user." a fost creat";
		else
			echo "Userul ".$user." exista deja in baza de date";
		mysqli_close($conn);
	}
?>