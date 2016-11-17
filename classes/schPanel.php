<?
	/** Si no existe una página anterior como referencia, no muestra nada. */
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
	$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";

	$showdate = date("d/m/Y");

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
	<!--[CDATA[
		var cli = "<?=$cli; ?>";
	//]]-->
	</script>
	<script type="text/javascript" src="../modules/schPanel.js"></script>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2">&nbsp;</td>
	<td id="pTd" style="width: 300px;">&nbsp;</td>
	<td class="outf1y2">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="panelHeader">Selecciona una cl&iacute;nica</td>
	</tr>
	<tr>
		<td>
		<select id="panelClinic" name="clinic" onchange="changeProfile(this, '<?=$showdate; ?>')">
			<?
				$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
				if($admin) {
					$query = "select c.cli_id, c.cli_shortname from {$DBName}.clinic as c
					where c.cli_active = 1 order by c.cli_shortname";
				}
				else {
					$query = "select uc.cli_id, c.cli_shortname from {$DBName}.userclinic as uc
					left join {$DBName}.clinic as c on c.cli_id = uc.cli_id
					where uc.usr_id = {$uid} and c.cli_active = 1 order by c.cli_shortname";
				}
				if($result = @mysql_query($query, $link)) {
					if(($numrows = @mysql_num_rows($result)) > 0) {
						while($row = @mysql_fetch_row($result)) {
							$selected = ($row[0] == $cli) ? " selected=\"selected\"" : "";
			?>
			<option value="<?=$row[0]; ?>"<?=$selected; ?>><?=strtoupper($row[1]); ?></option>
			<?
						}
					}
					else {
			?>
			<option value="0">----</option>
			<?
					}
				}
			?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="panelHeader">Selecciona una fecha</td>
	</tr>
	<tr>
		<td><iframe id="mCalendar" width="100%" height="470" src="mCalendar.php?profile=<?=$cli; ?>&parent=schPanel.php&showdate=<?=$showdate; ?>" frameborder="0" scrolling="no"></iframe></td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td class="outf3y4"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom">&nbsp;</td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>

</body>
</html>