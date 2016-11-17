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

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$q = (isset($_GET["q"]) && !empty($_GET["q"])) ? $_GET["q"] : "";
	$com = (isset($_GET["com"]) && !empty($_GET["com"])) ? $_GET["com"] : "0";
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $cli;
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
	<script type="text/javascript" src="../modules/companies.js"></script>
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
	    <td>Empresas</td>
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
		<?
			if($q != "" || $com != "0") {
				$i = 0;
				if($com == "0") {
					$query = "select c.com_id, c.com_name, a.agr_id, a.agr_name, a.atp_id, agr_ini, agr_end, count(p.pat_id)
					from {$DBName}.company as c left join {$DBName}.agreement as a on a.com_id = c.com_id
					left join {$DBName}.patient as p on p.agr_id = a.agr_id
					where c.com_name like '%".$q."%' and c.com_active = 1 and a.agr_active = 1
					group by c.com_id, a.agr_id order by c.com_name";
				}
				else if($com != "0") {
					$query = "select c.com_id, c.com_name, a.agr_id, a.agr_name, a.atp_id, agr_ini, agr_end, count(p.pat_id)
					from {$DBName}.company as c left join {$DBName}.agreement as a on a.com_id = c.com_id
					left join {$DBName}.patient as p on p.agr_id = a.agr_id
					where c.com_id = ".$com." and c.com_active = 1 and a.agr_active = 1
					group by c.com_id, a.agr_id order by c.com_name";
				}
				$result = @mysql_query($query, $link);
				if (@mysql_num_rows($result) <= 0) {
		?>
		<table width="80%" border="0" align="center">
		<tr>
			<td height="100" valign="bottom" style="font-weight: bold; color: #000">
			No se encontraron nombres de empresas relacionados con '<?=$q; ?>'.
			<p><a href="companies.php" target="_self">Ver la lista de empresas</a></p>
			</td>
		</tr>
		</table>
		<?php
				}
				else {
		?>
		<div id="sessHeader" style="position: fixed; left: 1px; width: 100%; z-index: 0;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right: 1px solid #8D9199; border-bottom: 1px solid #8D9199;">
		<tr style="height: 25px;">
			<td class="list_header" style="padding-left: 0px">Nombre de la Empresa</td>
			<td width="300" height="20" class="list_header" style="padding-left: 5px">Plan/Convenio</td>
			<td width="80" height="20" class="list_header"># pacientes</td>
			<td width="160" height="20" class="list_header" style="padding-left: 2px">Vigencia del Plan</td>
		</tr>
		</table>
		</div>

		<table id="sessTable" width="100%" border="0" cellspacing="0" cellpadding="0" style=" width: 100%; border-right: 1px solid #8D9199; border-bottom: 1px solid #8D9199">
		<tr style="height: 25px;">
			<td colspan="5">&nbsp;</td>
		</tr>
		<?php
					while($row = @mysql_fetch_row($result)) {
						$bgcolor = is_int($i / 2) ? "#FFF" : "#FFD773";
						$company = (strlen($row[1]) > 0) ? utf8_encode($row[1]) : "&nbsp;";
						$agrid = is_null($row[2]) ? "0" : $row[2];
						$agreement = (strlen($row[3]) > 0) ? utf8_encode($row[3]) : "&nbsp;";
						$agrinidate = is_null($row[5]) ? "--" : date("d/m/Y", strtotime($row[5]));
						$agrenddate = is_null($row[6]) ? "--" : date("d/m/Y", strtotime($row[6]));
		?>
		<tr  style="height: 20px; background-color: <?=$bgcolor; ?>">
			<td class="list_item" align="left" style="padding-left: 5px"><?=$company; ?></td>
			<td width="300" height="20" align="left" class="list_item" style="padding-left: 5px"><? if($agreement != "&nbsp;"){ ?><a href="getAgreement.php?agr=<?=$agrid; ?>&cli=<?=$cli; ?>"><? } ?><?=$agreement; ?><? if($agreement != "&nbsp;"){ ?></a><? } ?></td>
			<td width="80" height="20" class="list_item"><?=$row[7]; ?></td>
			<td width="80" height="20" align="center" class="list_item"><?=$agrinidate; ?></td>
			<td width="80" height="20" align="center" class="list_item"><?=$agrenddate; ?></td>
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
			En esta secci&oacute;n encontrar&aacute;s la lista de empresas con las que tenemos convenio; para
			saber si tenemos un convenio en espec&iacute;fico, ingresa el nombre de la empresa en el campo
			Buscar (arriba) y presiona Enter, o selecciona una opci&oacute;n de la siguiente lista:
			</td>
		</tr>
		<tr>
			<td height="40" valign="bottom">
			<select name="com" onchange="changeCompany(this)">
				<option value="0">----</option>
				<?php
					$query = "select c.com_id, c.com_name from {$DBName}.company as c
					where c.com_active = 1 order by c.com_name";
					if($result = @mysql_query($query, $link)) {
						while($row = @mysql_fetch_row($result)) {
							echo "<option value=\"".$row[0]."\">".utf8_encode($row[1])."</option>\n";
						}
						@mysql_free_result($result);
					}
				?>
			</select>
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
	<td class="wtbottom">&nbsp;</td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>
</form>

</body>
</html>