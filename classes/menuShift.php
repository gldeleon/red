<?php
	include "../config.inc.php";
	$mid = $_POST["mid"];
	$url = "javascript:void(0);";
	
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	$query = "select mnu_url from ".$DBName.".menu where mnu_id = ".$mid;
	$result = @mysql_query($query, $link);
	$res = @mysql_result($result, 0);
	echo (!$res) ? $url : $res;
	@mysql_close($link);
?>
