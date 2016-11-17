<?php
include_once "ttdTreat.class.php";

$tipo = (isset($_GET["tipo"]) && !empty($_GET["tipo"])) ? $_GET["tipo"] : "ADL";

$ttdTreat = new ttdTreat();

$result = $ttdTreat->getTooth($tipo);

echo $result;

?>
