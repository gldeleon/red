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

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";

	/** Obtiene un objeto de conexion con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
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
		var today = "<?=date("Y-m-d"); ?>";
		var now = "<?=date("H:i:s"); ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/createPatient.js"></script>
</head>
<body>

<div id="cfg" style="display: none"><?=$uid; ?></div>
<div id="resFilter" style="top: 0px; left: 0px; overflow-x: hidden; overflow-y: scroll"></div>
<table width="450" border="0" cellspacing="0" cellpadding="0" align="right" style="margin-top: 20px;">
<tr>
	<td width="130" class="newEditItem">Apellido Paterno:</td>
	<td align="left"><input name="lastname" type="text" id="lastname" size="50" /></td>
</tr>
<tr>
	<td class="newEditItem">Apellido Materno:</td>
	<td align="left"><input type="text" name="surename" id="surename" /></td>
</tr>
<tr>
	<td class="newEditItem">Nombre(s):</td>
	<td align="left"><input type="text" name="name" id="name" /></td>
</tr>
<tr>
	<td class="newEditItem">Tel&eacute;fono(s):</td>
	<td align="left">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><input name="telnum" type="text" id="telnum" style="width: 86px; line-height: 16px; height: 18px !important;" /></td>
		<td><select name="teltype" id="teltype" style="width: 55px; margin-left: 5px">
			<option value="0">Tipo --</option>
			<?php
				$query = "select tlt_name, tlt_abbr from {$DBName}.teltype order by tlt_id";
				if($result = @mysql_query($query, $link)) {
					while($row = @mysql_fetch_row($result)) {
						echo "<option value=\"{$row[1]}\">{$row[0]}</option>";
					}
					@mysql_free_result($result);
				}
			?></select></td>
		<td><input type="button" value="Agregar" style="margin-left: 5px; height: 18px;" onclick="addToList('telList', 'telnum', 'teltype')" title="Agregar" /></td>
		<td><input type="button" value="Quitar" style="margin-left: 5px; height: 18px;" onclick="removeFromList('telList')" title="Quitar" /></td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td class="newEditItem">&nbsp;</td>
	<td align="left"><select name="telList" size="3" id="telList"></select></td>
</tr>
<tr>
	<td class="newEditItem">Correo electr&oacute;nico:</td>
	<td align="left"><input type="text" name="email" id="email" /></td>
</tr>
<tr>
	<td height="10" colspan="2"><hr /></td>
</tr>
<tr>
	<td class="newEditItem">¿C&oacute;mo se enter&oacute;?:</td>
	<td align="left"><select name="meetform" id="meetform">
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
</table>

</body>
</html>