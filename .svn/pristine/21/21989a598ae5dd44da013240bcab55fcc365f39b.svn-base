<?php
class mod_patschedule_select{

	public static function selectFreeBusy($cli_id){
	
		$query = "select csc_id, cli_id, cli_chair, csc_day, csc_ini, csc_end, csc_date, csc_date_end, csc_moddate, csc_inactive
	    		  from clinicschop
	    		  where cli_id = '{$cli_id}'
	    		  order by csc_day asc, cli_chair, csc_date desc, csc_ini, csc_end";
	
		return $query;
	
	}
	
	public static function selectScheduleEvents(){
		
		$query = "select vst.vst_id, vst.cli_id, vta.vta_color, 
						 vta.vta_name, vst.pat_id, pat.pat_complete, vst.cli_chair,
						 vst.emp_id, emp.emp_abbr, emp.emp_complete, vst.vst_date, 
						 vst.vst_ini, vst.vst_end, vst.vst_descr, vta.vta_hcolor, 
						 vtt.trt_id, trt.spc_id, vst.vta_id, group_concat(tel.tel_number separator '<br/>'),
						 trt.trt_name, pat.agr_id, vst.vst_place
				  from visit vst 
				  
				  left join clinic cli
				  on vst.cli_id = cli.cli_id
				  
				  left join employee emp
				  on vst.emp_id = emp.emp_id
				  
				  left join visitstatus vta
				  on vst.vta_id = vta.vta_id

				  left join patient pat
				  on vst.pat_id = pat.pat_id

				  left join telephone tel
				  on vst.pat_id = tel.pat_id
				  
				  left join (vistreat vtt
					  		 left join treatment trt
					  		 on vtt.trt_id = trt.trt_id)
				  on vst.vst_id = vtt.vst_id
				  
				  where vst.vst_date BETWEEN ? AND ?
				  and vst.vta_id NOT IN (9, 7)
				  and vst.cli_id = ?
				  group by vst.vst_id
				  order by vst.vst_date, vst.vst_ini";
		
		 return $query;
		
		
	}
	
	public static function getVisitStatus(){
		
		$query = "select vta_color, vta_hcolor from visitstatus where vta_id = ?";
		return $query;
		
	}
	
	public static function getVisitLength(){
		
		$query = "select vln_id from visitlength where vln_min = ?";
		return $query;
		
	}
	
	public static function getAbbrEmpName(){
		$query = "select emp_abbr, emp_complete from employee where emp_id = ?";
		return $query;
	}
	
	public static function selectSchedule($cli_id, $spc_id){
	
		$query = "select ssch.ssch_id, ssch.spc_id, ssch.emp_id, ssch.cli_id, ssch.cli_chair, ssch.ssch_day, 
                         ssch.ssch_ini,ssch.ssch_end, ssch.mod_date, ssch.usr_id, spc.spc_color, IFNULL(ssch.ssch_date_ini,'0000-00-00') as ini, 
                         IFNULL(ssch.ssch_date_end,'0000-00-00') as end, emp.emp_complete, emp.emp_abbr, ssch.inactive, spc.spc_header, ssch.quincenal, ssch.quincenal_date_ini
                  from spcschedule ssch
                  left join speciality spc
                  on ssch.spc_id = spc.spc_id
                  left join employee emp
                  on ssch.emp_id = emp.emp_id
                  where ssch.cli_id = '{$cli_id}'
                  and ssch.spc_id = '{$spc_id}'
                  order by ssch.ssch_day, ssch.cli_chair asc, ini desc, ini desc, end desc";
	
		return $query;
	
	}
	
	public static function selectSpecialities($cli){
		
		$query = "SELECT DISTINCT ecl.spc_id, spc.spc_name, spc.spc_color
					FROM `empclinic` ecl
					INNER JOIN speciality spc ON spc.spc_id = ecl.spc_id
					WHERE spc.spc_color IS NOT NULL
					AND spc.spc_id NOT IN (1)
				  	ORDER BY spc.spc_id";

		return $query;
		
	}
	
	public static function spcSchedule($dia, $spc = 0, $cli = 0){
		
			$query = "SELECT ssch.ssch_ini, ssch.ssch_end, ssch.cli_id, ssch.ssch_day, 
							 ssch.cli_chair, ssch.emp_id, emp.emp_complete, cli.cli_name
					  FROM spcschedule ssch 
					  LEFT JOIN employee emp 
					  ON ssch.emp_id = emp.emp_id
					  LEFT JOIN clinic cli
					  ON ssch.cli_id = cli.cli_id
					  WHERE ssch.spc_id = {$spc}
					  AND ssch.inactive = 0  
					  AND ssch.ssch_day = {$dia} ";
			
			if($cli != 0){
				
				$query .= " AND ssch.cli_id = {$cli} "; 
				
			}
			
			$query .= " ORDER BY ssch.cli_id, ssch.ssch_day, ssch.emp_id, ssch.cli_chair";
		
			return $query;
		
	}
	
	public static function vstSchedule($cli = 0, $fi){
		
			$query = "SELECT vst.vst_date, vst.vst_ini, vst.vst_end, 
							(DAYOFWEEK(vst.vst_date)-1) as day, vst.cli_id, 
							((vst.cli_chair)-1) as cli_chair, cli.cli_name						
						FROM visit vst  
						LEFT JOIN clinic cli
						ON vst.cli_id = cli.cli_id
						WHERE vst.vst_date BETWEEN '{$fi}' AND ('{$fi}' + INTERVAL 2 WEEK) 
						AND vst.vta_id NOT IN (9, 7) ";
			
			if($cli != 0){
				
				$query .= " AND vst.cli_id = {$cli} ";
				
			}
			
			$query .= " ORDER BY vst.cli_id, vst.vst_date, vst.vst_ini, vst.vst_end, vst.cli_chair";
			
			return $query;
		
	}
	
	public static function drEnTurno(){
		
			$query = "SELECT ssch.emp_id, emp.emp_complete, emp.emp_abbr, ssch.ssch_date_ini, 
							 ssch.ssch_date_end, ssch.ssch_ini, ssch.ssch_end,
							 ssch.quincenal, ssch.quincenal_date_ini, ssch.inactive, ssch.spc_id
					  FROM spcschedule ssch
					  LEFT JOIN employee emp
					  ON ssch.emp_id = emp.emp_id
					  WHERE ssch.cli_id = ?
					  AND ssch.cli_chair = ?
					  AND ssch.ssch_day = ?
					  ORDER BY ssch.ssch_date_ini desc, ssch.quincenal_date_ini 
					  ";
			
			return $query;
		
	}
	
	public static function spcPorDoctor(){
		
			$query = "SELECT ssch.spc_id
					  FROM spcschedule ssch
					  WHERE ssch.emp_id = ?
					  GROUP BY ssch.emp_id";
			
			return $query;
		
	}
	
	public static function cliScheduleDent($dia, $cli = 0){
			
		$query = "SELECT  distinct csc.csc_ini, csc.csc_end, csc.cli_id, csc.csc_day,
								 csc.cli_chair, cli.cli_name
								 FROM clinicschop csc
								 INNER JOIN clinic cli
								 ON csc.cli_id = cli.cli_id
								 AND csc.csc_inactive = 0 
								 AND csc.csc_day = {$dia} ";
				if($cli != 0){
					$query .= " AND csc.cli_id = {$cli} ";
				}
					$query .= " ORDER BY csc.cli_id, csc.csc_day, csc.cli_chair";
				
				return $query;
			
			
	}	

}
?>