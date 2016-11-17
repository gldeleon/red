<?php
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
		exit();
	session_name("pra8atuw");
	session_start();
	if(count($_SESSION) > 0)
		extract($_SESSION);
	else {
		$_SESSION = array();
		session_destroy();
		header("Location: logout.php");
	}

	include "../config.inc.php";
	include "../functions.inc.php";

	$url = (isset($_GET["url"]) && !empty($_GET["url"])) ? $_GET["url"] : "welcome";
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $cli;

	$qs = $_SERVER["QUERY_STRING"];
	$qs = explode("&", $qs);
	$string = "";
	if(count($qs) > 0) {
		$yis = array("url", "cli", "profile");
		$pos = array();
		foreach($qs as $item => $args) {
			$arg = explode("=", $args);
			if(in_array($arg[0], $yis)) {
				$pos[] = $item;
			}
		}
		foreach($pos as $item => $key) {
			$qs = array_key_extract($qs, $key);
		}
		if(count($qs) > 0) {
			$string = "&".implode("&", $qs);
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="../modules/content.js"></script>
	<title><?=$AppTitle; ?></title>
</head>

<frameset id="sessions" rows="*,190" cols="*" framespacing="0" frameborder="no" border="0">
	<frame src="<?=$url; ?>.php?cli=<?=$cli.$string; ?>" name="mainFrame" id="mainFrame" title="" />
	<frame src="sessions.php?cli=<?=$cli; ?>" name="bottomFrame" scrolling="no" noresize="noresize" id="bottomFrame" />
</frameset>

</html>