<?php
	class DestinationConnector {
		private $mysqli = NULL;
		
		public static $TABLE_NAME = "destinations";
		public static $COLUMN_ID = "id";
		public static $COLUMN_NAME = "name";
		public static $COLUMN_LAT = "lat";
		public static $COLUMN_LONG = "lon";
		public static $COLUMN_DETAILS = "details";
		
		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $deleteStatement = NULL;
		
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}
			
			$this->mysqli = $mysqli;
			
			$this->createStatement = $mysqli->prepare("INSERT INTO " . DestinationConnector::$TABLE_NAME . "(`" . DestinationConnector::$COLUMN_NAME . "`, `" . DestinationConnector::$COLUMN_LAT . "`, `" . DestinationConnector::$COLUMN_LONG . "`, `" . DestinationConnector::$COLUMN_DETAILS . "`) VALUES(?, ?, ?, ?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM `" . DestinationConnector::$TABLE_NAME . "` WHERE `" . DestinationConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM `" . DestinationConnector::$TABLE_NAME . "`");
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . DestinationConnector::$TABLE_NAME . " WHERE `" . DestinationConnector::$COLUMN_ID . "` = ?");
		}
		
		public function create($name, $lat, $long, $details) {
			$this->createStatement->bind_param("ssss", $name, $lat, $long, $details);
			return $this->createStatement->execute();
		}
		
		public function select($id) {
			$this->selectStatement->bind_param("i", $id);
			if(!$this->selectStatement->execute()) return false;

			$result = $this->selectStatement->get_result();
			if(!$result) return false;
			$destination = $result->fetch_assoc();
			
			$this->selectStatement->free_result();
			
			return $destination;
		}
		
		public function selectAll() {
			if(!$this->selectAllStatement->execute()) return false;
			$result = $this->selectAllStatement->get_result();
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}
		
		public function delete($id) {
			if($id == NULL) return false;
			
			$this->deleteStatement->bind_param("i", $id);
			if(!$this->deleteStatement->execute()) return false;
			
			return true;
		}
	}
?>
