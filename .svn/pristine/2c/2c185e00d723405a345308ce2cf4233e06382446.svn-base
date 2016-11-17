<?php

include '../mod_mailAlert/mailFunction.php';

$string = (isset($_POST["string"]) && !empty($_POST["string"])) ? $_POST["string"] : "";
$cadena = (isset($_POST["cadena"]) && !empty($_POST["cadena"])) ? $_POST["cadena"] : "";
$affected = 0;

if ($string != "") {
    $sArray = explode("|", $string);
    if (count($sArray) == 5) {
        $sid = $sArray[0];
        $cli = $sArray[1];
        $pat = $sArray[2];
        $thclass = $sArray[3];
        $string = $sArray[4];
        $sArray = explode("*", $string);
        array_pop($sArray);

        if (count($sArray) > 0) {
            /* Llama al archivo de configuracion */
            include "../../config.inc.php";

            /* Establece la zona horaria para trabajar con fechas */
            date_default_timezone_set("America/Mexico_City");

            /* Establece la conexion con la base de datos */
            $link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

            /* Obtiene el numero de sesion */
            $sessnum = $empid = 0;
            $query = "select s.ses_number, s.emp_id from {$DBName}.session as s
				left join {$DBName}.employee as e on e.emp_id = s.emp_id
				where s.ses_id = {$sid} and s.cli_id = {$cli}";
            if ($result = @mysql_query($query, $link)) {
                list($sessnum, $empid) = @mysql_fetch_row($result);
                @mysql_free_result($result);
            }

            /* Determina la clase de la clinica */
            $cli_class = "1";
            $query8 = "select clc_id from {$DBName}.clinic where cli_id = " . $cli;
            if ($result8 = @mysql_query($query8, $link)) {
                $cli_class = @mysql_result($result8, 0);
                @mysql_free_result($result8);
            }
            $cli_class = (is_null($cli_class) || $cli_class == "0") ? "1" : $cli_class;

            /* Determina el tipo de la clinica */
            $cli_type = "1";
            $query9 = "select clt_id, cli_name from {$DBName}.clinic where cli_id = {$cli}";
            if ($result9 = @mysql_query($query9, $link)) {
                list($cli_type, $cli_name) = @mysql_fetch_row($result9);
                @mysql_free_result($result9);
            }
            $cli_type = is_null($cli_type) ? "1" : $cli_type;

            $trtProg = array();
            if ($sessnum != "0") 
            {
                foreach ($sArray as $item => $value) 
                {
                    //*** tratamiento, cantidad, numero de sesiones, sesion actual
                    // UPDATE 2009-09-06: se agrega: diente, caras (separadas
                    // por comas)
                    list($tid, $tqty, $sess, $sesscount, $thoot, $thcomb) = explode("=", $value); //14=1=2=1
                    $thoot = is_null($thoot) ? 0 : $thoot;
                    $thcomb = is_null($thcomb) ? "" : $thcomb;
                    // UPDATE 2010-05-08: se verifica que la cadena contenga alguna coma
                    // para validar correctamente los tratamientos de TotalDent
                    //echo '$thcomb='.$thcomb.'='.(int)is_numeric($thcomb);
                    if (strpos($thcomb, ",") === false && !is_numeric($thcomb)) {
                        $sfc = trim($thcomb);
                        $sfc_array = array("", "V", "D", "P", "M", "O", "", "");
                        $sfc_parts = str_split($sfc);
                        $sfc_string = "";
                        foreach ($sfc_parts as $sfc_value) {
                            $sfcsr = array_search($sfc_value, $sfc_array);
                            if ($sfcsr !== false) {
                                $sfc_string .= $sfcsr . ",";
                            }
                        }
                        if (substr($sfc_string, -1) == ",") {
                            $sfc_string = substr($sfc_string, 0, -1);
                        }
                        $thcomb = $sfc_string;
                    }

                    list($btr_id, $bud_number, $tht_vpos, $tht_zpos) = explode("|", $cadena);
                    $bud_number = (is_null($bud_number) || $bud_number == "") ? "0" : $bud_number;

                    /* Verifica que el precio del tratamiento se divida en sesiones. */
                    $trt_divsess = 0;
                    $query7 = "select trt_divsess from {$DBName}.treatment where trt_id = {$tid}";
                    if ($result7 = @mysql_query($query7, $link)) {
                        $trt_divsess = @mysql_result($result7, 0);
                        @mysql_free_result($result7);
                    }
                    $trt_divsess = is_null($trt_divsess) ? 0 : intval($trt_divsess, 10);

                    $tdis = $agr_id = $agt_incdisc = "0";
                    $agt_price = "";

                    /* Buscar el tratamiento en el Plan para el paciente. */
                    $queryjcc = "select at.agt_inctreat, at.agt_incdisc, at.agt_discount, 
						at.agt_price, p.agr_id, at.agt_incdiscgrp
						from {$DBName}.agreetreat as at
						left join {$DBName}.patient as p on p.agr_id = at.agr_id
						where p.pat_id = '" . utf8_decode($pat) . "' and at.trt_id = {$tid}
						and at.agt_date <= curdate() order by at.agt_date desc limit 1";
                    $resultjcc = @mysql_query($queryjcc, $link);
                    list($agt_inctreat, $agt_incdisc, $agt_discount, $agt_price, $agr_id,
                            $agt_incdiscgrp) = mysql_fetch_row($resultjcc);
                    /* Verifica si incluye tratamientos con descuento especial por cantidad, 
                     * ej. Incluye dos resinas al 100% de descuento, y el resto a 70% */
                    if (($agt_inctreat != "") && ($agt_inctreat != "0")) {
                        $i = 0;
                        /* El tratamiento esta agrupado con otros */
                        if ($agt_incdiscgrp != "0") {
                            $gta_grp = "0";
                            /* Obtiene la clave de grupo del tratamiento */
                            $queryjcc4 = "select gr.gta_grp from {$DBName}.grptreatagr as gr 
								where gr.trt_id = '{$tid}' and gr.gta_active = 1";
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
								date_sub(curdate(), interval 1 year) and curdate() and ts.trt_id = '{$tid}' 
								and (s.ses_status = 6 or s.ses_status = 0)";
                            if ($resultjcc5 = @mysql_query($queryjcc5, $link)) {
                                if (@mysql_num_rows($resultjcc5) > 0) {
                                    $i += @mysql_result($resultjcc5, 0);
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
						where t.trt_id = {$tid} and t.cli_class = {$cli_class} and
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

                    /* Determina el diferencial del precio del tratamiento 
                     * respecto al numero de sesiones en que se divide dicho 
                     * tratamiento */
                    $price_diff = ($sess == 1 || $trt_divsess == 0) ? 1 : floatval(1 / $sess);

                    /* Modifica el precio del tratamiento de acuerdo al 
                     * diferencial de sesiones */
                    $tpricemod = $tpricemod * $price_diff;
                    $tpricemod = round($tpricemod);

                    /* Obtiene el monto a pagar en funcion al precio y descuento,
                     * tomando en cuenta el numero de sesiones */
                    $tamount = $tpricemod * $factor;


                    // si el trt tienen 50% o mas de descuento, se enviara la alerta
                    if ($tdis >= 50) {
                        $trtProg[] = $tid;
                    }
                    
                    //descuentos del 70 al 80 en AXA
                    // $trtdis, $agr_id
                    $axaIni = "2016-07-22";
                    $axaFin = "2016-08-22";
                    $casosAxa = array(180, 213, 399, 400);
                    $axaHoy = date("Y-m-d");
                    if ($axaHoy >= $axaIni && $axaHoy <= $axaFin && $tdis == 70 && in_array($agr_id, $casosAxa)) {
                        $tdis = 80;
                    }

                    for ($j = 0; $j < $tqty; $j++) {
                        $query = "insert into {$DBName}.treatsession set ses_number = {$sessnum}, trt_id = {$tid},
							trs_sessnum = {$sesscount}, trs_sessfrom = {$sess}, cli_id = {$cli}, trp_price = {$tpricemod},
							agt_discount = {$tdis}, trs_amount = {$tamount}, rec_number = 0, tht_id = {$thoot},
							trt_comb = '{$thcomb}', tht_class = '{$thclass}', btr_id = {$btr_id}, bud_number = {$bud_number},
							tht_vpos = '{$tht_vpos}', tht_zpos = '{$tht_zpos}'";
                        @mysql_query($query, $link);
                        if (@mysql_affected_rows($link) !== false) {
                            $affected++;
                        }
                    }
                    if (($sess > 1) && ($sesscount < $sess)) {
                        for ($j = 0; $j < $tqty; $j++) {
                            for ($i = $sesscount; $i < $sess; $i++) {
                                $query4 = "insert into {$DBName}.treatprog set pat_id = '" . utf8_decode($pat) . "',
									trt_id = {$tid}, tpg_sessnum = " . ($i + 1) . ", tpg_sessfrom = {$sess},
									trp_price = {$tpricemod}, agt_discount = {$tdis}, trs_amount = {$tamount},
									tht_id = {$thoot}, trt_comb = '{$thcomb}', tht_class = '{$thclass}'";
                                @mysql_query($query4, $link);
                            }
                        }
                    }
                }
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
echo ($affected > 0) ? "OK" : "ERROR";
?>