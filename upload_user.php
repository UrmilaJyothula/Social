<?php
	session_start();
	if(!isset($_SESSION["login_status"]))
	{
		header("Location:fb_login.php");  
	}
	else
	{	 
		if(!isset($_SESSION["fileuploaded"]))
		{
			$_SESSION["fileuploaded"] = True;  
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
	if(!file_exists("C:/Users/DELL/Desktop/Uploads/$fullname/")) {
		mkdir("C:/Users/DELL/Desktop/Uploads/$fullname/");
	}
 
?>

<html>
	<head>
		<title>
			Fb-Upload-User
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
			<center>
			<div class="upload_style">
				<form method="POST" enctype="multipart/form-data">
					<input class="sample" type="file" name="uploadfile" value="uploadfile"><br>
					<br><input type="submit" name="upload_submit" value="Upload File">
				</form>
			</div>
			</center>
		</main>
		<footer>
			<p>&copy;2018 Fbook, Arjith Inc.</p>
		</footer>
	</body>
</html>

<?php
	$_SESSION["uploadoutput"]=True;
	if(isset($_POST["submit_logout"])) {
		unset($_SESSION["login_status"]);
		session_destroy();
		header("Location:fb_login.php");
		exit;
	} 
 
 
	if(isset($_POST["upload_submit"])&& isset($_FILES["uploadfile"])) {
		
		$uploaddir = "C:/Users/DELL/Desktop/Uploads/"."$fullname/";
		$original_name = $_SESSION["original_name"] = $_FILES["uploadfile"]["name"];
		
		$byte_size = $_FILES["uploadfile"]["size"];
		$uploadfile = $uploaddir.basename($original_name);
		
		$temporary_name = $_FILES["uploadfile"]["tmp_name"];
		
		if(move_uploaded_file($temporary_name, $uploadfile)) {
			
			$_SESSION["file_output"] = $original_name." has been uploaded successfully";
			$tablename = $fullname."_uploads";
			
			$sql = "CREATE TABLE IF NOT EXISTS `$tablename`(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, File_name VARCHAR(500), File_location VARCHAR(500), File_size VARCHAR(500), reg_date TIMESTAMP)";          
			if(mysqli_query($conn, $sql)){
				#echo "couldn't create table successfully:".mysqli_error($conn_db_output_upload);
			}
             
			$sql = "INSERT INTO `$tablename`(File_name, File_location, File_size) VALUES('$original_name', '$uploadfile', '$byte_size')";
			if(mysqli_query($conn, $sql)) {
				#echo "File information of ".$original_name." is successfully inserted into table:".$lastname_upload_output."<br>";
			}
			else {
				#echo "Couldn't enter data successfully:".mysqli_error($conn_db_output_upload);
			}
		}
		$_SESSION["upload_output"] = True;
		header("Location:fb_upload_output.php");
	}
?>
