
<?php
//*** Llama los archivos de configuracion y funciones.
 header('Content-Type: text/html; charset=iso-8859-1');
include "../../../config.inc.php";
$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
?>
        <?php
        echo $btr_id = $_GET["btr_id"];
        echo $agt_discount = $_GET["agt_discount"];
        echo $trs_amount = $_GET["trs_amount"];
        
        $query = mysql_query("UPDATE kobemxco_red.budtreat SET agt_discount = ". $agt_discount.", trs_amount = ". $trs_amount."  WHERE btr_id = '$btr_id';", $link);
        if (!$query)
            echo "\nNo se Pudo Realizar la Operacion intente de nuevo";

        else {
            echo "\nexito";
            
        }
        ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<!-- <META HTTP-EQUIV="Refresh" CONTENT="8; URL=http://red.kobe.com.mx/modules/mod_report/presupuesto/searchName.php"> -->
		<!-- <a href="javascript:closeWindow();">Close Window</a> -->
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
        <script >
function cerrar() {
ventana=window.parent.self;
ventana.opener=window.parent.self;
ventana.close();
}

</script>

<script>
var StayAlive = 2; // Number of seconds to keep window open
function KillMe(){
setTimeout("self.close()",StayAlive);
}
</script>
		<script>killMe()</script>  

    </head>

    <body bgcolor="#666666" text="white" onload="cerrar()">
        <b style="font-size: 14px;">Cambiar valor</b>
                
        <br></br>


    </body>
</html>