<?php
	class ImageConnector {
		private $mysqli = NULL;
		
		public static $TABLE_NAME = "images";
		public static $COLUMN_ID = "id";
		public static $COLUMN_DESTINATIONID = "destinationId";
		public static $COLUMN_SRC = "src";
		public static $COLUMN_DATETAKEN = "dateTaken";
		
		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $deleteStatement = NULL;
		
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}
			
			$this->mysqli = $mysqli;
			
			$this->createStatement = $mysqli->prepare("INSERT INTO " . ImageConnector::$TABLE_NAME . "(`" . ImageConnector::$COLUMN_DESTINATIONID . "`, `" . ImageConnector::$COLUMN_SRC . "`, `" . ImageConnector::$COLUMN_DATETAKEN . "`) VALUES(?, ?, ?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM `" . ImageConnector::$TABLE_NAME . "` WHERE `" . ImageConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM `" . ImageConnector::$TABLE_NAME . "` WHERE `" . ImageConnector::$COLUMN_DESTINATIONID . "` = ?");
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . ImageConnector::$TABLE_NAME . " WHERE `" . ImageConnector::$COLUMN_ID . "` = ?");
		}
		
		public function create($destinationid, $src, $datetaken) {
			$this->createStatement->bind_param("sbs", $destinationid, $src, $datetaken);
			return $this->createStatement->execute();
		}
		
		public function select($id) {
			$this->selectStatement->bind_param("i", $id);
			if(!$this->selectStatement->execute()) return false;

			$result = $this->selectStatement->get_result();
			if(!$result) return false;
			$image = $result->fetch_assoc();
			
			$this->selectStatement->free_result();
			
			return $image;
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
