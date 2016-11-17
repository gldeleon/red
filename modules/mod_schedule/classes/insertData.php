<?php

include_once "../../../lib/definitions.inc.php";
include_once '../../../config.class.php';
include_once "../../../lib/execQuery.class.php";
include "mod_schedule_insert.php";
include "mod_schedule_select.php";
include_once "../../../lib/functions.inc.php";

date_default_timezone_set("America/Mexico_City");

$section = (isset($_POST["section"]) && !empty($_POST["section"])) ? $_POST["section"] : "";
$date = date("Y-m-d");
$time = date("H:i:s");
$datetime = $date." ".$time;
$enddate = date("Y-m-d", mktime(0,0,0,date("m"), date("d"), date("Y")+5));

switch($section){
	
	case "altaClinica":
	
		$cliname = (isset($_POST["cliname"]) && !empty($_POST["cliname"])) ? $_POST["cliname"] : "";
		$clishortname = (isset($_POST["clishortname"]) && !empty($_POST["clishortname"])) ? $_POST["clishortname"] : "";
		$clichair = (isset($_POST["clichair"]) && !empty($_POST["clichair"])) ? $_POST["clichair"] : "";
		$cli_class = (isset($_POST["cli_class"]) && !empty($_POST["cli_class"])) ? $_POST["cli_class"] : "";
		$state = (isset($_POST["state"]) && !empty($_POST["state"])) ? $_POST["state"] : "";
		$clicoord = (isset($_POST["clicoord"]) && !empty($_POST["clicoord"])) ? $_POST["clicoord"] : "";
		$dentalcoord = (isset($_POST["dentalcoord"]) && !empty($_POST["dentalcoord"])) ? $_POST["dentalcoord"] : "";
		$cliemail = (isset($_POST["cliemail"]) && !empty($_POST["cliemail"])) ? $_POST["cliemail"] : "";
		$usrid = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : 0;
		
		$query = mod_schedule_insert::insertClinic();
		$params = array($cliname, $clishortname, $cliemail, $cli_class, $clichair, $state);
		$types = "sssiii";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->insertData();
		$key = $execQuery->last_id;
		$affected = $execQuery->aRows;
		
// 		if($affected > 0){
			
// 			$query = mod_schedule_insert::insertClinicWeb();
// 			$params = array($cliname, $clishortname, $cliemail, $cli_class, $clichair, $state);
// 			$types = "sssiii";
			
// 			$execQuery = new execQuery($query, $params, $types);
// 			$response = $execQuery->insertData();
			
// 			$query = mod_schedule_insert::insertClinicCoord();
// 			$params = array($key, $clicoord, $dentalcoord, $date, $enddate, $usrid, $time);
// 			$types = "iiissis";
			
// 			$execQuery = new execQuery($query, $params, $types);
// 			$response = $execQuery->insertData();
// 			$affected = $execQuery->aRows;
	
// 		}
		
		$res = array("respuesta" => $response);
		echo json_encode($res);  
		
		break;
		
	case "activeClinic":
		
		$clid = (isset($_POST["clid"]) && !empty($_POST["clid"])) ? $_POST["clid"] : "";
		$active = (isset($_POST["active"]) && !empty($_POST["active"])) ? $_POST["active"] : "0";
		
		$query = mod_schedule_insert::activateClinic();
		$params = array($active, $clid);
		$types = "ii";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->insertData();
		
// 		$query = mod_schedule_insert::activateClinicWeb();
// 		$params = array($active, $clid);
// 		$types = "ii";
		
// 		$execQuery = new execQuery($query, $params, $types);
// 		$execQuery->insertData();
		
		if($response == "OK"){
		
			$query = mod_schedule_select::selectClinicInfo(1);
			$execQuery = new execQuery($query);
			$result = $execQuery->getQueryResults();
		
			$cliList = "<table id='cliList'>
												<tr> 
													<th width='115'>Estado</th>
													<th width='125'>Cl&iacute;nica</th>
													<th width='105'>Nombre corto</th>
													<th width='100'>Tipo</th>
													<th width='60'>Sillones</th>
													<th width='44'>Editar</th>
													<th width='55'>Horario</th>
													<th width='52'>Baja</th>
											 	</tr>";
		
			foreach($result as $val){
		
				list($cli_id, $cli_name, $cli_shortname, $clc_name, $cli_chairs,
				$cli_active, $stt_name, $stt_id,$clc_id) = explode(__SEPARATOR, $val);
		
				$cliList .= "<tr>
													<td>".utf8_encode($stt_name)."</td>
													<td>".utf8_encode($cli_name)."</td>
													<td>".utf8_encode(ucwords(strtolower($cli_shortname)))."</td>
													<td>".ucfirst(strtolower($clc_name))."</td>
													<td>{$cli_chairs}</td>
													<td><a href='javascript:void(0);' onclick='editClinicDialog({$cli_id},1)' ><img src='../../images/icon-edit.gif' border='0' alt='Editar' title='Editar' style='cursor:pointer;' /></a></td>
													<td><a href='calendar.php?clinic={$cli_id}'><img src='../../images/schedule-icon.png'  border='0' alt='Horario' title='Horario' style='cursor:pointer;'/></a></td>
													<td><a href='javascript:void(0);' onclick='changeStatus({$cli_id}, 0)' ><img src='../../images/icon-delete.gif'  border='0' alt='Baja' title='Baja' style='cursor:pointer;'/></a></td>
												</tr>";
			}
		
			$cliList .= "</table>";
		
			$query = mod_schedule_select::selectClinicInfo(0);
			$execQuery = new execQuery($query);
			$result = $execQuery->getQueryResults();
		
			$cliInactiveList = "<table id='cliList'>
												<tr> 
													<th width='115'>Estado</th>
													<th width='125'>Cl&iacute;nica</th>
													<th width='105'>Nombre corto</th>
													<th width='100'>Tipo</th>
													<th width='60'>Sillones</th>
													<th width='44'>Editar</th>
													<th width='55'>Horario</th>
													<th width='52'>Activar</th>
											 	</tr>";
		
			foreach($result as $val){
		
				list($cli_id, $cli_name, $cli_shortname, $clc_name, $cli_chairs,
				$cli_active, $stt_name, $stt_id,$clc_id) = explode(__SEPARATOR, $val);
		
				$cliInactiveList .= "<tr>
															<td>".utf8_encode($stt_name)."</td>
															<td>".utf8_encode($cli_name)."</td>
															<td>".utf8_encode(ucwords(strtolower($cli_shortname)))."</td>
															<td>".ucfirst(strtolower($clc_name))."</td>
															<td>{$cli_chairs}</td>
															<td><a href='javascript:void(0);' onclick='editClinicDialog({$cli_id},0)' ><img src='../../images/icon-edit.gif' border='0' alt='Editar' title='Editar' style='cursor:pointer;' /></a></td>
															<td><a href='calendar.php?clinic={$cli_id}'><img src='../../images/schedule-icon.png'  border='0' alt='Horario' title='Horario' style='cursor:pointer;'/></a></td>
															<td><a href='javascript:void(0);' onclick='changeStatus({$cli_id}, 1)' ><img src='../../images/icon_active.gif'  border='0' alt='Activar' title='Activar' style='cursor:pointer;'/></a></td>
														</tr>";
			}
		
			$cliInactiveList .= "</table>";
		
		}
		
		
		
		$res = array("respuesta" => $response,
					 "active" => $cliList,
					 "inactive" => $cliInactiveList);
		
		echo json_encode($res);
		
		break;
		
	case "editClinica":
		
		$cliname = (isset($_POST["cliname"]) && !empty($_POST["cliname"])) ? utf8_decode($_POST["cliname"]) : "";
		$clishortname = (isset($_POST["clishortname"]) && !empty($_POST["clishortname"])) ? utf8_decode($_POST["clishortname"]) : "";
		$clichair = (isset($_POST["clichair"]) && !empty($_POST["clichair"])) ? $_POST["clichair"] : "";
		$cli_class = (isset($_POST["cli_class"]) && !empty($_POST["cli_class"])) ? $_POST["cli_class"] : "";
		$state = (isset($_POST["state"]) && !empty($_POST["state"])) ? $_POST["state"] : "";
		$clicoord = (isset($_POST["clicoord"]) && !empty($_POST["clicoord"])) ? $_POST["clicoord"] : "";
		$dentalcoord = (isset($_POST["dentalcoord"]) && !empty($_POST["dentalcoord"])) ? $_POST["dentalcoord"] : "";
		$cliemail = (isset($_POST["cliemail"]) && !empty($_POST["cliemail"])) ? $_POST["cliemail"] : "";
		$usrid = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : 0;
		$clid = (isset($_POST["clid"]) && !empty($_POST["clid"])) ? $_POST["clid"] : "";
		
		$query = mod_schedule_insert::updateClinic();
		$params = array($cliname, $clishortname, $cliemail, $cli_class, $clichair, $state, $clid);
		$types = "sssiiii";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->updatetData();
		$affected = $execQuery->aRows;

				
// 			$query = mod_schedule_insert::updateClinicWeb();
// 			$params = array($cliname, $clishortname, $cliemail, $cli_class, $clichair, $state, $clid);
// 			$types = "sssiiii";
				
// 			$execQuery = new execQuery($query, $params, $types);
// 			$response = $execQuery->insertData();
				
// 			$query = mod_schedule_insert::insertClinicCoord();
// 			$params = array($clid, $clicoord, $dentalcoord, $date, $enddate, $usrid, $time);
// 			$types = "iiissis";
				
// 			$execQuery = new execQuery($query, $params, $types);
// 			$response = $execQuery->insertData();
// 			$affected = $execQuery->aRows;
			
			if($response == "OK"){
				
				$query = mod_schedule_select::selectClinicInfo(1);
				$execQuery = new execQuery($query);
				$result = $execQuery->getQueryResults();
				
				$cliList = "<table id='cliList'>
										<tr>
											<th width='115'>Estado</th>
											<th width='125'>Cl&iacute;nica</th>
											<th width='105'>Nombre corto</th>
											<th width='100'>Tipo</th>
											<th width='60'>Sillones</th>
											<th width='44'>Editar</th>
											<th width='55'>Horario</th>
											<th width='52'>Baja</th>
									 	</tr>";
				
				foreach($result as $val){
				
					list($cli_id, $cli_name, $cli_shortname, $clc_name, $cli_chairs,
					$cli_active, $stt_name, $stt_id,$clc_id) = explode(__SEPARATOR, $val);
				
					$cliList .= "<tr>
									<td>".utf8_encode($stt_name)."</td>
									<td>".utf8_encode($cli_name)."</td>
									<td>".utf8_encode(ucwords(strtolower($cli_shortname)))."</td>
									<td>".ucfirst(strtolower($clc_name))."</td>
									<td>{$cli_chairs}</td>
									<td><a href='javascript:void(0);' onclick='editClinicDialog({$cli_id},1)' ><img src='../../images/icon-edit.gif' border='0' alt='Editar' title='Editar' style='cursor:pointer;' /></a></td>
									<td><a href='calendar.php?clinic={$cli_id}'><img src='../../images/schedule-icon.png'  border='0' alt='Horario' title='Horario' style='cursor:pointer;'/></a></td>
									<td><a href='javascript:void(0);' onclick='changeStatus({$cli_id}, 0)' ><img src='../../images/icon-delete.gif'  border='0' alt='Baja' title='Baja' style='cursor:pointer;'/></a></td>
								</tr>";
				}
				
				$cliList .= "</table>";
				
				$query = mod_schedule_select::selectClinicInfo(0);
				$execQuery = new execQuery($query);
				$result = $execQuery->getQueryResults();
				
				$cliInactiveList = "<table id='cliList'>
										<tr> 
											<th width='115'>Estado</th>
											<th width='125'>Cl&iacute;nica</th>
											<th width='105'>Nombre corto</th>
											<th width='100'>Tipo</th>
											<th width='60'>Sillones</th>
											<th width='44'>Editar</th>
											<th width='55'>Horario</th>
											<th width='52'>Activar</th>
									 	</tr>";
				
				foreach($result as $val){
				
					list($cli_id, $cli_name, $cli_shortname, $clc_name, $cli_chairs,
					$cli_active, $stt_name,$stt_id,$clc_id) = explode(__SEPARATOR, $val);
				
					$cliInactiveList .= "<tr>
											<td>".utf8_encode($stt_name)."</td>
											<td>".utf8_encode($cli_name)."</td>
											<td>".utf8_encode(ucwords(strtolower($cli_shortname)))."</td>
											<td>".ucfirst(strtolower($clc_name))."</td>
											<td>{$cli_chairs}</td>
											
											<td><a href='javascript:void(0);' onclick='editClinicDialog({$cli_id},0)' ><img src='../../images/icon-edit.gif' border='0' alt='Editar' title='Editar' style='cursor:pointer;' /></a></td>
											<td><a href='calendar.php?clinic={$cli_id}'><img src='../../images/schedule-icon.png'  border='0' alt='Horario' title='Horario' style='cursor:pointer;'/></a></td>
											<td><a href='javascript:void(0);' onclick='changeStatus({$cli_id}, 1)' ><img src='../../images/icon_active.gif'  border='0' alt='Activar' title='Activar' style='cursor:pointer;'/></a></td>
										</tr>";
				}
				
				$cliInactiveList .= "</table>";
				
			}
		
		
		
		$res = array("respuesta" => $response,
					 "active" => $cliList,
					 "inactive" => $cliInactiveList);
		echo json_encode($res);
		
		break;
		
		
	case "cliSch":
		
		$cli_id = (isset($_POST["cli_id"]) && !empty($_POST["cli_id"])) ? $_POST["cli_id"] : "0";
		$cli_chair = (isset($_POST["cli_chair"]) && !empty($_POST["cli_chair"])) ? $_POST["cli_chair"] : "0";
		$csc_ini = (isset($_POST["csc_ini"]) && !empty($_POST["csc_ini"])) ? $_POST["csc_ini"] : "00:00:00";
		$csc_end = (isset($_POST["csc_end"]) && !empty($_POST["csc_end"])) ? $_POST["csc_end"] : "00:00:00";
		$csc_date = (isset($_POST["csc_date"]) && !empty($_POST["csc_date"])) ? $_POST["csc_date"] : "0000-00-00";
		$csc_date_end = (isset($_POST["csc_date_end"]) && !empty($_POST["csc_date_end"])) ? $_POST["csc_date_end"] : "0000-00-00";
		$csc_modusr = (isset($_POST["csc_modusr"]) && !empty($_POST["csc_modusr"])) ? $_POST["csc_modusr"] : "0";
		$csc_inactive = (isset($_POST["inactive"]) && !empty($_POST["inactive"])) ? $_POST["inactive"] : "0";
		$data = array();
		
		$csc_moddate = $datetime;
		
		$csc_ini = explode(" ", $csc_ini);
		$csc_end = explode(" ", $csc_end);
		
		$csc_day = dayToNum($csc_ini[0]);
		
		$query = mod_schedule_insert::insertClinicSch();
		$params = array($cli_id,$cli_chair,$csc_day,$csc_ini[4],$csc_end[4],$csc_date,$csc_date_end,$csc_moddate,$csc_modusr, $csc_inactive);
		$types = "iiisssssii";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->insertData();
		$key = $execQuery->last_id;
		
		$color = ($csc_inactive == "0") ? "#52D017" : "#CCCCCC";
		
		$data = array("id" => $key,
					  "response" => $response,
					  "color" => $color);

		echo json_encode($data);
		
		break;
		
	case "editCliSch":
		
		$cli_id = (isset($_POST["cli_id"]) && !empty($_POST["cli_id"])) ? $_POST["cli_id"] : "0";
		$cli_chair = (isset($_POST["cli_chair"]) && !empty($_POST["cli_chair"])) ? $_POST["cli_chair"] : "0";
		$csc_ini = (isset($_POST["csc_ini"]) && !empty($_POST["csc_ini"])) ? $_POST["csc_ini"] : "00:00:00";
		$csc_end = (isset($_POST["csc_end"]) && !empty($_POST["csc_end"])) ? $_POST["csc_end"] : "00:00:00";
		$csc_date = (isset($_POST["csc_date"]) && !empty($_POST["csc_date"])) ? $_POST["csc_date"] : "0000-00-00";
		$csc_date_end = (isset($_POST["csc_date_end"]) && !empty($_POST["csc_date_end"])) ? $_POST["csc_date_end"] : "0000-00-00";
		$csc_modusr = (isset($_POST["csc_modusr"]) && !empty($_POST["csc_modusr"])) ? $_POST["csc_modusr"] : "0";
		$csc_inactive = (isset($_POST["inactive"]) && !empty($_POST["inactive"])) ? $_POST["inactive"] : "0";
		$csc_id = (isset($_POST["csc_id"]) && !empty($_POST["csc_id"])) ? $_POST["csc_id"] : "0";
		$data = array();
		
		$csc_moddate = $datetime;
		
		$csc_ini = explode(" ", $csc_ini);
		$csc_end = explode(" ", $csc_end);
		
		$csc_day = dayToNum($csc_ini[0]);
		
		$query = mod_schedule_insert::editClinicSch();
		$params = array($cli_id,$cli_chair,$csc_day,$csc_ini[4],$csc_end[4],$csc_date,$csc_date_end,$csc_moddate,$csc_modusr, $csc_inactive, $csc_id);
		$types = "iiisssssiii";
		
		$execQuery = new execQuery($query, $params, $types);
		$response = $execQuery->insertData();
		
		$color = ($csc_inactive == "0") ? "#52D017" : "#CCCCCC";
		
		$data = array("response" => $response,
					  "color" => $color);
		
		echo json_encode($data);
		
		break;
		
	case "deleteSch":
		
		$csc_id = (isset($_POST["csc_id"]) && !empty($_POST["csc_id"])) ? $_POST["csc_id"] : "0";
		$data = array();
		
		$query = mod_schedule_insert::deleteSch($csc_id);
		$execQuery = new execQuery($query);
		$response = $execQuery->deletetData();
		
		$data = array("response" => $response);
		
		echo json_encode($data);
		
		break;
	
}

?>