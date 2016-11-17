<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	date_default_timezone_set('America/Mexico_City');
	
	define('DB_DENTALIA','kobemxco_dentalia');
	define('DB_RED_KOBE','kobemxco_red');
	
	if(isset($_GET['echo']) && $_GET['echo'] == 'on'){
		define('ECHO_ON', true);
	}else{
		define('ECHO_ON',false);
	}
	
	define('DO_QUERYS',true);
	
	if( PHP_SAPI === 'cli' ){
		//die('CLI');
		require_once dirname($_SERVER['PHP_SELF']) . '/../config.inc.php';
	}else{
		//die('WEB');
		require_once '../config.inc.php';
	}
	
	#conexion a la base de datos
	mysql_connect($DBServer,$DBUser,$DBPaswd);
	mysql_select_db(DB_RED_KOBE);
	mysql_query("SET time_zone = 'America/Mexico_City';");
	mysql_query("SET lc_time_names = 'es_MX';");
	mysql_query("SET default_week_format = 1;");
	mysql_query("SET NAMES utf8");
	
	## compañias permitidas en sistema RED (AXA, GEO, JAFRA)
	$companiasPermitidas = implode(',', array(/*'143',*/'66','175','180','202'));
	
	$ti = time();
	if(ECHO_ON) echo "##<br/>## Verificando Pacientes " . date('r') . "<br/>##<pre>";
	
	if(ECHO_ON) echo "<h3>## Altas! dentalia - RED!</h3>\n";
	
	## buscamos pacientes en dentalia
	$sql = "SELECT * FROM ".DB_DENTALIA.".patient WHERE agr_id IN (SELECT agr_id FROM ".DB_DENTALIA.".agreement a JOIN ".DB_DENTALIA.".company c USING(com_id) WHERE c.com_id IN ({$companiasPermitidas})) ;";
	$rsPacientesDentalia = mysql_query($sql);
	while($pacienteDentalia = mysql_fetch_assoc($rsPacientesDentalia)){
		## buscamos paciente en RED
		$rsPacienteRED = mysql_query("SELECT * FROM ".DB_RED_KOBE.".patient WHERE pat_id = '{$pacienteDentalia['pat_id']}' AND agr_id = '{$pacienteDentalia['agr_id']}' ");
		if(mysql_num_rows($rsPacienteRED) == 1){
			## paciente encontrado, actualizar?
			$pacienteRED = mysql_fetch_assoc($rsPacienteRED);
			$actualizarDatos = array_diff_assoc($pacienteDentalia,$pacienteRED);
			unset($actualizarDatos['pat_vip']);
			//echo "Paciente encontrado!<pre>diff:\n" . print_r($actualizarDatos, true) . "dentalia:\n".print_r($pacienteDentalia, true) . "red:\n" . print_r($pacienteRED, true)." </pre>";
			//echo "Paciente encontrado!<pre>diff:\n" . print_r($actualizarDatos, true) . " </pre>";
			if(count($actualizarDatos) > 0){
				$sql = "UPDATE ".DB_RED_KOBE.".patient SET  ";
				foreach ($actualizarDatos as $campo => $valor) { 
					$sql .= "{$campo} = '" . mysql_real_escape_string($valor) . "', "; 
				}
				$sql = substr($sql,0,-2) . " WHERE pat_id = '{$pacienteDentalia['pat_id']}' ;";
				if(ECHO_ON) echo "## Actualizar Datos: \n{$sql}\n";
				if(DO_QUERYS){
					if(!mysql_query($sql)){
						die("FAIL!!! (patient UPDATE) {$sql} \t" . mysql_error() . "\n");
					}
				}
			}
		}else{
			## no se encontro el paciente o no esta en el convenio correcto
			$rsCheckConvenio = mysql_query("SELECT * FROM ".DB_RED_KOBE.".patient WHERE pat_id = '{$pacienteDentalia['pat_id']}' ");
			if(mysql_num_rows($rsCheckConvenio) == 1){
				## el convenio del paciente esta mal, actualizarlo 
				$pacienteRED = mysql_fetch_assoc($rsCheckConvenio);
				$actualizarDatos = array_diff_assoc($pacienteDentalia,$pacienteRED);
				unset($actualizarDatos['pat_vip']);
				if(count($actualizarDatos) > 0){
					$sql = "UPDATE ".DB_RED_KOBE.".patient SET  ";
					foreach ($actualizarDatos as $campo => $valor) { 
						$sql .= "{$campo} = '" . mysql_real_escape_string($valor) . "', "; 
					}
					$sql = substr($sql,0,-2) . " WHERE pat_id = '{$pacienteDentalia['pat_id']}' ;";
					if(ECHO_ON) echo "## Actualizar Convenio ({$pacienteRED['agr_id']} -> {$pacienteDentalia['agr_id']}): \n{$sql}\n";
					if(DO_QUERYS){
						if(!mysql_query($sql)){
							die("FAIL!!! (patient UPDATE convenio) {$sql} \t" . mysql_error() . "\n");
						}
					}
				}
			}else{
				## no esta en la base de RED ingresarlo
				$sql = "INSERT INTO ".DB_RED_KOBE.".patient(";
				foreach ($pacienteDentalia as $campo => $valor) {
					if($campo != 'pat_vip'){
						$sql .= "{$campo}, ";
					}
				}
				$sql = substr($sql,0,-2) . ") VALUES(";
				foreach ($pacienteDentalia as $campo => $valor) {
					if($campo != 'pat_vip'){	
						$sql .= "'" . mysql_real_escape_string($valor) . "', ";
					}
				}
				$sql = substr($sql,0,-2) . ");";
				if(ECHO_ON) echo "## Agregar Paciente ({$pacienteDentalia['pat_id']}): \n{$sql}\n";
				if(DO_QUERYS){
					if(!mysql_query($sql)){
						die("FAIL!!! (patient INSERT) {$sql} \t" . mysql_error() . "\n");
					}
				}
			}
			## ingresamos el ultimo cambio/alta de convenio que hubo para este paciente
			$sql = "INSERT INTO ".DB_RED_KOBE.".patagrhist SELECT null,pat_id, agr_id, usr_id, pah_date, pah_ini, pah_end, pah_active FROM ".DB_DENTALIA.".patagrhist WHERE pat_id = '{$pacienteDentalia['pat_id']}' ORDER BY pah_date DESC LIMIT 1;"; 
			if(ECHO_ON) echo "## Actualizar Historial por Cambio/Alta Convenio: \n{$sql}\n";
			if(DO_QUERYS){
				if(!mysql_query($sql)){
					die("FAIL!!! (patagrhist) {$sql} \t" . mysql_error() . "\n");
				}
			}
		}
	}
	
	if(ECHO_ON) echo "<h3>## Bajas! RED - dentalia!</h3>";
	
	## buscamos pacientes en RED para dar bajas de convenio
	$sql = "SELECT * FROM ".DB_RED_KOBE.".patient WHERE agr_id IN (SELECT agr_id FROM ".DB_RED_KOBE.".agreement a JOIN ".DB_RED_KOBE.".company c USING(com_id) WHERE c.com_id IN ({$companiasPermitidas})) ;";
	//die($sql); 
	$rsPacientesRED = mysql_query($sql);
	while($pacienteRED = mysql_fetch_assoc($rsPacientesRED)){
		## buscamos paciente en dentalia
		$rsPacienteRED = mysql_query("SELECT * FROM ".DB_DENTALIA.".patient WHERE pat_id = '{$pacienteRED['pat_id']}' AND agr_id = '{$pacienteRED['agr_id']}' ");
		if(mysql_num_rows($rsPacienteRED) != 1){
			## paciente con convenio NO encontrado, buscamos si esta con otro convenio
			$rsCheckConvenio = mysql_query("SELECT * FROM ".DB_DENTALIA.".patient WHERE pat_id = '{$pacienteRED['pat_id']}' ");
			if(mysql_num_rows($rsCheckConvenio) == 1){
				## el convenio del paciente esta mal, actualizarlo 
				$pacienteDentalia = mysql_fetch_assoc($rsCheckConvenio);
				## checamos que el convenio al que se cambio sea uno permitido por red o de lo contrario quitar convenio (agr_id = 0)
				$sql = "SELECT '{$pacienteDentalia['agr_id']}' IN (SELECT agr_id FROM ".DB_RED_KOBE.".agreement a JOIN ".DB_RED_KOBE.".company c USING(com_id) WHERE c.com_id IN ({$companiasPermitidas})) AS valido";
				$checkConvenio = mysql_fetch_assoc(mysql_query($sql));
				if($checkConvenio['valido']){
					## lo cambiamos de convenio
					$nuevoConvenio = $pacienteDentalia['agr_id'];
				}else{
					## lo sacamos de convenios
					$nuevoConvenio = 0;
				}
				$sql = "UPDATE ".DB_RED_KOBE.".patient SET agr_id = '{$nuevoConvenio}' WHERE pat_id = '{$pacienteDentalia['pat_id']}' ;";
				if(ECHO_ON) echo "## Actualizar Convenio BAJA ({$pacienteRED['agr_id']} -> {$pacienteDentalia['agr_id']}): \n{$sql}\n";
				if(DO_QUERYS){
					if(!mysql_query($sql)){
						die("FAIL!!! (patient UPDATE convenio) {$sql} \t" . mysql_error() . "\n");
					}
				}
				## ingresamos el ultimo cambio/alta de convenio que hubo para este paciente
				$sql = "INSERT INTO ".DB_RED_KOBE.".patagrhist SELECT null,pat_id, agr_id, usr_id, pah_date, pah_ini, pah_end, pah_active FROM ".DB_DENTALIA.".patagrhist WHERE pat_id = '{$pacienteDentalia['pat_id']}' ORDER BY pah_date DESC LIMIT 1;"; 
				if(ECHO_ON) echo "## Actualizar Historial por Cambio/Baja Convenio: \n{$sql}\n";
				if(DO_QUERYS){
					if(!mysql_query($sql)){
						die("FAIL!!! (patagrhist) {$sql} \t" . mysql_error() . "\n");
					}
				}
			}
		}#else{ #si se encontro y corresponde el convenio }
	}
	
	if(ECHO_ON) echo "</pre>##<br/>## Fin ". date('r') . "<br/>## ".(time() - $ti)."s<br/>##";
	
	/*
	function beginTransaction() {
		##inicia una transaccion en mysql
		mysql_query("SET AUTOCOMMIT = 0;");
		mysql_query("BEGIN;");
	}
	
	function commitTransaction(){
		##guarda las operaciones de la transaccion en mysql
		mysql_query("COMMIT;");
		mysql_query("SET AUTOCOMMIT = 1;");
	}
	
	function rollbackTransaction(){
		##cancela las operaciones de la transaccion en mysql
		mysql_query("ROLLBACK;");
		mysql_query("SET AUTOCOMMIT = 1;");
	}
	*/
?>