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
	$respuesta = "OK";

	$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : "X";
	$surename = (isset($_POST['surename']) && !empty($_POST['surename'])) ? $_POST['surename'] : "X";
	$name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : "";
	$phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : "(55) 0000-0000";
	$cel = (isset($_POST['cel']) && !empty($_POST['cel'])) ? $_POST['cel'] : "044-55-0000-0000";
	$clinic = (isset($_POST['clinic']) && !empty($_POST['clinic'])) ? $_POST['clinic'] : 0;
	$post = (isset($_POST['post']) && !empty($_POST['post'])) ? $_POST['post'] : 24;
	$usr_id = (isset($_POST['usr']) && !empty($_POST['usr'])) ? $_POST['usr'] : "";

	$cli = explode("*", $clinic);
	$puestos = explode("*", $post);
	$num = 1;

	$complete = $name." ".$lastname." ".$surename;
	$abbr = $name[0].$lastname[0].$surename[0];
	$eps_date = $usr_lastupdate = $pat_ldate = date("Y-m-d H:i:s");
	$pstArray = $data->getSpeciality();

	if($respuesta == "OK") {
		$spc_id = $cSpc = 1;

		for($i = 0; $i<count($puestos)-1; $i++){
		    if(in_array($puestos[$i], $pstArray)){
		        $cSpc = $data->getSpcId($puestos[$i]);
		    }
		    $spc_id = ($cSpc > $spc_id) ? $cSpc : $spc_id;
		}

		/*************insert Employee*****************/
        $employee->setEmpLastName(strtoupper(utf8_decode($lastname)));
        $employee->setEmpSureName(strtoupper(utf8_decode($surename)));
        $employee->setEmpName(strtoupper(utf8_decode($name)));
        $employee->setEmpComplete(strtoupper(utf8_decode($complete)));
        $employee->setEmpAbbr(strtoupper($abbr));
        $employee->setEmpCel($cel);
        $employee->setEmpTel($phone);
        $employee->setAdeId("1");
        $employee->setEmpActive("1");

        $emp_id = $data->insertEmployee($employee);

	        if($emp_id != "ERROR"){

	                for($i = 0; $i<count($cli)-1; $i++){

	                    $empclinic->setCliId($cli[$i]);
	                    $empclinic->setEmpId($emp_id);
	                    $empclinic->setSpcId($spc_id);

	                    $confirmEmpClinic = $data->insertEmpClinic($empclinic);

	                    if($confirmEmpClinic == "ERROR"){
	                        $respuesta = "ERROR";
	                        break;
	                    }

	                }

	                for($i = 0; $i<count($puestos)-1; $i++){

	                    $emppost->setEmpId($emp_id);
	                    $emppost->setPstId($puestos[$i]);
	                    $emppost->setUsrId("1");
	                    $emppost->setEpsActive("1");
	                    $emppost->setEpsDate($eps_date);

	                    $confirmEmpPost = $data->insertEmpPost($emppost);

	                    if($confirmEmpPost == "ERROR"){
	                        $respuesta = "ERROR";
	                        break;
	                    }
	                }
	         }
	         else {
	             $respuesta = "ERROR";
	         }
	}
	echo $respuesta
?>