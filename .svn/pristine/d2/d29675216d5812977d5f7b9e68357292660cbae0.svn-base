<?php
// if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
// 	exit();
// 	session_name("pra8atuw");
// 	session_start();
// 	if(count($_SESSION) > 0)
// 		extract($_SESSION);
// 	else {
// 		$_SESSION = array();
// 		session_destroy();
// 		header("Location: logout.php");
// 	}

$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
//$ref = (isset($_GET["ref"]) && !empty($_GET["ref"])) ? $_GET["ref"] : "";
//$ref = ($ref == "") ? $_SERVER['HTTP_REFERER'] : $ref;
include "classes/clinicInfo.php";
include "classes/cliClassList.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Alta de Horarios</title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
    
	<? //if($browser == "FF") { ?>
        <!--<link href="../../dentalia_ff.css" rel="stylesheet" type="text/css" />-->
        <? //} echo "\n"; ?>
        <link rel='stylesheet' type='text/css' href='../jquery/reset.css' />
        <script type="text/javascript" src='../jquery/myscroll.js' ></script>
        <script type="text/javascript" src="../../modules/createMenu.js"></script>

        <script type="text/javascript" src="../../modules/newPatientDialog.js"></script>
        <script type="text/javascript" src="../../modules/ajax.js"></script>
        <script type="text/javascript" src="../jquery/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="../jquery/jquery-ui-1.8.11.custom.min.js"></script>
        <link type="text/css" rel="stylesheet" href="../jquery/themes/ui-lightness/jquery.ui.all.css"  />
        <script type='text/javascript' src='../jquery/date.js' ></script>
        <link rel='stylesheet' type='text/css' href='../jquery/css/default.css' />
        <script type="text/javascript" src="js/mod_schedule.js" ></script>
        <link rel='stylesheet' type='text/css' href="css/mod_schedule.css" />
		<script language="javascript" type="text/javascript">
            
		<!--[CDATA[
			var cli = "<?=$cli; ?>";
	
		//]]-->
		</script>
  </head>
  <body style="background:#FFFFFF;">
	<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
	<div id="cfg" style="display: none"><?=$uid; ?></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="outf1y2"></td>
		<td width="100%" class="title2">
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td>
				<label class="title2">M&oacute;dulo de Horarios de Cl&iacute;nicas</label>
			</td>
			<td width="300" height="30">&nbsp;</td>
		</tr>
		</table>
		</td>
		<td class="outf1y2"></td>
	</tr>
	<tr>
		<td colspan="3" id="m">
		<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		
		<div id="clinicSchedule" style="border:0px;">
			<ul>
				<li><a href="#clinicSchedule-1">Alta de Cl&iacute;nica</a></li>
				<li><a href="#activeClinics">Cl&iacute;nicas Activas</a></li>
				<li><a href="#inactiveClinics">Cl&iacute;nicas Inactivas</a></li>
			</ul>  
						<div id="clinicSchedule-1">  
						<p>&nbsp;</p>
                         <table id="scheduleTable" cellspacing="0" cellpadding="0" style="margin-left:100px;">
                         		<tr>
                         			<th colspan="2" style="font-weight:bold; font-size:14px;">Alta de Cl&iacute;nica<br/>&nbsp;</th>
                         			
                         		</tr>
                         		
                         		<tr>
                         			<td class="title">Nombre de la Cl&iacute;nica:</td>
                         			<td class="content">
                         				<input type="text" id="cliname" value="" style="width:200px;"/>
                         			</td>
                         		</tr>
                         		<tr>
                         			<td class="title">Nombre Corto de la Cl&iacute;nica:</td>
                         			<td class="content"><input type="text" id="clishortname" value="" style="width:200px;"/></td>
                         		</tr>
                         		<tr>
                         			<td class="title">N&uacute;mero de Sillones:</td>
                         			<td class="content"><input type="text" id="clichair" value="" style="width:20px;"/></td>
                         		</tr>
                         		<tr>
                         			<td class="title">Tipo de Cl&iacute;nica:</td>
                         			<td class="content"><?=$cliClassSelect; ?></td>
                         		</tr>
                         		<tr>
                         			<td class="title">Estado:</td>
                         			<td class="content"><?=$stateSelect; ?></td>
                         		</tr>
                         		
                         		<tr>
									<td colspan="2" style="text-align:right">
										<input type="button" value="Alta" id="alta"/>
									</td>
                         		</tr>
                         </table>
           </div>
                         <div id="success" title="Alta Exitosa" style="text-align: center; font-weight:bold;">¡Cl&iacute;nica dada de alta exitosamente!</div>
                         <div id="fail" title="Error" style="text-align: center; font-weight:bold;">Error al Insertar los datos<br/>Error: </div>
                       <div id="activeClinics" style="margin-left:100px">
	                       <p>&nbsp;</p>
	                       <p style="font-weight:bold; font-size:14px; text-align: left;">Cl&iacute;nicas Activas<br/>&nbsp;</p>
	                       <span id="active"><?=$cliList;  ?></span>
	                       <p>&nbsp;</p>
                       </div>
                       <div id="inactiveClinics" style="margin-left:100px">
	                       <p>&nbsp;</p>
	                       <p style="font-weight:bold; font-size:14px; text-align: left;">Cl&iacute;nicas Inactivas<br/>&nbsp;</p>
	                       <span id="inactive"><?=$cliInactiveList;  ?></span>
	                       <p>&nbsp;</p>
                       </div>
                       
         </div>
                       <div id="edit-clinic-dialog" title="Editar Datos Generales" style="display:none;">
	                       	<table id="scheduleTable" cellspacing="0" cellpadding="0">
	                         		
	                         		<tr>
	                         			<td class="title">Nombre de la Cl&iacute;nica:</td>
	                         			<td class="content">
	                         				<input type="text" id="clinameEdit" value="" style="width:200px;"/>
	                         				<input type="hidden" id="clid" value=""/>
	                         			</td>
	                         		</tr>
	                         		<tr>
	                         			<td class="title">Nombre Corto de la Cl&iacute;nica:</td>
	                         			<td class="content"><input type="text" id="clishortnameEdit" value="" style="width:200px;"/></td>
	                         		</tr>
	                         		<tr>
	                         			<td class="title">N&uacute;mero de Sillones:</td>
	                         			<td class="content"><input type="text" id="clichairEdit" value="" style="width:20px;"/></td>
	                         		</tr>
	                         		<tr>
	                         			<td class="title">Tipo de Cl&iacute;nica:</td>
	                         			<td class="content"><?=$cliClassSelectEdit; ?></td>
	                         		</tr>
	                         		<tr>
	                         			<td class="title">Estado:</td>
	                         			<td class="content"><?=$stateSelectEdit; ?></td>
	                         		</tr>
	                         		
	                         </table>
                       </div>
                         
                     </div>

               
               </td>
        </tr>
        <tr>
                <td class="outf3y4"></td>
                <td class="wtbottom">&nbsp;</td>
                <td class="outf3y4"></td>
        </tr>
</table>

  </body>
</html>

