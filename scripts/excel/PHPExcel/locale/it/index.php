<?php

	header("HTTP/1.0 404 Not Found");
	print(file_get_contents("http://sis.dentalia.com.mx.local/content/errorMessages/errorDentalia.php"));
	exit();

?>