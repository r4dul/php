<?php
	session_start();
	require_once('config/database.php');
	$conn = database_connect();
	$upload_dir = "uploads/";
	$img = $_POST['hidden_data'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = $upload_dir . mktime() . ".png";
	$success = file_put_contents($file, $data);
	$finalUrl = "http://" . $_SERVER['SERVER_NAME'] . '/' . $file;
	echo $finalUrl;
	$filename =  preg_replace('/[^0-9]/', '', $file) . ".png";
	$user = $_SESSION['login_user'];
	$sql = "INSERT INTO images(image, link, user) VALUES('$filename', '$finalUrl', '$user')";
	$conn->exec($sql);
	echo $finalUrl;
?>