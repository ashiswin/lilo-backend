<?php
	require_once "utils/database.php";
	require_once "connectors/DestinationConnector.php";
	
	$DestinationConnector = new DestinationConnector($conn);
	$destinations = $DestinationConnector->selectAll();
	
	$response["success"] = true;
	$response["destinations"] = $destinations;
	
	echo(json_encode($response));
?>
