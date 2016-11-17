<?php
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
		exit();
	session_name("pra8atuw");
	/* set the cache expire to 30 minutes */
	session_cache_expire(30);
	session_start();
	if(count($_SESSION) > 0)
		extract($_SESSION);
	else {
		$_SESSION = array();
		session_destroy();
		header("Location: ../../classes/logout.php");
	}

	/** Llama al archivo de configuración. */
	include "../../config.inc.php";
	include "../../functions.inc.php";

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$UPD = (isset($_GET["UPD"]) && !empty($_GET["UPD"])) ? $_GET["UPD"] : "0";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	$esp = (isset($_GET["esp"]) && !empty($_GET["esp"])) ? $_GET["esp"] : "1";
	$rec = (isset($_GET["rec"]) && !empty($_GET["rec"])) ? $_GET["rec"] : "--";
    $gto = (isset($_GET["gto"]) && !empty($_GET["gto"])) ? $_GET["gto"] : "";

	/**
	 * Obtiene un recurso de conexion con la base de datos
	 * @type {Resource} $link
	 */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$AppTitle; ?></title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
	/*[CDATA[*/
		var cli = "<?=$cli; ?>";
		var sFilePath = "";
	/*]]*/
	</script>
    <script type="text/javascript" src="../ajax.js"></script>
	<script type="text/javascript" src="../createMenu.js"></script>
	<script type="text/javascript" src="odontoGrama.js"></script>
	<link href="odontoGrama.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="cfg" style="display: none"><?=$uid; ?></div>
<div id="UPD" style="display: none"><?=$UPD; ?></div>
<div id="pat" style="display: none"><?=$pat; ?></div>
<div id="rec" style="display: none"><?=$rec; ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">Asignar o Modificar Tratamiento del Paciente</td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
	<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<form name="f" onsubmit="return false;">
		<table id="sessTable" width="100%" class="header">
		<?php
			$query = "select p.pat_complete, s.ses_ini, e.emp_abbr, s.ses_end, c.cli_name, s.cli_id, p.agr_id,
			a.agl_id, a.agr_name, s.ses_number, e.emp_complete from {$DBName}.session as s
			left join {$DBName}.patient as p on p.pat_id = s.pat_id
			left join {$DBName}.employee as e on e.emp_id = s.emp_id
			left join {$DBName}.clinic as c on c.cli_id = s.cli_id
			left join {$DBName}.agreement as a on a.agr_id = p.agr_id where ";
			if($cli != 1) {
				$query .= "s.cli_id = ".$cli." and ";
			}
			$query .= "s.ses_id = {$UPD} and s.pat_id = '".utf8_decode($pat)."' group by s.cli_id, s.pat_id, s.ses_id";
			$i = 0;
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_row($result)) {
					$exit = ($row[3] == "00:00:00") ? "--:--" : date("H:i", strtotime($row[3]));
					$doctor = is_null($row[2]) ? "--" : strtoupper($row[2]);
					$agrid = is_null($row[6]) ? "0" : $row[6];
					$agrclass = (!is_null($row[6]) && $row[6] != "0" && $row[7] != "2")  ? " style=\"color: #00AA33;\"" : ((!is_null($row[7]) && $row[7] == "2") ? " style=\"color: #FF6600;\"" : "");
					$sesscli = is_null($row[5]) ? "0" : $row[5];
					$sessnum = is_null($row[9]) ? "0" : $row[9];
					$drname = is_null($row[10]) ? "" : utf8_encode($row[10]);
					$patnom = uppercase($row[0]);

					/** Obtiene el monto del recibo que ampara el pago de los tratamientos de esta sesion. */
					$recnum = "0";
					$amount = 0;
					$pm_early = false;
					$query5 = "select r.rec_number, r.rec_amount, r.rec_paymeth from ".$DBName.".receipt as r
					left join ".$DBName.".session as s on s.ses_number = r.ses_number
					and s.cli_id = r.cli_id and s.pat_id = r.pat_id and s.ses_date = r.rec_date
					where r.pat_id = '".utf8_decode($pat)."' and r.ses_number = ".$sessnum." and r.rec_status = 0
					and r.rec_date = '".date("Y-m-d")."'";
					if($result5 = @mysql_query($query5, $link)) {
						while($row5 = @mysql_fetch_row($result5)) {
							$recnum = is_null($row5[0]) ? "0" : $row5[0];
							$paymeth = is_null($row5[2]) ? "" : $row5[2];
							if($paymeth == "PA") $pm_early = true;
							$amount += (is_null($row5[1]) || $paymeth == "PA") ? 0 : intval($row5[1], 10);
						}
						@mysql_free_result($result5);
					}

					/** Obtiene el ultimo presupuesto del paciente de esta sesion. */
					$budid = "";
					$buddate = "--";
					$query2 = "select bud_id, bud_date from ".$DBName.".budget
					where pat_id = '".utf8_decode($pat)."' order by bud_date desc, bud_number desc limit 1";
					if($result2 = @mysql_query($query2, $link)) {
						$row2 = @mysql_fetch_row($result2);
						$budid = is_null($row2[0]) ? "" : $row2[0];
						$buddate = is_null($row2[1]) ? "--" : date("d/m/Y", strtotime($row2[1]));
						@mysql_free_result($result2);
					}

					/** Obtiene el numero de factura del paciente, si es que esta generada. */
					$invnum = "0";
					$query6 = "select i.inv_number from {$DBName}.invoice as i
					left join {$DBName}.invoicerec as ir on ir.inv_id = i.inv_id
					left join {$DBName}.receipt as r on r.cli_id = ir.rec_cli and
					r.rec_number = ir.rec_number and r.pat_id = i.pat_id
					where r.pat_id = '".utf8_decode($pat)."' and r.cli_id = {$sesscli} and
					r.rec_number = {$recnum} limit 1";
					if($result6 = @mysql_query($query6, $link)) {
						$invnum = @mysql_result($result6, 0);
						@mysql_free_result($result6);
					}
					$invnum = (is_null($invnum) || $invnum == "") ? "0" : $invnum;

					/** Obtiene el numero de tratamientos efectuados en esta sesion. */
					$rev = false;
					$treat = "--";
					$trtsum = 0;
					$trid = 0;
					$query3 = "select t.trs_id, t.trs_qty, t.trt_id, t.trs_sessnum, t.trs_sessfrom
					from {$DBName}.treatsession as t
					left join {$DBName}.session as s on s.ses_number = t.ses_number and s.cli_id = t.cli_id
					where s.ses_id = {$UPD}";
					if($result3 = @mysql_query($query3, $link)) {
						$trtnum = @mysql_num_rows($result3);
						while($row3 = @mysql_fetch_row($result3)) {
							$trtsum += intval($row3[1], 10);
							$trid = $row3[2];
							$rev = ($trtnum == "1") && ($trid == "3" || $trid == "122");
						}
						@mysql_free_result($result3);
						$treat = ($trtsum == "0") ? "--" : ($rev ? "Rev" : $trtsum);
						$treat = ((true && $trid == "122") ? "Rev/TA" : $treat);
					}

					/** Convierte el monto del recibo a formato de moneda sin signo $ o bien indica si el tx no tiene costo,
					*** o bien, indica que aun no se ha cobrado nada. */
					$pay = ($recnum == "0" && $amount == 0 && !$rev) ? "--" : (($amount == 0 && $rev) ? "SC" : number_format(floatval($amount), 0, ".", ","));
					$pay = ($pm_early && $amount > 0) ? ("PA/".$pay) : (($pm_early && $amount == 0) ? "PA" : $pay);

					/** Obtiene la fecha de la proxima cita de este paciente... */
					$nextvisit = "";
					$query4 = "select vst_date from ".$DBName.".visit where pat_id = '".utf8_decode($pat)."'
					and vst_date > '".date("Y-m-d")."' order by vst_date desc limit 1";
					if($result4 = @mysql_query($query4, $link)) {
						$nextvisit = @mysql_result($result4, 0);
						@mysql_free_result($result4);
					}
					$nvlink = (is_null($nextvisit) || $nextvisit == "") ? true : false;
					/** ...o bien, coloca el icono del calendario para indicar que no hay cita proxima. */
					$calimage = "<img src=\"../../images/calendar.gif\" width=\"16\" height=\"13\" border=\"0\" style=\"cursor: pointer; margin-top: 3px;\" />";
					$nextvisit = (is_null($nextvisit) || $nextvisit == "") ? $calimage : date("d/m/Y", strtotime($nextvisit));
		?>
		<tr class="report_item">
			<?php if($cli == 1) { ?>
			<td width="120" class="content" style="text-align: left;"><?=utf8_encode($row[4]); ?></td>
			<?php } ?>
			<td class="content" style="padding-left: 5px; text-align: left;"><a href="../../classes/content.php?url=getPatient&pat=<?=$pat; ?>&cli=<?=$sesscli; ?>&agr=<?=$agrid; ?>" title="<?=utf8_encode($row[8]); ?>" target="rightFrame"<?=$agrclass; ?>><?=$patnom; ?></a></td>
			<td width="60" class="content"><?=date("H:i", strtotime($row[1])); ?></td>
			<td width="60" class="content"><?php if($doctor == "--") { ?><a href="../../classes/content.php?url=changeDoctor&UPD=<?=$UPD; ?>&cli=<?=$sesscli; ?>" target="rightFrame"><?=$doctor; ?></a><?php } else { ?><label title="<?=$drname; ?>"><?=$doctor; ?></label><?php } ?></td>
			<td width="100" class="content"><a href="../../classes/content.php?url=mod_budget&UPD=<?=$UPD; ?>&pat=<?=$pat; ?>&cli=<?=$sesscli; ?>&bud=<?=$budid; ?>&agr=<?=$agrid; ?>&gto=<?=$gto; ?>" target="rightFrame"><?=$buddate; ?></a></td>
			<td width="60" class="content"><?php if($exit == "--:--") { ?><a href="javascript:void(0);" onclick="exitSession('<?=$cli; ?>', '<?=$UPD; ?>');"><?=$exit; ?></a><?php } else { ?><?=$exit; ?><?php } ?></td>
			<td width="60" class="content" id="treatSessionField"><?=$treat; ?></td>
			<td width="80" class="content" id="getPaymentField"><a onclick="getDoctor('<?=$UPD;?>', '../../classes/content.php?url=getPayment&UPD=<?=$UPD; ?>&cli=<?=$sesscli; ?>&pat=<?=$pat; ?>&rec=<?=$recnum; ?>&inv=<?=$invnum; ?>&bud=<?=$budid; ?>&gto=<?=$gto ?>&agr=<?=$agrid; ?>');" href="javascript:void(0);" target="rightFrame"><?=$pay; ?></a></td>
			<td width="100" class="content"><?php if($nvlink) { ?><a href="../../classes/schedule.php?cli=<?=$sesscli; ?>&pat=<?=$pat; ?>" target="rightFrame"><?php } ?><?=$nextvisit; ?><?php if($nvlink) { ?></a><?php } ?></td>
		</tr>
		<?php
					$i++;
				} // !while
			}
		?>
		</table>
        <table cellspacing="0" cellpadding="0" border="0" style="margin-top: 3px;">
		<tr>
			<td rowspan="4" style="padding-left: 5px;" valign="top">
			<div class="cat_list">Categor&iacute;as</div>
			<ul class="cat_list">
			<?php
				$lastspc = "2";
				$query = "(select tc.tcy_number, tc.tcy_name, tc.tcy_color, tc.spc_id
				from {$DBName}.treatcategory as tc where tc.tcy_id in (select t.tcy_id
				from (select tcy_id, tcy_number, tcy_date from {$DBName}.treatcategory
				order by tcy_date desc) as t group by t.tcy_number) and tc.spc_id = 2
				group by tc.tcy_number order by tc.tcy_name) union (select tc.tcy_number,
				tc.tcy_name, tc.tcy_color, tc.spc_id
				from {$DBName}.treatcategory as tc where tc.tcy_id in (select t.tcy_id
				from (select tcy_id, tcy_number, tcy_date from {$DBName}.treatcategory
				order by tcy_date desc) as t group by t.tcy_number) and tc.spc_id > 2
				group by tc.tcy_number order by tc.spc_id, tc.tcy_name)";
				if($result = @mysql_query($query, $link)) {
					while($row = @mysql_fetch_row($result)) {
						list($tcy_number, $tcy_name, $tcy_color, $spc) = $row;
						$tcy_name = ucfirst(lowercase($tcy_name));
						$onclick = "getCategoryScheme(this, {$tcy_number}, '{$tcy_color}');";
						if($spc != "2" && $lastspc == "2") {
							$border = "margin-top: 3px; border-top: 1px solid #084C9D;";
							$lastspc = "0";
						}
						else {
							$border = "";
						}
			?>
				<li id="tcy<?=$tcy_number; ?>" class="cat_list" onclick="<?=$onclick; ?>" style="<?=$border; ?>">
					<div class="cat_list_icon" style="background-color: <?=$tcy_color; ?>"><img src="../../images/spacer.gif" width="16" height="16" /></div>
					<div class="cat_list_text"><?=$tcy_name; ?></div>
				</li>
			<?php
					}
					@mysql_free_result($result);
				}
			?>
			</ul>
			</td>
			<td colspan="2" height="20"><div id="tx_comb" class="tx_comb">----</div></td>
		</tr>
		<tr>
			<td rowspan="3" height="300" valign="top">
				<div id="dentalChartSelector">
					<div id="selBudget" onclick="getCategoryScheme(this, 91);">Presupuesto</div>
					<div id="selDentalChart" onclick="getCategoryScheme(this, 90, '#123456');">Actual</div>
					<div id="selHistoricTx" onclick="getCategoryScheme(this, 92, '#123456');">Hist&oacute;rico</div>
				</div>
				<div id="dentalChartPanel" style="display: none;">
					<div id="adlclass" onclick="getTheet('ADL');">Adulto</div>
					<div id="infclass" onclick="getTheet('INF');">Infantil</div>
					<div id="tmpclass">&nbsp;</div>
					<div id="posrh">DERECHA</div>
					<div id="poslf">IZQUIERDA</div>
					<div id="dChartCanvas">
					    <div id="C1"></div>
					    <div id="C2"></div>
					    <div id="C4"></div>
					    <div id="C3"></div>
					</div>
					<div id="dcAvalTx" class="catTx">
						<div id="dcAvalTxTitle">Tratamientos disponibles</div>
					</div>
				</div>
				<div id="txListPanel" style="display: none;">
					<div id="catTx" class="catTx">
						<div id="catTxTitle">Tratamientos disponibles</div>
					</div>
					<div id="budgetList" style="display: none;">No hay tratamientos presupuestados.</div>
				</div>
				<div id="dentalSlice" style="display: none;">
					<div id="posrhSlice">DERECHA</div>
					<div id="poslfSlice">IZQUIERDA</div>
					<div id="dChartCanvasSlice">
					    <div id="C1Slice"></div>
					    <div id="C2Slice"></div>
					    <div id="C4Slice"></div>
					    <div id="C3Slice"></div>
					</div>
					<div id="dcSelTx" class="catTx">
						<div id="dcSelTxTitle">Tratamiento seleccionado</div>
					</div>
				</div>
			</td>
			<td valign="top" height="150">
				<div id="actTxTitle">Tratamientos actuales</div>
				<div id="actTx">
					<div id="actTxHeader">
						<table>
						<tr>
							<td width="115">Tratamiento</td>
							<td width="30" title="&Oacute;rgano dentario">OD</td>
							<td width="30" title="Sesi&oacute;n">Ses</td>
						</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td height="20">
				<div id="txControl">
					<div id="txToUp" onclick="moveTxToActual();" title="Enviar a Tratamientos Actuales"></div>
					<div id="txToDown" onclick="moveTxToProgram();" title="Enviar a Tratamientos Programados"></div>
					<div id="txDelete" onclick="deleteSelectedTx();" title="Quitar de la lista el Tratamiento seleccionado"></div>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top">
			<div id="prgTxTitle">Tratamientos programados</div>
			<div id="prgTx">
				<div id="prgTxHeader">
					<table>
					<tr>
						<td width="115">Tratamiento</td>
						<td width="30" title="&Oacute;rgano dentario">OD</td>
						<td width="30" title="Sesi&oacute;n">Ses</td>
					</tr>
					</table>
				</div>
			</div>
			</td>
		</tr>
        </table>
		</form>
	</div>
	</td>
</tr>
<tr>
	<td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/outf4.gif" width="42" height="42" /></td>
	<td class="wtbottom">&nbsp;</td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/outf3.gif" width="42" height="42" /></td>
</tr>
</table>
<script type="text/javascript">
/* [CDATA[ */
	if(document.body.__defineGetter__) {
		if(HTMLElement) {
			var element = HTMLElement.prototype;
			if(element.__defineGetter__) {
				element.__defineGetter__("outerHTML",
					function() {
						var parent = this.parentNode;
						var el = document.createElement(parent.tagName);
						el.appendChild(this);
						var shtml = el.innerHTML;
						parent.appendChild(this);
						return shtml;
					}
				);
			}
		}
	}

	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8) {
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) + "px";
	}
	uid = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
	UPD = eval("document.getElementById('UPD')." + (ff ? "textContent" : "innerText"));
	pat = eval("document.getElementById('pat')." + (ff ? "textContent" : "innerText"));
	rec = eval("document.getElementById('rec')." + (ff ? "textContent" : "innerText"));
	var agrId = '<?=$agrid; ?>';
	var budId = '<?=$budid; ?>';
	deleteMenu();
	getCategoryScheme(null, 91);
	var treatSessionField = document.getElementById("treatSessionField");
	if(typeof(treatSessionField) != 'undefined' && treatSessionField != null) {
		iCntTreats = parseInt(treatSessionField.innerHTML);
		iCntTreats = isNaN(iCntTreats) ? 0 : iCntTreats;
	}
	loadActTxObj();
	loadPrgTxObj();
/* ]] */
</script>

</body>
</html>