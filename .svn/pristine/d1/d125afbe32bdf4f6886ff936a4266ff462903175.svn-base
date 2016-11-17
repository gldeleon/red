<?php
include_once "../../lib/definitions.inc.php";
include_once '../../config.class.php';
include_once "../../lib/execQuery.class.php";
include_once "../../lib/toHtml.class.php";
include_once "classes/mod_schedule_select.php";

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
					<td><a href='calendar.php?clinic={$cli_id}&cli={$cli}'><img src='../../images/schedule-icon.png'  border='0' alt='Horario' title='Horario' style='cursor:pointer;'/></a></td>
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
							<td><a href='calendar.php?clinic={$cli_id}&cli={$cli}'><img src='../../images/schedule-icon.png'  border='0' alt='Horario' title='Horario' style='cursor:pointer;'/></a></td>
							<td><a href='javascript:void(0);' onclick='changeStatus({$cli_id}, 1)' ><img src='../../images/icon_active.gif'  border='0' alt='Activar' title='Activar' style='cursor:pointer;'/></a></td>
						</tr>";
}

$cliInactiveList .= "</table>";


?>