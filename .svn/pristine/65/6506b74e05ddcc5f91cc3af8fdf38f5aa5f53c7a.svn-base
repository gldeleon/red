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

	include_once "data.php";
	include_once "../../functions.inc.php";

	$section = (isset($_GET["section"]) && !empty($_GET["section"])) ? $_GET["section"] : "1";
	$data = new data();
	$clinicas = $data->getClinic();
	$posts = $data->getPost();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Empleados</title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/css.css" type="text/css" />
	<script type="text/javascript" src="../../modules/ajax.js"></script>
	<script type="text/javascript" src="../../modules/createMenu.js"></script>
	<script type='text/javascript' src='js/prototype.js'></script>
	<script type='text/javascript' src='js/scriptaculous-js-1.8.3/src/scriptaculous.js'></script>
	<script type='text/javascript' src='js/lightview.js'></script>
	<link rel="stylesheet" type="text/css" href="css/lightview.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/js.js"></script>
	<script type='text/javascript' src='js/myscroll.js'></script>
	<script language="javascript" type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$cli; ?>";
	/* ]] */
	</script>
</head>
<body>

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="cfg" style="display: none"><?=$uid; ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">Doctores</td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
		<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<?php
			switch($section) {
				case "2":
					include 'altaForm.php';
					break;
				case "3":
					include 'empReturn.php';
					break;
				default:
					include 'empList.php';
			}
		?>
		</div>
    </td>
</tr>
<tr>
	<td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom">&nbsp;</td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>

</body>
</html>