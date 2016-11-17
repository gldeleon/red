<?php
$emplist = $data->empList(0,0,0);
$tablaEmp = "";
$empNom = "";
for($i=0; $i<count($emplist); $i++){

    list($emp_id, $emp_complete, $emp_email) = explode("*", $emplist[$i]);


    $posts = $data->getLastEmpPosts($emp_id);
    $tdColor = $i+1;
    if($tdColor%2 == 0){
        $tablaEmp .= "<tr bgcolor='#FFD773'>";
    }
    else{
        $tablaEmp .= "<tr bgcolor='#FFFFFF'>";
    }

    $tablaEmp .= "<td align='center'>".($i+1)."</td>
                      <td align='left'>".ucwords(lowercase($emp_complete, true))."</td>
                      <td align='left'>";

                      for($j=0; $j<count($posts); $j++){

                          list($pst_name, $pst_id) = explode("*", $posts[$j]);
                          $tablaEmp .= ucwords(lowercase($pst_name, true))."<br/>";

                      }

    $tablaEmp .= "    </td>
                      <td align='center'><a href='editEmp.php?id={$emp_id}&uid=1&alta=1' class='lightview' rel='iframe' title='Editar Informaci&oacute;n del empleado ::  :: width: 580, height: 600'><img style='cursor:pointer;' src='img/icon-edit.gif' alt='Editar' title='Alta' border='0'/></a></td>
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
	<h1 style="text-align: center; font-size:15px; color:#F00;">Lista de Doctores (Inactivos)</h1>
	<table id='tabla_empleados' cellspacing='2' cellpadding='4'>
	<tr>
		<th>#</th><th>Nombre del Doctor</th>
		<th>Especialidad(es)</th>
		<th>Editar</th>
	</tr>
	<?=$tablaEmp; ?>
	</table>
	<br/><br/>
</div>