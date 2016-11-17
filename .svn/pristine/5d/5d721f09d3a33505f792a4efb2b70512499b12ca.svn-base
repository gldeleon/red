<?php

include_once "../../lib/commonSearch.php";
include_once "../../lib/execQuery.class.php";
include_once "../../lib/toHtml.class.php";
include_once '../../config.class.php';

$query = commonSearch::getSpecialities();

$execQuery = new execQuery($query);
$spcResult = $execQuery->getQueryResults();
$resultToHtml = new toHtml($spcResult);
$spcSelect = $resultToHtml->toSelect("spc", "", "onchange=\"getDoctors(this.value)\"", "name='spc'");
$spcSelect2 = $resultToHtml->toSelect("spc2", "", "onchange=\"getDoctors2(this.value)\"", "name='spc2'");



?>
