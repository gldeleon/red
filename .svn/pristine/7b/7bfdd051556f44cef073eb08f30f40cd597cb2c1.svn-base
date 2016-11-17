<?php

$filter = (isset($_GET["term"]) && !empty($_GET["term"])) ? $_GET["term"] : "";

include "../config.inc.php";
$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

$response = array();

$query = "select p.pat_id, p.pat_complete, p.agr_id, a.agl_id from ".$DBName.".patient as p
			left join ".$DBName.".agreement as a on a.agr_id = p.agr_id where 
			p.pat_complete like '%".$filter."%' order by p.pat_complete limit 10";

if($result = @mysql_query($query, $link)) {
	while($row = @mysql_fetch_array($result)) {
		$response[] = array("id" => utf8_encode($row[0]),
							"value" => utf8_encode($row[1]),
							"label" => utf8_encode($row[1]));
	}
	@mysql_free_result($result);
}
@mysql_close($link);

echo json_encode($response);

?>