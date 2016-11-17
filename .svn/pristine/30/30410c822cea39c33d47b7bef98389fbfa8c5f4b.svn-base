var ff = document.getElementById && !document.all;
var sessionPopupBoxContainer, sessionPopupBox;

window.onload = function() {
	var pTable = document.getElementById("pTable");
	pTable.style.width = parseInt(document.body.clientWidth) + "px";
	
	var pTd = document.getElementById("pTd");
	pTd.style.width = parseInt(document.body.clientWidth) - (40 * 2) + "px";
	
	var m = document.getElementById("m");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 2  + "px";
	
	var sessTable = document.getElementById("sessTable");
	sessTable.style.width = parseInt(document.body.clientWidth) - 19 + "px";
	
	var sessHeader = document.getElementById("sessHeader");
	sessHeader.style.width = parseInt(document.body.clientWidth) - 19 + "px";
	
	var oPatName = document.getElementById('patient');
	if(typeof(oPatName) != 'undefined' && oPatName != null) {
		oPatName.value = "";
	}
};

function exitSession(cli, sid) {
	var sParams = "&cli=" + cli + "&sid=" + sid + "&act=exit";
	var valor = AjaxQuery("POST", "../classes/updPatSession.php", false, sParams);
	alert(valor);
	if(typeof(valor) != 'undefined' && valor != null && valor == "OK") {
		top.rightFrame.bottomFrame.location.reload(true);
	}
}

function pathistory(cli, sid) {
	var sParams = "&cli=" + cli + "&sid=" + sid;
	//alert(sParams);
	var valor = AjaxQuery("POST", "../classes/verifica_pathistory.php", false, sParams);
	//alert(valor);
	if(typeof(valor) != 'undefined' && valor != null && valor == "OK"){
		return true;
	}
	else{
		alert("No se puede finalizar la sesi\u00f3n, porque no se ha capturado la historia cl\u00ednica del paciente");
		return false;
	}
}

function verCobro(cli, sid) {
	endSession(cli, sid);
}

function endSession(cli, sid) {
	var sParams = "&cli=" + cli + "&sid=" + sid + "&act=end";
	var valor = AjaxQuery("POST", "../classes/updPatSession.php", false, sParams);
	if(typeof(valor) != 'undefined' && valor != null && valor == "OK") {
		top.rightFrame.mainFrame.location.replace("welcome.php?cli=" + cli);
		top.rightFrame.bottomFrame.location.reload(true);
	}
	else{
		if(typeof(valor) != 'undefined' && valor != null && valor == "SIN_PAGO"){
			alert("Debes registrar un pago antes de finalizar la sesión");
		}
		else{
			alert("Error al cerrar la sesión");
		}
	}
}

function reloadSessions(cli) {
	if(typeof(cli) != 'undefined' && cli != null && !isNaN(parseInt(cli))) {
		location.replace("sessions.php?cli=" + cli);
	}
	else {
		location.reload(true);
	}
}

function showSessionPopupBox(){
	if(cli == "0") {
		return false;
	}
	hideSessionPopupBox();
	if(typeof(sPopUpBoxNumber) == 'undefined' || sPopUpBoxNumber == null) {
		sPopUpBoxNumber = "";
	}
	sessionPopupBoxContainer = document.getElementById("sessionPopupBoxContainer");
	sessionPopupBox = document.getElementById("sessionPopupBox" + sPopUpBoxNumber);
	sessionPopupBox.style.display = "block";

	if(typeof(sessionPopupBoxContainer) == 'undefined' || sessionPopupBoxContainer == null) {
		return false;
	}
	if(typeof(sessionPopupBox) == 'undefined' || sessionPopupBox == null) {
		return false;
	}
	sessionPopupBox.height = sessionPopupBox.offsetHeight;
	sessionPopupBoxContainer.style.height = parseInt(sessionPopupBox.height) + "px";
	sessionPopupBoxContainer.style.left = (parseInt(document.body.clientWidth) / 2) - (parseInt(sessionPopupBoxContainer.offsetWidth) / 2) + "px";
	sessionPopupBoxContainer.style.top = "0px";
	sessionPopupBoxContainer.style.visibility = "visible";
	sessionPopupBox.style.top = sessionPopupBox.height * (-1) + "px";
	dropstart = setInterval("dropinv2()", 50);

	var oPatName = document.getElementById("patient");
	if(typeof(oPatName) != 'undefined' && oPatName != null) {
		oPatName.focus();
		oPatName.value = "";
	}
}

function dropinv2() {
	scroll_top = ff ? window.pageYOffset : truebody().scrollTop;
	if(parseInt(sessionPopupBox.style.top) < 0) {
		sessionPopupBoxContainer.style.top = scroll_top + 0 + "px";
		sessionPopupBox.style.top = parseInt(sessionPopupBox.style.top) + 15 + "px";
	}
	else {
		clearInterval(dropstart);
		sessionPopupBox.style.top = 0;
	}
}

function hideSessionPopupBox() {
	if(window.dropstart) {
		clearInterval(dropstart);
	}
	if(typeof(sessionPopupBoxContainer) != 'undefined') {
		sessionPopupBoxContainer.style.visibility = "hidden";
		sessionPopupBox.style.display = "none";
	}
}

function truebody() {
	return (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body;
}

function showAgreementDesc(oObj, iAgrId) {
	return false;
}

function startNewSession(oPatId, oPatName, iEmp) {
	var oPatId = document.getElementById(oPatId).value;

	var iUsr = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
	var oPatName = document.getElementById(oPatName);
	if(cli == "0")
		return false;
	if(oPatName.value.length < 1) {
		alert("Por favor escribe el nombre del paciente.");
		return false;
	}
	if(typeof(cli) == 'undefined' || typeof(oPatId) == 'undefined' || typeof(iUsr) == 'undefined')
		return false;
	if(cli == "1") {
		alert("Por favor selecciona una clinica.");
		return false;
	}
	var sParams = "&cli=" + cli + "&pat=" + oPatId + "&emp=0&usr=" + iUsr;
	var valor = AjaxQuery("POST", "../classes/newSession.php", false, sParams);
	if(typeof(valor) != 'undefined' && valor != null && valor.length > 0 && valor == "OK") {
		location.reload(true);
	} 
	else {
		alert("Error al iniciar sesi\u00f3n. Regres\u00f3: " + valor);
		return false;
	}
}

function showNewPatientDialog(e, oPatName, oPatId) {
	if(typeof(top.rightFrame.mainFrame) == 'undefined') {
		return false;
	}
	top.rightFrame.mainFrame.showNewPatientDialog(oPatName, oPatId);
}

function getDoctor(sessId, sURL, event) {
	if(typeof(sessId) != 'undefined' && sessId != null) {
		var sParams = "&UPD=" + sessId;
		//alert(sParams);
		var drExists = AjaxQuery("POST", "../classes/getDoctor.php", false, sParams);
		//alert(drExists);
		if(typeof(drExists) != null && drExists != "" && drExists == "OK") {
			top.rightFrame.mainFrame.location.href = sURL;
			//location.reload(true);
		}
		else {
			alert("No hay un doctor relacionado con \u00e9sta sesi\u00f3n. Por favor agrega un doctor.");
		}
	}
}

window.onresize = function() {
	var pTable = document.getElementById("pTable");
	pTable.style.width = parseInt(document.body.clientWidth) + "px";
	
	var pTd = document.getElementById("pTd");
	pTd.style.width = parseInt(document.body.clientWidth) - (40 * 2) + "px";
	
	var m = document.getElementById("m");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 2  + "px";
	
	var sessTable = document.getElementById("sessTable");
	sessTable.style.width = parseInt(document.body.clientWidth) - 19 + "px";
	
	var sessHeader = document.getElementById("sessHeader");
	sessHeader.style.width = parseInt(document.body.clientWidth) - 19 + "px";
};

document.oncontextmenu = function() {
	return true;
};