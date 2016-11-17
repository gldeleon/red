<?php
	$f = isset($_GET['f']) ? $_GET['f'] : '';
	if($f != '' && is_file('./'.$f)) {
		$len = filesize($f);
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$f.'"');
		header('Content-Length: '.$len);
		readfile('./'.$f);
	}
?>