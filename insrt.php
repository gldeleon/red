<?php
include "config.inc.php";
include "functions.inc.php";
$alert = "";
if(isset($_POST["statusContra"]) && !empty($_POST["statusContra"]) && isset($_POST["contr"]) && !empty($_POST["contr"]) && isset($_POST["cliID"]) && !empty($_POST["cliID"])){
	if($_POST["statusContra"] == "ACEPTADO"){
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		$query = "UPDATE kobemxco_red.accept_cont SET status = '".$_POST["statusContra"]."',date_accept = now() WHERE cli_id = ".$_POST["cliID"]." AND type_contr = '".$_POST["contr"]."';";
		if(!$link){
			$alert ="Error al conectar ".mysql_error();
		}
		if($exeQuery = @mysql_query($query,$link)){
			$alert = "Gracias por tu cooperación, tu respuesta ha sido guardada";
		}else{
			$alert = "Error al guardar tu respuesta, comunicate al 01 800 011 56 56";
		}
		
	}else{
		$alert = "Recuerda que al rechazar no se podra iniciar sesión en el sistema";
	}
	
}else{
	$alert = "Error al guardar tu respuesta(campos vacios), comunicate al 01 800 011 56 56";
}
echo "<script type='text/javascript'>";
echo "window.alert('".$alert."');";
echo "location.href='index.php'";
echo '</script>';
