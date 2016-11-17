<?php
	date_default_timezone_set("America/Mexico_City");

	include_once "data.php";
	include_once "tables/emppost.class.php";

	$empid = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : "";
	$section = (isset($_POST['section']) && !empty($_POST['section'])) ? $_POST['section'] : "";
	$data = new data();
	$emppost = new emppost();

	switch($section) {
	    case 1:
			$respuesta = $data->deleteEmp($empid);
            $posts = $data->getEmpPosts($empid);

            for($i=0; $i<count($posts); $i++){

                list($pst_name, $pst_id) = explode("*", $posts[$i]);

                $emppost->setPstId($pst_id);
                $emppost->setEmpId($empid);
                $emppost->setEpsActive(0);
                $emppost->setEpsDate(date("Y-m-d H:i:s"));
                $emppost->setUsrId("1");

                $respuesta = $data->insertEmpPost($emppost);

            }
	    break;
	    case 2:

	        $clinica = (isset($_POST['clinica']) && !empty($_POST['clinica'])) ? $_POST['clinica'] : "";

	        $respuesta = $data->empClinicHist($empid, $clinica);
	        $respuesta = $data->deleteClinic($empid, $clinica);


	    	break;
	    case 3:
	        $puesto = (isset($_POST['puesto']) && !empty($_POST['puesto'])) ? $_POST['puesto'] : "";

	        $emppost->setPstId($puesto);
	        $emppost->setEmpId($empid);
	        $emppost->setEpsActive(0);
	        $emppost->setEpsDate(date("Y-m-d H:i:s"));
	        $emppost->setUsrId("1");

	        $respuesta = $data->insertEmpPost($emppost);

	    	break;
	}

	echo $respuesta;
?>