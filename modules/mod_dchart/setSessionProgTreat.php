<?php

include '../mod_mailAlert/mailFunction.php';

$string = (isset($_POST["string"]) && !empty($_POST["string"])) ? $_POST["string"] : "";
$affected = 0;

/** Establece la zona horaria para trabajar con fechas. */
date_default_timezone_set("America/Mexico_City");

//***************************************** fechas
$fechahoy = date("Y-m-d");

$hora = new DateTime();
$horaactual = $hora->format("H:i:s");

$fmd = new DateTime();
$fmd->modify("+16 days");

$findemesactual = new DateTime();
$findemes = $findemesactual->format("Y-m-t");

//***************************
$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
$d = (int) date("d", $today);
$m = (int) date("m", $today);
$Y = (int) date("Y", $today);

if (($d >= '1' && $d <= '15')) {
    $fechapagoinicial = $findemes;
} else if ($d >= 16 && $d <= $findemes) {
    $mesdespues1quincena = $fmd->format("Y-m-15");
    $fechapagoinicial = $mesdespues1quincena;
}
//***************************************************************************************************************

if ($string != "") {
    $sArray = explode("|", $string);
    if (count($sArray) == 4) {
        $sid = $sArray[0];
        $cli = $sArray[1];
        $pat = $sArray[2];
        $string = $sArray[3];
        $pat = utf8_decode($pat);
        $sArray = explode("*", $string);
        array_pop($sArray);

        if (count($sArray) > 0) {
            /** Llama al archivo de configuracion. */
            include "../../config.inc.php";

            /** Obtiene un objeto de conexion con la base de datos. */
            $link = @mysql_pconnect($DBServer, $DBUser, $DBPaswd);

            $sessnum = $empid = $agrid = "0";
            $sesdate = "";
            $query = "select s.ses_number, s.emp_id, s.ses_date, p.agr_id
				from {$DBName}.session as s left join {$DBName}.patient as p on p.pat_id = s.pat_id
				left join {$DBName}.employee as e on e.emp_id = s.emp_id
				where s.ses_id = {$sid} and s.cli_id = {$cli}";
            if ($result = @mysql_query($query, $link)) {
                list($sessnum, $empid, $sesdate, $agrid) = @mysql_fetch_row($result);
                @mysql_free_result($result);
            }

            /** Obtiene el saldo del paciente. */
            $bal = 0;
            $query = "select p.pagado - sum(s.suma) from (select sum(rec_amount) as pagado
				from {$DBName}.receipt where pat_id = '{$pat}' and rec_status = 0
				and rec_paymeth != 'PA') as p, (select rec_payment as suma from {$DBName}.receipt
				where pat_id = '{$pat}' and rec_status = 0 group by rec_number) as s group by p.pagado";
            if ($result = @mysql_query($query, $link)) {
                $bal = @mysql_result($result, 0);
                @mysql_free_result($result);
            }
            $bal = is_null($bal) ? 0 : intval($bal, 10);

            //*** Determina el tipo y la clase de la clinica.
            $cli_class = "2";
            $cli_type = "1";
            $query = "select clc_id, clt_id, cli_name from {$DBName}.clinic where cli_id = {$cli}";
            if ($result = @mysql_query($query, $link)) {
                list($cli_class, $cli_type, $cli_name) = @mysql_fetch_row($result);
                @mysql_free_result($result);
            }
            $cli_class = is_null($cli_class) ? "2" : $cli_class;
            $cli_type = is_null($cli_type) ? "1" : $cli_type;
            $trtProg = array();
            if ($sessnum != "0") {
                foreach ($sArray as $item => $value) {
                    $query = "select tpg_id, pat_id, trt_id, tpg_qty, tpg_sessnum,
						tpg_sessfrom, trp_price, agt_discount, trs_amount, tpg_payment,
						rec_number, tht_id, trt_comb, null, tht_class
						from {$DBName}.treatprog where tpg_id = {$value} limit 1";
                    if ($result = @mysql_query($query, $link)) {
                        $row = @mysql_fetch_row($result);
                        $sesscount = is_null($row[4]) ? 1 : intval($row[4], 10);
                        $sess = is_null($row[5]) ? 1 : intval($row[5], 10);
                        $treat = $row[2];
                        $tpricemod = floatval($row[6]);
                        $tdis = round($row[7]);
                        $tamount = floatval($row[8]);
                        $tpayment = floatval($row[9]);
                        $recnum = intval($row[10], 10);
                        $tht_id = intval($row[11], 10);
                        $trt_comb = is_null($row[12]) ? "" : $row[12];
                        $tht_class = is_null($row[14]) ? "" : $row[14];

                        $spc = 0;
                        $query7 = "select trt_divsess, spc_id from {$DBName}.treatment where trt_id = {$treat}";
                        if ($result7 = @mysql_query($query7, $link)) {
                            list($trt_divsess, $spc) = @mysql_fetch_row($result7);
                            @mysql_free_result($result7);
                        }
                        //$comm = ($spc > 1 && $spc < 9) ? 30 : (($spc > 9 || $spc < 2) ? 0 : 40);
                        /* $spcArray = array("3", "4", "6", "7", "8", "11");
                          $comm = (array_search($spc, $spcArray) !== false) ? 40 : 30; */
                        $comm = ($spc < 2) ? 0 : (($spc > 2) ? 40 : 30);
                        if ($empid == 89)
                            $comm = 30;
                        if ($empid == 33)
                            $comm = 25;

                        $query2 = "insert into {$DBName}.treatsession set ses_number = {$sessnum},
							trt_id = {$treat}, trs_sessnum = {$sesscount}, trs_sessfrom = {$sess}, cli_id = {$cli},
							trp_price = {$tpricemod}, agt_discount = {$tdis}, trs_amount = {$tamount},
							trs_payment = {$tpayment}, rec_number = {$recnum}, tht_id = {$tht_id},
							trt_comb = '{$trt_comb}', tht_class = '{$tht_class}'";
                        @mysql_query($query2, $link);
                        if (@mysql_affected_rows($link) !== false) {
                            $affected++;
                            $trsid = @mysql_insert_id($link);
                        }

                        /*                         * Obtenemos los costos del tratamiento */
                        $fcost = $scost = $lcost = "0";
                        $query4 = "select trc_fcost, trc_scost, trc_lcost from {$DBName}.treatcost
							where trc_date <= '{$sesdate}' and trt_id = {$treat} order by trc_date desc limit 1";
                        if ($result4 = @mysql_query($query4, $link)) {
                            list($fcost, $scost, $lcost) = @mysql_fetch_row($result4);
                            @mysql_free_result($result4);
                        }

                        //*** Determina el precio y costos del tratamiento si es de ortodoncia.
                        //*** Esto es TEMPORAL****************************************
                        $tpricecomm = "0";
                        $fcostcomm = $scostcomm = $lcostcomm = "0";
                        if ($spc == "4") {
                            $query2 = "select t.trp_price from {$DBName}.treatprice as t
								where t.trt_id = {$treat} and t.cli_class = {$cli_class} and
								t.trp_date <= '2009-12-01' order by t.trp_date desc limit 1";
                            if ($result2 = @mysql_query($query2, $link)) {
                                $tpricecomm = @mysql_result($result2, 0);
                                @mysql_free_result($result2);
                            }
                            $tpricecomm = is_null($tpricecomm) ? 0 : intval($tpricecomm, 10);

                            $query4 = "select trc_fcost, trc_scost, trc_lcost
								from {$DBName}.treatcost where trc_date <= '2009-12-01'
								and trt_id = {$treat} order by trc_date desc limit 1";
                            if ($result4 = @mysql_query($query4, $link)) {
                                list($fcostcomm, $scostcomm, $lcostcomm) = @mysql_fetch_row($result4);
                                @mysql_free_result($result4);
                            }
                        } else {
                            $tpricecomm = $tpricemod;
                            $fcostcomm = $fcost;
                            $scostcomm = $scost;
                            $lcostcomm = $lcost;
                            $tdiscomm = $tdis;
                        }

                        /** Determina el costo fijo real. */
                        $totsess = ($sess == 0) ? 1 : $sess;
                        $rfcost = $fcostcomm / $totsess;
                        $rfcostcomm = $fcostcomm / $totsess;
                        $rlcost = $lcostcomm / $totsess;
                        $rlcostcomm = $lcostcomm / $totsess;
                        $rfcost += $rlcost;

                        //*** Determina el diferencial del precio del tratamiento
                        // respecto al numero de sesiones en que se divide dicho
                        // tratamiento.
                        $price_diff = ($sess == 1 || $trt_divsess == 0) ? 1 : floatval(1 / $sess);
                        if ($tdis == 0 && $tpricemod != $tamount) {
                            $tpricemod = $tamount;
                            if ($spc == "4") {
                                $tpricemod = $tamount = ($tpricecomm * $price_diff);
                                $tpayment = $tamount;
                            }
                        } else if ($tdis > 0 && $tdis < 100 && $tamount == 0) {
                            $tpricemod = 0;
                        } else if ($tdis > 0 && $tdis < 100 && $tamount != 0) {
                            $tpricemod = $tamount / (1 - ($tdis / 100));
                            //           220      / (1 - (80    / 100))
                            if ($spc == "4") {
                                $tpricemod = ($tpricecomm * $price_diff);
                                $factor = (1 - (intval($tdis, 10) / 100));
                                $tamount = $tpricemod * $factor;
                                $tpayment = $tamount;
                            }
                        } else if ($spc == "4") {
                            $tpricemod = ($tpricecomm * $price_diff);
                            $factor = (1 - (intval($tdis, 10) / 100));
                            $tamount = $tpricemod * $factor;
                            $tpayment = $tamount;
                        }

                        /** Determina la base de la comision, respecto a la especialidad del tratamiento */
                        /** y el porcentaje de descuento. */
                        $factor = ($tdis >= 50 && $spc > 2) ? 0.8 : (($tdis >= 50 && $spc == 2) ? 0.5 : 1);
                        $base = ($tdis < 50) ? $tamount : ($tpricemod * $factor);

                        $tcost = $rfcost + $scostcomm;

                        /** Determina la utilidad bruta. */
                        $util = $base - $rfcost - $scostcomm;
                        $util = ($util < 0) ? 0 : $util;

                        $tcomm = $util * ($comm / 100);
                        if ($treat == 36)
                            $tcomm = 0;

                        if ($empid == 152 || $empid == 37 || $empid == 159 || $empid == 169 || $empid == 164) {
                            $tcomm = 0;
                        }
                        if ($bal < 0) {
                            $feestatus = 1;
                            $tcomm = 0;
                        } else if ($bal >= 0) {
                            $feestatus = 4;
                        }

                        // Determina la fecha de pago de la comision
                        $sdArray = explode("-", $sesdate);
                        $today = mktime(0, 0, 0, $sdArray[1], $sdArray[2] + 16, $sdArray[0]);
                        $d = (int) date("d", $today);
                        $m = (int) date("m", $today);
                        $Y = (int) date("Y", $today);
                        if ($d > 15) {
                            $mtfi = mktime(0, 0, 0, $m, 16, $Y);
                            $ld = (int) date("t", $mtfi);
                            $mtff = mktime(0, 0, 0, $m, $ld, $Y);
                        } elseif ($d < 15) {
                            $mtff = mktime(0, 0, 0, $m, 15, $Y);
                        }
                        $ff = @date("Y-m-d", $mtff);

                        // si el trt tienen 50% o mas de descuento, se enviara la alerta
                        if ($tdis >= 50) {
                            $trtProg[] = $treat;
                        }
                        
                        //descuentos del 70 al 80 en AXA
                        // $trtdis, $agrid
                        $axaIni = "2016-07-22";
                        $axaFin = "2016-08-22";
                        $casosAxa = array(180, 213, 399, 400);
                        $axaHoy = date("Y-m-d");
                        if ($axaHoy >= $axaIni && $axaHoy <= $axaFin && $tdis == 70 && in_array($agrid, $casosAxa)) {
                            $tdis = 80;
                        }
                        
                        /**
                         * Inserta un registro en la tabla de comisiones, de acuerdo con la
                         * informacion recabada de los tratamientos programados.
                         * @var {String} $query5
                         */
                        $query5 = "insert into {$DBName}.fee set ses_date = '{$sesdate}', cli_id = {$cli},
							emp_id = {$empid}, pat_id = '{$pat}', pat_balance = {$bal}, trt_id = {$treat},
							agr_id = {$agrid}, ses_id = {$sid}, trs_sessnum = {$sesscount}, trs_sessfrom = {$sess},
							trt_price = {$tpricemod}, agt_discount = {$tdis}, trs_amount = {$tamount},
							trs_payment = {$tpayment}, trc_fcost = {$rfcostcomm}, trc_scost = {$scostcomm},
							trc_lcost = {$rlcostcomm}, rec_number = {$recnum}, trs_id = {$trsid}, fee_base = {$base},
							fee_commp = {$comm}, fee_profit = {$util}, fee_comm = 0, fee_paydate = '{$fechapagoinicial}',
							tht_id = {$tht_id}, trt_comb = '{$trt_comb}', fee_status = '{$feestatus}',
							fee_vista = '{$fechapagoinicial}', fee_viewlast = 2, tht_class = '{$tht_class}'";
                        @mysql_query($query5, $link);

                        @mysql_free_result($result);
                    }

                    $query = "delete from {$DBName}.treatprog where tpg_id = {$value} limit 1";
                    @mysql_query($query, $link);
                }

                /* Nuevo codigo para las alertas por correo */
                $patName = "";
                $queryPat = "SELECT pat_complete FROM {$DBName}.patient where pat_id = '{$pat}'; ";
                if ($resPat = @mysql_query($queryPat, $link)) {
                    $patName = @mysql_result($resPat, 0);
                    @mysql_free_result($resPat);
                }
                $alert = sendMailAlert($trtProg, $patName, $cli_name, "Session");
            }
        }
    }
}
echo ($affected > 0) ? "OK" : "ERROR";
?>