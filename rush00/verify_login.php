<?php
	//session_start();
	function verify_login(){
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$sql = "SELECT name from users WHERE name='".$_SESSION['login']['username']."'";
		$list_names = mysqli_query($conn, $sql);
		if (!(mysqli_num_rows($list_names) >= 1))
		{
			return "User not found";
		}
		else
		{
			$sql = "SELECT name, password from users WHERE name='".$_SESSION['login']['username']."' AND password='".$_SESSION['login']['password']."'";
			$list_names = mysqli_query($conn, $sql);
			if ((mysqli_num_rows($list_names) >= 1))
			{
				return "You are loged in";
			}
			else
				return "Password incrrect";
		}
		mysqli_close($conn);
	}
?>