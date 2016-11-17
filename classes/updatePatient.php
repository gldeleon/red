<?
        date_default_timezone_set("America/Mexico_City");
	//tel=5 - CA*6 - MO*
	/** Carga variables URL y determina sus valores iniciales. */
	$ln = (isset($_POST["ln"]) && !empty($_POST["ln"])) ? $_POST["ln"] : "";
	$sn = (isset($_POST["sn"]) && !empty($_POST["sn"])) ? $_POST["sn"] : "";
	$nm = (isset($_POST["nm"]) && !empty($_POST["nm"])) ? $_POST["nm"] : "";
	$email = (isset($_POST["email"]) && !empty($_POST["email"])) ? $_POST["email"] : "";
	$agr = $_POST["agr"];
	$agrval = $_POST["agrval"];
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$tel = (isset($_POST["tel"]) && !empty($_POST["tel"])) ? $_POST["tel"] : "";
	$pol = (isset($_POST["pol"]) && !empty($_POST["pol"])) ? $_POST["pol"] : "";
	$uid = (isset($_POST["uid"]) && !empty($_POST["uid"])) ? $_POST["uid"] : "1";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$res = "ERROR";

	if($ln != "" && $nm != "" && $pat != "") {
		$conacento = array("á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ");
		$sinacento = array("a", "e", "i", "o", "u", "ñ", "a", "e", "i", "o", "u", "Ñ");
		$ln = strtoupper(str_replace($conacento, $sinacento, strtolower($ln)));
		$sn = strtoupper(str_replace($conacento, $sinacento, strtolower($sn)));
		$nm = strtoupper(str_replace($conacento, $sinacento, strtolower($nm)));

		$ln = utf8_decode($ln);
		$sn = utf8_decode($sn);
		$nm = utf8_decode($nm);

		//if($agrval != "0" && $agr == "0")
		//	$agr = $agrval;

		/** Llama al archivo de configuración. */
		include "../config.inc.php";

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$agrant = "";
		$query = "select agr_id from {$DBName}.patient where pat_id = '".utf8_decode($pat)."'";
		if($result = @mysql_query($query, $link)) {
			$agrant = @mysql_result($result, 0);
			@mysql_free_result($result);
		}
		if($agr == "PLAN") {
			$agr = $agrant;
		}

		if($agr == "180" || $agr == "185") {
			$query = "insert into {$DBName}.axaauth set pat_id = '".utf8_decode($pat)."', axa_poliza = '{$pol}',
			no_auth = '', usr_id = '{$uid}', axa_date = '".date("Y-m-d")."', axa_hora = '".date("H:i:s")."',
			agr_id = '{$agr}', axa_src = 1,  cli_id = {$cli}";
			@mysql_query($query, $link);
		}

		$query = "update ".$DBName.".patient set pat_lastname = '".$ln."', pat_surename = '".$sn."', pat_name = '".$nm."',
		pat_complete = '".($nm." ".$ln." ".$sn)."', pat_mail = '".$email."', agr_id = ".$agr."
		where pat_id = '".utf8_decode($pat)."'";
		@mysql_query($query, $link);
		if(@mysql_affected_rows($link) >= 0) {
			$res = "OK";

			if($agrant != $agr) {
				$agr = ($agr == "") ? "0" : $agr;

				date_default_timezone_set("America/Mexico_City");

				$datetime = date_create();
				date_modify($datetime, "+1 Year");
				$agred = date_format($datetime, "Y-m-d H:i:s");

				$agrinidate = ($agr != "0") ? date("Y-m-d H:i:s") : "0000-00-00";
				$agrenddate = ($agr != "0") ? $agred : "0000-00-00";
				$agrmod = ($agr != "0") ? $agr : $agrant;
				$agractive = ($agr != "0") ? 1 : 0;

				$query2 = "insert into {$DBName}.patagrhist values(null, '".utf8_decode($pat)."',
				{$agrmod}, {$uid}, '".date("Y-m-d H:i:s")."', '{$agrinidate}', '{$agrenddate}',
				{$agractive})";
				@mysql_query($query2, $link);
			}

			/** Elimina todos los registros telefónicos del paciente. */
			$query2 = "delete from ".$DBName.".telephone where pat_id = '".utf8_decode($pat)."'";
			@mysql_query($query2, $link);

			if($tel != "") {
				$telArray = explode("*", $tel);
				array_pop($telArray);
				foreach($telArray as $item => $tel) {
					if(strpos($tel, " - ") !== false) {
						$telNum = explode(" - ", $tel);
						$tel = $telNum[0];
						$tel = preg_replace('/\(([0-9]+)\)\s+/', '', $tel);
						$telabbr = $telNum[1];

						/** Obtiene el tipo de telefono. */
						$teltype = "0";
						$query3 = "select tlt_id from ".$DBName.".teltype where tlt_abbr = '".$telabbr."'";
						if($result3 = @mysql_query($query3, $link)) {
							$teltype = @mysql_result($result3, 0);
							@mysql_free_result($result3);
						}

						/** Inserta los telefonos del paciente. */
						$query4 = "insert into ".$DBName.".telephone values (null, '".utf8_decode($pat)."', 0, 0, 0, ".$teltype.", 52, 55, '".$tel."', 0)";
						@mysql_query($query4, $link);
						if(@mysql_affected_rows($link) >= 0) {
							$res = "OK";
						}
					}
				}
			}
		}
	}
	echo $res;
?>
