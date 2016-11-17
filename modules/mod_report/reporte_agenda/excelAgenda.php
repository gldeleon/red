<?php
	$filename ="ReporteAgenda_{$_GET["fi"]}_{$_GET["ff"]}.xls";
	$contents = " &nbsp; \n";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	echo $contents;
	
	include "../../../config.inc.php";
	include "functionsDebt.inc.php";
	include "config_report.inc.php";
	
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	
	$espanol = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$ingles = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

?>


<table>
	<tr>
		<td>Fecha</td>
		<td>Hora</td>
		<td>Cl&iacute;nica</td>
		<td>Ciudad</td>
		<td>Estado</td>
		<td>Paciente</td>
		<td>Doctor</td>
		<td>Especialidad</td>
		<td>Tratamiento</td>
		<td>Status</td>
	</tr>
	
	
	
	<?php 
		$sql = "SELECT v.vst_date, v.vst_ini, c.cli_name, s.stt_name, p.pat_complete, 
						e.emp_complete, sp.spc_name, t.trt_name, vs.vta_name
				FROM kobemxco_red.visit v
				LEFT JOIN (kobemxco_red.clinic c
						   LEFT JOIN kobemxco_red.state s
						   ON c.stt_id = s.stt_id
						  )
				ON c.cli_id = v.cli_id
				LEFT JOIN kobemxco_red.patient p
				ON p.pat_id = v.pat_id
				LEFT JOIN kobemxco_red.employee e
				ON e.emp_id = v.emp_id
				LEFT JOIN (kobemxco_red.vistreat vt
							LEFT JOIN (kobemxco_red.treatment t
										LEFT JOIN kobemxco_red.speciality sp
										ON t.spc_id = sp.spc_id
										)
							ON t.trt_id = vt.trt_id
							)
				ON vt.vst_id = v.vst_id
				LEFT JOIN kobemxco_red.visitstatus vs
				ON vs.vta_id = v.vta_id
				WHERE v.vst_date BETWEEN '{$_GET['fi']}' AND '{$_GET['ff']}'";
// 		echo $sql;
		$rs = mysql_query($sql,$link);
		//die(mysql_error());
		while($row = @mysql_fetch_assoc($rs)){
			
			$fecha = new DateTime($row["vst_date"]);
			$fecha = $fecha->format("d/m/Y");
			
			echo "<tr>
					<td>".$fecha."</td>
					<td>".$row["vst_ini"]."</td>
					<td>".ucwords(mb_strtolower($row["cli_name"]))."</td>
					<td>&nbsp;</td>
					<td>".$row["stt_name"]."</td>
					<td>".ucwords(mb_strtolower($row["pat_complete"]))."</td>
					<td>".ucwords(mb_strtolower($row["emp_complete"]))."</td>
					<td>".ucwords(mb_strtolower($row["spc_name"]))."</td>
					<td>".ucwords(mb_strtolower($row["trt_name"]))."</td>
					<td>".ucwords(mb_strtolower($row["vta_name"]))."</td>
				</tr>";
			
		}
	?>
</table>