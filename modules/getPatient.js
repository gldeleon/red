var ff = document.getElementById && !document.all;
var uid;

window.onload = function() {
	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8) {
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 4 + "px";
	}
	uid = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
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

function selectIt(oRadio) {
	oRadio.blur();
}

function openReceipt(rec, reccli, pat) {
	var sParams = "rec=" + rec + "&cli=" + reccli;
    var sURL = "../classes/receipt.php?"+sParams;
    pWindow = window.open(sURL, "winDoc", "width=800, height=600, resizable=yes, status=yes, toolbar=no, menubar=no", true);
    pWindow.focus();
}

function openBudget(bud, budcli, pat) {
	var sURL = "../modules/mod_budget/budget.php?bud=" + bud + "&cli=" + budcli + "&pat=" + pat;
	pWindow = window.open(sURL, "winDoc", "width=800, height=600, resizable=yes, status=yes, toolbar=no, menubar=no", false);
	pWindow.focus();
}

function updatePatient(oList, sPat, ref) {
	var oList = document.getElementById(oList);
	var lastname = document.getElementById("lastname").value;
	var surename = document.getElementById("surename").value;
	var name = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var agreelist = document.getElementById("agreelist");

	if(agreelist.disabled == true) {
		agreelist = "PLAN";
	}
	else {
		agreelist = agreelist.options[agreelist.selectedIndex].value;
	}
	//alert(agreelist);
	var agrval = document.getElementById("agrval").value;
	//alert(agrval);
	if(typeof(sPat) == 'undefined' || sPat == null)
		return false;
	var sRes = "";
	var sParams = "&ln=" + lastname + "&sn=" + surename + "&nm=" + name + "&email=" + email
				+ "&agr=" + agreelist + "&pat=" + sPat + "&agrval=" + agrval + "&uid=" + uid
				+ "&cli=" + cli;
	for(var i = 0; i < oList.options.length; i++) {
		sRes += oList.options[i].text + "*";
	}
	sParams += "&tel=" + sRes;
	//alert(sParams);
	//&ln=VELAZQUEZ&sn=FRIEDERICHSEN&nm=OSCAR DAVID&email=ffff@&agr=54&pat=VEENOSEZFRID&tel=5 - CA*6 - MO*
	var valor = AjaxQuery("POST", "../classes/updatePatient.php", false, sParams);
	//alert(valor);
	if(typeof(valor) != 'undefined' && valor != null) {
		if(valor == "OK") {
			document.location.reload(true);
			if(ref.indexOf("sessions.php") > -1) {
				top.rightFrame.bottomFrame.location.reload(true);
			}
		}
		else if(valor != "OK") {
			alert("Error al modificar los datos del paciente. Devolvio: " + valor);
			return false;
		}
	}
}

function addToList(oList, oTel, sTelType) {
	var oList = document.getElementById(oList);
	var oTel = document.getElementById(oTel);
	var sTelType = document.getElementById(sTelType);
	if(typeof(oList) == 'undefined' || oList == null)
		return false;
	if(typeof(oTel) == 'undefined' || oTel == null)
		return false;
	if(typeof(sTelType) == 'undefined' || sTelType == null)
		return false;
	sTelType = sTelType.options[sTelType.selectedIndex].value;
	var bSelected = ((sTelType == "0") ? false : true);

	if(!bSelected) {
		alert("Selecciona un tipo de telefono.");
		return false;
	}
	var sNumTel = oTel.value.toString().replace(/ /g, "");
	sNumTel = sNumTel.replace(/[()+-]/g, "");
	if(sNumTel.length < 1) {
		alert("Numero telefonico no valido. Por favor verifica.");
		return false;
	}
	bExiste = false;
	for(var i = 0; i < oList.options.length; i++) {
		if(oList.options[i].value == sNumTel) {
			bExiste = true;
			break;
		}
	}
	if(!bExiste) {
		oList.options[oList.options.length] = new Option(oTel.value + " - " + sTelType, sNumTel);
		oTel.value = "";
		sTelType.value = 0;
	} else {
		alert("El numero ya existe.");
		return false;
	}
}

function removeFromList(oList) {
	var oList = document.getElementById(oList);
	if(typeof(oList) == 'undefined' || oList == null)
		return false;
	for(var i = 0; i < oList.options.length; i++) {
		if(oList.options[i].selected) {
			oList.options[i] = null;
			break;
		}
	}
}

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};

document.oncontextmenu = function() {
	return true;
};