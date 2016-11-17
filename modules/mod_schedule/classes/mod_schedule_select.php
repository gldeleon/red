<?php

class mod_schedule_select{
	
	public static function selectClinicInfo($activo, $cli = 0){
		
		$query = "SELECT r.cli_id, r.cli_name, r.cli_shortname, r.clc_name, 
				  r.cli_chairs,r.cli_active, r.stt_name,r.stt_id, r.clc_id 
				  FROM (SELECT cli.cli_id, cli.cli_name, cli.cli_shortname, clc.clc_name, 
				  cli.cli_chairs, cli.cli_active, stt.stt_name,
				  stt.stt_id, clc.clc_id
				  FROM kobemxco_red.clinic cli
				  LEFT JOIN kobemxco_red.clinicclass clc
				  ON cli.clc_id = clc.clc_id
				  LEFT JOIN kobemxco_red.state stt
				  ON cli.stt_id = stt.stt_id
				  WHERE cli.cli_id <> 1
				  and cli.cli_active = {$activo} 
				  ";
		
		if($cli != 0){
			
			$query .= " and cli.cli_id = {$cli} ";
			
		}
		
	    $query .= " ) as r
				  GROUP BY r.cli_id
				 ";
		
		return $query;
		
	}
	
	
	public static function selectSchedule($cli_id){
	
		$query = "select csc_id, cli_id, cli_chair, csc_day, csc_ini, csc_end, csc_date, csc_date_end, csc_moddate, csc_inactive
				  from kobemxco_red.clinicschop
				  where cli_id = '{$cli_id}'
				  order by csc_day asc, cli_chair, csc_date desc, csc_ini, csc_end";
	
		return $query;
	
	}
	
}

?>