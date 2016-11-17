<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lista de tratamientos y descuentos</title>
        <link type="text/css" rel="stylesheet" href="../red.css" />
        <style type="text/css">
            html, body {
                overflow-x: none;
                overflow-y: auto;
            }
            table, table td {
                border: 1px solid #E6701D;
            }
            td.hd {
                background-color: #FDB031;
                color: #FFF;
                padding: 5px;
            }
            td.hd2 {
                background-color: #E6701D;
                color: #FFF;
                text-align: center;
            }
            td.cant {
                text-align: center;
            }
        </style>
    </head>
    <body>

        <?php
        /** Llama al archivo de configuracion. */
        include "../config.inc.php";

        /** Establece la zona horaria para trabajar con fechas. */
        date_default_timezone_set("America/Mexico_City");

        /** Carga variables URL y determina sus valores iniciales. */
        $agr = (isset($_GET["agr"]) && !empty($_GET["agr"])) ? $_GET["agr"] : "0";
        $clic = (isset($_GET["clic"]) && !empty($_GET["clic"])) ? $_GET["clic"] : "1";
        if ($clic == 153) {
            $clic = 153;
        } else {
            $clic = 1;
        }
        /** Obtiene un objeto de conexion con la base de datos. */
        $link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

        $query = "select q.spc_name, q.trt_name, q.trp_price, q.agt_discount, q.copago
	from ( select t.spc_id, sp.spc_name, at.trt_id, t.trt_name,
	tp.trp_price, at.agt_discount, (tp.trp_price * (1 - (at.agt_discount / 100))) as copago
	from {$DBName}.agreetreat as at
	inner join {$DBName}.treatment as t on t.trt_id = at.trt_id and t.trt_active = 1
	left join {$DBName}.treatprice as tp on tp.trt_id = at.trt_id and tp.cli_class = {$clic}
	left join {$DBName}.speciality as sp on sp.spc_id = t.spc_id
	where agr_id = {$agr}
	order by tp.trp_date desc ) as q group by q.trt_id order by q.spc_id, q.trt_name";
        //echo $query;
        $tabla = "";
        if ($result = @mysql_query($query, $link)) {
            if (@mysql_num_rows($result) > 0) {
                $spc = "";
                $tabla = '<table cellspacing="0" cellpadding="0" border="0" width="100%">';
                while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
                    if ($spc != $row['spc_name']) {
                        $tabla .= '<tr><td colspan="4" class="hd">' . $row['spc_name'] . '</td></tr>';
                        $tabla .= '<tr>
					<td class="hd2">Nombre del Tratamiento</td>
					<td class="hd2" width="100">Precio</td>
					<td class="hd2" width="100">Descuento</td>
					<td class="hd2" width="100">Co-pago</td></tr>';
                        $spc = $row['spc_name'];
                    }
                    $tabla .= '<tr>
				<td>' . utf8_encode($row['trt_name']) . '</td>
				<td class="cant">$' . number_format($row['trp_price'], 0, '.', ',') . '</td>
				<td class="cant">' . $row['agt_discount'] . '%</td>
				<td class="cant">$' . number_format($row['copago'], 0, '.', ',') . '</td></tr>';
                }
                $tabla .= '</table>';
            }
        }
        echo (!$tabla) ? "No se encontr&oacute; informaci&oacute;n." : $tabla;
        ?>

    </body>
</html>