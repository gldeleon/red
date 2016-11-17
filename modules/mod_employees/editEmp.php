<?php
	include_once "data.php";
	include_once "../../functions.inc.php";
	$empid = (isset($_GET["id"]) && !empty($_GET["id"])) ? $_GET["id"] : "1";
	$uid = (isset($_GET["uid"]) && !empty($_GET["uid"])) ? $_GET["uid"] : "1";
	$alta = (isset($_GET["alta"]) && !empty($_GET["alta"])) ? $_GET["alta"] : "0";
	$data = new data();
	$empData = $data->getEmployeeInfo($empid);
	$cli = $psts = "";
	$sameCli = "";
	$samePst = array();

	for($i=0; $i<count($empData); $i++){

	    list($emp_complete, $emp_tel, $emp_cel, $emp_email, $emp_surename, $emp_lastname, $emp_name, $cli_name, $cli_id) = explode("*", $empData[$i]);



	    if($sameCli != $cli_id){


	        $cli .= "<p><label style='-moz-border-radius:5px; border: #FFFFFF 1px solid; background: #ABD9E9; padding:3px;'>".ucwords(lowercase($cli_name, true));
	        $cli .= " <input type='hidden' value='{$cli_id}' name='existingClinic' /><img src=\"img/delete_icon.gif\" id='{$cli_id}' style=\"cursor:pointer;\" class=\"deleteClinica\"/></label></p>";

	        $sameCli = $cli_id;

	    }

	    if($alta != 1){
	        $posts = $data->getEmpPosts($empid);
	    }
	    else{
	        $posts = $data->getLastEmpPosts($empid);
	    }

	    for($j=0; $j<count($posts); $j++){

	            list($pst_name, $pst_id) = explode("*", $posts[$j]);

	                if(!in_array($pst_id, $samePst) && $pst_id != null){
	                    $psts .= "<p><label style='-moz-border-radius:5px; border: #FFFFFF 1px solid; background: #ABD9E9; padding:3px;'>".ucwords(lowercase($pst_name, true));
	                    $psts .= " <input type='hidden' value='{$pst_id}' name='existingPost' /><img src=\"img/delete_icon.gif\" id='{$pst_id}' style=\"cursor:pointer;\" class=\"deletePuesto\" /></label></p>";
	                }
	                array_push($samePst, $pst_id);

	    }


	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Alta de Doctores</title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/css.css" type="text/css" />
	<script type='text/javascript' src='js/prototype.js'></script>
	<script type='text/javascript' src='js/scriptaculous-js-1.8.3/src/scriptaculous.js'></script>
	<script type='text/javascript' src='js/lightview.js'></script>
	<link rel="stylesheet" type="text/css" href="css/lightview.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/js.js"></script>
</head>
<body style="background:#FFFFFF; overflow: auto; overflow-x: hidden;">

<input type="hidden" value="<?=$empid; ?>" id="emp"/>
<input type="hidden" value="<?=$uid; ?>" id="uid" />
<input type="hidden" value="<?=$alta; ?>" id="alta" />
<div style="padding-left:5px; margin-top:20px;">
                    <table id="altaTable" cellspacing="2" cellpadding="2" border="0">
                        <tr>
                            <td width="150" class="labelitem">Apellido Paterno:</td><td colspan="2" width="200"><input type="text" id="lastname" value="<?=ucwords(lowercase($emp_lastname,true)); ?>" /></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Apellido Materno:</td><td colspan="2" width="200"><input type="text" id="surename" value="<?=ucwords(lowercase($emp_surename,true)); ?>"/></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Nombre(s):</td><td colspan="2" width="200"><input type="text" id="name" value="<?=ucwords(lowercase($emp_name,true)); ?>"/></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Tel&eacute;fono:</td><td colspan="2" width="200"><input type="text" id="phone" value="<?=$emp_tel; ?>"/> </td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Celular:</td><td colspan="2" width="200"><input type="text" id="cel" value="<?=utf8_encode($emp_cel); ?>"/> </td>
                        </tr>
                        <tr>
                            <td valign="top" width="150" class="labelitem">Cl&iacute;nica(s):</td>
                            <td valign="top" id="clinicas" width="200">
                                <input type="button" class="large" value="Atiende En..." id="agregarClinica" />
                                <br/>
                                <?=$cli; ?>

                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="150" class="labelitem">Puesto(s):</td>
                            <td id="puestos" colspan="2" width="200">
                                <input type="button" class="large" value="Agregar Puesto" id="agregarPuesto" />
                                <br/>
                                <?=$psts; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding-top: 10px;" align="center">
                                <?php
                                if($alta == 0){ ?>
                                    <input id="editar" type="button" value="Editar" />
                                <?php

                                }else{
                                ?>
                                    <input id="editar" class="large" type="button" value="Reactivar" />
                                <?php
                                }
                                ?>
                            </td>

                        </tr>
                    </table>
            </div>

</body>
</html>
