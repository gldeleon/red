<?php
	date_default_timezone_set("America/Mexico_City");

	include_once "data.php";
	include_once "tables/employee.class.php";
	include_once "tables/emppost.class.php";
	include_once "tables/empclinic.class.php";
	include_once "../../functions.inc.php";

	$data = new data();
	$employee = new employee();
	$emppost = new emppost();
	$empclinic = new empclinic();

	$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : "X";
	$surename = (isset($_POST['surename']) && !empty($_POST['surename'])) ? $_POST['surename'] : "X";
	$name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : "X";
	$cel = (isset($_POST['cel']) && !empty($_POST['cel'])) ? $_POST['cel'] : "044-55-0000-0000";
	$phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : "(55) 0000-0000";
	$emp_id = (isset($_POST['empid']) && !empty($_POST['empid'])) ? $_POST['empid'] : "";
	$clinic = (isset($_POST['clinic']) && !empty($_POST['clinic'])) ? $_POST['clinic'] : 0;
	$post = (isset($_POST['post']) && !empty($_POST['post'])) ? $_POST['post'] : 24;
	$usr_id = (isset($_POST['usr']) && !empty($_POST['usr'])) ? $_POST['usr'] : "";
	$exPost = (isset($_POST['exPost']) && !empty($_POST['exPost'])) ? $_POST['exPost'] : "";
	$alta = (isset($_POST["alta"]) && !empty($_POST["alta"])) ? $_POST["alta"] : "0";

	$cli = explode("*", $clinic);
	$puestos = explode("*", $post);
	$exPost = explode("*", $exPost);
	$array = array(6,17,18,19);
	$pstArray  = array();
	$pstArray = $data->getSpeciality();

	$spc_id = $cSpc = 1;

	if(!empty($puestos)) {
	    for($i = 0; $i < count($puestos)-1; $i++) {
	        if(in_array($puestos[$i], $pstArray)){
	            $cSpc = $data->getSpcId($puestos[$i]);
	        }
		    $spc_id = ($cSpc > $spc_id) ? $cSpc : $spc_id;
	    }
	}

	$complete = $name." ".$lastname." ".$surename;

	$employee->setEmpLastName(strtoupper(utf8_decode($lastname)));
	$employee->setEmpSureName(strtoupper(utf8_decode($surename)));
	$employee->setEmpName(strtoupper(utf8_decode($name)));
	$employee->setEmpComplete(strtoupper(utf8_decode($complete)));
	$employee->setEmpCel($cel);
	$employee->setEmpTel($phone);
	$employee->setEmpId($emp_id);

	$eps_date = date("Y-m-d H:i:s");
	$eps_active = 1;

	$respuesta = $data->editEmployee($employee);

	for($i = 0; $i<count($exPost)-1; $i++){
		if(@in_array($exPost[$i], $pstArray)){
			$cSpc = $data->getSpcId($exPost[$i]);
		}
	    $spc_id = ($cSpc > $spc_id) ? $cSpc : $spc_id;
	}

	if(!empty($cli)) {
        for($i = 0; $i<count($cli)-1; $i++) {
            $empclinic->setCliId($cli[$i]);
            $empclinic->setEmpId($emp_id);
            $empclinic->setSpcId($spc_id);

            $confirmEmpClinic = $data->insertEmpClinic($empclinic);

            if($confirmEmpClinic == "ERROR"){
                $respuesta = "ERROR";
                break;
            }
        }
	}

	if(!empty($puestos)){
        for($i = 0; $i<count($puestos)-1; $i++) {
            $emppost->setEmpId($emp_id);
            $emppost->setPstId($puestos[$i]);
            $emppost->setUsrId($usr_id);
            $emppost->setEpsActive($eps_active);
            $emppost->setEpsDate($eps_date);

            $confirmEmpPost = $data->insertEmpPost($emppost);

            if($confirmEmpPost == "ERROR"){
                $respuesta = "ERROR";
                break;
            }
        }
        $empclinic->setEmpId($emp_id);
        $empclinic->setSpcId($spc_id);

        $data->updateEmpClinic($empclinic);
	}

	if($alta == 1) {
	    $data->reactivateEmp($emp_id);
	    if(!empty($exPost)) {
	        for($i = 0; $i<count($exPost)-1; $i++) {
	            $emppost->setEmpId($emp_id);
	            $emppost->setPstId($exPost[$i]);
	            $emppost->setUsrId($usr_id);
	            $emppost->setEpsActive($eps_active);
	            $emppost->setEpsDate($eps_date);

	            $confirmEmpPost = $data->insertEmpPost($emppost);
	        }
	    }
	}

	echo $respuesta;
?>