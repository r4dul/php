<?php
	require_once('database.php');
	$conn = database_connect();
	/*$sql = "CREATE TABLE users (id INT(11) UNSIGNED NOT NULL, user VARCHAR(255) NOT NULL, pass VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"*/
	$conn->exec("CREATE TABLE users(
		id int(11) PRIMARY KEY AUTO_INCREMENT, 
		user VARCHAR(255) NOT NULL, 
		pass VARCHAR(255) NOT NULL, 
		email VARCHAR(255) NOT NULL,
		token VARCHAR(10) NOT NULL,
		activ int(11) DEFAULT '0',
		emailpref int(11) DEFAULT '1')
		ENGINE=MyISAM DEFAULT CHARSET=utf8;");

	$conn->exec("CREATE TABLE images(
		id int(11) PRIMARY KEY AUTO_INCREMENT, 
		image VARCHAR(255) NOT NULL, 
		link VARCHAR(255) NOT NULL,
		likes VARCHAR(255) DEFAULT '0',
		user VARCHAR(255) DEFAULT 'anomin')
		ENGINE=MyISAM DEFAULT CHARSET=utf8;");

	$conn->exec("CREATE TABLE comments(
		id int(11) PRIMARY KEY AUTO_INCREMENT, 
		userid int(11) NOT NULL,
		user VARCHAR(255) DEFAULT 'anomin',
		comment VARCHAR(255) NOT NULL)
		ENGINE=MyISAM DEFAULT CHARSET=utf8;");
?>