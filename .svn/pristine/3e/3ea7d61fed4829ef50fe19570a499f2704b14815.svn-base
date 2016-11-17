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
$profile = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
$arg = (isset($_GET["arg"]) && !empty($_GET["arg"])) ? $_GET["arg"] : "0";
$cli = ($cli == 0) ? $profile : $cli;
$fechaCal = (isset($_GET["fecha"]) && !empty($_GET["fecha"])) ? $_GET["fecha"] : "";
$pat_id = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
$pat_name = (isset($_GET["patname"]) && !empty($_GET["patname"])) ? $_GET["patname"] : "";

include_once "../../lib/definitions.inc.php";
include_once "../../lib/execQuery.class.php";
// include_once "mod_spcschedule/classes/getFreeBusy.php";
include_once '../../config.class.php';
include_once "includes/specialities.php";
$query = "SELECT cli_chairs, cli_name FROM kobemxco_red.clinic where cli_id = {$cli}";
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
	<title>Red KOBE</title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript">
            
	<!--[CDATA[
		var longitud = [<?=substr($sillones, 0, -2); ?>];
		var clinica = "<?=utf8_encode($nombreCli); ?>";
        var argument = "<?=$arg; ?>";
        var fechaCal = "<?=$fechaCal; ?>"; 
        var pat = "<?=$pat_id; ?>";
        var patname = "<?=$pat_name; ?>"; 

	//]]-->
	</script>

        
	<? //if($browser == "FF") { ?>
        <!--<link href="../../dentalia_ff.css" rel="stylesheet" type="text/css" />-->
        <? //} echo "\n"; ?>
        <link rel='stylesheet' type='text/css' href='../jquery/reset.css' />
        <script type="text/javascript" src="../../modules/createMenu.js"></script>
        <script type="text/javascript" src="../../modules/newPatientDialog.js"></script>
        <script type="text/javascript" src="../../modules/ajax.js"></script>
        <script type="text/javascript" src="../jquery/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="../jquery/jquery-ui-1.8.11.custom.min.js"></script>
        <link type="text/css" rel="stylesheet" href="../jquery/themes/ui-lightness/jquery.ui.all.css"  />
        <script type='text/javascript' src='../jquery/date.js' ></script>
        <script type='text/javascript' src='js/jquery.weekcalendar.js' ></script>
        <script type='text/javascript' src='js/jquery-contextmenu.js' ></script>
        <link rel='stylesheet' type='text/css' href='../jquery/jquery.weekcalendar.css' />
        <link rel='stylesheet' type='text/css' href='../jquery/css/default.css' />
        <link rel='stylesheet' type='text/css' href='../jquery/weekcalendar.css' />
        <script type="text/javascript" src='js/weekcalendar.js' ></script>
        <script type="text/javascript" src="js/mod_patschedule.js" ></script>
        <link rel='stylesheet' type='text/css' href="css/mod_patschedule.css" />
        <style type="text/css">
        
        		#buscarDr{
        			
        			width:640px;
        			height:300px;
        			position:absolute;
        			z-index: 10000000000000000000000;
        			background: #FFFFFF;
        			left: 228px;
        			-webkit-border-radius: 10px;
					-moz-border-radius: 10px;
					border-radius: 10px;
					-webkit-box-shadow: 0px 0px 8px 1px #333333;
					-moz-box-shadow: 0px 0px 8px 1px #333333;
					box-shadow: 0px 0px 8px 1px #333333; 
					border: #084C9D 1px solid;
					
        		
        		}
        		
        		#drTable{
        			width: 530px;
        			font-size:10px;
        		}
        		
        		#drTable .title{
        			text-align:right;
        			font-weight:bold;
        		}
        		
        		#drTable td{
        			padding: 2px;
        		}
        		
        		#drTable .hlength{
				    width:70px;
				}
				#drTable .drName{
				    width: 170px;
				}
				#drTable .cliName{
				    width: 75px;
				}
        		
        		#drTable select{
        			width:auto;
        		}
        		#titulo{
        			-moz-border-radius-topleft: 10px;
					-moz-border-radius-topright: 10px;
					-moz-border-radius-bottomright: 0px;
					-moz-border-radius-bottomleft: 0px;
					-webkit-border-radius: 10px 10px 0px 0px;
					border-radius: 10px 10px 0px 0px;
					background-color: #ABD9E9;
					color: #084C9D;
					height:15px;
					width:630px;
					text-align:center;
					font-weight:bold;
					padding:5px;
					border-bottom: #084C9D 1px solid;
        		}
        		#searchResults{
        			
        			border: 1px solid #ABD9E9;
        			width:400px;
        			height:220px;
        			overflow:scroll;
        			overflow-x: hidden;
        		
        		}
        		
        		#loader{
        			left:360px;
                    top: 95px;
        			position:absolute;
        		}
        		
        		#cargar{
        			position: absolute;
        			left:45%;
        			top:50%;
        			font-weight: bold;
        		}
        		
        </style>
        <script language="javascript" type="text/javascript">
            
	<!--[CDATA[
		var cli = "<?=$cli; ?>";
        
        $j(function() {

            $j("#drSearch").click(function(){
    			$j("#buscarDr").slideToggle();
    		});
    		
        });
    
      document.oncontextmenu = function(e) {
   			return false;
        };		

        function closeSearch(){
        	$j("#buscarDr").slideUp();
        	$j("#searchResults").html("");
        	$j("#spc2").val("");
        	$j("#clinic").val("");
        	$j("#horaIni").val("");
        }


        window.onload = function() {
        	var m = document.getElementById("m");
        	if(parseInt(document.body.clientHeight) > 8) {
        		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 5 + "px";
        	}
        	var w = parseInt(document.body.clientWidth);
        	w = ff ? (w - 4) : w;
        	if(typeof(top.leftFrame) != 'undefined') {
        		deleteMenu();
        	}
        	
        	if(fechaCal != ""){ 
      		   $j('#calendar').weekCalendar("gotoWeek", fechaCal);
      		}

      		if(pat != ""){
				document.getElementById("trSillon").style.display = "table-row";
      		}   
                
        }
 	      

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
			<td><table><td><label class="title2">Agenda de la Semana (<?=utf8_encode($nombreCli); ?>)</label></td><td style="width: 50px;">&nbsp;</td><td>Especialidades:</td><td><?=$especialidades; ?></td></table> </td>
			<td width="40" height="30">
				<input type="button" value="Buscar" id="drSearch" />
				<div id="buscarDr" style="display:none;">
					<div align="center" id="titulo" >B&uacute;squeda de horario</div>
					<div>&nbsp;</div>
					<table align="center" id="drTable">
						<tr>
							<td class="title">Especialidad:</td>
							<td><?=$spcSelect2;?></td>
							<td rowspan="7"></td>
							<td rowspan="7" ><div id="searchResults"></div></td>
						</tr>
						<tr>
							<td class="title">Cl&iacute;nica:</td>
							<td><?=$cliSelect; ?></td>
						</tr>
						<tr>
							<td class="title">Hora:</td>
							<td><select id="horaIni" name="horaIni">
									<option value="">---</option>
									<?=$intHoras; ?>
								</select>
							</td>
						</tr>
						<tr><td></td><td style="text-align:left;"><input type="button" value="Buscar" onclick="getFreeDr()"/></td></tr>
						<tr></tr>
						<tr></tr>
						<tr></tr>
						<tr><td colspan="4" style="text-align: right;"><input type="button" value="Cerrar" onclick="closeSearch()" /></td></tr>

					</table>
					
				</div>
			</td>
		</tr>
		</table>
		</td>
		<td class="outf1y2"></td>
	</tr>
	<tr>
		<td colspan="3" id="m">
		<div style="width: 100%; height: 100%; overflow-y: hidden; overflow-x: hidden">

                     <div id="container">              
                         
<!-- Inicio del calendario -->
                         
	<div id='calendar'></div>
	<input type="hidden" id="iniDate" />
	<div id="event_edit_container">
		<form>
			<input type="hidden" />
			<table id="optionsTable" width="400" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="1" class="title">Doctor:</td>
					<td colspan="3"><?=$drSelect; ?></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Paciente:</td>
					<td colspan="3">
						<input type="text" id="patient" /><input type="hidden" id="pat_id" name="pat_id" /> 
						<a onclick="showNewPatientDialog('patient', 'patid')" href="javascript:void(0);"><img width="20" height="20" border="0" style="cursor: pointer; vertical-align:middle;" title="Nuevo" alt="Nuevo" src="../../images/newicon.gif" /></a>
					</td>
				</tr>
				<tr>
					<td colspan="1" class="title">Fecha: </td>
					<td colspan="3">
						<span class="date_holder"></span>
						<input type="text" id="selDate" class="selDate" />
					</td>
				</tr>
				<tr id="trSillon" style="display:none">
					<td colspan="1" class="title">Sill&oacute;n:</td>
					<td colspan="3">
						<select id="sillon">
							<?php 
								for($i=1; $i<=$numSillon; $i++){
										echo "<option value='{$i}'>{$i}</option>"; 
								}
						 	?>
						</select>
					</td>
				</tr>
				
					<td colspan="1" class="title">Especialidad:</td>
					<td colspan="3"><?=$spcSelect;?></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Tratamiento:</td>
					<td colspan="3"><select name="trt" id="trt"><option value="">---</option></select></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Horario Inicial:</td>
					<td colspan="3"><select name="start" id="start"><option value="">Select Start Time</option></select></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Horario Final:</td>
					<td colspan="3"><select name="end" id="end"><option value="">Select End Time</option></select></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Observaciones:</td>
					<td colspan="3"><textarea id="obs" name="obs" cols="10" rows="5"></textarea></td>
				</tr>
			</table>
		</form>
	</div>

	
	<!-- Schedule Info -->
	
	<div id="schInfoBox" style="display: none;">
	
		<table id="optionsTable" width="400" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="1" class="title">Fecha: </td>
					<td colspan="3"><span class="date_holder"></span></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Doctor:</td>
					<td colspan="3" id="infoDoctor"></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Paciente:</td>
					<td colspan="3" id="infoPaciente"></td>
				</tr>
				<tr>
					<td colspan="1" class="title" valign="top">Tel&eacute;fono(s):</td>
					<td colspan="3" id="infoTel"></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Status:</td>
					<td colspan="3" id="infoCita"></td>
				</tr>
				<tr>
					<td colspan="1" class="title">Tratamiento:</td>
					<td colspan="3" id="infoTratamiento"></td>
				</tr>
				
				<tr>
					<td colspan="1" class="title">Observaciones:</td>
					<td colspan="3" id="infoObs"></td>
				</tr>
		</table>
	
	</div>
	<div id="cargar" style="display:none;">
		<img src="../../images/agenda-loader.gif" /><br/><br/>
		Cargando Calendario
	</div>
	
	<?php 
		if($arg != "1") {
		
			include "newPatient.inc.php";
		
		}
	?>
                         
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

