<?php
	require_once "utils/database.php";
	require_once "connectors/ImageConnector.php";
	
	$destination = $_GET['id'];
		
	$ImageConnector = new ImageConnector($conn);
	$images = $ImageConnector->selectAll($destination);
	
	$response["success"] = true;
	$response["images"] = $images;
	
	echo(json_encode($response));
?>
