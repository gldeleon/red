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

$clinica = (isset($_GET["clinic"]) && !empty($_GET["clinic"])) ? $_GET["clinic"] : "0";
$cli= (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
//$ref = (isset($_GET["ref"]) && !empty($_GET["ref"])) ? $_GET["ref"] : "";
//$ref = ($ref == "") ? $_SERVER['HTTP_REFERER'] : $ref;
include_once "../../lib/definitions.inc.php";
include_once "../../lib/execQuery.class.php";
include_once '../../config.class.php';

$query = "SELECT cli_chairs, cli_name FROM kobemxco_red.clinic where cli_id = {$clinica}";
$execQuery = new execQuery($query);
$numChair = $execQuery->getQueryResults();
$sillones = "";
list($numSillon, $nombreCli) = explode(__SEPARATOR, $numChair[0]);
for($i=0; $i<$numSillon; $i++){
	
	$sillones .= ($i+1).", ";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Alta de Horarios</title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript">
            
	<!--[CDATA[
		var longitud = [<?=substr($sillones, 0, -2); ?>];
        var clinica = "<?=utf8_encode($nombreCli); ?>";        

	//]]-->
	</script>

        
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
        <script type='text/javascript' src='../jquery/jquery.weekcalendar.js' ></script>
        <link rel='stylesheet' type='text/css' href='../jquery/jquery.weekcalendar.css' />
        <link rel='stylesheet' type='text/css' href='../jquery/css/default.css' />
        <link rel='stylesheet' type='text/css' href='../jquery/weekcalendar.css' />
        <script type="text/javascript" src='js/clischedule.js' ></script>
        <script type="text/javascript" src="js/mod_schedule.js" ></script>
        <link rel='stylesheet' type='text/css' href="css/mod_schedule.css" />
        <script language="javascript" type="text/javascript">
            
	<!--[CDATA[
		var cli = "<?=$cli; ?>";
		var clid = "<?=$clinica; ?>";
        
        $j(function() {
            $j( "#date_ini" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });
    
        $j(function() {
            $j( "#date_end" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });

        $j(function() {
            $j( "#date_ini2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });
    
        $j(function() {
            $j( "#date_end2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });

        document.oncontextmenu = function(e) {
        	return false;
        };
 

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
				<label class="title2">M&oacute;dulo de Horarios de Cl&iacute;nicas (<?=utf8_encode($nombreCli);?>)</label>
			</td>
			<td width="300" height="30">&nbsp;</td>
			<td width="100" align="right" valign="middle">
		</tr>
		</table>
		</td>
		<td class="outf1y2"></td>
	</tr>
	<tr>
		<td colspan="3" id="m">
		<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">

                     <div id="container">              
                         
<!-- Inicio del calendario -->                                        
	<div id='calendar'></div>
	<div id="event_edit_container">
		<form>
			<input type="hidden" />
			
			<table id="optionsTable" width="450" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="1" class="title">Fecha: </td>
					<td colspan="3"><span class="date_holder"></span></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Tipo de Horario:</td>
					<td colspan="3">
						<input type="radio" name="schType" id="1" onclick="openOptions(this.id)" checked="checked"/> Fijo
						<input type="radio" name="schType" id="2" onclick="openOptions(this.id)"/> Inactividad
						<input type="radio" name="schType" id="3" onclick="openOptions(this.id)"/> Especial
					</td>
				</tr>

				<tr id="specialOptions" style="display:none;">
					<td colspan="1" class="title">Asignar:</td>
					<td colspan="3">
						<input type="radio" name="radDate" valor="2" checked="checked" onclick="enablePeriod(this.getAttribute('valor'),'')"/> Fecha seleccionada <input type="radio" name="radDate" valor="1" onclick="enablePeriod(this.getAttribute('valor'),'')"/> Rango de fechas
					</td>
				</tr>	
				<tr id="specialOptions2" style="display:none;">
					<td class="title">Fecha Inicial:</td><td><input type="text" style="width:100px" name="date_ini" id="date_ini" disabled="disabled"/></td>
					<td class="title">Fecha Final:</td> <td><input type="text" style="width:100px" name="date_end" id="date_end" disabled="disabled"/></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Horario Inicial:</td>
					<td colspan="3"><select name="start"><option value="">Select Start Time</option></select></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Horario Final:</td>
					<td colspan="3"><select name="end"><option value="">Select End Time</option></select></td>
				</tr>
			</table>

		</form>
		
		  <div id="confirmEdit" style="text-align:center; display:none;">
				<p>Para editar el horario de este sill&oacute;n haga clic en "Aceptar".</p>
				<p>para editar el horario de este sill&oacute;n en la fecha seleccionada haga clic en "Cancelar".</p>
    	  </div>
	</div>
	<div id="event_edit_container2" style="display: none;">
		<form>
			<input type="hidden" />
			
			<table id="optionsTable" width="450" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="1" class="title">Fecha: </td>
					<td colspan="3"><span class="date_holder"></span></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Tipo de Horario:</td>
					<td colspan="3">
						<input type="radio" name="schType2" id="1" checked="checked"/> Normal
						<input type="radio" name="schType2" id="2" /> Inactividad
					</td>
				</tr>

				<tr id="specialOptions3" style="display:none;">
					<td colspan="1" class="title">Asignar:</td>
					<td colspan="3">
						<input type="radio" name="radDate2" valor="2" checked="checked" onclick="enablePeriod(this.getAttribute('valor'), 2)"/> Fecha seleccionada <input type="radio" name="radDate2" valor="1" onclick="enablePeriod(this.getAttribute('valor'),2)"/> Rango de fechas
					</td>
				</tr>	
				<tr id="specialOptions4" style="display:none;">
					<td class="title">Fecha Inicial:</td><td><input type="text" style="width:100px" name="date_ini2" id="date_ini2" disabled="disabled"/></td>
					<td class="title">Fecha Final:</td> <td><input type="text" style="width:100px" name="date_end2" id="date_end2" disabled="disabled"/></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Horario Inicial:</td>
					<td colspan="3"><select name="start"><option value="">Select Start Time</option></select></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Horario Final:</td>
					<td colspan="3"><select name="end"><option value="">Select End Time</option></select></td>
				</tr>
			</table>

		</form>
		
		  <div id="confirmEdit" style="text-align:center; display:none;">
				<p>Para editar el horario de este sill&oacute;n haga clic en "Aceptar".</p>
				<p>para editar el horario de este sill&oacute;n en la fecha seleccionada haga clic en "Editar".</p>
    	  </div>
	</div>                             
 <!-- Fin del calendario -->                         
          
                         
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

