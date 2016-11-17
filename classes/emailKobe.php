<?php 
require_once '/home/kobemxco/public_html/dentalia3/application/Application.php';

 if(isset($_POST['nombre']) && !empty($_POST['nombre']) &&
     isset($_POST['email']) && !empty($_POST['email']) &&
     isset($_POST['clinica']) && !empty($_POST['clinica']) &&
     isset($_POST['mensaje']) && !empty($_POST['mensaje'])){
 	
		$name = "Cecilia Ceballos";
		$dr_name = $_POST['nombre'];
		$email_dr = $_POST['email'];
		$mail_to = 'cceballos@kobe.com.mx';
		$clinica = $_POST['clinica'];
		$mensaje = 'Doctor: '.$dr_name."<br/><br/>";
		$mensaje .= "Email: ".$email_dr."<br/><br/>";
		$mensaje .= 'Clinica/consultorio: '.$clinica."<br/><br/>";
		$mensaje .= str_replace("\n", "<br/>", $_POST['mensaje']);
		
		
		$email = new Email(new SMTP_kobe('Sistema Red Kobe'));
		$email->addTo($mail_to, $name);
		$email->addCc("lzavala@kobe.com.mx", "Laura Zavala");
		$email->setSubject('Cotización de Productos Kobe');
		$email->setBody($mensaje);
		if(!$email->send()){
			echo "2"; //ERROR
		}
		else{
			echo "1";//OK
		}

}
?>