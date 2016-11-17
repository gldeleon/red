var ff = document.getElementById && !document.all;

window.onload = function() {
	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8) {
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 34 + "px";
	}
	
	var sessHeader = document.getElementById("sessHeader");
	if(typeof(sessHeader) != 'undefined' && sessHeader != null) {
		sessHeader.style.width = parseInt(document.body.clientWidth) - 19 + "px";
		if(document.all) {
			var sessTable = document.getElementById("sessTable");
			if(typeof(sessTable) != 'undefined' && sessTable != null)
				sessTable.style.width = parseInt(document.body.clientWidth) - 19 + "px";
		}
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

function searchPatient(oTextBox, e) {
	var firedEvt = ff ? e : event;
	if(firedEvt.keyCode == 13) {
		var q = oTextBox.value;
		if(typeof(q) == 'undefined' || q == null)
			return false;
		if(q.length < 1) {
			alert("Escribe un nombre o parte del mismo y presiona Enter para buscar.");
			return false;
		}
		if(q == "%") {
			var bRes = confirm("La b\u00fasqueda que intentas relizar tardar\u00e1 mucho tiempo " +
			"y podr\u00eda provocar un error en el navegador. \u00bfDeseas continuar?");
			if(bRes == false) {
				oTextBox.value = "";
				return false;
			}
		}
		location.href = "patients.php?q=" + q + "&cli=" + cli;
	}
}

function startNewSession(oPatId, iEmp) {
	var iUsr = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
	if(cli == "0")
		return false;
	if(typeof(cli) == 'undefined' || typeof(oPatId) == 'undefined' || typeof(iUsr) == 'undefined')
		return false;
	if(cli == "1") {
		alert("Por favor selecciona una cl\u00ednica.");
		return false;
	}

	var sParams = "&cli=" + cli + "&pat=" + oPatId + "&emp=0&usr=" + iUsr;
	var valor = AjaxQuery("POST", "../classes/newSession.php", false, sParams);
	if(typeof(valor) != 'undefined' && valor != null && valor.length > 0 && valor == "OK") {
		top.rightFrame.mainFrame.location.href = "welcome.php";
		top.rightFrame.bottomFrame.location.reload(true);
	}
	else {
		alert("Error al iniciar sesi\u00f3n. Regres\u00f3: " + valor);
		return false;
	}
}

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};

document.oncontextmenu = function() {
	return true;
};