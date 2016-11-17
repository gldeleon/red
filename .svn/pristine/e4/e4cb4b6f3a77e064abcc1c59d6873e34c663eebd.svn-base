<?
	/** Carga variables URL y determina sus valores iniciales. */
	$oid = (isset($_POST["oid"]) && !empty($_POST["oid"])) ? $_POST["oid"] : "";
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
	$treat = (isset($_POST["treat"]) && !empty($_POST["treat"])) ? $_POST["treat"] : "0";
	$res = "ERROR";

	if($oid != "" && $hini != "" && $len != "0" && $vd != "" && $chair != "0" && $cli != "0" && $uid != "0") {

		/** Llama al archivo de configuracion. */
		include "../config.inc.php";

		/** Establece la zona horaria para trabajar con fechas. */
		date_default_timezone_set("America/Mexico_City");

		$vd = explode("/", $vd);
		$vd = $vd[2]."-".$vd[1]."-".$vd[0];
		$minute = (strlen($minute) < 2) ? ("0".$minute) : $minute;
		$hini = ((strlen($hini) < 2) ? ("0".$hini) : $hini).":".$minute.":00";

		/** Obtiene un objeto de conexion con la base de datos. */
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$arrayChairs = array();
		$query = "select cli_chairs from {$DBName}.clinic where cli_id = {$cli}";
		if($result = @mysql_query($query, $link)) {
			if(@mysql_num_rows($result) > 0) {
				array_push($arrayChairs, $row[0]);
			}
			@mysql_free_result($result);
		}
		//$pos = array_search($chair, $arrayChairs);

		$query = "select vst_id from {$DBName}.visit where cli_id = {$cli}
		and cli_chair = {$chair} and vst_date = '{$vd}' and vst_ini = '{$hini}'
		and vta_id not in (7,9) limit 1";
		if($result = @mysql_query($query, $link)) {
			if(@mysql_num_rows($result) > 0) {
				if(@mysql_result($result, 0) != $oid)
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

		if($res != "EXISTS" && $res != "CHAIR") {
			$desc = (strlen($desc) > 0) ? $desc : "Sin observaciones";
			$desc = preg_replace("/[^ a-zA-Z0-9s]/", "", $desc);

                         $backup = "insert into ".$DBName.".visithist (select null, vst.* from ".$DBName.".visit vst
                                   where vst.vst_id = ".$oid.")";

                        @mysql_query($backup, $link);

			$query = "update ".$DBName.".visit set vln_id = ".$len.", pat_id = '".utf8_decode($pat)."',
			vst_usrmod = ".$uid.", emp_id = ".$emp.", cli_chair = ".$chair.", vst_date = '".$vd."',
			vst_ini = '".$hini."', vst_descr = '".$desc."', vst_datemod = '".date("Y-m-d")."'
			where vst_id = ".$oid;
			if($result = @mysql_query($query, $link)) {
				if(@mysql_affected_rows($link) >= 0) {
					$res = "OK";
					if($treat != "") {
						$trtArray = explode("*", $treat);
						array_pop($trtArray);
						if(count($trtArray) > 0) {
							$query2 = "delete from ".$DBName.".vistreat where vst_id = ".$oid;
							@mysql_query($query2, $link);
							foreach($trtArray as $item => $value) {
								$query3 = "insert into ".$DBName.".vistreat values (NULL, ".$oid.", ".$value.")";
								@mysql_query($query3, $link);
							}
						}
					}
				}
				@mysql_free_result($result);
			}
		}
		@mysql_close($link);
	}
	echo $res;
?>