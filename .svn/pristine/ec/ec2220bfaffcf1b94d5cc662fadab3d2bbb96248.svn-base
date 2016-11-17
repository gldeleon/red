var ff = document.getElementById && !document.all;

window.onload = function() {
	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8)
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 36 + "px";
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	var mWin2 = document.getElementById("newPatient");
	if(mWin2 != null && typeof(mWin2) != 'undefined') {
		mWin2.style.left = ((w / 2) - (parseInt(mWin2.offsetWidth) / 2)) + "px";
		mWin2.style.top = "0px";
	}
	mWin2.style.visibility = "hidden";
	deleteMenu();
}

function selectDoctor(iDr) {
	var oRadioCol = document.getElementsByTagName("INPUT");
	for(var i = 0; i < oRadioCol.length; i++) {
		if(oRadioCol[i].name != "empid")
			continue;
		if(oRadioCol[i].name == "empid") {
			if(oRadioCol[i].value == iDr) {
				oRadioCol[i].checked = true;
				break;
			}
		}
	}
}

function assignDoctor(upd, cli) {
	if(typeof(upd) == 'undefined' || typeof(cli) == 'undefined')
		return false;
	var oRadioCol = document.getElementsByTagName("INPUT");
	if(typeof(oRadioCol) != 'undefined' && oRadioCol != null) {
		var j = 0;
		var emp = "0";
		for(var i = 0; i < oRadioCol.length; i++) {
			if(oRadioCol[i].type == "radio") {
				j++;
				if(oRadioCol[i].checked) {
					emp = oRadioCol[i].value;
					break;
				}
			}
		}
		if(j == 0) {
			alert("Por favor selecciona un doctor.");
			return false;
		} else if(j > 0 && emp != "0") {
			var sParams = "&cli=" + cli + "&emp=" + emp + "&UPD=" + upd;
			//alert(sParams);
			var valor = AjaxQuery("POST", "../classes/setDoctor.php", false, sParams);
			//alert(valor);
			if(valor != "OK") {
				alert("Error al modificar el Doctor.");
				return false;
			} else if(valor == "OK") {
				top.rightFrame.mainFrame.location.href = "welcome.php";
				top.rightFrame.bottomFrame.location.reload(true);
			}
		}
	}
}

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
}

document.oncontextmenu = function() {
	return true;
}