<?php
	require_once "utils/database.php";
	require_once "connectors/EventConnector.php";
	
	$destination = $_GET['id'];
		
	$EventConnector = new EventConnector($conn);
	$events = $EventConnector->selectAll($destination);
	
	$response["success"] = true;
	$response["events"] = $events;
	
	echo(json_encode($response));
?>
