<?php

	//Llama al archivo de configuracion.
	include "../config.inc.php";

	date_default_timezone_set("America/Mexico_City");
	//Carga variables URL y determina sus valores iniciales.
	$rec = (isset($_GET["rec"]) && !empty($_GET["rec"])) ? $_GET["rec"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";

	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$pat = "";
	$patname = "NOMBRE DEL PACIENTE";
	$recdate = array(date("Y"), date("m"), date("d"));
	$recnum = $sessnum = "0";
	$recamount = $recpayment = $pm_amount = 0;
	$pm_early = $credit = false;

	$query = "select r.rec_id, r.ses_number, r.pat_id, r.rec_number, r.rec_date,
	r.rec_amount, r.rec_payment, r.rec_paymeth, p.pat_complete from {$DBName}.receipt as r
	left join {$DBName}.patient as p on p.pat_id = r.pat_id
	where r.rec_number = {$rec} and r.cli_id = {$cli}";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			$pat = $row[2];
			$patname = $row[8];
			$recnum = $row[3];
			$recdate = explode("-", $row[4]);
			$sessnum = $row[1];
			$recpayment = is_null($row[6]) ? 0 : $row[6];
			$recpaymeth = is_null($row[7]) ? "" : $row[7];
			$recamount += (is_null($row[5]) || $recpaymeth == "PA" || $recpaymeth == "CD") ? 0 : intval($row[5], 10);
			if($recpaymeth == "PA") {
				$pm_early = true;
				$pm_amount = is_null($row[5]) ? 0 : intval($row[5], 10);
			}
			if($recpaymeth == "CD") {
				$credit = true;
			}
		}
		@mysql_free_result($result);
	}

	$limpieza = false;
	$blanq = false;
	$descuento150 = false;
	$data = array();
	$query = "select ts.trt_id, sum(ts.trs_qty), ts.trs_sessnum, ts.trs_sessfrom, ts.trp_price,
	ts.agt_discount, sum(ts.trs_amount), t.trt_name, t.trt_divsess from ".$DBName.".treatsession as ts
	left join ".$DBName.".treatment as t on t.trt_id = ts.trt_id
	where ts.ses_number = ".$sessnum." and ts.cli_id = ".$cli."
	group by ts.cli_id, ts.trs_sessnum, ts.trt_id, ts.trs_amount order by t.trt_name";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			$fila = implode(",", $row);
			$tid = $row[0];
			$discount = $row[5];
			$price = round($row[4]);
			$total = round($row[6]);
			if($tid == "4") {
				$limpieza = true;
			}
			if($tid == "30") {
				$blanq = true;
			}
			if(($tid == "4" && $blanq && ($discount < 100) && ($total == ($price - 150))) || ($tid == "30" && $limpieza)) {
				$descuento150 = true;
			}
			$fila = explode(",", $fila);
			$data[] = $fila;
		}
		@mysql_free_result($result);
	}

	$bundles = array();
	$query = "select bd.bun_name, sum(if(bt.bun_paid = 1, bt.trs_amount, 0))
	from {$DBName}.budtreat as bt left join {$DBName}.bundle as bd on bt.bun_id = bd.bun_id
	where bt.bun_paid_cli = {$cli} and bt.rec_number = {$rec} and bt.bun_id > 0 and bt.bun_paid = 1
	group by bt.bun_id";
	if($result = @mysql_query($query, $link)) {
		while($row = @mysql_fetch_row($result)) {
			$bundles[] = $row;
		}
		@mysql_free_result($result);
	}

	require('pdf/fpdf.php');
	$maxwidth = 215 - 20;

	class PDF extends FPDF
	{
		function Header()
		{
			global $maxwidth, $pat, $patname, $recnum, $recdate;

			$this->SetFont("Arial_Narrow", "", 11);
			$this->Cell($maxwidth - 98, 6, "", 0, 0);
			$this->Cell(96, 6, $patname, 0, 0, "R");
			$this->Cell(2, 6, "", 0, 1);

			$this->Ln(2);
			$this->SetFont("Arial_Narrow", "", 8);
			$this->Cell($maxwidth - 25, 9, "", 0, 0);
			$this->Cell(25, 9, $recnum, 0, 1, "L");

			$this->Ln(2);
			$this->SetFont("Arial_Narrow", "", 9);
			$this->Cell(12, 10, $recdate[2], 0, 0, "L");
			$this->Cell(12, 10, $recdate[1], 0, 0, "L");
			$this->Cell(14, 10, $recdate[0], 0, 0, "L");
			$this->Cell($maxwidth - 110, 10, "", 0, 0);
			$this->Cell(30, 10, "45", 0, 0, "C");
			$this->Cell(40, 10, $pat, 0, 0, "R");
			$this->Cell(2, 10, "", 0, 1);

			$this->Ln(8);
			$this->SetFont("Arial_Narrow", "B", 10);
			$this->Cell($maxwidth - 60, 6, "", 0, 0);
			$this->Cell(20, 6, "P UNITARIO", 0, 0, "C");
			$this->Cell(20, 6, "DESC/PLAN", 0, 0, "C");
			$this->Cell(20, 6, "SUBTOTAL", 0, 1, "C");
		}

		function BasicTable() {
			global $maxwidth, $data, $recpayment, $recamount, $limpieza, $blanq, $descuento150, $pm_early, $pm_amount,
				   $bundles;

			$this->Ln(3);
			$this->SetFont("Arial_Narrow", "", 10);
			$cuenta_lineas = 0;
			$subtotal = 0;
			foreach($data as $item => $value) {
				$trt_count = $value[1];
				$trt_sessnum = is_null($value[2]) ? 1 : intval($value[2], 10);
				$trt_sessfrom = is_null($value[3]) ? 1 : intval($value[3], 10);
				$trt_name = $value[7].($trt_sessfrom > 1 ? (" (".$trt_sessnum."/".$trt_sessfrom.")") : "");
				$trt_divsess = is_null($value[8]) ? 0 : intval($value[8], 10);
				$price_diff = ($trt_sessfrom == 1 || $trt_divsess == 1) ?  1 : floatval(1 / $trt_sessfrom);
				$trt_price = intval($value[4], 10);
				$this->Cell(22, 6, $trt_count, 0, 0, "L");
				$this->Cell($maxwidth - 82, 6, $trt_name, 0, 0, "L");
				$this->Cell(20, 6, "$".number_format($trt_price, 0, ".", ","), 0, 0, "C");
				$this->Cell(20, 6, $value[5]."%", 0, 0, "C");
				$total = is_null($value[6]) ? 0 : intval($value[6], 10);
				$this->Cell(20, 6, "$".number_format($total, 0, ".", ","), 0, 1, "C");
				$subtotal += $total;
				$cuenta_lineas++;
			}
			if($descuento150 == true) {
				$this->Cell(22, 6, "", 0, 0, "L");
				$this->Cell($maxwidth - 82, 6, "INCLUYE DESCUENTO EN LIMPIEZA POR PAQUETE", 0, 0, "L");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "", 0, 1, "C");
				$cuenta_lineas++;
			}
			if($pm_early == true) {
				$this->Cell(22, 6, "", 0, 0, "L");
				$this->Cell($maxwidth - 82, 6, "PAGO - APLICACION DE SALDO A FAVOR", 0, 0, "L");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "$".number_format($pm_amount, 0, ".", ","), 0, 1, "C");
				$subtotal -= $pm_amount;
				$cuenta_lineas++;
			}
			if($subtotal < $recamount) {
				if(count($bundles) > 0) {
					foreach($bundles as $key => $bundle) {
						$this->Cell(22, 6, "1", 0, 0, "L");
						$this->Cell($maxwidth - 82, 6, "PAQUETE DE ".$bundle[0], 0, 0, "L");
						$this->Cell(20, 6, "", 0, 0, "C");
						$this->Cell(20, 6, "", 0, 0, "C");
						$this->Cell(20, 6, "$".number_format($bundle[1], 0, ".", ","), 0, 1, "C");
						$cuenta_lineas++;
					}
				}
				else {
					$this->Cell(22, 6, "", 0, 0, "L");
					$this->Cell($maxwidth - 82, 6, "PAGO ANTICIPADO", 0, 0, "L");
					$this->Cell(20, 6, "", 0, 0, "C");
					$this->Cell(20, 6, "", 0, 0, "C");
					$resta = $recamount - $subtotal;
					$this->Cell(20, 6, "$".number_format($resta, 0, ".", ","), 0, 1, "C");
					$cuenta_lineas++;
				}
			}
			else if($subtotal > $recamount) {
				$this->Cell(22, 6, "", 0, 0, "L");
				$this->Cell($maxwidth - 82, 6, "PAGO A CUENTA DE ESTE TRATAMIENTO", 0, 0, "L");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "$".number_format($recamount, 0, ".", ","), 0, 1, "C");
				$cuenta_lineas++;
				$this->Cell(22, 6, "", 0, 0, "L");
				$this->Cell($maxwidth - 82, 6, "ADEUDO POR ESTE CONCEPTO", 0, 0, "L");
				$this->Cell(20, 6, "", 0, 0, "C");
				$this->Cell(20, 6, "", 0, 0, "C");
				$resta = $subtotal - $recamount;
				$this->Cell(20, 6, "$".number_format($resta, 0, ".", ","), 0, 1, "C");
				$cuenta_lineas++;
			}

			/* El numero de lineas totales es 8, menos una de quejas, 7. */
			$lineas_totales = 7;
			if($cuenta_lineas < $lineas_totales) {
				$this->Ln(6 * ($lineas_totales - $cuenta_lineas));
			}

			/* Linea para quejas y comentarios. */
			$this->SetFont("Arial_Narrow", "", 7);
			$this->Cell(22, 6, "", 0, 0);
			$this->Cell($maxwidth - 82, 6, "", 0, 0, "L");
			$this->Cell(20, 6, "", 0, 0);
			$this->Cell(20, 6, "", 0, 0);
			$this->Cell(20, 6, "", 0, 1);
		}

		function Footer()
		{
			global $maxwidth, $recamount;

			$this->Ln(3);
			$this->SetFont("Arial_Narrow", "", 9);
			$this->Cell(22, 5, "", 0, 0);
			$this->Cell($maxwidth - 82, 5, "", 0, 0, "L");
			$this->Cell(20, 5, "", 0, 0);
			$this->Cell(20, 5, "", 0, 0);
			$this->Cell(20, 5, "", 0, 1);
			$this->Cell(22, 5, "", 0, 0);
			$this->Cell($maxwidth - 82, 5, "", 0, 0, "L");
			$this->Cell(20, 5, "", 0, 0);
			$this->Cell(20, 5, "", 0, 0);
			$this->Cell(20, 5, "", 0, 1);

			$this->Ln(3);
			$this->Cell($maxwidth - 40, 5, "", 0, 0);
			$this->Cell(40, 5, "$".number_format($recamount, 0, ".", ","), 0, 1, "C");
			$this->Cell($maxwidth - 40, 5, "", 0, 0);
			$this->Cell(40, 5, "$".number_format(0, 0, ".", ","), 0, 1, "C");
			$this->Cell($maxwidth - 40, 5, "", 0, 0);
			$this->Cell(40, 5, "$".number_format($recamount, 0, ".", ","), 0, 1, "C");
		}
	}
	$pdf = new PDF("P", "mm", "Letter"); //215.9 x 279.4
	$pdf->SetTitle("Recibo");
	$pdf->SetAuthor("dentalia");
	$pdf->SetSubject("Recibo en formato PDF");
	$pdf->SetCreator("FPDF 1.53 / PHP ".phpversion());
	$pdf->AddFont("Arial_Narrow", "", "anarrow.php");
	$pdf->AddFont("Arial_Narrow", "B", "anarrowb.php");
	$pdf->SetMargins(10, 10);
	$pdf->AddPage();
	$pdf->BasicTable();
	$pdf->Output();
?>