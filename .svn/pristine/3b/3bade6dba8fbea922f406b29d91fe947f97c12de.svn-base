<?php 
include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/functions.inc.php";
include_once "../../../lib/execQuery.class.php";
include_once '../../../config.class.php';
include_once 'mod_spcschedule_select.class.php';

$start = (isset($_GET["start"]) && !empty($_GET["start"])) ? $_GET["start"] : "";
$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "";


list($yi, $mi, $di) = explode("-", $start);

        $query = mod_spcschedule_select::selectFreeBusy($cli);
        $execQuery = new execQuery($query);
        $result = $execQuery->getQueryResults();
        $jsonArray = $week = $check = array();
        
        
        for($i = 0; $i<count($result); $i ++){
            $inactivo = $exists = false;
            list($csc_id, $cli_id, $cli_chair, $csc_day, $csc_ini, $csc_end, 
            $csc_date, $csc_date_end, $csc_moddate, $inactive) = explode(__SEPARATOR, $result[$i]);
            
            ###################################################################
            ####      Obtiene los días de la semana que estamos viendo     ####
            ####       los coloca en un arreglo para revisar periodos      ####
            ####             irregulares en caso de que existan.           ####
            ###################################################################
            
            for($j = 0; $j<7; $j++){
                
                $verify_date = date("w", mktime(0, 0, 0, $mi, $di+$j, $yi));
                
                $week[] = date("Y-m-d", mktime(0, 0, 0, $mi, $di+$j, $yi));

                if($verify_date == $csc_day){
                    $strDate = date("M d Y", mktime(0, 0, 0, $mi, $di+$j, $yi));
                    break;
                }
            }
            
            ###################################################################
            ####         Rango de fechas para periodos irregulares         ####
            ###################################################################

            
            if($csc_date != "0000-00-00"){

                    $dias = restaFechas($csc_date, $csc_date_end);
                    $dias = ($dias == 0)? 1 : $dias;

                    for($k = 0; $k<$dias; $k++){
                        list($iyear, $imonth, $iday) = explode("-", $csc_date);
                        $inDates = date("Y-m-d", mktime(0, 0, 0, $imonth, $iday+$k, $iyear));

                        if(in_array($inDates, $week)){

                            $exists = true;
                            break;
                        }
                    }
					
                    $day = dayToNum($csc_day, true);

             //Tue Aug 23 2011 13:15:00 GMT-0500
            
              	    $color = ($inactive == 1) ? "#CCCCCC" : "#52D017";
             	    //var_dump($exists); 
					$busy = ($inactive == 1)? false : true;
                    if($exists){
                        $jsonArray[] = array(
                                             "start" => $day." $strDate ".$csc_ini,
                                             "end" => $day." $strDate ".$csc_end,
                        					 "free" => $busy,
                        				     "userId" => (integer)$cli_chair,
                                             
                                             );
                        
                        $check = array("cli" => $cli_id,
                                       "day" => $day,
                        			   "ini" => $csc_ini,
                        			   "chair" => $cli_chair);
                        
                    	}
                    
                    
                    
                    //print_r($check);
                    
            }else{
                
            	
            	
                $day = dayToNum($csc_day, true);
// 				echo "EMP = ".$emp_id." - ".$check["emp"]."DAY = ".$day." - ".$check["day"]."<br/>";
                //Tue Aug 23 2011 13:15:00 GMT-0500
                $color = ($inactive == 1) ? "#CCCCCC" : "#52D017";
                $busy = ($inactive == 1)? false : true;
                if($day != $check["day"] || $cli_chair != $check["chair"]){
                	    
		                $jsonArray[] = array(
                                             "start" => $day." $strDate ".$csc_ini,
                                             "end" => $day." $strDate ".$csc_end,
                                             "free" => $busy,
		                				     "userId" => (integer)$cli_chair
                                             );
                }
                
                
            }
            

                    
           // array_push($array, $jsonArray);

        }
        
        echo json_encode($jsonArray);
?>
