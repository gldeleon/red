<?php

include "../config.inc.php";
include "../functions.inc.php";
require_once 'excel/PHPExcel/IOFactory.php';
require_once 'excel/PHPExcel/PHPExcel.php';

if (!ini_set("max_execution_time", "10000"))   #####  Sets maximum execution time to 30 minutes (1800 seconds)
	echo "Error al configurar tiempo maximo de ejecucion";

$highestRow = 0;

try{
	$BD = "kobemxco_red";
	$hoy = date("Ymd");
	$nomsArchivo = "updateData";
	$ext = 'xlsx';
	$archivo = dirname(__FILE__) . "/data/" . $nomsArchivo . $hoy . "." . $ext; // nombre ya integrado
	$phpExcel = new PHPExcel();
	$objectReader = PHPExcel_IOFactory::createReader("Excel2007");
	$objectReader->setReadDataOnly(false);
	$objPHPExcel = $objectReader->load($archivo);
	$objWorksheet = $objPHPExcel->getActiveSheet(0);
	$highestRow = $objWorksheet->getHighestRow(0);
}
catch(Exception $e){
	echo 'Error ('.$e->getCode().') en l&iacute;nea '.$e->getLine().': '.$e->getMessage().'</p>';
}

if($highestRow == 0){
	die("El archivo esta vacio o no existe");
}

echo '<p>Antes del for</p>';
for ($i = 2; $i <= $highestRow; $i++) {
	$us = limpiaText($objWorksheet->getCellByColumnAndRow(1, $i)->getValue());
	$user = empty($us)?"": $us;
	$em = limpiaText($objWorksheet->getCellByColumnAndRow(2, $i)->getValue());
	$email = empty($em)?"":$em;
	$con = limpiaText($objWorksheet->getCellByColumnAndRow(3, $i)->getValue());
	$contrato = empty($con)?"": $con;
	$pres = limpiaText($objWorksheet->getCellByColumnAndRow(4, $i)->getValue());
	$prestador = empty($pres)?"":$pres;
	$rep =  limpiaText($objWorksheet->getCellByColumnAndRow(5, $i)->getValue());
	$repLegal = empty($rep)?"": $rep;
	$r = limpiaText($objWorksheet->getCellByColumnAndRow(6, $i)->getValue());
	$rfc = empty($r)?"":$r;
	$dL = limpiaText($objWorksheet->getCellByColumnAndRow(7, $i)->getValue());
	$dirLegal = empty($dL)?"": $dL;
	$dC = limpiaText($objWorksheet->getCellByColumnAndRow(8, $i)->getValue());
	$dirConsul = empty($dC)?"": $dC;
	$t = limpiaText($objWorksheet->getCellByColumnAndRow(9, $i)->getValue());
	$tel = empty($t)?"":$t;
	$f = limpiaText($objWorksheet->getCellByColumnAndRow(10, $i)->getValue());
	$fax = empty($f)?"": $f;
	$at = $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
	$alta = empty($at)?"00000":$at;
	$timestamp = PHPExcel_Shared_Date::ExcelToPHP($alta);
	$dateAlta = date("Y-m-d",strtotime("+1 day",$timestamp));
	$pg = $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
	$gral = empty($pg)?0:$pg;
	$p1 = limpiaText($objWorksheet->getCellByColumnAndRow(13, $i)->getValue());
	$porcent1 = empty($p1)?"0%":$p1;
	$p2 = limpiaText($objWorksheet->getCellByColumnAndRow(14, $i)->getValue());
	$porcent2 = empty($p2)?"0%":$p2;
	$pe = $objWorksheet->getCellByColumnAndRow(15, $i)->getValue();
	$pxExtra = empty($pe)?0:$pe;
	$apd =  $objWorksheet->getCellByColumnAndRow(16, $i)->getValue();
	$apartirde = empty($apd)?0: $apd;
	$ex = $objWorksheet->getCellByColumnAndRow(17, $i)->getValue();
	$extra = empty($ex)?0: $ex;
	$or = $objWorksheet->getCellByColumnAndRow(18, $i)->getValue();
	$orto = empty($or)?0: $or;
	$es = $objWorksheet->getCellByColumnAndRow(19, $i)->getValue();
	$esp = empty($es)?0:$es;
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	if (!$link) {
		die("Error al conectar " . mysql_error());
	}
	if($user!= ''){
		$userFind = "SELECT us.usr_id
			,us.usr_name
			,uc.cli_id
		FROM $BD.user as us
		LEFT JOIN $BD.userclinic AS uc
			ON uc.usr_id = us.usr_id
		LEFT JOIN $BD.clinic AS cli
			ON cli.cli_id = uc.cli_id
			AND cli.cli_active = 1
		WHERE usr_name = '$user' AND usr_active = 1";
		
		if($exeUsr = @mysql_query($userFind,$link)){
			if($rowU = @mysql_fetch_array($exeUsr, MYSQL_ASSOC)){
				if($rowU['cli_id']!='' || !is_null($rowU['cli_id'])){
					$updateData = "UPDATE $BD.clinic 
						SET cli_name = '$prestador'
							,cli_email = '$email'
							,cli_tel = '$tel'
							,cli_dir = '$dirConsul'
							,cli_webdir = '$dirConsul'
							,cli_rfc = '$rfc'
							,cli_rfc_dom = '$dirLegal'
							,cli_type_cont = '$contrato'
							,cli_fax = '$fax'
							,pago_serv = $gral
							,alta_date = '$dateAlta'
							,pago_extra = $pxExtra
							,px_extra = '$apartirde'
							,px_pago = $extra
							,pago_ort = $orto
							,pago_esp = $esp
							,rep_legal = '$repLegal'
							,porcent_1 = '$porcent1'
							,porcent_2 = '$porcent2'
						WHERE cli_id =".$rowU['cli_id'];

					if($exeUpdate = @mysql_query($updateData,$link)){
						echo "<br> $i .- Registro actualizado ";
					}else{
						echo "<br> $i .- No se actualizo bien =( Query($updateData)";
					}
				}else{
					echo "<br>$i NO hay cli_id";
				}
			}else{
				echo "<br>$i .- El $user No existe =(";
			}
		}else{
			echo "<br>Errores al ejecutar la consulta de la busqueda del usuario";
		}
	}
}
function limpiaText($txt){
	$acen = array('Á','É','Í','Ó','Ú','á','é','í','ó','ú');
	$normal = array('A','E','I','O','U','a','e','i','o','u');
	$txt = str_replace($acen, $normal, $txt);
	return $txt;
}