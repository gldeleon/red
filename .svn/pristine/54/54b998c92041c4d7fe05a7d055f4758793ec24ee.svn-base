<?php
include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/functions.inc.php";
include_once "../../../lib/execQuery.class.php";
include_once "../../../lib/toHtml.class.php";
include_once "../../../lib/commonSearch.php";
include_once "../../../config.class.php";
include_once "mod_patschedule_select.class.php";
include_once "../includes/functions.inc.php";

$section = (isset($_GET["section"]) && !empty($_GET["section"])) ? $_GET["section"] : "";

switch($section){
	
	case "patList":
		
		$term = (isset($_GET["term"]) && !empty($_GET["term"])) ? "%".utf8_decode($_GET["term"])."%" : "";
		$query = commonSearch::getPatients();
		$params = array($term);
		$types = "s";
		$response = array();
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		
		foreach($result as $data){
			list($patid, $patcomplete) = explode(__SEPARATOR, $data);
		
			$response[] = array("id" => utf8_encode($patid),
								"value" => utf8_encode($patcomplete),
								"label" => utf8_encode($patcomplete));
		}
		
		echo json_encode($response);
		
		
		break;
		
	case "drtrt" :
		
		$trtindex = (isset($_GET["trtindex"]) && !empty($_GET["trtindex"])) ? $_GET["trtindex"] : "";
		$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
		$spc = (isset($_GET["spc"]) && !empty($_GET["spc"])) ? $_GET["spc"] : "0";
		
		$query = commonSearch::getTreatmentsBySpc();
		$params = array($spc);
		$types = "i";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		$resultToHtml = new toHtml($result);
		$trtSelect = $resultToHtml->toSelect("trt", "", "", "name='trt'", $trtindex, true);
	
		echo $trtSelect;
		
		break;
	
	case "drTurno" : 
		
		$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
		$hora = (isset($_GET["hora"]) && !empty($_GET["hora"])) ? str_pad($_GET["hora"],5,"0",STR_PAD_RIGHT) : "00:00";
		$dia = (isset($_GET["dia"]) && !empty($_GET["dia"])) ? $_GET["dia"] : "0";
		$chair = (isset($_GET["chair"]) && !empty($_GET["chair"])) ? $_GET["chair"] : "0";
		$fecha = (isset($_GET["fecha"]) && !empty($_GET["fecha"])) ? $_GET["fecha"] : "0000-00-00";
		$horaDoctor = array();
		$jsonArray = array();
		$check = array();
		
		$query = mod_patschedule_select::drEnTurno();
		$params = array($cli, $chair, $dia);
		$types = "iis";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		
		foreach($result as $rData){
			
			list($emp_id, $emp_complete, $emp_abbr, $ssch_date_ini, 
				 $ssch_date_end, $ssch_ini, $ssch_end,
				 $quincenal, $quincenal_date_ini, $inactive, $spc_id) = explode(__SEPARATOR, $rData);
			
			list($horai, $mini, $seci) = explode(":", $ssch_ini);
			list($horaf, $minf, $secf) = explode(":", $ssch_end);
			$hi = array("hora" => $horai, "min" => $mini);
			$hf = array("hora" => $horaf, "min" => $minf);
			
			
			$horaDoctor = horarioSeleccionado($hi, $hf, $hi, 15);

			if(in_array($hora, $horaDoctor)){
					if($ssch_date_ini != "0000-00-00"){
						
						$k = 0;
						$existe = false;
						
						###########################################################################
						#### Buscamos que la fecha dada este entre el rango de fechas del periodo
						###########################################################################
						
						
						while($fechaTope != $fecha){
							
							list($iyear, $imonth, $iday) = explode("-", $ssch_date_ini);
							$fechaTope = date("Y-m-d", mktime(0, 0, 0, $imonth, $iday+$k, $iyear));	
							++$k;
							if($fechaTope == $fecha){
								$existe = true;
							}
							if($fechaTope == $ssch_date_end){
								break;
							}
							
						}
						
						if($existe){
							
							$jsonArray = array("emp_id" => $emp_id,
												 "emp_complete" => ucwords(lowercase($emp_complete,true)),
												 "emp_abbr" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr."</span>",
												 "spc_id" => $spc_id
												 );
							

						}
						
					}
					else{
		
						###############################################
						#### Verificamos si el horaro es quincenal ####
						###############################################
						if($quincenal == 1){
							
							$showQuin = restaFechas($quincenal_date_ini, $fecha);
							if($showQuin%14 == 0){
								
									$jsonArray = array("emp_id" => $emp_id,
								            	         "emp_complete" => ucwords(lowercase($emp_complete,true)),
												 		 "emp_abbr" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr."</span>",
														 "spc_id" => $spc_id
														 );
							}
							
						}
						
					   ######################
					   ### Horario Normal ###
					   ######################
					   
						else{
							
							$jsonArray = array("emp_id" => $emp_id,
												 "emp_complete" => ucwords(lowercase($emp_complete,true)),
												 "emp_abbr" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr."</span>",
												 "spc_id" => $spc_id
												 );	
						}
	
					}
			}
		
		}
		
		echo json_encode($jsonArray);
		
		break;
	case "spcdr" :
		
		$dr = (isset($_GET["dr"]) && !empty($_GET["dr"])) ? $_GET["dr"] : "0";
		$query = mod_patschedule_select::spcPorDoctor();
		$params = array($dr);
		$types = "i";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->execute(ARRAY_ASSOC);
		
		$spc = preg_replace('/[^0-9]/', '', $result[0]["spc_id"]);
		
		if($spc == ""){
			$spc = 2;
		}
		
		echo $spc;
		
		break;
	
}
	
?>