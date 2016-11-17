<?php

//die('que desea?');
echo "<p>Inicio del script</p>";

//define('DB_DENTALIA', 'dentalia');
//define('DB_RED', 'kobemxco_red');
###Para Produccion
//require_once dirname(__FILE__) . "/" . "../../dentalia3/Enumeration.php";
//require_once dirname(__FILE__) . "/" . "../../dentalia3/MySQLConnectionFailedException.php";
//require_once dirname(__FILE__) . "/" . "../../dentalia3/MySQLException.php";
//require_once dirname(__FILE__) . "/" . "../../dentalia3/MySQL.php";
//require_once dirname(__FILE__) . "/" . "../../dentalia3/RequestTypeEnum.php";
//require_once dirname(__FILE__) . "/" . "../../dentalia3/BadRequestException.php";
###Para Local
require_once dirname(__FILE__) . "/" . "../../dentalia3_mysql/Enumeration.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3_mysql/MySQLConnectionFailedException.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3_mysql/MySQLException.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3_mysql/MySQL.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3_mysql/RequestTypeEnum.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3_mysql/BadRequestException.php";

echo "<p>Fin de requires</p>";

ini_set('memory_limit', '560M');
echo "<p>Se pone la memoria</p>";
set_time_limit(65 * 60);
echo "<p>Se pone time limit de 60*60</p>";

$dbk = MySQL::getInstance('KOBE');
$dbd = MySQL::getInstance('DENT');

echo "<p>Instacia de conexi&oacute;n a BD</p>";
echo "<pre>" . print_r($db, TRUE) . "</pre>";
//Se regenera la tabla treatment
$sqlDeleteTrtRed = "TRUNCATE TABLE treatment;";

try {
	if ($dbk->query($sqlDeleteTrtRed)) {
		echo "<p>Se borran tratamientos de RED KOBE</p>";
		//Regeneramos tratamientos en red
		/* obtenemos los tratamientos para despues actualizar la tabla */
		//$sqlRegenerateTrt = "INSERT INTO " . DB_RED . ".treatment// traemos solo los activos ;)
		$sqlRegenerateTrt = "SELECT
                            trt.trt_id,
                            trt.usr_id,
                            trt.trt_name,
                            trt.trt_abbr,
                            trt.spc_id,
                            trt.trt_date,
                            trt.trt_minsess,
                            CASE
                                WHEN trt.trt_divsess = 'SI' THEN 1
                                ELSE 0
                            END AS trt_divsess,
                            CASE
                                WHEN trt.trt_active = 'ACTIVO' THEN 1
                                ELSE 0
                            END AS trt_active,
                            col.color_code AS trt_color,
                            trt.tcy_id,
                            IF(GROUP_CONCAT(DISTINCT SUBSTRING(td.thtdir_name, 1, 1)
                                    ORDER BY thtdir_name ASC
                                    SEPARATOR '') IS NULL,
                                '',
                                GROUP_CONCAT(DISTINCT SUBSTRING(td.thtdir_name, 1, 1)
                                    ORDER BY thtdir_name ASC
                                    SEPARATOR '')) AS trt_comb,
                            trt.trt_maxsess,
                            CASE
                                WHEN ts.stage_id IS NULL THEN 1
                                ELSE ts.stage_id
                            END AS stage_id
                        FROM
                            treatment trt
                                LEFT JOIN
                            color col ON col.color_id = trt.color_id
                                LEFT JOIN
                            trtstage ts ON ts.trt_id = trt.trt_id
                                LEFT JOIN
                            treatcomb tc ON tc.trt_id = trt.trt_id
                                LEFT JOIN
                            toothdirection td ON td.thtdir_id = tc.thtdir_id
                        WHERE
                            trt_active = 'ACTIVO'
                            AND red_kobe = 'SI'
                        GROUP BY trt.trt_id";
		//if ($dbd->query($sqlRegenerateTrt)) {
		/* comenzamos el ciclo para insertar los tratamientos */
		$result = $dbd->query($sqlRegenerateTrt);
		while ($row = $dbd->fetch($result)) {
			$queryInserta = "INSERT INTO treatment (trt_id, usr_id, trt_name, trt_abbr, spc_id, trt_date, trt_sess, trt_divsess, trt_active, trt_color, tcy_number, trt_comb, trt_maxsess, trt_bstage)"
					. "values(" . $row['trt_id'] . ", " . $row['usr_id'] . ", '" . $row['trt_name'] . "','" . $row['trt_abbr'] . "'," . $row['spc_id'] . ",'" . $row['trt_date'] . "'," . $row['trt_minsess'] . "," . $row['trt_divsess'] . "," . $row['trt_active'] . ",'" . $row['trt_color'] . "'," . $row['tcy_id'] . ",'" . $row['trt_comb'] . "'," . $row['trt_maxsess'] . "," . $row['stage_id'] . ")";
			$rs = $dbk->query($queryInserta);
		}
		/* termina el ciclo */
		if ($rs) {
			//Ahora vamos con los precios
			$sqlGetRedClinics = "SELECT cli_id FROM clinic";
			if (($clisRed = $dbk->query($sqlGetRedClinics)) && $dbk->count($clisRed) > 0) {

				//Por cada clínica, cargamos treatprice de general de dentalia
				while ($cliRed = $dbk->fetch($clisRed)) {
					$cli_class = $cliRed["cli_id"];
					/* traemos los precios e insertamos */
					$sqlDentaliaPrice = "SELECT r.trt_id," . $dbk->clean($cli_class) . ",r.trp_price, DATE(r.trp_date) AS trp_date,2 AS usr_id "
							. "FROM(SELECT * FROM treatprice WHERE clt_id = 2 ORDER BY trp_date DESC) AS r GROUP BY trt_id";
					//$sqlDentaliaPrice = "SELECT * FROM treatprice WHERE clt_id = 2 ORDER BY trp_date DESC";
//                    $sqlDentaliaPrice = "SELECT DISTINCT
//                                            r.trt_id,
//                                            " . $dbk->clean($cli_class) . ",
//                                            r.trp_price,
//                                            DATE(r.trp_date) AS trp_date,
//                                            2 AS usr_id
//                                        FROM
//                                            (SELECT DISTINCT
//                                                tp.trp_id,
//                                                    tp.trt_id,
//                                                    tp.clt_id,
//                                                    tp.trp_price,
//                                                    trp_date,
//                                                    tp.usr_id
//                                            FROM
//                                                treatprice tp
//                                            LEFT JOIN treatment tr ON tp.trt_id = tr.trt_id
//                                            WHERE
//                                                tp.clt_id = 2 AND tr.red_kobe = 'SI'
//                                            GROUP BY tp.trt_id
//                                            ORDER BY trp_date DESC) AS r
//                                        GROUP BY trt_id";
					$rsult = $dbd->query($sqlDentaliaPrice);
					/* insertamos */
					while ($inser = $dbk->fetch($rsult)) {
						$i = "INSERT INTO treatprice (trt_id,cli_class,trp_price,trp_date,usr_id)"
								. "VALUES (" . $inser['trt_id'] . ", $cli_class," . $inser['trp_price'] . ",'" . $inser['trp_date'] . "'," . $inser['usr_id'] . ")";
						$precios = $dbk->query($i);
					}
					/* termina de insertar precios */
					//Leemos precios de tipo 2 en dentalia
//                    $sqlDentaliaPrice = "INSERT INTO treatprice (trt_id,cli_class,trp_price,trp_date,usr_id)
//						SELECT r.trt_id," . $dbk->clean($cli_class) . ",r.trp_price, DATE(r.trp_date) AS trp_date,2 AS usr_id FROM(SELECT * FROM " . DB_DENTALIA . ".treatprice WHERE clt_id = 2 ORDER BY trp_date DESC) AS r GROUP BY trt_id;";
					//if ($dbk->query($sqlDentaliaPrice)) {
					if ($precios) {
						echo '<p style="color:green;">Precio actualizado para ' . $cli_class . '</p>';
					} else {
						echo '<p style="color:red;">Error al actualizar precio para ' . $cli_class . '</p>';
					}
				}
				$sqlChangeConsultaName = "UPDATE treatment SET trt_name = 'RECETA', trt_abbr = 'RECETA' WHERE trt_name = 'CONSULTA'";
				if ($dbk->query($sqlChangeConsultaName)) {
					echo '<p style="color:green;">Se actualizo consulta a receta</p>';
				} else {
					echo '<p style="color:red;">Error al cambiarle el nombre a la consulta</p>';
				}
				echo '<p style="color:green;">YA ACTUALIZAMOS PRECIOS Y TRATAMIENTOS!!</p>';
			} else {
				echo '<p style="color:red;">Error al obtener clinicas de red</p>';
			}
		} else {
			echo '<p style="color:red;">Error al regenerar tratamientos en red</p>';
		}
	} else {
		echo '<p style="color:red;">Error al borrar tratamientos en red</p>';
	}
} catch (Exception $e) {
	echo "Excepci&oacute;n: <pre>" . print_r($e, TRUE) . "</pre>";
}

function kDev() {
//	$remoteAddr = filter_input(INPUT_SERVER,'REMOTE_ADDR');
	$remoteAddr = $_SERVER['REMOTE_ADDR'];
	if (php_sapi_name() == 'cli' || isset($remoteAddr) && in_array($remoteAddr, array('::1', 'localhost', '127.0.0.1', '187.162.35.59', '201.156.225.50'))) {
		return TRUE;
	}
	return FALSE;
}
