<?

$res = "ERROR*";
$ln = (isset($_POST["ln"]) && !empty($_POST["ln"])) ? $_POST["ln"] : "";
$sn = (isset($_POST["sn"]) && !empty($_POST["sn"])) ? $_POST["sn"] : "X";
$nm = (isset($_POST["nm"]) && !empty($_POST["nm"])) ? $_POST["nm"] : "";
$mail = (isset($_POST["mail"]) && !empty($_POST["mail"])) ? $_POST["mail"] : "";
$agr = (isset($_POST["agr"]) && !empty($_POST["agr"])) ? $_POST["agr"] : "0";
$option = (isset($_POST["option"]) && !empty($_POST["option"])) ? $_POST["option"] : "false";
$tel = (isset($_POST["tel"]) && !empty($_POST["tel"])) ? $_POST["tel"] : "";
$pol = (isset($_POST["pol"]) && !empty($_POST["pol"])) ? $_POST["pol"] : "";
$uid = (isset($_POST["uid"]) && !empty($_POST["uid"])) ? $_POST["uid"] : "1";
$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";

if ($ln != "" && $sn != "" && $nm != "") {
    include "../config.inc.php";

    $conacento = array("á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ");
    $sinacento = array("a", "e", "i", "o", "u", "ñ", "a", "e", "i", "o", "u", "ñ");
    $ln = strtoupper(str_replace($conacento, $sinacento, $ln));
    $sn = strtoupper(str_replace($conacento, $sinacento, $sn));
    $nm = strtoupper(str_replace($conacento, $sinacento, $nm));

    $ln = trim($ln);
    $sn = trim($sn);
    $nm = trim($nm);
    $ln = utf8_decode($ln);
    $sn = utf8_decode($sn);
    $nm = utf8_decode($nm);
    $mail = utf8_decode($mail);

    $lnp = preg_replace('/\s/', '', $ln);
    $snp = preg_replace('/\s/', '', $sn);
    $nmp = preg_replace('/\s/', '', $nm);

    /** Establece la zona horaria para trabajar con fechas. */
    date_default_timezone_set("America/Mexico_City");

    $link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
    //E10			F10			G10
    //CONCATENAR(IZQUIERDA(E10,2),DERECHA(F10,2),IZQUIERDA(G10,2),DERECHA(E10,2),IZQUIERDA(F10,2),DERECHA(G10,2)
    $patid = substr($lnp, 0, 2) . substr($snp, -2, 2) . substr($nmp, 0, 2) . substr($lnp, -2, 2) . substr($snp, 0, 2) . substr($nmp, -2, 2);

    /* Agregamos validacion para confirmar que realmente el pat_id sea para una persona nueva */
    $query = "select pat_id, pat_name, pat_complete from {$DBName}.patient where pat_id = '{$patid}'";
    //echo $patid;
    //$result = @mysql_query($query, $link);
    if ($result = @mysql_query($query, $link)) {
        if (@mysql_num_rows($result) >= 1 && $option == "false") {
            @mysql_close($link);
            echo "EXISTE*";
            exit();
            /* comprobamos que el o los nombres sean exactamente iguales */
//            $userexist = @mysql_fetch_array($result);
//            if (trim($userexist['pat_name']) === trim($nm)) {
//                @mysql_close($link);
//                echo "EXISTE*";
//                exit();
//            }
            //else {
//                @mysql_free_result($result);
//                $max = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20');
//                for ($i = 0; $i < count($max); $i++) {
//                    $pat = substr($patid, 0, -2) . $max[$i];
//                    $query = "select pat_id, pat_name, pat_complete from {$DBName}.patient where pat_id = '{$patid}'";
//                    $result = @mysql_query($query, $link);
//                    if (@mysql_num_rows($result) >= 1) {
//                        $i = $i + 1;
//                        $patid = substr($pat, 0, -2) . $max[$i];
//                    }
//                }
//            }
        } elseif (@mysql_num_rows($result) >= 1 && $option == "true") {
            //$num = 0;
            @mysql_free_result($result);
            $max = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20');
            for ($i = 0; $i < count($max); $i++) {
                $pat = substr($patid, 0, -2) . $max[$i];
                $query = "select pat_id, pat_name, pat_complete from {$DBName}.patient where pat_id = '{$patid}'";
                $result = @mysql_query($query, $link);
                if (@mysql_num_rows($result) >= 1) {
                    $i = $i + 1;
                    $patid = substr($pat, 0, -2) . $max[$i];
                }
            }
        }
    }

    $clc = "1";
    $query = "select clc_id from {$DBName}.clinic where cli_id = {$cli}";
    if ($result = @mysql_query($query, $link)) {
        $clc = @mysql_result($result, 0);
        $clc = is_null($clc) ? "1" : $clc;
        @mysql_free_result($result);
    }

    //
    $query = "insert into {$DBName}.patient set pat_id = '{$patid}', clc_id = '{$clc}',
		agr_id = '{$agr}', pat_lastname = '{$ln}', pat_surename = '{$sn}', pat_name = '{$nm}',
		pat_complete = '{$nm} {$ln} {$sn}', pat_ldate = curdate(), pat_gender = 'MA',
		pat_balance = 0, pat_mail = '{$mail}', pat_occupation = '', pat_ndate = '0000-00-00',
		pat_mtstatus = 0, pat_nson = '', pat_address = '', pat_okmail = 0, pat_telcontact = '',
		com_id = '0'";
    $res = mysql_query($query, $link);
    //var_dump($res);
    //$res = $query;
    if (@mysql_affected_rows($link) > 0) {
        //$res = "OK*{$patid}-{$nm} {$ln} {$sn}";
        $res = "OK";

        if ($tel != "") {
            $telArray = explode("*", $tel);
            array_pop($telArray);
            foreach ($telArray as $item => $tel) {
                if (strpos($tel, " - ") !== false) {
                    $telNum = explode(" - ", $tel);
                    $tel = $telNum[0];
                    $tel = preg_replace('/\(([0-9]+)\)\s+/', '', $tel);
                    $telabbr = $telNum[1];

                    /** Obtiene el tipo de telefono. */
                    $teltype = "0";
                    $query3 = "select tlt_id from {$DBName}.teltype
						where tlt_abbr = '{$telabbr}'";
                    if ($result3 = @mysql_query($query3, $link)) {
                        $teltype = @mysql_result($result3, 0);
                        @mysql_free_result($result3);
                    }

                    /** Inserta los telefonos del paciente. */
                    $query4 = "insert into {$DBName}.telephone values (null, '{$patid}', 0, 0, 0,
						{$teltype}, 52, 55, '{$tel}', 0)";
                    @mysql_query($query4, $link);
                    if (@mysql_affected_rows($link) >= 0) {
                        $res = "OK";
                    }
                }
            }
        }
    } else {
        $res = @mysql_error();
        echo $res;
        exit();
    }
    @mysql_close($link);
}
echo $res;
exit();
?>