<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style/style.css">
	<title>The Camagru Project -= by raiosif =- </title>
	<?php
	session_start();
	if (isset($_SESSION['login_user'])) {
		include ("header2.php");
	}
	else {
		include("header.php");
	}
?>
</head>

<body>
	<div class="body">
		<div id='video-container'> 
			<video id="camera-stream" class="" width="500"> </video>
			<canvas id="canvas"></canvas><br>

			<center>
			<button onclick="snap()">Snap</button>
			<button onclick="saveImage()">Save</button><br></center>
			<form method="post" accept-charset="utf-8" name="form1">
				<input name="hidden_data" id="hidden_data" type="hidden">
			</form>

			<script type="text/javascript">
				var video = document.getElementById('camera-stream');
				var canvas = document.getElementById('canvas');
				var context = canvas.getContext('2d');
				var imagine = "";
				//global variable for sidebar canvas
				var count = 0;

				navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;

				if (navigator.getUserMedia) {
					navigator.getUserMedia({video:true}, streamWebCam, throwError);
				}

				function streamWebCam(stream) {
					video.src = window.URL.createObjectURL(stream);
					video.play();
					//store the webcam
					localMediaStream = stream;
				}

				function throwError (e) {
					alert(e.name);
				}

				function snap() {
					var imagesLoaded = 0;
					canvas.width = 500;//video.clientWidth; //to match de device but for testing I let this size
					canvas.height = 450;//video.clientHeight;
					if (imagesLoaded == 0) {
						context.drawImage(video, 0, 0);
					}
				var ctx = canvas.getContext("2d");

				var img1 = loadImage(imagine, main);

				function main() {
				    imagesLoaded += 1;

				    if(imagesLoaded == 1) {
				        ctx.drawImage(video, 0, 0);
				        ctx.drawImage(img1, 0, 0);
				        var destCtx = canvas2.getContext('2d');
				        destCtx.drawImage(canvas, 0, count, 200, 200);
						count += 200;
				    }
				}

				function loadImage(src, onload) {
				    var img = new Image();

				    img.onload = onload;
				    img.src = src;
				    return img;
					}
				}

				function saveImage(){
	                var dataURL = canvas.toDataURL("image/png");
	                document.getElementById('hidden_data').value = dataURL;
	                var fd = new FormData(document.forms["form1"]);
	 
	                var xhr = new XMLHttpRequest();
	                xhr.open('POST', 'save.php', true);
	 
	                xhr.upload.onprogress = function(e) {
	                    if (e.lengthComputable) {
	                        var percentComplete = (e.loaded / e.total) * 100;
	                        console.log(percentComplete + '% uploaded');
	                        alert('Succesfully uploaded');
	                    }
	                };
	 
	                xhr.onload = function() {
	 
	                };
	                	xhr.send(fd);
           		 }

				// here we will check which .png is selected
				function addImage(element){
					imagine = element;
				}

				function addEffect(element) {
					var NAME = document.getElementById("camera-stream");
					NAME.className= element;
					canvas.className = element;
				}

			</script>
			<fieldset>
			<legend>Add Effect</legend>
			<form action="">
			  <input type="radio" onclick="addEffect('sepia')" name="effect" value="sepia">
			  <label for="sepia">Sepia</label>
			  <input type="radio" onclick="addEffect('blur')" name="effect" value="blur">
			  <label for="blur">Blur</label>
			  <input type="radio" onclick="addEffect('grayscale')" name="effect" value="grayscale">
			  <label for="grayscale">Grayscale</label>
			  <input type="radio" onclick="addEffect('brightness')" name="effect" value="brightness">
			  <label for="brightness">Brightness</label><br>
			  <input type="radio" onclick="addEffect('contrast')" name="effect" value="contrast">
			  <label for="contrast">Contrast</label>
			  <input type="radio" onclick="addEffect('hue-rotate')" name="effect" value="hue-rotate">
			  <label for="hue-rotate">Hue-rotate</label>
			  <input type="radio" onclick="addEffect('invert')" name="effect" value="invert">
			  <label for="invert">Invert</label>
			  <input type="radio" onclick="addEffect('saturate')" name="effect" value="saturate">
			  <label for="saturate">Saturate</label>
			  <input type="radio" onclick="addEffect('opacity')" name="effect" value="opacity">
			  <label for="grayscale">Opacity</label>
			  </form>
			 </fieldset> <br>

			 <?php
				require_once('config/database.php');
				$conn = database_connect();
				//increase like count by 1
				if (isset($_POST['like'])){
					$id = $_POST['like'];
					$sql = "UPDATE images SET likes = likes + 1 WHERE id='$id'";
					$conn->exec($sql);
				}
				//decrease likes by 1
				if (isset($_POST['dislike'])){
					$id = $_POST['dislike'];
					$sql = "UPDATE images SET likes = likes - 1 WHERE id='$id'";
					$conn->exec($sql);
				}
				if (isset($_POST['sendComment']) && $_SESSION['login_user'] != ""){
					$comment = htmlspecialchars($_POST['commentArea']);
					$userid = $_POST['sendComment'];
					$user = $_SESSION['login_user'];

					$sth = $conn->prepare("INSERT INTO comments(userid, user, comment) VALUES ('$userid', '$user', '$comment')");
					$sth->bindValue(1, $userid, PDO::PARAM_INT);
					$sth->bindValue(2, $user, PDO::PARAM_STR);
					$sth->bindValue(3, $comment, PDO::PARAM_STR);
					$sth->execute();

					$subject = "Your received a new comment";
					$message = "A new comment was added to your picture";
					$headers = 'From: admin@camagru.ro' . "\r\n" .
					'Reply-To: admin@camagru.ro' . "\r\n" .
					'X-Mailer: PHP/' . "\r\n" . 'Content-type:text/html;charset=UTF-8';
					$sth = $conn->prepare("SELECT emailpref, email FROM users WHERE user='$user'");
					$sth->execute();
					$result = $sth->fetch(PDO::FETCH_ASSOC);
					$email = $result['email'];
					$emailpref = $result['emailpref'];
					echo $emailpref;
					if ($emailpref){
						mail($email, $subject, $message, $headers);
					}
				}

				$sql = "SELECT * FROM images ORDER BY id DESC LIMIT 10";
				$sql1 = "SELECT * FROM comments";
				foreach ($conn->query($sql) as $row) {
					echo "<form method='post' accept-charset='UTF-8'>";
					echo '<img name="image" value="' . $row['id'] . '" ' . 'src="uploads/' . $row['image'] . '">';
					echo '<center>Likes: ' . $row['likes'] . '</center>';
					echo "<center><button name='like' id='like' value='" . $row['id'] . "' > Like </button><button name='dislike' id='dislike' value='" . $row['id'] . "' > Dislike </button></center><br>";
					echo "<label> Comments: </label>";
					echo "<textarea name='commentSection' id='commentSection' rows=4 cols=60>";
					$photoid = $row['id'];
					$sql1 = "SELECT * FROM comments WHERE userid='$photoid'";
						foreach ($conn->query($sql1) as $row1) {
							echo $row1['user'] . " said: " . nl2br($row1['comment']) . PHP_EOL;
						}
					echo "</textarea><br>";
					echo "<label for='commentArea'>Insert a comment here:</label>";
					echo "<input type='text' name='commentArea'>";
					echo "<center><button name='sendComment' value=" . $row['id'] ." > Leave a comment </button></center><br><br>";
					echo "</form>";
				}
			?>

			<form method="post">
				<input type='text' name='com'>
				<button value="submit" name="cacat">Submit</button>
			</form>
		</div>
		<div class="sidebar"> 
		<form action="">
			<label>
			  <input type="radio" onclick="addImage('images/horse.png')" name="png" value="horse">
			  <img src="images/horse.png"> <br>
			  <input type="radio" onclick="addImage('images/hair.png')" name="png" value="hair" />
			  <img src="images/hair.png"><br>
			  <input type="radio" onclick="addImage('images/love.png')" name="png" value="love" />
			  <img src="images/love.png"><br>
			  <input type="radio" onclick="addImage('images/mustache.png')" name="png" value="mustache" />
			  <img src="images/mustache.png"><br>
			</label>
		</form>
		</div>

		<div class="sidebar2">
			<canvas id="canvas2" height="800"> 
			</canvas>
		</div>
	</div>
</body>
</html>

<?php 
include ("footer.php");
?>