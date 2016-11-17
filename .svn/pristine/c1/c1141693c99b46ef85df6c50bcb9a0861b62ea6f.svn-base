<?php
	$res = "ERROR";
	$uid = (isset($_POST["uid"]) && !empty($_POST["uid"])) ? $_POST["uid"] : "0";
	if($uid != "0") {
		include "../config.inc.php";
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		$query = "select usr_pref from ".$DBName.".user where usr_id = ".$uid;
		if($result = @mysql_query($query, $link)) {
			$row = @mysql_fetch_row($result);
			$res = $row[0];
		}
		@mysql_free_result($result);
		@mysql_close($link);
	}
	echo $res;
?>