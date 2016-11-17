<?php

    $trs = (isset($_POST["trs"]) && !empty($_POST["trs"])) ? $_POST["trs"] : array();
	$res = "EMPTY";
	
	if(count($trs) > 0) {
		$sTxList = implode(",", $trs);
		if(strlen($sTxList) > 0) {
			/** Llama al archivo de configuracion. */
			include "../../config.inc.php";
	
			$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
			
			$query = "delete from {$DBName}.fee where trs_id in ({$sTxList})";
			@mysql_query($query, $link);
			
			$query = "delete from {$DBName}.treatsession where trs_id in ({$sTxList})";
			@mysql_query($query, $link);
			$affected = @mysql_affected_rows($link);
			
			if($affected > 0) {
				$res = "OK";
			}
			else $res = "ERROR";
		}
	}
	echo $res;
?>