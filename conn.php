<?php
	$dbhost = 'localhost';
	$dbuser = 'kobemxco_dental';
	$dbpass = '*h!qj6e29usE';
	$dbname = 'kobemxco_red';

	$conn = mysql_pconnect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
	mysql_select_db($dbname);
?>