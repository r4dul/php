	<div class="header">
		<div class="logo">
			<img class="logoimg" src="https://www.thecomputerstoreks.com/files/2016/12/CS-logo.png">
		</div>


		<div class="login">
			<form method="post">
				<user>Username: </user>
				<input type="text" name="username" value="">
				<pass>Password: </pass>
				<input type="text" name="password" value="">
				<input type="submit" name="submit" value="Log in">
				<input type="button" name="register" value="Register" onclick="window.location='register.php';">
				<input type="button" name="logout" onclick="window.location='logout.php'" value="Log out"><br>
			<?php
				require_once('verify_login.php');
				if ((isset($_POST['username'], $_POST['password'], $_POST['submit'])))
				{
					if ($_POST['username'] == "admin" && $_POST['password'] == "admin")
					{
						$_SESSION['login']['username'] = "admin";
						$_SESSION['login']['password'] = "admin";
						?>
						<input type="button" name="adminchange" value="Change stuff" onclick="window.location='add_content.php'">
					<?php
					}
					else{
						$_SESSION['login']['username'] = $_POST['username'];
						$_SESSION['login']['password'] = $_POST['password'];
						echo verify_login();
					}
				}
				if (isset($_SESSION['login']['username']))
					echo " ".$_SESSION['login']['username'];
				else
					echo "You are not logged in";
			?>
			</form>
		</div>

		<div class="menu">
			<div class="links">
				<a href="index.php" class="link">Home</a>
				<?php
					require_once('read_categories.php');
					$list_categories = read_categories();
					while($row = mysqli_fetch_array($list_categories)){
					?>
					<a class="link"><?php echo '<a href="'; echo $row['name'].".php"; echo '">';echo $row['name']; echo '</a>'?></a>
					<?php } ?>
			</div>
			<a href="cart.php" style="position: absolute; right: 20px; top: 5px;"><img class="cosul" src="http://www.pvhc.net/img180/cjsfaxwgoflbedkowfvn.png"></a>
		</div>
	</div>