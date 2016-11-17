<?php
        //*** Carga variables URL y determina sus valores iniciales.
	$sid = (isset($_POST["sid"]) && !empty($_POST["sid"])) ? $_POST["sid"] : "0";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$res = "ERROR";
        
        if($sid != "0" && $cli != "0" ) {
            //*** Llama al archivo de configuracion.
            include "../config.inc.php";

            $link = @mysql_connect($DBServer, $DBUser, $DBPaswd);
        
                $cobroQuery = "select rec_id from {$DBName}.receipt where ses_number = (
                            select ses_number from {$DBName}.session where ses_id = {$sid}) and cli_id = {$cli}
                            and rec_status = 0";

            if($cobroResult = @mysql_query($cobroQuery, $link)){
                   if(@mysql_num_rows($cobroResult) > 0){
                       $res = "OK";
                   }
            }

            @mysql_close($link);
                
	}
	echo $res; 
        
?>
