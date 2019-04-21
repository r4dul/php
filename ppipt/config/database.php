<?php
	function database_connect(){
		$hostname = "localhost";
		$username = "root";
		$password = "ionut";

	$conn = mysqli_connect($hostname, $username, $password);
	if (mysqli_connect_errno($conn)) {
		echo "Failed to connect to database root" . mysqli_connect_error();
		return NULL;
	}
	return $conn;
	}

	function database_connect2(){
		$hostname = "localhost";
		$username = "root";
		$password = "ionut";
		$databasename = "greppy";

		$conn = mysqli_connect($hostname, $username, $password, $databasename);
		if (mysqli_connect_errno($conn)) {
			echo "Failed to connect to database greppy" . mysqli_connect_error();
			return NULL;
		}
		return $conn;
	}
?>