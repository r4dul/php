<?php
session_start();
unset($_SESSION['login']);
echo "You were logged out!";
?>
<meta http-equiv="refresh" content="2; url=index.php">