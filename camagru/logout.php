<?php
	session_start();
	session_destroy();
	//echo "<center><h2> You have been logged out. You will be redirected to homepage in 3 seconds</h2></center>";
	echo '<meta http-equiv="refresh" content="0;url=index.php" />';
?>