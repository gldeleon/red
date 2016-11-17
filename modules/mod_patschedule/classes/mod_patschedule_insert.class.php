<?php

class mod_patschedule_insert{
	
	public static function insertVisit(){
		
		$query = "insert into visit set
				  cli_id = ?,
				  vln_id = ?,
				  vta_id = ?,
				  pat_id = ?,
				  usr_id = ?,
				  emp_id = ?,
				  cli_chair = ?,
				  vst_date = ?,
				  vst_ini = ?,
				  vst_end = ?,
				  vst_descr = ?,
				  vst_usrmod = ?,
				  vst_datemod = ?,
				  vst_place = 0";
		
		return $query;
			
	}
	
	public static function insertVstTreat(){
		
		$query = "insert into vistreat set
				  vst_id = ?,
				  trt_id = ?";
				  
		return $query;
		
	}
	
	public static function updateVisit(){
		
		$query = "update visit set
				  cli_id = ?,
				  vln_id = ?,
				  vta_id = ?,
				  pat_id = ?,
				  emp_id = ?,
				  cli_chair = ?,
				  vst_date = ?,
				  vst_ini = ?,
				  vst_end = ?,
				  vst_descr = ?,
				  vst_usrmod = ?,
				  vst_datemod = ?
				  where vst_id = ?";
		
		return $query;
		
	}
	
	public static function updateVstTreat(){
		
		$query = "update vistreat set
				  trt_id = ?
				  where vst_id = ?";
		
		return $query;
			
	}
	
	public static function deleteVst(){
		
		$query = "update visit set
				  vta_id = ?,
				  vst_usrmod = ?,
				  vst_datemod = ?
				  where vst_id = ?";
		return $query;
		
	}
	
	public static function insertVstHist(){
		
		$query = "insert into visithist (
					select null, vst.* from visit vst where vst.vst_id = ?)";
		
		return $query;
		
	}
	
	public static function updateVstStatus(){
		
		$query = "update visit set vta_id = 6 where vst_id = ?";
		return $query;
		
	}
	
}

?>
