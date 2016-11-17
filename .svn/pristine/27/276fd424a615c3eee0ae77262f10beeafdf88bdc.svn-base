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
        <b style="font-size: 24px;" >Actualizar Presupuesto</b>
        <center>
            <?php
            $trt_id = $_GET["trt_id"];
            $cli_id = $_GET["cli_id"];
            $bud_number = $_GET["bud_number"];
            $query = mysql_query("SELECT budget.cli_id, budget.bud_number, budtreat.trt_id, budtreat.trp_price,
                                         budtreat.agt_discount, budtreat.trs_amount, budtreat.btr_id	
                                  FROM kobemxco_red.budget
                                  NATURAL LEFT JOIN kobemxco_red.budtreat 
                                  NATURAL LEFT JOIN kobemxco_red.treatment
                                  WHERE (budget.cli_id = " . $cli_id . " AND budget.bud_number = " . $bud_number . ") AND budtreat.trt_id = " . $trt_id . ";", $link);
            if (!$query)
                echo 'No se encontraron resultados en la base de datos 1';
            ?>            
                <table border="0" cellspacing="0" cellpadding="5">
                    <tr  align="center">
                        <th><output/>Tratamiento</th>
                        <th><output/>Precio</th>
                        <th><output/>Descuento</th>
                        <th><output/>Total</th>
                        <th><output/></th>
                    </tr>
                    <tr></tr>
                    <?php
					$i=0;
                    while ($row = mysql_fetch_array($query)) {
                        ?>    
						<form name="form<?php echo $i?>" method="GET" action="update.php?btr_id=btr_id&agt_discount=agt_discount&trs_amount"  target="_blank" >
                    <td><output name="trp_price" type="text" id="trt_name2"/>
                            <?php
                            $query1 = mysql_query("SELECT treatment.trt_name FROM kobemxco_red.treatment WHERE trt_id=" . $trt_id . ";", $link);
                            if (!$query1)
                                echo 'No se encontraron resultados en la base de datos ahhh';
                            while ($row1 = mysql_fetch_array($query1)) {
                                echo $name = $row1['trt_name'];
                            }
                            ?>
                        </td>
                        <td><output name="trp_price" type="text" id="trt_name2" value="<?php echo @$result[] = @$row['trp_price']; ?>"/> $   <?php echo @$result[] = @$row['trp_price']; ?></td>
                        <td><input size="5" name="agt_discount" type="text" id="trt_name2" value="<?php echo @$result[] = @$row['agt_discount']; ?>" /></td>
                        <td><input size="5" name="trs_amount" type="text" id="trt_name2" value="<?php echo @$result[] = @$row['trs_amount']; ?>"/></td>
                        <td>
							<!-- <a href="update.php?btr_id=<?php echo @$result[]=@$row['btr_id']?>&agt_discount=<?php ?>&trs_amount=<?php ?>">Actualizar</a> -->
							<input name="enviar" type="submit" id="enviar" value="Actualizar"></input>							
                            <input name="btr_id" type="hidden" id="enviar" value="<?php echo @$result[] = @$row['btr_id']; ?>"/></td>
                        </tr>
                        </form>
						<?php
						$i++;
                    }
                    ?>
                </table>
            <br/>
        </center>
    </body>
</html>