<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Sincronizacion de precios de Sistema de Red Kobe</title>
</head>
<body>

	<h1>Sincronizaci&oacute;n de precios de Sistema de Red Kobe</h1>
<?php

	$link = mysql_connect('localhost', 'kobemxco_dental', '*h!qj6e29usE');

	$txprice = array();
	$query = "select q1.trt_id, q1.trp_price, q1.trp_date from (select trt_id,
	trp_price, trp_date from kobemxco_dentalia.treatprice where cli_class = 2
	and trp_date > '2012-01-01' order by trp_date desc) as q1 group by q1.trt_id";
	$result = mysql_query($query, $link);
	if($result) {
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$txprice[] = array(
				'trtId' => $row['trt_id'],
				'trtPrice' => $row['trp_price'],
				'trpDate' => $row['trp_date']
			);
		}
	}
	//echo "Tratamientos encontrados:<br/><pre>" . print_r($txprice,true) . "</pre><br/>";
	$query1 = "select clc_id from kobemxco_red.clinic group by clc_id";
	$result1 = mysql_query($query1, $link) or die('q1: ' . mysql_error() . "<br/>" . $query1);
	if($result1) {
		while ($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)) {
			$clcId = $row1['clc_id'];

			echo "<p><b>Verificando precios de clase {$clcId}...</b><br/> ";

			$txpcount = 0;
			foreach ($txprice as $price) {				
				$query2 = "select count(*) resultados from kobemxco_red.treatprice
				where cli_class='{$clcId}' and trt_id = '{$price['trtId']}' and
				trp_price = '{$price['trtPrice']}' and trp_date = '{$price['trpDate']}'";
				//echo print_r($price,TRUE) . "}<br/>";
				$result2 = mysql_query($query2, $link) or die('q2: ' . mysql_error() . "<br/>" . $query2);
				$row = mysql_fetch_array($result2);		
				if($row['resultados'] == 0) {
					//echo "sin rows!<br/>";
					//echo "res: {$row['resultados']}<br/>";
					$query3 = "insert into kobemxco_red.treatprice values (null,
					'{$price['trtId']}', '{$clcId}', '{$price['trtPrice']}',
					'{$price['trpDate']}', 1)";
					mysql_query($query3, $link) or die('q3: ' . mysql_error() . "<br/>" . $query3);
					if(mysql_affected_rows($link) > 0) {
						$txpcount++;
					}
				}else{
					//echo "{$query2}<br/> con rows!<br/><br/>";
				}
			}
			$p = ($txpcount == 1) ? "&oacute;" : "aron";
			echo "Se actualiz{$p} {$txpcount} registro(s). </p>";
		}
	}
?>

</body>
</html>