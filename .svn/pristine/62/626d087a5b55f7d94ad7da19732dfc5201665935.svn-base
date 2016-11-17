
<?php
//*** Llama los archivos de configuracion y funciones.
 header('Content-Type: text/html; charset=iso-8859-1');
include "../../../config.inc.php";
$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte de Red</title>
        <link rel="stylesheet" type="text/css" href="../../components/jscalendar/calendar.css" />
        <script type="text/javascript" src="../../components/jscalendar/calendar.js"></script>
        <script type="text/javascript" src="../../components/jscalendar/lang/calendar-es.js"></script>
        <script type="text/javascript" src="../../components/jscalendar/calendar-setup.js"></script>
        <link rel="stylesheet" href="mod_report.css" type="text/css" />
        <script type='text/javascript' src='js/prototype.js'></script>
        <script type='text/javascript' src='js/scriptaculous-js-1.8.3/src/scriptaculous.js'></script>
        <script type='text/javascript' src='js/lightview.js'></script>
        <link rel="stylesheet" type="text/css" href="css/lightview.css" />

        
        <style type="text/css">
            table, td, th
            {
                border:1px solid #E6701D;
            }
            th
            {
                background-color:#E6701D;
                color:white;
            }
            td
            {
                background-color:#FFD773;
                color:black;
            }
        </style>
    </head>

    <body bgcolor="#666666" text="white">
        <b style="font-size: 14px;">Cambiar valor</b>
                
        <br></br>
        
        <?php
        $agr_id = $_GET["new_agr_id"];
        $pat_id = $_GET["pat"];
        $clc_id = $_GET["new_clc_id"];

        $query = mysql_query("UPDATE kobemxco_red.patient SET agr_id = " . $agr_id . ", clc_id =" . $clc_id . "  WHERE pat_id = '$pat_id';", $link);
        if (!$query)
            echo "\n No se Pudo Realizar la Operacion intente de nuevo";

        else {
            echo "\n Exito";
            
        }
        ?>

    </body>
</html>