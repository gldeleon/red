<?php
	/** Llama al archivo de configuración. */
	include "../../config.inc.php";
	include "../../functions.inc.php";

	/** Obtiene un objeto de conexión con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	$date = date("Y-m-d");

	$opcion = (isset($_POST["opcion"]) && !empty($_POST["opcion"])) ? $_POST["opcion"] : "";

	$empid = (isset($_POST["empid"]) && !empty($_POST["empid"])) ? intval($_POST["empid"], 10) : 0;
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? intval($_POST["cli"], 10) : 0;
	$correcta = (isset($_POST["correcta"]) && !empty($_POST["correcta"])) ? intval($_POST["correcta"], 10) : 0;

	/** Fecha de llenado de Historia Clinica Fisica*/
	$day = (isset($_POST["day"]) && !empty($_POST["day"])) ? intval($_POST["day"], 10) : 0;
	$month = (isset($_POST["month"]) && !empty($_POST["month"])) ? intval($_POST["month"], 10) : 0;
	$year = (isset($_POST["year"]) && !empty($_POST["year"])) ? intval($_POST["year"], 10) : 0;

	/** Datos del paciente*/
	$pat_id = (isset($_POST["pat_id"]) && !empty($_POST["pat_id"])) ? $_POST["pat_id"] : "";
	$sexo = (isset($_POST["sexo"]) && !empty($_POST["sexo"])) ? $_POST["sexo"] : "";
	$job = (isset($_POST["job"]) && !empty($_POST["job"])) ? $_POST["job"] : 0;
	$anio = (isset($_POST["anio"]) && !empty($_POST["anio"])) ? intval($_POST["anio"], 10) : 0;
	$mes = (isset($_POST["mes"]) && !empty($_POST["mes"])) ? intval($_POST["mes"], 10) : 0;
	$dia = (isset($_POST["dia"]) && !empty($_POST["dia"])) ? intval($_POST["dia"], 10) : 0;
	$edociv = (isset($_POST["edociv"]) && !empty($_POST["edociv"])) ? intval($_POST["edociv"], 10) : 0;
	$nohijo = (isset($_POST["nohijo"]) && !empty($_POST["nohijo"])) ? intval($_POST["nohijo"], 10) : 0;
	$col = (isset($_POST["col"]) && !empty($_POST["col"])) ? $_POST["col"] : "";
	$cp = (isset($_POST["cp"]) && !empty($_POST["cp"])) ? $_POST["cp"] : "";
	$mail = (isset($_POST["mail"]) && !empty($_POST["mail"])) ? $_POST["mail"] : "";
	$okmail = (isset($_POST["okmail"]) && !empty($_POST["okmail"])) ? intval($_POST["okmail"], 10) : 0;
	$foncontact = (isset($_POST["foncontact"]) && !empty($_POST["foncontact"])) ? intval($_POST["foncontact"], 10) : 0;

	$telcasa = (isset($_POST["telcasa"]) && !empty($_POST["telcasa"])) ? $_POST["telcasa"] : "0";
	$teloficina = (isset($_POST["teloficina"]) && !empty($_POST["teloficina"])) ? $_POST["teloficina"] : "0";
	$telcel = (isset($_POST["telcel"]) && !empty($_POST["telcel"])) ? $_POST["telcel"] : "0";
	$telnex = (isset($_POST["telnex"]) && !empty($_POST["telnex"])) ? $_POST["telnex"] : "0";

	//*** Datos de la historia clinica del paciente.
	$penic = (isset($_POST["penic"]) && !empty($_POST["penic"])) ? intval($_POST["penic"], 10) : 0;
	$antb = (isset($_POST["antb"]) && !empty($_POST["antb"])) ? intval($_POST["antb"], 10) : 0;
	$antf = (isset($_POST["antf"]) && !empty($_POST["antf"])) ? intval($_POST["antf"], 10) : 0;
	$ang = (isset($_POST["ang"]) && !empty($_POST["ang"])) ? intval($_POST["ang"], 10) : 0;
	$slf = (isset($_POST["slf"]) && !empty($_POST["slf"])) ? intval($_POST["slf"], 10) : 0;
	$ots = (isset($_POST["ots"]) && !empty($_POST["ots"])) ? intval($_POST["ots"], 10) : 0;
	$otroaler = (isset($_POST["otroaler"]) && !empty($_POST["otroaler"])) ? $_POST["otroaler"] : "";
	$db = (isset($_POST["db"]) && !empty($_POST["db"])) ? intval($_POST["db"], 10) : 0;
	$hp = (isset($_POST["hp"]) && !empty($_POST["hp"])) ? intval($_POST["hp"], 10) : 0;
	$asm = (isset($_POST["asm"]) && !empty($_POST["asm"])) ? intval($_POST["asm"], 10) : 0;
	$heart = (isset($_POST["heart"]) && !empty($_POST["heart"])) ? intval($_POST["heart"], 10) : 0;
	$pc = (isset($_POST["pc"]) && !empty($_POST["pc"])) ? intval($_POST["pc"], 10) : 0;
	$fr = (isset($_POST["fr"]) && !empty($_POST["fr"])) ? intval($_POST["fr"], 10) : 0;
	$hm = (isset($_POST["hm"]) && !empty($_POST["hm"])) ? intval($_POST["hm"], 10) : 0;
	$hipo = (isset($_POST["hipo"]) && !empty($_POST["hipo"])) ? intval($_POST["hipo"], 10) : 0;
	$hipe = (isset($_POST["hipe"]) && !empty($_POST["hipe"])) ? intval($_POST["hipe"], 10) : 0;
	$pres = (isset($_POST["pres"]) && !empty($_POST["pres"])) ? intval($_POST["pres"], 10) : 0;
	$df = (isset($_POST["df"]) && !empty($_POST["df"])) ? intval($_POST["df"], 10) : 0;
	$opc = (isset($_POST["opc"]) && !empty($_POST["opc"])) ? intval($_POST["opc"], 10) : 0;
	$cv = (isset($_POST["cv"]) && !empty($_POST["cv"])) ? intval($_POST["cv"], 10) : 0;
	$oth = (isset($_POST["oth"]) && !empty($_POST["oth"])) ? intval($_POST["oth"], 10) : 0;
	$otroenf = (isset($_POST["otroenf"]) && !empty($_POST["otroenf"])) ? $_POST["otroenf"] : "";
	$adntl = (isset($_POST["adntl"]) && !empty($_POST["adntl"])) ? intval($_POST["adntl"], 10) : 0;
	$reac = (isset($_POST["reac"]) && !empty($_POST["reac"])) ? intval($_POST["reac"], 10) : 0;
	$descreac = (isset($_POST["descreac"]) && !empty($_POST["descreac"])) ? $_POST["descreac"] : "";
	$prectrt = (isset($_POST["prectrt"]) && !empty($_POST["prectrt"])) ? $_POST["prectrt"] : "";
	$salud = (isset($_POST["salud"]) && !empty($_POST["salud"])) ? $_POST["salud"] : "";
	$dientes = (isset($_POST["dientes"]) && !empty($_POST["dientes"])) ? $_POST["dientes"] : "";
	$cambios = (isset($_POST["cambios"]) && !empty($_POST["cambios"])) ? $_POST["cambios"] : "";
	$smile = (isset($_POST["smile"]) && !empty($_POST["smile"])) ? intval($_POST["smile"], 10) : 0;
	$sonrisa = (isset($_POST["sonrisa"]) && !empty($_POST["sonrisa"])) ? $_POST["sonrisa"] : "";
	$like = (isset($_POST["like"]) && !empty($_POST["like"])) ? intval($_POST["like"], 10) : 0;
	$colordte = (isset($_POST["colordte"]) && !empty($_POST["colordte"])) ? $_POST["colordte"] : "";
	$encia = (isset($_POST["encia"]) && !empty($_POST["encia"])) ? intval($_POST["encia"], 10) : 0;
	$ensiasna = (isset($_POST["ensiasna"]) && !empty($_POST["ensiasna"])) ? $_POST["ensiasna"] : "";
	$visit = (isset($_POST["visit"]) && !empty($_POST["visit"])) ? intval($_POST["visit"], 10) : 0;
	$embda = (isset($_POST["embda"]) && !empty($_POST["embda"])) ? intval($_POST["embda"], 10) : 0;
	$meses = (isset($_POST["meses"]) && !empty($_POST["meses"])) ? intval($_POST["meses"], 10) : 0;
	$embzos = (isset($_POST["embzos"]) && !empty($_POST["embzos"])) ? intval($_POST["embzos"], 10) : 0;
	$tiene = (isset($_POST["tiene"]) && !empty($_POST["tiene"])) ? intval($_POST["tiene"], 10) : 0;
	$dolor = (isset($_POST["dolor"]) && !empty($_POST["dolor"])) ? intval($_POST["dolor"], 10) : 0;
	$dlragudo = (isset($_POST["dlragudo"]) && !empty($_POST["dlragudo"])) ? intval($_POST["dlragudo"], 10) : 0;
	$mandi = (isset($_POST["mandi"]) && !empty($_POST["mandi"])) ? intval($_POST["mandi"], 10) : 0;
	$cuerpo = (isset($_POST["cuerpo"]) && !empty($_POST["cuerpo"])) ? intval($_POST["cuerpo"], 10) : 0;
	$almf = (isset($_POST["almf"]) && !empty($_POST["almf"])) ? intval($_POST["almf"], 10) : 0;
	$alml = (isset($_POST["alml"]) && !empty($_POST["alml"])) ? intval($_POST["alml"], 10) : 0;
	$mast = (isset($_POST["mast"]) && !empty($_POST["mast"])) ? intval($_POST["mast"], 10) : 0;
	$beber = (isset($_POST["beber"]) && !empty($_POST["beber"])) ? intval($_POST["beber"], 10) : 0;
	$touch = (isset($_POST["touch"]) && !empty($_POST["touch"])) ? intval($_POST["touch"], 10) : 0;
	$esfzo = (isset($_POST["esfzo"]) && !empty($_POST["esfzo"])) ? intval($_POST["esfzo"], 10) : 0;
	$feber = (isset($_POST["feber"]) && !empty($_POST["feber"])) ? intval($_POST["feber"], 10) : 0;
	$pdp = (isset($_POST["pdp"]) && !empty($_POST["pdp"])) ? intval($_POST["pdp"], 10) : 0;
	$sang = (isset($_POST["sang"]) && !empty($_POST["sang"])) ? intval($_POST["sang"], 10) : 0;
	$alivio = (isset($_POST["alivio"]) && !empty($_POST["alivio"])) ? $_POST["alivio"] : "";
	$mejoro = (isset($_POST["mejoro"]) && !empty($_POST["mejoro"])) ? intval($_POST["mejoro"],10) : 0;
	$medicamentos = (isset($_POST["medicamentos"]) && !empty($_POST["medicamentos"])) ? $_POST["medicamentos"] : "";
	$proxim = (isset($_POST["proxim"]) && !empty($_POST["proxim"])) ? $_POST["proxim"] : "";
	$otrproxim = (isset($_POST["otrproxim"]) && !empty($_POST["otrproxim"])) ? $_POST["otrproxim"] : "";
	$recom = (isset($_POST["recom"]) && !empty($_POST["recom"])) ? $_POST["recom"] : "";
	$rec = (isset($_POST["rec"]) && !empty($_POST["rec"])) ? $_POST["rec"] : "";
	$recotro = (isset($_POST["recotro"]) && !empty($_POST["recotro"])) ? $_POST["recotro"] : "";
	$reposo = (isset($_POST["reposo"]) && !empty($_POST["reposo"])) ? intval($_POST["reposo"], 10) : 0;
	$tomamdto = (isset($_POST["tomamdto"]) && !empty($_POST["tomamdto"])) ? $_POST["tomamdto"] : "";
	$coment = (isset($_POST["coment"]) && !empty($_POST["coment"])) ? $_POST["coment"] : "";
	$pthid = (isset($_POST["pthid"]) && !empty($_POST["pthid"])) ? intval($_POST["pthid"], 10) : 0;

	switch($opcion) {
		case 'guarda':
			//*** Actualiza la informacion del paciente con base en los datos capturados
			// en el formulario de historia clinica.
			$query = "update {$DBName}.patient set pat_gender = '{$sexo}', pat_occupation = '{$job}',
			pat_ndate = '{$anio}-{$mes}-{$dia}', pat_mtstatus = {$edociv}, pat_nson = '{$nohijo}',
			pat_address = '{$col}cp-{$cp}', pat_mail = '{$mail}', pat_okmail = {$okmail},
			pat_telcontact = '{$foncontact}' where pat_id = '".utf8_decode($pat_id)."'";
			@mysql_query($query, $link) or die("1".$query);

			$queryt = "";
			//*** Telefono de casa.
			$query = "select tel_id from {$DBName}.telephone where pat_id = '".utf8_decode($pat_id)."'
			and tlt_id = 1";
			if($result = @mysql_query($query, $link)) {
				if(@mysql_num_rows($result) > 0) {
					$queryt = "update {$DBName}.telephone set tel_number = '{$telcasa}' where
					pat_id = '".utf8_decode($pat_id)."' and tlt_id = 1";
				}
				else {
					if($telcasa != "" && $telcasa != "0") {
						$queryt = "insert into {$DBName}.telephone (pat_id, tel_number, tlt_id)
						values ('".utf8_decode($pat_id)."', '{$telcasa}', 1)";
					}
				}
				@mysql_free_result($result);
			}
			if($queryt != "") {
				//*** Actualiza los telefonos del paciente, siempre y cuando ya tenga numeros
				// capturados, de lo contrario los inserta en la tabla.
				@mysql_query($queryt, $link) or die("2");
			}

			$queryt = "";
			//*** Telefono de oficina.
			$query = "select tel_id from {$DBName}.telephone where pat_id = '".utf8_decode($pat_id)."'
			and tlt_id = 2";
			if($result = @mysql_query($query, $link)) {
				if(@mysql_num_rows($result) > 0) {
					$queryt = "update {$DBName}.telephone set tel_number = '{$teloficina}' where
					pat_id = '".utf8_decode($pat_id)."' and tlt_id = 2";
				}
				else {
					if($teloficina != "" && $teloficina != "0") {
						$queryt = "insert into {$DBName}.telephone (pat_id, tel_number, tlt_id) values
						('".utf8_decode($pat_id)."', '{$teloficina}', 2)";
					}
				}
				@mysql_free_result($result);
			}
			if($queryt != "") {
				//*** Actualiza los telefonos del paciente, siempre y cuando ya tenga numeros
				// capturados, de lo contrario los inserta en la tabla.
				@mysql_query($queryt, $link) or die("3");
			}

			$queryt = "";
			//*** Telefono celular.
			$query = "select tel_id from {$DBName}.telephone where pat_id = '".utf8_decode($pat_id)."'
			and tlt_id = 3";
			if($result = @mysql_query($query, $link)) {
				if(@mysql_num_rows($result) > 0) {
					$queryt = "update {$DBName}.telephone set tel_number = '{$telcel}' where
					pat_id = '".utf8_decode($pat_id)."' and tlt_id = 3";
				}
				else {
					if($telcel != "" && $telcel != "0") {
						$queryt = "insert into {$DBName}.telephone (pat_id, tel_number, tlt_id) values
						('".utf8_decode($pat_id)."', '{$telcel}', 3)";
					}
				}
				@mysql_free_result($result);
			}
			if($queryt != "") {
				//*** Actualiza los telefonos del paciente, siempre y cuando ya tenga numeros
				// capturados, de lo contrario los inserta en la tabla.
				@mysql_query($queryt, $link) or die("4");
			}

			$queryt = "";
			//*** Nextel
			$query = "select tel_id from {$DBName}.telephone where pat_id = '".utf8_decode($pat_id)."'
			and tlt_id = 4";
			if($result = @mysql_query($query, $link)) {
				if(@mysql_num_rows($result) > 0) {
					$queryt = "update {$DBName}.telephone set tel_number = '{$telnex}' where
					pat_id = '".utf8_decode($pat_id)."' and tlt_id = 4";
				}
				else {
					if($telnex != "" && $telnex != "0") {
						$queryt = "insert into {$DBName}.telephone (pat_id, tel_number, tlt_id) values
						('".utf8_decode($pat_id)."', '{$telnex}', 4)";
					}
				}
				@mysql_free_result($result);
			}
			if($queryt != "") {
				//*** Actualiza los telefonos del paciente, siempre y cuando ya tenga numeros
				// capturados, de lo contrario los inserta en la tabla.
				@mysql_query($queryt, $link) or die("5");
			}

			if($pthid != 0) {
				$pta_type = "2";
			}
			else {
				$pta_type = "1";

				$query = "insert into {$DBName}.pathistory set pat_id = '".utf8_decode($pat_id)."'";
				@mysql_query($query, $link);
				$pthid = @mysql_insert_id($link);
			}

			$query  = "update {$DBName}.pathistory set pth_penic = {$penic}, pth_antib = {$antb},
			pth_anfinf = {$antf}, pth_analg = {$ang}, pth_sulf = {$slf}, pth_oth = {$ots},
			pth_other = '{$otroaler}', pth_diab = {$db}, pth_hepat = {$hp}, pth_asthma = {$asm},
			pth_heart = {$heart}, pth_coagul = {$pc}, pth_reum = {$fr}, pth_hemo = {$hm},
			pth_hypot = {$hipo}, pth_hypert = {$hipe}, pth_pres = {$pres}, pth_faint = {$df},
			pth_oper = {$opc}, pth_convul = {$cv}, pth_othd = {$oth}, pth_othdis = '{$otroenf}',
			pth_anes = {$adntl}, pth_anrct = {$reac}, pth_react = '{$descreac}', pth_caut = '{$prectrt}',
			pth_health = '{$salud}', pth_teethf = '{$dientes}', pth_chang = '{$cambios}', pth_smile = {$smile},
			pth_smiled = '{$sonrisa}', pth_tcolor = {$like}, pth_tcolord = '{$colordte}', pth_ences = {$encia},
			pth_encesd = '{$ensiasna}', pth_lastv = '{$visit}', pth_pregnan = {$embda}, pth_pregmon = {$meses},
			pth_pregnum = {$embzos}, pth_pain = {$tiene}, pth_painst = '{$dolor}', pth_acpain = '{$dlragudo}',
			pth_mouth = {$mandi}, pth_expan = {$cuerpo}, pth_cold = {$almf}, pth_sweet = {$alml},
			pth_chew = {$mast}, pth_drink = {$beber}, pth_touch = {$touch}, pth_physef = {$esfzo},
			pth_fever = {$feber}, pth_dentp = {$pdp}, pth_bleeding = {$sang}, pth_ease = '{$alivio}',
			pth_medicin = {$mejoro}, pth_mdcwch = '{$medicamentos}', pth_prxcli = '{$proxim}',
			pth_oprxcli = '{$otrproxim}', pth_knowd = '{$recom}', pth_recd = '{$rec}', pth_orecd = '{$recotro}',
			pth_stand = {$reposo}, pth_othmed = '{$tomamdto}', pth_comm = '{$coment}',
			pth_date = '{$year}-{$month}-{$day}' where pat_id = '".utf8_decode($pat_id)."'";
			@mysql_query($query, $link) or die("6");

			if($pthid != 0) {
				$query = "insert into {$DBName}.pthaudit (pta_date, pth_id, emp_id, cli_id, pta_type) values
				('{$date}', {$pthid}, {$empid}, {$cli}, {$pta_type})";
				@mysql_query($query, $link) or die("7");
			}
			echo "OK*";
			break;
		case 'audita':

			$query = "insert into {$DBName}.pthaudit (pta_date, pth_id, emp_id, cli_id, pta_correct, pta_type) values
			('{$date}', {$pthid}, {$empid}, {$cli}, {$correcta}, 3)";
			@mysql_query($query, $link);

			echo (@mysql_affected_rows($link) < 0) ? "ERROR" : "OK";
			break;
		default:
			echo "ERROR*";
	}
?>