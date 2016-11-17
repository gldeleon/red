<script type="text/javascript" src="../modules/ajax.js"></script>
<script type="text/javascript" src="../modules/createMenu.js"></script>
<script type="text/javascript" src="../modules/changeBudget.js"></script>
<script type="text/javascript" src="../modules/newPatientDialog.js"></script>
<script type="text/javascript" src="../modules/help.js"></script>
<style type="text/css">
	body{font-family: "DIN Light", Arial, Helvetica;}
</style>
<script type="text/javascript">
	function gencad() {
		var elms = document.getElementsByName('sck');
		for(i = 0; i < elms.length; i++) {
			if(elms[i].checked) {
				var hid = document.getElementById("hid_" + elms[i].value);
				params = hid.value;
				arr = params.split('-%%-');
				for(c = 0; c < arr.length; c++) {
					sRes = AjaxQuery("POST", "../classes/setBudget.php", false, arr[c]);
					//alert(sRes);
				}
			}
		}
		var parent = window.opener;
		parent.location.reload(true);
		window.close();
	}
</script>
<?
	/** Llama al archivo de configuración. */
	include "../config.inc.php";
	include "../conn.php";
	$ibud = (isset($_GET["ibud"]) && !empty($_GET["ibud"])) ? $_GET["ibud"] : "0";
	$paks = (isset($_GET["paks"]) && !empty($_GET["paks"])) ? $_GET["paks"] : "0";
	$pat = (isset($_GET["pat"]) && !empty($_GET["pat"])) ? $_GET["pat"] : "";
	//echo $ibud;
	if($ibud == 0)
	{
		$fecha = time();
		$query = "select * from {$DBName}.budget where pat_id = '{$pat}' and 
		bud_date = '".date("Y", $fecha)."-".(date("m", $fecha))."-".date("d", $fecha)."' order by bud_number desc";
		//echo $query;
		$rs = @mysql_query($query, $conn) or die($query);
		$rw = @mysql_fetch_array($rs);
		$ibud = $rw['bud_id'];
	}
	
	//echo "---".$paks;
	//verificamos que la cadena de paquetes no llegue vacia
	if($paks != "") {
		$trtpack = "";
		$pack = split("-00-", $paks);//separamos los paquetes en un array
		/*Comenzamos a traer los tratamientos y cantidades presupuestados*/
		$query = "select a.bud_number, a.cli_id, b.clc_id, a.pat_id from {$DBName}.budget as a, {$DBName}.clinic as b 
		where a.cli_id = b.cli_id and a.bud_id = {$ibud}";
		//echo $query;
		$result = @mysql_query($query, $conn) or die($query);
		if(@mysql_num_rows($result) > 0) {
			$row = @mysql_fetch_array($result);
			$clascli = $row["clc_id"];
			$pat_id = $row["pat_id"];
			$cli_id = $row["cli_id"];
			$bud_number = $row["bud_number"];
			$query = "select agr_id from {$DBName}.patient where pat_id = '{$pat_id}'";
			//echo $query."<br/>";
			$agr = -1;
			$resultcn = @mysql_query($query, $conn);
			if(@mysql_num_rows($resultcn) > 0) {
				$agrow = @mysql_fetch_array($resultcn);
				$agr = $agrow[0];
			}
			/*Comenzamos a traer los tratamientos que el cliente eligio*/
			$query = "select a.btr_id, a.trt_id, a.bud_qty, a.trp_price as price_pack, b.trp_price as price_treat 
			from {$DBName}.budtreat as a, (select * from (select * from {$DBName}.treatprice where cli_class = {$clascli} 
			order by trt_id, trp_date desc) as a1 group by trt_id) as b where a.bun_id = 0 and a.bud_number = ".$row["bud_number"]." 
			and a.cli_id = ".$row['cli_id']." and a.trt_id = b.trt_id order by b.trp_price desc";
			//echo $query."<br/>";
			$result2 = @mysql_query($query, $conn) or die($query);
			$pack_ok = array(); //Este arreglo es para guardar los paquetes que concuerden
			$pack_okn = array();
			if(@mysql_num_rows($result2) > 0) {
				$cont = 0;
				$trt_pat = array();
				$trt_pok = array();
				$trt_pokn = array();
				$trt_price = array();
				$btr_idpat = array();
				//llenamos los arreglos de los tratamientos que ha seleccionado el paciente 
				while($row2 = @mysql_fetch_array($result2)) {
					for($i = 0; $i < $row2["bud_qty"]; $i++) {
						$trt_pat[$cont] = $row2['trt_id'];
						$trt_pok[$cont] = 0;
						$trt_pokn[$cont] = 0;
						$trt_price[$cont] = $row2['price_treat'];
						$btr_id[$cont] = $row2['btr_id'];
						$btr_idpat[$cont] = $row2['btr_id'];
						//echo "--".$trt_pat[$cont]."<br/>";
						$cont++;
					}
				}
			}
			/*Se terminan de traer los tratamientos que el paciente ha elegido*/
			/*Comenzamos a llenar los tratamientos por cada posible paquete*/
			for($cont = 0; $cont < count($pack); $cont++) {
				$query = "select a.trt_id, a.bnt_qty, a.bnt_discount, a.bnt_opc, a.bnt_fdesc, b.trt_name, c.trp_price as price 
				from (select * from {$DBName}.bundletreat where bun_id = {$pack[$cont]} order by bnt_date desc) as a, 
				{$DBName}.treatment as b, (select * from (select * from {$DBName}.treatprice where cli_class = {$clascli} 
				order by trt_id, trp_date desc) as a1 group by trt_id) as c where a.trt_id = b.trt_id and a.trt_id = c.trt_id 
				group by trt_id";
				//echo $query."<br/>";
				$respak = @mysql_query($query, $conn);
				if(@mysql_num_rows($respak) > 0) {
					$var = "pack_".$pack[$cont];
					$$var = array();
					$varu = "packunit_".$pack[$cont];
					$$varu = array();
					$varqty = "packqty_".$pack[$cont];
					$$varqty = array();
					$varprc = "packprc_".$pack[$cont];
					$$varprc = array();
					$vardsc = "packdsc_".$pack[$cont];
					$$vardsc = array();
					$varfdc = "packfdc_".$pack[$cont];
					$$varfdc = array();
					$vartrt = "packtrt_".$pack[$cont];
					$$vartrt = array();
					$var2 = "packobl_".$pack[$cont];
					$$var2 = array();
					$var3 = "packopc_".$pack[$cont];
					$$var3 = array();
					$pcont = 0;
					$varno = "unmobl_".$pack[$cont];
					$$varno = 0;
					$unit = 0;
					$varcont = "contrt_".$pack[$cont];
					$$varcont = 0;
					$query2 = "select max(bun_num) from {$DBName}.budtreat where cli_id = {$cli_id} and bud_number = {$bud_number} 
					and bun_id = {$pack[$cont]}";
					$rescont = @mysql_query($query2, $conn);
					$rowcont = @mysql_fetch_array($rescont);
					if($rowcont[0] != "") {
						$$varcont = $rowcont[0];
					}

					while($rowpk = @mysql_fetch_array($respak)) {
						${$varu}[$unit] = $rowpk["trt_id"];
						${$vartrt}[$unit] = $rowpk["trt_name"];
						${$varqty}[$unit] = $rowpk["bnt_qty"];
						${$vardsc}[$unit] = $rowpk["bnt_discount"];
						${$varprc}[$unit] = $rowpk["price"];
						${$varfdc}[$unit] = $rowpk["bnt_fdesc"];
						for($i = 0; $i < $rowpk["bnt_qty"]; $i++) {
							${$var}[$pcont] = $rowpk["trt_id"];
							${$var2}[$pcont] = $rowpk["bnt_opc"];
							if($rowpk["bnt_opc"] == 0) {
								${$varno}++;
							}
							//echo $var."[".$pcont."]=".${$var}[$pcont]."<br/>";
							$pcont++;
						}
						$unit++;
					}
				}
			}
			
			/* Terminamos de llenar los arreglos de tratamientos por paquete*/
			/*Comienza la declaracion de variables de numero de tratamientos requeridos*/
			for($cont = 0; $cont < count($pack); $cont++) {
				$query = "select numtrt from {$DBName}.bundle where bun_id = {$pack[$cont]}";
				$resvar = @mysql_query($query,$conn);
				if(@mysql_num_rows($resvar) > 0) {
					while($rwnt = @mysql_fetch_array($resvar)) {
						$varnt = "numtrt_".$pack[$cont];
						$$varnt = $rwnt["numtrt"];//variable que guarda el numero de tratamientos necesarios
					}
				}
			}

			/*Termina declaracion de variables de numero de tratamientos requeridos*/
			/*Comienzan las comparaciones para determinar paquetes disponibles */
			for($cont = 0; $cont < count($pack); $cont++) {
				$trtend = 0; //variable que servira como bandera para determinar si ya no existen concidencias con este paquete
				$vuelta = ${"contrt_".$pack[$cont]} + 1; //variable paara decir que numero de vuelta va
				$completo = 0;
				while($trtend == 0) {
					//echo "entra a paquete".$pack[$cont]."<br/>";
					$tmpobl = 0;
					$tmpopc = 0;
					$completo = 0;
					for($ci = 0; $ci < count(${"pack_".$pack[$cont]}); $ci++) {
						for($ct = 0; $ct < count($trt_pat); $ct++) {
							//echo "*if(".$trt_pok[$ct]."==0)<br/>";
							if($trt_pok[$ct] == 0) {
								if(${"packfdc_".$pack[$cont]}[$ci] == 0) {
									$pricetot = ${"packprc_".$pack[$cont]}[$ci] - ${"packdsc_".$pack[$cont]}[$ci];
								}
								else {
									$pricetot = ${"packprc_".$pack[$cont]}[$ci] - (((${"packprc_".$pack[$cont]}[$ci]) * (${"packdsc_".$pack[$cont]}[$ci])) / 100);
								}
								//echo "**if(".${"packunit_".$pack[$cont]}[$ci]."==".$trt_pat[$ct].")---".${"packprc_".$pack[$cont]}[$ci]."---".${"packdsc_".$pack[$cont]}[$ci]."--".${"packfdc_".$pack[$cont]}[$ci]."-/-".$pricetot."<br/>";
								if(${"pack_".$pack[$cont]}[$ci] == $trt_pat[$ct]) {
									//echo "****if(".${"packobl_".$pack[$cont]}[$ci]."==0)<br/>";
									if(${"packobl_".$pack[$cont]}[$ci] == 0) {
										$tmpobl++;
									}
									else {
										$tmpopc++;
										$ci--;
									}
									$trt_price[$ct] = $pricetot;
									$trt_pok[$ct] = $pack[$cont];
									$trt_pokn[$ct] = $vuelta;
									//echo "if((".$tmpobl."==(".${"unmobl_".$pack[$cont]}."))and(".($tmpobl+$tmpopc)."==".(${"numtrt_".$pack[$cont]})."))<br/>";
									if(($tmpobl == (${"unmobl_".$pack[$cont]})) and (($tmpobl + $tmpopc) == (${"numtrt_".$pack[$cont]}))) {
										$completo = 1;
										$pack_ok[count($pack_ok)] = $trt_pok[$ct];
										break 2;
									}
									else {
										break;
									}
								}
							}
						}
					}
					if($completo == 1) {
						$trtend = 0;
					}
					else {
						$trtend = 1;
						for($ct = 0; $ct < count($trt_pat); $ct++) {
							if(($trt_pok[$ct] == $pack[$cont]) and ($trt_pokn[$ct] == $vuelta)) {
								$trt_pok[$ct] = 0;
							}
						}
					}
					$vuelta++;
				}
			}
			/*Terminan comparaciones para detertminar paquetes disponibles*/
		}
	}
	$pckact =- 1;
	$pckv =- 1;
	$packsok = array();
	$packsokv = array();
	for($i = 0; $i < count($trt_pat); $i++) {
		if(count($packsok) == 0) {
			if($trt_pok[$i] != 0) {
				$packsokv[count($packsok)] = $trt_pokn[$i];
				$packsok[count($packsok)] = $trt_pok[$i];
			}
		}
		else {
			if($trt_pok[$i] != 0) {
				$find = 0;
				for($ct = 0; $ct < count($packsok); $ct++) {
					if(($packsok[$ct] == $trt_pok[$i]) && ($packsokv[$ct] == $trt_pokn[$i])) {
						$find = 1;
					}
				}
				if($find == 0) {
					$packsokv[count($packsok)] = $trt_pokn[$i];
					$packsok[count($packsok)] = $trt_pok[$i];
				}
			}
		}
	}

	for($ci = 0; $ci < count($trt_pat); $ci++) {
		if($trt_pok[$ci] == 0) {
			if($agr != -1) {
				$query3 = "select at.agt_discount, at.agt_price from {$DBName}.agreetreat as at
				left join {$DBName}.patient as p on p.agr_id = at.agr_id 
				where p.pat_id = '{$pat_id}' and at.trt_id = {$trt_pat[$ci]}";
				$desc = @mysql_query($query3, $conn);
				if(@mysql_num_rows($desc) > 0)  {
					$rowdesc = @mysql_fetch_array($desc);
					if($rowdesc[1] != "") {
						$trt_price[$ci] = $trt_price[$ci] - ((($trt_price[$ci]) * ($rowdesc[0])) / 100);
					}
					else {
						$trt_price[$ci] = $trt_price[$ci] - $rowdesc[1];
					}
				}
			}
		}	
		$string[$ci] = "&string=".$pat_id."|".$cli_id."|".$bud_number."|1|".$ibud."|".$trt_pat[$ci]."=1=".$trt_price[$ci]."*|".$trt_pok[$ci]."|".$trt_pokn[$ci]."|".$btr_idpat[$ci];
		//echo $ci."---".$string[$ci]."<br/>";
	}
	/*if(count($packsok)==0)
	echo "<script>window.close();</script>";
	else*/
	for($i = 0; $i < count($packsok); $i++) {
		$packtmp = array();
		$packtmpct = array();
		$packsrt = array();
		for($ci = 0; $ci < count($trt_pat); $ci++) {
			if(($packsok[$i] == $trt_pok[$ci]) && ($packsokv[$i] == $trt_pokn[$ci])) {
				$packtmpct[count($packtmp)] = 1;
				$packsrt[count($packtmp)] = $string[$ci];
				$packtmp[count($packtmp)] = $trt_pat[$ci];
				//}
				//}
			}
		}
		$query = "select * from {$DBName}.bundle where bun_id = ".$packsok[$i];
		$respk = @mysql_query($query, $conn);
		$rwpk = @mysql_fetch_array($respk);
?>
<div style="text-transform: capitalize; margin: 5px; border: 1px solid #6CA6C8; width: 350px; padding: 7px;">
<div style="background-color: #6CA6C8; color: #FFF; padding: 3px; font-size: 12px; font-weight: bold;">
    <table cellspacing="0" cellpadding="0" border="0" style="font-size: 12px; font-weight: bold; color: #FFF; width: 340px;">
    <tr>
        <td><?=$rwpk['bun_name']; ?></td>
        <td align="right"><input type="checkbox" id="sck_<?=$i; ?>" value="<?=$i; ?>" name="sck" /></td>
    </tr>
    </table>
</div>
<table cellpadding="0" cellspacing="0" border="0" style="font-size:12px;">
<tr >
    <td width="20" style="border-bottom: 1px solid #6CA6C8;">Cant.</td>
    <td width="130" style="border-bottom: 1px solid #6CA6C8;">Tratamiento</td>
    <td width="90" style="border-bottom: 1px solid #6CA6C8;">Precio</td>
    <td width="90" style="border-bottom: 1px solid #6CA6C8;">P con Desc</td>
</tr>
<?
		$total = 0;
		$totaldesc = 0;
		$parameters = "";
		for($cont = 0; $cont < count($packtmp); $cont++) {
			$parameters .= $packsrt[$cont]."-%%-";
			$cad = "";
			$cad = $packsok[$i]."_%%_".$packsokv[$i]."||".$packtmp[$cont]."_%%_".$packtmpct[$cont];
?>
<tr>
	<td><?=$packtmpct[$cont]?></td>
<?
			$vartrt = "packtrt_".$packsok[$i];
			$varu = "packunit_".$packsok[$i];
			$vardsc = "packdsc_".$packsok[$i];
			$varprc = "packprc_".$packsok[$i];
			$varfdc = "packfdc_".$packsok[$i];
			for($z = 0; $z < count(${$varu}); $z++) {
				if(${$varu}[$z] == $packtmp[$cont]) {
?>
    <td><?=utf8_encode(${$vartrt}[$z]); ?></td>
    <td>$<? echo ($packtmpct[$cont] * (${$varprc}[$z])); $total += ($packtmpct[$cont] * (${$varprc}[$z])); ?></td>
    <td>$<?
					if(${$varfdc}[$z] == 0) {
						$desc = ($packtmpct[$cont] * (${$varprc}[$z])) - (${$vardsc}[$z]);
						$totaldesc += $desc;
						echo $desc;
					}
					else {
						$desc = ($packtmpct[$cont] * (${$varprc}[$z])) - ((($packtmpct[$cont] * (${$varprc}[$z])) * (${$vardsc}[$z])) / 100);
						$totaldesc += $desc;
						echo $desc;
					}
					$cad .= "_%%_".$desc;
?>	</td>
<?
					break;
				}
			}
?>
</tr>
<?
		}
		$parameters = substr($parameters, 0, -4);
?>
<tr>
    <td></td>
    <td style="color: #900;">Total:</td>
    <td>$<?=$total; ?></td>
    <td>$<?=$totaldesc; ?></td>
</tr>
</table>
<input type="hidden" id="hid_<?=$i; ?>" name="hid_<?=$i; ?>" value="<?=$parameters; ?>" />
</div>
<?
	}
?>
<div>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><input type="button" value="Agregar Paquetes" onclick="gencad()"/> </td>
		<td><input type="button" value="Cancelar" onclick="window.close();"/></td>
	</tr>
	</table>
	<span style="font-size: 12px; color: #BA2D0A;">* En paquetes no aplican descuentos adicionales por plan o convenio.</span>
</div>