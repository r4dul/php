<?php
	function read_products(){
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$sql = "SELECT * from product";
		$list_categories = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $list_categories;
	}
?>