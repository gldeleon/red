<?php
	$pat = isset($pat) ? $pat : "";
?>
<div id="newEditWindow" style="left: 0px; top: 100px; visibility: hidden">
<form name="ne">
<input type="hidden" name="visitid" id="visitid" value="" />
<input type="hidden" name="empid" id="empid" value="" />
<input type="hidden" name="patid" id="patid" value="<?=$pat; ?>" />
<input type="hidden" name="cid" id="cid" value="" />
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf_f1y2" style="border-left: 1px solid #811E53;">&nbsp;</td>
	<td class="pTd_f" style="width: 450px;">Agregar/Modificar Cita</td>
	<td class="outf_f1y2" style="border-right: 1px solid #811E53;">&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="center" id="mWindow" style="border-left: 1px solid #811E53;">
	<table width="400" border="0" cellspacing="0" cellpadding="0" align="right">
	<tr>
		<td width="100" class="newEditItem">Doctor:</td>
		<td width="280" style="text-align: left">
		<select name="doctor" id="clidoc" onchange="setInputValue(this, this.id)">
			<option value="0">----</option>
		<?
			$query = "select e.emp_id, e.emp_complete from ".$DBName.".empclinic as ec
			left join ".$DBName.".employee as e on e.emp_id = ec.emp_id
			left join {$DBName}.emppost as ep on ep.emp_id = ec.emp_id
			where e.emp_active = 1 and ep.pst_id in (25, 26, 27, 28, 29, 30, 31, 38, 41)
			and ec.cli_id = ".$cli." group by e.emp_id order by e.emp_complete";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result)) {
					echo "<option value=\"".$row[0]."\">".uppercase($row[1])."</option>";
				}
				@mysql_free_result($result);
			}
		?>
		</select>
		</td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Paciente:</td>
		<td style="text-align: left"><input type="text" name="patient" id="patient" value="<?=$patcomp; ?>" /></td>
		<td width="20">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align: right;"><input type="button" class="large" style="margin-right: 10px;" value="Nuevo paciente" onclick="showNewPatientDialog('patient', 'patid');" /></td>
		<td width="20">&nbsp;</td>
	</tr>
	<tr>
		<td class="newEditItem">Fecha:</td>
		<td style="text-align: left"><input type="text" name="visitd" id="visitd" style="width: 120px" value="<?=date("d/m/Y"); ?>" /></td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Hora Inicial:</td>
		<td style="text-align: left"><select name="ihour" id="ihour" style="width: 40px">
		<?
			for($i = 0; $i < 24; $i++)
				echo "<option value=\"".$i."\">".((strlen($i) == 1) ? "0".$i : $i)."</option>\n";
		?>
		</select>
		<select name="iminute" id="iminute" style="width: 40px">
			<option value="0">:00</option>
			<option value="15">:15</option>
			<option value="30">:30</option>
			<option value="45">:45</option>
		</select>
		</td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Duraci&oacute;n:</td>
		<td style="text-align: left"><select name="vlength" id="vlength" style="width: 140px">
		<?
			$query = "select * from ".$DBName.".visitlength order by vln_id";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result))
					echo "<option value=\"".$row[0]."\">".$row[1]."</option>\n";
			}
		?>
		</select></td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Sill&oacute;n:</td>
		<td style="text-align: left"><select name="chair" id="chair" style="width: 40px">
		<?
			for($i = 1; $i <= $spaces; $i++)
				echo "<option value=\"".$i."\">".$i."</option>\n";
		?>
		</select>
		</td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Especialidad:</td>
		<td style="text-align: left"><select name="speciality" id="speciality" onchange="treatFilter(this, 'treatment')">
		<?
			$query = "select spc_id, spc_name from ".$DBName.".speciality where spc_id > 1 order by spc_id";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result))
					echo "<option value=\"".$row[0]."\">".utf8_encode($row[1])."</option>\n";
			}
		?>
		</select></td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Tratamiento:</td>
		<td style="text-align: left"><select name="treatment" id="treatment">
			<option value="0">----</option>
		<?
			$query = "select trt_id, trt_name from {$DBName}.treatment
			where spc_id = 2 and trt_active = 1 order by trt_name";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result))
					echo "<option value=\"".$row[0]."\">".utf8_encode($row[1])."</option>\n";
			}
		?>
		</select></td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	<tr>
		<td class="newEditItem">Observaciones:</td>
		<td style="text-align: left"><textarea name="desc" id="desc" cols="39" rows="3"></textarea></td>
		<td width="20"><img src="../images/spacer.gif" width="20" height="1" /></td>
	</tr>
	</table>
	</td>
	<td style="border-right: 1px solid #811E53;">&nbsp;</td>
</tr>
<tr>
	<td class="outf_f3y4" style="border-left: 1px solid #811E53;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom" style="border-bottom: 1px solid #811E53; border-top: 1px solid #811E53; text-align: right;">
	<input id="save" name="save" type="button" value="Guardar" onclick="saveVisit()" />&nbsp;
	<input id="cancel" name="cancel" type="button" value="Cancelar" onclick="cancelVisitEdit()" /></td>
	<td class="outf_f3y4" style="border-right: 1px solid #811E53;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>
</form>
</div>