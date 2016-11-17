<?
	$res = "";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$ini = (isset($_POST["ini"]) && !empty($_POST["ini"])) ? $_POST["ini"] : "0000-00-00";
	$end = (isset($_POST["end"]) && !empty($_POST["end"])) ? $_POST["end"] : "0000-00-00";
	if($ini != "0000-00-00" && $end != "0000-00-00") {

		include "../config.inc.php";

		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

		$query = "select v.vst_id, v.cli_id, v.pat_id, v.usr_id, v.emp_id,
		v.cli_chair, v.vst_date, v.vst_ini, v.vst_descr, e.emp_abbr, c.cli_chairs,
		vl.vln_len, vt.vta_color, pat.agr_id
		from {$DBName}.visit as v
		left join {$DBName}.employee as e on e.emp_id = v.emp_id
		left join {$DBName}.clinic as c on c.cli_id = v.cli_id
		left join {$DBName}.visitlength as vl on vl.vln_id = v.vln_id
		left join {$DBName}.visitstatus as vt on vt.vta_id = v.vta_id
		left join {$DBName}.patient as pat on v.pat_id = pat.pat_id
		where v.cli_id = {$cli} and v.vst_date between '{$ini}' and '{$end}' and v.vta_id not in (7,9)
		order by v.vst_date, v.cli_chair, v.vst_ini";
		//echo $query;
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
				$desc = preg_replace("/[^a-zA-Z0-9s]/", "", $row['vst_descr']);
				$pat = utf8_encode($row['pat_id']);
				$res .= "{$row['vst_id']},{$row['vln_len']},{$row['cli_chairs']},
				{$row['emp_abbr']},{$row['cli_chair']},{$row['vst_date']},{$row['vst_ini']},
				{$desc},{$row['vta_color']},{$row['cli_id']},{$pat},{$row['emp_id']},
				{$row['usr_id']},{$row['agr_id']},{$row['pat_vip']}*";
			}
		}
	}
	echo $res;
?>