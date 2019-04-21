<?php
	require_once('mysql_connect.php');
	require_once('create_database.php');
	require_once('create_tables.php');
	require_once('mysql_connect2.php');
	require_once('populate_table.php');

	$conn = database_connect();
	create_database($conn);
	mysqli_close($conn);
	$conn = database_connect2();
	create_tables($conn);
	populate_table($conn);

	mysqli_close($conn);
?>