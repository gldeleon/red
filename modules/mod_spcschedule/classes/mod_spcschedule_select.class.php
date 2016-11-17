<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_spcschedule_select
 *
 * @author Administrador
 */
class mod_spcschedule_select {
    
    public static function selectSpcColor(){
        
        $query = "select spc_color, spc_header from kobemxco_red.speciality where spc_id = ?";
        return $query;
        
    }
    
    public static function getEmpAbbr($emp_id){
    	
    	$query = "select emp_abbr, emp_complete from kobemxco_red.employee where emp_id = {$emp_id}";
    	return $query;
    	
    }
    
    public static function selectSchedule($cli_id){
        
       $query = "select ssch.ssch_id, ssch.spc_id, ssch.emp_id, ssch.cli_id, ssch.cli_chair, ssch.ssch_day, 
                         ssch.ssch_ini,ssch.ssch_end, ssch.mod_date, ssch.usr_id, spc.spc_color, 
                         IFNULL(ssch.ssch_date_ini,'0000-00-00') as ini, IFNULL(ssch.ssch_date_end,'0000-00-00') as end, 
                         emp.emp_complete, emp.emp_abbr, ssch.inactive, spc.spc_header, ssch.quincenal, ssch.quincenal_date_ini
                  from kobemxco_red.spcschedule ssch
                  left join kobemxco_red.speciality spc
                  on ssch.spc_id = spc.spc_id
                  left join kobemxco_red.employee emp
                  on ssch.emp_id = emp.emp_id
                  where ssch.cli_id = '{$cli_id}'
                  order by ssch.ssch_day, ssch.cli_chair asc, ini desc, end desc";
        
        return $query;
        
    }
    
    public static function selectFreeBusy($cli_id){
    
    	$query = "select csc_id, cli_id, cli_chair, csc_day, csc_ini, csc_end, csc_date, csc_date_end, csc_moddate, csc_inactive
    				  from kobemxco_red.clinicschop
    				  where cli_id = '{$cli_id}'
    				  order by csc_day asc, cli_chair, csc_date desc, csc_ini, csc_end";
    
    	return $query;
    
    }
    
}

?>
