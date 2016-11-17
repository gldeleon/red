
<?php
//*** Llama los archivos de configuracion y funciones.
include "../../../config.inc.php";
 header('Content-Type: text/html; charset=iso-8859-1');
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
        <?php
        $pat = $_POST["nombre"];
        $pat_id;

        $query = mysql_query("SELECT pat_id, pat_complete FROM kobemxco_red.patient WHERE pat_complete LIKE '%" . $pat . "%' ORDER BY pat_complete;", $link);

        if (!$query)
            echo 'No se encontro algun nombre parecido al que indico';
        ?>
        <table border ='0'>
            <?php
            while ($row = mysql_fetch_array($query)) {
                echo '<td>';
                ?>
                <a href="editPatient.php?pat_id=<?php echo @$result[] = @$row['pat_id']; ?>"><?php echo @$result[] = @$row['pat_complete'] ?></a>
                <?php
                echo '</tr>';
            }
//$result[] = $row['pat_complete'] 
            //echo "<pre>".print_r($result, TRUE)."</pre>";
            //echo "Se encontraron " . count($result) . "Resultados";
            ?>
        </table>
    </body>
</html>
