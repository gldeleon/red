<?php
include_once "data.php";
$data = new data();
include_once "../../functions.inc.php";
$lastname = (isset($_GET['lastname']) && !empty($_GET['lastname'])) ? $_GET['lastname'] : "X";
$surename = (isset($_GET['surename']) && !empty($_GET['surename'])) ? $_GET['surename'] : "X";
$name = (isset($_GET['name']) && !empty($_GET['name'])) ? $_GET['name'] : "";
$phone = (isset($_GET['phone']) && !empty($_GET['phone'])) ? $_GET['phone'] : "(55) 0000-0000";
$cel = (isset($_GET['cel']) && !empty($_GET['cel'])) ? $_GET['cel'] : "044-55-0000-0000";
$clinic = (isset($_GET['clinic']) && !empty($_GET['clinic'])) ? $_GET['clinic'] : "";
$post = (isset($_GET['post']) && !empty($_GET['post'])) ? $_GET['post'] : "";
$usr_id = (isset($_GET['usr']) && !empty($_GET['usr'])) ? $_GET['usr'] : "";

$cli = explode("*", $clinic);
$puestos = explode("*", $post);
$complete = $name." ".$lastname." ".$surename;
$empclinicas = $emppuestos = $userclinicas = "";

for($i=0;$i<count($cli)-1;$i++){

    $clinica = $data->getClinic($cli[$i]);
    list($uno, $dos) = explode("*",$clinica[0]);
    $empclinicas .= ucfirst(lowercase($dos, true))."<br/>";

}

for($i=0;$i<count($puestos)-1;$i++){

    $pst = $data->getPost($puestos[$i]);
    list($uno, $dos) = explode("*",$pst[0]);
    $emppuestos .= ucfirst(lowercase($dos,true))."<br/>";

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Vista Previa</title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/css.css" type="text/css" />
	<script type='text/javascript' src='js/prototype.js'></script>
	<script type='text/javascript' src='js/scriptaculous-js-1.8.3/src/scriptaculous.js'></script>
	<script type='text/javascript' src='js/lightview.js'></script>
	<link rel="stylesheet" type="text/css" href="css/lightview.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/js.js"></script>
</head>
<body style="background-color: #FFF; overflow:auto;">
    <input type="hidden" value="<?=$lastname; ?>" id="lastname" />
    <input type="hidden" value="<?=$surename; ?>" id="surename" />
    <input type="hidden" value="<?=$name; ?>" id="name" />
    <input type="hidden" value="<?=$phone; ?>" id="phone" />
    <input type="hidden" value="<?=$cel; ?>" id="cel" />
    <input type="hidden" value="<?=$clinic; ?>" id="clinic" />
    <input type="hidden" value="<?=$post; ?>" id="post" />


<div id="emp_data" align="center" style="width:100%;">
    <h1 style="font-weight:bold; text-align:left; padding-left:10px;">Vista Previa.</h1>
    <p class="notice">
        Confirme que los datos del empleado son correctos; si es as&iacute; presione el bot&oacute;n <i>Alta</i>, o bien, si requiere
        hacer alguna modificaci&oacute;n, presione el bot&oacute;n <i>Regresar</i></p>
    <table id='datos_empleado' cellspacing='2' cellpadding='4'>
                <tr>
                    <th colspan='2'>Datos del Empleado</th>
                </tr>
                <tr>
                    <td class='titulo'>Empleado:</td><td><?=ucwords(lowercase($complete, true)); ?></td>
                </tr>
                <tr>
                    <td class='titulo'>Tel&eacute;fono:</td><td><?=$phone; ?></td>
                </tr>
                <tr>
                    <td class='titulo'>Celular:</td><td><?=$cel; ?></td>
                </tr>
                <tr>
                    <td class='titulo' valign='top'>Puesto(s):</td><td><?=$emppuestos; ?></td>
                </tr>
                <tr>
                    <td class='titulo' valign='top'>Atiende en la(s) Cl&iacute;nica(s):</td><td><?=$empclinicas; ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="hidden" value="<?=$usr_id; ?>" id="uid" />
                        <input type="button" id="alta" value="Alta" />
                        <input type="button" onclick="closeLightview()" value="Regresar" />
                    </td>
                </tr>
    </table>
</div>

</body>
</html>