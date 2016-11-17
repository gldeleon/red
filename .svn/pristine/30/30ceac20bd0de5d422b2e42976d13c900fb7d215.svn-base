<?php
    
	$trt = (isset($_POST["trt"]) && !empty($_POST["trt"])) ? $_POST["trt"] : "0";
	$tht = (isset($_POST["tht"]) && !empty($_POST["tht"])) ? $_POST["tht"] : "0";
	$comb = (isset($_POST["comb"]) && !empty($_POST["comb"])) ? $_POST["comb"] : "";
	$jcmb = (isset($_POST["jcmb"]) && !empty($_POST["jcmb"])) ? $_POST["jcmb"] : "0";
	$res = "";
	
	if($trt != "0") {
		//*** Llama al archivo de configuracion.
		include "../../config.inc.php";
		
		//*** Obtiene un objeto de conexion con la base de datos.
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$query = "select trt_comb from {$DBName}.treatment where trt_id = {$trt}";
		if($result = @mysql_query($query, $link)) {
			$trt_comb = @mysql_result($result, 0);
			$trt_comb = (is_null($trt_comb) || $trt_comb == "") ? "" : $trt_comb;
			@mysql_free_result($result);
		}
		@mysql_close($link);
		$jcomb = $trt_comb;
		
		if($trt_comb == "") {
			echo "EMPTY";
			exit;
		}
		$crown = 0;
		$crown_array = array("V", "L", "P", "M", "D", "O");
		$trt_comb = str_split($trt_comb);
		$trt_comb = array_unique($trt_comb);
		if(count($trt_comb) > 0) {
			foreach ($crown_array as $item => $value) {
				if(in_array($value, $trt_comb)) {
					$crown++;
				}
			}
			if($crown > 4) {
				echo "CROWN";
				exit;
			}
			if($comb != "" && in_array($comb, $trt_comb)) {
				echo "OK";
			}
			elseif($comb == "" && $jcmb == "1") {
				echo $jcomb;
			}
			else {
				echo "NO";
			}
		}
		else {
			echo "EMPTY";
		}
	}
?>