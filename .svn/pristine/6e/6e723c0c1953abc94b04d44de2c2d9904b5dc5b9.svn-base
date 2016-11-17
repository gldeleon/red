<?php
include_once "../../lib/definitions.inc.php";
include_once "includes/functions.inc.php";
include_once "../../lib/commonSearch.php";
include_once "../../lib/execQuery.class.php";
include_once "../../lib/toHtml.class.php";
include_once "../../config.class.php";
include_once "classes/mod_patschedule_select.class.php";

$index = (isset($index)) ? $index : "";

##################################################################
## Lista de Especialidades para buscar tratamientos en la agenda
##################################################################

$query = commonSearch::getSpecialities();
$execQuery = new execQuery($query);
$spcResult = $execQuery->getQueryResults();
$resultToHtml = new toHtml($spcResult);
$spcSelect = $resultToHtml->toSelect("spc", "", "onchange=\"getTrtDr(this.value, '')\"", "name='spc' disabled='disabled'");

##################################################################
## Lista de doctores que atienden en la clinica
##################################################################

$query = commonSearch::getDoctors(false);
$params = array($cli);
$types = "i";

$execQuery = new execQuery($query, $params, $types);
$drResult = $execQuery->getQueryResults();
$resultToHtml = new toHtml($drResult);
$drSelect = $resultToHtml->toSelect("dr", "", "onchange=\"spcPorDr(this.value)\"", "name='dr'", $index);

###########################################################################
## Lista de especialidades que se muestra arriba de la agenda con colores
###########################################################################

$query = mod_patschedule_select::selectSpecialities($cli);

$execQuery = new execQuery($query);
$result = $execQuery->getQueryResults();

$especialidades = "<ul id='spcList'>";

foreach($result as $data){
	
	list($spc_id, $spc_name, $spc_color) = explode(__SEPARATOR, $data);

	$especialidades .= "<li>
							<div id='{$spc_id}' class='{$spc_color}' title='".utf8_encode($spc_name)."' style='background-color: {$spc_color}; width:17px; height: 17px; border: 1px #000000 solid; cursor: pointer' onmouseover='getSpcSch(this.id, this.className);' onmouseout='getFreeBusys();'></div>
						</li> ";
	
	
}

$especialidades .= "</ul>";

##########################################################################
## Lista de especialidades para hacer busquedas 
##########################################################################

$resultToHtml = new toHtml($result);
$spcSelect2 = $resultToHtml->toSelect("spc2");

##########################################################################
## Lista de clinicas para busquedas
##########################################################################

$query = commonSearch::getClinics();
$execQuery = new execQuery($query);
$result = $execQuery->getQueryResults();
$toHtml = new toHtml($result);
$cliSelect = $toHtml->toSelect("clinic");

$intHoras = hourInteval(array("hora" => "06", "min" => "00"), array("hora" => "23", "min" => "15"));


?>
