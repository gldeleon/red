<?php
    /** Llama al archivo de configuración. */
	include "../../config.inc.php";
	
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$user = (isset($_POST["user"]) && !empty($_POST["user"])) ? $_POST["user"] : "";
	$paswd = (isset($_POST["pswd"]) && !empty($_POST["pswd"])) ? $_POST["pswd"] : "";
	
	$consulta = "select u.usr_id, u.emp_id from {$DBName}.user as u 
	where u.usr_name = '".$user."' and u.usr_passwd = '".md5($paswd)."' and u.usr_active = 1";
	if($res = @mysql_query($consulta,$link)){
		$row = @mysql_fetch_row($res);
		if(@mysql_num_rows($res) > 0){
			$empid = $row[1];
			echo "EXISTE*".$empid;
		}
		else{
			echo "ERROR*";
		}
		@mysql_free_result($result);
	}
	@mysql_close($link);
?>