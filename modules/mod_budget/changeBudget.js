var ff = document.getElementById && !document.all;
var uid;

window.onload = function() {
	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8) {
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 2 + "px";
	}
	uid = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
	var spcDiv = document.getElementById("spcDiv2");
	if(typeof(spcDiv) != 'undefined' && spcDiv != null)
		spcDiv.style.display = "block";
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	var mWin2 = document.getElementById("newPatient");
	if(mWin2 != null && typeof(mWin2) != 'undefined') {
		mWin2.style.left = ((w / 2) - (parseInt(mWin2.offsetWidth) / 2)) + "px";
		mWin2.style.top = "0px";
	}
	mWin2.style.visibility = "hidden";
	deleteMenu();
	var removeBudgetTxBtn = document.getElementById("removeBudgetTxBtn");
	if(typeof(removeBudgetTxBtn) != 'undefined' && removeBudgetTxBtn != null) {
		removeBudgetTxBtn.disabled = true;
		removeBudgetTxBtn.className = "disabled";
	}
};

function openBudget(bud, budcli, pat) {
	var sURL = "budget.php?bud=" + bud + "&cli=" + budcli + "&pat=" + pat;
	pWindow = window.open(sURL, "winDoc", "width=800, height=600, resizable=yes, status=yes, toolbar=no, menubar=no", false);
	pWindow.focus();
}

function selectTextBox(oTextBoxId) {
	var oTextBox = document.getElementById(oTextBoxId);
	oTextBox.select();
}

function getNewBudget(pat) {
	document.location.replace("changeBudget.php?cli=" + cli + "&pat=" + pat + "&agr=" + agr);
}

function changeStage(oSelect, pat, bud) {
	var iStage = oSelect.options[oSelect.selectedIndex].value;
	if(typeof(pat) == 'undefined' || pat == null)
		return false;
	if(typeof(bud) == 'undefined' || bud == null)
		var bud = "0";
	document.location.replace("changeBudget.php?cli=" + cli + "&pat=" + pat + "&stage=" + iStage + "&bud=" + bud + "&agr=" + agr);
}

function getSpecialityTreats(oSelect) {
	var spc = oSelect.options[oSelect.selectedIndex].value;
	var spcLength = oSelect.options.length;
	var maxValue = 0;
	for(var i = 0; i < spcLength; i++) {
		if(parseInt(oSelect.options[i].value) > maxValue)
			maxValue = parseInt(oSelect.options[i].value);
	}
	for(var i = 2; i <= maxValue; i++) {
		var spcDiv = document.getElementById("spcDiv" + i);
		if(typeof(spcDiv) != 'undefined' && spcDiv != null)
			spcDiv.style.display = "none";
	}
	var spcDiv = document.getElementById("spcDiv" + spc);
	if(typeof(spcDiv) != 'undefined' && spcDiv != null) {
		spcDiv.style.display = "block";
	}
}

function selectAllBudgetTreats(oCheckBox, sBudgetTreatCheckBoxName) {
	var oCheckBoxCol = document.getElementsByName(sBudgetTreatCheckBoxName);
	var removeBudgetTxBtn = document.getElementById("removeBudgetTxBtn");
	if(typeof(oCheckBoxCol) != 'undefined' && oCheckBoxCol != null) {
		for(var i = 0; i < oCheckBoxCol.length; i++) {
			oCheckBoxCol[i].checked = oCheckBox.checked;
		}
		if(oCheckBoxCol.length > 0) {
			removeBudgetTxBtn.disabled = !oCheckBox.checked;
			removeBudgetTxBtn.className = (oCheckBox.checked) ? "" : "disabled";
		}
	}
}

function selectThisBudgetTreat(oCheckBox, sBudgetTreatCheckBoxName) {
	var oCheckBoxCol = document.getElementsByName(sBudgetTreatCheckBoxName);
	var removeBudgetTxBtn = document.getElementById("removeBudgetTxBtn");
	var budtx_all = document.getElementById("budtx_all");
	if(typeof(oCheckBoxCol) != 'undefined' && oCheckBoxCol != null) {
		var iCheckBoxChecked = 0;
		for(var i = 0; i < oCheckBoxCol.length; i++) {
			iCheckBoxChecked += oCheckBoxCol[i].checked;
		}
		removeBudgetTxBtn.disabled = !oCheckBox.checked && (iCheckBoxChecked == 0);
		removeBudgetTxBtn.className = (oCheckBox.checked && (iCheckBoxChecked > 0)) ? "" : "disabled";
		budtx_all.checked = (iCheckBoxChecked == oCheckBoxCol.length) ? true : false;
	}
}

function addTreatmentToList(sPatId, iCli, iBud, sSelect, agrId) {
	var oInputCol = document.getElementsByName("bdgtrt");
	var oSelect = document.getElementById(sSelect);
	var iStage = "1";
	var sRes = sPatId + "|" + iCli + "|";
	var j = 0;
	var esNaN = false;
	var sParams = "";

	if(typeof(oSelect) != 'undefined' && oSelect != null) {
		iStage = oSelect.options[oSelect.selectedIndex].value;
		if(iStage == "0") {
			iStage = "1";
		}
	}

	if(typeof(agrId) == 'undefined' || agrId == null) {
		agrId = "0";
	}

	if(typeof(iBud) == 'undefined' || iBud == null) {
		iBud = "0";
	}

	if(typeof(oInputCol) == 'undefined' || oInputCol == null) {
		return false;
	}

	if(typeof(sPatId) == 'undefined' || typeof(iCli) == 'undefined') {
		return false;
	}

	for(var i = 0; i < oInputCol.length; i++) {
		if(isNaN(parseInt(oInputCol[i].value, 10))) {
			esNaN = true;
			break;
		}
		if(oInputCol[i].value != "0") {
			j++;
			sRes += oInputCol[i].id + "=" + oInputCol[i].value + "*";
		}
	}
    
	if(esNaN) {
		alert("Por favor introduce solamente n\u00fameros.");
		for(var i = 0; i < oInputCol.length; i++) {
			oInputCol[i].value = "0";
		}
		return false;
	}

	if(j < 1) {
		alert("Por favor selecciona alg\u00fan tratamiento.");
		return false;
	}

	//alert("Busca TotalDent...");
	sParams = "&string=" + sRes + "&eq=1" + "&agr=" + agrId;
	//alert(sParams);
	var insertParams = sParams + "&cadena=" + iStage + "|" + iBud + "|";
	//alert(insertParams);
	//alert("Ahora va a budget...");
	var budgetList = document.getElementById("budgetList");
	if(typeof(budgetList) != 'undefined' && budgetList != null) {
		sParams = "&string=" + sRes;
		//alert(sParams);
		var valor = AjaxQuery("POST", "getPatientTreatmentPrice.php", false, sParams);
		//alert(valor);
		//return false;
		if(typeof(valor) != 'undefined' && valor != null) {
			if(valor.length > 0) {
				sRes = sPatId + "|" + iCli + "|" + uid + "|" + iStage + "|" + iBud + "|";
				//Ejemplo: 1*3*LIMPIEZA*$70|2*11*RESINA*$168|1*15*CONSULTA*$16
				//1*1*REVISION*$0
				var sTxPriceArray = valor.split("|");
				for(var j = 0; j < sTxPriceArray.length; j++) {
					var valor = sTxPriceArray[j];
					//alert(valor);
					if(valor.length > 0) {
						var sTxArray = valor.split("*");
						var sTxCant = parseInt(sTxArray[0], 10);
						var sTxId = parseInt(sTxArray[1], 10);
						var sTxPrice = parseInt(sTxArray[3], 10);
						sRes += sTxId + "=" + sTxCant + "=" + sTxPrice + "*";
					}
				}
				var sParams = "&string=" + sRes;
				//alert(sParams);
				//&string=CRLAAAUZVAON|12|2|1|25473|3=1=0*
				var valor = AjaxQuery("POST", "setBudget.php", false, sParams);
				//alert(valor);
				if(valor.indexOf("*") > -1) {
					var sResArray = valor.split("*");
					if(sResArray[0] == "OK") {
						var parm = "&ibud=" + iBud + "&pat=" + sPatId;
						document.location.replace("changeBudget.php?cli=" + cli + "&pat=" + sPatId
						+ "&bud=" + sResArray[1] + "&agr=" + agr);
						top.rightFrame.bottomFrame.location.reload(true);
					}
				}
				else {
					alert("Error al asignar presupuesto. Regreso: " + sRes);
					return false;
				}
			} //! if(valor.length > 0)
		}
	}
	for(var i = 0; i < oInputCol.length; i++) {
		oInputCol[i].value = "0";
	}
}

function removeTreatmentFromList(sPatId, iBud, sBudgetTreatCheckBoxName, agrid) {
	if(typeof(sPatId) == 'undefined' || typeof(iBud) == 'undefined')
		return false;
	var oCheckBoxCol = document.getElementsByName(sBudgetTreatCheckBoxName);
	if(typeof(oCheckBoxCol) != 'undefined' && oCheckBoxCol != null) {
		var sRes = sPatId + "|" + cli + "|" + iBud + "|";
		var j = 0;
		for(var i = 0; i < oCheckBoxCol.length; i++) {
			if(oCheckBoxCol[i].checked) {
				sRes += oCheckBoxCol[i].value + "*";
				j++;
			}
		}
		if(j < 1) {
			alert("Por favor selecciona algun tratamiento del presupuesto.");
			return false;
		}
		var sParams = "&agr=" + agrid + "&string=" + sRes ;
		//alert(sParams);
		var sRes = AjaxQuery("POST", "updateBudget.php", false, sParams);
		//alert(sRes);
		if(sRes != "OK") {
			alert("Error al quitar tratamientos del presupuesto.");
		}
		if(sRes == "OK") {
			document.location.replace("changeBudget.php?cli=" + cli + "&pat=" + sPatId + "&bud="
			+ iBud + "&agr=" + agr);
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