<?php
session_start();

$total = 0;
if (isset($_SESSION['cart'])){
	foreach ($_SESSION['cart'] as $key => $value) {
		echo "Produs: ".$value['name']."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp";
		echo "Pret produs: ".$value['price']."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp";
		echo "Cantitate: ".$value['cantitate']."<br>";
		$total = $total + $value['price'];
	}
}
else
	echo "You cart is empty";

echo "<h2>"."Pretul total este: ".$total."</h2>";
?>

<a href="finalizare.php">Finalizare comanda</a><br>
<a href="index.php">Go back to webshop</a>