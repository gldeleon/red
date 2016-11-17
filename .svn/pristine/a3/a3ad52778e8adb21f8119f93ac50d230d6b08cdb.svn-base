<?php
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$sess = (isset($_POST["sess"]) && !empty($_POST["sess"])) ? $_POST["sess"] : "0";
	$usr = (isset($_POST["usr"]) && !empty($_POST["usr"])) ? $_POST["usr"] : "1";
	$ps = (isset($_POST["ps"]) && !empty($_POST["ps"])) ? $_POST["ps"] : "";
	$packs = (isset($_POST["packs"]) && !empty($_POST["packs"])) ? $_POST["packs"] : "";
	$income = (isset($_POST["income"]) && !empty($_POST["income"])) ? $_POST["income"] : "0";
	$res = "ERROR";

	if($pat != "" && $cli != "0" && $usr != "0" && $sess != "0") {

		date_default_timezone_set("America/Mexico_City");

		include "../config.inc.php";
		include "patient.class.php";

		$pat = utf8_decode($pat);
		$patClass = new Patient($pat);
		$pay = explode("|", $ps);
		array_pop($pay);

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$sessnum = "1";
		$query = "select ses_number from {$DBName}.session where ses_id = {$sess}";
		if($result = @mysql_query($query, $link)) {
			$sessnum = @mysql_result($result, 0);
			@mysql_free_result($result);
		}
		$sessnum = is_null($sessnum) ? "1" : $sessnum;

		$recnum = "1";
		$query = "select max(rec_number) + 1 from {$DBName}.receipt where cli_id = {$cli}";
		if($result = @mysql_query($query, $link)) {
			$recnum = @mysql_result($result, 0);
			@mysql_free_result($result);
		}
		$recnum = is_null($recnum) ? "1" : $recnum;

		/** Obtiene el saldo del paciente. */
		$bal = $patClass->getPatientBalance();
		$bal = is_null($bal) ? 0 : $bal;

//if de saldo
	if($bal >= 0) {
		$query =  "update {$DBName}.treatsession set rec_number = '{$recnum}'
		where ses_number = '{$sessnum}' and cli_id = '{$cli}'";
		@mysql_query($query, $link);

		$affected = 0;
		$receiptids = array();
		foreach($pay as $item => $value) {
			/** Extrae los valores de la cadena a traves de un arreglo. */
			list($payment, $meth, $ban, $ref) = explode("*", $value);

			$query = "insert into {$DBName}.receipt set ses_number = {$sessnum}, pat_id = '{$pat}', ban_id = {$ban},
			usr_id = {$usr}, cli_id = {$cli}, rec_number = {$recnum}, rec_date = '".date("Y-m-d")."',
			rec_subject = '{$ref}', rec_amount = {$payment}, rec_paymeth = '{$meth}', rec_payment = {$income}";

			if($result = @mysql_query($query, $link)) {
				if(@mysql_affected_rows($link) > 0) {
					$affected++;
					$receiptids[] = @mysql_insert_id($link);
				}
				@mysql_free_result($result);
			}

		}//fin del foreach
		if($affected > 0) {
			$res = "OK*".$recnum;
		}
	}//fin del if de saldo
//parte editada por mi
	else if($bal<0){
                $debt = $bal;
		$query =  "update {$DBName}.treatsession set rec_number = '{$recnum}' 
		where ses_number = '{$sessnum}' and cli_id = '{$cli}'";
		@mysql_query($query, $link);

		$affected = $pmdeuda = 0;
		$receiptids = array();
		foreach($pay as $item => $value) {
			/** Extrae los valores de la cadena a traves de un arreglo. */
			list($payment, $meth, $ban, $ref) = explode("*", $value);
			$saldo=$bal*(-1);

                        if($debt < 0){
                           //$debt += $payment;
//                           $paymentModif=$payment+$debt;
                           $debt += $payment;
//                           $paymentModif = ($paymentModif < 0) ? 0 : $paymentModif;
                        }
//                       else{
                           $paymentModif = $payment;
//                       }


                       //if($paymentModif != 0){
                                $query = "insert into {$DBName}.receipt set ses_number = {$sessnum}, pat_id = '{$pat}', ban_id = {$ban},
                                usr_id = {$usr}, cli_id = {$cli}, rec_number = {$recnum}, rec_date = '".date("Y-m-d")."',
                                rec_subject = '{$ref}', rec_amount = {$paymentModif}, rec_paymeth = '{$meth}', rec_payment = {$income}";

                                if($result = @mysql_query($query, $link)) {
                                        if(@mysql_affected_rows($link) > 0) {
                                                $affected++;
                                                $receiptids[] = @mysql_insert_id($link);
                                        }
                                        @mysql_free_result($result);
                                }
                       //}
                       $pmdeuda += $paymentModif;

		}//fin del foreach

                if($pmdeuda >= abs($bal)){

                $query = "insert into {$DBName}.receipt set ses_number = {$sessnum}, pat_id = '{$pat}', ban_id = 0,
			usr_id = {$usr}, cli_id = {$cli}, rec_number = {$recnum}, rec_date = '".date("Y-m-d")."',
			rec_subject = '0', rec_amount = {$bal}, rec_paymeth = 'PD', rec_payment = {$income}";

			if($result = @mysql_query($query, $link)) {
				if(@mysql_affected_rows($link) > 0) {
					$affected++;
					$receiptids[] = @mysql_insert_id($link);
				}
				@mysql_free_result($result);
			}

		if($affected > 0) {
			$res = "OK*".$recnum;
		}
                }else{
                     $newbal = $pmdeuda*(-1);
                $query = "insert into {$DBName}.receipt set ses_number = {$sessnum}, pat_id = '{$pat}', ban_id = 0,
			usr_id = {$usr}, cli_id = {$cli}, rec_number = {$recnum}, rec_date = '".date("Y-m-d")."',
			rec_subject = '0', rec_amount = {$newbal}, rec_paymeth = 'PD', rec_payment = {$income}";

			if($result = @mysql_query($query, $link)) {
				if(@mysql_affected_rows($link) > 0) {
					$affected++;
					$receiptids[] = @mysql_insert_id($link);
				}
				@mysql_free_result($result);
			}

			if ($affected > 0) {
				$res = "OK*".$recnum;
			}
		}
		}//fin del else del if de saldo

		$bal = $patClass->getPatientBalance();
		$bal = is_null($bal) ? 0 : $bal;

		foreach($receiptids as $item => $value) {
			$query = "update {$DBName}.receipt set pat_balance = '{$bal}' where rec_id = {$value}";
			@mysql_query($query, $link);
		}
	}//fin del if principal
	echo $res;
?>