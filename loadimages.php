<?php
	
	$servername = "192.168.0.4";
	$username_db = "root";
	$password = "1234";
	$dbname = "WD";
 
	$conn = mysqli_connect( $servername, $username_db, $password, $dbname);
 
	if(!$conn)
	{
		die( "Couldn't connect to database:".mysqli_connect_error() );
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
		<link rel="stylesheet" type="text/css" href="css/loadimages.css">
	</head>
	
	<body>		
		
		<div id="outertube">
				<center>
				<?php
					if(isset($_POST["name"])){
		
						$friendsname = $_POST["name"];
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
							if(!empty( $friendsfilelocations[$i])) {
								copy($friendsfilelocations[$i], $destination.$friendsfilenames[$i]);
							}
						}
		
						for($i = 0; $i < sizeof($friendsfilenames); $i++) {
							echo "<div id=\"img\">";
							echo "<a class=\"fname\" href=\"viewprofile.php?friendname=$friendsname\">$friendsname</a>";
							echo "<img class=\"myImg\" src=\"images/Uploads/$friendsname/$friendsfilenames[$i]\" alt=\"MUFC\" width=\"720\" height=\"480\">";
							echo "</div>";
						}
					}
				?>
				
				<div id="myModal" class="modal">
					<span class="close">&times;</span>
					<img class="modal-content" id="img01">
					<div id="caption"></div>
				</div>
				
				<script>
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
	</body>
</html>
