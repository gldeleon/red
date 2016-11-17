<?php

include '../mod_mailAlert/mailFunction.php';

$string = (isset($_POST["string"]) && !empty($_POST["string"])) ? $_POST["string"] : "";
$tht = (isset($_POST["tht"]) && !empty($_POST["tht"])) ? $_POST["tht"] : "0";
$sfc = (isset($_POST["sfc"]) && !empty($_POST["sfc"])) ? $_POST["sfc"] : "";
$affected = 0;

$tooth = explode("*", $tht);
$tht = $tooth[0];

/** Establece la zona horaria para trabajar con fechas. */
date_default_timezone_set("America/Mexico_City");

if ($string != "") {
    $sArray = explode("|", $string);
    if (count($sArray) >= 6) {
        $pat = $sArray[0];
        $cli = $sArray[1];
        $uid = $sArray[2];
        $stage = ($sArray[3] == "0") ? "1" : $sArray[3];
        $bud = $sArray[4];
        $string = $sArray[5];
        $sArray = explode("*", $string);
        array_pop($sArray);

        if (count($sArray) > 0) {
            /** Llama al archivo de configuracion. */
            include "../../config.inc.php";

            $link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

            /** Determina la clase de la clinica. */
            $cli_class = "2";
            $query8 = "select clc_id, cli_name from {$DBName}.clinic where cli_id = {$cli}";
            if ($result8 = @mysql_query($query8, $link)) {
                list($cli_class, $cli_name) = @mysql_fetch_row($result8);
                @mysql_free_result($result8);
            }
            $cli_class = is_null($cli_class) ? "2" : $cli_class;

            $budnum = 0;
            $buddate = date("Y-m-d");
            if ($bud == "0") {
                $query = "select max(bud_number) + 1, '" . date("Y-m-d") . "' from {$DBName}.budget where cli_id = {$cli}";
            } else {
                $query = "select bud_number, bud_date from {$DBName}.budget where bud_id = {$bud}";
            }
            if ($result = @mysql_query($query, $link)) {
                list($budnum, $buddate) = @mysql_fetch_row($result);
                @mysql_free_result($result);
            }
            $budnum = (is_null($budnum) || intval($budnum, 10) == 0 || $budnum == "") ? 1 : intval($budnum, 10);
            $buddate = (is_null($buddate) || $bud == "0") ? date("Y-m-d") : $buddate;

            if ($bud == "0") {
                $query = "insert into {$DBName}.budget set pat_id = '" . utf8_decode($pat) . "', cli_id = {$cli},
					usr_id = {$uid}, bud_number = {$budnum}, bud_date = '" . date("Y-m-d") . "'";
                if (@mysql_query($query, $link)) {
                    if (@mysql_affected_rows($link) > 0)
                        $affected++;
                    $bud = @mysql_insert_id($link);
                }
            }
            elseif ($budnum != 0 && $bud) {
                $affected++;
            }

            $thtclass = $thtvpos = $thtzpos = "";
            //nuevo arreglo para las alertas
            $trtList = array();
            if ($affected > 0 && $bud) {
                foreach ($sArray as $item => $value) {
                    list($treat, $tqty, $tprice) = explode("=", $value);

                    $trtPrices = array();
                    for ($i = 0; $i < $tqty; $i++) {
                        $trtPrices = getPrice($DBName, $pat, $treat, $cli_class, $link);
                        $tdis = $trtPrices[0];
                        $tamount = $trtPrices[1];
                        $tpricemod = $trtPrices[2];

                        // si el trt tienen 50% o mas de descuento, se enviara la alerta
                        // si se ingresaron dos o mas cantidades del mismo trt s etoma la primera
                        if ($tdis >= 50 && $i == 0) {
                            $trtProg[] = $treat;
                        }
                        if (is_numeric($tht)) {
                            $toothquery = "SELECT tht_class, tht_vpos, tht_zpos FROM {$DBName}.tooth
								WHERE tht_cid = {$tht}";
                            if ($result = @mysql_query($toothquery, $link)) {
                                list($thtclass, $thtvpos, $thtzpos) = @mysql_fetch_row($result);
                                @mysql_free_result($result);
                            }
                        } else {
                            $tht = 0;
                        }

                        $query = "insert into {$DBName}.budtreat set bud_number = {$budnum}, trt_id = {$treat},
							cli_id = {$cli}, bud_qty = 1, trp_price = {$tpricemod}, agt_discount = {$tdis},
							trs_amount = {$tamount}, btr_stage = {$stage}, bun_id = 0, tht_cid = {$tht},
							trt_comb = '{$sfc}', tht_class = '{$thtclass}', tht_vpos = '{$thtvpos}',
							tht_zpos = '{$thtzpos}', treatgto_id = {$bud}";
                        @mysql_query($query, $link);

                        $btr_id = mysql_insert_id($link);
                    }

                    if (@mysql_affected_rows($link) !== false) {
                        $affected++;
                    }

                    $update = "update {$DBName}.budtreat SET bud_number = {$budnum}
						where bud_number = {$bud}";
                    if ($upresult1 = @mysql_query($update, $link)) {
                        @mysql_free_result($upresult1);
                    }

                    //echo "<br / ><br / >";

                    $update2 = "update {$DBName}.budtreat SET bud_number = {$budnum}
						where bud_number = 0";
                    if ($upresult2 = @mysql_query($update2, $link)) {
                        @mysql_free_result($upresult2);
                    }
                }

                /* Nuevo codigo para las alertas por correo */
                $patName = "";
                $queryPat = "SELECT pat_complete FROM {$DBName}.patient where pat_id = '{$pat}'; ";
                if ($resPat = @mysql_query($queryPat, $link)) {
                    $patName = @mysql_result($resPat, 0);
                    @mysql_free_result($resPat);
                }
                $alerta = sendMailAlert($trtList, $patName, $cli_name, "Budget");
            }
        }
    }
}

function getPrice($DBName, $pat, $treat, $cli_class, $link) {
    $tdis = $agr_id = $agt_incdisc = "0";
    $agt_price = "";

    /* Buscar el tratamiento en el Plan para el paciente. */
    $queryjcc = "select at.agt_inctreat, at.agt_incdisc, at.agt_discount, 
					at.agt_price, p.agr_id, at.agt_incdiscgrp
					from {$DBName}.agreetreat as at
					left join {$DBName}.patient as p on p.agr_id = at.agr_id
					where p.pat_id = '" . utf8_decode($pat) . "' and at.trt_id = {$treat}
					and at.agt_date <= curdate() order by at.agt_date desc limit 1";
    $resultjcc = @mysql_query($queryjcc, $link);
    list($agt_inctreat, $agt_incdisc, $agt_discount, $agt_price, $agr_id, $agt_incdiscgrp) = mysql_fetch_row($resultjcc);
    /* Verifica si incluye tratamientos con descuento especial por cantidad, 
     * ej. Incluye dos resinas al 100% de descuento, y el resto a 70% */
    if (($agt_inctreat != "") && ($agt_inctreat != "0")) {
        $i = 0;
        /* El tratamiento esta agrupado con otros */
        if ($agt_incdiscgrp != "0") {
            $gta_grp = "0";
            /* Obtiene la clave de grupo del tratamiento */
            $queryjcc4 = "select gr.gta_grp from {$DBName}.grptreatagr as gr 
								where gr.trt_id = '{$treat}' and gr.gta_active = 1";
            $resultjcc4 = @mysql_query($queryjcc4, $link);
            if (@mysql_num_rows($resultjcc4) > 0) {
                $gta_grp = @mysql_result($resultjcc4, 0);
            }
            /* Verifica que el grupo exista */
            if (($gta_grp !== false) && $gta_grp > 0) {
                /* Verifica si el paciente ya se hizo algun tratamiento de ese grupo */
                $queryjcc5 = "select count(ts.trs_id) from {$DBName}.treatsession as ts
									left join {$DBName}.session as s on s.ses_number = ts.ses_number and s.cli_id = ts.cli_id 
									where s.pat_id = '" . utf8_decode($pat) . "' and s.ses_date between 
									date_sub(curdate(), interval 1 year) and curdate() and ts.trt_id in (
										select trt_id from {$DBName}.grptreatagr where gta_grp = '{$gta_grp}'
									) and (s.ses_status = 6 or s.ses_status = 0)";
                if ($resultjcc5 = mysql_query($queryjcc5, $link)) {
                    $i += @mysql_result($resultjcc5, 0);
                }
                /* Verifica el numero de tratamientos en el presupuesto */
                $queryjcc6 = "select count(bt.btr_id) from {$DBName}.budtreat as bt
									left join {$DBName}.budget as b on b.bud_number = bt.bud_number and b.cli_id = bt.cli_id 
									where b.pat_id = '" . utf8_decode($pat) . "' and b.bud_date between 
									date_sub(curdate(), interval 1 year) and curdate() and bt.trt_id in (
										select trt_id from {$DBName}.grptreatagr where gta_grp = '{$gta_grp}'
									)";
                if ($resultjcc6 = mysql_query($queryjcc6, $link)) {
                    $i += @mysql_result($resultjcc6, 0);
                }
                /* Compara la cuenta contra el numero de tratamientos incluidos y agrupados */
                if ($i < $agt_inctreat) {
                    $tdis = $agt_incdisc;
                } else {
                    $tdis = $agt_discount;
                }
            }
            /* Si el grupo no existe */ else {
                $trtGrpDoesntExists = true;
            }
        }
        /* El tratamiento no esta agrupado */
        /* Esta validacion debe ser excluyente de la anterior por el caso en que
         * el tratamiento se agrupo pero no existe el grupo como tal. */
        if (($agt_incdiscgrp == "0") || isset($trtGrpDoesntExists)) {
            /* Verifica el numero de tratamientos en sesion */
            $queryjcc5 = "select count(ts.trs_id) from {$DBName}.treatsession as ts
								left join {$DBName}.session as s on s.ses_number = ts.ses_number and s.cli_id = ts.cli_id 
								where s.pat_id = '" . utf8_decode($pat) . "' and s.ses_date between 
								date_sub(curdate(), interval 1 year) and curdate() and ts.trt_id = '{$treat}' 
								and (s.ses_status = 6 or s.ses_status = 0)";
            if ($resultjcc5 = @mysql_query($queryjcc5, $link)) {
                if (@mysql_num_rows($resultjcc5) > 0) {
                    $i += @mysql_result($resultjcc5, 0);
                }
            }
            /* Verifica el numero de tratamientos en el presupuesto */
            $queryjcc6 = "select count(bt.btr_id) from {$DBName}.budtreat as bt
								left join {$DBName}.budget as b on b.bud_number = bt.bud_number and b.cli_id = bt.cli_id 
								where b.pat_id = '" . utf8_decode($pat) . "' and b.bud_date between 
								date_sub(curdate(), interval 1 year) and curdate() and bt.trt_id = '{$treat}'";
            if ($resultjcc6 = mysql_query($queryjcc6, $link)) {
                if (@mysql_num_rows($resultjcc6) > 0) {
                    $i += @mysql_result($resultjcc6, 0);
                }
            }
            /* Compara la cuenta contra el numero de tratamientos incluidos */
            if ($i < $agt_inctreat) {
                $tdis = $agt_incdisc;
            } else {
                $tdis = $agt_discount;
            }
        }
    }
    /* El plan no incluye descuentos especiales por cantidad, se 
     * toma el descuento normal */ else {
        $tdis = $agt_discount;
    }

    $tdis = (is_null($tdis) || $tdis == "") ? "0" : $tdis;
    $agt_price = is_null($agt_price || $agt_price == "") ? "" : $agt_price;
    $agr_id = is_null($agr_id || $agr_id == "") ? "0" : $agr_id;

    /* Determina el precio mas reciente del tratamiento */
    $tprice = 0;
    $query2 = "select t.trp_price from {$DBName}.treatprice as t
					where t.trt_id = {$treat} and t.cli_class = {$cli_class} and
					t.trp_date <= curdate() order by t.trp_date desc
					limit 1";
    if ($result2 = @mysql_query($query2, $link)) {
        $tprice = @mysql_result($result2, 0);
        @mysql_free_result($result2);
    }
    $tprice = is_null($tprice) ? 0 : intval($tprice, 10);

    /* Obtiene planes o convenios con precios especiales */
    $agrSpcPrice = array('31', '93');

    /* Verifica que el precio del tratamiento no sea mayor al precio 
     * maximo del plan o convenio definido en $agrSpcPrice */
    $agr_price = NULL;
    if (($agt_price != "") && ($agt_price < $tprice) && (in_array($agr_id, $agrSpcPrice) !== false)) {
        $agr_price = intval($agt_price, 10);
    }

    $tpricemod = ($agr_price != NULL) ? $agr_price : $tprice;
    $tdis = ($agr_price != NULL) ? ((1 - ($agr_price / $tprice)) * 100) : $tdis;
    $factor = (1 - (intval($tdis, 10) / 100));
    $factor = ($agr_price != NULL) ? 1 : $factor;

    /* Verifica que el precio del tratamiento se divida en sesiones. */
    $trt_divsess = 0;
    $sess = 0;
    $query7 = "select trt_sess, trt_divsess from {$DBName}.treatment where trt_id = {$treat}";
    if ($result7 = @mysql_query($query7, $link)) {
        list($sess, $trt_divsess) = mysql_fetch_row($result7);
        @mysql_free_result($result7);
    }
    $trt_divsess = is_null($trt_divsess) ? 0 : intval($trt_divsess, 10);
    $sess = is_null($sess) ? 0 : intval($sess, 10);
    /* Determina el diferencial del precio del tratamiento 
     * respecto al numero de sesiones en que se divide dicho 
     * tratamiento */
    $price_diff = ($sess == 1 || $trt_divsess == 0) ? 1 : floatval(1);

    /* Modifica el precio del tratamiento de acuerdo al 
     * diferencial de sesiones */
    $tpricemod = $tpricemod * $price_diff;
    $tpricemod = round($tpricemod);

    /* Obtiene el monto a pagar en funcion al precio y descuento,
     * tomando en cuenta el numero de sesiones */
    $tamount = $tpricemod * $factor;

    //descuentos del 70 al 80 en AXA
    //$agr_id $tdis
    $axaIni = "2016-07-22";
    $axaFin = "2016-08-22";
    $casosAxa = array(180, 213, 399, 400);
    $axaHoy = date("Y-m-d");
    if ($axaHoy >= $axaIni && $axaHoy <= $axaFin && $tdis == 70 && in_array($agr_id, $casosAxa)) {
        $tdis = 80;
    }
    
    
    return array($tdis, $tamount, $tpricemod);
}

echo ($affected > 1) ? ("OK*" . $bud) : "ERROR";
?>