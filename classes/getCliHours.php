<?
	$cli = $_POST["cli"];
	$date = $_POST["date"];
	$res = "";
	if(!empty($cli)) {
		include "../config.inc.php";

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		//$query = "select csc_day, csc_ini, csc_end from ".$DBName.".clinicsch where cli_id = ".$cli;
		$query = "select csc_day, csc_ini, csc_end from {$DBName}.clinicsch
		where cli_id = {$cli} and csc_date <= '{$date}'
		order by csc_date desc, csc_day limit 7";
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_row($result)) {
				$hi = explode(":", $row[1]);
				$he = explode(":", $row[2]);
				$res .= $row[0]."*".intval($hi[0])."*".intval($he[0])."|";
			}
			$res = substr($res, 0, -1);
		}
		@mysql_free_result($result);
	}
	echo $res;
?>