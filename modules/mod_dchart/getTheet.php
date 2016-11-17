<?php
/**
 * Obtiene la lista de dientes del odontograma infantil o de adulto
 * @package dentalia
 * @global {String} $tclass
 * @return {String} $res
 */
	//Carga variables URL y determina sus valores iniciales.
	$tclass = (isset($_POST["tclass"]) && !empty($_POST["tclass"])) ? ($_POST["tclass"]) : "ADL";
	$res = "";

	if($tclass != "") {
		//Llama al archivo de configuracion.
		include "../../config.inc.php";
		include "../../functions.inc.php";
		
		/**
		 * Obtiene un objeto de conexion con la base de datos
		 * @var {Resource} 
		 */
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		//Obtiene una lista con todos los tratamientos de la categoria seleccionada.
		$query = "select tht_cid, tht_name, tht_hpos, tht_vpos from {$DBName}.tooth
		where tht_class = '{$tclass}' and tht_excep = 0 order by tht_cid asc, 
		tht_hpos asc, tht_vpos desc";
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_row($result)) {
				list($tht_cid, $tht_name, $tht_hpos, $tht_vpos) = $row;
				$tht_name = uppercase(utf8_encode($tht_name));
				$res .= "{$tht_cid},{$tht_name},{$tht_hpos},{$tht_vpos}*";
			}
			$res = substr($res, 0, -1);
			@mysql_free_result($result);
		}
		// Los dientes restantes de infantil
		$query = "select tht_cid, tht_name, tht_hpos, tht_vpos from {$DBName}.tooth
		where tht_class = '{$tclass}' and tht_excep = 1 order by tht_cid asc, 
		tht_hpos asc, tht_vpos desc";
		if($result = @mysql_query($query, $link)) {
			if(@mysql_num_rows($result) > 0) {
				while($row = @mysql_fetch_row($result)) {
					list($tht_cid, $tht_name, $tht_hpos, $tht_vpos) = $row;
					$tht_name = uppercase(utf8_encode($tht_name));
					$res .= "*{$tht_cid},{$tht_name},{$tht_hpos},{$tht_vpos}";
				}
			}
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
	echo (strlen($res) > 0) ? $res : "ERROR";
?>