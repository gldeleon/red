<?php

include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/functions.inc.php";
include_once "../../../lib/execQuery.class.php";
include_once '../../../config.class.php';
include_once 'mod_patschedule_select.class.php';
include_once 'mod_patschedule_insert.class.php';

$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "";
$start = (isset($_GET["startDate"]) && !empty($_GET["startDate"])) ? $_GET["startDate"] : "";
$events = array();
$extension = array("jpg", "png", "gif");
$flag = "";
list($yi, $mi, $di) = explode("-", $start);

$end_date = date("Y-m-d", mktime(0, 0, 0, $mi, $di+6, $yi));

$query = mod_patschedule_select::selectScheduleEvents();
$params = array($start, $end_date, $cli);
$types = "ssi";

$execQuery = new execQuery($query, $params, $types);
$result = $execQuery->getQueryResults();

foreach($result as $data){
	
	list($vst_id, $cli_id, $vta_color, 
		 $vta_name, $pat_id, $pat_complete, $cli_chair,
		 $emp_id, $emp_abbr, $emp_complete, $vst_date, $vst_ini, 
		 $vst_end, $vst_descr, $vst_hcolor, $trt, $spc, $vta, 
		 $tel, $trtName, $agr, $vst_place) = explode(__SEPARATOR, $data);
	
	if(strtotime($vst_date) < strtotime(date("Y-m-d"))){
	
		if($vta != 5){
			
			$query = mod_patschedule_insert::insertVstHist();
			$params = array($vst_id);
			$types = "i";
			$execQuery = new execQuery($query,$params,$types);
			$execQuery->execute(ARRAY_ASSOC);
			
			$query = mod_patschedule_insert::updateVstStatus();
			$execQuery = new execQuery($query,$params,$types);
			$execQuery->execute(ARRAY_ASSOC);
			
		}
		
	}
	
	list($year, $month, $day) = explode("-", $vst_date);
	$cli_chair = $cli_chair-1;
	$vst_day = date("D", mktime(0, 0, 0, $month, $day, $year));
	$date = date("M d Y", mktime(0, 0, 0, $month, $day, $year));
	
	$patron = '/\d+/';
	$existe = preg_match($patron, $tel);
	
	if($agr > 0){ 
		foreach($extension as $ext){
			$identImg = "../../../images/com_identifier/".$agr.".".$ext;
			if(file_exists($identImg)){
				$flag = "<img src='../../images/com_identifier/".$agr.".".$ext."'/>";
				break;				
			}else{
				$flag = "";
			}
		}
		
		
	}
	
	$tel = ($tel == "" || is_null($tel) || $existe <= 0) ? "No Disponible" : $tel;
	
	$events[] = array("id" => $vst_id, 
					  "cli" => $cli_id, 
					  "titulo" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr." ".$flag."</span>",
					  "color" => $vta_color, 
		 			  "status" => ucfirst(lowercase($vta_name, true)), 
		 			  "patid" => utf8_encode($pat_id), 
		 			  "patient" => ucwords(lowercase($pat_complete, true)), 
		 			  "userId" => (integer)$cli_chair,
		 			  "dr" => $emp_id, 
		 			  "start" => $vst_day." ".$date." ".$vst_ini, 
		 			  "end" => $vst_day." ".$date." ".$vst_end,
		 		      "obs" => $vst_descr,
					  "headerColor" => $vst_hcolor,
					  "trt" => $trt,
					  "spc" => $spc,
					  "vta" => $vta,
					  "tel" => $tel,
					  "drName" => ucwords(lowercase($emp_complete)),
					  "trtName" => ucwords(lowercase($trtName, true)),
					  "vst_place" => $vst_place
					  ); 
	$flag = "";
	
}

echo json_encode($events);

?>