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
?>

<div class="products">
	<table>
		<?php
					require_once('read_from_category.php');
					$list_products = readFromCategory("laptops");
					$i = 1;
					echo '<tr>';
					while($row = mysqli_fetch_array($list_products)){
					?>
					
					<td class="produs">
						<p><?php echo $row['name'];?></p>
						<p><?php echo'<img src="'.$row['link'].'">'?></p>
						<p><?php echo $row['price']." lei";?></p>
						<a href="laptops.php?action=add&id=<?php echo $row['id'];?>&price=<?php echo $row['price'];?>"><img src="https://xopixel.com/wp-content/uploads/2016/12/Screen-Shot-2016-12-26-at-9.54.38-PM.png" alt = "add to cart button" class = imgsize> </a>
					</td>
					<?php
						if ($i % 4 == 0){
							echo '</tr>';
							$i = 0;
						} ?>
					<?php $i++; } ?>
	</table>



</div>

</body>
</html>