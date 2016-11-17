<?php
	/** Si no existe una pagina anterior como referencia, no muestra nada. */
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
		exit();
	session_name("pra8atuw");
	session_start();
	if(count($_SESSION) > 0)
		extract($_SESSION);
	else {
		$_SESSION = array();
		session_destroy();
		header("Location: classes/logout.php");
	}

	/** Llama e incluye el archivo de configuracion. */
	include "config.inc.php";

	$url = $AppUrl;

	/** Obtiene un recurso de conexion con el servidor MySQL. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	$active = false;
	$error = true;
	if(isset($_GET["rq"]) && !empty($_GET["rq"])) {
		$rq = $_GET["rq"];
	}
	
	$query = "select usr_lastupdate from ".$DBName.".user where usr_id = ".$uid;
	if($result = @mysql_query($query, $link)) {
		$lastupd = @mysql_result($result, 0);
		$tresmeses = mktime(0, 0, 0, intval(date("m"), 10) - 3, intval(date("j"), 10), intval(date("Y"), 10));
		if(is_null($lastupd) || $lastupd == "" || ($lastupd <= date("Y-m-d", $tresmeses))) {
			$active = true;
		}
		@mysql_free_result($result);
	}
	if(!$active) {
		header("Location: main.php");
	}
	if(isset($_POST["ca"]) && !empty($_POST["ca"])) {
		if(isset($_POST["cn"]) && !empty($_POST["cn"])) {
			if(isset($_POST["cc"]) && !empty($_POST["cc"])) {
				$ca = $_POST["ca"];
				$cn = $_POST["cn"];
				$cc = $_POST["cc"];
				if(strlen($cn) >= 6 && strlen($cc) >= 6) {
					if(($cn == $cc) && ($ca != $cn) && ($ca != $cc)) {
						$query = "select usr_passwd from ".$DBName.".user where usr_id = ".$uid;
						if($result = @mysql_query($query, $link)) {
							$pa = @mysql_result($result, 0);
							if(($pa == md5($ca)) && ($pa != md5($cn))) {
								$query2 = "update ".$DBName.".user set usr_passwd = '".md5($cn)."', usr_lastupdate = '".date("Y-m-d")."' where usr_id = ".$uid;
								@mysql_query($query2, $link);
								if(@mysql_affected_rows($link) > 0) {
									$error = false;
									$url = "main.php";
								}
							}
							@mysql_free_result($result);
						}
						@mysql_close($link);
					}
				}
			}
		}
	}

	if(!$error) header("Location: $url");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Cambio de contrase&ntilde;a</title>
	<style type="text/css">
		.h1 { font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans; font-size: 20px; text-align: center; padding: 15px; color: #084C9D; font-weight: bold; }
		.h2 { font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans; font-size: 16px; text-align: center; padding: 10px; color: #ABD9E9; font-weight: bold; }
		.p { font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans; font-size: 14px; padding-top: 10px; padding-bottom: 10px; color: #084C9D; font-weight: normal; }
		.pr { font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans; font-size: 14px; text-align: center; padding-top: 10px; padding-bottom: 10px; color: #CC0000; font-weight: bold; }
		.pg { font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans; font-size: 14px; padding-top: 5px; padding-bottom: 5px; color: #084C9D; font-weight: bold; width: 200px; }
		input[type="submit"], input[type="button"] { font-family: "Trebuchet MS", Tahoma, Arial, Helvetica, sans; font-size: 14px; font-weight: bold; }
	</style>
    <script type="text/javascript">
    /* [CDATA[ */
		function cancelLogin() {
			location.href = "classes/logout.php";
		}

		window.onload = function() {
			document.getElementById("ca").focus();
		};
	/* ]] */
	</script>
</head>
<body>

<form name="f" action="passwd.php" method="post">
<table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td colspan="2" class="h1">Cambio de contrase&ntilde;a</td>
</tr>
<tr>
	<td colspan="2" class="h2">Elige una nueva contrase&ntilde;a</td>
</tr>
<tr>
	<td colspan="2" class="p">Como medida de seguridad, es importante que cambies tu contrase&ntilde;a periodicamente.</td>
</tr>
<tr>
	<td colspan="2" class="p">Ten en cuenta estas reglas antes de cambiar tu contrase&ntilde;a:
	<ul>
		<li>Debe contener letras min&uacute;sculas, may&uacute;sculas, n&uacute;meros y cualquier car&aacute;cter del teclado.</li>
		<li>Debe tener m&iacute;nimo seis (6) caracteres.</li>
	</ul>
	</td>
</tr>
<?php if($error && !isset($rq)) { ?>
<tr>
	<td colspan="2" class="pr">Por favor vuelve a introducir tus contrase&ntilde;as. Al parecer ocurri&oacute; un error.</td>
</tr>
<?php } ?>
<tr>
	<td class="pg">Contrase&ntilde;a actual:</td>
	<td><input type="password" id="ca" name="ca" tabindex="1" /></td>
</tr>
<tr>
	<td class="pg">Contrase&ntilde;a nueva:</td>
	<td><input type="password" id="cn" name="cn" /></td>
</tr>
<tr>
	<td class="pg">Confirma contrase&ntilde;a nueva:</td>
	<td><input type="password" id="cc" name="cc" /></td>
</tr>
<tr>
	<td colspan="2" height="40" valign="bottom" align="right">
    <input type="button" value="Cancelar" onclick="cancelLogin()" />
    <input type="submit" value="Cambiar" /></td>
</tr>
</table>
</form>

</body>
</html>