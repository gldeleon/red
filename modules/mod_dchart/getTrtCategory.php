<?php
	$trt = (isset($_POST["trt"]) && !empty($_POST["trt"])) ? $_POST["trt"] : "0";
	$res = "";

	if($trt != "0") {
		//Llama al archivo de configuracion.
		include "../../config.inc.php";
		include "../../functions.inc.php";
		
		//Obtiene un objeto de conexion con la base de datos.
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$query = "select spc_id, trt_sess, trt_divsess, trt_color, tcy_number, trt_maxsess 
		from {$DBName}.treatment where trt_id = {$trt}";
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_row($result)) {
				list($spc_id, $trt_sess, $trt_divsess, $trt_color, $tcy_number, $trt_maxsess) = $row;
				$res .= "{$spc_id},{$trt_sess},{$trt_divsess},{$trt_color},{$tcy_number},{$trt_maxsess}";
			}
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo (strlen($res) > 0) ? $res : "ERROR";
?>