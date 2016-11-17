<?php

include_once "../../../lib/definitions.inc.php";
include_once '../../../config.class.php';
include_once "../../../lib/execQuery.class.php";
include_once "../../../lib/toHtml.class.php";
include_once "mod_schedule_select.php";

$active = (isset($_POST["active"]) && !empty($_POST["active"])) ? $_POST["active"] : "0";
$cli = (isset($_POST["clid"]) && !empty($_POST["clid"])) ? $_POST["clid"] : "0";
$section = (isset($_POST["section"]) && !empty($_POST["section"])) ? $_POST["section"] : "0";

switch($section){
	
	case "datosClinica":
		
		$query = mod_schedule_select::selectClinicInfo($active, $cli);
		$execQuery = new execQuery($query);
		$result = $execQuery->getQueryResults();
		$data = array();
		
		foreach($result as $val){
			
			list($cli_id, $cli_name, $cli_shortname, $clc_name, 
				  $cli_chairs, $cli_active, $stt_name,
				  $stt_id, $clc_id) = explode(__SEPARATOR, $val);
			
			$data = array("cli_id" => $cli_id, 
						  "cli_name" => utf8_encode($cli_name), 
						  "cli_shortname" => utf8_encode($cli_shortname), 
						  "clc_name" => $clc_name, 
						  "cli_chairs" => $cli_chairs, 
						  "cli_active" => $cli_active, 
						  "stt_name" => $stt_name, 
						  "stt_id" => $stt_id, 
						  "clc_id" => $clc_id);
			
			
		}
		
		echo json_encode($data);

		break;

	
}


?>
