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
	<script type="text/javascript" src="../modules/jquery/jquery-1.5.1.min.js"></script>
	<script type='text/javascript'>

		function sendMail(){

			var email = $("#email");
			var nombre = $("#nombre");
			var clinica = $("#clinica");
			var mensaje = $("#mensaje");

			var emailValido = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			var testEmail = emailValido.test(email.val()); 			

			if(!testEmail){
				alert("El formato de correo ingresado no es valido.");
				return false;
			}
					
			if(nombre.val() == ""){
				alert("Debe escribir su nombre en el campo 'Nombre'.");
				return false;
			}
			if(clinica.val() == ""){
				alert("Debe escribir el nombre de su clinica o consultorio en el campo 'Clinica/Consultorio'.");
				return false;
			}
			if(mensaje.val() == ""){
				alert("Debe escribir un mensaje en el campo 'Mensaje'.");
				return false;
			}
					
			$.ajax({
				type : "post",
				url : "emailKobe.php",
				data : "nombre="+nombre.val()+"&email="+email.val()+"&clinica="+clinica.val()+"&mensaje="+mensaje.val(),
				cache : false,
				error : 
					 function(jqXHR, textStatus, errorThrown){
						 alert("Error text: "+jqXHR.responseText+"\n"+
							   "Error thrown: "+errorThrown);
					 },
				success : function(strData){
							if(strData == 1){
								alert("Su correo se ha enviado.");
								email.val("");
								nombre.val("");
								clinica.val("");
								mensaje.val("");
							}
							else{
								alert("Hubo un error al enviar su correo, por favor intentelo nuevamente.");
							}
					}
						
			});
			
		}
	
	</script>
</head>
<body>

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="cfg" style="display: none"><?=$uid; ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">Cotizaci&oacute;n de Productos KOBE</td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
		<div style="text-align:left; margin-left:20px; width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
<br/><br/>

<form action="emailKobe.php" method="post" enctype="multipart/form-data" name="emailKobe">

<div>Email:<br>
<input name="email" type="text" id="email" style='width:200px;' maxlength="50"><br><br>
Nombre:<br>
<input name="nombre" type="text" id="nombre" style='width:200px;' maxlength="50"><br><br>
Clinica/Consultorio:<br>
<input name="clinica" type="text" id="clinica" style='width:200px;' value=""><br><br>
Mensaje:<br>
<textarea name="mensaje" id="mensaje" style='width:500px; height:100px;' cols='50' rows='10'></textarea><br><br>
<input name="Enviar" type="button" onclick="sendMail()" id="Enviar" value="Enviar">
</div>
</form>


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