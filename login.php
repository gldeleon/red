<?php

include "config.inc.php";
include "functions.inc.php";
$a = $_POST["a"];
$y = $_POST["y"];
$url = $AppUrl;
$alert = '';
if (!empty($a) && !empty($y)) {

    $link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
    if (!$link) {
        die("Error al conectar " . mysql_error());
    }
    $query = "SELECT us.usr_id
		,us.usr_priv
		,us.usr_name
        ,us.usr_passwd
        ,us.usr_active
		,e.emp_complete
        ,e.emp_name
		FROM {$DBName}.user AS us
		LEFT JOIN {$DBName}.employee AS e
			ON e.emp_id = us.emp_id
		WHERE us.usr_name = '$a'
		AND us.usr_passwd = '" . md5($y) . "'
		AND us.usr_active = 1";
    if ($result = @mysql_query($query, $link)) {
        $next = 0;
        if ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
            $queryAccept = "SELECT
                                 uc.usr_id
                                ,cli.cli_name
                                ,cli.cli_tel
                                ,cli.cli_email
                                ,cli.cli_dir
                                ,cli.cli_rfc
                                ,cli.cli_rfc_dom
                                ,cli.cli_type_cont
                                ,cli.cli_id AS cliid
                                ,cont.cli_id
                                ,cont.type_contr
                                ,cont.status
                            FROM {$DBName}.userclinic AS uc
                            LEFT JOIN {$DBName}.clinic AS cli
                                ON cli.cli_id = uc.cli_id
                            LEFT JOIN {$DBName}.accept_cont AS cont
                                ON cont.cli_id = cli.cli_id
                            WHERE usr_id = " . $row["usr_id"] . "";
            if ($exeAccept = @mysql_query($queryAccept, $link)) {
                if ($rowAccept = @mysql_fetch_array($exeAccept)) {
//					die($rowAccept["status"]);
                    switch ($rowAccept["status"]) {
                        case NULL:
                            //require_once "../../dentalia/public_html/application/Application.php";
                            //require_once '../dentalia3/application/Application.php';
                            //require_once 'lib/mailer/PHPMailerAutoload.php';
                            require_once 'classes/swiftmailer.php';
                            if (isset($rowAccept["cli_name"]) && !empty($rowAccept["cli_name"]) && isset($rowAccept["cli_email"]) && !empty($rowAccept["cli_email"])) {
                                $cli_name = ucwords(lowercase($rowAccept['cli_name']));
                                $cli_email = $rowAccept['cli_email'];
                                $inst = "INSERT INTO {$DBName}.accept_cont VALUES (" . $rowAccept['cliid'] . ",'" . $rowAccept["cli_type_cont"] . "','" . date('Y-m-d H:i:s') . "','RECHAZADO'); ";
                                if ($insexe = @mysql_query($inst, $link)) {
                                    //$alert = "El mailer";
                                    $msj = "<br><p>Estimado <b>" . $cli_name . "</b>,</p>
//                                        <p>Para poder ingresar al portal de Red Kobe es necesario validar su identidad para ello de clic en la siguiente liga:
//                                        <br>http://red.kobe.com.mx/activar.php?active=" . md5($rowAccept["cliid"] . "-" . $rowAccept["usr_id"]) . "</b>
//                                        <br><p>De igual manera puede copiar el enlace y pegarlo en su navegador.</p>
//                                        <p>Si necesita asistencia favor comunicarse al 01 800 011 56 56
//                                        <br><p>Sin más por el momento, agradecemos su apoyo y le deseamos excelente día
//                                        <br>Atentamente:
//                                        <br>Equipo de Red Kobe.</p>";
                                        $mail = new mailerswift();
                                        $rs = $mail->enviaMail($cli_email, $cli_name, $msj);
                                        if($rs){
                                            $alert = 'En breves instantes será enviado un email a los correos de los doctores asociados a esta clínica para confirmar su información. Es importante recordar que el acceso no será autorizado hasta que todos los doctores hayan confirmado su identidad';
                                        }else{
                                            $alert = 'Error al enviar la confirmación comunicate al 01800 011 56 56: ' . $mail->ErrorInfo;                                            
                                        }
                                } else {
                                    $alert = "No se pudo guardar la confirmación de la clinica";
                                }
                            } else {
                                $alert = "El nombre de la clínica o el email de la carrea estan vacios";
                            }
                            break;
                        case '':
                            //require_once "../../dentalia/public_html/application/Application.php";
                            //require_once '../dentalia3/application/Application.php';
                            //require_once 'lib/mailer/PHPMailerAutoload.php';                            
                            require_once 'classes/mailer.php';
                            if (isset($rowAccept["cli_name"]) && !empty($rowAccept["cli_name"]) && isset($rowAccept["cli_email"]) && !empty($rowAccept["cli_email"])) {
                                $cli_name = ucwords(lowercase($rowAccept['cli_name']));
                                $cli_email = $rowAccept['cli_email'];
                                $inst = "INSERT INTO {$DBName}.accept_cont VALUES (" . $rowAccept['cliid'] . ",'" . $rowAccept["cli_type_cont"] . "','" . date('Y-m-d H:i:s') . "','RECHAZADO'); ";
                                if ($insexe = @mysql_query($inst, $link)) {
                                    //$alert = "El mailer";
                                    $msj = "<br><p>Estimado <b>" . $cli_name . "</b>,</p>
//                                        <p>Para poder ingresar al portal de Red Kobe es necesario validar su identidad para ello de clic en la siguiente liga:
//                                        <br>http://red.kobe.com.mx/activar.php?active=" . md5($rowAccept["cliid"] . "-" . $rowAccept["usr_id"]) . "</b>
//                                        <br><p>De igual manera puede copiar el enlace y pegarlo en su navegador.</p>
//                                        <p>Si necesita asistencia favor comunicarse al 01 800 011 56 56
//                                        <br><p>Sin más por el momento, agradecemos su apoyo y le deseamos excelente día
//                                        <br>Atentamente:
//                                        <br>Equipo de Red Kobe.</p>";
                                    
                                        $mail = new mailer();
                                        $rs = $mail->enviaMail($cli_email, $cli_name, $msj);
                                        if($rs){
                                            $alert = 'En breves instantes será enviado un email a los correos de los doctores asociados a esta clínica para confirmar su información. Es importante recordar que el acceso no será autorizado hasta que todos los doctores hayan confirmado su identidad';
                                        }else{
                                            $alert = 'Error al enviar la confirmación comunicate al 01800 011 56 56: ' . $mail->ErrorInfo;                                            
                                        }
                                } else {
                                    $alert = "No se pudo guardar la confirmación de la clinica";
                                }
                            } else {
                                $alert = "El nombre de la clínica o el email de la carrea estan vacios";
                            }
                            break;
                            
                        case 'RECHAZADO':
                            $alert = "Para poder iniciar sesión debes confirmar tus datos en el correo que se te envio";
                            break;
                        case 'ACEPTADO':
                            session_name("pra8atuw");
                            session_start();
                            $_SESSION["a"] = $a; //Loginname
                            $_SESSION["uid"] = $row['usr_id'];  //Id Usuario
                            $_SESSION["p"] = $row['usr_priv']; //Privilegios Globales LecturaEscrituraAdmin
                            $prefs = $row['usr_pref'];   //Preferencias
                            if ($prefs == "00:00:00:00:00") {
                                $cli = "0";
                                $query = "select u.cli_id from {$DBName}.userclinic as u
                                        left join {$DBName}.clinic as c on c.cli_id = u.cli_id
                                        where u.usr_id = {$row[0]}";
                                if ($result = @mysql_query($query, $link)) {
                                    $numrows = @mysql_num_rows($result);
                                    if ($numrows > 0) {
                                        $cli = @mysql_result($result, 0);
                                    }
                                }
                                $prefs = ((strlen($cli) < 2) ? ("0" . $cli) : $cli) . substr($prefs, 2);
                            }
                            $_SESSION["s"] = $prefs;   //Preferencias
                            $_SESSION["e"] = $row['emp_id']; //Id Empleado
                            $_SESSION["uname"] = ucwords(lowercase($row['emp_name']));  //Nombre
                            $_SESSION["udname"] = ucwords(lowercase($row['emp_complete'])); //Nombre Completo
                            $url = "passwd.php?rq=1";
                            @mysql_free_result($result);

                            //Genera el registro para la bitacora de usuario
                            $query2 = "insert into {$DBName}.userlog set usr_id = '{$row['usr_id']}',
					cli_id = {$cli}, ulg_date = now(), ulg_mvmt = 'LOGIN', ulg_tag = ''";
                            @mysql_query($query2, $link);
                            header("Location: $url");
                            break;
                    }
                } else {
                    session_name("pra8atuw");
                    session_start();
                    $_SESSION["a"] = $a; //Loginname
                    $_SESSION["uid"] = $row['usr_id'];  //Id Usuario
                    $_SESSION["p"] = $row['usr_priv']; //Privilegios Globales LecturaEscrituraAdmin
                    $prefs = $row['usr_pref'];   //Preferencias
                    if ($prefs == "00:00:00:00:00") {
                        $cli = "0";
                        $query = "select u.cli_id from {$DBName}.userclinic as u
							left join {$DBName}.clinic as c on c.cli_id = u.cli_id
							where u.usr_id = {$row[0]}";
                        if ($result = @mysql_query($query, $link)) {
                            $numrows = @mysql_num_rows($result);
                            if ($numrows > 0) {
                                $cli = @mysql_result($result, 0);
                            }
                        }
                        $prefs = ((strlen($cli) < 2) ? ("0" . $cli) : $cli) . substr($prefs, 2);
                    }
                    $_SESSION["s"] = $prefs;   //Preferencias
                    $_SESSION["e"] = $row['emp_id']; //Id Empleado
                    $_SESSION["uname"] = ucwords(lowercase($row['emp_name']));  //Nombre
                    $_SESSION["udname"] = ucwords(lowercase($row['emp_complete'])); //Nombre Completo
                    $url = "passwd.php?rq=1";
                    @mysql_free_result($result);
                    //Genera el registro para la bitacora de usuario
                    $query2 = "insert into {$DBName}.userlog set usr_id = '{$row['usr_id']}',
					cli_id = {$cli}, ulg_date = now(), ulg_mvmt = 'LOGIN', ulg_tag = ''";
                    @mysql_query($query2, $link);
                    header("Location: $url");
                }
            } else {
                $alert = "Error al validar contratos";
            }
        } else {
            $alert = 'Usuario y/o contraseña no validas';
        }
    } else {
        $alert = 'Error al validar usuario, contacte a su administrador';
    }
    if ($alert != null) {
        $url = 'index.php';
        echo "<script type='text/javascript'>";
        echo "window.alert('" . $alert . "');";
        echo "location.href='index.php'";
        echo '</script>';
    }
    @mysql_close($link);
} else {
    echo "<script type='text/javascript'>";
    echo "window.alert('Debes introducir usuario y contraseña para iniciar sesión');";
    echo "location.href='index.php'";
    echo '</script>';
}
?>