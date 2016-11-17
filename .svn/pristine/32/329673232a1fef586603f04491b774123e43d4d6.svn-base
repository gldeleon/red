<?
	include "../config.inc.php";

	session_name("pra8atuw");
	session_start();

	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	//Genera el registro para la bitacora de usuario
	$query = "insert into {$DBName}.userlog set ulg_id = null, usr_id = '{$_SESSION["uid"]}',
	ulg_date = '".date("Y-m-d H:i:s")."', ulg_mvmt = 'LOGOUT', ulg_tag = ''";
	@mysql_query($query, $link);
	@mysql_close($link);

	$_SESSION = array();
	session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
	<script language="JavaScript" type="text/javascript">
		window.onload = function() {
			top.location.href = '<?=$AppUrl; ?>';
		}
	</script>
	<link href="../red.css" rel="stylesheet" type="text/css" />
</head>
<body>

</body>
</html>
