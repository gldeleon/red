<?php
	$res = "ERROR";
	$UPD = (isset($_POST["UPD"]) && !empty($_POST["UPD"])) ? $_POST["UPD"] : "";
	$emp = (isset($_POST["emp"]) && !empty($_POST["emp"])) ? $_POST["emp"] : "";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "";
	if($UPD != "0" && $cli != "" && $emp != "") {
		
		/** Llama al archivo de configuraci�n. */
		include "../config.inc.php";
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$query = "update ".$DBName.".session set emp_id = ".$emp." where ses_id = ".$UPD." and cli_id = ".$cli;
		if($result = @mysql_query($query, $link)) {
			if(@mysql_affected_rows($link) > 0)
				$res = "OK";
		}
		@mysql_free_result($result);
		@mysql_close($link);
	}
	echo $res;
?>