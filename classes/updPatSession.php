<?php
	/** Carga variables URL y determina sus valores iniciales. */
	$sid = (isset($_POST["sid"]) && !empty($_POST["sid"])) ? $_POST["sid"] : "0";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$gto = (isset($_POST["gto"]) && !empty($_POST["gto"])) ? $_POST["gto"] : "";
	$auth = (isset($_POST["auth"]) && !empty($_POST["auth"])) ? strtoupper($_POST["auth"]) : "";
	$act = (isset($_POST["act"]) && !empty($_POST["act"])) ? $_POST["act"] : "0";

	$res = "ERROR";

	if($sid != "0" && $cli != "0" && $act != "0") {
		/** Llama al archivo de configuraci�n. */
		include "../config.inc.php";

		/** Establece la zona horaria para trabajar con fechas. */
		date_default_timezone_set("America/Mexico_City");

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		switch($act) {
			case "exit":
				$query = "update {$DBName}.session set ses_end = '".date("H:i:s")."' where ses_id = {$sid} and cli_id = {$cli}";
				break;
			case "end":
				//Buscamos el ses_number
				$query = "SELECT ses_number FROM {$DBName}.session where ses_id = {$sid} and cli_id = {$cli}";
				if(($result = mysql_query($query, $link) or die(mysql_error($link)) ) && mysql_num_rows($result)>0) {
					$row = @mysql_fetch_assoc($result);
					$ses_number = $row["ses_number"];
					//Validamos si ya pagó
					$query = "SELECT rec_id FROM {$DBName}.receipt WHERE cli_id = {$cli} AND ses_number = {$ses_number};";
					if(($result = mysql_query($query, $link) or die(mysql_error($link))) && mysql_num_rows($result) === 0) {
						//No ha pagado, regresa error
						echo "SIN_PAGO";
						return false;
					}
				}
				else{
					//No encontró el ses_number
					echo "ERROR";
					return false;
				}
				//Todo en orden, se cierra la sesión
				$query = "update {$DBName}.session set ses_status = 6 where ses_id = {$sid} and cli_id = {$cli}";
				break;
		}
		if($result = @mysql_query($query, $link)) {
			if(@mysql_affected_rows($link) >= 0)
				$res = "OK";
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo $res;
?>