<?php

class empclinic{

	private $cli_id;
	private $emp_id;
	private $spc_id;

	public function getCliId(){
		return $this->cli_id;
	}

	public function setCliId($cli_id){
		$this->cli_id = $cli_id;
	}

	public function getEmpId(){
		return $this->emp_id;
	}

	public function setEmpId($emp_id){
		$this->emp_id = $emp_id;
	}

	public function getSpcId(){
		return $this->spc_id;
	}

	public function setSpcId($spc_id){
		$this->spc_id = $spc_id;
	}

}

?>