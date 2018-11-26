<?php
	session_start();
	
	$fullname = $_SESSION["fullname"];
	$friendsname = $_GET["friendname"];
	
	$servername = "192.168.0.4";
	$username_db = "root";
	$password = "1234";
	$dbname = "WD";
	
	//echo $_GET["friendname"];
 
	$conn = mysqli_connect( $servername, $username_db, $password, $dbname);
	
	// *** still to do
	//once the username is searched enter his name into following table as not following
	
	if(!$conn) {
			die( "Couldn't connect to database:".mysqli_connect_error() );
	}
	
	$tablename = $fullname."_following";
	
	$sql = "CREATE TABLE IF NOT EXISTS `$tablename`(Friends_name varchar(200), Status varchar(200))";
	if(!mysqli_query($conn, $sql)){
		die("Error creating table: " . mysqli_error($conn));
	}
	
	
	$sql = "SELECT * FROM `$tablename` WHERE Friends_name = '$friendsname'";
	$result = mysqli_query( $conn, $sql );
	if($result) {
		if(mysqli_num_rows($result) == 0) {			
			$sql_i = "INSERT INTO `$tablename`(Friends_name, Status) VALUES('$friendsname', 'Not following')";
			if (!mysqli_query($conn, $sql_i)){
				die("Error: " . $sql . "<br>" . mysqli_error($conn));
			}		
		}
	}
	
	$sql = "SELECT * FROM `$tablename` WHERE Friends_name = '$friendsname'";
	$result = mysqli_query( $conn, $sql );
	if($result) {
		if(mysqli_num_rows($result) == 1){
			while($row = mysqli_fetch_assoc($result)){
				$following_status = $row["Status"];
			}
		}
	}	
	
	$frienduploadstable = $friendsname."_uploads";
	$friendsfilelocations = array();
	$friendsfilenames = array();
	
	$sql = "SELECT * FROM `$frienduploadstable`";
	$result = mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$filelocation = $row["File_location"];
				$filename = $row["File_name"];
				array_push($friendsfilenames, $filename);
				array_push($friendsfilelocations, $filelocation);
			}
		}
	}
	
	
	if(!file_exists("C:/xampp/htdocs/images/Uploads/$friendsname/")) {
		if(!mkdir("C:/xampp/htdocs/images/Uploads/$friendsname/")){
			die("mkdir problem");
		}
	}
	
	$destination = "C:/xampp/htdocs/images/Uploads/$friendsname/"; 
	for( $i = 0; $i < sizeof($friendsfilelocations); $i++ ) { 
		if( !empty( $friendsfilelocations[$i] ) ) {
				copy($friendsfilelocations[$i], $destination.$friendsfilenames[$i]);
		}
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>View Profile</title>		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/viewprofile.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<script>
			$(document).ready(function()
			{
				$("#btn").click(function(){
					var friendsname = '<?php echo $friendsname; ?>';
		
					$.post("jquery_post.php", 
						{ 
							name:friendsname
						},
						function(data, status){
							console.log(data);
							if(data === "Following"){
								$("#btn").html("Following");
								final("Following");
							}
							else if(data === "Not following"){
								$("#btn").html("Follow");
								final("Not following");
							}
						}
					);
				});
			});
			
			function final(data){
				var friendsname = '<?php echo $friendsname; ?>';
				
				if(data === "Not following"){
					$( "#outertube" ).load( "loadfollow.php", {"name": friendsname});
				}
				else if(data === "Following"){
					$( "#outertube" ).load( "loadimages.php", {"name": friendsname});
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
				<?php echo "<h4><a href=\"viewprofile.php?friendname=$friendsname\">$friendsname</a></h4>" ?>;
				<?php
					if($following_status === "Not following"){
						echo"<button id=\"btn\" class=\"button button_follow\">Follow</button>";
					}
					elseif($following_status === "Following"){
						echo"<button id=\"btn\" class=\"button button_follow\">Following</button>";
					}
				?>
			</div>
			<div id="outertube">
				<center>
				<?php
					if($following_status === "Following"){
						for($i = 0; $i < sizeof($friendsfilenames); $i++) {
							echo "<div id=\"img\">";
							echo "<a class=\"fname\" href=\"viewprofile.php?friendname=$friendsname\">$friendsname</a>";
							echo "<img class=\"myImg\" src=\"images/Uploads/$friendsname/$friendsfilenames[$i]\" alt=\"MUFC\" width=\"720\" height=\"480\">";
							echo "</div>";
						}
					}
					else if($following_status === "Not following"){
						echo "<img    border-radius: 5px; cursor: pointer; transition: 0.3s; margin-top: 15px; src=\"images/follow.png\" height=\"456\" width=\"360\">";
					}
				?>
				
				<!-- The Modal -->
				<div id="myModal" class="modal">
					<span class="close">&times;</span>
					<img class="modal-content" id="img01">
					<div id="caption"></div>
				</div>
				
				<script>
					// Get the modal
					var modal = document.getElementById('myModal');
					// Get the image and insert it inside the modal - use its "alt" text as a caption
					//var img = document.getElementsByClassName('myImg');
					var modalImg = document.getElementById("img01");
					var captionText = document.getElementById("caption");
					function showImageModal(){
						modal.style.display = "block";
						modalImg.src = this.src;
						modalImg.alt = this.alt;
						//captionText.innerHTML = this.alt;
					}
					
					var images = document.getElementsByClassName("myImg");
					for(let i=0; i<images.length; i++){
						images[i].addEventListener("click",showImageModal);
					}
					// Get the <span> element that closes the modal
					var span = document.getElementsByClassName("close")[0];
					// When the user clicks on <span> (x), close the modal
					span.onclick = function() { 
						modal.style.display = "none";
					}
				</script>
				</center>
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
