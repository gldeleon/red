<?php
	/** Carga variables URL y determina sus valores iniciales. */
	$oid = (isset($_POST["oid"]) && !empty($_POST["oid"])) ? $_POST["oid"] : "";
	$oid = str_replace("visit", "", $oid);
	$oid = str_replace("[", "", $oid);
	$oid = str_replace("]", "", $oid);
	$res = "ERROR";

	if($oid != "") {
		/** Llama al archivo de configuración. */
		include "../config.inc.php";

		/** Obtiene un objeto de conexión con la base de datos. */
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		/** Establece la zona horaria para trabajar con fechas. */
		date_default_timezone_set("America/Mexico_City");

		$query = "select v.vln_id, v.pat_id, v.emp_id, v.cli_chair, v.vst_date, v.vst_ini,
		v.vst_descr, p.pat_complete, e.emp_complete from {$DBName}.visit as v
		left join {$DBName}.patient as p on p.pat_id = v.pat_id
		left join {$DBName}.employee as e on e.emp_id = v.emp_id
		where v.vst_id = {$oid} limit 1";
		if($result = @mysql_query($query, $link)) {
			/** Obtiene una sola fila del resultado. */
			$row = @mysql_fetch_row($result);

			/** Determina el valor de las variables de acuerdo al resultado obtenido. */
			$len = is_null($row[0]) ? "0" : $row[0];
			$pat_id = is_null($row[1]) ? "0" : utf8_encode($row[1]);
			$emp_id = is_null($row[2]) ? "0" : $row[2];
			$chair = is_null($row[3]) ? "0" : $row[3];
			$date = is_null($row[4]) ? date("Y-m-d") : date("Y-m-d", strtotime($row[4]));
			$hour = is_null($row[5]) ? date("H:i:s") : date("H:i:s", strtotime($row[5]));
			$desc = (is_null($row[6]) || (strlen(trim($row[6])) == 0)) ? "" : utf8_encode($row[6]);
			$pat = is_null($row[7]) ? "" : utf8_encode($row[7]);
			$emp = is_null($row[8]) ? "" : utf8_encode($row[8]);

			$trtstr = "";
			$query2 = "select v.trt_id, t.spc_id from {$DBName}.vistreat as v
			left join {$DBName}.treatment as t on t.trt_id = v.trt_id
			where v.vst_id = {$oid} and v.trt_id != 0 limit 1";
			if($result2 = @mysql_query($query2, $link)) {
				if(@mysql_num_rows($result2) > 0) {
					$trtstr = "|";
					while($row2 = @mysql_fetch_row($result2)) {
						$trtstr .= $row2[0]."-".$row2[1]."*";
					}
					if(substr($trtstr, -1, 1) == "*") {
						$trtstr = substr($trtstr, 0, -1);
					}
				}
				@mysql_free_result($result2);
			}
			/** Genera la cadena de respuesta. */
			$res = $oid."*".$len."*".$pat_id."*".$emp_id."*".$chair."*".$date."*".$hour."*".$desc."*".$pat."*".$emp;
			$res .= $trtstr;

			/** Libera el espacio en memoria ocupado por la variable. */
			@mysql_free_result($result);
		}
		/** Cierra la conexión con la base de datos. */
		@mysql_close($link);
	}
	echo $res;
?>