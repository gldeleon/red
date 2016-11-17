<?php
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $cli;
	$UPD = (isset($_GET["UPD"]) && !empty($_GET["UPD"])) ? $_GET["UPD"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	$esp = (isset($_GET["esp"]) && !empty($_GET["esp"])) ? $_GET["esp"] : "1";
	$rec = (isset($_GET["rec"]) && !empty($_GET["rec"])) ? $_GET["rec"] : "--";
	$inv = (isset($_GET["inv"]) && !empty($_GET["inv"])) ? $_GET["inv"] : "0";
    $gto = (isset($_GET["gto"]) && !empty($_GET["gto"])) ? $_GET["gto"] : "0";
	$string = "cli={$cli}&UPD={$UPD}&pat={$pat}&esp={$esp}&rec={$rec}&inv={$inv}&gto={$gto}";

	header("Location: ../modules/mod_dchart/odontoGrama.php?".$string);
?>