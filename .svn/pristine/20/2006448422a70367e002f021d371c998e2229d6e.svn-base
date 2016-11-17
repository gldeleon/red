<?
	$res = false;
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$date1 = (isset($_POST["date1"]) && !empty($_POST["date1"])) ? $_POST["date1"] : "";
		$date2 = (isset($_POST["date2"]) && !empty($_POST["date2"])) ? $_POST["date2"] : "";
	} else if($_SERVER['REQUEST_METHOD'] == "GET") {
		$date1 = (isset($_GET["date1"]) && !empty($_GET["date1"])) ? $_GET["date1"] : "";
		$date2 = (isset($_GET["date2"]) && !empty($_GET["date2"])) ? $_GET["date2"] : "";
	}
	if($date1 != "" && $date2 != "") {
		if(strtotime($date1) == strtotime($date2))
			$res = 0;
		if(strtotime($date1) > strtotime($date2))
			$res = 1;
		if(strtotime($date1) < strtotime($date2))
			$res = -1;
	}
	echo $res;
?>