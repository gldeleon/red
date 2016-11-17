<?php
/**
 *
 * @param string $day Day to convert
 * @param bool $reverse 
 * @return type depends on the reverse variable, if true returns String, if false returns integer 
 */
function dayToNum($day, $reverse = false){
    
    $days = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    $dayNum = array(0,1,2,3,4,5,6);
    
    if(!$reverse){
        $dayToNum = str_replace($days, $dayNum, $day);
    }else{
        $dayToNum = str_replace($dayNum, $days , $day);
    }
    
    return $dayToNum;
    
}

/**
 * 
 * @param string $month
 * @param bool $reverse
 * @return type depends on the reverse variable, if true returns String, if false returns integer 
 * 
 */

function monthToNum($month, $reverse = false){

	$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	$monthNum = array(1,2,3,4,5,6,7,8,9,10,11,12);

	if(!$reverse){
		$monthToNum = str_replace($months, $monthNum, $month);
	}else{
		$monthToNum = str_replace($monthNum, $months , $month);
	}

	return $monthToNum;

}

/**
 * 
 * @param string $horaini
 * @param string $horafin
 * @return integer 
 */

function RestarHoras($horaini,$horafin){
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);

	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);

	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);

	$dif=$fin-$ini;

	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	//date("H:i:s",mktime($difh,$difm,$difs));
	return $dif/60;
}


function lowercase(&$string, $removeaccents = false, $isUTF8String = true) {
	if($isUTF8String) {
		$string = utf8_encode($string);
	}
	$string = mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
	if($removeaccents) {
		$minusculas = array("á", "é", "í", "ó", "ú", "ñ", "ä", "ë", "ï", "ö", "ü", "ç");
		$minusculas2 = array("a", "e", "i", "o", "u", "ñ", "a", "e", "i", "o", "u", "z");
		$string = str_replace($minusculas, $minusculas2, $string);
	}

	return $string;
}

function restaFechas($fechaIni, $fechaFin){

	list($anio1, $mes1, $dia1) = explode("-", $fechaIni);
	list($anio2, $mes2, $dia2) = explode("-", $fechaFin);

	//calculo timestam de las dos fechas
	$timestamp1 = mktime(0, 0 ,0 , $mes1, $dia1, $anio1);
	$timestamp2 = mktime(4, 12, 0, $mes2, $dia2, $anio2);

	//resto a una fecha la otra
	$segundos_diferencia = $timestamp1 - $timestamp2;
	//echo $segundos_diferencia;

	//convierto segundos en días
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

	//obtengo el valor absoulto de los días (quito el posible signo negativo)
	$dias_diferencia = abs($dias_diferencia);

	//quito los decimales a los días de diferencia
	$dias_diferencia = floor($dias_diferencia);

	return $dias_diferencia;

}
?>