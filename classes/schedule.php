<?
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
		exit();
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
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	$profile = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
	$profile = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $profile;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$profile; ?>";
		var calendarDay = '<?=date("j"); ?>';
		var calendarMonth = '<?=date("n"); ?>';
		var calendarYear = '<?=date("Y"); ?>';
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/schedule.js"></script>
	<title><?=$AppTitle; ?></title>
</head>

<frameset id="schedule" rows="*" cols="*,200" framespacing="0" frameborder="no" border="0">
	<frame src="schCalendar.php?profile=<?=$profile; ?>&pat=<?=$pat; ?>" name="schCalendar" id="schCalendar" title="" />
	<frame src="schPanel.php?profile=<?=$profile; ?>" name="schPanel" scrolling="no" noresize="noresize" id="schPanel" />
</frameset>

</html>