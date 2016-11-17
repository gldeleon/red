<?php
/**
 * Obtiene una lista de tratamientos y los regresa a modo de cadena
 * @package dentalia
 * @global {String} $cat
 * @global {String} $color
 * @return {String} $res
 */
	$cat = (isset($_POST["cat"]) && !empty($_POST["cat"])) ? $_POST["cat"] : "0";
	$color = (isset($_POST["color"]) && !empty($_POST["color"])) ? $_POST["color"] : "0";
	$trt = (isset($_POST["trt"]) && !empty($_POST["trt"])) ? $_POST["trt"] : "0";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$agr = (isset($_POST["agr"]) && !empty($_POST["agr"])) ? $_POST["agr"] : "0";
	$btr = (isset($_POST["btr"]) && !empty($_POST["btr"])) ? $_POST["btr"] : "0";
	$res = "";

	if($cat != "0") {
		//Llama al archivo de configuracion.
		include "../../config.inc.php";
		include "../../functions.inc.php";

		//Obtiene un objeto de conexion con la base de datos.
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		//Obtiene una lista con todos los tratamientos de la categoria seleccionada.
		if($cat != "91") {
			if($cat == "1" && $btr == "0") {
				$query = "select trt_id, trt_name, trt_abbr, spc_id, trt_sess, trt_divsess,
				trt_color, tcy_number, trt_maxsess, null, null, null, null, null, null, null,
				null, null, null, null, null, null, null
				from {$DBName}.treatment where trt_active = 1 and tcy_number = {$cat} and
				trt_id = 3";
				if($result = @mysql_query($query, $link)) {
					while($row = @mysql_fetch_row($result)) {
						list($trt_id, $trt_name, $trt_abbr, $spc_id, $trt_sess, $trt_divsess, $trt_color,
						$tcy_number, $trt_maxsess, $tht_cid, $trt_comb, $tht_class, $tht_vpos, $tht_zpos,
						$treatgto_id, $ttd_gto, $ttd_iniauth, $btr_id, $bud_number, $cli_id, $trp_price,
						$agt_discount, $trs_amount) = $row;
						$trt_name = trim(uppercase($trt_name));
						$trt_abbr = trim(uppercase($trt_abbr));
						$white = ($trt_color == "#7F4E52" || $trt_color == "#153E7E" || $trt_color == "#2B60DE" ||
								  $trt_color == "#4E9258" || $trt_color == "#38ACEC" || $trt_color == "#585692" ||
								  $trt_color == "#27625C" || $trt_color == "#2D968B" || $trt_color == "#67C3B9"
								 ) ? "#FFF" : "#084C9D";
						$res .= "{$trt_id},{$trt_name},{$trt_abbr},{$spc_id},{$trt_sess},{$trt_divsess},{$trt_color},
						{$white},{$tcy_number},{$trt_maxsess},{$tht_cid},{$trt_comb},{$tht_class},{$tht_vpos},{$tht_zpos},
						{$treatgto_id},{$ttd_gto},{$ttd_iniauth},{$btr_id},{$bud_number},{$cli_id},{$trp_price},
						{$agt_discount},{$trs_amount}*";
					}
					@mysql_free_result($result);
				}
			}
			elseif($btr != "0") {
				$query = "select bt.trt_id, t.trt_name, t.trt_abbr, t.spc_id, t.trt_sess, t.trt_divsess,
				t.trt_color, t.tcy_number, t.trt_maxsess, bt.tht_cid, bt.trt_comb, bt.tht_class, bt.tht_vpos,
				bt.tht_zpos, bt.treatgto_id, b.ttd_gto, b.ttd_iniauth, bt.btr_id, bt.bud_number, bt.cli_id,
				bt.trp_price, bt.agt_discount, bt.trs_amount
				from {$DBName}.budtreat as bt left join {$DBName}.treatment as t on t.trt_id = bt.trt_id
				left join {$DBName}.budget as b on b.bud_number = bt.bud_number and b.cli_id = bt.cli_id
				where bt.btr_id = {$btr}";
				if($cat == "1") {
					$query .= " and bt.trt_id != 3";
				}
				$query .= " order by bt.btr_stage, t.trt_name";
			}

			if($btr == "0") {
				$query = "select trt_id, trt_name, trt_abbr, spc_id, trt_sess, trt_divsess, trt_color, tcy_number,
				trt_maxsess, null, null, null, null, null, null, null, null, null, null, null, null, null, null
				from {$DBName}.treatment where trt_active = 1 and tcy_number = {$cat}";
				if($cat == "1") {
					$query .= " and trt_id != 3";
				}
				if($color != "0") {
					$query .= " and trt_color = '{$color}'";
				}
				if($trt != "0") {
					$query .= " and trt_id = '{$trt}'";
				}
				$query .= " order by trt_name";
			}
		}
		elseif($cat == "91") {
			if($pat == "") {
				die("ERROR");
			}
			$budnum = $budcli = "";
			$query = "select bud_number, cli_id from {$DBName}.budget where
			pat_id = '".utf8_decode($pat)."' order by bud_date desc limit 1";
			if($result = @mysql_query($query, $link)) {
				if(@mysql_num_rows($result) > 0) {
					list($budnum, $budcli) = @mysql_fetch_row($result);
				}
				else die("BUDGET");
			}

			$query = "select bt.trt_id, t.trt_name, t.trt_abbr, t.spc_id, t.trt_sess, t.trt_divsess,
			t.trt_color, t.tcy_number, t.trt_maxsess, bt.tht_cid, bt.trt_comb, bt.tht_class, bt.tht_vpos,
			bt.tht_zpos, bt.treatgto_id, b.ttd_gto, b.ttd_iniauth, bt.btr_id, bt.bud_number, bt.cli_id,
			bt.trp_price, bt.agt_discount, bt.trs_amount
			from {$DBName}.budtreat as bt left join {$DBName}.treatment as t on t.trt_id = bt.trt_id
			left join {$DBName}.budget as b on b.bud_number = {$budnum} and b.cli_id = {$budcli}
			where bt.bud_number = {$budnum} and bt.cli_id = {$budcli}
			order by bt.btr_stage, t.trt_name";
		}

		if($result = @mysql_query($query, $link)) {
			if(@mysql_num_rows($result) > 0) {
				while($row = @mysql_fetch_row($result)) {
					list($trt_id, $trt_name, $trt_abbr, $spc_id, $trt_sess, $trt_divsess, $trt_color,
					$tcy_number, $trt_maxsess, $tht_cid, $trt_comb, $tht_class, $tht_vpos, $tht_zpos,
					$treatgto_id, $ttd_gto, $ttd_iniauth, $btr_id, $bud_number, $cli_id, $trp_price,$agt_discount,$trs_amount) = $row;
					$trt_name = uppercase($trt_name);
					$trt_abbr = uppercase($trt_abbr);
					$white = ($trt_color == "#7F4E52" || $trt_color == "#153E7E" || $trt_color == "#2B60DE" ||
							  $trt_color == "#4E9258" || $trt_color == "#38ACEC" || $trt_color == "#585692" ||
							  $trt_color == "#27625C" || $trt_color == "#2D968B" || $trt_color == "#67C3B9"
							 ) ? "#FFF" : "#084C9D";
					$res .= "{$trt_id},{$trt_name},{$trt_abbr},{$spc_id},{$trt_sess},{$trt_divsess},{$trt_color},
					{$white},{$tcy_number},{$trt_maxsess},{$tht_cid},{$trt_comb},{$tht_class},{$tht_vpos},{$tht_zpos},
					{$treatgto_id},{$ttd_gto},{$ttd_iniauth},{$btr_id},{$bud_number},{$cli_id},{$trp_price},
					{$agt_discount},{$trs_amount}*";
				}
			}
			else die("EMPTY");
		}
		@mysql_close($link);
	}
	echo (strlen($res) > 0) ? $res : "ERROR";

?>