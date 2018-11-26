<?php
	$users = array();
	
	$servername = "192.168.0.4";
	$username_db = "root";
	$password = "1234";
	$dbname = "WD";
 
	$conn = mysqli_connect($servername, $username_db, $password, $dbname);
 
	if(!$conn) {
		die("Couldn't connect to database:".mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM User_Info";
	$result = mysqli_query( $conn, $sql );
	if($result) {
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$user = $row["Full_name"];
				array_push($users, $user);
			}
		}
	}	
	// get the q parameter from URL
	$q = $_REQUEST["q"];
	$hints = array();
	// lookup all hints from array if $q is different from "" 
	if ($q !== "") {
		$q = strtolower($q);
		$len=strlen($q);
		foreach($users as $name) {
			if (stristr($q, substr($name, 0, $len))) {
				array_push($hints, $name);
			}
		}
	}
// Output "no suggestion" if no hint was found or output correct values 
	if(sizeof($hints) > 0){
		echo json_encode($hints);
	}
	else{
		echo "No suggestions";
	}
