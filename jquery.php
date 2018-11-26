<?php
	session_start();
	
	$servername = "192.168.0.4";
	$username_db = "root";
	$password = "1234";
	$dbname = "WD";
	
	
	$fullname = $_SESSION["fullname"];
	
	$conn = mysqli_connect( $servername, $username_db, $password, $dbname);
 
	if(!$conn)
	{
		die( "Couldn't connect to database:".mysqli_connect_error() );
	}
	
	
	if(!empty($_POST["name"])) {
		
		$name = $_POST["name"];
		$tablename = $fullname."_following";
		
		$sql = "SELECT * FROM `$tablename` WHERE Friends_name='$name'";
		$result = mysqli_query( $conn, $sql );
		if($result) {
			if(mysqli_num_rows($result) == 1) {
				while( $row = mysqli_fetch_assoc( $result ) ) {
					$status = $row["Status"];
				}
			}
		}		
		
		if($status === "Not following"){
			$status = "Following";
		}
		elseif($status === "Following"){
			$status = "Not following";
		}
		$sql = "UPDATE `$tablename` SET Status='$status' WHERE Friends_name='$name'";
		if(mysqli_query( $conn, $sql )) {
			$sql_update = "SELECT * FROM `$tablename` WHERE Friends_name='$name'";
			$result = mysqli_query( $conn, $sql_update );
			if($result) {
				if( mysqli_num_rows($result) == 1) {
					while( $row = mysqli_fetch_assoc( $result ) ) {
						$status = $row["Status"];
					}
				}
			}
			echo $status;
		}
		
	}
?>
