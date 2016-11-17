<?php
require_once ('./lib/swift/lib/swift_required.php');
/*
// Create the message
$message = Swift_Message::newInstance()// Give the message a subject
->setSubject('Your subject')
// Set the From address with an associative array
->setFrom(array('john@doe.com'=>'John Doe'))
// Set the To addresses with an associative array
->setTo(array('receiver@domain.org','other@domain.org'=>'A name'))
// Give it a body
->setBody('Here is the message itself')
// And optionally an alternative body
->addPart('<q>Here is the message itself</q>','text/html')
// Optionally add any attachments
->attach(Swift_Attachment::fromPath('my-document.pdf'))
;*/

class mailerswift{
    
    function enviaMail($cli_email, $cli_name, $msj){
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance('host406.hostmonster.com', 465, 'ssl')
          ->setUsername('no-reply@kobe.com.mx')
          ->setPassword('x#l%=pcDw,TS');

        /*
        You could alternatively use a different transport such as Sendmail or Mail:

        // Sendmail
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        // Mail
        $transport = Swift_MailTransport::newInstance();
        */

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create a message
        $message = Swift_Message::newInstance('Validación de acceso RED KOBE')
          ->setFrom(array('no-reply@kobe.com.mx' => 'No-Reply'))
          ->setTo(array($cli_email => $cli_name))
          ->setCc(array("iavila@kobe.com.mx" => "Ileana Avila", "rociom@kobe.com.mx" => "Rocio Manuel"))
          //->setBody($msj)
          // And optionally an alternative body
          ->addPart($msj, 'text/html');
        // Send the message
        $result = $mailer->send($message);
        if(!$result) {
            return false;                                         
        } else {
            return true;
        }
    }
}

