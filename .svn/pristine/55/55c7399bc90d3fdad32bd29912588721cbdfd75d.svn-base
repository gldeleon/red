<?php

include "../../config.inc.php";
date_default_timezone_set("America/Mexico_City");

$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

$query = "SELECT td.ttd_ename, td.ttd_code, td.{$campo}, t.trt_abbr, td.ttd_ttype, td.ttd_sface
                            FROM {$DBName}.totaldent as td left join {$DBName}.treatment as t on t.trt_id = td.trt_id
                            WHERE td.trt_id = {$txc} ";

                        if($sfc != "" && $tht == ""){
                            $ttd_sface = " AND td.ttd_sface = '{$sfc}' ";
                        }
                        else if ($sfc == "" && $tht != ""){
                            $ttd_sface = " AND td.ttd_sface = '{$tht}' ";
                        }
                        else if($sfc == "" && $tht == ""){
                            $ttd_sface = " AND td.ttd_sface IS NULL ";
                        }
                        else if($sfc != "" && $tht != ""){

                            if(is_numeric($tht) && ($typ != "POS" && $typ != "ANT")){
                                $ttd_sface = " AND td.ttd_sface = '{$tht}' ";
                            }
                            else if(!is_numeric($tht) && ($typ != "POS" && $typ != "ANT")){
                                $ttd_sface = " AND td.ttd_sface = '{$tht}' ";
                            }
                            else if(is_numeric($tht) && ($typ == "POS" || $typ == "ANT")){
                                $ttd_sface = " AND td.ttd_sface = '{$sfc}' ";
                            }
                            else if(!is_numeric($tht) && ($typ == "POS" || $typ == "ANT")){
                                $ttd_sface = " AND td.ttd_sface = '{$sfc}' ";
                            }

                        }

                        if($typ != ""){
                            $ttd_ttype = " AND td.ttd_ttype = '{$typ}' ";
                        }
                        else{
                            $ttd_ttype = " AND td.ttd_ttype IS NULL ";
                        }


$query .= "{$ttd_sface} {$ttd_ttype} ";
$query .= "ORDER BY td.ttd_date desc limit 1";

if($result = @mysql_query($query, $link)) {
	if(@mysql_num_rows($result) > 0) {
            list($ttd_ename, $ttd_code, $tprice, $tabbr, $ttd_ttype, $ttd_sface) = @mysql_fetch_row($result);
				$tabbr = utf8_encode($tabbr);

            if(is_null($tprice)) {
                    $res = "NA";
            }
            

        }
        else{

           $res = "Error";

        }

}

?>
