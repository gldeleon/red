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
		var profile = "<?=$cli; ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/menu.js"></script>
</head>
<body>

<div id="cfg" style="display: none"><?=$uid; ?></div>
<table width="153" border="0" cellpadding="0" cellspacing="0" bgcolor="#5E6E65">
<tr>
	<td height="85" colspan="3"><img src="../images/bmenlogo.png" width="153" height="85" border="0" /></td>
</tr>
<tr>
	<td width="20"><img src="../images/spacer.gif" width="20" height="90" /></td>
	<td width="123" align="right" valign="top" id="mn" style="height: 100%">&nbsp;</td>
	<td width="10"><img src="../images/spacer.gif" width="10" height="1" /></td>
</tr>
<tr>
	<td height="85" colspan="3"><img src="../images/spacer.gif" width="153" height="85" /></td>
</tr>
</table>
<?php
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	include "createMenu.php";
?>
<div id="menu">
<?php
	$query = "select mnu_id, mnu_name, mnu_frame, usr_priv
	from {$DBName}.menu where mnu_parent = 0 and mnu_show = 1 order by mnu_order";
	$result = @mysql_query($query, $link);
	while($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
		$showframe = is_null($row["mnu_frame"]) ? 1 : intval($row["mnu_frame"], 10);
		if(!is_null($row["usr_priv"]) && $row["usr_priv"] != $p) {
			continue;
		}
?>
	<div id="<?=$row["mnu_id"]; ?>" class="menuItem" onmouseout="getMouseEvt(this, 'out');" onmouseover="getMouseEvt(this, 'over');" onclick="clickMenu(this.id, <?=$showframe; ?>)">
	<img src="../images/spacer.gif" width="16" height="16" border="0" /><?=mb_convert_case($row["mnu_name"], MB_CASE_TITLE, 'utf-8'); ?></div>
<?php
	}
?>
</div>
<div id="clinicList">
	<select name="clinic" onchange="changeProfile(this)">
		<?php
			if($admin) {
				$query = "select c.cli_id, ucase(c.cli_shortname) as sname from {$DBName}.clinic as c
				where c.cli_active = 1 order by c.cli_shortname";
			}
			else {
				$query = "select uc.cli_id, ucase(c.cli_shortname) as sname from {$DBName}.userclinic as uc
				left join {$DBName}.clinic as c on c.cli_id = uc.cli_id
				where uc.usr_id = {$uid} and c.cli_active = 1 order by c.cli_shortname";
			}
			if($result = @mysql_query($query, $link)) {
				if(($numrows = @mysql_num_rows($result)) > 0) {
					while($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
						$selected = ($row['cli_id'] == $cli) ? " selected=\"selected\"" : "";
						echo "<option value=\"{$row['cli_id']}\"{$selected}>{$row['sname']}</option>";
					}
				}
				else {
					echo "<option value=\"0\">----</option>";
				}
			}
		?>
	</select>
</div>

</body>
</html>