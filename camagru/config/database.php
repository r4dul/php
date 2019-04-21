<?php
	function database_connect()
	{
		$DB_DSN = "mysql:host=localhost";
		$DB_USER = "root";
		$DB_PASSWORD = "ionut";
		$DB_NAME = "camagru";
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->exec('CREATE DATABASE IF NOT EXISTS `camagru`');
		try {
			$DB_DSN = 'mysql:dbname=camagru;host=localhost';
			$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->exec('CREATE DATABASE IF NOT EXISTS `camagru`');
			$conn->exec('USE camagru');
			//echo "Database 'camagru' was created.";
			return ($conn);
		}
		catch(PDOExceptio $e){
			echo $e->getMessage();
			exit();
		}
	}
?>