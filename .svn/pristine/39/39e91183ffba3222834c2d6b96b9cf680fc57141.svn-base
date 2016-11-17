<?
	$filter = (isset($_POST["filter"]) && !empty($_POST["filter"])) ? $_POST["filter"] : "";
	$type = (isset($_POST["type"]) && !empty($_POST["type"])) ? $_POST["type"] : "";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";

	if($filter != "" && $type != "") {
		include "../config.inc.php";
		$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
		
		$filter = ereg_replace("([$\\\"\'¿?0-9#\*~€%&\/\(\)]+)", "", trim($filter));
		
		if($type == "doctor" && $cli == "0")
			$query = "select emp_id, emp_complete, null, null from ".$DBName.".employee where
			emp_complete like '%".$filter."%' order by emp_complete limit 10";
		if($type == "clidoc" && $cli != "0")
			$query = "select e.emp_id, e.emp_complete, null, null from {$DBName}.empclinic as ec 
			left join {$DBName}.employee as e on e.emp_id = ec.emp_id 
			left join {$DBName}.emppost as ep on ep.emp_id = ec.emp_id
			where e.emp_complete like '%".$filter."%' and e.emp_active = 1 and 
			and ep.pst_id in (25, 26, 27, 28, 29, 30, 31) and ec.cli_id = {$cli} order by e.emp_complete limit 10";
		elseif($type == "patient")
			$query = "select p.pat_id, p.pat_complete, p.agr_id, a.agl_id from ".$DBName.".patient as p
			left join ".$DBName.".agreement as a on a.agr_id = p.agr_id where 
			p.pat_complete like '%".$filter."%' order by p.pat_complete limit 10";
		//echo $query;
		if($result = @mysql_query($query, $link)) {
			while($row = @mysql_fetch_array($result)) {
				$agrclass = (!is_null($row[2]) && $row[2] != "0" && $row[3] != "1")  ? "filterAgrResult" : ((!is_null($row[3]) && $row[3] == "2") ? "filterConvResult" : "filterResult");
				echo "<div id=\"".utf8_encode($row[0])."\" class=\"".$agrclass."\" style=\"width: 500px\" onmouseover=\"showAgreementDesc(this, '".$row[2]."')\" onclick=\"setAutoCompleteValue(this, '".$type."')\">".utf8_encode($row[1])."</div>";
			}
			@mysql_free_result($result);
		}
		@mysql_close($link);
	}
?>