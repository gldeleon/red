<?php
include_once '../../config.class.php';
include_once "../../lib/execQuery.class.php";

$query = "SELECT vst.vst_id, vst.vst_ini, vst.vln_id, vln_min 
		  FROM `visit` vst
		  LEFT JOIN visitlength vln
		  ON vst.vln_id = vln.vln_id
		  WHERE vst.`vst_end` = '00:00:00'";

$execQuery = new execQuery($query);
$result = $execQuery->execute(ARRAY_ASSOC);
$i = 0;
foreach($result as $data){
	
	list($hr, $min, $sec) = explode(":", $data["vst_ini"]);
	$vst_end = date("H:i:s", mktime($hr, $min+$data["vln_min"], $sec,1,1,1));
// 	echo "Inicial: ".$data["vst_ini"]." Final: ".$vst_end." Minutos: ".$data["vln_min"]."<br/>";

	echo $query = "UPDATE visit SET 
			  vst_end = '{$vst_end}' 
			  WHERE vst_id = {$data["vst_id"]} 
			  AND vst_end = '00:00:00' AND vst_ini <> '00:00:00'";
echo "<br/>";
	$execQuery = new execQuery($query);
	$res = $execQuery->execute(ARRAY_ASSOC);
	if($res["affected_rows"] > 0){
		$i++;
	}
	
}

echo $i;

?>