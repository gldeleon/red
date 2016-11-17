var ff = document.getElementById && !document.all;

window.onload = function() {
	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8) {
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 5 + "px";
	}
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	var mWin2 = document.getElementById("newPatient");
	if(mWin2 != null && typeof(mWin2) != 'undefined') {
		mWin2.style.left = ((w / 2) - (parseInt(mWin2.offsetWidth) / 2)) + "px";
		mWin2.style.top = "0px";
	}
	mWin2.style.visibility = "hidden";
	deleteMenu();
};

function selectPatient(oListItem, oPatId, oPatName) {
	var oPatId = document.getElementById(oPatId);
	var oPatName = document.getElementById(oPatName);
	if(typeof(oPatId) == 'undefined' || typeof(oPatName) == 'undefined' || oPatId == null || oPatName == null) {
		return false;
	}
	if(typeof(oListItem.id) == 'undefined' || oListItem.id == null) {
		return false;
	}
	oPatId.value = oListItem.id;
	oPatName.value = ff ? oListItem.textContent : oListItem.innerText;
}

function startNewSession(oPatId, oPatName, iEmp, iAgr) {
	var oPatId = document.getElementById(oPatId).value;
	var sParams = "&pat=" + oPatId;
	//alert(sParams);
	var iUsr = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
	var oPatName = document.getElementById(oPatName);
	if(cli == "0") {
		return false;
	}
	if(oPatName.value.length < 1) {
		alert("Por favor selecciona un paciente.");
		return false;
	}
	if(typeof(cli) == 'undefined' || typeof(oPatId) == 'undefined' || typeof(iUsr) == 'undefined') {
		return false;
	}
	if(cli == "1") {
		alert("No puedes iniciar sesion del paciente en esta clinica. Por favor selecciona otra.");
		return false;
	}
	var sParams = "&cli=" + cli + "&pat=" + oPatId + "&emp=0&usr=" + iUsr + "&agr=" + iAgr;
	//alert(sParams);
	var valor = AjaxQuery("POST", "../classes/newSession.php", false, sParams);
	//alert(valor);
	if(typeof(valor) != 'undefined' && valor != null && valor.length > 0 && valor == "OK") {
		top.rightFrame.mainFrame.location.href = "welcome.php?cli=" + cli;
		top.rightFrame.bottomFrame.location.reload(true);
	}
	else {
		alert("Error al iniciar sesion. Regreso: " + valor);
		return false;
	}
}

function setNewVisit(oPatId, oPatName) {
	var oPatId = document.getElementById(oPatId);
	var oPatName = document.getElementById(oPatName);
	if(typeof(oPatId) == 'undefined' || oPatId == null) {
		return false;
	}
	if(typeof(oPatName) == 'undefined' || oPatName == null) {
		return false;
	}
	if(oPatName.value.length < 1 || oPatId.value.length < 1) {
		alert("Por favor selecciona un paciente.");
		return false;
	}
	top.rightFrame.location.href = "schedule.php?cli=" + cli + "&pat=" + oPatId.value;
}

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};

document.oncontextmenu = function() {
	return true;
};