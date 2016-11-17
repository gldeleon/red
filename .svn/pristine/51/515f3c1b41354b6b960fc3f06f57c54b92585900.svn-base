 <?
	/** Llama al archivo de configuración. */
	include "../config.inc.php";
	include "../conn.php";
	$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : "0";
	$pat = (isset($_POST["pat"]) && !empty($_POST["pat"])) ? $_POST["pat"] : "";
	$esp = (isset($_GET["esp"]) && !empty($_GET["esp"])) ? $_GET["esp"] : "2";
	$ibud = (isset($_POST["ibud"]) && !empty($_POST["ibud"])) ? $_POST["ibud"] : "0";
	$stage = (isset($_GET["stage"]) && !empty($_GET["stage"])) ? $_GET["stage"] : "0";
	$pat = utf8_decode($pat);
	
	if($ibud == 0) {
		$query = "select * from {$DBName}.budget where pat_id = '{$pat}' order by bud_date desc";
		$rs = @mysql_query($query, $conn) or die ($query);
		$rw = @mysql_fetch_array($rs);
		$ibud = $rw['bud_id'];
	}
	$query = "select * from {$DBName}.budget where bud_id = {$ibud}";
	$result = @mysql_query($query, $conn) or die ($query);
	if(@mysql_num_rows($result) > 0) {
		$row = @mysql_fetch_array($result);
		$query = "select b.bun_id from {$DBName}.clinic as a, {$DBName}.bundle as b where a.cli_id = {$row['cli_id']} 
		and (b.bun_active = 1) and (b.clt_id = a.clt_id or b.clt_id = 0) and (b.clc_id = a.clc_id or b.clc_id = 0)"; 
		//echo $query;
		$result2 = @mysql_query($query, $conn); //Traemos los paquetes disponibles para la clinica
		if(@mysql_num_rows($result2) > 0) {
			$packs = array();
			$pcont = 0;
			while($row2 = @mysql_fetch_array($result2)) {
				$packs[$pcont] = $row2['bun_id'];
				if($pcont > 0) {
					$paramtrt .= " or ";
				}
				$paramtrt .= "a.bun_id = {$row2['bun_id']}";
				$pcont++;
			}
			$query = "select trt_id, sum(bud_qty) as bud_qty from {$DBName}.budtreat where bun_id = 0 and 
			bud_number = {$row[4]} and cli_id = {$row[2]} group by trt_id";
			$result2 = @mysql_query($query, $conn) or die ($query);
			if(@mysql_num_rows($result2) > 0) {
				$cont = 0;
				$param = "";
				$trt_pat = array();
				$trt_qtypat = array();
				$pack_ok = array();
				$ntrt_ok = 0;
				$ntrt_okqty = 0;
				while($row2 = @mysql_fetch_array($result2)){
					if($cont > 0) {
						$param .= " or ";
					}
					$param .= "a.trt_id = {$row2['trt_id']}";
					$trt_pat[$cont] = $row2['trt_id'];
					$trt_qtypat[$cont] = $row2['bud_qty'];
					$cont++;
				}
				$query = "select distinct a.bun_id, b.bun_name, b.numtrt from {$DBName}.bundletreat as a, {$DBName}.bundle as b 
				where a.bun_id = b.bun_id and b.bun_active = 1 and ({$param}) and ({$paramtrt})";
				$result2 = @mysql_query($query, $conn) or die ($query);
				if(@mysql_num_rows($result2) > 0) {
					//echo $query."<br/>";
					while($row3 = @mysql_fetch_array($result2)) {
						$ntrt_ok = 0;
						$ntrt_okqty = 0;
						$numtrt = $row3['numtrt'];
						//echo "<br/>------entra".$numtrt."<br/>";
						$query = "select * from (select trt_id, bun_id, bnt_date, bnt_opc, bnt_qty from {$DBName}.bundletreat 
						where bun_id = ".$row3["bun_id"]." order by trt_id, bnt_date desc) as a group by trt_id";
						$res3 = @mysql_query($query, $conn);
						//echo $query."--------".mysql_num_rows($res3)."<br/>";
						if(@mysql_num_rows($res3) > 0) {
							$trtopc = array();
							$trtobl = array();
							$trtopcqty = array();
							$trtoblqty = array();
							$contopc = 0;
							$contobl = 0;
							while($row4 = @mysql_fetch_array($res3)) {
								if($row4["bnt_opc"] == 0) {
									$trtobl[$contobl] = $row4["trt_id"];
									$trtoblqty[$contobl] = $row4["bnt_qty"];
									$contobl++;
								}
								else {
									$trtopc[$contopc] = $row4["trt_id"];
									$trtopcqty[$contopc] = $row4["bnt_qty"];
									$contopc++;
								}
							}
							//echo "opc:".$contopc." obl:".$contobl."<br/>";
							if($contobl > 0) {
								//echo count($trtobl);
								for($ntrt = 0; $ntrt < count($trtobl); $ntrt++) {
									for($nptrt = 0; $nptrt < count($trt_pat); $nptrt++) {
										//echo "entra<br/>";
										//echo "if((".$trtobl[$ntrt]."==".$trt_pat[$nptrt].")&&(".$trtoblqty[$ntrt]."<=".$trt_qtypat[$nptrt]."))<br/>";
										if(($trtobl[$ntrt] == $trt_pat[$nptrt]) && ($trtoblqty[$ntrt] <= $trt_qtypat[$nptrt])) {
											$ntrt_okqty = $ntrt_okqty + $trtoblqty[$ntrt];
											$ntrt_ok = $ntrt_ok + $trtoblqty[$ntrt];
											//echo "Encontrado obl ".$trtobl[$ntrt]."--".$trt_pat[$nptrt]."<---->".$ntrt_ok."--".$ntrt_okqty."<br/>";  
										}
									}
								}
							}
							//echo "<br/>".$ntrt_okqty."==".$ntrt_ok."<br/>";
							if($ntrt_okqty == $ntrt_ok) {
								//echo "Obligatorios cubiertos<br/>";
								if($contopc > 0) {
									//echo "Existen Opcionales<br/>";
									for($ntrt = 0; $ntrt < count($trtopc); $ntrt++) {
										for($nptrt = 0; $nptrt < count($trt_pat); $nptrt++) {
											//echo "if((".$trtopc[$ntrt]."==".$trt_pat[$nptrt].")&&(".$trtopcqty[$ntrt]."<=".$trt_qtypat[$nptrt]."))<br/>";
											if(($trtopc[$ntrt] == $trt_pat[$nptrt]) && ($trtopcqty[$ntrt] <= $trt_qtypat[$nptrt])) {
												$ntrt_okqty = $ntrt_okqty + $trt_qtypat[$nptrt];
												$ntrt_ok = $ntrt_ok + $trtopcqty[$ntrt];
												//echo "<br/>Encontrado".$trtopc[$ntrt]."--".$trt_pat[$nptrt]."<---->".$ntrt_ok."--".$ntrt_okqty."<br/>";	
											}
										}
									}
								}
								//echo "<br/>-------------".$numtrt."<=".$ntrt_ok."<br/>";
								if($numtrt <= $ntrt_okqty) {
									$npk = count($pack_ok);
									$pack_ok[$npk] = $row3["bun_id"];
									//echo "Agregamos paquete<br/>";
								}
							}
						}
					}
					
					if(count($pack_ok) > 0) {
						$packs = "";
						for($pkcont = 0; $pkcont < count($pack_ok); $pkcont++) {
							$packs .= $pack_ok[$pkcont]."-00-";
						}
						$packs = substr($packs, 0, -4);
						echo $packs;
					}
					else {
						echo "-|e";	 
					}
				}
				else {
					echo "-|d";
				}
			}
			else {
				echo "-|c";
			}
		}
		else {
			echo "-|b";
		}
	}
	else {
		echo "-|a";
	} 
?>