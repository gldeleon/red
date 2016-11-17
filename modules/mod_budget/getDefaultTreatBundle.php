<?
	$spc = (isset($_POST["spc"]) && !empty($_POST["spc"])) ? $_POST["spc"] : "0";
	$res = "";
	
	if($spc != "0") {
		/** Llama al archivo de configuración. */
		include "../config.inc.php";
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$query = "select dfb_id, dfb_name from ".$DBName.".deftreatbund where spc_id = ".$spc;
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_row($result)) {
				$res .= $row[0]."|".utf8_encode($row[1])."*";
			}
			@mysql_free_result($result);
			$res = substr($res, 0, -1);
		}
		@mysql_close($link);
	}
	echo $res;
?>