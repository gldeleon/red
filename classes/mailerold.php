<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('./lib/mailer/PHPMailerAutoload.php');

class mailer extends PHPMailer{
    
    function enviaMail($cli_email, $cli_name, $msj){
        
        $mail = new PHPMailer();
        //$mail->SMTPDebug  = 1;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'host406.hostmonster.com'; //'mail.kobe.com.mx';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'no-reply@kobe.com.mx';                 // SMTP username
        $mail->Password = 'x#l%=pcDw,TS';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('no-reply@kobe.com.mx', 'No-Reply');
        //$mail->addAddress($cli_email, $cli_name);     // Add a recipient
        $mail->addAddress($cli_email, $cli_name);

        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC("gdeleon@dentalia.com", "Geovas");
        /*$mail->addCC("iavila@kobe.com.mx", "Ileana Avila");
        $mail->addCC("rociom@kobe.com.mx", "Rocio Manuel");*/
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Validación de acceso RED KOBE';
        //$mail->MsgHTML('Test');
        //$mail->Body = '<p>test</p>';                                        
//        $mail->Body    = "<br><p>Estimado <b>" . $cli_name . "</b>,</p>
//                                        <p>Para poder ingresar al portal de Red Kobe es necesario validar su identidad para ello de clic en la siguiente liga:
//                                        <br>http://red.kobe.com.mx.local/activar.php?active=" . md5($rowAccept["cliid"] . "-" . $rowAccept["usr_id"]) . "</b>
//                                        <br><p>De igual manera puede copiar el enlace y pegarlo en su navegador.</p>
//                                        <p>Si necesita asistencia favor comunicarse al 01 800 011 56 56
//                                        <br><p>Sin más por el momento, agradecemos su apoyo y le deseamos excelente día
//                                        <br>Atentamente:
//                                        <br>Equipo de Red Kobe.</p>";
        $mail->Body = $msj;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            return false;
            //return $alert = 'Error al enviar la confirmación comunicate al 01800 011 56 56: ' . $mail->ErrorInfo;                                            
        } else {
            return true;
            //return $alert = 'En breves instantes será enviado un email a los correos de los doctores asociados a esta clínica para confirmar su información. Es importante recordar que el acceso no será autorizado hasta que todos los doctores hayan confirmado su identidad';
        }
    }
}