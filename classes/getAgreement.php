<?php
if (!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
    exit();
session_name("pra8atuw");
session_start();
if (count($_SESSION) > 0)
    extract($_SESSION);
else {
    $_SESSION = array();
    session_destroy();
    header("Location: logout.php");
}

/** Llama al archivo de configuracion. */
include "../config.inc.php";

/** Establece la zona horaria para trabajar con fechas. */
date_default_timezone_set("America/Mexico_City");

/** Carga variables URL y determina sus valores iniciales. */
$agr = (isset($_GET["agr"]) && !empty($_GET["agr"])) ? $_GET["agr"] : "0";
$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
$ref = $_SERVER['HTTP_REFERER'];

/** Obtiene un objeto de conexion con la base de datos. */
$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

$agrname = "NOMBRE DEL CONVENIO";
$company = "Nombre de la Empresa";
$agrdesc = $agrreqs = "Cargando...";
$agrtype = "Plan";
$query = "select a.agr_id, a.com_id, a.usr_id, a.atp_id, a.agl_id, a.agr_name,
	a.agr_desc, a.agr_reqs, a.agr_ini, a.agr_end, a.emp_id, c.com_name, t.atp_name,
	g.agl_name from {$DBName}.agreement as a
	left join {$DBName}.company as c on c.com_id = a.com_id
	left join {$DBName}.agreetype as t on t.atp_id = a.atp_id
	left join {$DBName}.agreeclass as g on g.agl_id = a.agl_id
	where a.agr_id = {$agr} limit 1";
if ($result = @mysql_query($query, $link)) {
    $row = @mysql_fetch_array($result, MYSQL_ASSOC);
    $agrtype = (strpos(utf8_encode($row["agl_name"]), "PLAN") === false) ? "Convenio" : "Plan";
    $agrname = strtoupper(utf8_encode($row["agr_name"]));
    $company = strtoupper(utf8_encode($row["com_name"]));
    $agrdesc = utf8_encode($row["agr_desc"]);
    $agrreqs = utf8_encode($row["agr_reqs"]);
    @mysql_free_result($result);
}

/** Obtiene los permisos GLOBALES del usuario. */
$admin = intval($p{2});
$write = intval($p{1});
$reead = intval($p{0});
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $AppTitle; ?></title>
        <link href="../red.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            /* [CDATA[ */
            var cli = "<?= $cli; ?>";
            /* ]] */
        </script>
        <script type="text/javascript" src="../modules/ajax.js"></script>
        <script type="text/javascript" src="../modules/createMenu.js"></script>
        <script type="text/javascript" src="../modules/getAgreement.js"></script>
        <script type="text/javascript" src="../modules/newPatientDialog.js"></script>
    </head>
    <body>

        <div id="subMenu" style="position: absolute; visibility: hidden;"></div>
        <? include "newPatient.inc.php"; ?>
        <form name="f">
            <div id="cfg" style="display: none"><?= $uid; ?></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
                    <td id="pTd">Administrar <?= $agrtype; ?> (<?= $agrname; ?>)</td>
                    <td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" id="m">
                        <div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
                            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                <tr>
                                    <td width="140" class="labelitem">Empresa:</td>
                                    <td width="400" class="newEditItem"><?= $company; ?></td>
                                    <td width="100%" class="newEditItem">Tratamientos y Descuentos</td>
                                </tr>
                                <tr>
                                    <td class="labelitem">Descripci&oacute;n:</td>
                                    <td>
                                        <div id="agreeDesc" style="font-size: 12px; text-align: justify; overflow-y: scroll; width: 394px; height: 120px; border: 1px solid #ABD9E9; padding: 3px;">
                                            <?= nl2br($agrdesc); ?></div></td>
                                    <td rowspan="4" align="left" valign="top">
                                        <iframe id="agreeTreatList" frameborder="0" width="90%" height="302" src="agrTreatList.php?agr=<?= $agr; ?>&clic=<?= $cli ?>"></iframe>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="labelitem">Requisitos:</td>
                                    <td><div id="agreeReqs" style="font-size: 12px; text-align: justify; overflow-y: scroll; width: 394px; height: 50px; border: 1px solid #ABD9E9; padding: 3px;"><?= $agrreqs; ?></div></td>
                                </tr>
                                <tr>
                                    <td class="labelitem">Beneficiarios:</td>
                                    <td><div id="beneficiaries">
                                            <?
                                            $query = "select pat_id, pat_complete from {$DBName}.patient
				where agr_id = {$agr} order by pat_complete";
                                            $result = @mysql_query($query, $link);
                                            while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
                                                echo "<div id=\"" . strtoupper(utf8_encode($row["pat_id"])) . "\" class=\"filterResult\" onclick=\"selectPatient(this, 'patid', 'patient')\">";
                                                echo strtoupper(utf8_encode($row["pat_complete"]));
                                                echo "</div>\n";
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../images/spacer.gif" width="145" height="1" /></td>
                                    <td align="left" valign="top">
                                        <input id="patid" name="patid" type="hidden" value="" />
                                        <input type="text" name="patient" id="patient" style="font-size: 12px; width: 240px; border: 1px solid #ABD9E9;" onclick="this.select()" readonly="readonly" />
                                        <input type="button" value="Agendar" onclick="setNewVisit('patid', 'patient');" />
                                        <input type="button" value="Sesi&oacute;n" onclick="startNewSession('patid', 'patient', '<?= $e; ?>');" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
                    <td class="wtbottom">&nbsp;</td>
                    <td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
                </tr>
            </table>
        </form>

    </body>
</html>