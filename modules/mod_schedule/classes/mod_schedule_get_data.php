<?php

include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/functions.inc.php";
include_once "../../../lib/execQuery.class.php";
include_once "../../../lib/toHtml.class.php";
include_once "../../../lib/commonSearch.php";
include_once '../../../config.class.php';

$section = (isset($_GET["section"]) && !empty($_GET["section"])) ? $_GET["section"] : "";

switch($section){
	
	case "empList":
		
		$emp = (isset($_GET["term"]) && !empty($_GET["term"])) ? "%".$_GET["term"]."%" : "";
		$query = commonSearch::selectEmployee();
		$params = array($emp);
		$types = "s";
		$response = array();
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		
		for($i=0; $i<count($result); $i++){
			list($empid, $empcomplete) = explode(__SEPARATOR, $result[$i]);
		
			$response[] = array("id" => $empid,
								"value" => $empcomplete,
								"label" => $empcomplete);
		}
		
		echo json_encode($response);
		
		
		break;

		
	
}
	
?>