<?php
	$emplist = $data->empList();
	$tablaEmp = "";
	$empNom = "";
	for($i=0; $i<count($emplist); $i++){
	    list($emp_id, $emp_complete, $emp_email) = explode("*", $emplist[$i]);

	    $posts = $data->getEmpPosts($emp_id);
	    $tdColor = $i+1;
	    if($tdColor%2 == 0){
	        $tablaEmp .= "<tr bgcolor='#FFD773'>";
	    }
	    else{
	        $tablaEmp .= "<tr bgcolor='#FFFFFF'>";
	    }

	    $tablaEmp .= "    <td align='center'>".($i+1)."</td>
	                      <td align='left'><a href='empInfo.php?id={$emp_id}' style='text-decoration:underline' class='lightview' rel='iframe' title='Informaci&oacute;n del empleado ::  :: width: 580, height: 600'>".ucwords(lowercase($emp_complete, true))."</a></td>
	                      <td align='left'>";

	                      for($j=0; $j<count($posts); $j++){

	                          list($pst_name, $pst_id) = explode("*", $posts[$j]);
	                          $tablaEmp .= ucwords(lowercase($pst_name, true))."<br/>";

	                      }

	    $tablaEmp .= "</td>
	                      <td align='center'><a href='editEmp.php?id={$emp_id}&uid={$uid}' class='lightview' rel='iframe' title='Editar Informaci&oacute;n del empleado ::  :: width: 580, height: 600'><img style='cursor:pointer;' src='img/icon-edit.gif' alt='Editar' title='Editar' border='0'/></a></td>
	                      <td align='center'><img style='cursor:pointer;' class='deleteEmp' id='{$emp_id}' src='img/delete.png' alt='Baja' title='Baja'/></td>
	                  </tr>";


	}
?>
<div id="sessHeader" style="position: fixed; left: 1px; width: 97%; background: #FFFFFF;">
<table align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td class="btnHeader<?=(($section == "1") ? " btnHeaderOver" : ""); ?>"><a href="?section=1" target="_self">Lista de Doctores</a></td>
	<td class="btnHeader<?=(($section == "2") ? " btnHeaderOver" : ""); ?>"><a href="?section=2" target="_self">Alta</a></td>
	<td class="btnHeader<?=(($section == "3") ? " btnHeaderOver" : ""); ?>"><a href="?section=3" target="_self">Baja</a></td>
</tr>
</table>
</div>
<div style="padding-left:20px; margin-top:50px;">
	<h1 style="text-align: center; font-size:15px;color:#084C9D;">Lista de Doctores (Activos)</h1>
	<table id='tabla_empleados' cellspacing='2' cellpadding='4'>
	<tr>
		<th>#</th><th>Nombre del Doctor</th>
		<th>Especialidad(es)</th>
		<th>Editar</th>
		<th>Baja</th>
	</tr>
	<?=$tablaEmp; ?>
	</table>
	<br/><br/>
</div>