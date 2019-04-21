  <?php
  function readFromCategory($category) {
    require_once('mysql_connect2.php');
    $conn = database_connect2();

    $sql = "SELECT product.name, product.price, product.link, product.id from product
	   inner join cat_prod on cat_prod.idProd = product.id
	    inner join category on cat_prod.idCat = category.id
	     where category.name = '$category'";
    $list = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $list;
  }
  ?>
