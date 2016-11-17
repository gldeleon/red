<?
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1) {
		exit();
	}
	session_name("pra8atuw");
	session_start();
	if(count($_SESSION) > 0) {
		extract($_SESSION);
	}
	else {
		$_SESSION = array();
		session_destroy();
		header("Location: logout.php");
	}

	/** Llama al archivo de configuracion. */
	include "../config.inc.php";

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$showDate = (isset($_GET["showdate"]) && !empty($_GET["showdate"])) ? $_GET["showdate"] : (date("j")."/".date("n")."/".date("Y"));
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";

	$showDateArray = explode("/", $showDate);
	$actualWeek = strftime("%U", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0], $showDateArray[2])) + 1;
	$showDateWeekDay = date("w", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0], $showDateArray[2]));
	$firstMonth = date("n", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0] - $showDateWeekDay, $showDateArray[2]));
	$firstDate = date("j", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0] - $showDateWeekDay, $showDateArray[2]));
	$firstYear = date("Y", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0] - $showDateWeekDay, $showDateArray[2]));
	$lastDate = date("j", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0] + (6 - $showDateWeekDay), $showDateArray[2]));
	$lastMonth = date("n", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0] + (6 - $showDateWeekDay), $showDateArray[2]));
	$lastYear = date("Y", mktime(0, 0, 0, $showDateArray[1], $showDateArray[0] + (6 - $showDateWeekDay), $showDateArray[2]));

	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$clinom = "";
	$query = "select cli_name from {$DBName}.clinic
	where cli_id = {$cli}";
	if($result = @mysql_query($query, $link)) {
		$clinom = @mysql_result($result, 0);
		$clinom = utf8_encode($clinom);
	}
	if(empty($clinom)) {
		$clinom = "Sin cl&iacute;nica asignada";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
	<link href="../red.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$cli; ?>";
		var actualWeek = <?=$actualWeek; ?>;
		var firstDate = <?=$firstDate; ?>;
		var firstMonth = <?=$firstMonth; ?>;
		var firstYear = <?=$firstYear; ?>;
		var lastDate = <?=$lastDate; ?>;
		var lastMonth = <?=$lastMonth; ?>;
		var lastYear = <?=$lastYear; ?>;
		var showDate = "<?=$showDate; ?>";
		var pat = "<?=$pat; ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/createMenu.js"></script>
	<script type="text/javascript" src="../modules/schCalendar.js"></script>
</head>
<body>

<?php
	$monthString = $meses[(($firstMonth == $lastMonth) ? ($firstMonth) : ($firstMonth." - ".$lastMonth)) - 1];
	$monthString = ucfirst($monthString);
	$cellDate = date("Y-m-d");
	$cellHour = date("G")."-".(date("G") + 1);
	$cellId = "[".(date("w") + 0)."][".(date("G") - 0)."]";
?>
<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
	    <td>Agenda de la semana - <?=$monthString; ?> (<?=$clinom; ?>)</td>
	    <td width="180" align="left"><input type="button" id="<?=$cellId; ?>" class="large" value="Nueva cita" onclick="openNewVisitDialog(event);" /></td>
    </tr>
    </table>
    </td>
	<td class="outf1y2">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" valign="top" id="schedule_m">
	<iframe name="pFrame" id="pFrame" height="100%" frameborder="0" scrolling="yes" src="" style="overflow: hidden; overflow-y: scroll;"></iframe>
	</td>
</tr>
<tr>
	<td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom"><label id="week">&nbsp;</label></td>
	<td class="outf3y4"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>
<script type="text/javascript">
/* [CDATA[ */
	document.getElementById('<?=$cellId; ?>').setAttribute("cdate", '<?=$cellDate; ?>');
	document.getElementById('<?=$cellId; ?>').setAttribute("chour", '<?=$cellHour; ?>');
/* ]] */
</script>

</body>
</html>