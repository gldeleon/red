<?php
	$emp = (isset($_POST["emp"]) && !empty($_POST["emp"])) ? $_POST["emp"] : "1";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$vd = (isset($_POST["vd"]) && !empty($_POST["vd"])) ? $_POST["vd"] : "";
	$hini = (isset($_POST["hini"]) && !empty($_POST["hini"])) ? $_POST["hini"] : "";
	$len = (isset($_POST["len"]) && !empty($_POST["len"])) ? $_POST["len"] : "0";
	$chair = (isset($_POST["chair"]) && !empty($_POST["chair"])) ? $_POST["chair"] : "0";
	$stat = (isset($_POST["stat"]) && !empty($_POST["stat"])) ? $_POST["stat"] : "0";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$uid = (isset($_POST["uid"]) && !empty($_POST["uid"])) ? $_POST["uid"] : "0";
	$desc = (isset($_POST["desc"]) && !empty($_POST["desc"])) ? $_POST["desc"] : "";
	$minute = (isset($_POST["minute"]) && !empty($_POST["minute"])) ? $_POST["minute"] : "0";
	$treat = (isset($_POST["treat"]) && !empty($_POST["treat"])) ? $_POST["treat"] : "";
	$res = "ERROR";

	if($hini != "" && $len != "0" && $vd != "" && $chair != "0" && $cli != "0" && $uid != "0") {
		include "../config.inc.php";

		$vd = explode("/", $vd);
		$vd = $vd[2]."-".$vd[1]."-".$vd[0];
		$minute = (strlen($minute) < 2) ? ("0".$minute) : $minute;
		$hini = ((strlen($hini) < 2) ? ("0".$hini) : $hini).":".$minute.":00";
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$arrayChairs = array();
		$clc = "1";
		$query = "select cli_chairs, clc_id from ".$DBName.".clinic where cli_id = ".$cli;
		if($result = @mysql_query($query, $link)) {
			if(@mysql_num_rows($result) > 0) {
				array_push($arrayChairs, $row[0]);
				$clc = $row[1];
			}
			@mysql_free_result($result);
		}

		$pos = array_search($chair, $arrayChairs);
		$query = "select vst_id from ".$DBName.".visit where cli_id = ".$cli." and cli_chair = ".$chair." and vst_date = '".$vd."' and vst_ini = '".$hini."' and vta_id not in (7,9)";
		if($result = @mysql_query($query, $link)) {
			if(@mysql_num_rows($result) > 0) {
				$res = "EXISTS";
			}
			@mysql_free_result($result);
		}

		if($res == "EXISTS") {
			for($i = 0; $i < count($arrayChairs); $i++) {
				if($arrayChairs[$i] == $chair)
					continue;
				$query = "select vst_id from ".$DBName.".visit where cli_id = ".$cli." and cli_chair = ".$arrayChairs[$i]." and vst_date = '".$vd."' and vst_ini = '".$hini."' and vta_id not in (7,9)";
				if($result = @mysql_query($query, $link)) {
					if(@mysql_num_rows($result) > 0)
						continue;
					else $res = "CHAIR";
					@mysql_free_result($result);
				}
			}
		}

		if($res == "EXISTS" || $res == "CHAIR") {
			echo $res;
			exit();
		}
		$desc = (strlen($desc) > 0) ? $desc : "Sin observaciones";
		$desc = preg_replace("/[^ a-zA-Z0-9s]/", "", $desc);
		$query = "insert into ".$DBName.".visit(vst_id,clc_id,cli_id,vln_id,vta_id,pat_id,usr_id,emp_id,cli_chair,vst_date,vst_ini,vst_descr,vst_usrmod,vst_datemod) values(NULL, '{$clc}', ".$cli.", ".$len.", 1, '".utf8_decode($pat)."', ".$uid.", ".$emp.", ".$chair.", '".$vd."', '".$hini."', '".$desc."', NULL, NULL)";
		if($result = @mysql_query($query, $link)) {
			if(@mysql_affected_rows($link) > 0) {
				$res = @mysql_insert_id($link);
				if($treat != "") {
					$trtArray = explode("*", $treat);
					array_pop($trtArray);
					if(count($trtArray) > 0) {
						foreach($trtArray as $item => $value) {
							$query2 = "insert into ".$DBName.".vistreat values (NULL, ".$res.", ".$value.")";
							@mysql_query($query2, $link);
						}
					}
				}
			}
			@mysql_free_result($result);
		}

		$query = "select emp_abbr from ".$DBName.".employee where emp_id = ".$emp;
		if($result = @mysql_query($query, $link)) {
			$row = @mysql_fetch_row($result);
			$res .= "*".$row[0];
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo $res;
?>