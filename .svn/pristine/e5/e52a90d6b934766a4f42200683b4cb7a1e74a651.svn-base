<?
	if(!$_SERVER['HTTP_REFERER']) {
		exit();
	}
	include "../config.inc.php";

	$dd = 1;
	$selMonth = date("n");
	$selYear = date("Y");
	$source = "";
	$parent = "";
	$profile = 1;
	if(isset($_GET)) extract($_GET);
	if(isset($showdate) && !empty($showdate)) {
		list($foo, $selMonth, $selYear) = explode("/", $showdate);
	}
	$mm = intval($selMonth);
	$yyyy = intval($selYear);
	$arrY = array();
	for($ii = 0; $ii <= 4; $ii++) {
		$arrY[$ii] = $yyyy - 2 + $ii;
	}

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$AppTitle; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../red.css" />
	<script type="text/javascript">
	/* [CDATA[ */
		var wParent = "<?=$parent; ?>";
		var oLastCell;
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/mCalendar.js"></script>
</head>
<body>

<form action="mCalendar.php" method="get" name="mcalendar" id="mcalendar">
<input type="hidden" name="parent" value="<?=$parent; ?>" />
<input type="hidden" name="source" value="<?=$source; ?>" />
<input type="hidden" name="profile" value="<?=$profile; ?>" />

<center>
<table cellspacing="1" cellpadding="0" border="0">
<tr>
	<td><input name="hoy" type="button" class="todayBtn" id="<?="d".date("d_m_Y"); ?>" value="Hoy" onclick="choiceDate(this, oLastCell, true, '<?=$profile; ?>')" /></td>
	<td>
	<select id="selMonth" name="selMonth" onchange="changeCal('<?=$profile; ?>')">
	<?
		for($i = 0; $i < count($meses); $i++) {
			$selected = ($i == $mm - 1) ? " selected=\"selected\"" : "";
			echo "<option value=\"".($i + 1)."\"".$selected.">".strtoupper($meses[$i])."</option>\n";
		}
	?>
	</select>
	</td>
	<td>
	<select id="selYear" name="selYear" onchange="changeCal('<?=$profile; ?>')">
	<?
		for($i = 0; $i < count($arrY); $i++) {
			$selected = ($arrY[$i] == $yyyy) ? " selected=\"selected\"" : "";
			echo "<option value=\"".$arrY[$i]."\"".$selected.">".$arrY[$i]."</option>\n";
		}
	?>
	</select>
	</td>
</tr>
</table>
<?
	$currentMonth = $mm;
	$previousMonth = $currentMonth - 1;
	$nextMonth = $currentMonth + 1;

	$maxDaysPrevMonth = date("t", mktime(0, 0, 0, $previousMonth, 1, $yyyy));
	$maxDaysCurrMonth = date("t", mktime(0, 0, 0, $currentMonth, 1, $yyyy));
	$maxDaysNextMonth = date("t", mktime(0, 0, 0, $nextMonth, 1, $yyyy));

	$firstWeekDayPrevMonth = date("w", mktime(0, 0, 0, $previousMonth, 1, $yyyy));
	$firstWeekDayCurrMonth = date("w", mktime(0, 0, 0, $currentMonth, 1, $yyyy));
	$firstWeekDayNextMonth = date("w", mktime(0, 0, 0, $nextMonth, 1, $yyyy));

	$lastWeekDayPrevMonth = date("w", mktime(0, 0, 0, $previousMonth, $maxDaysPrevMonth - 0, $yyyy));
	$lastWeekDayCurrMonth = date("w", mktime(0, 0, 0, $currentMonth, $maxDaysCurrMonth, $yyyy));
?>
<table id="calendarTable" cellspacing="1" cellpadding="0" border="0">
<tr>
	<td colspan="7" class="nommes"><?=strtoupper($meses[$currentMonth - 1]); ?></td>
</tr>
<tr>
    <td class="nomdia">D</td>
	<td class="nomdia">L</td>
	<td class="nomdia">M</td>
	<td class="nomdia">M</td>
	<td class="nomdia">J</td>
	<td class="nomdia">V</td>
	<td class="nomdia">S</td>
</tr>
<?
	$m = $previousMonth;
	if(($firstWeekDayCurrMonth == 0) || ($lastWeekDayPrevMonth == 6)) {
		$dayNumber = 1;
		$m = $currentMonth;
	}
	else
		$dayNumber = $maxDaysPrevMonth - ($lastWeekDayPrevMonth + 0);
	for($i = 1; $i < 7; $i++) {
		if($m == $nextMonth)
			break;
?>
<tr>
<?
		for($j = 0; $j < 7; $j++) {
			if(($m == date("n")) && ($dayNumber == date("j")) && ($yyyy == date("Y")))
				$class = "diahoy";
			elseif(($m == $previousMonth) || ($m == $nextMonth))
				$class = "noenmesactual";
			else
				$class = "diadelmes";
?>
	<td id="<?="d".date("d_m_Y", mktime(0,0,0, $m, $dayNumber, $yyyy)); ?>" class="<?=$class; ?>" onclick="oLastCell = choiceDate(this, oLastCell, false, '<?=$profile; ?>')"><?=$dayNumber; ?></td>
<?
			if(($dayNumber == $maxDaysPrevMonth) && ($m == $previousMonth)) {
				$dayNumber = 1;
				$m = $currentMonth;
			}
			elseif(($dayNumber == $maxDaysCurrMonth) && ($m == $currentMonth)) {
				$dayNumber = 1;
				$m = $nextMonth;
			}
			else
				$dayNumber++;
		}
?>
</tr>
<?
	}
?>
</table>
<?
	$currentMonth = ($mm + 1) > 12 ? 1 : ($mm + 1);
	$yyyy = ($mm + 1) > 12 ? $yyyy + 1 : $yyyy;
	$previousMonth = $currentMonth - 1;
	$nextMonth = $currentMonth + 1;
	$maxDaysPrevMonth = date("t", mktime(0, 0, 0, $previousMonth, 1, $yyyy));
	$maxDaysCurrMonth = date("t", mktime(0, 0, 0, $currentMonth, 1, $yyyy));
	$maxDaysNextMonth = date("t", mktime(0, 0, 0, $nextMonth, 1, $yyyy));
	$firstWeekDayPrevMonth = date("w", mktime(0, 0, 0, $previousMonth, 1, $yyyy));
	$firstWeekDayCurrMonth = date("w", mktime(0, 0, 0, $currentMonth, 1, $yyyy));
	$firstWeekDayNextMonth = date("w", mktime(0, 0, 0, $nextMonth, 1, $yyyy));
	$lastWeekDayPrevMonth = date("w", mktime(0, 0, 0, $previousMonth, $maxDaysPrevMonth - 0, $yyyy));
	$lastWeekDayCurrMonth = date("w", mktime(0, 0, 0, $currentMonth, $maxDaysCurrMonth, $yyyy));
?>
<table id="calendarTable2" cellspacing="1" cellpadding="0" border="0">
<tr>
	<td colspan="7" class="nommes"><?=strtoupper($meses[$currentMonth - 1]); ?></td>
</tr>
<tr>
    <td class="nomdia">D</td>
	<td class="nomdia">L</td>
	<td class="nomdia">M</td>
	<td class="nomdia">M</td>
	<td class="nomdia">J</td>
	<td class="nomdia">V</td>
	<td class="nomdia">S</td>
</tr>
<?
	$m = $previousMonth;
	if(($firstWeekDayCurrMonth == 0) || ($lastWeekDayPrevMonth == 6)) {
		$dayNumber = 1;
		$m = $currentMonth;
	}
	else
		$dayNumber = $maxDaysPrevMonth - ($lastWeekDayPrevMonth + 0);
	for($i = 1; $i < 7; $i++) {
		if($m == $nextMonth)
			break;
?>
<tr>
<?
		for($j = 0; $j < 7; $j++) {
			if(($m == date("n")) && ($dayNumber == date("j")) && ($yyyy == date("Y")))
				$class = "diahoy";
			elseif(($m == $previousMonth) || ($m == $nextMonth))
				$class = "noenmesactual";
			else
				$class = "diadelmes";
?>
	<td id="<?="d".date("d_m_Y", mktime(0,0,0, $m, $dayNumber, $yyyy)); ?>" class="<?=$class; ?>" onclick="oLastCell = choiceDate(this, oLastCell, false, '<?=$profile; ?>')"><?=$dayNumber; ?></td>
<?
			if(($dayNumber == $maxDaysPrevMonth) && ($m == $previousMonth)) {
				$dayNumber = 1;
				$m = $currentMonth;
			}
			elseif(($dayNumber == $maxDaysCurrMonth) && ($m == $currentMonth)) {
				$dayNumber = 1;
				$m = $nextMonth;
			}
			else
				$dayNumber++;
		}
?>
</tr>
<?
	}
?>
</table>
<?
	$currentMonth = ($mm + 2) > 12 ? ($mm + 2) - 12 : ($mm + 2);
	$yyyy = ($mm + 2) > 12 ? $yyyy + 1 : $yyyy;
	$yyyy = ($mm + 2) > 13 ? $yyyy - 1 : $yyyy;
	$currentMonth = $currentMonth > 12 ? $currentMonth - 12 : $currentMonth;
	$previousMonth = ($currentMonth != 0) ? ($currentMonth - 1) : 12;
	$nextMonth = ($currentMonth != 12) ? ($currentMonth + 1) : 0;
	$maxDaysPrevMonth = date("t", mktime(0, 0, 0, $previousMonth, 1, $yyyy));
	$maxDaysCurrMonth = date("t", mktime(0, 0, 0, $currentMonth, 1, $yyyy));
	$maxDaysNextMonth = date("t", mktime(0, 0, 0, $nextMonth, 1, $yyyy));
	$firstWeekDayPrevMonth = date("w", mktime(0, 0, 0, $previousMonth, 1, $yyyy));
	$firstWeekDayCurrMonth = date("w", mktime(0, 0, 0, $currentMonth, 1, $yyyy));
	$firstWeekDayNextMonth = date("w", mktime(0, 0, 0, $nextMonth, 1, $yyyy));
	$lastWeekDayPrevMonth = date("w", mktime(0, 0, 0, $previousMonth, $maxDaysPrevMonth - 0, $yyyy));
	$lastWeekDayCurrMonth = date("w", mktime(0, 0, 0, $currentMonth, $maxDaysCurrMonth, $yyyy));
?>
<table id="calendarTable2" cellspacing="1" cellpadding="0" border="0">
<tr>
	<td colspan="7" class="nommes" style="text-align: center"><?=strtoupper($meses[$currentMonth - 1]); ?></td>
</tr>
<tr>
	<td class="nomdia">D</td>
	<td class="nomdia">L</td>
	<td class="nomdia">M</td>
	<td class="nomdia">M</td>
	<td class="nomdia">J</td>
	<td class="nomdia">V</td>
	<td class="nomdia">S</td>
</tr>
<?
	$m = $previousMonth;
	if(($firstWeekDayCurrMonth == 0) || ($lastWeekDayPrevMonth == 6)) {
		$dayNumber = 1;
		$m = $currentMonth;
	}
	else
		$dayNumber = $maxDaysPrevMonth - ($lastWeekDayPrevMonth + 0);
	for($i = 1; $i < 7; $i++) {
		if($m == $nextMonth)
			break;
?>
<tr>
<?
		for($j = 0; $j < 7; $j++) {
			if(($m == date("n")) && ($dayNumber == date("j")) && ($yyyy == date("Y")))
				$class = "diahoy";
			elseif(($m == $previousMonth) || ($m == $nextMonth))
				$class = "noenmesactual";
			else
				$class = "diadelmes";
?>
	<td id="<?="d".date("d_m_Y", mktime(0,0,0, $m, $dayNumber, $yyyy)); ?>" class="<?=$class; ?>" onclick="oLastCell = choiceDate(this, oLastCell, false, '<?=$profile; ?>')"><?=$dayNumber; ?></td>
<?
			if(($dayNumber == $maxDaysPrevMonth) && ($m == $previousMonth)) {
				$dayNumber = 1;
				$m = $currentMonth;
			}
			elseif(($dayNumber == $maxDaysCurrMonth) && ($m == $currentMonth)) {
				$dayNumber = 1;
				$m = $nextMonth;
			}
			else
				$dayNumber++;
		}
?>
</tr>
<?
	}
?>
</table>
</center>
</form>

</body>
</html>