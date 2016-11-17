<?php
	//*** Llama los archivos de configuracion y funciones.
	
	include "../../config.inc.php";
	include "functionsDebt.inc.php";
	include "config_report.inc.php";
	
	//*** Establece la zona horaria para trabajar con fechas.
	date_default_timezone_set("America/Mexico_City");
	
	$curmes = date("m") - 1;
	$curmes = date("t", mktime(0,0,0,$curmes,1,1));
	//*** Las fechas se generan con base en mktime, m-d-Y
	$ff = date("Y-m-d", mktime(0, 0, 0, date("n") - 1, $curmes, date("Y")));
	//*** Las fechas mensuales son de trece meses antes al actual.
	$fim = date("Y-m-d", mktime(0, 0, 0, date("n") - 13, 1, date("Y")));
	//*** Las fechas trimestrales son de veinticuatro meses antes al actual.
	$fit = date("Y-m-d", mktime(0, 0, 0, date("n") - 24, date("j"), date("Y")));
	//*** Fecha anual.
	$fia = date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")));
	$currdate = date("n_y", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$fi = (isset($_GET["fi"]) && !empty($_GET["fi"])) ? $_GET["fi"] : $fim; //fecha inicio
	$ff = (isset($_GET["ff"]) && !empty($_GET["ff"])) ? $_GET["ff"] : $ff; //fecha fin
	$num = $den = 0;
	$yearlist = $lyearlist = "";
	$monthlist = $lmonthlist = "";
	
	$splitfi = explode("-", $fi);
	$splitff = explode("-", $ff);
	
	$curyear = ($ff != $ff) ? date("Y") + 1 : $splitff[0];
	$lastyear = ($fi == $fim) ? date("Y") - 1 : $splitfi[0];
	$curmonth = ($ff != $ff) ? date("m") - 1 : $splitff[1];
	$lastmonth = ($fi == $fim) ? date("m") - 1 : $splitfi[1];
	
	$thisYear = date("Y") + 1;
	
	$smonth = array("Enero", "Febrero", "Marzo", "Abril", "May", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	
	for($i=2006;$i<$thisYear; $i++){
		$selectedf = ($i == $curyear) ? " selected='selected' " : "";
		$yearlist .= "<option {$selectedf} value='{$i}'>".$i."</option>\n";
	}
	
	for($i=2006;$i<$thisYear; $i++){
		$selectedi = ($i == $lastyear) ? " selected='selected' " : "";
		$lyearlist .= "<option {$selectedi} value='{$i}'>".$i."</option>\n";
	}
	
	for($i=1;$i<13; $i++){
		$selectedmf = ($i == $curmonth) ? " selected='selected' " : "";
		$monthlist .= "<option {$selectedmf} value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".$smonth[$i-1]."</option>\n";
	}
	
	for($i=1;$i<13; $i++){
		$selectedmi = ($i == $lastmonth) ? " selected='selected' " : "";
		$lmonthlist .= "<option {$selectedmi} value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".$smonth[$i-1]."</option>\n";
	}
	
	
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
	
	//*** Los arreglos de fechas.
	$m = array("fim" => $fim, "ffm" => $ff);
	$t = array("fit" => $fit, "fft" => $ff);
	$a = array("fia" => $fia, "ffa" => $ff);
	//*** Arreglo de consulta
	$qa = array($m, $t, $a);
	
	$fiarr = explode("-", $fi); //Y-m-d
	$fimk = mktime(0, 0, 0, $fiarr[1], $fiarr[2], $fiarr[0]);
	$ffarr = explode("-", $ff); //Y-m-d
	$ffmk = mktime(0, 0, 0, $ffarr[1], $ffarr[2], $ffarr[0]);
	
	$mabbr = array("");
	foreach($meses as $arr) {
		$mabbr[] = ucfirst(substr($arr, 0, 3)); //coloca los meses con formato de 3 letras y la primera en mayuscula e.g. Ene, Feb, Mar
	}
	
	$arrmkey = array();
	$arrmval = array();
	$arrtyear = array();
	if($ff > $fi) {
		for($i = $fimk; $i < $ffmk; ) {
			$mes = date("n", $i);
			$anio = date("y", $i);
			$fts = $mabbr[$mes]."-".$anio;
			if(!in_array($fts, $arrmkey)) {
				$arrmkey[] = $fts;
				$arrmval[] = $mes."-".$anio;
			}
			if(!in_array($anio, $arrtyear)) {
				$arrtyear[] = $anio;
			}
			$i += 86400;
		}
	}
	else if($ff == $fi) {
		$mes = date("n", $ffmk);
		$anio = date("y", $ffmk);
		$fts = $mabbr[$mes]."-".$anio;
		$arrmkey[] = $fts;
		$arrmval[] = $mes."-".$anio;
	}
	$arrmeses = array_combine($arrmkey, $arrmval);
	
	$arrtrim = array();
	$arrter = array(
			"1T" => array(1, 2, 3),
			"2T" => array(4, 5, 6),
			"3T" => array(7, 8, 9),
			"4T" => array(10, 11, 12)
	);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de Agenda</title>
		<link rel="stylesheet" type="text/css" href="../../components/jscalendar/calendar.css" />
		<script type="text/javascript" src="../../components/jscalendar/calendar.js"></script>
		<script type="text/javascript" src="../../components/jscalendar/lang/calendar-es.js"></script>
		<script type="text/javascript" src="../../components/jscalendar/calendar-setup.js"></script>
		<link rel="stylesheet" href="mod_report.css" type="text/css" />
		<script type='text/javascript' src='js/prototype.js'></script>
		<script type='text/javascript' src='js/scriptaculous-js-1.8.3/src/scriptaculous.js'></script>
		<script type='text/javascript' src='js/lightview.js'></script>
		<link rel="stylesheet" type="text/css" href="css/lightview.css" />
		<script type="text/javascript">
			<!--
				<?php
					echo "var prdc = '{$prdc}';";
					echo "var fis = '{$fi}';";
					echo "var ffs = '{$ff}';";
					foreach($qa as $arr) {
						foreach($arr as $key => $val) {
							echo "var {$key} = '{$val}';";
						}
					}
				?>
			//-->
		</script>
		<script type="text/javascript">
			function generaExcel(){
				var ff = document.getElementById("ff");
				var fi = document.getElementById("fi");
				window.open("excelAgenda.php?fi="+fi.value+"&ff="+ff.value,"_blank","width=10,height=10");
			}
		</script>
	</head>
	
	
	<body>
		<b style="font-size: 14px;">Reporte de Agenda</b>
		<br />
		<br />
		<center>
			<form name="f" action="<?=$_SERVER['PHP_SELF']; ?>" method="get" style="padding: 0px; margin: 0px;">
				<table class="header">

				<tr>
					<td class="header">Fecha inicial:</td>
					<td class="content" colspan="2"><input type="text"
						class="calendar_trigger" id="fi" name="fi" value="aaaa-mm-dd" /></td>
				</tr>
				<tr>
					<td class="header">Fecha final:</td>
					<td class="content" colspan="2"><input type="text"
						class="calendar_trigger" id="ff" name="ff" value="aaaa-mm-dd" /></td>
				</tr>
				<tr>
					<td class="header_request" colspan="7"><input type="button"
						value="Genera Reporte" onclick="generaExcel();" /></td>
				</tr>
			</table>
			</form>
			<br />
			
			<?php 
				//$filename = "reporteexcel.xls";
				//header('Content-type: application/x-msexcel');
				//header('Content-Disposition: attachment; filename='.$filename);
			?>
		</center>
		
		<script type="text/javascript">
			/* [CDATA[ */
			Calendar.setup({
				inputField: "fi", ifFormat: "%Y-%m-%d", button: "fi_trigger", align: "Br", weekNumbers: false,
				singleClick: true, firstDay: 0, showOthers: true
			});
			Calendar.setup({
				inputField: "ff", ifFormat: "%Y-%m-%d", button: "ff_trigger", align: "Br", weekNumbers: false,
				singleClick: true, firstDay: 0, showOthers: true
			});
			/* ]] */
		</script>
		<?php
			if($link) {
				@mysql_close($link);
			}
		?>
	</body>
</html>