<?php
	$conn = new mysqli("localhost", "lilo", "lilo", "lilo");
	if($conn->connect_error) {
		$response["success"] = false;
		$response["message"] = "Connection failed: " . $conn->connect_error;
	} 
?>
