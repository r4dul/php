<?php
	require_once('database.php');
	$conn = database_connect();

	//create database greppy 
	$sql = "CREATE DATABASE IF NOT EXISTS greppy";
	if (mysqli_query($conn, $sql) == TRUE) {
		echo "Database 'greppy' was created<br>";
	} else {
		echo "Error while creating database greppy" . mysqli_error($conn);
	}
	mysqli_close($conn);

	//connect to database greppy
	$conn = database_connect2();

	//table users
	$sql = 'CREATE TABLE IF NOT EXISTS users (
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) unique NOT NULL,
	password VARCHAR(255) NOT NULL,
	email VARCHAR(80) NOT NULL,
	created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
	)';
	if (mysqli_query($conn, $sql)) {
		echo "Table 'users' was created<br>";
	} else {
		echo "Table users was not created" . mysqli_error($conn);
	}

	//table formular
	$sql = 'CREATE TABLE IF NOT EXISTS formular (
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	user_id INT(11) NOT NULL,
	title VARCHAR(255) NOT NULL,
	description VARCHAR(255) NOT NULL,
	uploaded_file VARCHAR(255) NOT NULL,
	gender ENUM("female","male"),
	created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
	)';
	if (mysqli_query($conn, $sql)) {
		echo "Table 'formular' was created<br>";
	} else {
		echo "Table formular was not created<br>" . mysqli_error($conn);
	}

	//adding username test and admin into database
	$pass = password_hash("test", PASSWORD_DEFAULT);
	$sql = "INSERT INTO users(username, password) VALUES ('test', '$pass');";
	$pass = password_hash("admin", PASSWORD_DEFAULT);
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO users(username, password) VALUES ('admin', '$pass');";
	mysqli_query($conn, $sql);
	mysqli_close($conn);
	echo '<meta http-equiv="refresh" content="0;url=../index.php" />';
?>