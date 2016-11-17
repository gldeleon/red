<?php
include_once "../../lib/execQuery.class.php";
include_once "../../lib/toHtml.class.php";
include_once "../../lib/commonSearch.php";
include_once '../../config.class.php';

$query = commonSearch::selectClinicClass();
$execQuery = new execQuery($query);
$data = $execQuery->getQueryResults();
$list = new toHtml($data);
$cliClassSelect = $list->toSelect("cliclass");

$query = commonSearch::getStates();
$execQuery = new execQuery($query);
$data = $execQuery->getQueryResults();
$list = new toHtml($data);
$stateSelect = $list->toSelect("states");

$query = commonSearch::selectClinicClass();
$execQuery = new execQuery($query);
$data = $execQuery->getQueryResults();
$list = new toHtml($data);
$cliClassSelectEdit = $list->toSelect("cliclassEdit");

$query = commonSearch::getStates();
$execQuery = new execQuery($query);
$data = $execQuery->getQueryResults();
$list = new toHtml($data);
$stateSelectEdit = $list->toSelect("statesEdit");

?>