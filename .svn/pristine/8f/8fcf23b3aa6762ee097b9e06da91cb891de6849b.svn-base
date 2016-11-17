<?php

include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/functions.inc.php";
include_once "../../../lib/commonSearch.php";
include_once "../../../lib/execQuery.class.php";
include_once "../../../lib/toHtml.class.php";
include_once '../../../config.class.php';
include_once 'mod_spcschedule_select.class.php';

$spc = (isset($_POST["spc"]) && !empty($_POST["spc"])) ? $_POST["spc"] : "0";
$section = (isset($_POST["section"]) && !empty($_POST["section"])) ? $_POST["section"] : "0";
$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
$index = (isset($_POST["index"]) && !empty($_POST["index"])) ? $_POST["index"] : "0";

switch($section){
    
    case "spc":
        
        $query = commonSearch::getDoctors();
        $params = array($cli, $spc);
        $types = "ii";
        
        $execQuery = new execQuery($query, $params, $types);
        $drResult = $execQuery->getQueryResults();
        $resultToHtml = new toHtml($drResult);
        $drSelect = $resultToHtml->toSelect("dr", "", "", "name='dr'", $index, true);

        echo $drSelect;
        
        break;
    
    
    
}

?>
