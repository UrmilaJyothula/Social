<?php
	session_start();
	if(!isset($_SESSION["signup_confirm"])) {
		$_SESSION["signup"] = True;
		header("Location:signup.php");	 
	}
 
	if(isset($_SESSION["signup_confirm"])) {
		
		$firstname = $_SESSION["firstname"];
		$lastname = $_SESSION["lastname"];
		$emailid = $_SESSION["emailid"];
		$password = $_SESSION["password"];
		$confirmpassword = $_SESSION["confirmpassword"];
   
  
		if($password !== $confirmpassword) {
			$pwderror = "Password are not matched, please re-enter your password";
		}
		else {
		
			$servername = "192.168.0.4";
			$username = "root";
			$password_db = "1234"; 
    
			$conn=mysqli_connect($servername, $username, $password_db);
			if(!$conn) {
				die("Could not connect to server:".mysqli_connect_error());
			}
   
			## creating database if not exists 
   
			$sql = "CREATE DATABASE IF NOT EXISTS WD";
			if(mysqli_query($conn, $sql)) {
				#echo "<br>"."Created database Secure Drive successfully"."<br>";
			}
			else {
				echo "<br>"."Coudn't create database User_Info:".mysql_error($conn)."<br>";
			}
    
			mysqli_close($conn);
			## connecting to database WD 
			$dbname = "WD";
			$conn_db = mysqli_connect($servername,$username,$password_db,$dbname);
			if(!$conn_db) {
				die("Could not connect succesfull to SDrive:".mysqli_connect_error());
			}
  
			## creating table user info
			
			$fullname = $firstname.' '.$lastname;
   
			$sql = "CREATE TABLE IF NOT EXISTS User_Info(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, Full_name VARCHAR(200), First_name VARCHAR(50), Last_name VARCHAR(50), Email_Id VARCHAR(100), Password VARCHAR(30), reg_date TIMESTAMP)";
			if(!mysqli_query($conn_db, $sql)) {
				echo "<br>"."Couldn't create table User_Info:".mysqli_error($conn_db)."<br>";
			}
			
			## checking if email-id exists already
			$sql = "SELECT * FROM User_Info WHERE Email_Id='$emailid'";
			$result = mysqli_query($conn_db, $sql);
			$rowcount = mysqli_num_rows($result);
			
			if($rowcount == 0) {
				## inserting data into table
				
				$sql = "INSERT INTO User_Info(Full_name, First_name, Last_name, Email_Id, Password) VALUES('$fullname', '$firstname', '$lastname', '$emailid', '$password')";
				if(mysqli_query($conn_db,$sql)) {
					$email_confirm = "Your account has been created successfully";
				}
				else {
					echo "<br>"."Data not inserted successfully"."<br>";
				}
				
				if(!file_exists("C:/Users/DELL/Desktop/Uploads/$fullname/")) {
					if(mkdir("C:/Users/DELL/Desktop/Uploads/$fullname/",777))
					{ 
						$_SESSION["Uploaddir"]="C:/Users/DELL/Desktop/Uploads/$fullname/";
						$namespace="Namespace for you is created in our database with location:".$fullname;
					}
				}
				else {
					$namespace="Namespace for you is created in our database with location:".$fullname;
				}
			}
			else{
				$email_confirm = "Your Email Id exists already";
				$namespace = "";
			}
		}
	}		
	unset($_SESSION["signup_confirm"]);
?>

<html>
	<head>
		<title>
			SignUp-confirm
		</title>
		<link rel="stylesheet" type="text/css" href="css/signup_output.css">
	</head>
	<body>
		<header id="header">
			<div id="logo">
				<h1>Facebook</h1>
			</div>
		</header>
		<main>
			<center>
			<?php
				if ($password !== $confirmpassword)
				{
					$pwderror="Password are not matched, please re-enter your password";
					echo "<h3>".$pwderror."</h3>"."<br>";
				}
				else
				{
					echo "<h3>".$email_confirm."</h3>"."<br>";
					echo "<h3>".$namespace."</h3>"."<br>";
				}		   
			?>
			<form method="POST">
				<input type="submit" name="redirect_login" value="Click here to login">
			</form>
			</center>
		</main>
		<footer>
			<p>&copy;2018 Fbook, Arjith Inc.</p>
		</footer>
	</body>
</html>

<?php
	if(isset($_POST["redirect_login"]))
	{
		header("Location:fb_login.php");	 
	}
?> 
