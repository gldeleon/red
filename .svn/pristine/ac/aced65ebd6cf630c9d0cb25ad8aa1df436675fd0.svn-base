<?php
	$UPD = (isset($_POST["UPD"]) && !empty($_POST["UPD"])) ? $_POST["UPD"] : "0";
	$res = "OK";

	include "../config.inc.php";

	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$empid = 0;
	$query = "select emp_id from {$DBName}.session where ses_id = {$UPD} limit 1";
	if($result = @mysql_query($query, $link)) {
		$empid = @mysql_result($result, 0);
		@mysql_free_result($result);
	}
	$empid = (is_null($empid) || $empid == "") ? 0 : $empid;
	$res = ($empid == 0) ? "DOCTOR" : "OK";
	@mysql_close($link);

	echo $res;
?>