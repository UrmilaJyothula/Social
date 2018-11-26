<!DOCTYPE html>
<!-- Template by quackit.com -->

<?php
	session_start();
	if(!isset($_SESSION["signup"]))
	{
		$_SESSION["signup"] = True;
		header("Location:fb_signup.php");	 
	}
 
?> 

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SignUp - User</title>		
		<link rel="stylesheet" type="text/css" href="css/fb_signup.css">
	</head>
	
	<body>		

		<header id="header">
			<div id="logo">
				<h1>Facebook</h1>
			</div>
		</header>
				
		<main>
			<div class="innertube">
				<center>
					<form method="POST">
						<fieldset class="formstyle">
							<legend>Create Account</legend>
							<div class="adjust">
								<br><label class="labels">First name</label><br>
								<input class="floattype" type="text" name="firstname" placeholder="First Name" required><br>
								<br><label class="labels">Last name</label><br>
								<input class="floattype" type="text" name="lastname" placeholder="Last Name" required><br>
								<br><label class="labels">E-mail ID</label><br>
								<input class="floattype" type="text" name="emailid" placeholder="E-mail Id" required><br>
								<br><label class="labels">Password</label><br>
								<input class="floattype" type="password" name="password" placeholder="Password" required><br>
								<br><label class="labels">Confirm Password</label><br>
								<input class="floattype" type="password" name="confirm_password" placeholder="Confirm Password" required><br>
								<br><button type="submit" name="signup" value="Sign Up">Sign Up</button>
							</div>
						</fieldset>
					</form>
				</center>
			</div>
		</main>	
	</body>
</html>

<?php
	if(isset($_POST["signup"]))
	{
		$_SESSION["signup_confirm"] = True; 
		$_SESSION["firstname"] = $_POST["firstname"];
		$_SESSION["lastname"] = $_POST["lastname"];
		$_SESSION["emailid"] = $_POST["emailid"];
		$_SESSION["password"] = $_POST["password"];
		$_SESSION["confirmpassword"] = $_POST["confirm_password"];
		header("Location:fb_signup_sql.php");	 
	}
?> 
