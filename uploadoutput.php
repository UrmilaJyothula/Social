<?php
	session_start();
	if(!isset($_SESSION["login_status"]))
	{
		header("Location:fb_login.php");  
	}
	else
	{	 
		if(!isset($_SESSION["upload_output"]))
		{ 
			header("Location:fb_upload_user.php");
		}
	} 
 
	$email = $_SESSION["email_login"];
	$servername = "192.168.0.4";
	$username = "root";
	$password = "1234";
	$dbname = "WD";
 
	$conn = mysqli_connect($servername,$username,$password,$dbname);
 
	if(!$conn) {
		die("Couldn't connect to database:".mysqli_connect_error());
	}
	
	$fullname = $_SESSION["fullname"];
	$file_output = $_SESSION["file_output"];
?>

<html>
	<head>
		<title>
			Fb-Upload-Output
		</title>
		<link rel="stylesheet" type="text/css" href="css/fb_upload_user.css">
	</head>
	<body>
		<header id="header">
			<div id="logo">
				<h3>Facebook</h3>
			</div>
			<div id="logout">
				<div id="name"><?php echo "<p>".$fullname."</p>"?></div>
				<div id="logoutform">
				<form  method="POST">
					<button type="submit" class="button logout_button" name="submit_logout" value="Logout">Logout</button>
				</form>
				</div>
			<div>
		</header>
		<main>
			<?php echo "<h3>".$file_output."</h3>"; unset($_SESSION["upload_output"]); unset($_SESSION["fileuploaded"]);?>
		</main>
		<footer>
			<p>&copy;2018 Fbook, Arjith Inc.</p>
		</footer>
	</body>
</html>
