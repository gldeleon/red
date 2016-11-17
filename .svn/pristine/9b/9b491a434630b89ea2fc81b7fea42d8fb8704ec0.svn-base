<?php
	include_once "data.php";
	include_once "../../functions.inc.php";
	$empid = (isset($_GET["id"]) && !empty($_GET["id"])) ? $_GET["id"] : "1";
	$data = new data();
	$empData = $data->getEmployeeInfo($empid);
	$cli = $psts = "";
	$sameCli = "";
	$samePst = array();

	for($i=0; $i<count($empData); $i++){

	    list($emp_complete, $emp_tel, $emp_cel, $emp_email, $emp_surename, $emp_lastname, $emp_name, $cli_name, $cli_id) = explode("*", $empData[$i]);

	    if($sameCli != $cli_id){
	        $cli .= "<p><label style='-moz-border-radius:5px; border: #FFFFFF 1px solid; background: #ABD9E9; padding:3px;'>".ucwords(lowercase($cli_name, true));
	        $cli .= " </label></p>";

	        $sameCli = $cli_id;
	    }
	    $posts = $data->getEmpPosts($empid);
		//$posts = $data->getLastEmpPosts($empid);

	    for($j=0; $j < count($posts); $j++) {
            list($pst_name, $pst_id) = explode("*", $posts[$j]);
			if(!in_array($pst_id, $samePst) && $pst_id != null){
				$psts .= "<p><label style='-moz-border-radius:5px; border: #FFFFFF 1px solid; background: #ABD9E9; padding:3px;'>".ucwords(lowercase($pst_name, true));
				$psts .= " </label></p>";
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
<body style="background:#FFFFFF; overflow: auto; overflow-x:hidden;">

<input type="hidden" value="<?=$empid; ?>" id="emp"/>
<div style="padding-left:5px; margin-top:20px;">
                    <table id="altaTable" cellspacing="2" cellpadding="2">
                        <tr>
                            <td width="150" class="labelitem">Apellido Paterno:</td><td width="200"><?=ucwords(lowercase($emp_lastname,true)); ?></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Apellido Materno:</td><td width="200"><?=ucwords(lowercase($emp_surename,true)); ?></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Nombre(s):</td><td width="200"><?=ucwords(lowercase($emp_name,true)); ?></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Tel&eacute;fono:</td><td width="200"><?=$emp_tel; ?></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Celular:</td><td width="200"><?=utf8_encode($emp_cel); ?></td>
                        </tr>
                        <tr>
                            <td valign="top" width="150" class="labelitem">Cl&iacute;nica(s):</td>
                            <td valign="top" id="clinicas" width="200">
                                Atiende en la(s) Cl&iacute;nica(s):
                                <?=$cli; ?>

                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="150" class="labelitem">Especialidad(es):</td>
                            <td id="puestos">
                                <?=$psts; ?>
                            </td>
                        </tr>
                    </table>
            </div>
</body>
</html>
