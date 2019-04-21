<div class="header"> 
	<div class="title">
		<h1 style="color: green; text-align: center; padding-top: 20px">The Camagru Project = by raiosif =</h1>
	</div>
	<div class="menu">
		<?php
			echo "<span style='color:white'>Hello </span>" . "= " . $_SESSION['login_user'] . " =";
		?>
		<button onclick="window.location='index.php'">Home</button>
		<button onclick="window.location='upload.php'">Upload</button>
		<button onclick="window.location='admin.php'">User Panel</button>
		<button onclick="window.location='logout.php'">Logout</button>
	</div>
</div> 