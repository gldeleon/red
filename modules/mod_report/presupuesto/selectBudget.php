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
        <b style="font-size: 24px;"> Actualizar Presupuesto </b>
        <?php
        $pat_id = $_GET["pat_id"];
        ?>
        <form name="form" method="GET" action="submit.php?pat_id=pat&agr_id=new_agr_id">
            <?php
            $pat_id = $_GET["pat_id"];

            $query = mysql_query("SELECT DISTINCT budget.cli_id, budget.bud_number, budtreat.trt_id, clinic.cli_name FROM kobemxco_red.budget
                                   NATURAL JOIN kobemxco_red.budtreat
                                   NATURAL JOIN kobemxco_red.clinic
                                   WHERE budget.pat_id= '" . $pat_id . "';", $link);
            if (!$query)
                echo "No se encontraron resultados en la base de datos";
            ?>
            <br></br>
            <center>
                <table border ='0' cellspacing="0" cellpadding="0">
                    Seleccione el Presupuesto
                    <br></br>
                        <tr  align="center">
                            <th><output/>Numero de Presupuesto</th>
                            <th><output/>Clinica</th>
                        </tr>
                        <?php
                    while ($row = mysql_fetch_array($query)) {
                        echo '<td  align="center">';
                        ?>
                        <a href="editBud.php?trt_id=<?php echo @$result[] = @$row['trt_id']; ?>&cli_id=<?php echo @$result[] = @$row['cli_id']; ?>&bud_number=<?php echo @$result[] = @$row['bud_number']; ?>"><?php echo @$result[] = @$row['trt_id'] ?></a>
                        <td>
                            <output><?php echo @$result[] = @$row['cli_name']; ?></output>
                        <?php
                        echo '</tr>';
                        }
                        ?>
                </table>
            </center>
        </form>
        <br />
    </body>
</html>