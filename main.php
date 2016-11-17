<?php
	/** Si no existe una pagina anterior como referencia, no muestra nada. */
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
		exit();
	session_name("pra8atuw");
	session_start();
	if(count($_SESSION) > 0)
		extract($_SESSION);
	else {
		$_SESSION = array();
		session_destroy();
		header("Location: classes/logout.php");
	}

	include "config.inc.php";

	/** Obtiene los permisos GLOBALES del usuario. */
	$admin = intval($p{2});
	$write = intval($p{1});
	$reead = intval($p{0});

	$prefs = explode(":", $s);
	$cli = $prefs[0] ? intval($prefs[0]) : "0";
	$authcli = array();

	/** Obtiene un recurso de conexion con el servidor MySQL. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	/** Consulta para obtener una lista de clinicas autorizadas para el usuario. */
	$query = "select u.cli_id from {$DBName}.userclinic as u
	left join {$DBName}.clinic as c on c.cli_id = u.cli_id
	where u.usr_id = {$uid} and u.cli_id != '0'";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			@array_push($authcli, $row[0]);
		}
		@mysql_free_result($result);
	}

	/** Si la lista tiene uno o mas elementos, busca en esta la clinica preferida,
	de lo contrario, la variable $cli valdra cero. */
	if(count($authcli) > 0) {
		if(!in_array($cli, $authcli)) {
			$cli = $authcli[0];
		}
	}
	else {
		if ($admin != "1") {
			$cli = "0";
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
</head>

<frameset rows="*" cols="155,*" frameborder="no" border="0" framespacing="0">
	<frame src="classes/menu.php?cli=<?=$cli; ?>" name="leftFrame" scrolling="no" noresize="noresize" id="leftFrame" title="" />
	<frame src="classes/content.php?cli=<?=$cli; ?>" name="rightFrame" scrolling="no" noresize="noresize" id="rightFrame" title="" />
</frameset>

</html>