<?php

	include_once "data.php";
	include_once "../../functions.inc.php";
	$data = new data();
	$clinicas = $data->getClinic();
	$posts = $data->getPost();

	$section = (isset($_POST['section']) && !empty($_POST['section'])) ? $_POST['section'] : 1;
	$name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : "clinic";
	$respuesta = "";


	switch($section){

	    case 1:

	        $respuesta .= "<label><select name='{$name}'><option value=''>---</option>";
	        for($i=0; $i<count($clinicas); $i++){

	            list($cli_id, $cli_name) = explode("*", $clinicas[$i]);
	            $respuesta .= "<option value='{$cli_id}'>".ucwords(lowercase($cli_name, true))."</option>";

	        }

	        $respuesta .= '</select> <img src="img/delete.png" style="cursor:pointer;" class="quitarClinica" /></label> ';
	        break;

	   case 2:
	        $respuesta .= "<label><select name='post'><option value=''>---</option>";
	        for($i=0; $i<count($posts); $i++){

	            list($pst_id, $pst_name) = explode("*", $posts[$i]);
	            $respuesta .= "<option value='{$pst_id}'>".ucfirst(lowercase($pst_name, true))."</option>";


	        }
	        $respuesta .= '</select> <img src="img/delete.png" style="cursor:pointer;" class="quitarPuesto" /></label> ';
	        break;

	}

	echo $respuesta;

?>
