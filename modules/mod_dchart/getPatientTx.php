<?php
	
	$UPD = (isset($_POST["UPD"]) && !empty($_POST["UPD"])) ? $_POST["UPD"] : "0";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$numrows = 0;
	$res = "";
	
	if($pat != "") {
		include "../../config.inc.php";
		include "../../functions.inc.php";
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$query = "select ts.tht_id, th.tht_hpos, th.tht_vpos, t.trt_color, ts.trt_comb
		from {$DBName}.treatsession as ts left join {$DBName}.treatment as t on t.trt_id = ts.trt_id 
		left join {$DBName}.tooth as th on th.tht_cid = ts.tht_id
		left join {$DBName}.session as s on s.ses_number = ts.ses_number and s.cli_id = ts.cli_id 
		where ";
		if($UPD != "0") {
			$query .= "s.ses_id = {$UPD} ";
		}
		else if($UPD == "0") {
			$query .= "s.pat_id = '".utf8_decode($pat)."' and ts.rec_number != 0 and ts.tht_id != '' ";
		}
		$query .= "group by s.ses_number, s.cli_id, ts.trt_id, ts.tht_id
		order by ts.tht_id, th.tht_hpos, th.tht_vpos";
		//echo $query;
		if($result = @mysql_query($query, $link)) {
			$numrows = @mysql_num_rows($result);
			while($row = @mysql_fetch_row($result)) {
				list($tht_id, $tht_hpos, $tht_vpos, $color, $comb) = $row;
				$comb = explode(",", $comb);
				if(count($comb) > 0) {
					foreach($comb as $key => $face) {
						$res .= "tht{$tht_id}s{$face},{$color}*";
					}
				}
			}
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo (strlen($res) > 0) ? $res : (($numrows == 0) ? "EMPTY" : "ERROR");
?>