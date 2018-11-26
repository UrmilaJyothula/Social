<?php
	session_start();
	if(!isset($_SESSION["findfriends"]))
	{
		header("Location:fb_login.php");  
	}
 
	$email = $_SESSION["email_login"];
	$servername = "192.168.0.4";
	$username_db = "root";
	$password = "1234";
	$dbname = "WD";
 
	$conn = mysqli_connect($servername, $username_db, $password, $dbname);
 
	if(!$conn) {
		die("Couldn't connect to database:".mysqli_connect_error());
	}
	
	$fullname = $_SESSION["fullname"];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Find friends</title>		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/findfriends.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
			function showHint(str) {
				if (str.length == 0) { 
					if ( $('#atag').children().length > 0 ) {
						$("#atag").empty();
					}
					//$('#atag').append($('<p></p>'));
					return;
				} else {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							if ( $('#atag').children().length > 0 ) {
								$("#atag").empty();
							}
							//document.getElementById("txtHint").innerHTML = this.responseText;
							if(this.responseText !== "No suggestions"){
								var names = JSON.parse(this.responseText);
								for (var i = 0; i < names.length; i++) {
									console.log(names[i]);
									var userLink = "viewprofile.php?friendname=" + names[i];
									$('#atag').append($('<a id="link" href="'+userLink+'">'+names[i]+'</a>'+'<br>'));
								}	
							}
							else{
								$('#atag').append($('<p>No suggestions found</p>'));
							}
						}	
					}
					xmlhttp.open("GET", "gethint.php?q="+str, true);
					xmlhttp.send();
				}
			}
		
		</script>
		
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
			<div id="innertube">
				<form class="formstyle">
					<center>
					<div>
						<label class="labels">Name:</label><br>
						<input type="text" onkeyup="showHint(this.value)" placeholder="Enter the full name">
					</div>
					<div id="atag"></div>
				</form>
			</div>
		</main>

	</body>
</html>

<?php
	if(isset($_POST["submit_logout"])) {
		unset($_SESSION["login_status"]);
		session_destroy();
		header("Location:fb_login.php");
	}
?>
