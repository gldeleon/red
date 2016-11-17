<?php

    $tpg = (isset($_POST["tpg"]) && !empty($_POST["tpg"])) ? $_POST["tpg"] : array();
	$txs = (isset($_POST["txs"]) && !empty($_POST["txs"])) ? $_POST["txs"] : "0";
	$txsm = (isset($_POST["txsm"]) && !empty($_POST["txsm"])) ? $_POST["txsm"] : "0";
	$res = "EMPTY";
	
	if(count($tpg) > 0) {
		$sTxList = implode(",", $tpg);
		if(strlen($sTxList) > 0) {
			/** Llama al archivo de configuracion. */
			include "../../config.inc.php";
	
			$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
			
			if($txs != "0" && $txsm != "0") {
				$query = "select t.tpg_id from {$DBName}.treatprog as t left join 
				(select pat_id, trt_id, tpg_qty, tpg_sessnum, tpg_sessfrom from 
				{$DBName}.treatprog where tpg_id = {$tpg[0]}) as x on x.pat_id = t.pat_id 
				where t.pat_id = x.pat_id and x.trt_id = t.trt_id and x.tpg_sessfrom = t.tpg_sessfrom 
				and (t.tht_id is null || t.tht_id = 0) and t.tpg_sessnum >={$txs} and t.tpg_sessfrom = {$txsm} 
				order by t.tpg_id limit ".($txsm - 1);
				if($result = @mysql_query($query, $link)) {
					$sTxList = "";
					while($row = @mysql_fetch_row($result)) {
						$sTxList .= $row[0].",";
					}
					if(strlen($sTxList) > 0) {
						if(substr($sTxList, -1) == ",") {
							$sTxList = substr($sTxList, 0, -1);
						}
					}
				}
			}
			
			$query = "delete from {$DBName}.treatprog where tpg_id in ({$sTxList})";
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