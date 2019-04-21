<h3>ADD, REMOVE, CHANGE PRODUCTS</h3>
<form method="post">
	Product Title: <input type="text" name="product" value=""><br>
	Product Price: <input type="text" name="price" value=""><br>
	Product Image link: <input type="text" name="link" value=""><br>
	<input type="submit" name="submit" value="Add product">
</form>
<br>
<?php

	require_once('mysql_connect2.php');
		$conn = database_connect2();
		$query = "SELECT name FROM product";
		$sql = mysqli_query($conn, $query);
		echo "<ol>";
		while($row = mysqli_fetch_array($sql)){
		?>
			<li><?php echo $row['name'];?></li>
		<?php } 
		mysqli_close($conn);

?>
<br>
<form method="post">
	Select product id: <input type="text" name="deleteuser" value=""><br>
	What to modify(options: delete, changeprice or changename): <input type="text" name="change" value=""><br>
	What to replace with: <input type="text" name="replace" value=""><br>
	<input type="submit" name="delete2" value="Submit">
</form>
<br>

<h3>ADD, REMOVE, CHANGE USER</h3>

<form method="post">
	Username: <input type="text" name="product" value=""><br>
	Password: <input type="text" name="pass" value=""><br>
	<input type="submit" name="submit" value="Add user">
</form>

<?php
		if ((!isset($_POST['product'], $_POST['pass'], $_POST['submit'])))
			echo "Please fill all the fields\n";
		else
		{
			require_once('mysql_connect2.php');
			$conn = database_connect2();
			$value1 = $value2 = "";
			if (isset($_POST['product']))
				$value1 = $_POST['product'];
			if (isset($_POST['product']))
				$value2 = $_POST['pass'];
			$addcontent = "INSERT INTO users (name, password) VALUES ('$value1', '$value2')";
			if (mysqli_query($conn, $addcontent))
				echo "Category added!";
			else
				echo "Error while adding the category";
			mysqli_close($conn);
		}
?>

<?php
		if (!isset($_POST['product'], $_POST['price'], $_POST['submit']))
			echo "Please fill all the fields\n";
		else
		{
			require_once('mysql_connect2.php');
			$conn = database_connect2();
			$value1 = $value2 = $value3 = "";
			if (isset($_POST['product']))
				$value1 = $_POST['product'];
			if (isset($_POST['link']))
				$value2 = $_POST['link'];
			if (isset($_POST['price']))
				$value3 = $_POST['price'];
			$addcontent = "INSERT INTO product (name, link, price) VALUES ('$value1', '$value2', '$value3')";
			if (mysqli_query($conn, $addcontent))
				echo "Product added!";
			else
				echo "Error while adding the product";
			mysqli_close($conn);
		}
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$query = "SELECT name FROM users";
		$sql = mysqli_query($conn, $query);
		echo "<ol>";
		while($row = mysqli_fetch_array($sql)){
		?>
			<li><?php echo $row['name'];?></li>
		<?php } 
		mysqli_close($conn);
?>

<form method="post">
	Select user: <input type="text" name="deleteuser" value=""><br>
	What to modify(options: delete, changepass or changeuser): <input type="text" name="change" value=""><br>
	What to replace with: <input type="text" name="replace" value=""><br>
	<input type="submit" name="delete" value="Submit">
</form>
<?php

	if(!isset($_POST['deleteuser'], $_POST['delete2']))
		echo "enter a product to change or delete";
	else
	{	
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$usertodel = $_POST['deleteuser'];
		if ($_POST['change'] == "delete")
		{
			$query = "DELETE FROM product WHERE id='$usertodel'";
			$sql = mysqli_query($conn, $query);
		}
		else if ($_POST['change'] === "changeprice")
		{
			$newpass = $_POST['replace'];
			$query = "UPDATE product SET price='$newpass' WHERE id='$usertodel'";
			$sql = mysqli_query($conn, $query);
		}
		else if ($_POST['change'] === "changename")
		{
			$newuser = $_POST['replace'];
			$query = "UPDATE product SET name='$newuser' WHERE id='$usertodel'";
			$sql = mysqli_query($conn, $query);
		}
		mysqli_close($conn);
	}

?>
<?php

	if(!isset($_POST['deleteuser'], $_POST['delete']))
		echo "enter a user to change or delete";
	else
	{	
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		$usertodel = $_POST['deleteuser'];
		if ($_POST['change'] === "delete")
		{
			$query = "DELETE FROM users WHERE name='$usertodel'";
			$sql = mysqli_query($conn, $query);
		}
		else if ($_POST['change'] === "changepass")
		{
			$newpass = $_POST['replace'];
			$query = "UPDATE users SET password='$newpass' WHERE name='$usertodel'";
			$sql = mysqli_query($conn, $query);
		}
		else if ($_POST['change'] === "changeuser")
		{
			$newuser = $_POST['replace'];
			$query = "UPDATE users SET name='$newuser' WHERE name='$usertodel'";
			$sql = mysqli_query($conn, $query);
		}
		mysqli_close($conn);
	}

?>

<h3>ADD, REMOVE, CHANGE CATEGORY</h3>

<?php

	require_once('mysql_connect2.php');
	$conn = database_connect2();
	$query = "SELECT name FROM category";
	$sql = mysqli_query($conn, $query);
	echo "<ol>";
	while($row = mysqli_fetch_array($sql)){
	?>
		<li><?php echo $row['name'];?></li>
	<?php } 
	mysqli_close($conn);

?>
<br>



<form method="post">
	Category Title: <input type="text" name="catname" value=""><br>
	<input type="submit" name="submit2" value="Add category">
</form>

<?php
		if ((!isset($_POST['catname'], $_POST['submit2'])))
			echo "Please fill all the fields\n";
		else
		{
			require_once('mysql_connect2.php');
			$conn = database_connect2();
			$value1 = "";
			if (isset($_POST['catname']))
				$value1 = $_POST['catname'];
			$addcontent = "INSERT INTO category (name) VALUES ('$value1')";
			if (mysqli_query($conn, $addcontent))
				echo "Category added!";
			else
				echo "Error while adding the category";
			mysqli_close($conn);
		}
?>

<form method="post">
	Select category: <input type="text" name="deleteuser" value=""><br>
	What to modify(options: delete, changename): <input type="text" name="change" value=""><br>
	What to replace with: <input type="text" name="replace" value=""><br>
	<input type="submit" name="delete" value="Submit">
</form>

<?php

	if(!isset($_POST['deleteuser'], $_POST['delete']))
		echo "enter a user to change or delete";
	else
	{	
		$deleteuser = $_POST['deleteuser'];
		$replace = $_POST['replace'];
		require_once('mysql_connect2.php');
		$conn = database_connect2();
		if ($_POST['change'] === "delete")
		{
			$query = "DELETE FROM category WHERE name='$deleteuser'";
			$sql = mysqli_query($conn, $query);
		}
		else if ($_POST['change'] === "changename")
		{
			$query = "UPDATE category SET name='$replace' WHERE name='$deleteuser'";
			$sql = mysqli_query($conn, $query);
		}
		mysqli_close($conn);
	}

?>

<br>
<h4><a href="index.php">Go back to webshop</a></h4>