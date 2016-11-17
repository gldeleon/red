<?php
	$oid = (isset($_POST["oid"]) && !empty($_POST["oid"])) ? $_POST["oid"] : "";
	if($oid != "") {

		include "../config.inc.php";

		$oid = str_replace("visit", "", $oid);
		$oid = str_replace("[", "", $oid);
		$oid = str_replace("]", "", $oid);

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$query = "select v.vst_descr, p.pat_complete, e.emp_complete, vs.vta_name,
		ty.tlt_name, t.tel_number, t.tel_ext from {$DBName}.visit as v
		left join {$DBName}.patient as p on p.pat_id = v.pat_id
		left join {$DBName}.employee as e on e.emp_id = v.emp_id
		left join {$DBName}.visitstatus as vs on vs.vta_id = v.vta_id
		left join {$DBName}.telephone as t on t.pat_id = p.pat_id
		left join {$DBName}.teltype as ty on ty.tlt_id = t.tlt_id
		where v.vst_id = {$oid} limit 3";
		if($result = @mysql_query($query, $link)) {
			$i = 0;
			while($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
				$emp = is_null($row['emp_complete']) ? "No Disponible" : utf8_encode(ucwords(strtolower($row['emp_complete'])));
				$pat = is_null($row['pat_complete']) ? "No Disponible" : ucwords(mb_strtolower(utf8_encode($row['pat_complete']), "UTF-8"));
				$status = is_null($row['vta_name']) ? "No Disponible" : "Cita ".utf8_encode(ucwords(strtolower($row['vta_name'])));
				$desc = (is_null($row['vst_descr']) || (strlen(trim($row['vst_descr'])) == 0)) ? "&nbsp;" : utf8_encode(ucfirst(strtolower($row['vst_descr'])));
				$i++;
				${"tel".$i} = is_null($row['tel_number']) ? "0" : $row['tel_number'];
				${"ttype".$i} = is_null($row['tlt_name']) ? "N/D" : $row['tlt_name'];
				${"text".$i} = is_null($row['tel_ext']) ? "0" : $row['tel_ext'];
			}
			$tel1 = isset($tel1) ? $tel1 : "0";
			$tel2 = isset($tel2) ? $tel2 : "0";
			$tel3 = isset($tel3) ? $tel3 : "0";
			$ttype1 = isset($ttype1) ? $ttype1 : "";
			$ttype2 = isset($ttype2) ? $ttype2 : "";
			$ttype3 = isset($ttype3) ? $ttype3 : "";
			$text1 = isset($text1) ? $text1 : "0";
			$text2 = isset($text2) ? $text2 : "0";
			$text3 = isset($text3) ? $text3 : "0";
			$tel1 = ($tel1 == "0") ? "No Disponible" : $tel1.(($text1 != "0") ? ("Ext. ".$text1) : "").(($ttype1 != "") ? (" (".$ttype1.")") : "");
			$tel2 = ($tel2 == "0") ? "No Disponible" : $tel2.(($text2 != "0") ? ("Ext. ".$text2) : "").(($ttype2 != "") ? (" (".$ttype2.")") : "");
			$tel3 = ($tel3 == "0") ? "No Disponible" : $tel3.(($text3 != "0") ? ("Ext. ".$text3) : "").(($ttype3 != "") ? (" (".$ttype3.")") : "");
?>
<table class="sessionPopupBoxItem" width="350" border="0" cellspacing="0" cellpadding="0" style="margin: 10px; border: 1px solid #084C8D">
<tr>
	<td width="90" align="left" valign="top" class="visitDescHeader">Doctor:</td>
	<td class="visitDescItem"><?=$emp; ?></td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Paciente:</td>
	<td class="visitDescItem"><?=$pat; ?></td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Tel 1:</td>
	<td class="visitDescItem"><?=$tel1; ?></td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Tel 2:</td>
	<td class="visitDescItem"><?=$tel2; ?></td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Tel 3:</td>
	<td class="visitDescItem"><?=$tel3; ?></td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Status:</td>
	<td class="visitDescItem"><?=$status; ?></td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Tratamiento(s):</td>
	<td class="visitDescItem">
	<?php
			$treats = "";
			$query2 = "select t.trt_name from {$DBName}.vistreat as v
			left join {$DBName}.treatment as t on t.trt_id = v.trt_id
			where v.vst_id = {$oid}";
			if($result2 = @mysql_query($query2, $link)) {
				$conacento = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú");
				$sinacento = array("a", "e", "i", "o", "u", "a", "e", "i", "o", "u");
				while($row2 = @mysql_fetch_array($result2, MYSQL_ASSOC)) {
					$treats .= utf8_encode(ucfirst(str_replace($conacento, $sinacento, strtolower($row2['trt_name'])))).", ";
				}
				$treats = substr($treats, 0, -2);
				@mysql_free_result($result2);
			}
			echo $treats = ($treats != "") ? $treats : "&nbsp;";
	?>
	</td>
</tr>
<tr>
	<td align="left" valign="top" class="visitDescHeader">Observaciones:</td>
	<td class="visitDescItem"><?=$desc; ?></td>
</tr>
</table>
<?php
			@mysql_free_result($result);
		}
		else {
			echo "ERROR";
		}
	}
?>