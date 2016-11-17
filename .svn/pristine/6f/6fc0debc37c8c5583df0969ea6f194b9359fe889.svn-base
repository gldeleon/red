<?php

include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/execQuery.class.php";
include_once "../../../config.class.php";
include_once "../classes/mod_patschedule_select.class.php";
include_once "../includes/functions.inc.php";

$spc = (isset($_POST["spc"]) && !empty($_POST["spc"])) ? $_POST["spc"] : 2;
$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : 0;
$horaSel = (isset($_POST["ini"]) && !empty($_POST["ini"])) ? $_POST["ini"].":00" : "10:00:00";

$busy = $merged = $diff = $libre = $doctores = $lastArray = $libreAssoc = array();
$disponibles = $clisch = $visitsch = $horarioClinica = $horarioOcupado = $spcsch = $horarioDoctor =array();

$showHr = ($cli != 0) ? 480 : 60;
$interval = 15;
$fi = date("Y-m-d");
list($yi, $mi, $di) = explode("-", $fi);
$ff = date("Y-m-d", mktime(0, 0, 0, $mi, $di+15, $yi));

##############################
####  HORARIO DE CLINICA  ####
##############################

$weekDays = dateInterval($fi, $ff);

foreach($weekDays as $wdData){

	list($year, $month, $day) = explode("-", $wdData);
	$no_day = date("w", mktime(0,0,0,$month, $day, $year));

	$query = mod_patschedule_select::cliScheduleDent($no_day, $cli);
	$execQuery = new execQuery($query);
	$cliResult = $execQuery->getQueryResults();

	foreach($cliResult as $cliData){
			
		list($csc_ini, $csc_end, $cli_id, $csc_day,
		$cli_chair, $cli_name) = explode(__SEPARATOR, $cliData);
			
		list($chorai, $cmini, $cseci) = explode(":", $csc_ini);
		list($choraf, $cminf, $csecf) = explode(":", $csc_end);
		list($shora, $smin, $ssec) = explode(":", $horaSel);
			
		$HoraDesde = array("hora" => $chorai, "min" => $cmini);
		$HoraHasta = array("hora" => $choraf, "min" => $cminf);
		$horaSelec = array("hora" => $shora, "min" => $smin);
		$clisch[] = mostrarIntervalo($HoraDesde, $HoraHasta, $cli_name, $cli_chair, $csc_day, $wdData, $cli_id, $horaSelec, $showHr, $interval);
			
	}

}

foreach($clisch as $csh){

	foreach($csh as $data){
		$horarioClinica[] = $data;
	}

}

//   echo "<pre>".print_r($horarioClinica, true)."</pre>";

#########################
#### HORARIO OCUPADO ####
#########################

$query = mod_patschedule_select::vstSchedule($cli, $fi);
$execQuery = new execQuery($query);
$vstResult = $execQuery->getQueryResults();

foreach($vstResult as $vstData){

	list($vst_date, $vst_ini, $vst_end, $day, $cli_id, 
		 $cli_chair, $cli_name) = explode(__SEPARATOR, $vstData);
		
	list($chorai, $cmini, $cseci) = explode(":", $vst_ini);
	list($choraf, $cminf, $csecf) = explode(":", $vst_end);
	list($shora, $smin, $ssec) = explode(":", $horaSel);
		
	$HoraDesde = array("hora" => $chorai, "min" => $cmini);
	$HoraHasta = array("hora" => $choraf, "min" => $cminf);
	$horaSelec = array("hora" => $shora, "min" => $smin);

	$visitsch[] = mostrarIntervalo2($HoraDesde, $HoraHasta, $cli_name, $cli_chair, $day, $vst_date, $cli_id, $horaSelec, $showHr, $interval);
		
}

foreach($visitsch as $vstsch){

	foreach($vstsch as $data){

		$horarioOcupado[] = $data;

	}

}

//  echo "<pre>".print_r($horarioOcupado, true)."</pre>";

#########################
#### HORARIOS LIBRES ####
#########################

$diff = array_diff($horarioClinica, $horarioOcupado);


foreach($diff as $diffVal){

	list($hora, $cliName, $chair, $day, $fecha, $cliId) = explode(" - ", $diffVal);
	$libreAssoc[] = array("cli_name" => $cliName,
					 "cli_chair" => $chair,
					 "day" => $day,
					 "date" => $fecha,
					 "cli_id" => $cliId,
					 "hora_ini" => $hora);

}

//  echo "<pre>".print_r($libreAssoc, true)."</pre>";

###############################
####  HORARIO DE DOCTORES  ####
###############################

foreach($weekDays as $wdData){

	list($year, $month, $day) = explode("-", $wdData);
	$no_day = date("w", mktime(0,0,0,$month, $day, $year));

	$query = mod_patschedule_select::spcSchedule($no_day, $spc, $cli);
	
	//selects::spcSchedule($no_day, $cli, $zpc, $stt, $speciality);
	//  	echo "<br/><br/>";
	$execQuery = new execQuery($query);
	$spcResult = $execQuery->getQueryResults();

	foreach($spcResult as $spcData){
		
		list($ssch_ini, $ssch_end, $cli_id, $ssch_day,
		$cli_chair, $emp_id, $emp_complete, $cli_name) = explode(__SEPARATOR, $spcData);
			
		// 		echo $ssch_ini." - ".$ssch_end."<br/>";
		list($horai, $mini, $seci) = explode(":", $ssch_ini);
		list($horaf, $minf, $secf) = explode(":", $ssch_end);
		list($shora, $smin, $ssec) = explode(":", $horaSel);

		$HoraDesde = array("hora" => $horai, "min" => $mini);
		$HoraHasta = array("hora" => $horaf, "min" => $minf);
		$horaSelec = array("hora" => $shora, "min" => $smin);
			
		//$spcsch[] = mostrarIntervaloDr($HoraDesde, $HoraHasta, $cli_name, $cli_chair, $ssch_day, $wdData, $cli_id, $emp_id, $emp_complete);
		$spcsch[] = mostrarIntervaloDr($HoraDesde, $HoraHasta, $cli_name, $cli_chair, $ssch_day, $wdData, $cli_id, $horaSelec, $showHr, 30, $emp_id, $emp_complete);
			
	}

}

foreach($spcsch as $spcVal){

	foreach($spcVal as $spcValVal){

		list($horaIni, $cliName, $chair, $day, $fecha, $cliId, $empId, $empComplete) = explode(" - ", $spcValVal);

		$doctores[] = array("hora_ini" => $horaIni,
							 "cli_name" => $cliName,
							 "cli_chair" => $chair,
							 "day" => $day,
							 "date" => $fecha,
							 "cli_id" => $cliId,
							 "emp_id" => $empId,
							 "emp_complete" => $empComplete);

	}

}

foreach($libreAssoc as $libreVal){

	foreach($doctores as $drVal){

		if($libreVal["hora_ini"].$libreVal["cli_name"].$libreVal["date"].$libreVal["cli_id"].$libreVal["day"] .$libreVal["date"].$libreVal["cli_chair"] ==
		$drVal["hora_ini"].$drVal["cli_name"].$drVal["date"].$drVal["cli_id"].$drVal["day"].$drVal["date"].$drVal["cli_chair"]){
				
			$lastArray[] = $drVal["hora_ini"]." - ".$drVal["cli_name"]." - ".$drVal["cli_chair"]
			." - ".$drVal["day"]." - ".$drVal["date"]." - ".$drVal["cli_id"]
			." - ".$drVal["emp_id"]." - ".$drVal["emp_complete"]." - ".$libreVal["cli_chair"];
				
		}

	}

}


if(count($lastArray) > 0){
	$results = "<table id='resultTable' cellspacing='0'>";

	for($i=0; $i<count($lastArray); $i++){
		$tdColor = '#ffffff';
		if(empty($lastArray[$i])){
			break;
		}
			
		list($hora_ini, $clinica, $sillon, $dia, $fecha,
		$clid, $drId, $doctor, $cli_chair) = explode(" - ", $lastArray[$i]);
			
		$pair = $i+1;
			
		if($pair%2 == 0){
			$tdColor = '#d5edf4';
		}
			
		list($anio, $mes, $dia) = explode("-", $fecha);
		$fecha2 = date("d/m/Y", mktime(0,0,0,$mes, $dia, $anio));

		$results .= "<tr>
							<td style='background-color: {$tdColor}' class='hlength'><span id='gotodate' onclick='gotoDate(\"".$fecha."\", ".$clid.")'>".$hora_ini."</span></td> 
							<td style='background-color: {$tdColor}' class='drName'>".ucwords(strtolower($doctor))."</td> 
 							<td style='background-color: {$tdColor}' class='cliName'>".utf8_encode($clinica)."</td>
 							<td style='background-color: {$tdColor}'>".$fecha2."</td>

						</tr>";

	}

	$results .= "</table>";
}
else{
	$results = "<p align='center'><b>No se encontraron horarios disponibles.</b></p>";
}
echo $results;



// $limit = ($cli != 0) ? 20 : 10;

// if($ini != "0"){
// list($iniHour, $iniMin) = explode(":", $ini);
// $selMs = date("U", mktime($iniHour, $iniMin, 0, 1,1,1));
// }
// else{
// 	$selMs = 0;
// }

// $query = mod_patschedule_select::vstSchedule($spc, $cli);
// $execQuery = new execQuery($query);
// $vstResult = $execQuery->getQueryResults();
// $busy = $interval = $merged = $diff = $fechas = array();


// $weekDays = dateInterval(date("Y-m-d"), 15);

// foreach($weekDays as $wdData){
	
// 	list($year, $month, $day) = explode("-", $wdData);
// 	$no_day = date("w", mktime(0,0,0,$month, $day, $year));
	
// 	$query = mod_patschedule_select::spcSchedule($no_day, $spc, $cli);
// 	echo "<br/><br/>";
// 	$execQuery = new execQuery($query);
// 	$spcResult = $execQuery->getQueryResults();
	
	
// 		foreach($spcResult as $spcData){
			
// 			list($ssch_ini, $ssch_end, $scli_id, $ssch_day, $cli_chair, $semp_id, 
// 				 $semp_complete, $scli_name) = explode(__SEPARATOR, $spcData);
			
// 			list($shorai, $smini, $sseci) = explode(":", $ssch_ini);
// 			list($shoraf, $sminf, $ssecf) = explode(":", $ssch_end);

// 			$HoraDesde = array("hora" => $shorai, "min" => $smini);
// 			$HoraHasta = array("hora" => $shoraf, "min" => $sminf);
			
// 			$interval = mostrarIntervalo($HoraDesde, $HoraHasta, $semp_complete, $scli_name, $ssch_day, $wdData, $scli_id);
			
// 			foreach($vstResult as $vstData){
				
// 				list($vst_date, $vst_ini, $vst_end, $day, $cli_id, $emp_id, 
// 					 $cli_chair, $emp_complete, $spc_id, $cli_name) = explode(__SEPARATOR, $vstData);
				
// 				list($horai,$mini, $seci) = explode(":", $vst_ini);
// 				list($horaf,$minf, $secf) = explode(":", $vst_end);
				
// 				$HoraDesde = array("hora" => $horai, "min" => $mini);
// 				$HoraHasta = array("hora" => $horaf, "min" => $minf);
				
// 				if($day == $ssch_day && $emp_id == $semp_id && $cli_name = $scli_name){
// 					$busy[] = mostrarIntervalo($HoraDesde, $HoraHasta, $emp_complete, $cli_name, $day, $vst_date, $cli_id);
// 					$fechas[] = $vst_date;
// 				}
				
// 			}
			
// 			foreach($busy as $busyVal){
			
// 				foreach($busyVal as $busyValVal){
// 					$merged[] = $busyValVal;
// 				}
			
// 			}
			
// 			$diff[] = array_diff($interval, $merged);
			
// 		}

// }


// $fechas = array_unique($fechas);
// $lastArray = array();
// echo "<pre>".print_r($interval, true)."</pre>";



// for($j=0; $j<count($diff); $j++){
	
// 	$index = count(array_keys($diff[$j]))-1;
// 	$indexArray = array_keys($diff[$j]);
// 	$schIndex = $indexArray[$index]+1;
// 	$free = $inArray = FALSE;
// 	$horaFin = $cadena = "";

	
// 	if(!empty($diff[$j])){
// 			for($i=0; $i<$schIndex; $i++){
				
				
// 				if(!empty($diff[$j][$i])){
					
// 					list($hora, $dr, $clinica, $dia, $fecha, $clid, $microsec) = explode(" - ", $diff[$j][$i]);
// 					list($hour, $minute, $second) = explode(":", $hora);
// 					$horaFin = date("H:i:s", mktime($hour, $minute+15, $second, 1,1,1));
					
// 					if($selMs == 0){
// 						if(!$free){
// 							$cadena = $hora." - ".$dr." - ".$clinica." - ".$dia." - ".$fecha." - ".$clid." - ".$microsec;
// 							$free = TRUE;
// 						}
// 					}
// 					else{
// 						if($selMs == $microsec){
// 							if(!$free){
// 								$cadena = $hora." - ".$dr." - ".$clinica." - ".$dia." - ".$fecha." - ".$clid." - ".$microsec;
// 								$free = TRUE;
// 							}
// 						}
						
// 					}	
					
// 				}
// 				else{
		
// 					$free = FALSE;
// 					if($cadena != ""){
// 						$lastArray[] = $cadena." - ".$horaFin;
// 						$cadena = "";
// 					}
			
// 				}
				
// 				if($i == $schIndex-1){
					
// 					$lastArray[] = $cadena." - ".$horaFin;
					
// 				}
	
// 		 	}
// 	}
 	
// }

// echo "<pre>".print_r($lastArray, true)."</pre>";

// if(count($lastArray) > 0){
// 		$results = "<table id='resultTable' cellspacing='0'>";
		
// 		for($i=0; $i<$limit; $i++){
// 			$tdColor = '#ffffff';
// 			if(empty($lastArray[$i])){
// 				break;
// 			}
			
// 			list($hora_ini, $doctor, $clinica, $dia, $fecha, 
// 				 $clid, $microsec, $hora_fin) = explode(" - ", $lastArray[$i]);
			
// 			$pair = $i+1;
			
// 		    if($pair%2 == 0){
// 		        $tdColor = '#d5edf4';
// 		    }
			
// 		    if($microsec != ""){
// 			$results .= "<tr>
// 							<td style='background-color: {$tdColor}' class='hlength'><span id='gotodate' onclick='gotoDate(\"".$fecha."\", ".$clid.")'>".$hora_ini." - ".substr($hora_fin,0,-3)."</span></td> 
// 							<td style='background-color: {$tdColor}' class='drName'>".ucwords(strtolower($doctor))."</td> 
// 							<td style='background-color: {$tdColor}' class='cliName'>".utf8_encode($clinica)."</td>
// 							<td style='background-color: {$tdColor}'>".$fecha."</td>
// 						</tr>";
// 		    }
			
			
			
// 		}
		
// 		$results .= "</table>";
// }
// else{
// 	$results = "<p align='center'><b>No se encontraron horarios.</b></p>";
// }
// echo $results;


?>
