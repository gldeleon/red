<?php
	/* Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	$res = "ERROR";
	/* Carga variables URL y determina sus valores iniciales. */
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$emp = (isset($_POST["emp"]) && !empty($_POST["emp"])) ? $_POST["emp"] : "0";
	$usr = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : "1";

	if($pat != "" && $cli != "0" && $usr != "0") {
		/* Llama al archivo de configuracion. */
		include "../config.inc.php";

		$pat = utf8_decode($pat);

		/* Obtiene un objeto de conexion con la base de datos. */
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$sessnum  = "1";
		$query = "select max(ses_number) + 1 from {$DBName}.session
		where cli_id = {$cli}";
		if($result = @mysql_query($query, $link)) {
			$sessnum = @mysql_result($result, 0);
			@mysql_free_result($result);
		}
		$sessnum = is_null($sessnum) ? "1" : $sessnum;

		if($sessnum != "0") {
			$query = "insert into {$DBName}.session set ses_number = '{$sessnum}',
			pat_id = '{$pat}', cli_id = '{$cli}', emp_id = '{$emp}', usr_id = '{$usr}',
			ses_date = curdate(), ses_ini = curtime()";
			@mysql_query($query, $link);
			if(@mysql_affected_rows($link) > 0) {
				$res = "OK";
			}
		}
		@mysql_close($link);
	}
	echo $res;
?>