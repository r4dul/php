<?php
	session_start();
	session_destroy();
	echo "<center><span style='color:red'>You have been logged out. You will be redirected to homepage in 3 seconds</span></center><br>";
	echo '<meta http-equiv="refresh" content="3;url=index.php" />';
?>