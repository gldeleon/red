<?php
/**
 * Contains common queries used in all system as clinic lists, employee lists, etc.
 * @author Ing. Victor Alfonso Rivera Anzures
 */


class commonSearch {
    
    public static function getSpecialities(){
        
        $query = "select spc_id, spc_name from kobemxco_red.speciality where spc_id <> 1";
        return $query;
        
    }
    
    public static function getClinics(){
        
        $query = "select cli_id, cli_name 
                  from kobemxco_red.clinic 
                  where cli_active = 1 and cli_id <> 1
                  order by cli_name";
        return $query;
        
    }
    
    public static function getDoctors($byspc = true){
        
        $query = "SELECT r2.emp_id, r2.emp_complete 
                    FROM (

                        SELECT r.emp_id, r.emp_complete, r.eps_active, r.spc_id, r.cli_id
                        FROM (

                            SELECT emp.emp_id, emp.emp_complete, eps.eps_active, eps.eps_date, pst.spc_id, eps.pst_id, ecl.cli_id
                            FROM kobemxco_red.employee emp
                            LEFT JOIN (
                                    kobemxco_red.emppost eps
                                    LEFT JOIN kobemxco_red.post pst ON eps.pst_id = pst.pst_id
                                    ) ON emp.emp_id = eps.emp_id
                            LEFT JOIN kobemxco_red.empclinic ecl
                            ON emp.emp_id = ecl.emp_id
                            where ecl.cli_id = ?
                            and eps.pst_id IN (25,26,27,28,29,30,31,32,38,41)
                            and ecl.spc_id <> 1
                            ORDER BY eps.eps_date DESC
                            ) AS r
                        GROUP BY r.emp_id, r.pst_id
                        ) AS r2
                    WHERE r2.eps_active = 1 ";
        
			        if($byspc){
			        	$query .= " AND r2.spc_id = ? ";
			        }

        $query .= " order by r2.emp_complete";
        
        return $query;
        
    }
    
    public static function selectEmployee(){
    	
    	$query = "SELECT emp_id, emp_complete FROM kobemxco_red.employee
    			  WHERE emp_complete LIKE ?";
    	
    	return $query;
    	
    }
    
    public static function selectClinicClass(){
    	
    	$query = "select clc_id, clc_name from kobemxco_red.clinicclass order by clc_id";
    	return $query;
    	
    }
    
    public static function getStates(){
    	
    	$query = "select stt_id, stt_name from kobemxco_red.state order by stt_name";
    	return $query;
    	
    }
    
    public static function getPatients(){
    	
    	$query = "select pat_id, pat_complete from patient 
    			  where pat_complete LIKE ?
    	 	 	  order by pat_complete";
    	return $query;
    	
    }
    
    public static function getTreatmentsBySpc(){
    	
    	$query = "select trt.trt_id, trt.trt_name 
    			  from treatment trt 
    			  left join treatspeciality trsp
    			  on trt.trt_id = trsp.trt_id
    			  where trsp.spc_id = ?
    			  group by trt.trt_id
    			  order by trt.trt_name";
    	
    	return $query;
    	
    }
    
    public static function getTreatmentsBySpc2(){
    	 
    	$query = "select trt_id, trt_name from treatment where spc_id = ?
        			  order by trt_name";
    	 
    	return $query;
    	 
    }
    
}
?>