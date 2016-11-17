<?php
	$res = "ERROR";
	$uid = (isset($_POST["uid"]) && !empty($_POST["uid"])) ? $_POST["uid"] : "0";
	$pref = (isset($_POST["pref"]) && !empty($_POST["pref"])) ? $_POST["pref"] : "";
	
	if($uid != "0" && $pref != "") {
		
		/** Llama al archivo de configuración. */
		include "../config.inc.php";
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$query = "update ".$DBName.".user set usr_pref = '".$pref."' where usr_id = ".$uid;
		if($result = @mysql_query($query, $link)) {
			//PUEDE SER QUE NO SE TENGA QUE ACTUALIZAR NADA, NO DEBE MARCAR ERROR!!!!
			if(@mysql_affected_rows($link) >= 0)
				$res = "OK";
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo $res;
?>