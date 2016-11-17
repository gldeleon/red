<?php
include_once "../../../lib/definitions.inc.php";
include_once '../../../config.class.php';
include_once "../../../lib/execQuery.class.php";
include "mod_patschedule_insert.class.php";
include "mod_patschedule_select.class.php";
include_once "../../../lib/functions.inc.php";
//mysql_query("SET NAMES utf8");


date_default_timezone_set("America/Mexico_City");

$section = (isset($_POST["section"]) && !empty($_POST["section"])) ? $_POST["section"] : "";
$date = date("Y-m-d");
$time = date("H:i:s");

switch($section){
	
	case "save":
		
		$cli_id = (isset($_POST["cli_id"]) && !empty($_POST["cli_id"])) ? $_POST["cli_id"] : "";
		$pat_id =(isset($_POST["pat_id"]) && !empty($_POST["pat_id"])) ? $_POST["pat_id"] : "";
		$usr_id = (isset($_POST["usr_id"]) && !empty($_POST["usr_id"])) ? $_POST["usr_id"] : "0";
		$emp_id = (isset($_POST["emp_id"]) && !empty($_POST["emp_id"])) ? $_POST["emp_id"] : "";
		$cli_chair = (isset($_POST["cli_chair"]) && !empty($_POST["cli_chair"])) ? $_POST["cli_chair"] : "";
		$ini = (isset($_POST["vst_ini"]) && !empty($_POST["vst_ini"])) ? $_POST["vst_ini"] : "";#hora
		$end = (isset($_POST["vst_end"]) && !empty($_POST["vst_end"])) ? $_POST["vst_end"] : "";
		$vst_descr = (isset($_POST["vst_descr"]) && !empty($_POST["vst_descr"])) ? $_POST["vst_descr"] : "";
		$trt = (isset($_POST["trt"]) && !empty($_POST["trt"])) ? $_POST["trt"] : "";
		
		$pat_id = rawurldecode($pat_id);
		
		$vst_usrmod = 0;
		$vst_datemod = "0000-00-00";
		
		$data = array();
		$vst_descr = rawurldecode($vst_descr);
		
		//Tue Aug 23 2011 13:15:00 GMT-0500
		list($diai, $mesi, $ndiai, $anioi, $vst_ini, $gmti) = explode(" ", $ini);
		list($diaf, $mesf, $ndiaf, $aniof, $vst_end, $gmtf) = explode(" ", $end);
		
		################################################################################
		#### Convertimos el tiempo de la sesion a minutos y buscamos el registro en ####
		#### visitlength para llenar ese campo en visit al ingresar una nueva cita  ####
		################################################################################
		
		$minutos = RestarHoras($vst_ini, $vst_end);
		
		$query = mod_patschedule_select::getVisitLength();
		$params = array($minutos);
		$types = "i";
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		$vln_id = $result[0];
		
		##################################
		#### Insertamos la nueva cita ####
		##################################
		
		$mesi = monthToNum($mesi);
		
		$vst_date = $anioi."-".$mesi."-".$ndiai; #fecha
		
		$cli_chair = $cli_chair + 1;
		
		$query = mod_patschedule_insert::insertVisit();
		$params = array($cli_id, $vln_id, 1, $pat_id, $usr_id, $emp_id, $cli_chair, 
					    $vst_date, $vst_ini, $vst_end, $vst_descr, $vst_usrmod, $vst_datemod);
		$types = "iiisiiissssis";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->insertData();
		$key = $execQuery->last_id;
		
		############################################
		### Insertamos el tratamiento de la cita ###
		############################################
		
		if($execQuery->aRows > 0){
			$query = mod_patschedule_insert::insertVstTreat();
			$params = array($key, $trt);
			$types = "ii";
			
			$execQuery = new execQuery($query, $params, $types);
			$execQuery->insertData();
			
			##############################################
			##				Mandamos correo				##
			##############################################
			
 			/*require_once dirname(__FILE__).'/../../../'.'klib/correo/correo.php'; 
			
			$execQuery = new execQuery("SELECT p.pat_complete, p.pat_mail FROM patient p WHERE p.pat_id = ? ", array($pat_id), "s");
			$result = $execQuery->getQueryResults();
			list($infoPaciente['pat_complete'],$infoPaciente['pat_mail']) = explode(__SEPARATOR,$result[0]);
			
			if( filter_var($infoPaciente['pat_mail'], FILTER_VALIDATE_EMAIL) ){
				$execQuery = new execQuery("SELECT c.cli_name FROM clinic c WHERE c.cli_id = ? ", array($cli_id), "i");
				$result = $execQuery->getQueryResults();
				list($infoClinica['cli_name']) = explode(__SEPARATOR,$result[0]);
				
				$meses = array("01","02","03","04","05","06","07","08","09","10","11","12");
				$mesesEsp = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
				$mes = str_replace($meses, $mesesEsp, $mesi);
					
				$fecha = $ndiai." de ".$mes." del ".$anioi;
				
				#Informacion de correo
				$titulo = 'Tu cita ha sido agendada!';
				$archivoCorreo = 'agendarCita.html';
				//$to = array( $infoPaciente['pat_mail'] => $infoPaciente['pat_complete'] ); #direccion que ingresas en la confirmacion
				$to = array( "vickrattlehead@gmail.com" => $infoPaciente['pat_complete'] ); #direccion que ingresas en la confirmacion
				$personalizacionCorreo = array(
					'paciente' => $infoPaciente['pat_complete'],
					'dia' => $fecha,
					'hora' => substr($vst_ini, 0,5),
					'clinica' => $infoClinica['cli_name'],
				);
				##mandar correo de confirmacion
				if (enviaCorreo($to, $titulo, $archivoCorreo, $personalizacionCorreo)) {
					#que hacer cuando se envio
					//die(json_encode(array('ok' => true)));
				}
			}*/
		}
		
		################################################
		### Obtenemos el color del status de la cita ###
		################################################
		
		
		$query = mod_patschedule_select::getVisitStatus();
		$params = array(1);
		$types = "i";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		list($color, $hcolor) = explode(__SEPARATOR, $result[0]);
		
		$query = mod_patschedule_select::getAbbrEmpName();
		$params = array($emp_id);
		$types = "i";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		list($abbr, $drname) = explode(__SEPARATOR, $result[0]);
		
		$data = array("color" => $color,
				      "headerColor" => $hcolor,
				      "response" => $response,
				      "key" => $key,
					  "title" => "<span title='".utf8_encode($drname)."' style='font-size:9px;'>".$abbr."</span>");
		
		echo json_encode($data);
		
		break;
		
	case "edit":
		
		$cli_id = (isset($_POST["cli_id"]) && !empty($_POST["cli_id"])) ? $_POST["cli_id"] : "";
		$pat_id =(isset($_POST["pat_id"]) && !empty($_POST["pat_id"])) ? $_POST["pat_id"] : "";
		$usr_id = (isset($_POST["usr_id"]) && !empty($_POST["usr_id"])) ? $_POST["usr_id"] : "0";
		$emp_id = (isset($_POST["emp_id"]) && !empty($_POST["emp_id"])) ? $_POST["emp_id"] : "";
		$cli_chair = (isset($_POST["cli_chair"]) && !empty($_POST["cli_chair"])) ? $_POST["cli_chair"] : "";
		$ini = (isset($_POST["vst_ini"]) && !empty($_POST["vst_ini"])) ? $_POST["vst_ini"] : "";
		$end = (isset($_POST["vst_end"]) && !empty($_POST["vst_end"])) ? $_POST["vst_end"] : "";
		$vst_descr = (isset($_POST["vst_descr"]) && !empty($_POST["vst_descr"])) ? $_POST["vst_descr"] : "";
		$trt = (isset($_POST["trt"]) && !empty($_POST["trt"])) ? $_POST["trt"] : "";
		$id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : "";
		$vta_id = (isset($_POST["vta"]) && !empty($_POST["vta"])) ? $_POST["vta"] : "";
		
		$pat_id = rawurldecode($pat_id);
		
		$vst_usrmod = $usr_id;
		$vst_datemod = $date;
		
		$data = array();
		$vst_descr = rawurldecode($vst_descr);
		
		//Tue Aug 23 2011 13:15:00 GMT-0500
		list($diai, $mesi, $ndiai, $anioi, $vst_ini, $gmti) = explode(" ", $ini);
		list($diaf, $mesf, $ndiaf, $aniof, $vst_end, $gmtf) = explode(" ", $end);
		
		################################################################################
		#### Convertimos el tiempo de la sesion a minutos y buscamos el registro en ####
		#### visitlength para llenar ese campo en visit al editar una cita          ####
		################################################################################
		
		$minutos = RestarHoras($vst_ini, $vst_end);
		
		$query = mod_patschedule_select::getVisitLength();
		$params = array($minutos);
		$types = "i";
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		$vln_id = $result[0];
		
		##################################
		####     Editamos la cita     ####
		##################################
		
		$mesi = monthToNum($mesi);
		
		$vst_date = $anioi."-".$mesi."-".$ndiai;
		
		$cli_chair = $cli_chair + 1;
		
		$query = mod_patschedule_insert::insertVstHist();
		$execQuery = new execQuery($query, array($id),"i");
		$execQuery->execute(ARRAY_ASSOC);
		
		$query = mod_patschedule_insert::updateVisit();
		$params = array($cli_id, $vln_id, $vta_id, $pat_id, $emp_id, $cli_chair,
					    $vst_date, $vst_ini, $vst_end, $vst_descr, $vst_usrmod, $vst_datemod, $id);
		$types = "iiisiissssisi";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->updatetData();
		
		############################################
		### Insertamos el tratamiento de la cita ###
		############################################
		
		if($execQuery->aRows > 0){
			$query = mod_patschedule_insert::updateVstTreat();
			$params = array($trt, $id);
			$types = "ii";
				
			$execQuery = new execQuery($query, $params, $types);
			$execQuery->insertData();
		}
		
		################################################
		### Obtenemos el color del status de la cita ###
		################################################
		
		
		$query = mod_patschedule_select::getVisitStatus();
		$params = array($vta_id);
		$types = "i";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		list($color, $hcolor) = explode(__SEPARATOR, $result[0]);
		
		$query = mod_patschedule_select::getAbbrEmpName();
		$params = array($emp_id);
		$types = "i";
		
		$execQuery = new execQuery($query, $params, $types);
		$result = $execQuery->getQueryResults();
		list($abbr, $drname) = explode(__SEPARATOR, $result[0]);
		
		$data = array("color" => $color,
					  "headerColor" => $hcolor,
					  "response" => $response,
					  "title" => "<span title='".utf8_encode($drname)."' style='font-size:9px;'>".$abbr."</span>",
					  "userId" => $cli_chair);
		
		echo json_encode($data);
		
		
		break;
		
	case "delete" :
		
		$id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : "";
		$vta = (isset($_POST["vta"]) && !empty($_POST["vta"])) ? $_POST["vta"] : "";
		$usr_id = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : "0";
		
		$query = mod_patschedule_insert::insertVstHist();
		$execQuery = new execQuery($query, array($id),"i");
		$execQuery->execute(ARRAY_ASSOC);
		
		$query = mod_patschedule_insert::deleteVst();
		$params = array($vta, $usr_id, $date, $id);
		$types = "iisi";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->updatetData();
		
		echo $response;
		
		break;
	
	
}
?>