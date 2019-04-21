<?php
function database_connect()
{
	$hostname = "localhost";
	$username = "root";
	$password = "ionut";

	$connection = mysqli_connect($hostname, $username, $password);
	if (mysqli_connect_errno($connection))
	{
		echo "Failed to connect to the database rush00" . mysqli_connect_error();
		return (NULL);
	}
	return $connection;
}
?>