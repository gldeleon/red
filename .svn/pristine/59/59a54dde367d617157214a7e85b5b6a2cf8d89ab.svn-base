<?php
include "config.inc.php";
include "functions.inc.php";
$alert = '';
if (!isset($_GET["active"]) || empty($_GET["active"])) {
	$alert = "La llave esta vacía, comunícate al 01800 011 56 56";
} else {
	$key = $_GET["active"];
	$query = "SELECT ac.cli_id
		,ac.type_contr
		,uc.usr_id
		,cli.cli_name
		,cli.cli_tel
		,cli.cli_email
		,cli.cli_dir
		,cli.cli_rfc
		,cli.cli_rfc_dom
		,cli.cli_fax
		,cli.pago_serv
		,cli.alta_date
		,cli.pago_extra
		,cli.px_extra
		,cli.px_pago
		,cli.pago_ort
		,cli.pago_esp
	FROM kobemxco_red.accept_cont AS ac 
	LEFT JOIN kobemxco_red.userclinic AS uc
		ON uc.cli_id = ac.cli_id
	LEFT JOIN kobemxco_red.clinic AS cli
		ON cli.cli_id = ac.cli_id
	WHERE md5(concat(ac.cli_id,'-',uc.usr_id)) = '$key';";
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	if (!$link) {
		die("Error al conectar " . mysql_error());
	}
	if ($exeQuery = @mysql_query($query, $link)) {
		if ($rowQ = @mysql_fetch_array($exeQuery)) {
			$cli_id = $rowQ["cli_id"];
			$usr_id = $rowQ["usr_id"];
			$nomPres = utf8_encode($rowQ["cli_name"]);
			$nomRepLegal = utf8_encode($rowQ["rep_legal"]);
			$numFax = !empty($rowQ["cli_fax"])? "Fax: ".$rowQ["cli_fax"]:"";
			$numTel = $rowQ["cli_tel"];
			$domConsultorio = $rowQ["cli_dir"];
			$domFiscal = $rowQ["cli_rfc_dom"];
			$RFC = $rowQ["cli_rfc"];
			$altaDa = DATE('d-m-Y', strtotime($rowQ["alta_date"]));
			$pagoServ = formatDinero($rowQ["pago_serv"]); // servcio de odonlogia gral
			$letraServ = cantDinero($rowQ["pago_serv"]);
			$cant_extra = formatDinero($rowQ["px_pago"]); // cantidad a pagar por cada px extra
			$letra_extra = cantDinero($rowQ["px_pago"]); // letra a pagar por cada px extra
			$de0a = $rowQ["pago_extra"]; // limites de px
			$apartir = $rowQ["px_extra"]; // apartir de que px se cobrara extra
			$contr = $rowQ["type_contr"];
//			$contr = 'EGO';
			$cant_xt_odon = formatDinero($rowQ["pago_ort"]);
			$let_xt_odon = cantDinero($rowQ["pago_ort"]);
			$cant_xt_esp = formatDinero($rowQ["pago_esp"]);
			$let_xt_esp = cantDinero($rowQ["pago_esp"]);
			$porcent_1 = $rowQ["p1"];
			$porcent_2 = $rowQ["p2"];
				
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html  xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="robots" content="noindex" />
					<title>CONTRATOS</title>
					<link href="cont.css" rel="stylesheet" type="text/css" />
					<script type="text/javascript" src="modules/cont.js"></script>
					<link type="text/css" rel="stylesheet" href="content/css/contstyle.css" />
					<link type="text/css" rel="stylesheet" href="<?php echo "content/css/" . $contr . "css"; ?>" />
					<script type="text/javascript" src="modules/jquery/jquery-1.9.0.min.js"></script>
				</head>
				<body oncopy="return false" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
					<div id="content">
						<div id = "imgL">
							<img src="images/welcitem1.png"></img>
						</div>
						<div id = "contentGray">
							<div id="cont1">
								<div id="imgK">
									<img id="im" src="images/logoini.png"></img>
								</div>
							</div>
							<div id = "cont2">
								<div id="contrt">
									<?php include "sync/" . $contr . ".php"; ?>
								</div>
							</div>
							<div id="cont3">
								<div id="buttonbox">
									<form action="insrt.php" method="post">
										<input type="hidden" name="statusContra" id="statusContra" value=""/>
										<input type="hidden" name="cliID" id="cliID" value="<?php echo $cli_id; ?>"/>
										<input type="hidden" name="contr" id="contr" value="<?php echo $contr; ?>"/>
										<input type="submit" value="ACEPTAR" id="ba" onclick="cambiaVal('ACEPTADO')"/>
										<input type="submit" value="RECHAZAR" id="bc" onclick="cambiaVal('RECHAZADO')"/>
									</form>
								</div>
							</div>

						</div>
					</div>
				</body>
			</html>
			<?php
		} else {
			$alert = "No se han encontrado resultados";
		}
	} else {
		$alert = "Error al buscar la información";
	}
}
if ($alert != '') {
	echo "<script type='text/javascript'>";
	echo "window.alert('" . $alert . "');";
	echo "location.href='index.php'";
	echo '</script>';
}


function cantDinero($num){
    $numArray = 
		array(
		0=> "CERO"
		,1 => "UN"
		,2 => "DOS"
		,3 => "TRES"
		,4 => "CUATRO"
		,5 => "CINCO"
		,6 => "SEIS"
		,7 => "SIETE"
		,8 => "OCHO"
		,9 => "NUEVE"
		,10 => "DIEZ"
		,11 => "ONCE"
		,12 => "DOCE"
		,13 => "TRECE"
		,14 => "CATORCE"
		,15 => "QUINCE"
		,16 => "DIECISEIS"
		,17 => "DIECISIETE"
		,18 => "DIECIOCHO"
		,19 => "DIECINUEVE"
		,20 => "VEINTI"
		,30 => "TREINTA"
		,40 => "CUARENTA"
		,50 => "CINCUENTA"
		,60 => "SESENTA"
		,70 => "SETENTA"
		,80 => "OCHENTA"
		,90 => "NOVENTA"
		,100 => "CIENTO"
		,200 => "DOSCIENTOS"
		,300 => "TRESCIENTOS"
		,400 => "CUATROCIENTOS"
		,500 => "QUINIENTOS"
		,600 => "SEISCIENTOS"
		,700 => "SETECIENTOS"
		,800 => "OCHOCIENTOS"
		,900 => "NOVECIENTOS"
    );
//
    $num = trim($num);
    $long = strlen($num);
    $punto = strpos($num, ".");
    $xaux_int = $num;
    $xdecimales = "00";
    if (!($punto === false)) {
        if ($punto == 0) {
            $num = "0" . $num;
            $punto = strpos($num, ".");
        }
        $xaux_int = substr($num, 0, $punto); 
        $xdecimales = substr($num . "00", $punto + 1, 2);
    }
 
    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT);
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; 
        $xexit = true;
        while ($xexit) {
            if ($xi == $xlimite) { 
                break; 
            }
 
            $x3digitos = ($xlimite - $xi) * -1; 
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); 
            for ($xy = 1; $xy < 4; $xy++) { 
                switch ($xy) {
                    case 1:
                        if (substr($xaux, 0, 3) < 100) {
                             
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $numArray)){
                                $xseek = $numArray[$key];
                                $xsub = subfijo($xaux); 
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $numArray[$key];
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } 
                        }
                        break;
                    case 2: 
                        if (substr($xaux, 1, 2) < 10) {
                             
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $numArray)) {
                                $xseek = $numArray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $numArray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } 
                        }
                        break;
                    case 3: 
                        if (substr($xaux, 2, 1) < 1) {
                             
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $numArray[$key]; 
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } 
                        break;
                }
            } 
            $xi = $xi + 3;
        } 
 
        if (substr(trim($xcadena), -5, 5) == "ILLON")
            $xcadena.= " DE";
 
        if (substr(trim($xcadena), -7, 7) == "ILLONES") 
            $xcadena.= " DE";
 
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($num < 1) {
                        $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                    }
                    if ($num >= 1 && $num < 2) {
                        $xcadena = "UN PESO $xdecimales/100 M.N. ";
                    }
                    if ($num >= 2) {
                        $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } 
        } 
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); 
        $xcadena = str_replace("  ", " ", $xcadena); 
        $xcadena = str_replace("UN UN", "UN", $xcadena); 
        $xcadena = str_replace("  ", " ", $xcadena);
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); 
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena);
        $xcadena = str_replace("DE UN", "UN", $xcadena);
    } 
    return trim($xcadena);
}

function subfijo($xx){ 
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    return $xsub;
}

function formatDinero($cant){
	$dec = "";
	if(strpos($cant,".")!== false){
		$float = explode(".",$cant);
		$cant = $float[0];
		$dec = ".".$float[1];
	}
	$lonCant = strlen($cant);
	$arrCant = str_split($cant);
	$numComas = floor($lonCant/3);
	$numDig = $lonCant%3;
	$format = "";
	$y= 1;
	$ok = 0;
	for($x= 0;$x<$lonCant;$x++){
		$format.=$arrCant[$x];
		if($y == $numDig && $ok== 0 && $lonCant>3){
			$format.=",";
			$ok = 1;
			$y = 0;
		}
		if($y == 3 && $x != $lonCant-1){
			$format.=",";
			$y = 0; 
		}
		$y++;
	}
	return "$".$format.$dec;
	
}