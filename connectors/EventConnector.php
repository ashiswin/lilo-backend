<?php
	class EventConnector {
		private $mysqli = NULL;
		
		public static $TABLE_NAME = "events";
		public static $COLUMN_ID = "id";
		public static $COLUMN_DESTINATIONID = "destinationId";
		public static $COLUMN_NAME = "name";
		public static $COLUMN_THUMBNAIL = "thumbnail";
		public static $COLUMN_DATE = "date";
		
		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $deleteStatement = NULL;
		
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}
			
			$this->mysqli = $mysqli;
			
			$this->createStatement = $mysqli->prepare("INSERT INTO " . EventConnector::$TABLE_NAME . "(`" . EventConnector::$COLUMN_DESTINATIONID . "`, `" . EventConnector::$COLUMN_NAME . "`, `" . EventConnector::$COLUMN_THUMBNAIL . "`, `" . EventConnector::$COLUMN_DATE . "`) VALUES(?, ?, ?, ?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM `" . EventConnector::$TABLE_NAME . "` WHERE `" . EventConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM `" . EventConnector::$TABLE_NAME . "` WHERE `" . EventConnector::$COLUMN_DESTINATIONID . "` = ?");
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . EventConnector::$TABLE_NAME . " WHERE `" . EventConnector::$COLUMN_ID . "` = ?");
		}
		
		public function create($destinationid, $name, $thumbnail, $date) {
			$this->createStatement->bind_param("ssbs", $destinationid, $name, $thumbnail, $date);
			return $this->createStatement->execute();
		}
		
		public function select($id) {
			$this->selectStatement->bind_param("i", $id);
			if(!$this->selectStatement->execute()) return false;

			$result = $this->selectStatement->get_result();
			if(!$result) return false;
			$event = $result->fetch_assoc();
			
			$this->selectStatement->free_result();
			
			return $event;
		}
		
		public function selectAll($destinationid) {
			$this->selectAllStatement->bind_param("i", $destinationid);
			
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
