<?php

	$UPD = (isset($_POST["UPD"]) && !empty($_POST["UPD"])) ? $_POST["UPD"] : "0";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$numrows = 0;
	$res = "";

	if($UPD != "0" && $cli != "0") {

		include "../../config.inc.php";
		include "../../functions.inc.php";

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$sessnum = "0";
		$query = "select ses_number from {$DBName}.session where ses_id = {$UPD}";
		if($result = @mysql_query($query, $link)) {
			$sessnum = @mysql_result($result, 0);
			@mysql_free_result($result);
		}

		if($sessnum != "0") {
			//group by ts.ses_number, ts.cli_id, ts.trt_id, ts.tht_id, ts.trs_sessnum, ts.trs_sessfrom
			$query = "select ts.trs_id, ts.trs_qty, ts.trs_sessnum, ts.trs_sessfrom, t.trt_abbr,
			t.trt_name, ts.tht_id, th.tht_name, th.tht_hpos, th.tht_vpos, th.tht_class
			from {$DBName}.treatsession as ts left join {$DBName}.treatment as t on t.trt_id = ts.trt_id
			left join {$DBName}.tooth as th on th.tht_cid = ts.tht_id and th.tht_class = ts.tht_class
			where ts.ses_number = {$sessnum} and ts.cli_id = {$cli}
			order by t.trt_abbr, ts.trs_sessnum, ts.trs_sessfrom";
			if($result = @mysql_query($query, $link)) {
				$numrows = @mysql_num_rows($result);
				while($row = @mysql_fetch_row($result)) {
					$trs_id = is_null($row[0]) ? "0" : $row[0];
					$tqty = is_null($row[1]) ? "0" : $row[1];
					$trt_abbr = is_null($row[4]) ? "" : substr(utf8_encode($row[4]), 0, 23);
					$trt_name = is_null($row[5]) ? "" : uppercase($row[5]);
					$tht_id = (is_null($row[6]) || $row[6] == "0") ? "--" : $row[6];
					$tooth = "";
					if(!is_null($row[7])) {
						$tooth .= $row[7];
						if(!is_null($row[9])) {
							$tooth .= " ".$row[9]."ERIOR";
						}
						if(!is_null($row[8])) {
							$tooth .= " ".(($row[8] == "C1" || $row[8] == "C4") ? "DERECHO" : "IZQUIERDO");
						}
						if(!is_null($row[10])) {
							$tooth .= " ".(($row[10] == "ADL") ? "ADULTO" : "INFANTIL");
						}
					}
					if(strlen($row[4]) > 23) {
						$trt_abbr .= "...";
					}
					$sess = "(".(is_null($row[2]) ? "1" : $row[2])."/".(is_null($row[3]) ? "1" : $row[3]).")";
					$res .= $tqty.",".$trt_abbr.",".$sess.",".$trt_name.",".$tht_id.",".$tooth.",".$trs_id."*";
				}
				@mysql_free_result($result);
			}
		}
		@mysql_close($link);
	}
	echo (strlen($res) > 0) ? $res : (($numrows == 0) ? "EMPTY" : "ERROR");
?>