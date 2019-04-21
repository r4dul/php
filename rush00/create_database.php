<?php
	function create_database($connection)
	{
		$dbcreate = "DROP DATABASE rush00";
		mysqli_query($connection, $dbcreate);
		$dbcreate = "CREATE DATABASE IF NOT EXISTS rush00";
		if (mysqli_query($connection, $dbcreate) === TRUE) {
			echo "Database rush00 was created\n";
		} else
		{
			echo "Error creating rush00\n";
		}
	}
?>