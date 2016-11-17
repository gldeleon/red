<?
	$res = "ERROR";
	$oid = (isset($_POST["oid"]) && !empty($_POST["oid"])) ? $_POST["oid"] : "0";
	$act = (isset($_POST["act"]) && !empty($_POST["act"])) ? $_POST["act"] : "0";
	$reason = (isset($_POST["reason"]) && !empty($_POST["reason"])) ? $_POST["reason"] : "";
	
	if($oid != "0" && $act != "0") {
	
		/** Llama al archivo de configuraci�n. */
		include "../config.inc.php";
		
		
		$oid = str_replace("visit", "", $oid);
		$oid = str_replace("[", "", $oid);
		$oid = str_replace("]", "", $oid);
		
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		/** Lleva a cabo la consulta de actualizaci�n. */

                $backup = "insert into ".$DBName.".visithist (select null, vst.* from ".$DBName.".visit vst
                                   where vst.vst_id = ".$oid.")";

                @mysql_query($backup, $link);


		$query = "update ".$DBName.".visit set vta_id = ".$act." where vst_id = ".$oid;
		if($result = @mysql_query($query, $link)) {
			if(@mysql_affected_rows($link) >= 0)
				$res = "OK";
			if(@mysql_affected_rows($link) < 0)
				$res = "ERROR";
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo $res;
?>