<?php
	class config {
		/* Configuracion de la base de datos */
		var $db_type = "mysql";
		var $db_server = "localhost";
		var $db_user = "";
		var $db_passwd = "";
		var $db_name = "";

		/* Configuracion de la aplicacion */
		var $app_url = "/";
		var $app_title = "Red KOBE";

		/* Configuracion de las sesiones */
		var $sess_lifetime = 45;
		var $sess_cookies = 0;

		var $fp = array(
			"CLS" => "classes",
			"COM" => "components",
			"IMG" => "images",
			"INC" => "includes",
			"MOD" => "modules"
		);
	}
?>
