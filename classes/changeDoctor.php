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

	/** Carga variables URL y determina sus valores iniciales. */
	$UPD = (isset($_GET["UPD"]) && !empty($_GET["UPD"])) ? $_GET["UPD"] : "";
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
	<!--[CDATA[
		var cli = "<?=$cli; ?>";
	//]]-->
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/createMenu.js"></script>
	<script type="text/javascript" src="../modules/changeDoctor.js"></script>
	<script type="text/javascript" src="../modules/newPatientDialog.js"></script>
</head>
<body>

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<?php include "newPatient.inc.php"; ?>
<form name="f" onsubmit="return false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">Empresas</td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
	<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<br />
		<table cellpadding="0" cellspacing="0" border="0" align="center" style="border: 1px solid #E6701D">
		<tr>
			<td class="list_header" width="20">&nbsp;</td>
			<td class="list_header" width="250">Nombre del Doctor</td>
			<td class="list_header" width="150">Especialidad</td>
		</tr>
		<?php
				if($UPD != "" && $cli != "0") {
					$query = "select ec.ecl_id, ec.cli_id, ec.emp_id, e.emp_complete, s.spc_name
					from {$DBName}.empclinic as ec
					left join {$DBName}.employee as e on e.emp_id = ec.emp_id
					left join {$DBName}.emppost as ep on ep.emp_id = e.emp_id and ep.emp_id = ec.emp_id
					left join {$DBName}.speciality as s on s.spc_id = ec.spc_id
					where ec.spc_id > 1 and ec.cli_id = ".$cli."
					and ep.pst_id in (25, 26, 27, 28, 29, 30, 31, 38, 41) and e.emp_active = 1
					order by e.emp_complete";
					if($result = @mysql_query($query, $link)) {
						$bgcolor = "#FFD773";
						while($row = @mysql_fetch_row($result)) {
							$bgcolor = ($bgcolor == "#FFF") ? "#FFD773" : "#FFF";
							echo "<tr bgcolor=\"".$bgcolor."\">";
							echo "<td class=\"list_item\" style=\"text-align: left; vertical-align: middle;\" height=\"23\"><input name=\"empid\" type=\"radio\" value=\"".$row[2]."\" /></td>";
							echo "<td class=\"list_item\" style=\"text-align: left; padding-left: 5px; cursor: pointer\" onclick=\"selectDoctor('".$row[2]."')\">".utf8_encode(ucwords(strtolower($row[3])))."</td>";
							echo "<td class=\"list_item\" style=\"text-align: left; padding-left: 5px; cursor: pointer\" onclick=\"selectDoctor('".$row[2]."')\">".utf8_encode(ucwords(strtolower($row[4])))."</td>";
							echo "</tr>";
						}
					}
					@mysql_free_result($result);
				}
		?>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" align="center">
		<tr>
			<td height="30" valign="bottom"><input type="button" value="Asignar" onclick="assignDoctor('<?=$UPD; ?>', '<?=$cli; ?>')" /></td>
		</tr>
		</table>
	</div>
	</td>
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