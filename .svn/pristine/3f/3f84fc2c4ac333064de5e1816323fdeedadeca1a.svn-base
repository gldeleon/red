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
		location.href = "companies.php?q=" + q + "&cli=" + cli;
	}
}

function changeCompany(oSelect) {
	if(oSelect.selectedIndex != 0) {
		var com = oSelect.options[oSelect.selectedIndex].value;
		location.href = "companies.php?com=" + com + "&cli=" + cli;
	}
}

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};

document.oncontextmenu = function() {
	return true;
};