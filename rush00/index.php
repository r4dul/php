<?php 
    session_start(); 
    require_once('mysql_connect2.php');
    if (isset($_GET['action']))
    {
    	$id = intval($_GET['id']);
    	if (isset($_SESSION['cart'][$id]))
    	{
    		$_SESSION['cart'][$id]['cantitate']++;
    	}
    	else
    	{
    	$conn = database_connect2();
    	$sql="SELECT * FROM product
                WHERE id='$id'"; 
            $query=mysqli_query($conn,$sql); 
            if(mysqli_num_rows($query)!=0){ 
                $row=mysqli_fetch_array($query); 
                  
                $_SESSION['cart'][$row['id']]=array( 
                        "cantitate" => 1, 
                        "price" => $row['price'],
                        "name" => $row['name']
                    ); 
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>TITILE</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color: #f2f2f2;">

<?php
	include ("header.php");
	include ("category_contents.php");
?>



</body>
</html>