<?php
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $cli;
	$UPD = (isset($_GET["UPD"]) && !empty($_GET["UPD"])) ? $_GET["UPD"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	$esp = (isset($_GET["esp"]) && !empty($_GET["esp"])) ? $_GET["esp"] : "1";
	$bud = (isset($_GET["bud"]) && !empty($_GET["bud"])) ? $_GET["bud"] : "0";
	$agr = (isset($_GET["agr"]) && !empty($_GET["agr"])) ? $_GET["agr"] : "0";
	$string = "cli={$cli}&UPD={$UPD}&pat={$pat}&esp={$esp}&bud={$bud}&agr={$agr}";

	header("Location: ../modules/mod_budget/changeBudget.php?".$string);
?>