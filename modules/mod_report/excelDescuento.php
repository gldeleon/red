<?php
	$filename ="excelreport.xls";
	$contents = " &nbsp; \n";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	echo $contents;
	
	include "../../config.inc.php";
	include "functionsDebt.inc.php";
	include "config_report.inc.php";
	
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	
	$espanol = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$ingles = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

?>


<table>
	<tr>
		<td>DIA</td>
		<td>MES</td>
		<td>A&Ntilde;O</td>
		<td>Mes/A&ntilde;o</td>
		<td>FUENTE</td>
		<td>CL&Iacute;NICA</td>
		<td>ESTADO</td>
		<td>CIUDAD</td>
		<td>DOCTOR</td>
		<td>DOC-ESP</td>
		<td># Sx</td>
		<td># Px</td>
		<td>PACIENTE</td>
		<td>Tx</td>
		<td>ESPECIALIDAD</td>
		<td>HORA INICIO</td>
		<td>HORA FIN</td>
		<td>CLIENTE</td>
		<td>SUB CLIENTE</td>
		<td>PRECIO</td>
		<td>DESCUENTO</td>
		<td>CO-PAGO</td>
		<td>AHORRO</td>
		<td>COSTO x Tx</td>
		<td>UTILIDAD</td>
		<td>VALIDACI&Oacute;N ESP</td>
		<td>CUENTA PACIENTE</td>
		<td>POR PAGAR</td>
		<td>SEXO</td>
		<td>TEL PACIENTE</td>
		<td>FECHA NACIMIENTO Px</td>
		<td>POLIZA</td>
	</tr>
	
	
	
	<?php 
		$sql = "SELECT trs.trs_id, c.cli_name as CLINICA, pat.pat_complete as PACIENTE, s.ses_date AS FECHA, emp.emp_complete AS DOCTOR, s.emp_id as EMP_ID, stt.stt_name AS ESTADO,
				agr.agr_name as CONVENIO, com.com_name AS COMPANIA, trt.trt_name AS TRATAMIENTO, trs.trp_price AS PRECIO, trs.agt_discount AS DESCUENTO,
				trs.trs_amount AS MONTO, spc.spc_name AS TRT_ESP, spc.spc_id AS TRTSPC_ID, GROUP_CONCAT(CONCAT_WS(' ', tel.tel_number, CONCAT('(',tlt.tlt_name,')')) SEPARATOR ',') as TELEFONOS,
				pat.pat_ndate as NACIMIENTO, s.ses_ini as INICIO, s.ses_end AS FIN, pat.insurance_num AS POLIZA
				FROM kobemxco_red.session s
				LEFT JOIN (kobemxco_red.clinic c
				           LEFT JOIN kobemxco_red.state stt
				           ON stt.stt_id = c.stt_id)
				ON s.cli_id = c.cli_id
				LEFT JOIN (kobemxco_red.patient pat
				           LEFT JOIN (kobemxco_red.agreement agr
				                      LEFT JOIN kobemxco_red.company com
				                      ON agr.com_id = com.com_id
				                      )
				           ON agr.agr_id = pat.agr_id
				           LEFT JOIN (kobemxco_red.telephone tel
				                      LEFT JOIN kobemxco_red.teltype tlt
				                      ON tel.tlt_id = tlt.tlt_id
				                       )
				           ON tel.pat_id = pat.pat_id
				           )
				ON pat.pat_id = s.pat_id
				LEFT JOIN kobemxco_red.employee emp
				ON emp.emp_id = s.emp_id
				LEFT JOIN (kobemxco_red.treatsession trs
				                        LEFT JOIN (kobemxco_red.treatment trt
				                                    LEFT JOIN kobemxco_red.speciality spc
				                                    ON spc.spc_id = trt.spc_id)
				                        ON trs.trt_id = trt.trt_id)
				ON s.ses_number = trs.ses_number AND s.cli_id = trs.cli_id
				WHERE s.ses_date BETWEEN '{$_GET['fi']}' AND '{$_GET['ff']}'
				GROUP BY s.ses_id, trs.trs_id;";
// 		echo $sql;
		$rs = mysql_query($sql,$link);
		//die(mysql_error());
		while($row=@mysql_fetch_assoc($rs)){
			$drSpcArr = array();
			$drSpcIdArr = array();
			$drSpc = "";
			$drSpcId = "";
			
			$sql2 = "SELECT r2.* FROM (
					SELECT r.* FROM (
					SELECT eps.emp_id, eps.pst_id, spc.spc_id, spc.spc_name, eps.eps_active, eps.eps_date
					FROM kobemxco_red.emppost eps
					LEFT JOIN (kobemxco_red.post pst
					          LEFT JOIN kobemxco_red.speciality spc
					          ON pst.spc_id = spc.spc_id
					          )
					ON eps.pst_id = pst.pst_id
					WHERE eps.emp_id = ".$row["EMP_ID"]."
					ORDER BY eps.eps_date DESC
					) as r
					GROUP BY r.spc_id
					) as r2
					WHERE r2.eps_active = 1";
			
			$rs2 = @mysql_query($sql2, $link);
			if(@mysql_num_rows($rs2) > 0){
				while($row2 = @mysql_fetch_assoc($rs2)){
					$drSpcArr[] = $row2["spc_name"];
					$drSpcIdArr[] = $row2["spc_id"];
				}
				
				$drSpc = implode(", ", $drSpcArr);	
			}
			
			$fecha = new DateTime($row["FECHA"]);
			$dia = $fecha->format("d");
			$mes = str_replace($ingles, $espanol, $fecha->format("F"));
			$anio = $fecha->format("Y");
			$copago = ($row["PRECIO"] - (($row["PRECIO"]*$row["DESCUENTO"])/100));
			$ahorro = $row["PRECIO"] - $copago;
			
			$validaEsp = (in_array($row["TRTSPC_ID"], $drSpcIdArr)) ? 1 : 0;
			
			echo "<tr>
					<td>".$dia."</td>
					<td>".substr($mes,0,3)."</td>
					<td>".$anio."</td>
					<td>".substr($mes,0,3)."-".substr($anio,-2)."</td>
					<td></td>
					<td>".$row["CLINICA"]."</td>
					<td>".$row["ESTADO"]."</td>
					<td></td>
					<td>".$row["DOCTOR"]."</td>
					<td>".$drSpc."</td>
					<td></td>
					<td></td>
					<td>".$row["PACIENTE"]."</td>
					<td>".$row["TRATAMIENTO"]."</td>
					<td>".$row["TRT_ESP"]."</td>
					<td>".$row["INICIO"]."</td>
					<td>".$row["FIN"]."</td>
					<td>".$row["COMPANIA"]."</td>
					<td>".$row["CONVENIO"]."</td>
					<td>".$row["PRECIO"]."</td>
					<td>".$row["DESCUENTO"]."</td>
					<td>".$copago."</td>
					<td>".$ahorro."</td>
					<td></td>
					<td></td>
					<td>".$validaEsp."</td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$row["TELEFONOS"]."</td>
					<td>".$row["NACIMIENTO"]."</td>
					<td>".$row["POLIZA"]."</td>
				</tr>";
			
		}
	?>
</table>