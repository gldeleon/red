<?php
	/* Carga variables URL y determina sus valores iniciales */
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$rec = (isset($_POST["rec"]) && !empty($_POST["rec"])) ? $_POST["rec"] : "0";
	$res = "ERROR";
	
	if ($pat != "" && $cli != "0" && $rec != "0") {
		$pat = utf8_decode($pat);
		
		/* Llama al archivo de configuracion. */
		include "../config.inc.php";
		include_once "waitTime.class.php";

		$waitTime = new waitTime();
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$ses_id = $sesnum = "0";
		$query = "select ses_number from {$DBName}.receipt
		where rec_number = {$rec} and cli_id = {$cli}";
		if ($result = @mysql_query($query, $link)) {
			$sesnum = @mysql_result($result, 0);
			@mysql_free_result($result);
		}
		$sesnum = (is_null($sesnum) || $sesnum == "") ? "0" : $sesnum;
		
		$query = "select ses_id from {$DBName}.session where cli_id = {$cli} 
		and ses_number = {$sesnum}";
		if ($result = @mysql_query($query, $link)) {
			$ses_id = @mysql_result($result, 0);
			@mysql_free_result($result);
		}
		$ses_id = (is_null($ses_id) || $ses_id == "") ? "0" : $ses_id;
		
		$waitTime->updatePatwaittime($ses_id);
		
		/* Cancela el recibo como tal */
		$cancel = 0;
		$query = "update {$DBName}.receipt set rec_status = 1, rec_subject = ''
		where rec_number = {$rec} and cli_id = {$cli}";
		@mysql_query($query, $link);
		if (@mysql_affected_rows($link) >= 0) {
			$cancel++;
		}
		
		/* Marca los tratamientos relacionados como no pagados */
		$query = "update {$DBName}.treatsession set trs_payment = 0, rec_number = 0
		where rec_number = {$rec} and cli_id = {$cli} and ses_number = {$sesnum}";
		@mysql_query($query, $link);
		if (@mysql_affected_rows($link) >= 0) {
			$cancel++;
		}
		
		if ($cancel >= 1) {
			$res = "OK";
		}
	}
	echo $res;
?>