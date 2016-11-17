<?php
	/** Establece la zona horaria para trabajar con fechas. */
	date_default_timezone_set("America/Mexico_City");

	/** Carga variables URL y determina sus valores iniciales. */
	$obj = (isset($_POST["obj"]) && !empty($_POST["obj"])) ? $_POST["obj"] : "";
	$oid = (isset($_POST["oid"]) && !empty($_POST["oid"])) ? $_POST["oid"] : "";
	$ocls = (isset($_POST["ocls"]) && !empty($_POST["ocls"])) ? $_POST["ocls"] : "";
	$vdate = (isset($_POST["vdate"]) && !empty($_POST["vdate"])) ? $_POST["vdate"] : "";
	$uid = (isset($_POST["uid"]) && !empty($_POST["uid"])) ? $_POST["uid"] : "";
	$cli = (isset($_POST["cli"]) && !empty($_POST["cli"])) ? $_POST["cli"] : "0";
	$q = (isset($_POST["q"]) && !empty($_POST["q"])) ? $_POST["q"] : "0";
	$paste = "";

	if($obj != "" && $oid != "" && $vdate != "" && $uid != "") {
		$session = ($obj == "DIV" && substr($oid, 0, 1) == "[");
		$visit = ($obj == "TD" && substr($oid, 0, 1) == "[");
		$perm = true;

		/** Llama al archivo de configuracion. */
		include "../config.inc.php";

		$sess_start = $session && $ocls != "ASISTIDA" && $ocls != "NO ASISTIDA" && (strtotime($vdate) == strtotime(date("Y-m-d"))) ? "contextMenuItem" : "contextMenuItemDisabled";
		$sess_edit = $session && ($ocls == "NORMAL" || $ocls == "CONFIRMADA") && (strtotime($vdate) >= strtotime(date("Y-m-d"))) ? "contextMenuItem" : "contextMenuItemDisabled";
		$sess_confirm = $session && $ocls != "ASISTIDA" && $ocls != "CONFIRMADA" && $ocls != "CANCELADA" && (strtotime($vdate) >= strtotime(date("Y-m-d"))) ? "contextMenuItem" : "contextMenuItemDisabled";
		$sess_cancel = $session && $ocls != "ASISTIDA" && (strtotime($vdate) >= strtotime(date("Y-m-d"))) ? "contextMenuItem" : "contextMenuItemDisabled";
		$sess_delete = $session && $ocls != "ASISTIDA" && $ocls != "NO ASISTIDA" && (strtotime($vdate) >= strtotime(date("Y-m-d"))) ? "contextMenuItem" : "contextMenuItemDisabled";
		$sess_cutncpy = $session && (strtotime($vdate) >= strtotime(date("Y-m-d"))) ? "contextMenuItem" : "contextMenuItemDisabled";
		$sess_paste = $visit && (strlen($paste) > 0) ? "contextMenuItem" : "contextMenuItemDisabled";

		/** Determina si debe deshabilitar el evento, segun la clase CSS previamente definida. */
		$session_start_disabled = ($session && (strpos($sess_start, "Disabled") === false)) ? "false" : "true";
		$sess_edit_disabled = ($session && (strpos($sess_edit, "Disabled") === false)) ? "false" : "true";
		$session_confirm_disabled = ($session && (strpos($sess_confirm, "Disabled") === false)) ? "false" : "true";
		$sess_cancel_disabled = ($session && (strpos($sess_cancel, "Disabled") === false)) ? "false" : "true";
		$sess_delete_disabled = ($session && (strpos($sess_delete, "Disabled") === false)) ? "false" : "true";
?>
	<div class="<?=$sess_start; ?>" onclick="contextMenuActn('start', '<?=$oid; ?>', <?=$session_start_disabled; ?>)">Iniciar sesi&oacute;n</div>
    <div class="contextMenuSpacer"><img src="../images/spacer.gif" width="1" height="1" /></div>
	<div class="<?=$sess_edit; ?>" onclick="contextMenuActn('edit', '<?=$oid; ?>', <?=$sess_edit_disabled; ?>)">Editar...</div>
    <div class="contextMenuSpacer"><img src="../images/spacer.gif" width="1" height="1" /></div>
    <div class="<?=$sess_confirm; ?>" onclick="contextMenuActn('confirm', '<?=$oid; ?>', <?=$session_confirm_disabled; ?>)">Confirmar</div>
    <div class="<?=$sess_cancel; ?>" onclick="contextMenuActn('cancel', '<?=$oid; ?>', <?=$sess_cancel_disabled; ?>)">Cancelar</div>
	<div class="contextMenuSpacer"><img src="../images/spacer.gif" width="1" height="1" /></div>
	<div class="<?=$sess_delete; ?>" onclick="contextMenuActn('delete', '<?=$oid; ?>', <?=$sess_delete_disabled; ?>)">Eliminar</div>
    <div class="contextMenuSpacer"><img src="../images/spacer.gif" width="1" height="1" /></div>
    <div class="contextMenuItem" onclick="contextMenuActn('refresh', null, false)">Actualizar</div>
<?php
	}
	else {
		echo "ERROR";
	}
?>