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
        <center>
            <?php
            $pat_id = $_GET["pat_id"];
            ?>
            <form name="form" method="GET" action="submit.php?pat_id=pat&agr_id=new_agr_id&clc_id=new_clc_id">
                <?php
                $pat_id = $_GET["pat_id"];

                $query = mysql_query("SELECT * FROM kobemxco_red.patient WHERE pat_id='" . $pat_id . "';", $link);
                //  $query = mysql_query("UPDATE kobemxco_red.patient SET agr_id = ".$agr." WHERE pat_id = ".$pat_id.";", $link);
                if (!$query)
                    echo 'No se encontraron resultados en la base de datos';
                while ($row = mysql_fetch_array($query)) {
                    //$result = $row['pat_id'];
                    //$result = $row['pat_complete'];
                    //echo $result = $row['clc_id'];
                    //echo "Quisres modificar el campo del Paciente " . $result = $row['pat_complete']."\n";
                    //echo "<br> El Valor de su agr es = " . $result1 = $row['agr_id'];
                    ?>
                    </br>
                    <output name="nombre" type="text" id="nombre"/>
                    </br>
                    Escribe el nuevo valor a cambiar del paciente: 
                    <input name="pat" type="hidden" id="pat" redonly="redonly" value="<?php echo$result = $row['pat_id'] ?>"><?php echo$result = $row['pat_complete'] ?></input>
                    </br>
                    AGR actual
                    <output name="agr" type="text" id="agr"><?php echo$result = $row['agr_id'] ?></outtput>
                    <br></br>
                        Nuevo AGR
                        <input name="new_agr_id" type="text" id="enviar"/>
                        </br>
                        Clinica
                        <input name="new_clc_id" type="text" value="<?php echo $result = $row['clc_id'] ?>"></input>
                        <br></br>
                        <input name="enviar" type="submit" id="enviar" value="Actualizar"/>
                        <?php
                    }
                    ?>
            </form>
            <br />
        </center>
    </body>
</html>