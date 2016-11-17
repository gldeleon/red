<?php

include_once '../../../config.class.php';
include_once 'mod_spcschedule_insert.class.php';
include_once 'mod_spcschedule_select.class.php';
include_once "../../../lib/execQuery.class.php";
include_once "../../../lib/functions.inc.php";

$section  = (isset($_POST["section"]) && !empty($_POST["section"])) ? $_POST["section"] : "0";

switch($section){
    
    case "save":
        
        $start = (isset($_POST["start"]) && !empty($_POST["start"])) ? $_POST["start"] : "00:00:00";
        $end = (isset($_POST["end"]) && !empty($_POST["end"])) ? $_POST["end"] : "00:00:00";
        $cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
        $spc = (isset($_POST["spc"]) && !empty($_POST["spc"])) ? $_POST["spc"] : "0";
        $dr = (isset($_POST["dr"]) && !empty($_POST["dr"])) ? $_POST["dr"] : "0";
        $usr = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : "0";
        $color = (isset($_POST["color"]) && !empty($_POST["color"])) ? $_POST["color"] : "0";
        $date_ini = (isset($_POST["date_ini"]) && !empty($_POST["date_ini"])) ? $_POST["date_ini"] : "0000-00-00";
        $date_end = (isset($_POST["date_end"]) && !empty($_POST["date_end"])) ? $_POST["date_end"] : "0000-00-00";
        $sillon = (isset($_POST["sillon"]) && !empty($_POST["sillon"])) ? $_POST["sillon"] : "0";
        $inactive = (isset($_POST["inactive"]) && !empty($_POST["inactive"])) ? $_POST["inactive"] : "0";
        $quincenal = (isset($_POST["quincenal"]) && !empty($_POST["quincenal"])) ? $_POST["quincenal"] : "0";
        $quincenal_date_ini = (isset($_POST["quincenal_date_ini"]) && !empty($_POST["quincenal_date_ini"])) ? $_POST["quincenal_date_ini"] : "0000-00-00";
        
        //Tue Aug 23 2011 13:15:00 GMT-0500
        $start = explode(" ", $start);
        $end = explode(" ", $end);
        
        $day = dayToNum($start[0]);
        
        $query = mod_spcschedule_select::selectSpcColor();
        $params = array($spc);
        $types = "i";
        $execQuery = new execQuery($query, $params, $types);
        $color = $execQuery->getQueryResults();
		list($color, $headerColor) = explode(__SEPARATOR, $color[0]);
        
        
        $query = mod_spcschedule_select::getEmpAbbr($dr);
        $execQuery = new execQuery($query);
        $result = $execQuery->getQueryResults();
        list($emp_abbr, $emp_complete) = explode(__SEPARATOR, $result[0]);
        
        $query = mod_spcschedule_insert::insertSchedule();
        $params = array($spc, $dr, $cli, $sillon, $day, $date_ini, $date_end, $start[4], $end[4], date("Y-m-d H:i:s"), $usr, $inactive, $quincenal, $quincenal_date_ini);
        $types = "iiiiisssssiiis";

        $execQuery = new execQuery($query, $params, $types);
        $response = $execQuery->insertData();
        $key = $execQuery->last_id;
        
        $result = array("response" => $response,
                        "key" => $key,
                        "color" => $color,
        				"dr" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;font-size:9px;'>".$emp_abbr."</span>",
        				"headerColor" => $headerColor);
        
        echo json_encode($result);
        
        break;
    
    case "edit":
        
        $start = (isset($_POST["start"]) && !empty($_POST["start"])) ? $_POST["start"] : "00:00:00";
        $end = (isset($_POST["end"]) && !empty($_POST["end"])) ? $_POST["end"] : "00:00:00";
        $cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
        $spc = (isset($_POST["spc"]) && !empty($_POST["spc"])) ? $_POST["spc"] : "0";
        $dr = (isset($_POST["dr"]) && !empty($_POST["dr"])) ? $_POST["dr"] : "0";
        $usr = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : "0";
        $id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : "0";
        $color = (isset($_POST["color"]) && !empty($_POST["color"])) ? $_POST["color"] : "0";
        $date_ini = (isset($_POST["date_ini"]) && !empty($_POST["date_ini"])) ? $_POST["date_ini"] : "0000-00-00";
        $date_end = (isset($_POST["date_end"]) && !empty($_POST["date_end"])) ? $_POST["date_end"] : "0000-00-00";
        $sillon = (isset($_POST["sillon"]) && !empty($_POST["sillon"])) ? $_POST["sillon"] : "0";
        $inactive = (isset($_POST["inactive"]) && !empty($_POST["inactive"])) ? $_POST["inactive"] : "0";
        $quincenal = (isset($_POST["quincenal"]) && !empty($_POST["quincenal"])) ? $_POST["quincenal"] : "0";
        $quincenal_date_ini = (isset($_POST["quincenal_date_ini"]) && !empty($_POST["quincenal_date_ini"])) ? $_POST["quincenal_date_ini"] : "0000-00-00";
        
        $query = mod_spcschedule_select::getEmpAbbr($dr);
        $execQuery = new execQuery($query);
        $result = $execQuery->getQueryResults();
        list($emp_abbr, $emp_complete) = explode(__SEPARATOR, $result[0]);
        
        
        $query = mod_spcschedule_insert::insertScheduleHist($section);
        $params = array($id);
        $types = "i";
        
        $execQuery = new execQuery($query, $params, $types);
        $execQuery->insertData();
        
        //Tue Aug 23 2011 13:15:00 GMT-0500
        $start = explode(" ", $start);
        $end = explode(" ", $end);
        
        $day = dayToNum($start[0]);
        
        $query = mod_spcschedule_select::selectSpcColor();
        $params = array($spc);
        $types = "i";
        $execQuery = new execQuery($query, $params, $types);
        $color = $execQuery->getQueryResults();
        list($color, $headerColor) = explode(__SEPARATOR, $color[0]);
        
        $query = mod_spcschedule_insert::updateSchedule();
        $params = array($spc, $dr, $cli, $sillon, $day, $date_ini, $date_end, $start[4], $end[4], date("Y-m-d H:i:s"), $usr, $inactive, $quincenal, $quincenal_date_ini, $id);
        $types = "iiiiisssssiiisi";
       
        
        $execQuery = new execQuery($query, $params, $types);
        $response = $execQuery->updatetData();
        
        $result = array("response" => $response,
                        "color" => $color,
                        "affected_rows" => $execQuery->aRows,
        				"dr" => "<span title='".utf8_encode($emp_complete)."' style='color:#000000;'>".$emp_abbr."</span>",
        				"headerColor" => $headerColor);
        
        echo json_encode($result);

        break;
    
    case "delete":
        
        $id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : "0";
        
        $params = array($id);
        $types = "i";
        
        $query = mod_spcschedule_insert::insertScheduleHist($section);
        
        $execQuery = new execQuery($query, $params, $types);
        $execQuery->insertData();
        
        $query = mod_spcschedule_insert::deleteSchedule();
        
        
        $execQuery = new execQuery($query, $params, $types);
        $response = $execQuery->deletetData();
        
        $result = array("response" => $response,
                        "affected_rows" => $execQuery->aRows);
        
        echo json_encode($result);
        
        break;
        
}

?>
