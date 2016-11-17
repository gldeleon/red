<?php
	if(!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
		exit();
	session_name("pra8atuw");
	session_start();
	if(count($_SESSION) > 0)
		extract($_SESSION);
	else {
		$_SESSION = array();
		session_destroy();
		header("Location: logout.php");
	}

	/** Llama al archivo de configuracion. */
	include "../config.inc.php";
	include "../functions.inc.php";

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
	$UPD = (isset($_GET["UPD"]) && !empty($_GET["UPD"])) ? $_GET["UPD"] : "";

	/** Obtiene un objeto de conexion con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$clinom = "";
	$query = "select cli_name from {$DBName}.clinic where cli_id = {$cli}";
	if($result = @mysql_query($query, $link)) {
		$clinom = @mysql_result($result, 0);
		$clinom = utf8_encode($clinom);
	}
	if($clinom == "") {
		$clinom = "Sin cl&iacute;nica asignada";
	}
	if($UPD != "") {
		if(isset($_GET["end"])) {
			$query = "update {$DBName}.session set ses_status = 6
			where ses_id = {$UPD} and cli_id = {$cli}";
			@mysql_query($query, $link);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
	<link href="../red.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript">
	<!--[CDATA[
		var cli = "<?=$cli; ?>";
	//]]-->
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/createMenu.js"></script>
	<script type="text/javascript" src="../modules/sessions.js"></script>
	<script type="text/javascript" src="../modules/jquery/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="../modules/jquery/jquery-ui-1.8.11.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../modules/jquery/themes/ui-lightness/jquery.ui.all.css" />
	<script type="text/javascript">
		$(function() {
			function log( message ) {
				$( "#patid" ).val( message );
			}
			$( "#patient" ).autocomplete({
				source: "../classes/patSearch.php",
				minLength: 2,
				select: function( event, ui ) {
					log( ui.item ? ui.item.id : "" );
				}
			});
		});
	</script>
	<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}
	</style>
</head>
<body>

<form name="f">
<input type="hidden" name="patid" id="patid" value="" />
<div id="cfg" style="display: none"><?=$uid; ?></div>
<div id="sessionPopupBoxContainer">
	<div id="sessionPopupBox" style="display: none;">
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
	<tr>
		<td colspan="3"><input id="patient" name="patient" type="text" value="" style="font-size: 12px; width: 315px" /></td>
	</tr>
	<tr>
		<td><input name="new" type="button" value="Nuevo paciente" class="large" onclick="showNewPatientDialog(event, 'patient', 'patid')" /></td>
		<td><input name="sess" type="button" value="Sesi&oacute;n" onclick="startNewSession('patid', 'patient', '<?=$e; ?>');" /></td>
		<td><input name="csess" type="button" onclick="hideSessionPopupBox(); return false;" value="Cancelar" /></td>
	</tr>
	</table>
	</div>
</div>

<table id="pTable" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100" style="white-space: nowrap;">Sesiones Activas del <?=date("d/m/Y"); ?> (<?=$clinom; ?>)</td>
		<td width="30" align="right"><a href="javascript:void(0);" onclick="reloadSessions('<?=$cli; ?>');" title="Actualizar"><img src="../images/reload.png" width="20" height="20" border="0" style="cursor: pointer" /></a></td>
		<td align="right"><input type="button" class="large" value="Nueva sesi&oacute;n" onclick="showSessionPopupBox();" /></td>
	</tr>
	</table>
	</td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m" style="border-right: 1px solid #E6701D; border-left: 1px solid #E6701D;">
	<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<div id="sessHeader" style="position: fixed; left: 1px; width: 100%; z-index: 0;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr style="height: 25px;">
			<?php
				if($cli == 1) {
			?>
			<td width="120" class="list_header">Cl&iacute;nica</td>
			<?php
				}
			?>
			<td class="list_header">Paciente</td>
			<td width="60" class="list_header">Entrada</td>
			<td width="60" class="list_header">Doctor</td>
			<td width="100" class="list_header">Presupuesto</td>
			<td width="60" class="list_header">Salida</td>
			<td width="60" class="list_header">Tx</td>
			<td width="80" class="list_header">Cobro</td>
			<td width="100" class="list_header">Cita</td>
			<td width="50" class="list_header">Cierre</td>
		</tr>
		</table>
		</div>

		<table id="sessTable" border="0" cellspacing="0" cellpadding="0" style="border-right: 1px solid #E6701D">
		<tr style="height: 25px;">
			<td colspan="10">&nbsp;</td>
		</tr>
		<?php
			$query = "select p.pat_complete, s.ses_ini, e.emp_abbr, null, null,
			s.ses_end, null, null, null, p.pat_id, s.ses_id, c.cli_shortname, null,
			s.cli_id, p.agr_id, a.agl_id, a.agr_name, s.ses_number, e.emp_complete,
			s.ses_status
			from {$DBName}.session as s
			left join {$DBName}.patient as p on p.pat_id = s.pat_id
			left join {$DBName}.employee as e on e.emp_id = s.emp_id
			left join {$DBName}.clinic as c on c.cli_id = s.cli_id
			left join {$DBName}.agreement as a on a.agr_id = p.agr_id where ";
			if($cli != 1) {
				$query .= "s.cli_id = {$cli} and ";
			}
			$query .= "s.ses_date = '".date("Y-m-d")."'
			group by s.cli_id, s.pat_id, s.ses_id order by s.ses_date, s.ses_ini desc";
			$i = 0;
			$bgcolor = "#FFD773";
			if($result = @mysql_query($query, $link)) {
				while($row = @mysql_fetch_array($result, MYSQL_BOTH)) {
					$bgcolor = ($bgcolor == "#FFF") ? "#FFD773" : "#FFF";
					$sessid = is_null($row[10]) ? "0" : $row[10];
					$exit = ($row[5] == "00:00:00") ? "--:--" : date("H:i", strtotime($row[5]));
					$doctor = is_null($row[2]) ? "--" : strtoupper($row[2]);
					$agrid = is_null($row[14]) ? "0" : $row[14];
					$patid = utf8_encode($row[9]);
					$agrclass = (!is_null($row[14]) && $row[14] != "0" && $row[15] != "2")  ? " style=\"color: #00AA33;\"" : ((!is_null($row[15]) && $row[15] == "2") ? " style=\"color: #FF6600;\"" : "");
					$sesscli = is_null($row[13]) ? "0" : $row[13];
					$sessnum = is_null($row[17]) ? "0" : $row[17];
					$drname = is_null($row[18]) ? "" : utf8_encode($row[18]);
					$sestat = is_null($row[19]) ? "0" : $row[19];
					$agrclass = ($sestat == "0") ? $agrclass : " style=\"color: #808080\"";
					$fcolor = ($sestat == "6") ? "#999" : "#084C9D";
					$patnom = uppercase($row[0]);

					/** Obtiene el monto del recibo que ampara el pago de los tratamientos de esta sesion. */
					/** En el caso de este query, dejar el $row[9] que corresponde al PAT_ID, requiere no estar en utf8. */
					$recnum = "0";
					$amount = 0;
                    $amount2 = 0;
                    $payment = 0;
					$pm_early = $pm_pstvb = false;
					$query5 = "select r.rec_number, r.rec_amount, r.rec_paymeth, r.rec_payment from ".$DBName.".receipt as r
					left join ".$DBName.".session as s on s.ses_number = r.ses_number
					and s.cli_id = r.cli_id and s.pat_id = r.pat_id and s.ses_date = r.rec_date
					where r.pat_id = '".$row[9]."' and r.ses_number = ".$sessnum." and r.rec_status = 0
					and r.rec_date = '".date("Y-m-d")."' and rec_paymeth != 'PD'";
					if($result5 = @mysql_query($query5, $link)) {
						while($row5 = @mysql_fetch_row($result5)) {
							$recnum = is_null($row5[0]) ? "0" : $row5[0];
							$paymeth = is_null($row5[2]) ? "" : $row5[2];
                            $payment = is_null($row5[3]) ? "" : $row5[3];
							if($paymeth == "PA") $pm_early = true;
							$amount += (is_null($row5[1]) || $paymeth == "PA") ? 0 : intval($row5[1], 10);
                            $amount2 += (is_null($row5[1])) ? 0 : intval($row5[1], 10);
						}
						@mysql_free_result($result5);
					}

					/** Obtiene el ultimo presupuesto del paciente de esta sesion. */
					$budid = "";
					$buddate = "--";
					$query2 = "select bud_id, bud_date, ttd_gto from ".$DBName.".budget
					where pat_id = '".$row[9]."' order by bud_date desc, bud_number desc limit 1";
					if($result2 = @mysql_query($query2, $link)) {
						$row2 = @mysql_fetch_row($result2);
						$budid = is_null($row2[0]) ? "" : $row2[0];
						$buddate = is_null($row2[1]) ? "--" : date("d/m/Y", strtotime($row2[1]));
                        $ttd_gto = is_null($row2[2]) ? "" : $row2[2];
						@mysql_free_result($result2);
					}

					/** Obtiene el numero de factura del paciente, si es que esta generada. */
					$invnum = "0";
					$query6 = "select i.inv_number from {$DBName}.invoice as i
					left join {$DBName}.invoicerec as ir on ir.inv_id = i.inv_id
					left join {$DBName}.receipt as r on r.cli_id = ir.rec_cli and
					r.rec_number = ir.rec_number and r.pat_id = i.pat_id
					where r.pat_id = '{$row[9]}' and r.cli_id = {$sesscli} and
					r.rec_number = {$recnum} and ir.inr_status = 0 limit 1";
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
					where s.ses_id = {$sessid}";
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

					$adeuda = "";
					if($cli == "1") {
						$adeuda = $amount2 - $payment;
                    	$adeuda = ($adeuda < 0 && $recnum != "0") ? " (<span style='color: #FF0000; cursor: pointer;'>".abs($adeuda)."</span>)" : "";
					}

					/** Obtiene la fecha de la proxima cita de este paciente... */
					$nextvisit = "";
					$query4 = "select vst_date from {$DBName}.visit
					where pat_id = '{$patid}' and vst_date > curdate()
					order by vst_date desc limit 1";
					if($result4 = @mysql_query($query4, $link)) {
						$nextvisit = @mysql_result($result4, 0);
						@mysql_free_result($result4);
					}
					$nvlink = (is_null($nextvisit) || $nextvisit == "") ? true : false;
					/** ...o bien, coloca el icono del calendario para indicar que no hay cita proxima. */
					$calimage = "<img src=\"../images/calendar.png\" width=\"16\" height=\"13\" border=\"0\" style=\"cursor: pointer\" />";
					$nextvisit = (is_null($nextvisit) || $nextvisit == "") ? $calimage : date("d/m/Y", strtotime($nextvisit));

					/** Color del texto de las sesiones. Si estan finalizadas, las pone en gris. */
					$list_class = ($sestat == "0") ? "list_item" : "sessionf";

					$budlink = ($sestat == "0") ? "mod_budget.php?UPD={$sessid}&pat={$patid}&cli={$sesscli}&bud={$budid}&agr={$agrid}&gto={$ttd_gto}" : "javascript:void(0);";
					$budstyle = ($sestat == "0") ? "" : " style=\"cursor: default; \"";

					$trtlink = ($sestat == "0") ? "mod_dchart.php?pat={$patid}&UPD={$sessid}&cli={$sesscli}&rec={$recnum}&agr={$agrid}&gto={$ttd_gto}" : "javascript:void(0);";
					$trtstyle = ($sestat == "0") ? "" : " style=\"cursor: default; \"";

					$payurl = "getPayment.php?UPD={$sessid}&cli={$sesscli}&pat={$patid}&rec={$recnum}&inv={$invnum}&bud={$budid}&agr={$agrid}&gto={$ttd_gto}";
					$paylink = ($sestat == "0") ? "getDoctor('{$sessid}', '{$payurl}');" : "";
					$paystyle = ($sestat == "0") ? "" : " style=\"cursor: default; \"";

					$sesendclick = ($sestat == "0") ? " onclick=\"verCobro('{$cli}', '{$sessid}');\"" : " style=\"cursor: default; \"";
					$sesend = ($sestat == "0") ? "Fin" : "--"
		?>
		<tr style="height: 20px; background-color: <?=$bgcolor; ?>;">
			<?php
				if($cli == 1) {
			?>
			<td width="120" class="<?=$list_class; ?>"><?=utf8_encode($row['cli_shortname']); ?></td>
			<?php
				}
			?>
			<td class="<?=$list_class; ?>" align="left" style="padding-left: 5px;"><a href="getPatient.php?pat=<?=$patid; ?>&cli=<?=$sesscli; ?>&agr=<?=$agrid; ?>" title="<?=utf8_encode($row[16]); ?>" target="mainFrame"<?=$agrclass; ?>><?=$patnom;?></a></td>
			<td width="60" class="<?=$list_class; ?>"><?=date("H:i", strtotime($row[1])); ?></td>
			<td width="60" class="<?=$list_class; ?>"><? if($doctor == "--" && $sestat == "0") { ?><a href="changeDoctor.php?UPD=<?=$sessid; ?>&cli=<?=$sesscli; ?>" target="mainFrame"><?=$doctor; ?></a><? } else { ?><label title="<?=$drname; ?>"><?=$doctor; ?></label><? } ?></td>
			<td width="100" class="<?=$list_class; ?>"><a href="<?=$budlink; ?>" target="mainFrame"<?=$budstyle; ?>><?=$buddate; ?></a></td>
			<td width="60" class="<?=$list_class; ?>"><? if($exit == "--:--" && $sestat == "0") { ?><a href="javascript:void(0);" onclick="exitSession('<?=$cli; ?>', '<?=$sessid; ?>');"><?=$exit; ?></a><? } else { ?><?=$exit; ?><? } ?></td>
			<td width="60" class="<?=$list_class; ?>"><a href="<?=$trtlink; ?>" target="rightFrame"<?=$trtstyle; ?>><?=$treat; ?></a></td>
			<td width="80" class="<?=$list_class; ?>"><a href="javascript:void(0);" onclick="<?=$paylink; ?>" target="mainFrame"<?=$paystyle; ?>><?=$pay; ?><?=$adeuda; ?></a></td>
			<td width="100" class="<?=$list_class; ?>"><? if($nvlink && ($sestat == "0")) { ?><a href="schedule.php?cli=<?=$sesscli; ?>&pat=<?=$patid; ?>" target="rightFrame"><? } ?><?=$nextvisit; ?><? if($nvlink) { ?></a><? } ?></td>
			<td width="50" class="<?=$list_class; ?>"><a href="javascript:void(0);"<?=$sesendclick; ?>><?=$sesend; ?></a></td>
		</tr>
		<?php
					$i++;

				} // !while
			}
			for($j = 0; $j < (4 - ($i - 1)); $j++) {
				$bgcolor = ($bgcolor == "#FFF") ? "#FFD773" : "#FFF";
		?>
		<tr style="height: 20px; background-color: <?=$bgcolor; ?>;">
			<?php if($cli == 1) { ?>
			<td width="120" class="list_item">&nbsp;</td>
			<?php } ?>
			<td class="list_item" align="left">&nbsp;</td>
			<td width="60" class="list_item">&nbsp;</td>
			<td width="60" class="list_item">&nbsp;</td>
			<td width="100" class="list_item">&nbsp;</td>
			<td width="60" class="list_item">&nbsp;</td>
			<td width="60" class="list_item">&nbsp;</td>
			<td width="80" class="list_item">&nbsp;</td>
			<td width="100" class="list_item">&nbsp;</td>
			<td width="50" class="list_item">&nbsp;</td>
		</tr>
		<?php
			}
		?>
		</table>
	</div>
	</td>
</tr>
<tr>
	<td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom">
	<?php
		$query = "select s.ses_number, s.pat_id, s.ses_status, s.cli_id
		from {$DBName}.session as s where s.ses_date = '".date("Y-m-d")."'";
		if($cli != "1") {
			$query .= " and s.cli_id = ".$cli;
		}
		$pat = "";
		if($result = @mysql_query($query, $link)) {
			$num = 0;
			$numact = 0;
			$patients = 0;
			$tratnum = 0;
			$rev = 0;
			$incomes = 0;
			while($row = @mysql_fetch_row($result)) {
				if($row[1] != $pat) {
					$patients++;
					$pat == $row[1];
				}
				$num++;
				$numact++;
				if($row[2] == "6") {
					$numact--;
				}

				$query2 = "select trt_id from {$DBName}.treatsession
				where ses_number = ".$row[0]." and cli_id = ".$row[3];
				if($result2 = @mysql_query($query2, $link)) {
					$t = 0;
					while($row2 = @mysql_fetch_row($result2)) {
						if($row2[0] == "3") {
							$rev++;
						} else {
							if($t == 0) {
								$tratnum++;
								$t++;
							}
						}
					}
					@mysql_free_result($result2);
				}

				/** La clave del paciente debe pasar tal cual, sin codificar a utf8. */
				$query3 = "select sum(r.rec_amount) from {$DBName}.receipt as r
				left join {$DBName}.session as s on s.ses_number = r.ses_number
				and s.cli_id = r.cli_id and s.pat_id = r.pat_id and s.ses_date = r.rec_date
				where s.pat_id = '".($row[1])."' and s.ses_number = ".$row[0]." and r.rec_status = 0
				and r.rec_paymeth != 'PA' and r.rec_paymeth != 'PD' and s.cli_id = ".$row[3];
				if($result3 = @mysql_query($query3, $link)) {
					$incomes += intval(@mysql_result($result3, 0), 10);
					@mysql_free_result($result3);
				}
			}
			@mysql_free_result($result);
		}
	?>
	Sesiones: <?=number_format($num, 0, ".", ","); ?> |
	Activas: <?=number_format($numact, 0, ".", ","); ?> |
	Pacientes Hoy: <?=number_format($patients, 0, ".", ","); ?> |
	Con Tx: <?=number_format($tratnum, 0, ".", ","); ?> |
	Revisiones: <?=number_format($rev, 0, ".", ","); ?> |
	Ingresos: <?=number_format($incomes, 0, ".", ","); ?>
	</td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>
</form>

</body>
</html>