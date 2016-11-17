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
	include "../../config.inc.php";

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";

	/** Obtiene un objeto de conexion con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

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
	<link href="../../fCalendar.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$cli; ?>";
		var today = "<?=date("Y-m-d"); ?>";
		var now = "<?=date("H:i:s"); ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../../modules/ajax.js"></script>
	<script type="text/javascript" src="../jquery/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="../jquery/jquery-ui-1.8.11.custom.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../jquery/themes/redmond/jquery.ui.all.css"  />
	<script type="text/javascript" src="../../modules/createPatient.js"></script>
	<script type="text/javascript" src="js/mod_patschedule.js"></script>
	<script type="text/javascript" src="../../modules/help.js"></script>
</head>
<body>

<div id="cfg" style="display: none"><?=$uid; ?></div>
<div id="resFilter" style="top: 0px; left: 0px; overflow-x: hidden; overflow-y: scroll"></div>
<form>
	<table width="450" border="0" cellspacing="0" cellpadding="0" align="right">
	<tr>
		<td width="130" bgcolor="#FFFFFF" class="newEditItem">Apellido Paterno:</td>
		<td bgcolor="#FFFFFF" align="left"><input name="lastname" type="text" id="lastname" size="50" /></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">Apellido Materno:</td>
		<td bgcolor="#FFFFFF" align="left"><input type="text" name="surename" id="surename" /></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">Nombre(s):</td>
		<td bgcolor="#FFFFFF" align="left"><input type="text" name="name" id="name" /></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">Tel&eacute;fono(s):</td>
		<td bgcolor="#FFFFFF" align="left">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input name="telnum" type="text" id="telnum" size="15" /></td>
			<td><select name="teltype" id="teltype" style="font-size: 10px; height: 18px; width: 55px; margin-left: 5px">
				<option value="0">Tipo --</option>
				<?php
					$query = "select tlt_name, tlt_abbr from ".$DBName.".teltype order by tlt_id";
					if($result = @mysql_query($query, $link)) {
						while($row = @mysql_fetch_row($result)) {
							echo "<option value=\"".$row[1]."\">".$row[0]."</option>";
						}
						@mysql_free_result($result);
					}
				?></select></td>
			<td><input type="button" value="Agregar" style="margin-left: 5px" onclick="addToList('telList', 'telnum', 'teltype')" title="Agregar" /></td>
			<td><input type="button" value="Quitar" style="margin-left: 5px" onclick="removeFromList('telList')" title="Quitar" /></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">&nbsp;</td>
		<td bgcolor="#FFFFFF" align="left"><select name="telList" size="3" id="telList">
		</select></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">Correo electr&oacute;nico:</td>
		<td bgcolor="#FFFFFF" align="left"><input type="text" name="email" id="email" /></td>
	</tr>
	<tr>
		<td height="10" colspan="2" bgcolor="#FFFFFF"><hr /></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">¿C&oacute;mo se enter&oacute;?:</td>
		<td bgcolor="#FFFFFF" align="left"><select name="meetform" id="meetform">
		<option value="0">----</option>
		<?
			$query = "select pmu_id, pmu_name from {$DBName}.patmeetus order by pmu_id";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result)) {
					echo "<option value=\"".$row[0]."\">".utf8_encode($row[1])."</option>\n";
				}
			}
			@mysql_free_result($result);
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td height="10" colspan="2" bgcolor="#FFFFFF"><hr /></td>
	</tr>
	<!--<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">Recomendaci&oacute;n de:</td>
		<td bgcolor="#FFFFFF" align="left"><input name="recommendation" type="text" id="recommendation" autocomplete="off" onclick="this.select()" /></td>
		</tr>-->
	<tr>
		<td bgcolor="#FFFFFF" class="newEditItem">Convenio:</td>
		<td bgcolor="#FFFFFF" align="left">
		<select name="agreelist" onchange="verifyAxaAgr(this);" id="agreelist">
		<option value="0">----</option>
		<?php
			$query = "select agr_id, agr_name from {$DBName}.agreement
			where agl_id = 2 and agr_active = 1 order by agr_name";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_array($result)) {
					echo "<option value=\"{$row["agr_id"]}\">".utf8_encode($row["agr_name"])."</option>\n";
				}
			}
			@mysql_free_result($result);
		?>
		</select>
		</td>
	</tr>
	<tr id="polizaRow" style="visibility: hidden;">
		<td class="newEditItem">No. P&oacute;liza AXA:</td>
		<td align="left"><input id="poliza" name="poliza" type="text" value="" maxlength="8" size="10" /></td>
	</tr>
	</table>
</form>

</body>
</html>