var ff = document.getElementById && !document.all;
var cr = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
var sessionPopupBoxContainer, sessionPopupBox;
var wDiff = ff ? 60 : 70;

window.onload = function() {
	var vstSchedule = document.getElementById("vstSchedule");
	getCliHours(cli, endDate);
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	var sTd;
	for(var i = 0; i < 8; i++) {
		sTd = document.getElementById('[' + i + '][0]');
		if(sTd != null && typeof(sTd) != 'undefined')
			sTd.style.width = parseInt((w - wDiff) / 7) + "px";
		sTd = document.getElementById('[' + i + '][1]');
		if(sTd != null && typeof(sTd) != 'undefined')
			sTd.style.width = parseInt((w - wDiff) / 7) + "px";
	}
	for(var i = 0; i <= 24; i++) {
		sTd = document.getElementById('[0][' + i + ']');
		sTd.style.width = "60px";
	}
	document.getElementById("divHeader").style.width = w + 4 + "px";
//	document.getElementById("divHeader").style.width = "100%";

	if(visitMaxLength == 0) {
		visitMaxLength = 2;
	}
	if(visitLength == 0) {
		visitLength = 1;
	}

	var oContextMenu = document.getElementById("mnuItemList");
	if(typeof(oContextMenu) != 'undefined' && oContextMenu != null) {
		oContextMenu.style.zIndex = visitMaxLength + 1;
	}

	if(pat != "" && cli != "0") {
		var sPos = getVisitPos(today, now);
		var oCell = document.getElementById(sPos);
		if(oCell != null && typeof(oCell) != 'undefined') {
			openNewVisitDialog(null, oCell, false, null, null);
		}
	}
	parent.deleteMenu();
	top.leftFrame.menuBehavior(null, true);
	vstSchedule.style.visibility = "visible";

	/* Llama a la funcion de carga de visitas. */
	setTimeout("loadVisits(" + cli + ")", 10);
};

function showSessionPopupBox(oVisitItem){
	if(cli == "0") {
		return false;
	}
	sessionPopupBoxContainer = document.getElementById("sessionPopupBoxContainer");
	sessionPopupBox = document.getElementById("sessionPopupBox");
	if(typeof(sessionPopupBoxContainer) == 'undefined' || sessionPopupBoxContainer == null) {
		return false;
	}
	if(typeof(sessionPopupBox) == 'undefined' || sessionPopupBox == null) {
		return false;
	}
	var sParams = "&oid=" + oVisitItem.id;
	var valor = AjaxQuery("POST", "../classes/getVisitDescription.php", false, sParams);
	if(typeof(valor) != 'undefined' && valor != null) {
		sessionPopupBox.innerHTML = valor;
	}
	sessionPopupBox.height = sessionPopupBox.offsetHeight;
	sessionPopupBoxContainer.style.height = parseInt(sessionPopupBox.height) + "px";
	sessionPopupBoxContainer.style.left = (parseInt(document.body.clientWidth) / 2) - (parseInt(sessionPopupBoxContainer.offsetWidth) / 2) + "px";
	sessionPopupBoxContainer.style.top = "0px";
	sessionPopupBoxContainer.style.visibility = "visible";
	sessionPopupBox.style.top = sessionPopupBox.height * (-1) + "px";
	dropstart = setInterval("dropinv2()", 50);
}

function dropinv2() {
	var scroll_top = ff ? window.pageYOffset : truebody().scrollTop;
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
	if(typeof(sessionPopupBoxContainer) != 'undefined' && sessionPopupBoxContainer != null) {
		sessionPopupBoxContainer.style.visibility = "hidden";
	}
}

function truebody() {
	return (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body;
}

function getCliHours(cli, ed) {
	var sParams = "&cli=" + cli + "&date=" + ed;
	//alert(sParams);
	var sHourString = AjaxQuery("POST", "../classes/getCliHours.php", false, sParams);
	//alert(sHourString);
	if(typeof(sHourString) == 'undefined' || sHourString == null) {
		return false;
	}
	var iMinHour = 0;
	if(sHourString.length > 0) {
		sArrayDays = sHourString.split("|");
		iTry = 0;
		for(var i = 0; i < sArrayDays.length; i++) {
			sArrayHour = sArrayDays[i].split("*");
			if(sArrayHour[1] != "0") {
				if(iTry == 0) {
					iMinHour = parseInt(sArrayHour[1]);
					iTry++;
				}
				if(parseInt(sArrayHour[1]) < iMinHour) {
					iMinHour = parseInt(sArrayHour[1]);
				}
			}
		}
	}
	var sMinHour = "";
	var j = 0;
	for(var i = 1; i <= 24; i++) {
		var sTd = document.getElementById('[0][' + i + ']');
		if(typeof(sTd) != 'undefined' && sTd != null) {
			j = (i - 1);
			j = (j > 12) ? (j - 12) : ((j == 0) ? 12 : j);
			sMinHour = j.toString();
			if(sMinHour.length < 2) {
				sMinHour = "0" + sMinHour;
			}
			var sAMPMString = " " + (((i - 1) < 12) ? "A" : "P") + "M";
			sTd.innerHTML =  sMinHour + ":" + "00<sup><font style='font-size: 8px;'>" + sAMPMString + "</font></sup>";
		}
	}
	movePosition(iMinHour);
}

function movePosition(iMinHour) {
	var iQty = (ff || cr) ? 0 : 21;
	var xPos = (iMinHour * 40) + iQty;
	window.scrollTo(0, xPos);
}

function treatFilter(oSelect, oTreatList, spcid) {
	oTreatList = document.getElementById(oTreatList);
	if(typeof(oTreatList.options) != 'undefined') {
		for(var i = 0; i < oTreatList.options.length; i++) {
			oTreatList.options[i] = null;
		}
		oTreatList.options.length = 0;
		oTreatList.options[0] = new Option("----", "0");
		if(oSelect != null && typeof(oSelect) != 'undefined') {
			var spId = oSelect.options[oSelect.selectedIndex].value;
		}
		else if(spcid != null && typeof(spcid) != 'undefined') {
			var spId = spcid;
		}
		var sParams = "&sid=" + spId;
		var valor = AjaxQuery("POST", "../classes/getTreatments.php", false, sParams);
		if(typeof(valor) != 'undefined' && valor.length > 0) {
			var txArray = valor.split("*");
			if(typeof(txArray) != 'undefined' && txArray.length > 0) {
				for(var i = 0; i < txArray.length; i++) {
					var txItem = txArray[i].split(",");
					oTreatList.options[i + 1] = new Option(txItem[1], txItem[0]);
				}
			}
		}
	}
}

function loadVisits(cli) {
	if(typeof(cli) == 'undefined' || cli == null) {
		return false;
	}
	var sParams = "&cli=" + cli + "&ini=" + iniDate + "&end=" + endDate;
	//alert(sParams);
	var sVisitMatrix = AjaxQuery("POST", "../classes/getCliVisits.php", false, sParams);
	//alert(sVisitMatrix);
	if(typeof(sVisitMatrix) != 'undefined' && sVisitMatrix.length > 0) {
		if(sVisitMatrix.indexOf("*") > -1) {
			var sVisitItems = sVisitMatrix.split("*");
			//alert(sVisitItems);
			visitMaxLength = sVisitItems.length + 2;
			//alert(sVisitItems.length);
			if(sVisitItems.length > 0) {
				//alert(sVisitItems.length);
				for(var i = 0; i < sVisitItems.length; i++) {
					//alert(sVisitItems);
					//alert(sVisitItems[i]);
					if(sVisitItems[i].indexOf(",") > -1) {
						sVisit = sVisitItems[i].split(",");
						//alert(sVisit);
						//vst_id, vln_len, cli_chairs, emp_abbr, cli_chair, vst_date, vst_ini, vst_descr, vta_color
						//0     , 1      , 2         , 3       , 4        , 5       , 6      , 7        , 8
						//alert(sVisit.toSource());

						if(sVisit.length > 0) {
							//alert(sVisit[8]);
							var oCellDate = sVisit[5];
							var sPos = "";
							if(typeof(getVisitPos) != 'undefined') {
								sPos = getVisitPos(oCellDate, sVisit[6]);
							}
							//alert(sPos);
							var sCellArray = sVisit[6].split(":");
							var oCellHour = parseInt(sCellArray[0], 10);
							var iMinute = parseInt(sCellArray[1], 10);
							//alert(iMinute);
							//alert(sPos);
							oCellHour = oCellHour + "-" + (oCellHour + 1);
							//alert(oCellHour);
							var oCell;
							if(sPos != "") {
								oCell = document.getElementById(sPos);
							}
							//alert(oCell);
							if(typeof(oCell) == 'undefined' || (oCell == null)) {
								return false;
							}
							if(oCell.getAttribute("chour") == oCellHour && oCell.getAttribute("cdate") == oCellDate) {
								//            oVisit(iChair,    iMaxChair, oCell, iMinute, iLength,   iVisitId,  drName,    sDesc,     sColor,    bCalc, iCli,      iPat,       iDr,        iUsr        iAgr
								var foo = new oVisit(sVisit[4], sVisit[2], oCell, iMinute, sVisit[1], sVisit[0], sVisit[3], sVisit[7], sVisit[8], false, sVisit[9], sVisit[10], sVisit[11], sVisit[12], sVisit[13]);
								foo.showVisitItem();
							}
						}
					}
				}
			}
			var oContextMenu = document.getElementById("mnuItemList");
			var oContextDesc = document.getElementById("descPopup");
			if(typeof(oContextMenu) != 'undefined' && oContextMenu != null) {
				oContextMenu.style.zIndex = visitMaxLength + 1;
			}
			if(typeof(oContextDesc) != 'undefined' && oContextDesc != null) {
				oContextDesc.style.zIndex = visitMaxLength;
			}
		}
	}
	//hideLoading();
}

function oVisit(iChair, iMaxChair, oCell, iMinute, iLength, iVisitId, drName, sDesc, sColor, bCalc, iCli, iPat, iDr, iUsr, iAgr) {
	if(typeof(iMaxChair) == 'undefined' || iMaxChair == null)
		return false;
	if(typeof(oCell) == 'undefined' || oCell == null)
		return false;
	if(typeof(iMinute) == 'undefined' || iMinute == null)
		iMinute = 0;
	if(typeof(sDesc) == 'undefined')
		sDesc = "";
	if(typeof(bCalc) == 'undefined')
		bCalc = false;
	if(bCalc)
		iLength = iLength * 0.25;
	iChair = parseInt(iChair, 10);
	if(iChair < 1) iChair = 1;

	//Lista de metodos publicos disponibles para el objeto
	this.showVisitItem = showVisitItem;
	this.createVisitItem = createVisitItem;

	//Metodo que crea el elemento visita
	function createVisitItem() {
		var oVisitItem, sVisitBody, iLeftDiff;

		iLeftDiff = parseInt(((iChair == 1) ? 0 : ((iChair == 3) ? (iChair + 1) : iChair)), 10);
		iMinute = parseInt(iMinute, 10);
		iMinuteConv = parseInt((oCell.offsetHeight) * (iMinute / 60), 10);

		/* Comienza a crear el objeto. */
		oVisitItem = document.createElement("DIV");
		oVisitItem.style.position = "absolute";
		oVisitItem.style.left = oCell.offsetLeft + ((parseInt(oCell.offsetWidth / iMaxChair) - 2) * (iChair - 1)) + iLeftDiff + "px";
		oVisitItem.style.top = oCell.parentNode.offsetTop + 1 + iMinuteConv + "px";
		oVisitItem.style.overflow = "hidden";
		oVisitItem.style.zIndex = visitLength++;
		if(visitMaxLength == visitLength) {
			visitMaxLength++;
		}
		sVisitBody = "<div style='width: 100%\; height: 100%\; cursor: pointer' class='visitMain'>" +
		"<div style='cursor: pointer' class='visitMain'> " + ((typeof(drName) != 'undefined' && drName != null && drName != "") ? drName : "000") + "</div>" +
		"</div>";
		oVisitItem.innerHTML = sVisitBody;
		oVisitItem.style.border = "1px solid #000";
		oVisitItem.style.backgroundColor = sColor;
		oVisitItem.style.backgroundImage = "url('../images/visitbg.png')";
		oVisitItem.style.width = parseInt((oCell.offsetWidth / iMaxChair), 10) - 2 + "px";
		oVisitItem.style.height = parseInt((oCell.offsetHeight * iLength), 10) - 3 + "px";
		if(ff) {
			oVisitItem.style.MozUserSelect = "none";
		}
		oVisitItem.style.cursor = "pointer";

		/** Lista de propiedades publicas disponibles para el objeto. */
		oVisitItem.vtime = iMinute;
		oVisitItem.chair = iChair;
		oVisitItem.length = iLength;
		oVisitItem.drName = drName;
		oVisitItem.title = "";
		oVisitItem.id = '[visit' + iVisitId + ']';
		oVisitItem.name = "VISIT";
		oVisitItem.className = vstStatus[sColor];
		oVisitItem.patId = iPat;
		oVisitItem.drId = iDr;
		oVisitItem.cliId = iCli;
		oVisitItem.usrId = iUsr;
		oVisitItem.vdate = oCell.getAttribute("cdate");

		oVisitItem.changeColor = function(sColor) {
			this.style.backgroundColor = sColor;
			this.className = vstStatus[sColor];
		};
		oVisitItem.oncontextmenu = function(e) {
			showContextualMenu(e, this);
			return false;
		};
		oVisitItem.onclick = function(e) {
			showSessionPopupBox(this);
			return false;
		};

		/** Retorna el objeto. */
		return oVisitItem;
	}

	function showVisitItem() {
		document.body.appendChild(this.createVisitItem());
	}
}

function cancelVisitEdit() {
	var mWin = document.getElementById("newEditWindow");
	if(mWin != null && typeof(mWin) != 'undefined') {
		mWin.style.visibility = "hidden";
	}
	hideAutoComplete();
	if(pat != "" && cli != "0") {
		document.location.href = "fCalendar.php?profile=" + cli + "&showDate=" + showDate;
	}
}

function saveVisit() {
	var visitid = document.getElementById("visitid");
	var empid = document.getElementById("empid");
	var patid = document.getElementById("patid");
	var visitd = document.getElementById("visitd");
	var ihour = document.getElementById("ihour");
	var vlength = document.getElementById("vlength");
	var chair = document.getElementById("chair");
	var desc = document.getElementById("desc");
	var cid = document.getElementById("cid");
	var oCell = document.getElementById(cid.value);
	var mWin = document.getElementById("newEditWindow");
	var cfg = document.getElementById("cfg");
	var uid = ff ? cfg.textContent : cfg.innerText;
	var minute = document.getElementById("iminute");
	var ihour = document.getElementById("ihour");
	var speciality = document.getElementById("speciality");
	var treatment = document.getElementById("treatment");

	if(mWin != null && typeof(mWin) != 'undefined') {
		if(patid.value == "") {
			alert("No se ha ingresado el nombre del paciente.");
			return false;
		}
		if(typeof(oCell) != 'undefined' && oCell !=  null) {
			var bEdit = (visitid.value != "" && visitid.value != "0") ? true : false;
			//alert(bEdit); return;
			var iMinute = minute.options[minute.selectedIndex].value;
			var sParams = "&emp=" + empid.value + "&pat=" + patid.value + "&vd=" + visitd.value +
			"&hini=" + ihour.options[ihour.selectedIndex].value + "&len=" + vlength.options[vlength.selectedIndex].value +
			"&chair=" + chair.options[chair.selectedIndex].value + "&cli=" + cli + "&uid=" + uid + "&desc=" + desc.value +
			"&minute=" + iMinute + "&treat=" + treatment.options[treatment.selectedIndex].value + "*";

			var valor = "";
			if(bEdit) {
				sParams += "&oid=" + visitid.value;
				//alert(sParams); //return;
				valor = AjaxQuery("POST", "../classes/updateVisit.php", false, sParams);
			}
			else if (!bEdit) {
				valor = AjaxQuery("POST", "../classes/newVisit.php", false, sParams);
			}
			//alert(valor);

			if((typeof(valor) != 'undefined') && (valor.length > 0)) {
				if(valor == "ERROR") {
					alert("Se produjo un error al ingresar la cita. Por favor, intenta de nuevo.");
					return false;
				}
				else if(valor == "CHAIR") {
					alert("Ya existe una cita en la fecha, horario y sill\u00f3n seleccionados. " +
					"Por favor selecciona otro sill\u00f3n.");
					return false;
				}
				else if(valor == "EXISTS") {
					alert("Ya existe una cita en la fecha y horario seleccionados. Prueba seleccionando " +
					"otro sill\u00f3n.");
					return false;
				}
				else if (valor.indexOf("*") > -1 && !bEdit) {
					var argV = valor.split("*");
					var foo = new oVisit(chair.value, spaces, oCell, iMinute, vlength.value, argV[0], argV[1], '', vstColor['NORMAL'], true, cli, patid, empid, uid);
					foo.showVisitItem();
					var oContextMenu = document.getElementById("mnuItemList");
					var oContextDesc = document.getElementById("descPopup");
					if(typeof(oContextMenu) != 'undefined' && oContextMenu != null) {
						oContextMenu.style.zIndex = visitMaxLength + 1;
					}
					if(typeof(oContextDesc) != 'undefined' && oContextDesc != null) {
						oContextDesc.style.zIndex = visitMaxLength;
					}
				}
			}
		}
		mWin.style.visibility = "hidden";
		document.location.href = "fCalendar.php?profile=" + cli + "&showDate=" + showDate;
	}
}

function openNewVisitDialog(e, useThisCell, bEdit, sData, sTrtData) {
	var oCell;
	if(e != null && (typeof(useThisCell) == 'undefined' || useThisCell == null)) {
		var firedEvt = ff ? e : event;
		var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
		oCell = firedObj;
	}
	else if(typeof(useThisCell) != 'undefined' && useThisCell != null) {
		oCell = useThisCell;
	}
	if(typeof(bEdit) == 'undefined' || bEdit == null) {
		var bEdit = false;
	}
	if(typeof(sData) == 'undefined' || sData == null) {
		var sData = new Array();
	}
	if(typeof(sTrtData) == 'undefined' || sTrtData == null) {
		var sTrtData = new Array("3","2");
	}
	if(oCell.className != "schedule_avail" && oCell.className != "schedule_session" 
	   && oCell.className != "large") {
		return false;
	}
	
	var sParams = "&date1=" + oCell.getAttribute("cdate") + "&date2=" + today;
	var compVal = AjaxQuery("POST", "../classes/dateCompare.php", false, sParams);
	if(typeof(compVal) != 'undefined' && compVal != null && compVal != false) {
		if(compVal < 0) {
			alert("No puedes agregar una cita en fechas anteriores a la actual.");
			return false;
		}
	}
    var oCellDate = oCell.getAttribute("cdate").split("-");
    var oCellHour = oCell.getAttribute("chour").split("-");
    var newEditWindow = document.getElementById("newEditWindow");
    if(newEditWindow != null && typeof(newEditWindow) != 'undefined') {
		var visitid = document.getElementById("visitid");
		var empid = document.getElementById("empid");
		var patid = document.getElementById("patid");
		var visitd = document.getElementById("visitd");
		var ihour = document.getElementById("ihour");
		var iminute = document.getElementById("iminute");
		var vlength = document.getElementById("vlength");
		var chair = document.getElementById("chair");
		var cid = document.getElementById("cid");
		var doctor = document.getElementById("clidoc");
		var patient = document.getElementById("patient");
		var desc = document.getElementById("desc");
		var spcid = document.getElementById("speciality");
		var trtid = document.getElementById("treatment");
		var w = parseInt(document.body.clientWidth);
		w = ff ? (w - 4) : w;
		if(!bEdit) {
			visitid.value = "0";
			vlength.selectedIndex = 0;
			chair.selectedIndex = 0;
			visitd.value = oCellDate[2] + "/" + oCellDate[1] + "/" + oCellDate[0];
			ihour.value = oCellHour[0];
			iminute.selectedIndex = 0;
			cid.value = oCell.id;
			doctor.value = 0;
			desc.value = "";
			spcid.value = sTrtData[1];
			trtid.value = sTrtData[0];
		}
		else if(bEdit && sData.length > 0) {
			visitid.value = sData[0];
			vlength.value = sData[1];
			patid.value = sData[2];
			empid.value = sData[3];
			chair.value = sData[4];
			visitd.value = oCellDate[2] + "/" + oCellDate[1] + "/" + oCellDate[0];
			oCellHour = sData[6].split(":");
			ihour.value = parseInt(oCellHour[0], 10).toString();
			iminute.value = parseInt(oCellHour[1], 10).toString();
			cid.value = oCell.id;
			patient.value = sData[8];
			doctor.value = sData[3];
			desc.value = sData[7];
			spcid.value = sTrtData[1];
			treatFilter(null, 'treatment', sTrtData[1]);
			trtid.value = sTrtData[0];
		}
		newEditWindow.style.left = ((w / 2) - (parseInt(newEditWindow.offsetWidth) / 2)) + "px";
		newEditWindow.style.top = (ff ? window.pageYOffset : truebody().scrollTop) + (parseInt(newEditWindow.offsetHeight) / 2) - 80 + "px";
		newEditWindow.style.visibility = "visible";
    }
}

function hideContextualMenu() {
	var mnuItemList = document.getElementById("mnuItemList");
	if(typeof(mnuItemList) != 'undefined' && mnuItemList != null) {
		mnuItemList.style.visibility = "hidden";
	}
}

function cellOptions(e) {
	var firedEvt = ff ? e : event;
	var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
	var oCell = firedObj;
	if(typeof(oCell) == 'undefined' || oCell == null || (oCell.id.substr(1, 1) == "0")) {
		return false;
	}
	if(cli == "0") {
		return false;
	}
	var cfg = document.getElementById("cfg");
	var uid = ff ? cfg.textContent : cfg.innerText;
	var sParameters = "&obj=" + firedObj.tagName + "&oid=" + firedObj.id + "&ocls="
					+ firedObj.className + "&vdate=" + firedObj.vdate + "&uid=" + uid
					+ "&cli=" + cli + "&q=1";
	//alert(sParameters);
	var valor = AjaxQuery("POST", "../classes/createContextMenu.php", false, sParameters);
	//alert(valor);
	if(typeof(valor) != 'undefined' && valor != null) {
		if(valor == "OK") {
			openNewVisitDialog(e, null, false, null, null);
		}
		else if(valor == "PRIV") {
			alert("No dispones de suficientes privilegios. Por favor contacta al Coordinador.");
			return false;
		}
	}
}

function showContextualMenu(e, oObj) {
	var firedEvt = ff ? e : event;
	var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
	if(firedObj == null)
		return false;
	if(typeof(oObj) != 'undefined')
		firedObj = oObj;
	if(!firedObj.id || (firedObj.id.substring(0,2) == "[0") || (firedObj.id.substring(0,1) != "[")
	   || (firedObj.tagName == "BODY")) {
	   	return false;
	}
	var cfg = document.getElementById("cfg");
	var uid = ff ? cfg.textContent : cfg.innerText;
	var sParameters = "&obj=" + firedObj.tagName + "&oid=" + firedObj.id + "&ocls="
					+ firedObj.className + "&vdate=" + firedObj.vdate + "&uid=" + uid
					+ "&cli=" + cli;
	//alert(sParameters);
	var valor = AjaxQuery("POST", "../classes/createContextMenu.php", false, sParameters);
	//alert(valor);
	if(typeof(valor) == 'undefined' || valor == null) {
		alert("Error en consulta AJAX. Valor: " + valor);
		return false;
	}
	if(valor.length > 0 && valor != "ERROR") {
		var oDiv = document.getElementById("mnuItemList");
		oDiv.innerHTML = valor;
		var rightedge = ff ? (window.innerWidth - firedEvt.clientX) : (document.body.clientWidth - firedEvt.clientX);
		var bottomedge = ff ? (window.innerHeight - firedEvt.clientY) : (document.body.clientHeight - firedEvt.clientY);
		if(rightedge < oDiv.offsetWidth)
			oDiv.style.left = (ff ? (window.pageXOffset + firedEvt.clientX - oDiv.offsetWidth) : (document.body.scrollLeft + firedEvt.clientX - oDiv.offsetWidth)) + "px";
		else
			oDiv.style.left = (ff ? (window.pageXOffset + firedEvt.clientX) : (document.body.scrollLeft + firedEvt.clientX)) + "px";
		if(bottomedge < oDiv.offsetHeight)
			oDiv.style.top = (ff ? (window.pageYOffset + firedEvt.clientY - oDiv.offsetHeight) : (document.documentElement.scrollTop + firedEvt.clientY - oDiv.offsetHeight)) + "px";
		else
			oDiv.style.top = (ff ? (window.pageYOffset + firedEvt.clientY) : (document.documentElement.scrollTop + firedEvt.clientY)) + "px";
		if(ff) oDiv.style.MozUserSelect = "none";
		oDiv.style.visibility = "visible";
	}
}

function contextMenuActn(sAction, objId, bDisabled) {
	switch(sAction) {
		case "start":
			if(typeof(objId) != 'undefined' && !bDisabled) {
				var oObj = document.getElementById(objId);
				if(typeof(oObj) != 'undefined' && oObj != null) {
					var sParams = "&cli=" + oObj.cliId + "&pat=" + oObj.patId + "&usr=" + oObj.usrId;
					var valor = AjaxQuery("POST", "../classes/newSession.php", false, sParams);
					if(typeof(valor) != 'undefined' && valor != null && valor.length > 0 && valor == "OK") {
						var sParams = "&oid=" + oObj.id + "&act=5";
						var valor = AjaxQuery("POST", "../classes/updVisit.php", false, sParams);
						if(typeof(valor) != 'undefined' && valor != null && valor.length > 0) {
							if(valor == "ERROR") {
								alert("Error al modificar la cita. Regres\u00f3: " + valor);
								return false;
							}
							else if(valor == "OK") {
								oObj.changeColor(vstColor['ASISTIDA']);
							}
						}
						top.rightFrame.location.href = "content.php?profile=" + cli;
					}
					else {
						alert("Error al iniciar sesi\u00f3n. Regres\u00f3: " + valor);
						return false;
					}
				}
			}
			break;
		case "edit":
			if(typeof(objId) != 'undefined' && !bDisabled) {
				var oObj = document.getElementById(objId);
				if(typeof(oObj) != 'undefined' && oObj != null) {
					var cfg = document.getElementById("cfg");
					if(typeof(cfg) != 'undefined' && cfg != null) {
						cfg = ff ? cfg.textContent : cfg.innerText;
					}
					var sParams = "&oid=" + oObj.id;
					var valor = AjaxQuery("POST", "../classes/getVisitDetail.php", false, sParams);
					//alert(valor);
					if(typeof(valor) != 'undefined' && valor != null && valor.length > 0) {
						if(valor.indexOf("*") < 0) {
							return false;
						}
						var sVisitDetail, sVisitTrt;
						if(valor.indexOf("|") > -1) {
							var sVisitDetailMax = valor.split("|");
							sVisitDetail = sVisitDetailMax[0].split("*");
							sVisitTrt = sVisitDetailMax[1].split("-");
						}
						else {
							sVisitDetail = valor.split("*");
						}
						//alert(sVisitDetail);
						var sPos = getVisitPos(sVisitDetail[5], sVisitDetail[6]);
						var oCell = document.getElementById(sPos);
						//alert(oCell);
						openNewVisitDialog(null, oCell, true, sVisitDetail, sVisitTrt);
					}
				}
			}
			break;
		case "confirm":
			if(typeof(objId) != 'undefined' && !bDisabled) {
				var oObj = document.getElementById(objId);
				if(typeof(oObj) != 'undefined' && oObj != null) {
					var sParams = "&oid=" + oObj.id + "&act=2";
					var valor = AjaxQuery("POST", "../classes/updVisit.php", false, sParams);
					if(typeof(valor) != 'undefined' && valor != null && valor.length > 0) {
						if(valor == "ERROR") {
							alert("Error al modificar la cita. Regreso: " + valor);
							return false;
						}
						else if(valor == "OK")
							oObj.changeColor(vstColor['CONFIRMADA']);
					}
				}
			}
			break;
		case "cancel":
			if(typeof(objId) != 'undefined' && !bDisabled) {
				var sRes = confirm("Seguro que deseas cancelar la cita?");
				if(sRes) {
					var oObj = document.getElementById(objId);
					if(typeof(oObj) != 'undefined' && oObj != null) {
						var sParams = "&oid=" + oObj.id + "&act=7";
						var valor = AjaxQuery("POST", "../classes/updVisit.php", false, sParams);
						if(typeof(valor) != 'undefined' && valor != null && valor.length > 0) {
							if(valor == "ERROR") {
								alert("Error al modificar la cita. Regreso: " + valor);
								return false;
							}
							else if(valor == "OK") {
								oObj.changeColor(vstColor['CANCELADA']);
								document.location.reload(true);
							}
						}
					}
				}
			}
			break;
		case "delete":
			if(typeof(objId) != 'undefined' && !bDisabled) {
				var sRes = confirm("Seguro que deseas eliminar la cita?");
				if(sRes) {
					var oObj = document.getElementById(objId);
					if(typeof(oObj) != 'undefined' && oObj != null) {
						var sParams = "&oid=" + oObj.id + "&act=9";
						var valor = AjaxQuery("POST", "../classes/updVisit.php", false, sParams);
						if(typeof(valor) != 'undefined' && valor != null && valor.length > 0) {
							if(valor == "ERROR") {
								alert("Error al modificar la cita. Regreso: " + valor);
								return false;
							}
							else if(valor == "OK") {
								oObj.changeColor(vstColor['ELIMINADA']);
								document.location.reload(true);
							}
						}
					}
				}
			}
			break;
		case "refresh":
			document.location.reload(true);
			break;
	}
}

function setAutoCompleteValue(oField, type) {
	hideAutoComplete();
	var oType = document.getElementById(type);
	if(typeof(oType) != 'undefined' && oType != null) {
		oType.value = ff ? oField.textContent : oField.innerText;
	}
	var oID = (type == "doctor" || type == "clidoc") ? "empid" : (type == "patient") ? "patid" : (type == "recommendation") ? "recid" : "";
	var oObj = document.getElementById(oID);
	if(typeof(oObj) != 'undefined' && oObj != null) {
		oObj.value = oField.id;
	}
	oType.focus();
}

function setInputValue(oField, type) {
	var oID = (type == "doctor" || type == "clidoc") ? "empid" : (type == "patient") ? "patid" : (type == "recommendation") ? "recid" : "";
	var oObj = document.getElementById(oID);
	if(typeof(oObj) != 'undefined' && oObj != null) {
		oObj.value = oField.options[oField.selectedIndex].value;
	}
}

function showAutoComplete(oTextBox, searchType, e) {
	var firedEvt = ff ? e : event;
	var rf = document.getElementById("resFilter");
	if(typeof(rf) == 'undefined' || rf == null)
		return false;
	//alert(firedEvt.keyCode);
	if(firedEvt.keyCode && firedEvt.keyCode == 27) {
		rf.style.visibility = "hidden";
		firedEvt.cancelBubble = true;
	}
	var bShown = false;
	if(oTextBox.value.length > 3) {
		rf.style.left = parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetParent.offsetLeft) +
		+ parseInt(oTextBox.offsetParent.offsetLeft) + parseInt(oTextBox.offsetParent.offsetParent.offsetLeft) + 1 + "px";
		rf.style.top = parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetParent.offsetTop) +
		+ parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetTop) + parseInt(oTextBox.offsetTop) +
		+ parseInt(oTextBox.offsetHeight) + parseInt(oTextBox.offsetParent.offsetTop) - 1 + "px";
		rf.style.width = (oTextBox.offsetWidth - 2) + "px";
		var oTextBox_value = oTextBox.value.replace(/ñ/gi, "n");
		var oTexBoxID = (typeof(searchType) == 'undefined' || searchType == null) ? oTextBox.id : searchType;
		var sParams = "&filter=" + escape(oTextBox_value) + "&type=" + oTexBoxID + "&cli=" + cli;
		var valor = AjaxQuery("POST", "../classes/mFilter.php", false, sParams);
		if(valor.length > 0) {
			bShown = true;
			rf.innerHTML = valor;
		}
		else {
			bShown = false;
		}
	}
	rf.style.visibility = (bShown) ? "visible" : "hidden";
}

/** Se mantiene para efectos de compatibilidad. */
function showAgreementDesc(oObj, iAgrId) {
	return false;
}

function hideAutoComplete() {
	var resFilter = document.getElementById("resFilter");
	if(typeof(resFilter) != 'undefined' && resFilter != null) {
		resFilter.style.visibility = "hidden";
	}
}

function getVisitPos(oCellDate, oCellHour) {
	if(typeof(oCellDate) == 'undefined' || oCellDate == null)
		return false;
	if(typeof(oCellHour) == 'undefined' || oCellHour == null)
		return false;
	if(oCellHour.indexOf(":") < 1)
		return false;
	var sPos = "";
	for(var j = 0; j < fechas.length; j++) {
		if(fechas[j] == oCellDate) {
			sPos = "[" + (j + 1) + "]";
			break;
		}
	}
	var sCellArray = oCellHour.split(":");
	//alert(sCellArray[0]);
	oCellHour = parseInt(sCellArray[0], 10);
	//alert(oCellHour);
	sPos += "[" + (oCellHour + 1) + "]";

	return sPos;
}

function clickEvents(e, ie, arg) {
	var firedEvt = ff ? e : event;
	var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
	firedEvt.cancelBubble = true;
	if((ff && firedEvt.button == 2) || (!ff && ie)) {
		showContextualMenu(e);
	}
	else if(firedEvt.button == 0) {
		hideContextualMenu();
	}
	//alert(firedObj.className);
	if((firedObj.className != "visitMain" && firedObj.className != "sessionPopupBoxItem" &&
		firedObj.className != "visitDescHeader" && firedObj.className != "visitDescItem" &&
		firedObj.id != "sessionPopupBoxContainer" && firedObj.id != "sessionPopupBox") ||
	   (firedObj.className == "" && firedObj.tagName == "BODY")) {
		hideSessionPopupBox();
	}
	parent.deleteMenu();
	top.leftFrame.menuBehavior(null, true);
}

window.onscroll = function(e) {
	var firedEvt = ff ? e : event;
	var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
	var mWin = document.getElementById("newEditWindow");
	if(mWin != null && typeof(mWin) != 'undefined') {
		mWin.style.top = (ff ? window.pageYOffset : truebody().scrollTop) + (parseInt(mWin.offsetHeight) / 2) - 80 + "px";
	}
	var mWin2 = document.getElementById("newPatient");
	if(mWin2 != null && typeof(mWin2) != 'undefined') {
		mWin2.style.top = (ff ? window.pageYOffset : truebody().scrollTop) + (parseInt(mWin2.offsetHeight) / 2) - 120 + "px";
	}
	hideContextualMenu();
	hideAutoComplete();
};

window.onresize = function() {
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	var sTd;
	for(var i = 0; i < 8; i++) {
		sTd = document.getElementById('[' + i + '][0]');
		if(typeof(sTd) != 'undefined' && sTd != null)
			sTd.style.width = parseInt((w - wDiff) / 7) + "px";
		sTd = document.getElementById('[' + i + '][1]');
		if(typeof(sTd) != 'undefined' && sTd != null)
			sTd.style.width = parseInt((w - wDiff) / 7) + "px";
	}
	for(var i = 1; i <= 24; i++) {
		sTd = document.getElementById('[0][' + i + ']');
		if(typeof(sTd) != 'undefined' && sTd != null)
			sTd.style.width = "60px";
	}
};

document.onclick = function(e, arg) {
	clickEvents(e, false, arg);
};

document.oncontextmenu = function(e, arg) {
	return false;
};