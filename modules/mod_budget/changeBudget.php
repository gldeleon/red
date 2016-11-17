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

	/** Llama al archivo de configuración. */
	include "../../config.inc.php";
	include "../../classes/patient.class.php";

	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	$esp = (isset($_GET["esp"]) && !empty($_GET["esp"])) ? $_GET["esp"] : "2";
	$bud = (isset($_GET["bud"]) && !empty($_GET["bud"])) ? $_GET["bud"] : "0";
	$agr_id = (isset($_GET["agr"]) && !empty($_GET["agr"])) ? $_GET["agr"] : "0";
	$stage = (isset($_GET["stage"]) && !empty($_GET["stage"])) ? $_GET["stage"] : "0";

	$patClass = new Patient(utf8_decode($pat));
	$patcomp = $patClass->getPatientCompleteName();
	$patcomp = utf8_encode($patcomp);
	$agrcolor = $patClass->getPatientAgrColor();
	$agrcolor = ($agrcolor == "#084C9D") ? "#999" : $agrcolor;

	/** Obtiene un objeto de conexion con la base de datos. */
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	/** Obtiene los permisos GLOBALES del usuario. */
	$admin = intval($p{2});
	$write = intval($p{1});
	$reead = intval($p{0});
 	$colspan = ($agr_id == 147 || $agr_id == 148 || $agr_id == 183) ? '3' : '2';

	/** Determina el tipo de navegador del usuario. */
	$browser = (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false) ? "IE" : ((strpos($_SERVER['HTTP_USER_AGENT'], "Chrome") !== false) ? "GG" : ((strpos($_SERVER['HTTP_USER_AGENT'], "Firefox") !== false) ? "FF" : "SF"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$AppTitle; ?></title>
	<link href="../../red.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript">
	/* [CDATA[ */
		var cli = "<?=$cli; ?>";
		var agr = "<?=$agr_id; ?>";
        var pat = "<?=$pat; ?>";
        var bud = "<?=$bud; ?>";
	/* ]] */
	</script>
	<script type="text/javascript" src="../ajax.js"></script>
	<script type="text/javascript" src="../createMenu.js"></script>
	<script type="text/javascript" src="changeBudget.js"></script>
	<script type="text/javascript" src="../newPatientDialog.js"></script>
</head>
<body style="background-color: #FFF">

<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="cfg" style="display: none"><?=$uid; ?></div>
<?php
	include "../../classes/newPatient.inc.php";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="outf1y2" style="border-left: 1px solid #E6701D;">&nbsp;</td>
	<td id="pTd">
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
	    <td>Asignar o Modificar Presupuesto (<?=$patcomp; ?>)</td>
        <td width="300" height="30">&nbsp;</td>
		<td width="100">&nbsp;</td>
    </tr>
    </table>
    </td>
	<td class="outf1y2" style="border-right: 1px solid #E6701D;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" id="m">
	<div style="width: 100%; height: 100%; overflow-y: scroll; overflow-x: hidden">
		<form name="f">
		<table width="100%" border="0" cellspacing="10" cellpadding="0">
		<tr>
			<td width="500" valign="top" height="56">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="150" class="labelitem">Presupuesto:</td>
				<td width="" style="padding-left: 5px; text-align: left; font-size: 12px; font-weight: bold; color: #E6701D">
				<?php
					$budnum = "0";
					$budcli = "0";
					if($bud != "0") {
						$query = "select bud_number, cli_id, bud_date from {$DBName}.budget where bud_id = {$bud}";
						if($result = @mysql_query($query, $link)) {
							$row = @mysql_fetch_row($result);
							$budnum = $row[0];
							$budcli = $row[1];
							$buddate = $row[2];
							@mysql_free_result($result);
						}
						echo $budnum;
					} else if($bud == "0") {
						$budcli = $cli;
						$budnum = 0;
						$query = "select max(bud_number) + 1 from {$DBName}.budget where cli_id = {$budcli}";
						if($result = @mysql_query($query, $link)) {
							$budnum = @mysql_result($result, 0);
							@mysql_free_result($result);
						}
						$budnum = (is_null($budnum) || intval($budnum, 10) == 0 || $budnum == "") ? 1 : intval($budnum, 10);
						echo "No est&aacute; asignado.";
					}

				?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><img src="../../images/spacer.gif" width="1" height="10" /></td>
			</tr>
			<tr>
				<td width="150" class="labelitem">Especialidad:</td>
				<td width="" style="padding-left: 5px; text-align: left;">
				<select id="speciality" name="speciality" onchange="getSpecialityTreats(this)">
				<?php
					$query = "select spc_id, spc_name from {$DBName}.speciality where spc_id > 1";
					if($result = @mysql_query($query, $link)) {
						while($row = @mysql_fetch_row($result)) {
							echo "<option value=\"".$row[0]."\">".strtoupper(utf8_encode($row[1]))."</option>";
						}
						@mysql_free_result($result);
					}
				?>
				</select></td>
			</tr>
			</table>
			</td>
			<td width="100%" rowspan="2" valign="top" align="left">
			<table width="250" border="0" cellspacing="0" cellpadding="0" style="margin-top: 2px;">
			<tr>
				<td colspan="2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="150" class="labelitem">Ver Etapa:</td>
					<td>
					<select id="stage" name="stage" style="width: 100px" onchange="changeStage(this, '<?=$pat; ?>', '<?=$bud; ?>');">
						<option value="0">Todas</option>
						<?php
							for($i = 1; $i < 6; $i++) {
								$selected = $stage == $i ? " selected=\"selected\"": "";
								echo "<option value=\"$i\"".$selected.">".$i."</option>";
							}
						?>
					</select>
					</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"><img src="../../images/spacer.gif" width="1" height="10" /></td>
			</tr>
			<tr>
				<?php
					$disabled = ($bud != 0 && $buddate != date("Y-m-d")) ? " class=\"disabled\" disabled=\"disabled\"" : "";
				?>
				<td width="70"><input type="button" id="add" value="Agregar" onclick="addTreatmentToList('<?=$pat; ?>', '<?=$cli; ?>', '<?=$bud; ?>', 'stage', <?=$agr_id; ?>);"<?=$disabled; ?> /></td>
				<td width="180" align="left">&nbsp;<input type="button" id="removeBudgetTxBtn" value="Quitar" onclick="removeTreatmentFromList('<?=utf8_encode($pat); ?>', '<?=$bud; ?>', 'budtx', <?=$agr_id; ?>)" class="disabled" disabled="disabled" /></td>
				</tr>
			<tr>
				<td colspan="2"><img src="../../images/spacer.gif" width="1" height="10" /></td>
			</tr>
			<tr>
				<td colspan="2">
				<table id="budgetList" width="" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #E6701D;">
				<tr>
					<td width="30" class="list_header">Etp</td>
					<td width="30" class="list_header">Can</td>
					<td width="140" class="list_header">Trat</td>
					<td width="60" class="list_header">Precio</td>
					<td width="20" class="list_header"><input id="budtx_all" name="budtx_all" type="checkbox" value="" title="Seleccionar todo" onclick="selectAllBudgetTreats(this, 'budtx');"<?=$disabled; ?> /></td>
				</tr>
				<?php
					$agl_id = "0";
					$query = "select agl_id from {$DBName}.agreement where agr_id = {$agr_id} limit 1";
					if($result = @mysql_query($query, $link)) {
						$agl_id = @mysql_result($result, 0);
						@mysql_free_result($result);
					}
					$agl_id = is_null($agl_id) ? "0" : $agl_id;

					if($bud != "0") {
						$cli_type = "1";
						$query = "select clt_id from {$DBName}.clinic where cli_id = {$cli}";
						if($result = @mysql_query($query, $link)) {
							$cli_type = @mysql_result($result, 0);
						}
						$cli_type = is_null($cli_type) ? "1" : $cli_type;

						$cli_class = "2";
						$query = "select clc_id from {$DBName}.clinic where cli_id = {$cli}";
						if($result = @mysql_query($query, $link)) {
							$cli_class = @mysql_result($result, 0);
						}
						$cli_class = is_null($cli_class) ? "2" : $cli_class;

						$numtreats = 0;
						$query = "select b.btr_id, b.trt_id, t.trt_abbr, b.bud_qty, b.trp_price, b.btr_stage,
						b.agt_discount, b.trs_amount
						from {$DBName}.budtreat as b left join {$DBName}.treatment as t on t.trt_id = b.trt_id
						where b.bud_number = {$budnum} and b.cli_id = {$budcli}";
						if($stage != "0") {
							$query .= " and b.btr_stage = {$stage}";
						}
						$query .= " order by b.btr_stage, b.bud_qty desc, t.trt_abbr";
						if($result = @mysql_query($query, $link)) {
							while($row = @mysql_fetch_row($result)) {
								$stage = is_null($row[5]) ? 0 : $row[5];
								$brtid = $row[0];
								$tqty = is_null($row[3]) ? 0 : intval($row[3]);
								$treat = is_null($row[2]) ? "&nbsp;" : utf8_encode($row[2]);
								$price = is_null($row[4]) ? 0 : floatval($row[4]);
								$tprice = $price * $tqty;
								$bdesc = is_null($row[6]) ? 0 : intval($row[6]);
								$tamount = is_null($row[7]) ? 0 : floatval($row[7]);
								$tamount = "$".number_format($tamount, 0, ".", ",");
								$numtreats++;
				?>
				<tr>
					<td width="30" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$stage; ?></td>
					<td width="30" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$tqty; ?></td>
					<td width="140" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$treat; ?></td>
					<td width="60" class="tx_list_item" style="font-size: 10px; text-align: center"><?=$tamount; ?></td>
					<td width="20" class="tx_list_item" style="font-size: 10px; text-align: center"><input name="budtx" type="checkbox" value="<?=$brtid; ?>" onclick="selectThisBudgetTreat(this, 'budtx');"<?=$disabled; ?> /></td>
                                </tr>
				<?php
							}
							@mysql_free_result($result);
						}
					}
				?>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
				<?php if($bud != "0") { ?>
				<table border="0" cellpadding="0" cellspacing="5" width="100%">
				<tr>
					<?php
						$disabled = ($numtreats == 0) ? " class=\"disabled\" disabled=\"disabled\"" : "";
                    ?>
					<td align="center">
                        <input type="button" value="Imprimir" onclick="openBudget('<?=$bud; ?>', '<?=$budcli; ?>', '<?=utf8_encode($pat); ?>')"<?=$disabled; ?> />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input name="" type="button" value="Nuevo..." onclick="getNewBudget('<?=$pat; ?>')" /></td>
				</tr>
				</table>
				<?php } else { ?>&nbsp;<?php } ?>
				</td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td width="500" valign="top">
			<?php
				$spcquery = "select spc_id from {$DBName}.speciality where spc_id > 1";
				if($spcres = @mysql_query($spcquery, $link)) {
					while($spc = @mysql_fetch_row($spcres)) {
			?>
			<div id="spcDiv<?=$spc[0]; ?>" style="display: none">
			<?php
						if($spc[0] != "11") {
							$query = "select trt_id, trt_abbr, trt_sess from ".$DBName.".treatment
							where spc_id = ".$spc[0]." and trt_active = 1 order by trt_abbr";
							if($result = @mysql_query($query, $link)) {
								$numrows = @mysql_num_rows($result);
								if($numrows > 0) { //67 //5 //12 //14
			?>
			<table width="500" border="0" cellspacing="1" cellpadding="0">
			<tr>
			<?php
				$col = (($numrows / 10) > 3) ? 3 : ($numrows / 10);
				$col = ($col > 1) ? 2 : $col;
				if($numrows > 20) {
					$div = intval($numrows / $col); //22 //4
					$num = intval($numrows / $div); //3 //1 //3
					$res = $numrows % $div; //1 //0
				}
				else {
					$col = ($numrows <= 10) ? 1 : $col;
					$div = intval($numrows / $col);
					$num = intval($numrows / $div);
					$res = 1;
				}
				$num = $num + (($res > 0) ? 1 : 0);
				//echo "{$col}-{$div}-{$num}-{$res}";
				$width = ($col > 1) ? "100%" : "250";
				$i = 1;
				$j = 1;
				$bgcolor = "#FFF";
				while($row = @mysql_fetch_row($result)) {
					$bgcolor = ($bgcolor == "#FFD773") ? "#FFF" : "#FFD773";
					if($j == 1) {
						$bgcolor = "#FFF";
				?>
						<td valign="top" align="center">
						<!-- TABLAS DE LISTA DE TRATAMIENTOS #################### -->
						<table width="<?=$width; ?>" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #E6701D">
						<tr>
							<td class="list_header">Trat</td>
							<td class="list_header">Can</td>
						</tr>
				<?php
					}
					echo "<tr bgcolor=\"".$bgcolor."\" style=\"height: 32px;\">\n";
					echo "\t<td class=\"tx_list_item\" style=\"padding-left: 3px\">".utf8_encode($row[1])."</td>\n";
					echo "\t<td class=\"tx_list_item\" style=\"text-align: center\" onclick=\"selectTextBox('".$row[0]."');\"><input id=\"".$row[0]."\" name=\"bdgtrt\" type=\"text\" size=\"2\" value=\"0\" onclick=\"this.select();\" /></td>\n";
					echo "</tr>\n";
					if(($i <= $num && $j == $div) || ($i == $num && $j == $res)) {
						echo "</table>\n";
						echo "</td>\n";
					}
					if($j == $div) {
						$j = 0;
						$i++;
					}
					$j++;
				}
			?>
			</tr>
			</table>
		<?php
							} //! if($numrows > 0)
							else if($numrows == 0) {
		?>
			<table width="500" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td valign="top" height="100">No se encontraron elementos</td>
			</tr>
			</table>
		<?php
							}
							@mysql_free_result($result);
						} //! if($result = @mysql_query($query, $link))
					} //! if($spc[0] != "11")
					else {
		?>
			<table width="500" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td class="list_header" style="color: #FFF; background-color: #084C9D">Etapa 1</td>
				<td class="list_header" style="color: #FFF; background-color: #084C9D">Etapa 2</td>
				<td class="list_header" style="color: #FFF; background-color: #084C9D">Etapa 3</td>
			</tr>
			<tr>
		<?php
						$num2 = 3;
						$query2 = "select max(trt_bstage) from {$DBName}.treatment
						where spc_id = 11 and trt_active = 1";
						if($result2 = @mysql_query($query2, $link)) {
							$num2 = @mysql_result($result2, 0);
							@mysql_free_result($result2);
						}
						$query2 = "select trt_id, trt_abbr, trt_sess, trt_bstage from {$DBName}.treatment
						where spc_id = 11 and trt_active = 1 order by trt_bstage, trt_abbr";
						if($result2 = @mysql_query($query2, $link)) {
							$j2 = 1;
							$i2 = 0;
							$k2 = 0;
							while($row2 = @mysql_fetch_row($result2)) {
								$bgcolor2 = is_int($i2 / 2) ? "#FFFFFF" : "#ABD9E9";
								if($row2[3] != $j2) {
									$j2 = $row2[3];
									echo "</table></td>";
									$k2 = 0;
								}
								if($k2 == 0) {
									echo "\n";
								?>
				<td valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #E6701D">
				<tr>
					<td class="list_header">Trat</td>
					<td class="list_header">Can</td>
				</tr>
				<?php
									$k2 = 1;
								}
								echo "<tr bgcolor=\"".$bgcolor2."\" style=\"height: 27px;\">\n";
								echo "\t<td class=\"tx_list_item\" style=\"padding-left: 3px\">".utf8_encode($row2[1])."</td>\n";
								echo "\t<td class=\"tx_list_item\" style=\"text-align: center\" onclick=\"selectTextBox('".$row2[0]."');\"><input id=\"".$row2[0]."\" name=\"bdgtrt\" type=\"text\" size=\"2\" value=\"0\" onclick=\"this.select();\" /></td>\n";
								echo "</tr>\n";
							}
							echo "</table></td>";
							@mysql_free_result($result2);
						} //! if($result = @mysql_query($query2, $link)) {
		?>
			</tr>
			</table>
		<?php
					}
		?>
			</div>
		<?php
					} //! while($spc = @mysql_fetch_row($spcres))
		?>
			</td>

		</tr>
		</table>
		</form>
		<?php
					@mysql_free_result($spcres);
				} //! if($spcres = @mysql_query($spcquery, $link)) {
		?>
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