<?php
/*
* @
* @
* @
*/
	$tx = "";
	if(isset($_POST["sid"]) && $_POST["sid"] !== "") {
		$sid = $_POST["sid"];
		
		include "../config.inc.php";
		
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$query = "select trt_id, trt_name from {$DBName}.treatment where ";
		if($sid != "0") {
			$query .= "spc_id = {$sid} and ";
		}
		$query .= "trt_active = 1 order by trt_name";
		
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_row($result)) {
				$tx .= $row[0].",".utf8_encode($row[1])."*";
			}
		}
		@mysql_free_result($result);
		
		/** Agrega la revision y el diagnostico a la lista de tratamientos de odontopediatria. */
		if($sid == "3") {
			$query = "select trt_id, trt_name from ".$DBName.".treatment where trt_id = 3";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result)) {
					$tx .= $row[0].",".utf8_encode($row[1])."*";
				}
			}
		}
		
		/** Quita el último asterisco de la cadena. */
		$tx = substr($tx, 0, -1);
		
		@mysql_close($link);
	}
	echo $tx;
?>
