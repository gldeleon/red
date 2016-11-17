<?
	$string = (isset($_POST["string"]) && !empty($_POST["string"])) ? $_POST["string"] : "";
	$affected = 0;

	if($string != "") {
		$sArray = explode("|", $string);
		if(count($sArray) == 2) {
			$pat = $sArray[0];
			$string = $sArray[1];
			$pat = utf8_decode($pat);
			$sArray = explode("*", $string);
			array_pop($sArray);
			
			if(count($sArray) > 0) {
				/** Llama al archivo de configuración. */
				include "../config.inc.php";
				
				/** Obtiene un objeto de conexión con la base de datos. */
				$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
				
				foreach($sArray as $item => $value) {
					$query = "delete from {$DBName}.treatprog where tpg_id = {$value}";
					@mysql_query($query, $link);
					if(@mysql_affected_rows($link) !== false)
						$affected++;
				}
			}
		}
	}
	echo ($affected > 0) ? "OK" : "ERROR";
?>
