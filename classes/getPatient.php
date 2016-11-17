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
	include "patient.class.php";

	/** Carga variables URL y determina sus valores iniciales. */
	$org = (isset($_GET["org"]) && !empty($_GET["org"])) ? $_GET["org"] : "1";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	$agrid = (isset($_GET["agr"]) && !empty($_GET["agr"])) ? $_GET["agr"] : "";

	/** Obtiene un objeto de conexión con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$patClass = new Patient(utf8_decode($pat));
	$patcomp = $patClass->getPatientCompleteName();
	$patcomp = utf8_encode($patcomp);

	/** Obtiene los permisos GLOBALES del usuario. */
	$admin = intval($p{2});
	$write = intval($p{1});
	$reead = intval($p{0});
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
	<link href="../red.css" rel="stylesheet" type="text/css" />
	<link href="../getPatient.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$cli; ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../modules/ajax.js"></script>
	<script type="text/javascript" src="../modules/createMenu.js"></script>
	<script type="text/javascript" src="../modules/getPatient.js"></script>
	<script type="text/javascript" src="../modules/newPatientDialog.js"></script>
</head>
<body>

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="cfg" style="display: none"><?=$uid; ?></div>
<? include "newPatient.inc.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
	    <td>Administrar Paciente (<?=$patcomp; ?>)</td>
	    <td width="180" align="left"><input type="button" class="large" value="Nuevo paciente" onclick="showNewPatientDialog();" /></td>
	    <td width="50" align="right" style="font-size: 12px; font-weight: bold; color: #811E53">Buscar:</td>
        <td width="150" align="right"><input name="q" type="text" value="" onclick="this.select()" onkeyup="searchPatient(this, event)" style="width: 140px;" /></td>
    </tr>
    </table>
    </td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
	<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<div style="position: fixed; left: 0px; width: 100%; z-index: 9000;">
			<table border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="btnHeader<?=(($org == "1") ? " btnHeaderOver" : ""); ?>"><a href="getPatient.php?org=1&pat=<?=$pat; ?>&cli=<?=$cli; ?>&agr=<?=$agrid; ?>" target="_self">Generales</a></td>
				<td class="btnHeader<?=(($org == "3") ? " btnHeaderOver" : ""); ?>"><a href="getPatient.php?org=3&pat=<?=$pat; ?>&cli=<?=$cli; ?>&agr=<?=$agrid; ?>" target="_self">Presupuestos</a></td>
				<td class="btnHeader<?=(($org == "5") ? " btnHeaderOver" : ""); ?>"><a href="getPatient.php?org=5&pat=<?=$pat; ?>&cli=<?=$cli; ?>&agr=<?=$agrid; ?>" target="_self">Documentos</a></td>
				<td class="btnHeader<?=(($org == "4") ? " btnHeaderOver" : ""); ?>"><a href="getPatient.php?org=4&pat=<?=$pat; ?>&cli=<?=$cli; ?>&agr=<?=$agrid; ?>" target="_self">Sesiones</a></td>
				<td class="btnHeader<?=(($org == "6") ? " btnHeaderOver" : ""); ?>"><a href="getPatient.php?org=6&pat=<?=$pat; ?>&cli=<?=$cli; ?>" target="_self">Historia Cl&iacute;nica</a></td>
			</tr>
			</table>
		</div>
		<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td><img src="../images/spacer.gif" width="1" height="40" /></td>
		</tr>
		<tr>
			<td align="center" valign="top">
		<?php
			$agr = "0";
			switch($org) {
				case "1":
					$query = "select pat_id, agr_id, pat_lastname, pat_surename, pat_name, pat_mail
					from {$DBName}.patient where pat_id = '".utf8_decode($pat)."' limit 1";
					if($result = @mysql_query($query, $link)) {
						$row = @mysql_fetch_row($result);
						$agr = $row[1];
		?>
			<table width="500" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="130" class="newEditItem">Clave de Paciente:</td>
				<td align="left"><input type="text" id="patid" name="patid" value="<?=utf8_encode($row[0]); ?>" readonly="readonly" style="background-color: #DDD" /></td>
			</tr>
			<tr>
				<td class="newEditItem">Apellido Paterno:</td>
				<td align="left"><input type="text" id="lastname" name="lastname" value="<?=utf8_encode($row[2]); ?>" style="text-transform: uppercase" /></td>
			</tr>
			<tr>
				<td class="newEditItem">Apellido Materno:</td>
				<td align="left"><input type="text" id="surename" name="surename" value="<?=utf8_encode($row[3]); ?>" style="text-transform: uppercase" /></td>
			</tr>
			<tr>
				<td class="newEditItem">Nombre:</td>
				<td align="left"><input type="text" id="name" name="name" value="<?=utf8_encode($row[4]); ?>" style="text-transform: uppercase" /></td>
			</tr>
			<tr>
				<td rowspan="2" class="newEditItem" valign="top" style="padding-top: 5px">Tel&eacute;fono(s):</td>
				<td>
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><input name="telnum" type="text" id="telnum" size="15" /></td>
					<td><select name="teltype" id="teltype" style="font-size: 10px; height: 18px; width: 55px; margin-left: 5px">
					<option value="0">Tipo --</option>
		<?php
						$query2 = "select tlt_name, tlt_abbr from {$DBName}.teltype order by tlt_id";
						if($result2 = @mysql_query($query2, $link)) {
							while($row2 = @mysql_fetch_row($result2)) {
								echo "<option value=\"".$row2[1]."\">".$row2[0]."</option>";
							}
							@mysql_free_result($result2);
						}
		?></select></td>
					<td><input type="button" value="Agregar" style="margin-left: 5px" onclick="addToList('telList', 'telnum', 'teltype')" title="Agregar" /></td>
					<td><input type="button" value="Quitar" style="margin-left: 5px" onclick="removeFromList('telList')" title="Quitar" /></td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top">
				<select name="telList" size="3" id="telList" >
		<?php
						$query2 = "select t.tel_number, t.tel_ext, tt.tlt_abbr from {$DBName}.telephone as t
						left join {$DBName}.teltype as tt on tt.tlt_id = t.tlt_id
						where t.pat_id = '".utf8_decode($pat)."' order by tt.tlt_abbr";
						if($result2 = @mysql_query($query2, $link)) {
							while($row2 = @mysql_fetch_row($result2)) {
								$ext = (is_null($row2[1]) || $row2[1] == "0") ? "" : "EXT: ".$row2[1]." ";
								echo "<option value=\"0\">".$row2[0]." ".$ext."- ".$row2[2]."</option>";
							}
							@mysql_free_result($result2);
						}
		?></select></td>
			</tr>
			<tr>
				<td class="newEditItem">Correo electr&oacute;nico:</td>
				<td align="left"><input id="email" name="email" type="text" value="<?=utf8_encode($row[5]); ?>" /></td>
			</tr>
		<?php
						$agrclass = "newEditItem";
						$agrdisabled = "";
						$agrstyle = "";
						$agrArray = array();
						$bExiste = false;
						$query3 = "select agr_id, agr_name from {$DBName}.agreement
						where agl_id = 2 and agr_active = 1 order by agr_name";
						if($result3 = @mysql_query($query3, $link)) {
							while($row3 = @mysql_fetch_row($result3)) {
								$agrArray[] = array($row3[0], $row3[1]);
								if(!$bExiste) $bExiste = ($agr == $row3[0]);
							}
							@mysql_free_result($result3);
						}
						if(!$bExiste && $agr != "0") {
							$agrclass = "newEditItemDisabled";
							$agrdisabled = " disabled = \"disabled\"";
							$agrstyle = " style=\"color: #999;\"";
						}
		?>
			<tr>
				<td bgcolor="#FFFFFF" class="<?=$agrclass; ?>">Convenio:</td>
				<td bgcolor="#FFFFFF" align="left">
				<input id="agrval" name="agrval" type="hidden" value="<?=$agr; ?>" />
				<select name="agreelist" id="agreelist"<?=$agrdisabled; ?><?=$agrstyle; ?>>
				<option value="0">----</option>
		<?php
						foreach($agrArray as $item => $row3) {
							$selected = ($row3[0] == $agr) ? " selected = \"selected\"" : "";
							echo "<option value=\"".$row3[0]."\"".$selected.">".utf8_encode($row3[1])."</option>\n";
						}
		?></select>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="30" align="right" valign="bottom">
					<input type="button" value="Cambiar" title="Cambiar" onclick="updatePatient('telList', '<?=$pat; ?>', '<?=$ref; ?>');" />
				</td>
			</tr>
			</table>
			<?php
						@mysql_free_result($result);
					}
					break;
				case "3":
					$query = "select b.bud_id, b.cli_id, b.bud_number, c.cli_name, b.bud_date from {$DBName}.budget as b
					left join clinic as c on b.cli_id = c.cli_id where pat_id = '".utf8_decode($pat)."' and b.cli_id > 0";
					if($result = @mysql_query($query, $link)) {
						if(@mysql_num_rows($result) > 0) {
							while($row = @mysql_fetch_row($result)) {
								$bud = $row[0];
								$budcli = $row[1];
								$budnum = $row[2];
								$clinom = uppercase($row[3]);
			?>
			<p class="labelitem">Presup. No. <?=$budnum; ?></p>
			<table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #811E53;">
			<tr>
				<td colspan="5" class="list_header" style="font-size: 10px; background-color: #D7E6F4; text-align: left; padding-left: 5px;"><?=$clinom." - ".date("d/m/Y", strtotime($row[4])); ?></td>
			</tr>
			<tr>
				<td width="30" class="list_header">Etp</td>
				<td width="30" class="list_header">Can</td>
				<td width="200" class="list_header">Trat</td>
				<td width="60" class="list_header">Precio</td>
				<td width="20" class="list_header">&nbsp;</td>
			</tr>
			<?php
								$query2 = "select b.btr_id, b.trt_id, t.trt_abbr, sum(b.bud_qty), b.trs_amount, b.btr_stage
								from ".$DBName.".budtreat as b
								left join ".$DBName.".treatment as t on t.trt_id = b.trt_id
								where b.bud_number = ".$budnum." and b.cli_id = ".$budcli."
								group by b.btr_stage, b.trt_id order by b.btr_stage, b.bud_qty desc, t.trt_abbr";
								if($result2 = @mysql_query($query2, $link)) {
									$numrows = @mysql_num_rows($result2);
									$i = 0;
									while($row2 = @mysql_fetch_row($result2)) {
										$stage = is_null($row2[5]) ? 0 : $row2[5];
										$trtid = $row2[0];
										$tqty = is_null($row2[3]) ? 0 : intval($row2[3]);
										$treat = is_null($row2[2]) ? "&nbsp;" : utf8_encode($row2[2]);
										$tamount = is_null($row2[4]) ? 0 : floatval($row2[4]);
										$tamount = $tamount * $tqty;
										$tamount = "$".number_format($tamount, 0, ".", ",");
			?>
			<tr>
				<td width="30" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$stage; ?></td>
				<td width="30" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$tqty; ?></td>
				<td width="140" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$treat; ?></td>
				<td width="60" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$tamount; ?></td>
			<?php
										if($i == 0) {
			?>
				<td width="20" rowspan="<?=$numrows; ?>" class="tx_list_item" style="vertical-align: top; padding-top: 1px">
				<a href="javascript:void(0);" title="Imprimir" onclick="openBudget('<?=$bud; ?>', '<?=$budcli; ?>', '<?=$pat; ?>')">
				<img src="../images/printicon.gif" alt="Imprimir" width="18" height="18" border="0" style="cursor: pointer" /></a></td>
			<?php
											$i++;
										} //if($i == 0)
			?>
			</tr>
			<?php
									} //while($row2 = @mysql_fetch_row($result2))
									@mysql_free_result($result2);
								} //if($result2 = @mysql_query($query2, $link))
			?>
			</table>
			<?php
							} //while($row = @mysql_fetch_row($result))
							@mysql_free_result($result);
						} //if(@mysql_num_rows($result) > 0)
						else {
							echo "No hay presuestos asignados todav&iacute;a";
						}
					} //if($result = @mysql_query($query, $link))
					break;
				case "5": //Documentos
					$query = "(select r.rec_number, r.rec_date, sum(r.rec_amount), null,
					r.ses_number, c.cli_name, c.cli_id, r.rec_status, r.rec_paymeth, r.rec_invoiced,
					r.rec_id, datediff(r.rec_date, curdate()) as diff
					from {$DBName}.receipt as r
					left join {$DBName}.clinic as c on c.cli_id = r.cli_id
					where r.pat_id = '".utf8_decode($pat)."' and r.rec_paymeth != 'MS' and r.rec_paymeth != 'PD'
					group by r.rec_number, r.cli_id, r.pat_id)
					union
					(select r.rec_number, r.rec_date, r.rec_amount, r.rec_payment,
					r.ses_number, c.cli_name, c.cli_id, r.rec_status, r.rec_paymeth, r.rec_invoiced,
					r.rec_id, datediff(r.rec_date, curdate()) as diff
					from {$DBName}.receipt as r
					left join {$DBName}.clinic as c on c.cli_id = r.cli_id
					where r.pat_id = '".utf8_decode($pat)."' and r.rec_paymeth = 'MS')
					order by rec_date asc, cli_name, rec_number asc";
					if($result = @mysql_query($query, $link)) {
			?>
					<p style="margin-bottom: 5px;">Recibos</p>
					<table border="1" cellspacing="0" cellpadding="0" style="border: 1px solid #811E53;">
					<tr>
						<td width="60" class="list_header">No.</td>
						<td width="60" class="list_header">Fecha</td>
						<td width="60" class="list_header">Importe</td>
						<td width="60" class="list_header">Total</td>
						<td width="60" class="list_header">Saldo</td>
						<td width="50" class="list_header">Sesi&oacute;n</td>
						<td width="180" class="list_header">Cl&iacute;nica</td>
						<td width="20" class="list_header">&nbsp;</td>
						<td width="20" class="list_header">&nbsp;</td>
						<?=($canCancelRec) ? "<td width=\"20\" class=\"list_header\">&nbsp;</td>" : ""; ?>
					</tr>
			<?php
						while($row = @mysql_fetch_array($result, MYSQL_BOTH)) {
							$recnum = $row[0];
							$recdate = is_null($row[1]) ? "--" : date("d/m/Y", strtotime($row[1]));
							$recamount = is_null($row[2]) ? "0" : number_format(floatval($row[2]), 0, ".", ",");
							$sessnum = is_null($row[4]) ? "&nbsp;" : intval($row[4], 10);
							$clinom = is_null($row[5]) ? "--" : uppercase($row[5]);
							$reccli = is_null($row[6]) ? "0" : intval($row[6], 10);
							$paymeth = $row[8];
							//$recyear = date("Y", strtotime($row[1]));
							//$billed = (is_null($row[9]) || $row[9] == "0") ? false : true;
							$cancelled = (bool)intval($row[7], 10);
							$cancelstr = ($cancelled) ? "C" : "--";
							$balancetr = ($paymeth == "MS" || $paymeth == "TR" || $paymeth == "RM" || $paymeth == "AP") ? $paymeth : "";
							$idstring = ($balancetr != "") ? $balancetr : (($cancelstr != "--") ? $cancelstr : "--");
							$recid = $row['rec_id'];
							//$diff = $row['diff'];
			
							//$invoiceable = (($diff > -30 && $diff <= 0) && $recyear == date("Y")) ? true : false;
			
							$patbal = $patClass->getPatientBalance($row[1]);
							$patbal = is_null($row[1]) ? 0 : $patbal;
							$balstyle = ($patbal < 0) ? "color: #F00;" : "";
			
							if($paymeth == "PA") {
								$recamount = "PA/$".$recamount;
							}
							else if($paymeth == "PD") {
								$recamount = "PD/$".$recamount;
							}
							else if($paymeth != "PA" && $paymeth != "PD") {
								$recamount="$".$recamount;
							}
			
							$queryPayment = "select rec_payment from {$DBName}.receipt
							where rec_number = '{$recnum}' and cli_id = {$reccli}";
							if($paymeth == "MS" || $paymeth == "AP") {
								$queryPayment .= " and rec_id = {$recid}";
							}
							if($resultPayment = @mysql_query($queryPayment, $link)) {
								while($row2 = @mysql_fetch_row($resultPayment)) {
									$payment = is_null($row2[0]) ? "0" : number_format(floatval($row2[0]), 0, ".", ",");
								}
								@mysql_free_result($resultPayment);
							}
			
							if($paymeth != "AP"){
					
			?>
					<tr>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?=$recnum; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?=$recdate; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?=$recamount; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?="$".$payment; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center; <?=$balstyle; ?>"><?="$".$patbal; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?=$sessnum; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?=$clinom; ?></td>
						<td class="tx_list_item" style="font-size: 11px; text-align: center;"><?=$idstring; ?></td>
			<?php
						$printicon = ($idstring != "MS" && $idstring != "AP") ? "<a href=\"javascript:void(0);\" title=\"Imprimir\" onclick=\"openReceipt('{$recnum}', '{$reccli}', '{$pat}');\"><img src=\"../images/printicon.gif\" alt=\"Imprimir\" width=\"18\" height=\"18\" border=\"0\" style=\"cursor: pointer\" /></a>" : "&nbsp;";
						$cR = ($recdate == date("d/m/Y") && $cancelstr != "C" ) ? "<a href=\"javascript:void(0);\" title=\"Cancelar\" onclick=\"cancelReceipt('{$reccli}', '{$pat}', '{$recnum}')\"><img src=\"../images/delticon.gif\" alt=\"Cancelar\" width=\"18\" height=\"18\" border=\"0\" style=\"cursor: pointer\" /></a>" : "<img src=\"../images/delticon_dis.gif\" alt=\"Cancelar\" width=\"18\" height=\"18\" border=\"0\" style=\"cursor: pointer\" />";
			?>
						<td class="tx_list_item"><?=$printicon; ?></td>
						<?=($canCancelRec) ? "<td class=\"tx_list_item\" style=\"text-align: center\">{$cR}</td>" : ""; ?>
					</tr>
							
			<?php
							}
						} // !while($row = @mysql_fetch_row($result))
					}
			?>
					</table>
			<?php
					break;
				case "4":
			?>
			<script type="text/javascript">
			/* [CDATA[ */
				var sFilePath = "../modules/mod_dchart/";
			/* ]] */
			</script>
			<script type="text/javascript" src="../modules/mod_dchart/odontoGrama.js"></script>

			<center>
				<div id="dentalChartPanel">
					<div id="adlclass" onclick="getTheet('ADL'); loadDentalChartTx(false);">Adulto</div>
					<div id="infclass" onclick="getTheet('INF'); loadDentalChartTx(false);">Infantil</div>
					<div id="tmpclass">&nbsp;</div>
					<div id="posrh">DERECHA</div>
					<div id="poslf">IZQUIERDA</div>
					<div id="dChartCanvas">
						<div id="C1"></div>
						<div id="C2"></div>
						<div id="C4"></div>
						<div id="C3"></div>
					</div>
				</div>
			</center>
			<div id="UPD" style="display: none;"></div>
			<div id="pat" style="display: none;"><?=$pat; ?></div>
			<div id="rec" style="display: none;"></div>
			<script type="text/javascript">
			/* [CDATA[ */
				getCategoryScheme(null, 92, '#123456');
				loadDentalChartTx(false);
			/* ]] */
			</script>
			<?php
					$query = "select s.ses_date, c.cli_name, e.emp_abbr, t.trt_name, ts.trs_sessnum,
					ts.trs_sessfrom, ts.trs_qty, c.cli_shortname, e.emp_complete, ts.rec_number,
					ts.tht_id, ts.trt_comb, t.trt_abbr, th.tht_vpos, th.tht_hpos, t.trt_color
					from {$DBName}.session as s
					left join {$DBName}.clinic as c on c.cli_id = s.cli_id
					left join {$DBName}.employee as e on e.emp_id = s.emp_id
					left join {$DBName}.treatsession as ts on ts.ses_number = s.ses_number and ts.cli_id = s.cli_id
					left join {$DBName}.treatment as t on t.trt_id = ts.trt_id
					left join {$DBName}.tooth as th on th.tht_cid = ts.tht_id
					where s.pat_id = '".utf8_decode($pat)."' group by s.ses_number, s.cli_id, ts.trs_id
					order by s.ses_date,  t.trt_name, trs_sessnum, ts.trs_sessfrom";
					if($result = @mysql_query($query, $link)) {
			?>
			<table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #811E53;">
			<tr>
				<td width="60" class="list_header">Fecha</td>
				<td width="80" class="list_header">Cl&iacute;nica</td>
				<td width="50" class="list_header">Doctor</td>
				<td width="20" class="list_header">&nbsp;</td>
				<td width="260" class="list_header">Tratamiento</td>
				<td width="50" class="list_header" title="Superficie">Sup</td>
				<td width="30" class="list_header" title="&Oacute;rgano dentario">OD</td>
				<td width="50" class="list_header">Sesi&oacute;n</td>
				<td width="40" class="list_header">Cant</td>
				<td width="50" class="list_header">Recibo</td>
			</tr>
			<?php
						$slastdate = "";
						$lastclinic = "";
						while($row = @mysql_fetch_row($result)) {
							$sdate = is_null($row[0]) ? "--" : date("d/m/Y", strtotime($row[0]));
							$clinic = is_null($row[1]) ? "" : uppercase($row[1]);
							$cliabbr = is_null($row[7]) ? "--" : uppercase($row[7]);
							$docabbr = (is_null($row[2]) || $row[2] == "ADM") ? "--" : $row[2];
							$doctor = is_null($row[8]) ? "" : uppercase(utf8_encode($row[8]));
							$tratnom = is_null($row[3]) ? "--" : utf8_encode($row[3]);
							$tratabbr = is_null($row[12]) ? "--" : utf8_encode($row[12]);
							$sessions = (is_null($row[4]) || is_null($row[5])) ? "1/1" : ($row[4]."/".$row[5]);
							$tqty = is_null($row[6]) ? "1" : intval($row[6], 10);
							$thtid = (is_null($row[10]) || $row[10] == "") ? "--" : intval($row[10], 10);
							$recnum = is_null($row[9]) ? "--" : floatval($row[9]);
							$thtfaces = (is_null($row[11]) || $row[11] == "") ? "--" : explode(",", $row[11]);
							$tfaces = "--";
							$tftitle = "";
							$tarray = strtolower($row[13])."_".strtolower($row[14]);
							$trtcolor = (is_null($row[15]) || $row[15] == "") ? "#FFF" : $row[15];
							if(is_array($thtfaces)) {
								$fstring = implode(",", $thtfaces);
								$sup_c1 = array("","V","M","P","D","O","","");
								$sup_c2 = array("","V","D","P","M","O","","");
								$inf_c3 = array("","L","D","V","M","O","","");
								$inf_c4 = array("","L","M","V","D","O","","");
								$sup_c1_title = array("","VESTIBULAR","MESIAL","PALATINO","DISTAL","OCLUSAL","","");
								$sup_c2_title = array("","VESTIBULAR","DISTAL","PALATINO","MESIAL","OCLUSAL","","");
								$inf_c3_title = array("","LINGUAL","DISTAL","VESTIBULAR","MESIAL","OCLUSAL","","");
								$inf_c4_title = array("","LINGUAL","MESIAL","VESTIBULAR","DISTAL","OCLUSAL","","");
								if(strlen($tarray) == 6) {
									$tarray_title = ${$tarray."_title"};
									$tarray = ${$tarray};
									$tfaces = "";
									$tftitle = "";
									foreach($thtfaces as $key => $face) {
										$tfaces .= $tarray[$face];
										$tftitle .= $tarray_title[$face]." ";
									}
									$tftitle = chop($tftitle);
								} //if(strlen($tarray) == 6)
								if($fstring == "6") {
									$tfaces = "RAIZ";
								}
								if($fstring == "7") {
									$tfaces = "--";
								}
							} //if(is_array($thtfaces))
			?>
			<tr>
				<td class="tx_list_item" style="font-size: 10px; text-align: center"><?=$sdate; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center" title="<?=$clinic; ?>"><?=$cliabbr; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center" title="<?=$doctor; ?>"><?=$docabbr; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center;"><div style="background-color: <?=$trtcolor; ?>; width: 16px; height: 14px; margin: 2px;"></div></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: left; padding-left: 3px; padding-right: 3px;"><?=$tratnom; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center" title="<?=$tftitle; ?>"><?=$tfaces; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center"><?=$thtid; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center"><?=$sessions; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center"><?=$tqty; ?></td>
				<td class="tx_list_item" style="font-size: 10px; text-align: center"><?=$recnum; ?></td>
			</tr>
			<?php
						} //while($row = @mysql_fetch_row($result))
			?>
			</table>
			<?php
					} //if($result = @mysql_query($query, $link))
					break;
				case "6":
					include '../modules/mod_pat_history/formhistory.php';
					break;
			} //switch($org)
			?>
			</td>
		</tr>
		</table>
		<p>&nbsp;</p>
	</div>
	</td>
</tr>
<tr>
	<td class="outf3y4" style="border-left: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	<td class="wtbottom">&nbsp;</td>
	<td class="outf3y4" style="border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" /></td>
</tr>
</table>

</body>
</html>