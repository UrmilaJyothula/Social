<!DOCTYPE html>
<!-- Home page -->
<!-- Template by quackit.com -->

<?php
	session_start();
	if(!isset($_SESSION["login_status"])){
		header("Location:fb_login.php");
	}
	
	$servername = "192.168.0.4";
	$username = "root";
	$password = "1234";
	$dbname = "WD";
 
	$conn = mysqli_connect( $servername, $username, $password, $dbname);
 
	if(!$conn)
	{
		die( "Couldn't connect to database:".mysqli_connect_error() );
	}
	
	$email = $_SESSION["email_login"];
	$sql = "SELECT * FROM User_Info WHERE Email_Id = '$email'";
	$result = mysqli_query($conn,$sql);
 
	if(mysqli_num_rows($result)>0) {
		while($row = mysqli_fetch_assoc($result)) {
			$_SESSION["fullname"] = $fullname = $row["Full_name"];
		}
	}
	
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Profile - User</title>		
		<link rel="stylesheet" type="text/css" href="css/home.css">
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
			<div class="innertube">
				<center>

				</center>
			</div>
		</main>

		<nav id="nav">
			<div class="innertube">
				<form method="POST"><input type="submit" name="profile" value="Profile"></input></form>
				<form method="POST"><input type="submit" name="newsfeed" value="Newsfeed"></input></form>
				<form method="POST"><input type="submit" name="update_submit" value="Update status"></input></form>
				<form method="POST"><input type="submit" name="friends_submit" value="Friends"></input></form>
				<form method="POST"><input type="submit" name="groups" value="Groups"></input></form>
			</div>
		</nav>	
	</body>
</html>

<?php
	if(isset($_POST["submit_logout"])) {
		unset($_SESSION["login_status"]);
		session_destroy();
		header("Location:fb_login.php");
	}
	elseif(isset($_POST["update_submit"])) {
		$_SESSION["fileuploaded"] = True;
		header("Location:fb_upload_user.php");
	}
	elseif(isset($_POST["friends_submit"])) {
		$_SESSION["findfriends"] = True;
		header("Location: findfriends.php");
	}
	
?>
