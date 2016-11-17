<? 
	class Clinic {
		private $conn;
		private $cli;
		
		public function __construct($cli_id) {
			global $DBServer, $DBUser, $DBPaswd, $DBName;
			
			/** Obtiene un objeto de conexión con la base de datos. */
			$this->conn = @mysql_connect($DBServer, $DBUser, $DBPaswd);
			@mysql_select_db($DBName);
			if(isset($cli_id))
				$this->cli = $cli_id;
		}
		
		public function getClinicName() {
			$clinom = "Nombre de la Cl&iacute;nica";
			$query = "select cli_name from clinic where cli_id = ".$this->cli;
			if($result = @mysql_query($query, $this->conn)) {
				$clinom = @mysql_result($result, 0);
				$clinom = utf8_encode(ucwords(strtolower($clinom)));
				@mysql_free_result($result);
			}
			return $clinom;
		}
		
		public function getClinicShortName() {
			$clinom = "Cl&iacute;nica";
			$query = "select cli_shortname from clinic where cli_id = ".$this->cli;
			if($result = @mysql_query($query, $this->conn)) {
				$clinom = @mysql_result($result, 0);
				$clinom = utf8_encode(ucwords(strtolower($clinom)));
				@mysql_free_result($result);
			}
			return $clinom;
		}
		
		public function getClinicChairNum() {
			$chairs = 0;
			$query = "select cli_chairs from clinic where cli_id = ".$this->cli;
			if($result = @mysql_query($query, $this->conn)) {
				$chairs = @mysql_result($result, 0);
				$chairs = intval($chairs);
				@mysql_free_result($result);
			}
			return $chairs;
		}
		
		public function __destruct() {
			@mysql_close($this->conn);
			unset($this->conn);
		}
	}
?>