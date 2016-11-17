<?php
	class Patient {
		private $conn;
		private $pat;

		public function __construct($pat_id) {
			global $DBServer, $DBUser, $DBPaswd, $DBName;

			/** Obtiene un objeto de conexión con la base de datos. */
			$this->conn = @mysql_connect($DBServer, $DBUser, $DBPaswd);
			@mysql_select_db($DBName);
			if(isset($pat_id))
				$this->pat = $pat_id;
		}

		public function getPatientCompleteName() {
			$patcomp = "NOMBRE DEL PACIENTE";
			$query = "select pat_complete from patient where pat_id = '".$this->pat."'";
			if($result = @mysql_query($query, $this->conn)) {
				$patcomp = @mysql_result($result, 0);
				//$patcomp = ucwords(mb_strtolower(utf8_encode($patcomp), "UTF-8"));
				$patcomp = ucwords(strtolower($patcomp));
				@mysql_free_result($result);
			}
			return $patcomp;
		}

		public function getPatientBalance($patbaldate = "") {
			$bal = $importe = $total = $totalms = 0;
			/*$query = "select p.pagado - sum(s.suma) from (select sum(rec_amount) as pagado
			from receipt where pat_id = '".$this->pat."' and rec_status = 0 and rec_paymeth != 'PA') as p,
			(select rec_payment as suma from receipt where pat_id = '".$this->pat."' and rec_status = 0
			group by rec_number) as s group by p.pagado";*/

			/**
			 * Obtiene el monto total de los recibos que no son modificaciones
			 * de saldo.
			 */
			$query = "select sum(t.total) from (select rec_payment as total from receipt
			where pat_id = '{$this->pat}' and rec_status = 0 and rec_paymeth != 'MS' and rec_paymeth != 'PD' and rec_paymeth != 'AP'";
			if($patbaldate != "") {
				$query .= "and rec_date <= '{$patbaldate}' ";
			}
			$query .= "group by rec_number) as t";
			if($result = @mysql_query($query, $this->conn)) {
				$total = @mysql_result($result, 0);
				@mysql_free_result($result);
			}

			/**
			 * Obtiene el total de los recibos que son modificaciones de saldo.
			 */
			$query = "select sum(rec_payment) from receipt where pat_id = '{$this->pat}'
			and rec_status = 0 and rec_paymeth in ('MS', 'AP')  ";
			if($patbaldate != "") {
				$query .= "and rec_date <= '{$patbaldate}'";
			}
			if($result = @mysql_query($query, $this->conn)) {
				$totalms = @mysql_result($result, 0);
				@mysql_free_result($result);
			}
			$total += $totalms;

			/**
			 * Obtiene el importe real. La suma de los importes que no son
			 * pagos anticipados.
			 */
			$query = "select sum(if(rec_paymeth = 'PA', 0, rec_amount)) from receipt
			where rec_status = 0 and pat_id = '{$this->pat}' and rec_paymeth != 'PD' and rec_paymeth != 'AP' ";
			if($patbaldate != "") {
				$query .= "and rec_date <= '{$patbaldate}'";
			}
			if($result = @mysql_query($query, $this->conn)) {
				$importe = @mysql_result($result, 0);
				@mysql_free_result($result);
			}
			$bal = $importe - $total;

			return $bal;
		}

		public function getPatientLegalStatus() {
			$status = 0;
			$query = "select ptl_id from patlegal where pat_id = '".$this->pat."'";
			if($result = @mysql_query($query, $this->conn)) {
				$status = @mysql_num_rows($result);
				@mysql_free_result($result);
			}
			return $status;
		}

		public function getPatientAgrColor() {
			$aglid = "0";
			$query = "select a.agl_id from agreement as a
			left join patient as p on p.agr_id = a.agr_id where p.pat_id = '".$this->pat."'
			and agr_active = 1";
			if($result = @mysql_query($query, $this->conn)) {
				$aglid = @mysql_result($result, 0);
				@mysql_free_result($result);
			}
			$agrcolor = "#084C9D";
			$query = "select pgc_color from patagrcolor where pgc_id = ".($aglid + 1);
			if($result = @mysql_query($query, $this->conn)) {
				$agrcolor = @mysql_result($result, 0);
				@mysql_free_result($result);
			}

			return $agrcolor;
		}

		public function __destruct() {
			@mysql_close($this->conn);
			unset($this->conn);
		}
	}
?>
