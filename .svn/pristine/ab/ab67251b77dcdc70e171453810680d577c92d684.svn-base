<?php

class mod_spcschedule_insert{
    
    public static function insertSchedule(){
        
        $query = "insert into kobemxco_red.spcschedule set
                  spc_id = ?,
                  emp_id = ?,
                  cli_id = ?,
                  cli_chair = ?,
                  ssch_day = ?,
                  ssch_date_ini = ?,
                  ssch_date_end = ?,
                  ssch_ini = ?,
                  ssch_end = ?,
                  mod_date = ?,
                  usr_id = ?,
                  inactive = ?,
                  quincenal = ?,
                  quincenal_date_ini = ?
                  ";
        
        return $query;
        
    }
    
    public static function updateSchedule(){
        
        $query = "update kobemxco_red.spcschedule set
                  spc_id = ?,
                  emp_id = ?,
                  cli_id = ?,
                  cli_chair = ?,
                  ssch_day = ?,
                  ssch_date_ini = ?,
                  ssch_date_end = ?,
                  ssch_ini = ?,
                  ssch_end = ?,
                  mod_date = ?,
                  usr_id = ?,
                  inactive = ?,
                  quincenal = ?,
                  quincenal_date_ini = ?
                  where ssch_id = ?";
        
        return $query;
        
    }
    
    public static function deleteSchedule(){
        
        $query = "delete from kobemxco_red.spcschedule where ssch_id = ?";
        
        return $query;
        
    }
    
    public static function insertScheduleHist($move){
        
        $query = "insert into kobemxco_red.spcschedule_hist (
                        select null, ssch.*, '{$move}' from kobemxco_red.spcschedule ssch
                        where ssch_id = ?
                  )";
                        
        return $query;
        
    }
    
    
}


?>
