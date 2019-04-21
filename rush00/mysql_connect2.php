<?php
function database_connect2()
{
	$hostname = "localhost";
	$username = "root";
	$password = "ionut";
	$dbuser = "rush00";

	$connection = mysqli_connect($hostname, $username, $password, $dbuser);
	if (mysqli_connect_errno($connection))
	{
		echo "Failed to connect to the database rush00" . mysqli_connect_error();
		return (NULL);
	}
	return $connection;
}
?>