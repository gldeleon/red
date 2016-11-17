<?php

$bud = (isset($_GET["bud"]) && !empty($_GET["bud"])) ? $_GET["bud"] : "0";
$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";

require("../../classes/pdf/fpdf.php");
$maxwidth = 215;
$numtrat = 0;
$total = 0;

//*** Llama al archivo de configuracion.
include "../../config.inc.php";

//*** Establece la zona horaria para trabajar con fechas.
date_default_timezone_set("America/Mexico_City");

//*** Obtiene un objeto de conexion con la base de datos.
$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
$patnom = "NOMBRE DEL PACIENTE";
$clinom = "";
$clitel = "";
$climail = "";
$cliaddress = "";
$budcli = $cli;
$budnum = "0";
$buddate = date("Y-m-d");
$isAgreementBnf = false;
$isMAPFRE = false;
$isMovilOnly = false;
$query = "select b.bud_number, b.bud_date, p.pat_complete, c.cli_name, c.cli_tel, c.cli_email,
        c.cli_dir, c.clc_id, p.agr_id, b.cli_id from {$DBName}.budget as b left join {$DBName}.patient
        as p on p.pat_id = b.pat_id left join {$DBName}.clinic as c on c.cli_id = b.cli_id
        where b.bud_id = {$bud} limit 1";
if ($result = @mysql_query($query, $link)) {
    $row = @mysql_fetch_row($result);
    $budnum = $row[0];
    $buddate = $row[1];
    $budcli = $row[9];
    $patnom = $row[2];
    $clinom = $row[3];
    $clitel = $row[4];
    $climail = $row[5];
    $cliaddress = $row[6];
    $cliclass = $row[7];
    $isAgreementBnf = ($row[8] != "0");
    $isMAPFRE = ($row[8] == "114" || $row[8] == "115");
    $is3M = ($row[8] == "61" || $row[8] == "64");
    $isAdecco = ($row[8] == "111");
    $isMetlife = ($row[8] == "85");
    $isMercer = ($row[8] == "4");
    $isMovilOnly = ($row[8] == 132);
    @mysql_free_result($result);
}
$address = "";

$totalahorro = 0;
$query = "select sum(q1.resta) as ahorro from (select (ts.trp_price - ts.trs_amount) as resta
	from {$DBName}.session as s left join {$DBName}.treatsession as ts on s.ses_number = ts.ses_number
	and s.cli_id = ts.cli_id where s.pat_id = '" . $pat . "' and s.ses_date <= '{$buddate}') as q1";
if ($result = @mysql_query($query, $link)) {
    $totalahorro = @mysql_result($result, 0);
    @mysql_free_result($result);
}
$totalahorro = is_null($totalahorro) ? 0 : floatval($totalahorro);
$totalahorro = number_format($totalahorro, 0, ",", ".");

$ahorro = 0;
$data = array();
$query = "select b.btr_id, b.trt_id, t.trt_name, sum(b.bud_qty),
	b.trs_amount, b.btr_stage, b.trp_price, b.agt_discount, b.bun_id
	from {$DBName}.budtreat as b left join {$DBName}.treatment as t on
	t.trt_id = b.trt_id where b.bud_number = {$budnum} and b.cli_id = {$cli}
	group by b.btr_stage, b.trt_id, b.trs_amount order by b.btr_stage,
	b.bud_qty desc, t.trt_abbr";
if ($result = @mysql_query($query, $link)) {
    while ($row = @mysql_fetch_row($result)) {
        $fila = $row;
        $trs_amount = $row[4];
        $trp_price = $row[6];
        $agt_discount = $row[7];

        //*** Determina el precio mas reciente del tratamiento, de
        // acuerdo a la fecha del presupuesto.
        $query2 = "select t.trp_price from {$DBName}.treatprice as t
			where t.trt_id = {$row[1]} and t.cli_class = {$cliclass} and
			t.trp_date <= '{$buddate}' order by t.trp_date desc limit 1";
        if ($result2 = @mysql_query($query2, $link)) {
            $trp_price = @mysql_result($result2, 0);
            @mysql_free_result($result2);
        }
        $trp_price = is_null($trp_price) ? 0 : intval($trp_price, 10);

        if ($trp_price != $trs_amount && $agt_discount == "0") {
            //*** Determina el porcentaje de descuento de acuerdo al
            // plan o convenio del paciente.
            // UPDATE 2009-11-09: Y de acuerdo a la fecha del presupuesto.
            $query3 = "select a.agt_discount from {$DBName}.agreetreat as a
				left join {$DBName}.patient as p on p.agr_id = a.agr_id
				where p.pat_id = '" . utf8_encode($pat) . "' and a.trt_id = {$row[1]}
				and a.agt_date <= '{$buddate}' order by a.agt_date desc limit 1";
            if ($result3 = @mysql_query($query3, $link)) {
                $agt_discount = @mysql_result($result3, 0);
                @mysql_free_result($result3);
            }
        }
        array_push($fila, $trp_price);
        array_push($fila, $agt_discount);
        $numtrat++;

        $data[] = $fila;
    }
    @mysql_free_result($result);
}

class PDF extends FPDF {

    function Header() {
        global $meses, $patnom, $maxwidth, $buddate, $isAgreementBnf, $isMAPFRE, $is3M, $isAdecco, $isMetlife, $isMercer;

        $this->SetFont("Arial_Narrow", "B", 11);
        $this->Cell($maxwidth - 70, 8, "Presupuesto", 0, 0, "L");
        $this->Ln(10);
        $this->SetFont("Arial_Narrow", "", 11);
        $this->Cell($maxwidth - 123, 6, $patnom, 0, 0, "L");
        $this->Cell(53, 6, (date("d", strtotime($buddate)) . " de " . $meses[date("n", strtotime($buddate)) - 1] . " de " . date("Y", strtotime($buddate))), 0, 0, "R");
        $this->Ln(10);
        $this->SetFont("Arial_Narrow", "B", 10);
        $this->SetFillColor(242);
        $this->Cell(20, 5, "Etapa", 1, 0, "C", 1);
        $this->Cell(15, 5, "Cant.", 1, 0, "C", 1);

        $factor = $isAgreementBnf ? 130 : 105;
        $this->Cell($maxwidth - $factor, 5, "Tratamiento", 1, 0, "C", 1);
        $factor = $isAgreementBnf ? 0 : 5;
        $this->Cell(20 + $factor, 5, "Precio Unit.", 1, 0, "C", 1);
        if ($isAgreementBnf) {
            $this->Cell(15, 5, "Desc.", 1, 0, "C", 1);
            $this->Cell(20, 5, "Ahorro", 1, 0, "C", 1);
        }
        $this->Cell(20 + $factor, 5, "Subtotal", 1, 0, "C", 1);
    }

    function BasicTable() {
        global $data, $maxwidth, $total, $isAgreementBnf, $ahorro;

        $this->SetFont("Arial_Narrow", "", 10);
        $btr_stage = "0";
        $count = 0;
        $subtotal = 0;
        $tahorro = 0;
        foreach ($data as $item => $value) {
            if ($value[5] != $btr_stage) {
                if ($count != 0) {
                    $this->Cell(20, 5, "", "LBR", 0);
                    $this->Cell(15, 5, "", "LBR", 0);
                    $factor = $isAgreementBnf ? 130 : 105;
                    $this->Cell($maxwidth - $factor, 5, "", "LBR", 0);
                    $factor = $isAgreementBnf ? 15 : 5;
                    $this->Cell(20 + $factor, 5, "Subtotal", "LBR", 0, "R");
                    if ($isAgreementBnf) {
                        $this->SetFont("Arial_Narrow", "B", 10);
                        $this->Cell(20, 5, "", "LBR", 0, "R");
                        $this->SetFont("Arial_Narrow", "", 10);
                    }
                    $factor = $isAgreementBnf ? 0 : 5;
                    $this->Cell(20 + $factor, 5, ("$" . number_format($subtotal, 0, ".", ",")), "LBR", 0, "R");
                    $subtotal = 0;
                }
                $btr_stage = $value[5];

                /** Imprime el numero de etapa. Inicia en una línea nueva. */
                $this->Ln();
                $this->Cell(20, 5, $btr_stage, "LR", 0, "C");
            } else {
                /** Por cada etapa, cuando ya imprimio el numero de etapa, imprime una celda en blanco. */
                $this->Cell(20, 5, "", "LR", 0, "C");
            }

            $tratnom = $value[2];
            $tratcant = $value[3];
            $tprice = floatval($value[4]);
            $rprice = $value[6];
            $discount = $value[7];
            $tsubprice = intval($tratcant) * $tprice;
            $subtotal += $tsubprice;
            $total += $tsubprice;
            $ahorro += ($tratcant * $rprice) - $tsubprice;

            /** Imprime el resto de las celdas, de una etapa, por tratamiento. */
            $this->Cell(15, 5, $tratcant, "LR", 0, "C");
            $factor = $isAgreementBnf ? 130 : 105;
            $this->Cell($maxwidth - $factor, 5, $tratnom, "LR", 0, "L");
            $factor = $isAgreementBnf ? 0 : 5;
            $this->Cell(20 + $factor, 5, ("$" . number_format($rprice, 0, ".", ",")), "LBR", 0, "R");
            if ($isAgreementBnf) {
                $this->Cell(15, 5, (number_format($discount, 0, ".", ",") . "%"), "LBR", 0, "R");
                $this->SetFont("Arial_Narrow", "B", 10);

                $saving = $tratcant * ($rprice - $tprice);
                $saving = ($saving < 0) ? 0 : $saving;

                $tahorro += $saving;
                $tahorro = ($tahorro < 0) ? 0 : $tahorro;

                $this->Cell(20, 5, ("$" . number_format($saving, 0, ".", ",")), "LBR", 0, "R");
                $this->SetFont("Arial_Narrow", "", 10);
            }
            $this->Cell(20 + $factor, 5, ("$" . number_format($tsubprice, 0, ".", ",")), "LBR", 0, "R");

            /** Termina con un salto de línea. */
            $this->Ln();
            $count++;
        }
        if ($count == count($data)) {
            $this->Cell(20, 5, "", "LR", 0);
            $this->Cell(15, 5, "", "LR", 0);
            $factor = $isAgreementBnf ? 130 : 105;
            $this->Cell($maxwidth - $factor, 5, "", "LR", 0);
            $factor = $isAgreementBnf ? 15 : 5;
            $this->Cell(20 + $factor, 5, "Subtotal", "LBR", 0, "R");
            if ($isAgreementBnf) {
                $this->SetFont("Arial_Narrow", "B", 10);
                $this->Cell(20, 5, ("$" . number_format($tahorro, 0, ".", ",")), "LBR", 0, "R");
                $this->SetFont("Arial_Narrow", "", 10);
            }
            $factor = $isAgreementBnf ? 0 : 5;
            $this->Cell(20 + $factor, 5, ("$" . number_format($subtotal, 0, ".", ",")), "LBR", 0, "R");
        }
    }

    function Footer() {
        global $maxwidth, $address, $total, $isMAPFRE, $isAgreementBnf, $ahorro, $numtrat, $totalahorro, $budcli, $isMovilOnly;

        $this->Ln();
        $this->Cell(20, 5, "", 1, 0);
        $this->Cell(15, 5, "", 1, 0);
        $factor = $isAgreementBnf ? 130 : 105;
        $this->Cell($maxwidth - $factor, 5, "", 1, 0);
        $factor = $isAgreementBnf ? 35 : 5;
        $this->Cell(20 + $factor, 5, "Total", 1, 0, "R");
        $factor = $isAgreementBnf ? 0 : 5;
        $this->Cell(20 + $factor, 5, ("$" . number_format($total, 0, ".", ",")), 1, 0, "R");

        $this->Ln(10);
        if ($numtrat < 7) {
            for ($n = $numtrat; $n < 7; $n++) {
                $this->Cell($maxwidth, 5, "", 0, 1, "L");
            }
        }
        $this->SetFont("Arial_Narrow", "", 9);
        $this->Cell($maxwidth - 20, 5, "OBSERVACIONES:", "LTR", 1, "L");

        $leyenda = array(
            "* Este presupuesto tiene una vigencia de 30 días. Los tratamientos a realizar pueden variar."
        );
        $this->Cell($maxwidth - 20, 4, utf8_decode($leyenda[0]), "LR", 1, "L");
        $tutor = "* Antes de realizar algún tratamiento requerimos el consentimiento del paciente, y de su tutor en menores de edad.";
        $tutor = utf8_decode($tutor);
        $this->Cell($maxwidth - 20, 4, $tutor, "LRB", 1, "L");
        $this->SetFont("Arial_Narrow", "B", 8);
        $this->Ln(1);
        $this->Cell($maxwidth - 20, 5, "", 0, 1, "C");
    }

}

$pdf = new PDF("P", "mm", "Letter"); //215.9 x 279.4
$pdf->SetTitle("Presupuesto");
$pdf->SetAuthor("Kobe");
$pdf->SetSubject("Presupuesto en formato PDF");
$pdf->SetCreator("FPDF 1.53 / PHP " . phpversion());
$pdf->AddFont("Arial_Narrow", "", "anarrow.php");
$pdf->AddFont("Arial_Narrow", "B", "anarrowb.php");
$pdf->SetMargins(10, 10);
$pdf->AddPage();
$pdf->BasicTable();
$pdf->Output();
?>