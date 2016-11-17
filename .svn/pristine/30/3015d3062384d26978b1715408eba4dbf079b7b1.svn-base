<?php

	$string = (isset($_POST["string"]) && !empty($_POST["string"])) ? $_POST["string"] : "";
	$affected = 0;
	
	if($string != "") {
		$sArray = explode("|", $string);
		if(count($sArray) == 4) {
			$pat = $sArray[0];
			$cli = $sArray[1];
			$sess = $sArray[2];
			$string = $sArray[3];
			$pat = utf8_decode($pat);
			$sArray = explode("*", $string);
			array_pop($sArray);
			$sTxList = implode(",", $sArray);
			
			if(strlen($sTxList) > 0) {
				/** Llama al archivo de configuracion. */
				include "../../config.inc.php";

				$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
				
				$sessnum = "0";
				$query = "select ses_number from {$DBName}.session where ses_id = {$sess}";
				if($result = @mysql_query($query, $link)) {
					$sessnum = @mysql_result($result, 0);
					@mysql_free_result($result);
				}
				
				if($sessnum != "0") {
					foreach($sArray as $item => $value) {
						$query = "select trt_id, trs_sessnum, trs_sessfrom, trp_price, agt_discount,
						trs_amount, trs_payment, rec_number, tht_id, trt_comb, tht_class 
						from {$DBName}.treatsession 
						where trs_id = {$value} and ses_number = {$sessnum} limit 1";
						if($result = @mysql_query($query, $link)) {
							$row = @mysql_fetch_row($result);
							
							$query2 = "insert into {$DBName}.treatprog set pat_id = '{$pat}', trt_id = {$row[0]},
							tpg_sessnum = {$row[1]}, tpg_sessfrom = {$row[2]}, trp_price = {$row[3]},
							agt_discount = {$row[4]}, trs_amount = {$row[5]}, tpg_payment = {$row[6]}, 
							rec_number = {$row[7]}, tht_id = {$row[8]}, trt_comb = '{$row[9]}',
							tht_class = '{$row[10]}'";
							@mysql_query($query2, $link);
							if(@mysql_affected_rows($link) > 0) {
								$affected++;
							}
							@mysql_free_result($result);
						}
					}
					
					$query = "delete from {$DBName}.fee where trs_id in ({$sTxList}) and ses_id = {$sess}";
					@mysql_query($query, $link);
					
					$query = "delete from {$DBName}.treatsession where trs_id in ({$sTxList}) and ses_number = {$sessnum}";
					@mysql_query($query, $link);
					if(@mysql_affected_rows($link) > 0) {
						$affected++;
					}
				}
				
				//
				@mysql_close($link);
			}
		}
	}
	echo ($affected !== false && $affected > 1) ? "OK" : "ERROR";
?>