<div class="products">

	<table>
		<?php
					require_once('read_products.php');
					$list_products = read_products();
					$i = 1;
					echo '<tr>';
					while($row = mysqli_fetch_array($list_products)){
					?>
					
					<td class="produs"><!--<?php echo $row['name']; echo '<img src="'.$row['link'].'"'.$row['price'];?>-->
						<p><?php echo $row['name'];?></p>
						<p><?php echo'<img src="'.$row['link'].'">'?></p>
						<p><?php echo $row['price']." lei";?></p>
						<a href="index.php?action=add&id=<?php echo $row['id'];?>&price=<?php echo $row['price'];?>"><img src="https://xopixel.com/wp-content/uploads/2016/12/Screen-Shot-2016-12-26-at-9.54.38-PM.png" alt = "add to cart button" class = "imgsize"> </a>
					</td>
					<?php
						if ($i % 4 == 0){
							echo '</tr>';
							$i = 0;
						} ?>
					<?php $i++; } ?>
	</table>
</div>