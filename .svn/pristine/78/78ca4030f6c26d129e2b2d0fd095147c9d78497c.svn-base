<?php
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
	include "../functions.inc.php";

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

	/** Obtiene la marca de tiempo y fecha del primer y ultimo dias de la semana actual. */
	$baseDate = strtotime($firstYear."-".$firstMonth."-".$firstDate);
	$newDate = strtotime($lastYear."-".$lastMonth."-".$lastDate);
	$iniDate = date("Y-m-d", $baseDate);
	$endDate = date("Y-m-d", $newDate);

	/** Establece el primer dia del mes sin ceros. */
	$d = $firstDate;
	$tdY = ($lastMonth < $firstMonth) ? ($lastYear) : ($firstYear);

	/** Obtiene un objeto de conexion con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$clisch = array();
	$query = "select csc_day, csc_ini, csc_end from {$DBName}.clinicsch
	where cli_id = {$cli} and csc_date <= '{$endDate}'
	order by csc_date desc, csc_day limit 7";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			$clisch[$row[0]] = array(intval($row[1]), intval($row[2]) - 1);
		}
		@mysql_free_result($result);
	}

	$spaces = "1";
	$query = "select cli_chairs from {$DBName}.clinic where cli_id = {$cli}";
	if($result = @mysql_query($query, $link)) {
		$spaces = @mysql_result($result, 0);
		$spaces = is_null($spaces) ? "1" : $spaces;
		@mysql_free_result($result);
	}

	$oldvisit = "";
	$query = "select vst_id from {$DBName}.visit
	where vst_date < curdate() and vta_id in (1,8)";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			$oldvisit .= $row[0].",";
		}
		@mysql_free_result($result);
	}
	$oldvisit = @substr($oldvisit, 0, -1);

	/** Marca las visitas como no asistidas; solo aquellas marcadas como canceladas o confirmadas, no las asistidas. */
	$backup = "insert into ".$DBName.".visithist (select null, vst.* from ".$DBName.".visit vst
	where vst.vst_id in (".$oldvisit."))";
	@mysql_query($backup, $link);

	$query = "update {$DBName}.visit set vta_id = 6, usr_id = 1 where vst_id in (".$oldvisit.")";
	@mysql_query($query, $link);

	$patcomp = "";
	if($pat != "") {
		$query = "select pat_complete from {$DBName}.patient where pat_id = '".utf8_decode($pat)."'";
		if($result = @mysql_query($query, $link)) {
			$patcomp = strtoupper(utf8_encode(@mysql_result($result, 0)));
			@mysql_free_result($result);
		}
	}

	$vtav = array("0");
	$vtak = array("0");
	$query = "select vta_name, vta_color from {$DBName}.visitstatus order by vta_id";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			array_push($vtak, $row[0]);
			array_push($vtav, $row[1]);
		}
		@mysql_free_result($result);
	}
	$vta = array_combine($vtak, $vtav);

	/** Obtiene los permisos GLOBALES del usuario. */
	$admin = intval($p{2});
	$write = intval($p{1});
	$reead = intval($p{0});
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
	<link href="../red.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$cli; ?>";
		var spaces = "<?=$spaces; ?>";
		var iniDate = "<?=$iniDate; ?>";
		var endDate = "<?=$endDate; ?>";
		var fechas = new Array(<?php
			$fArray = "";
			for($i = 0; $i <= 6; $i++) {
				$baseDate = mktime(0, 0, 0, $firstMonth, $firstDate + $i, $firstYear);
				$iniDate = date("Y-m-d", $baseDate);
				$fArray .= "\"".$iniDate."\", ";
			}
			$fArray = substr($fArray, 0, -2);
			echo $fArray;
		?>);
		var vstStatus = new Array();
		<?php
			foreach($vta as $key => $value) {
				echo "vstStatus['".$value."'] = '".$key."';\n";
			}
		?>
		var vstColor = new Array();
		<?php
			foreach($vta as $key => $value) {
				echo "vstColor['".$key."'] = '".$value."';\n";
			}
		?>
		var today = "<?=date("Y-m-d"); ?>";
		var pat = "<?=$pat; ?>";
		var visitLength = 0;
		var visitMaxLength = 0;
		var now = "<?=date("H:i:s"); ?>";
		var showDate = "<?=$showDate; ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/newPatientDialog.js"></script>
	<script type="text/javascript" src="../modules/fCalendar.js"></script>
	<script type="text/javascript" src="../modules/jquery/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="../modules/jquery/jquery-ui-1.8.11.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../modules/jquery/themes/ui-lightness/jquery.ui.all.css" />
	<script type="text/javascript">
		$(function() {
			function log(message) {
				$( "#patid" ).val( message );
			}
			$("#patient").autocomplete({
				source: "patSearch.php",
				minLength: 2,
				select: function( event, ui ) {
					log( ui.item ? ui.item.id : "" );
				}
			});
		});
	</script>
	<style>
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 200px;
	}
	</style>
</head>
<body>

<div id="cfg" style="display: none"><?=$uid; ?></div>
<div id="resFilter" style="top: 0px; left: 0px; overflow-x: hidden; overflow-y: scroll"></div>
<div id="sessionPopupBoxContainer">
	<div id="sessionPopupBox"></div>
</div>
<div id="divHeader">
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="60" height="20" class="schedule_header"><img src="../images/spacer.gif" width="60" height="1" /></td>
		<?
			for($i = 0; $i < count($dias); $i++) {
				$td = (date("d-m-Y", mktime(0, 0, 0, $firstMonth, $d, $firstYear)) == date("d-m-Y")) ? "schedule_header_today" : "schedule_header";
				echo "<td id=\"[".($i + 0)."][0]\" height=\"20\" class=\"".$td."\">".mb_convert_case($dias[$i], MB_CASE_TITLE, 'utf-8')." ".date("j", mktime(0, 0, 0, $firstMonth, $d++, $tdY))."</td>\n";
			}
		?>
	</tr>
	</table>
</div>

<table id="vstSchedule" border="0" cellspacing="0" cellpadding="0" style="visibility: hidden">
<tr>
	<td colspan="8"><img src="../images/spacer.gif" width="1" height="20" /></td>
</tr>
<?
	for($i = 0; $i < 25; $i++) {
		echo "<tr>";
		for($j = 0; $j < 8; $j++) {
			$cellDate = date("Y-m-d", mktime(0, 0, 0, $firstMonth, $firstDate + $j - 1, $firstYear));
			$cellHour = ($i - 1)."-".(($i - 1) + 1);
			if(count($clisch) > 0) {
				$class = ($j == 0 && $i >= 1) ? ("schedule_header") : ((($i - 1) >= $clisch[$j - 1][0]
				&& ($i - 1) <= $clisch[$j - 1][1] && $j > 0) ? ("schedule_avail") :("schedule_session"));
			}
			else {
				$class = ($j == 0 && $i >= 1) ? "schedule_header" : "schedule_session";
			}
//			if($class === "schedule_session" && $i >=6)
			echo "\n<td width=\"60\" height=\"40\" chour=\"{$cellHour}\" cdate=\"{$cellDate}\" id=\"[{$j}][{$i}]\" ondblclick=\"cellOptions(event)\" onkeyup=\"\" class=\"{$class}\" style=\"width: 60px; height: 40px;\" title=\"\" nowrap=\"nowrap\">&nbsp;</td>";
		}
		echo "\n</tr>\n";
	}
?>
<tr>
	<td colspan="8"><img src="../images/spacer.gif" width="1" height="60" /></td>
</tr>
</table>

<div id="mnuItemList" style="position: absolute; left: 0px; top: 0px; width: 120px; z-index: 9000;"></div>
<?php
	include "newPatient.inc.php";
	include "newEditWindow.inc.php";
?>

</body>
</html>