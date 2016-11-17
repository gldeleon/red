<?php

include_once "../../../lib/definitions.inc.php";
include_once "../../../lib/functions.inc.php";
include_once "../../../lib/execQuery.class.php";
include_once '../../../config.class.php';
include_once 'mod_spcschedule_select.class.php';

$start = (isset($_GET["start"]) && !empty($_GET["start"])) ? $_GET["start"] : "";
$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "";

list($yi, $mi, $di) = explode("-", $start);

        $query = mod_spcschedule_select::selectSchedule($cli);
        $execQuery = new execQuery($query);
        $result = $execQuery->getQueryResults();
        $jsonArray = $week = $check = array();
        
        
        for($i = 0; $i<count($result); $i ++){
            $inactivo = $exists = false;
            list($ssch_id, $spc_id, $emp_id, $cli_id, $cli_chair, $ssch_day, 
                 $ssch_ini, $ssch_end, $mod_date, $usr_id, $spc_color, 
                 $date_ini, $date_fin, $emp_complete, $emp_abbr, $inactive, 
            	 $spc_header, $quincenal, $quincenal_date_ini) = explode(__SEPARATOR, $result[$i]);
            
            
            ###################################################################
            ####      Obtiene los días de la semana que estamos viendo     ####
            ####       los coloca en un arreglo para revisar periodos      ####
            ####             irregulares en caso de que existan.           ####
            ###################################################################
            
            for($j = 0; $j<7; $j++){
                
                $verify_date = date("w", mktime(0, 0, 0, $mi, $di+$j, $yi));
                
                $week[] = date("Y-m-d", mktime(0, 0, 0, $mi, $di+$j, $yi));

                if($verify_date == $ssch_day){
                    $strDate = date("M d Y", mktime(0, 0, 0, $mi, $di+$j, $yi));
                    break;
                }
            }
            
            ###################################################################
            ####         Rango de fechas para periodos irregulares         ####
            ###################################################################

            
            if($date_ini != "0000-00-00"){
            
                    $dias = restaFechas($date_ini, $date_fin);
                    $dias = ($dias == 0)? 1 : $dias;

                    for($k = 0; $k<$dias; $k++){
                        list($iyear, $imonth, $iday) = explode("-", $date_ini);
                        $inDates = date("Y-m-d", mktime(0, 0, 0, $imonth, $iday+$k, $iyear));

                        if(in_array($inDates, $week)){

                            $exists = true;
                            break;
                        }
                    }
                    
                    $day = dayToNum($ssch_day, true);

             //Tue Aug 23 2011 13:15:00 GMT-0500
            
             	    $spc_color = ($inactive == 1) ? "#999999" : $spc_color;
             	    //var_dump($exists); 
                    if($exists){
                    	
                        $jsonArray[] = array("id" => $ssch_id,
                                             "start" => $day." $strDate ".$ssch_ini,
                                             "end" => $day." $strDate ".$ssch_end,
                        				     "userId" => (integer)$cli_chair,
                     						 "color" => $spc_color,
                                             "dr" => $emp_id,
                                             "cli" => $cli_id,
                                             "spc" => $spc_id,
                                             "titulo" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr."</span>",
                                             "date_ini" => $date_ini,
                                             "date_end" => $date_fin,
                                             "inactive" => $inactive,
                                             "headerColor" => $spc_header,
                                             "quincenal" => $quincenal,
                                             "quincenal_date_ini" =>$quincenal_date_ini
                                             );
                        
                        $check = array("emp" => $emp_id,
                                       "day" => $day,
                        			   "chair" => $cli_chair);
                        
                    }
                    
                    
                    
                    //print_r($check);
                    
            }else{
                
            	if($quincenal == 1){

            		for($j = 0; $j<7; $j++){
            		
            			$verify_date = date("w", mktime(0, 0, 0, $mi, $di+$j, $yi));
            		
            			if($verify_date == $ssch_day){
            				$diaQuince = date("Y-m-d", mktime(0, 0, 0, $mi, $di+$j, $yi));
            				break;
            			}
            		}
            		
            		$showQuin = restaFechas($quincenal_date_ini, $diaQuince);
            		//echo $showQuin;
            		if($showQuin%14 == 0){
            			
            			$jsonArray[] = array("id" => $ssch_id,
            					"start" => $day." $strDate ".$ssch_ini,
            					"end" => $day." $strDate ".$ssch_end,
            					"userId" => (integer)$cli_chair,
            					"color" => $spc_color,
            					"dr" => $emp_id,
            					"cli" => $cli_id,
            					"spc" => $spc_id,
            					"titulo" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr."</span>",
            					"date_ini" => $date_ini,
            					"date_end" => $date_fin,
            					"inactive" => $inactive,
            					"headerColor" => $spc_header,
            					"quincenal" => $quincenal,
            			        "quincenal_date_ini" =>$quincenal_date_ini
            			);
            			
            		}
            		
            	}
            	else{
            	
            	
			                $day = dayToNum($ssch_day, true);
							//echo "EMP = ".$emp_id." - ".$check["emp"]."DAY = ".$day." - ".$check["day"]."<br/>";
			                //Tue Aug 23 2011 13:15:00 GMT-0500
			                $spc_color = ($inactive == 1) ? "#999999" : $spc_color; 
			                if($day != $check["day"] || $cli_chair != $check["chair"] || $emp_id != $check["emp"]){
			                	    
					                $jsonArray[] = array("id" => $ssch_id,
					                                     "start" => $day." $strDate ".$ssch_ini,
					                                     "end" => $day." $strDate ".$ssch_end,
					                					 "userId" => (integer)$cli_chair,
					                                     "color" => $spc_color,
					                                     "dr" => $emp_id,
					                                     "cli" => $cli_id,
					                                     "spc" => $spc_id,
					                                     "titulo" => "<span title='".utf8_encode($emp_complete)."' style='color:#FFFFFF;'>".$emp_abbr."</span>",
					                                     "date_ini" => $date_ini,
					                                     "date_end" => $date_fin,
					                					 "inactive" => $inactive,
					                					 "headerColor" => $spc_header,
					                					 "quincenal" => $quincenal,
					                                     "quincenal_date_ini" =>$quincenal_date_ini
					                                     );
			                }
			                
            	}			                
			                
			                
                
            }
            

                    
           // array_push($array, $jsonArray);

        }
        
        echo json_encode($jsonArray);
?>
