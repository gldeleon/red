<?php
    /** Llama al archivo de configuración. */
	include "../../config.inc.php";
	
	$link = @mysql_connect($DBServer, $DBUser, $DBPaswd);

	$user = (isset($_POST["user"]) && !empty($_POST["user"])) ? $_POST["user"] : "";
	$paswd = (isset($_POST["paswd"]) && !empty($_POST["paswd"])) ? $_POST["paswd"] : "";
	
	$autorizados = array();
	$val="";
	$consulta = "select u.usr_id, u.emp_id from {$DBName}.user as u 
				where u.usr_name = '".$user."' and u.usr_passwd = '".md5($paswd)."' and u.usr_active = 1";
				
	if($res = @mysql_query($consulta,$link)){
		$row = @mysql_fetch_row($res);
		if(@mysql_num_rows($res) > 0){
			$empid = $row[1];
			$query = "select emp_id from {$DBName}.emppost
					where pst_id in ( 2, 3, 4, 5, 6, 7, 8, 9, 20, 22, 23)";
			if($result = @mysql_query($query,$link)){
				while($row1 = @mysql_fetch_row($result)){
					$autorizados[] = $row1[0];
				}
				//$cont = var_dump($autorizados);
				if(in_array($empid, $autorizados)){
					$val = "EXISTE*".$empid;
				}
				else{
					$val = "ERROR*DENEGADO";
				}
				@mysql_free_result($result);
			}
		}
		else{
			$val = "ERROR*";
		}
		@mysql_free_result($res);
	}
	echo $val;

	@mysql_close($link);
?>