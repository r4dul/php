<?php
	function read_categories(){
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$sql = "SELECT name from category";
		$list_categories = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $list_categories;
	}
?>