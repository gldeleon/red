<?php
$start = (float) array_sum(explode(' ',microtime()));
require_once dirname(__FILE__) . "/" . "../../dentalia3/Enumeration.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3/MySQLConnectionFailedException.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3/MySQLException.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3/MySQL.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3/RequestTypeEnum.php";
require_once dirname(__FILE__) . "/" . "../../dentalia3/BadRequestException.php";

ini_set('memory_limit', '520M');
set_time_limit(65 * 60);

$db = MySQL::getInstance();
$dbRed = MySQL::getInstance('localhost', 'kobemxco_red');
	
$resumen = array(
	'duplicados' => array("cont"=>0,"data"=>array())
	, 'ok' => 0
	, 'no encontrados' => 0
	, 'total' => 0
);


//Buscamos las compañias activas
$sqlBuscaPx = "SELECT * FROM pxunificados;";

if (($rsPx = $dbRed->query($sqlBuscaPx)) && $dbRed->count($rsPx) > 0) {
	$resumen["total"] = $dbRed->count($rsPx);
	while ($rowPx = $dbRed->fetch($rsPx)) {
		
		$sqlUpdatePatRED = "";
		$sqlUpdatePatDEN = "";
		
		//Buscamos al px en dentalia por nombre
		$sqlPxDen = "SELECT pe.per_complete,pa.pat_id,pa.pat_key FROM patient pa LEFT JOIN person pe USING(person_id) WHERE pe.per_complete = '".$db->clean($rowPx["pat_complete"])."' AND pe.per_birthday = '".$rowPx["pat_ndate"]."' AND pa.pat_active = 'ACTIVO' AND pe.active = 'ACTIVO'";
		$rsPxDen = $db->query($sqlPxDen);
		$countPxDen = $db->count($rsPxDen);
		if($countPxDen === 0){
//			echo '<p>No existe px '.$rowPx["pat_complete"].' en dentalia</p>';
			$resumen["no encontrados"]++;
		}
		else if($countPxDen === 1){
			$rowPxDen = $db->fetch($rsPxDen);
//			echo '<p>TODO BIEN CON px '.$rowPx["pat_complete"].' en dentalia</p>';
			//Actualizamos el pat_id en RED y el pat_key en dentalia
			$sqlUpdatePatRED = "UPDATE patient SET pat_id_new = ".$db->clean($rowPxDen["pat_id"])." WHERE pat_id = '".$db->clean($rowPx["pat_id"])."';";
			$sqlUpdatePatDEN = "UPDATE patient SET pat_key = '".$db->clean($rowPx["pat_id"])."' WHERE pat_id = '".$db->clean($rowPxDen["pat_id"])."';";			
			$resumen["ok"]++;
		}
		else{
			//Al primero le ponemos el pat_key
			$duplicado = TRUE;
			$dupData = array();
			while($rowPxDen = $db->fetch($rsPxDen)){
				if($rowPx["pat_id"] == $rowPxDen["pat_key"]){
					//Encontramos al bueno, actualizamos pat_id en RED
					$sqlUpdatePatRED = "UPDATE patient SET pat_id_new = ".$db->clean($rowPxDen["pat_id"])." WHERE pat_id = '".$db->clean($rowPx["pat_id"])."';";
					$resumen["ok"]++;
					$duplicado = FALSE;
					$dupData = array();
					break;
				}
				else{
					$dupData[]=$rowPxDen;
				}
			}
			if($duplicado){
//				echo '<p>Hay multiples px '.htmlentities($rowPx["pat_complete"]).' en dentalia ('.$countPxDen.')</p>';
				$resumen["duplicados"]["cont"]++;
				$resumen["duplicados"]["data"][]=$dupData;
			}
		}
		
		/**/
		if($sqlUpdatePatRED !== ""){
			$dbRed->query($sqlUpdatePatRED);
		}
		if($sqlUpdatePatDEN !== ""){
			$db->query($sqlUpdatePatDEN);
		}
		/**/
	}
} else {
	die("<p>No hay pacientes</p>\n");
}
$end = (float) array_sum(explode(' ',microtime()));
echo "Se han procesado los registros en ". sprintf("%.4f", ($end-$start))." segundos<br/>";
echo '<pre>'.print_r($resumen,TRUE).'</pre>';