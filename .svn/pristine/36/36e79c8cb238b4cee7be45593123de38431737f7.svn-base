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

	/** Llama al archivo de configuracion. */
	include "../config.inc.php";
	include "patient.class.php";

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$q = (isset($_GET["q"]) && !empty($_GET["q"])) ? $_GET["q"] : "";
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $cli;
    $agrid = (isset($_GET["agr"]) && !empty($_GET["agr"])) ? $_GET["agr"] : "0";

	/** Obtiene un objeto de conexion con la base de datos. */
	$link = @mysql_pconnect($DBServer, $DBUser, $DBPaswd);

	$clc = "0";
	$query = "select clc_id from {$DBName}.clinic where cli_id = {$cli}";
	if($result = @mysql_query($query, $link)) {
		$clc = @mysql_result($result, 0);
		$clc = is_null($clc) ? "0" : $clc;
		@mysql_free_result($result);
	}
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
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/createMenu.js"></script>
	<script type="text/javascript" src="../modules/patients.js"></script>
	<script type="text/javascript" src="../modules/newPatientDialog.js"></script>
</head>
<body>

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="cfg" style="display: none"><?=$uid; ?></div>
<? include "newPatient.inc.php"; ?>
<form name="f" onsubmit="return false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
	    <td>Pacientes</td>
	    <td width="180" align="left"><input type="button" class="large" value="Nuevo paciente" onclick="showNewPatientDialog();" /></td>
	    <td width="50" align="right" style="font-size: 12px; font-weight: bold; color: #811E53">Buscar:</td>
        <td width="150" align="right"><input name="q" type="text" value="" onclick="this.select()" onkeyup="searchPatient(this, event)" style="width: 140px;" /></td>
    </tr>
    </table>
    </td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
	<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<?php
			if($q != "") {
				$i = 0;
				$q = utf8_decode($q);
				$query = "select p.pat_complete, a.agr_name, p.pat_id,
				max(s.ses_date) as ses_date, p.agr_id, a.agl_id
				from {$DBName}.patient as p
				left join {$DBName}.session as s on s.pat_id = p.pat_id
				left join {$DBName}.agreement as a on a.agr_id = p.agr_id
				where p.pat_complete like '%{$q}%'";
				if($cli != "1" && $clc != "1") {
					$query .= " and (clc_id = {$clc} or clc_id = 1)";
				}
				$query .= " group by p.pat_id order by p.pat_complete";
				$result = @mysql_query($query, $link);
				if(@mysql_num_rows($result) <= 0) {
		?>
		<table width="80%" border="0" align="center">
		<tr>
			<td height="100" valign="bottom" style="font-weight: bold; color: #000">
			No se encontraron nombres de pacientes relacionados con '<?=$q; ?>'.
			</td>
		</tr>
		</table>
		<?php
				}
				else {
		?>
		<div id="sessHeader" style="position: fixed; left: 1px; width: 100%; z-index: 0;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr style="height: 25px;">
			<td width="20" height="20" class="list_header">S</td>
			<td width="20" height="20" class="list_header">A</td>
			<td class="list_header">Nombre del Paciente</td>
			<td width="70" height="20" class="list_header">Saldo</td>
			<td width="300" height="20" class="list_header" style="padding-left: 5px">Plan/Convenio</td>
			<td width="100" height="20" class="list_header">&Uacute;ltima visita</td>
			<td width="100" height="20" class="list_header">Pr&oacute;x. Cita</td>
		</tr>
		</table>
		</div>

		<table id="sessTable" width="100%" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr style="height: 25px;">
			<td colspan="6">&nbsp;</td>
		</tr>
		<?php
					while($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
						$bgcolor = is_int($i / 2) ? "#FFF" : "#FFD773";
						$agreement = (strlen($row["agr_name"]) > 0) ? mb_convert_case($row["agr_name"], MB_CASE_UPPER, 'utf-8') : "&nbsp;";
						$agrid = is_null($row["agr_id"]) ? "0" : $row["agr_id"];
						$lastvisit = is_null($row["ses_date"]) ? "--" : date("d/m/Y", strtotime($row["ses_date"]));
						$agrclass = (!is_null($row["agr_id"]) && $row["agr_id"] != "0" && $row["agl_id"] != "2")  ? " style=\"color: #00AA33;\"" : ((!is_null($row["agl_id"]) && $row["agl_id"] == "2") ? " style=\"color: #FF6600;\"" : "");
						$patid = utf8_encode($row["pat_id"]);

						/** Obtiene la fecha de la proxima cita de este paciente. */
						$nextvisit = "--";
						$query4 = "select vst_date from {$DBName}.visit
						where pat_id = '{$row["pat_id"]}' and vst_date > curdate()
						order by vst_date asc limit 1";
						if($result4 = @mysql_query($query4, $link)) {
							if(@mysql_num_rows($result4) > 0) {
								$nextvisit = @mysql_result($result4, 0);
								$nextvisit = date("d/m/Y", strtotime($nextvisit));
							}
							@mysql_free_result($result4);
						}

						/** Obtiene el saldo del paciente. */
						$patClass = new Patient(utf8_decode($patid));
						$bal = $patClass->getPatientBalance();
						$patName = mb_convert_case($row["pat_complete"], MB_CASE_UPPER, 'utf-8');

						/** Es necesario eliminar el objeto para que los datos sean correctos. */
						unset($patClass);
						$balclass = ($bal < 0) ? " style=\"color: #CC0000;\"" : "";
		?>
		<tr style="height: 20px; background-color: <?=$bgcolor; ?>">
			<td width="20" height="20" class="list_item"><a href="javascript:void(0);" onclick="startNewSession('<?=$patid; ?>', '', '<?=$e; ?>');"><img src="../images/startsession.gif" alt="Iniciar sesi&oacute;n" title="Iniciar sesi&oacute;n" width="16" height="13" border="0" style="cursor: pointer" /></a></td>
			<td width="20" height="20" class="list_item"><a href="schedule.php?pat=<?=$patid; ?>&cli=<?=$cli; ?>" target="rightFrame"><img src="../images/calendar.png" alt="Agendar" title="Agendar" width="16" height="13" border="0" style="cursor: pointer" /></a></td>
			<td class="list_item" align="left" style="padding-left: 5px"><a href="getPatient.php?pat=<?=$patid; ?>&cli=<?=$cli; ?>&agr=<?=$agrid; ?>" target="mainFrame"<?=$agrclass; ?>><?=$patName; ?></a></td>
			<td width="70" height="20" align="center" class="list_item"><a href="getPatient.php?pat=<?=$patid; ?>&cli=<?=$cli; ?>&agr=<?=$agrid; ?>&org=5" target="mainFrame"<?=$balclass; ?>><?="$".number_format($bal, 0, ".", ","); ?></a></td>
			<td width="300" align="left" height="20" class="list_item" style="padding-left: 5px"><? if($agreement != "&nbsp;"){ ?><a href="getAgreement.php?agr=<?=$agrid; ?>&cli=<?=$cli; ?>"><? } ?><?=$agreement; ?><? if($agreement != "&nbsp;"){ ?></a><? } ?></td>
			<td width="100" height="20" align="center" class="list_item"><?=$lastvisit; ?></td>
			<td width="100" height="20" align="center" class="list_item"><?=$nextvisit; ?></td>
		</tr>
		<?
						$i++;
					}
		?>
		</table>
		<?
				}
			}
			else if($q == "") {
		?>
		<table width="80%" border="0" align="center">
		<tr>
			<td height="100" valign="bottom" style="font-weight: bold; color: #000">
			En esta secci&oacute;n encontrar&aacute;s la lista de pacientes, tanto tuyos como de las
			empresas con las que tenemos convenio. Para buscar el nombre de un paciente, ingresa su
			nombre en el campo Buscar (arriba) y presiona Enter.
			</td>
		</tr>
		</table>
		<?  } ?>
	</div>
	</td>
</tr>
<tr>
	<td colspan="3" class="addsubstr">&nbsp;</td>
</tr>
<tr>
	<td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom">Total de Pacientes: <?php
		$query = "select count(pat_id) from {$DBName}.patient";
		if($cli != "1" && $clc != "1") {
			$query .= " where (clc_id = {$clc} or clc_id = 1)";
		}
		if($result = @mysql_query($query, $link)) {
			echo $numpat = number_format(((intval(@mysql_result($result, 0)) > 0) ? intval(@mysql_result($result, 0)) : "0"), 0, ".", ",");
			@mysql_free_result($result);
		}
	?></td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>
</form>

</body>
</html>