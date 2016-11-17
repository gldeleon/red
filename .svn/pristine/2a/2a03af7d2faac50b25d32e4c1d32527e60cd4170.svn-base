<?php

class mod_schedule_insert{
	
	public static function insertClinic(){
		
		$query = "insert into kobemxco_red.clinic set
				  clt_id = 1,
				  cli_name = ?,
				  cli_shortname = ?,
				  cli_email = ?,
				  clc_id = ?,
				  cli_chairs = ?,
				  cli_type = 1,
				  cli_active = 0,
				  stt_id = ?";
		
		return $query;
		
	}
	
	public static function insertClinicWeb(){
	
		$query = "insert into kobemxco_dentweb.clinic set
					  clt_id = 1,
					  cli_name = ?,
					  cli_shortname = ?,
					  cli_email = ?,
					  clc_id = ?,
					  cli_chairs = ?,
					  cli_type = 1,
					  cli_active = 0,
					  stt_id = ?";
	
		return $query;
	
	}
	
	public static function insertClinicCoord(){
		
		$query = "insert into kobemxco_red.cliniccoord set
				  cli_id = ?,
				  emp_id = ?,	
				  dental_emp_id = ?,
				  ccd_date = ?,
				  ccd_end_date = ?,
				  usr_id = ?,
				  ccd_time = ?";
		
		return $query;
		
		
	}

	
	public static function activateClinic(){
		
		$query = "update kobemxco_red.clinic set
				  cli_active = ?
				  where cli_id = ?";
		
		return $query;
		
	}
	
	public static function activateClinicWeb(){
	
		$query = "update kobemxco_dentweb.clinic set
					  cli_active = ?
					  where cli_id = ?";
	
		return $query;
	
	}
	
	public static function updateClinic(){
	
		$query = "update kobemxco_red.clinic set
					  cli_name = ?,
					  cli_shortname = ?,
					  cli_email = ?,
					  clc_id = ?,
					  cli_chairs = ?,
					  stt_id = ?
					  where cli_id = ?
					  ";
	
		return $query;
	
	}
	
	public static function updateClinicWeb(){
	
		$query = "update kobemxco_dentweb.clinic set
						  cli_name = ?,
						  cli_shortname = ?,
						  cli_email = ?,
						  clc_id = ?,
						  cli_chairs = ?,
						  stt_id = ?
						  where cli_id = ?";
	
		return $query;
	
	}
	
	public static function insertClinicSch(){
		
		$query = "insert into kobemxco_red.clinicschop set
				  cli_id = ?,
				  cli_chair = ?,
				  csc_day = ?,
				  csc_ini = ?,
				  csc_end = ?,
				  csc_date = ?,
				  csc_date_end = ?,
				  csc_moddate = ?,
				  csc_modusr = ?,
				  csc_inactive = ?";
		
		return $query;
		
	}
	
	public static function editClinicSch(){
	
		$query = "update kobemxco_red.clinicschop set
					  cli_id = ?,
					  cli_chair = ?,
					  csc_day = ?,
					  csc_ini = ?,
					  csc_end = ?,
					  csc_date = ?,
					  csc_date_end = ?,
					  csc_moddate = ?,
					  csc_modusr = ?,
					  csc_inactive = ?
					  where csc_id = ?";
	
		return $query;
	}
	
	public static function deleteSch($id){
		
		$query = "delete from kobemxco_red.clinicschop where csc_id = {$id}";
		return $query;
		
	}
	
	
}

?>