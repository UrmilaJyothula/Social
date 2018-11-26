<?php
 
	session_start();
	if(isset($_SESSION["login_status"]))
	{
		header("Location:home.php");
	}
	## defining a function to validate user id
	function check_username($email,$password)
	{
		$servername = "192.168.0.4";
		$username = "root";
		$password_db = "1234";
		$dbname = "WD"; 
		$conn = mysqli_connect($servername,$username,$password_db,$dbname);
		
		if(!$conn) {
			die("Couldn't to connect to database:".mysqli_connect_error());
		}
  
		$sql = "SELECT * FROM User_Info WHERE Email_Id='$email'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result) == 1) {
			while($row = mysqli_fetch_assoc($result)) {
				$verify_login_password = $row["Password"];
				if($password !== $verify_login_password) {
					$password_match = "You entered wrong password, please re-enter the password";
					echo "<p class=\"php\">".$password_match."</p>";
				}
				else {
					$_SESSION["login_status"] = True;
					header("Location:home.php");
				}
			}
		}
		elseif(mysqli_num_rows($result) == 0) {	  
			$email_exits = "E-mail Id does not exists";
			echo "<p class=\"php\">".$email_exits."</p>";
		}
	}
?>

<html>
	<head>
		<title>
			Fb-Login
		</title>
		<link rel="stylesheet" type="text/css" href="css/fb_login.css">
	</head>
	<body>
		<header id="header">
			<div id="logo">
				<h1>Facebook</h1>
			</div>
		</header>
		<main>
		<div>
			<center>
			<form method="POST">
				<fieldset class="formstyle">
					<legend>Login</legend>
						<div class="adjust">
							<br><label class="labels">E-mail ID</label><br>
							<input class="floattype" type="text" name="emailid_login" placeholder="E-mail Id" required><br>
							<br><label class="labels">Password</label><br>
							<input class="floattype" type="password" name="password_login" placeholder="Password" required><br>
							<br><button type="submit" name="login_submit" value="Login">Login</button>
						</div>
				</fieldset>
			</form>
			<?php 
				if(isset($_POST["login_submit"]))
				{
					$_SESSION["email_login"] = $email = $_POST["emailid_login"];
					$password = $_POST["password_login"];
					check_username($email, $password);
				}
			?>
			<br><a class="link" href="fb_signup.php">Click here to SignUp</a>
			</center>
		</div>
		</main>
		<footer>
			<p>&copy;2018 Fbook, Arjith Inc.</p>
		</footer>
	</body>
</html>
