<?php

include_once "../../../lib/commonSearch.php";
include_once "../../../lib/execQuery.class.php";
include_once "../../../lib/toHtml.class.php";
include_once '../../../config.class.php';

$query = commonSearch::getClinics();

$execQuery = new execQuery($query);
$cliResult = $execQuery->getQueryResults();
$resultToHtml = new toHtml($cliResult);
$cliSelect = $resultToHtml->toSelect("cli", "", "onclick=''", "name='cli' style='width:140px'");

echo $cliSelect;


?>