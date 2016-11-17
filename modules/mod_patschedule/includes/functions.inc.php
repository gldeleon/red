<?php
function horarioSel($hi, $hf, $hs, $busquedaMinutos, $interval) {


	if((($hs["hora"]*60)+$hs["min"]) >= (($hi["hora"]*60)+$hi["min"]) && (($hs["hora"]*60)+$hs["min"]) < (($hf["hora"]*60)+$hf["min"])){
		for($i = (($hs["hora"]*60)+$hs["min"]); $i <= (($hs["hora"]*60)+$hs["min"]+$busquedaMinutos); $i+=$interval ){
			$result[] =  getHHMM($i);
		}
	}

	return $result;
	}

	
function horarioSeleccionado($hi, $hf, $hs, $interval) {
	
	
		if((($hs["hora"]*60)+$hs["min"]) >= (($hi["hora"]*60)+$hi["min"]) && (($hs["hora"]*60)+$hs["min"]) < (($hf["hora"]*60)+$hf["min"])){
			for($i = (($hi["hora"]*60)+$hi["min"]); $i <= (($hf["hora"]*60)+$hf["min"]); $i+=$interval ){
				$result[] =  getHHMM($i);
			}
		}
	
		return $result;
}
	

function mostrarIntervalo($hi, $hf, $cli, $chair, $day, $date, $clid, $hs, $busquedaMinutos, $interval) {
	//$HoraMin = $HoraDesde;
	$result = array();
	
// 	$microsec = date("U", mktime($HoraMin["hora"], $HoraMin["min"], 0, 1,1,1));
	
// 	$result[] = str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$microsec;
// 	do {
// 		$HoraMin['min'] = $HoraMin['min'] + 15;
// 		if ($HoraMin['min'] >= 60) {
// 			$HoraMin['min'] = 0;
// 			$HoraMin['hora'] = $HoraMin['hora'] + 1;
// 			if ($HoraMin['hora'] >= 24) {
// 				$HoraMin['hora'] = 0;
// 			}
// 		}
// 		if (($HoraMin['hora'] >= $HoraHasta['hora']) and ($HoraMin['min'] >= $HoraHasta['min'])) {
// 			break;
// 		}
// 		else {
// 			$microsec = date("U", mktime($HoraMin["hora"], $HoraMin["min"], 0, 1,1,1));
// 			array_push($result, str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$microsec);
				
// 		}
// 	} while (true);
	//$result[] = $HoraHasta['hora'].":".str_pad($HoraHasta['min'],2,0,STR_PAD_RIGHT);
	
	
// 	#hora inicio 11:00
// 	$hi["hora"]=11;
// 	$hi["min"]=00;
// 	#hora fin 22:00
// 	$hf["hora"]=22;
// 	$hf["min"]=00;
// 	#hora sel 13:00
// 	$hs["hora"]=13;
// 	$hs["min"]=00;
//  $busquedaMinutos = 60
//  $interval = 15
	if((($hs["hora"]*60)+$hs["min"]) >= (($hi["hora"]*60)+$hi["min"]) && (($hs["hora"]*60)+$hs["min"]) < (($hf["hora"]*60)+$hf["min"])){
		for($i = (($hs["hora"]*60)+$hs["min"]); $i <= (($hs["hora"]*60)+$hs["min"]+$busquedaMinutos); $i+=$interval ){
			
			$result[] =  getHHMM($i)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid;
		}
		}

	
// 	list($h,$m,$s) = explode(":", $horaSel);
// 	$sel = mktime($h, $m,$s,1,1,1);
// 	$microsec = mktime($HoraDesde["hora"], $HoraDesde["min"], 0, 1,1,1);
// 	$hi = mktime($HoraDesde["hora"], $HoraDesde["min"], 0, 1,1,1);
// 	$hf = mktime($HoraHasta["hora"], $HoraHasta["min"], 0, 1,1,1);
// 	$result[] = $h.":".$m." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$microsec;
// 	$inicio = $sel;
	
// 	while($inicio < $hf) {
// 		$inicio += 900;
// 		$hora = date("H:i", $inicio);
// 		$result[] = $hora." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$inicio;
// 	}

 	return $result;
}

function mostrarIntervalo2($hi, $hf, $cli, $chair, $day, $date, $clid, $hs, $busquedaMinutos, $interval) {
	
	$result = array();

	//if((($hs["hora"]*60)+$hs["min"]) >= (($hi["hora"]*60)+$hi["min"]) && (($hs["hora"]*60)+$hs["min"]) < (($hf["hora"]*60)+$hf["min"])){
		//for($i = (($hi["hora"]*60)+$hi["min"]); $i <= (($hf["hora"]*60)+$hf["min"]); $i+=$interval ){
		for($i = (($hi["hora"]*60)+$hi["min"]); (($i <= (($hf["hora"]*60)+$hf["min"])) && ($i <= (($hs["hora"]*60)+$hs["min"]+$busquedaMinutos)) && ($i >= (($hs["hora"]*60)+$hs["min"])) ); $i+=$interval ){
			$result[] =  getHHMM($i)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid;
		}
	//}

	return $result;
	}

	
	function mostrarIntervaloDr($hi, $hf, $cli, $chair, $day, $date, $clid, $hs, $busquedaMinutos, $interval, $emp_id, $emp_complete) {
	
		$result = array();
// 		echo print_r($hi,true)." ".print_r($hf,true)." ".print_r($hs,true)."<br/>";
		//if((($hs["hora"]*60)+$hs["min"]) >= (($hi["hora"]*60)+$hi["min"]) && (($hs["hora"]*60)+$hs["min"]) < (($hf["hora"]*60)+$hf["min"])){
		//for($i = (($hi["hora"]*60)+$hi["min"]); $i <= (($hf["hora"]*60)+$hf["min"]); $i+=$interval ){
		
// 		$vhi = (($hi["hora"]*60)+$hi["min"]);
// 		$vhf = (($hf["hora"]*60)+$hf["min"]);
// 		$vhs = (($hs["hora"]*60)+$hs["min"]);
// 		$vi = $vhi;
		
// 		
		
		
// 		echo (($hi["hora"]*60)+$hi["min"])." - ".(($hf["hora"]*60)+$hf["min"])." - ".(($hs["hora"]*60)+$hs["min"])."<br/>";
		for($i = (($hi["hora"]*60)+$hi["min"]); ($i <= (($hf["hora"]*60)+$hf["min"])) ; $i+=$interval ){
			//echo $i. " <= " .($vhs+$busquedaMinutos)." && ".$i. " >= " .$vhs;
			if( ( ($i <= (($hs["hora"]*60)+$hs["min"]+$busquedaMinutos)) && ($i >= (($hs["hora"]*60)+$hs["min"])) ) ){
				//echo "Si<br/>";
				$result[] =  getHHMM($i)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$emp_id." - ".$emp_complete;
			}else{
				//echo "No<br/>";
			}
// 			$result[] =  getHHMM($i)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$emp_id." - ".$emp_complete;
		}
		//}
	
		return $result;
		}
	
function getHHMM($hora_en_minutos){
	$hora = floor($hora_en_minutos / 60);
	$min = $hora_en_minutos % 60;
	return ((strlen($hora) == 1)? '0'.$hora : $hora) . ":" .  ((strlen($min) == 1)? '0'.$min : $min);
}


function dateInterval($date_ini, $date_end){
	
	$interval = array();
	$date = $date_ini;
	$i = 0;
	list($year, $month, $day) = explode("-", $date);
	
	while($date != $date_end){
		
		$date = date("Y-m-d", mktime(0,0,0, $month, $day+$i, $year));
		$interval[] = $date;
		$i++;
		
	}
	
	return $interval;
	
}

function hourInteval($HoraDesde, $HoraHasta) {
	
	$HoraMin = $HoraDesde;
	
	$options = "<option value='".str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)."'>".
				str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)."</option>";
	do {
		$HoraMin['min'] = $HoraMin['min'] + 15;
		if ($HoraMin['min'] >= 60) {
			$HoraMin['min'] = 0;
			$HoraMin['hora'] = $HoraMin['hora'] + 1;
			if ($HoraMin['hora'] >= 24) {
				$HoraMin['hora'] = 0;
			}
		}
		if (($HoraMin['hora'] >= $HoraHasta['hora']) and ($HoraMin['min'] >= $HoraHasta['min'])) {
			break;
		}
		else {
			$options .= "<option value='".str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)."'>".
			str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)."</option>";
		}
	} while (true);
	//$result[] = $HoraHasta['hora'].":".str_pad($HoraHasta['min'],2,0,STR_PAD_RIGHT);

	return $options;
}

// function mostrarIntervaloDr($HoraDesde, $HoraHasta, $cli, $chair, $day, $date, $clid, $drid, $dr) {
// 	$HoraMin = $HoraDesde;
// 	$result = array();

// 	$microsec = date("U", mktime($HoraMin["hora"], $HoraMin["min"], 0, 1,1,1));

// 	$result[] = str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$microsec." - ".$drid." - ".$dr;
// 	do {
// 		$HoraMin['min'] = $HoraMin['min'] + 15;
// 		if ($HoraMin['min'] >= 60) {
// 			$HoraMin['min'] = 0;
// 			$HoraMin['hora'] = $HoraMin['hora'] + 1;
// 			if ($HoraMin['hora'] >= 24) {
// 				$HoraMin['hora'] = 0;
// 			}
// 		}
// 		if (($HoraMin['hora'] >= $HoraHasta['hora']) and ($HoraMin['min'] >= $HoraHasta['min'])) {
// 			break;
// 		}
// 		else {
// 			$microsec = date("U", mktime($HoraMin["hora"], $HoraMin["min"], 0, 1,1,1));
// 			array_push($result, str_pad($HoraMin['hora'],2,'0', STR_PAD_LEFT).":".str_pad($HoraMin['min'],2,0,STR_PAD_RIGHT)." - ".$cli." - ".$chair." - ".$day." - ".$date." - ".$clid." - ".$microsec." - ".$drid." - ".$dr);

// 		}
// 	} while (true);
// 	$result[] = $HoraHasta['hora'].":".str_pad($HoraHasta['min'],2,0,STR_PAD_RIGHT);

// 	return $result;
// }

?>