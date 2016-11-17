<?

	$string = (isset($_POST["string"]) && !empty($_POST["string"])) ? $_POST["string"] : "";
  $agr = (isset($_POST["agr"]) && !empty($_POST["agr"])) ? $_POST["agr"] : 0;
	$affected = 0;

	if($string != "") {
		$sArray = explode("|", $string);
		if(count($sArray) == 4) {
			$pat = $sArray[0];
			$cli = $sArray[1];
			$bud = $sArray[2];
			$string = $sArray[3];
			$pat = utf8_decode($pat);
			$sArray = explode("*", $string);
			array_pop($sArray);
			$sBudTxList = implode(",", $sArray);


			if(strlen($sBudTxList) > 0) {
				/** Llama al archivo de configuración. */
				include "../../config.inc.php";

				$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

				/* Obtiene el numero de presupuesto y la clave de clinica del presupuesto seleccionado. */
				$budnum = "0";
				$budcli = $cli;
				$query = "select bud_number, cli_id from {$DBName}.budget where bud_id = {$bud} limit 1";
				if($result = @mysql_query($query, $link)) {
					$row = @mysql_fetch_row($result);
					$budnum = $row[0];
					$budcli = $row[1];
					@mysql_free_result($result);
				}

				if($budnum != "0") {
					/* Averigua que paquetes pudieron existir en los tratamientos a eliminar. */
					$bundles = array();
					$query = "select distinct bun_id from {$DBName}.budtreat where btr_id in ({$sBudTxList})";
					if($result = @mysql_query($query, $link)) {
						while($row = @mysql_fetch_row($result)) {
							$bundles[] = $row[0];
						}
						@mysql_free_result($result);
					}
 //********************JCC***********************************
      /** NO ELIMINAR DESCUENTOS NI PRECIOS ESPECIALES A LOS TRATAMIENTOS
          DEL PRESUPUESTO.
                           
					/* Para el resto de los tratamientos de ese presupuesto, se eliminan descuentos y precios especiales. 
					if(count($bundles) > 0) {
						foreach($bundles as $key => $bun_id) {
							/** TODO:  No nada mas quitarles el descuento, averiguar si es paciente de plan o convenio
							y ponerle el descuento correcto.... 

                                                        if($agr != "147" && $agr != "148" && $agr != "183"){
                                                            $query = "update {$DBName}.budtreat set bun_id = 0, agt_discount = 0, trs_amount = trp_price
                                                            where bud_number = {$budnum} and cli_id = {$budcli}";
                                                            @mysql_query($query, $link);
                                                        }
						}
					}

					Elimina los tratamientos que ya no se desea que formen parte del presupuesto. */
					//echo $sBudTxList;
 //********************JCC***********************************					
                                        //$ttdTreat->deleteGtoTreat($ttd_gto, $sBudTxList);

                    $query = "delete from {$DBName}.budtreat where btr_id in ({$sBudTxList}) and bud_number = {$budnum}";
					@mysql_query($query, $link);
					$affected = @mysql_affected_rows($link);

                                        
                                        
				}
				@mysql_close($link);
			}
		}
	}
	echo ($affected !== false && $affected >= 1) ? "OK" : "ERROR";
?>