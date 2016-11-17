<?php

	define('MAIL_SERVER', 'mail.dentalia.com.mx');
	define('MAIL_FROM','no-reply@dentalia.com.mx');
	define('MAIL_PASS','x#l%=pcDw,TS');
	
	function sendMailAlert($trtList, $patient, $clinic, $type)
	{
		if (count($trtList) == 0){
			return false;
		}
		$trtClear = "";
		foreach ($trtList as $trt_id) {
			$trtClear.= $trt_id.",";
		}
		$trtIn = trim($trtClear, ",");
		#$key = mysqli_connect('luke.kobemx.com', 'consulta_zoho',  'consulta_dentalia2015', 'dentalia', 3306) or die("Error".  mysqli_error($key));
		$key = mysqli_connect('192.168.151.126', 'consulta_zoho',  'consulta_dentalia2015', 'dentalia', 3306) or die("Error".  mysqli_error($key));
		//$key = mysqli_connect('localhost', 'kobemxco', '$Ciencia@2013=/', 'dentalia') or die("Error". mysqli_error($key));
		
		$query = "  select trt_id,
					trt_name,
					spc_id,
					work_id
					from treatment 
					where trt_id in ({$trtIn}); " or die("Error en consulta..". mysqli_error($key)); //$keyprod
	
        $result = mysqli_query($key, $query);
		$filas = mysqli_num_rows($result);
		$trtMail = array();
		if ($filas > 0)
		{
			while($row = mysqli_fetch_array($result)) 
		    {
				if ($row["work_id"] != '' && $row["spc_id"] == 12){
					$trtMail[] = $row["trt_name"];
				}
			}
		}
		
		if (count($trtMail) > 0)
		{
			$dest = array("iavila@kobe.com.mx"=>"Ileana Avila");
			$bcc = array("ccampos@kobe.com.mx"=>"Carlo Campos");
			$mail = buildMailAlert($type, $trtMail, $patient, $clinic, $dest, NULL, $bcc);
			
			return $mail;
		}
		else{
			return false;
		}
	}
	
	function buildMailAlert($type, $bodyData, $patient, $clinic, $addTo, $cc = NULL, $bcc = NULL)
	{
		include '../../lib/swift/lib/swift_required.php';
		//transporte para enviar el correo
		$transport = Swift_SmtpTransport::newInstance(MAIL_SERVER, 26);
		$transport->setUsername(MAIL_FROM);
		$transport->setPassword(MAIL_PASS);
		
		$subject = "Alerta de Tratamientos Presupuestados";
		
		switch ($type)
		{
			case "Budget":
				$body = "<html>
							<head>
								<title>{$subject}</title>
							</head>
							<body>
								<basefont face='Arial'>
								<p>Saludos!!</p>
								<p>Al paciente: <b>{$patient}</b></p>
								<p>En la cl&iacute;nica <b>{$clinic}</b></p>
								<p>Se le presupuestaron los siguientes Tx:</p>";
				foreach ($bodyData as $trt) {
					$body.= "	<b> {$trt} </b> <br>";
				}
				  $body .= "	<p>Los cuales van a necesitar un trabajo de laboratorio</p>
								<p>Y tienen un descuento del 50% o m&aacute;s</p>";
				  
				  $body .= "<p>Que tenga un buen d&iacute;a.</p>
							</body>
						</html>";
				break;

			case "Session":
				$subject = "Alerta de Tratamientos Realizados";
				$body = "<html>
							<head>
								<title>{$subject}</title>
							</head>
							<body>
								<basefont face='Arial'>
								<p>Saludos!!</p>
								<p>Al paciente: <b>{$patient}</b></p>
								<p>En la cl&iacute;nica <b>{$clinic}</b></p>
								<p>Se le realizaran los siguientes Tx con un 50% de descuento:</p>";
				foreach ($bodyData as $trt) {
					$body.= "	<b> {$trt} </b> <br>";
				}
				  
				  $body .= "<p>Que tenga un buen d&iacute;a.</p>
							</body>
						</html>";
				break;
			default:
				$body = "<p>ERROR AL ARMAR EL CORREO</p>";
				break;
		}
	
		$mail = Swift_Message::newInstance($subject);
		$mail->setFrom(array("no-reply@dentalia.com.mx" => "Alertas Laboratorio Red"));
		$mail->setTo($addTo);
		
		if ($cc != NULL){
			$mail->setCc($cc);
		}
		
		if ($bcc != NULL){
			$mail->setBcc($bcc);
		}
		
		$mail->setBody($body,'text/html');
		$mailer = Swift_Mailer::newInstance($transport);
		$result = $mailer->send($mail);
		
		return $result;
	
	}

