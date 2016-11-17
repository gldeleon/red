<?php

class emppost{
	
	private $emp_id;
	private $pst_id;
	private $usr_id;
	private $eps_date;
	private $eps_active;
	
	public function getEmpId(){
		return $this->emp_id;
	}
	
	public function setEmpId($emp_id){
		$this->emp_id = $emp_id;
	}
	
	public function getPstId(){
		return $this->pst_id;
	}
	
	public function setPstId($pst_id){
		$this->pst_id = $pst_id;
	}
	
	public function getUsrId(){
		return $this->usr_id;
	}
	
	public function setUsrId($usr_id){
		$this->usr_id = $usr_id;
	}
	
	public function getEpsDate(){
		return $this->eps_date;
	}
	
	public function setEpsDate($eps_date){
		$this->eps_date = $eps_date;
	}
	
	public function getEpsActive(){
		return $this->eps_active;
	}
	
	public function setEpsActive($eps_active){
		$this->eps_active = $eps_active;
	}
	
}

?>