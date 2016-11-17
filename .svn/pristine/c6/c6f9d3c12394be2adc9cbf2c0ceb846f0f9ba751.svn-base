/**
 * Determina si el navegador es IE o uno mejor
 * @type {Boolean} ff Por ejemplo, Firefox
 */
var ff = document.getElementById && !document.all;
/**
 * Almacena la clave del usuario
 * @type {Integer} uid
 */
var uid;
var UPD;
var pat;
var rec;

var sLastTab = "";
var sLastColor = "";
var sLastThoot = "";
var sLastPanel = "";
var iSelTxArray = new Array();

var iCntTreats = 0;

var iCurrentTx = 0;

var isTotalDentEvt = false;

/**
 * Funcion que actualiza la tabla de sesiones para establecer la hora de salida
 * del paciente
 * @param {Integer} cli Id de clinica
 * @param {Integer} sid Id de sesion
 */
function exitSession(cli, sid) {
	/**
	 * Guarda la cadena de consulta URL
	 * @type {String} sParams
	 */
	var sParams = "&cli=" + cli + "&sid=" + sid + "&act=exit";
	/**
	 * Obtiene el resultado de la consulta AJAX
	 * @type {String} valor
	 */
	var valor = AjaxQuery("POST", "../../classes/updPatSession.php", false, sParams);
	if(typeof(valor) != 'undefined' && valor != null && valor == "OK") {
		top.rightFrame.location.reload(true);
	}
}

function loadDentalChartTx(act) {
	//cambio hecho por daniel
	var patient = eval("document.getElementById('pat')." + (ff ? "textContent" : "innerText"));
	//alert(patient);
	if(typeof(act) == 'undefined' || act == null) {
		if(sLastPanel == "selDentalChart") {
			act = true;
		}
		else if(sLastPanel == "selHistoricTx") {
			act = false;
		}
		else return false;
	}
	var sParams = "&pat=" + patient + "&cli=" + cli;
	if(act) {
		sParams += "&UPD=" + UPD;
	}
	//alert(sParams);
	var valor = AjaxQuery("POST", sFilePath + "getPatientTx.php", false, sParams);
	//alert(pat);
	if(valor.indexOf("*") > -1) {
		var thtColorArray = valor.split("*");
		thtColorArray.pop();
		for(var i = 0; i < thtColorArray.length; i++) {
			var thtComb = thtColorArray[i].split(",");
			var cThooth = document.getElementById(thtComb[0]);
			var cColor = thtComb[1];
			if(typeof(cThooth) != 'undefined' && cThooth != null) {
				cThooth.style.backgroundColor = cColor;
			}
		}
	}
}

function loadActTxObj() {
	/**
	 * Variable que almacena el objeto actTx, o sea, el contenedor de
	 * tratamientos actuales.
	 * @var {Object} actTx
	 * @type {Object} actTx
	 */
	var actTx = document.getElementById("actTx");
	var treatSessionField = document.getElementById("treatSessionField");
	var actTxHeaderContent = document.getElementById("actTxHeader").innerHTML;
	var oNewTxHeader = document.createElement("DIV");
	oNewTxHeader.id = "actTxHeader";
	oNewTxHeader.innerHTML = actTxHeaderContent;
	while(actTx.hasChildNodes()) {
		actTx.removeChild(actTx.lastChild);
	}
	actTx.appendChild(oNewTxHeader);
	var iTop = 22;

	var sParams = "&UPD=" + UPD + "&pat=" + pat + "&cli=" + cli;
	//alert(sParams);
	var valor = AjaxQuery("POST", "getActualTx.php", false, sParams);
	//alert(valor);
	if(valor == "ERROR") {
		alert("Ha ocurrido un error al obtener la lista de Tratamientos actuales. Regres\u00f3: " + valor);
		return false;
	}
	else if(valor == "EMPTY") {
		treatSessionField.innerHTML = "--";
		return false;
	}
	else if(valor.indexOf("*") > -1) {
		var sTxArray = valor.split("*");
		if(sTxArray.length > 1) {
			iCntTreats = 0;
			for(var i = 0; i < sTxArray.length; i++) {
				if(sTxArray[i] != "") {
					var sTx = sTxArray[i].split(",");
					//alert(sTx.length);
					iCntTreats++;
					var oListTxItem = new createListTxItem(actTx, sTx[6], "actTxItem", iTop,
									  sTx[1], sTx[4], sTx[2], sTx[3], sTx[5]);
					actTx.appendChild(oListTxItem);
					iTop += 21;
				}
			}
			treatSessionField.innerHTML = iCntTreats;
		}
		else {
			treatSessionField.innerHTML = "--";
		}
		return false;
	}
	else return false;
}

function loadPrgTxObj() {
	var prgTx = document.getElementById("prgTx");
	var actTxHeaderContent = document.getElementById("prgTxHeader").innerHTML;
	var oNewTxHeader = document.createElement("DIV");
	oNewTxHeader.id = "prgTxHeader";
	oNewTxHeader.innerHTML = actTxHeaderContent;
	while(prgTx.hasChildNodes()) {
		prgTx.removeChild(prgTx.lastChild);
	}
	prgTx.appendChild(oNewTxHeader);
	var iTop = 22;

	var sParams = "&UPD=" + UPD + "&pat=" + pat + "&cli=" + cli;
	//alert(sParams);
	var valor = AjaxQuery("POST", "getProgramTx.php", false, sParams);
	//alert(valor);
	if(valor == "ERROR") {
		alert("Ha ocurrido un error al obtener la lista de Tratamientos programados. Regres\u00f3: " + valor);
		return false;
	}
	else if(valor == "EMPTY") {
		return false;
	}
	else if(valor.indexOf("*") > -1) {
		var sTxArray = valor.split("*");
		if(sTxArray.length > 1) {
			for(var i = 0; i < sTxArray.length; i++) {
				if(sTxArray[i] != "") {
					var sTx = sTxArray[i].split(",");
					//alert(sTx.length);
					var oListTxItem = new createListTxItem(prgTx, sTx[6], "prgTxItem", iTop,
									  sTx[1], sTx[4], sTx[2], sTx[3], sTx[5], sTx[7]);
					prgTx.appendChild(oListTxItem);
					iTop += 21;
				}
			}
		}
		return false;
	}
	else return false;
}

function createListTxItem(oTxList, oTxListId, oTxListClass, iTop, sTxName, sTxThtId, sTxSess, sTxCpName, sThtName, iTrtId) {

	var oListTx = document.createElement("DIV");
	oListTx.className = oTxListClass;
	oListTx.id = oTxListId;
	oListTx.trtId = iTrtId;
	oListTx.thtId = sTxThtId;
	oListTx.sesTx = sTxSess;
	oListTx.style.top = iTop + "px";

	var oTx = document.createElement("DIV");
	oTx.className = "oListTx_Tx";
	oTx.innerHTML = sTxName;
	oTx.title = sTxCpName;
	oListTx.appendChild(oTx);

	var oTh = document.createElement("DIV");
	oTh.className = "oListTx_Th";
	sTxThtId = (sTxThtId == "") ? "--" : sTxThtId;
	oTh.title = sThtName;
	oTh.innerHTML = sTxThtId;
	oListTx.appendChild(oTh);

	var oSess = document.createElement("DIV");
	oSess.className = "oListTx_Sess";
	oSess.innerHTML = sTxSess;
	oListTx.appendChild(oSess);

	oListTx.onclick = function() {
		if(this.style.backgroundColor == 'rgb(9, 39, 75)') {
			this.style.backgroundColor = "#E5E5E5";
			this.style.color = "#000";
		}
		else {
			this.style.backgroundColor = "#09274B";
			this.style.color = "#FFF";
		}
	};

	oListTx.onmouseover = function() {
		if(this.style.backgroundColor == 'rgb(9, 39, 75)') {
			return false;
		}
		else {
			this.style.backgroundColor = "#ABD9E9";
			this.style.color = "#000";
		}
	};

	oListTx.onmouseout = function() {
		if(this.style.backgroundColor == 'rgb(9, 39, 75)') {
			return false;
		}
		else {
			this.style.backgroundColor = "#E5E5E5";
			this.style.color = "#000";
		}
	};

	return oListTx;
}

function moveTxToProgram() {
	if(rec != "--") {
		return false;
	}
	var actTx = document.getElementById("actTx");
	if(actTx.hasChildNodes()) {
		var aToDelTx = new Array();
		for(var i = 0; i < actTx.childNodes.length; i++) {
			var oListSelectedTx = actTx.childNodes[i];
			if(oListSelectedTx.style.backgroundColor == 'rgb(9, 39, 75)') {
				if(oListSelectedTx.id != "") {
					aToDelTx.push(oListSelectedTx.id);
				}
			}
		}
		if(aToDelTx.length > 0) {
			var sParams = "&string=" + pat + "|" + cli + "|" + UPD + "|";
			for(var i = 0; i < aToDelTx.length; i++) {
				sParams += aToDelTx[i] + "*";
			}
			//alert(sParams);
			var valor = AjaxQuery("POST", "updateTreatment.php", false, sParams);
			//alert(valor);
			if(valor == "ERROR") {
				alert("Hubo un error al mover los tratamientos de la lista. Regres\u00f3: " + valor);
				return false;
			}
			else if(valor == "OK") {
				loadActTxObj();
				loadPrgTxObj();
			}
		}
	}
}

function moveTxToActual() {
	if(rec != "--") {
		return false;
	}
	var prgTx = document.getElementById("prgTx");
	if(prgTx.hasChildNodes()) {
		var aToDelTx = new Array();
		var iDcCount = 0;
		for(var i = 0; i < prgTx.childNodes.length; i++) {
			var oListSelectedTx = prgTx.childNodes[i];
			if(oListSelectedTx.style.backgroundColor == 'rgb(9, 39, 75)') {
				if(oListSelectedTx.trtId != null) {
					//alert(oListSelectedTx.thtId);
					if(oListSelectedTx.thtId == "" || oListSelectedTx.thtId == "--") {
						var sParams = "&trt=" + oListSelectedTx.trtId + "&jcmb=1";
						//alert(sParams);
						var valor = AjaxQuery("POST", "getTrtComb.php", false, sParams);
						//alert(valor);
						if(typeof(valor) != 'undefined' && valor != null && valor != ""
						&& valor != "EMPTY") {
							iDcCount++;
						}
					}
				}
				if(oListSelectedTx.id != "") {
					aToDelTx.push(oListSelectedTx.id);
				}
			}
		}

		if(iDcCount > 0) {
			if(iDcCount == 1) {
				for(var i = 0; i < prgTx.childNodes.length; i++) {
					var oListSelectedTx = prgTx.childNodes[i];
					if(oListSelectedTx.style.backgroundColor == 'rgb(9, 39, 75)') {
						break;
					}
				}
				var sParams = "&trt=" + oListSelectedTx.trtId;
				//alert(sParams);
				var valor = AjaxQuery("POST", "getTrtCategory.php", false, sParams);
				//alert(valor);
				if(typeof(valor) != 'undefined' && valor != null && valor.indexOf(",") > -1) {
					//2,1,1,#FDD017,9,2
					var prgTxArray = valor.split(",");
					if(prgTxArray.length > 0) {
						var oPanel = document.getElementById("dentalSlice");
						if(typeof(oPanel) == 'undefined' || oPanel == null) {
							return false;
						}
						oPanel.style.display = "block";
						var sTxColor = prgTxArray[3];
						var iTxCat = prgTxArray[4];
						getTheet(((iTxCat == 6) ? "INF" : ""), sTxColor, oListSelectedTx.trtId, false, true);
						var oSelTxTable = document.getElementById("dcSelTx");
						var selTreats = new Array();
						selTreats = getCategoryTreats(iTxCat, sTxColor, oListSelectedTx.trtId, agrId);
						if(selTreats != "BUDGET") {
							if(typeof(oSelTxTable) != 'undefined' && oSelTxTable != null) {
								var aTxSessions = oListSelectedTx.sesTx;
								aTxSessions = aTxSessions.replace(/\(/, "");
								aTxSessions = aTxSessions.replace(/\)/, "");
								aTxSessions = aTxSessions.split("/");
								oPanel.showTreatList(oSelTxTable, selTreats, aTxSessions, oListSelectedTx);
							}
						}
					}
				}
				alert("Por favor selecciona \u00f3rgano dentario y superficies.");
				return false;
			}
			else if(iDcCount > 1) {
				alert("Al menos un tratamiento de los seleccionados requiere que " +
					  "selecciones \u00f3rgano dentario y superficies, por favor " +
					  "intenta nuevamente.");
				return false;
			}
		}

		if(aToDelTx.length > 0) {
			var sParams = "&string=" + UPD + "|" + cli + "|" + pat + "|";
			for(var i = 0; i < aToDelTx.length; i++) {
				sParams += aToDelTx[i] + "*";
			}
			//alert(sParams);
			var valor = AjaxQuery("POST", "setSessionProgTreat.php", false, sParams);
			//alert(valor);
			if(valor == "ERROR") {
				alert("Hubo un error al mover los tratamientos de la lista. Regres\u00f3: " + valor);
				return false;
			}
			else if(valor == "OK") {
				loadActTxObj();
				loadPrgTxObj();
			}
		}
	}
}

function deleteSelectedTx() {
	if(rec != "--") {
		return false;
	}
	var actTx = document.getElementById("actTx");
	if(actTx.hasChildNodes()) {
		var aToDelTx = new Array();
		for(var i = 0; i < actTx.childNodes.length; i++) {
			var oListSelectedTx = actTx.childNodes[i];
			if(oListSelectedTx.style.backgroundColor == 'rgb(9, 39, 75)') {
				if(oListSelectedTx.id != "") {
					aToDelTx.push(oListSelectedTx.id);
				}
			}
		}
		if(aToDelTx.length > 0) {
			var sRes = confirm("\u00bfEstas seguro que deseas quitar los tratamientos "
					 + "seleccionados de la lista de TRATAMIENTOS ACTUALES?");
			if(sRes == true) {
				var sParams = "";
				for(var i = 0; i < aToDelTx.length; i++) {
					sParams += "&trs[]=" + aToDelTx[i];
				}
				var valor = AjaxQuery("POST", "delActualTx.php", false, sParams);
				if(valor == "ERROR") {
					alert("Hubo un error al quitar los tratamientos de la lista. Regres\u00f3: " + valor);
					return false;
				}
				else if(valor == "OK") {
					loadActTxObj();
				}
			}
		}
	}

	var prgTx = document.getElementById("prgTx");
	if(prgTx.hasChildNodes()) {
		var aToDelTx = new Array();
		for(var i = 0; i < prgTx.childNodes.length; i++) {
			var oListSelectedTx = prgTx.childNodes[i];
			if(oListSelectedTx.style.backgroundColor == 'rgb(9, 39, 75)') {
				if(oListSelectedTx.id != "") {
					aToDelTx.push(oListSelectedTx.id);
				}
			}
		}
		if(aToDelTx.length > 0) {
			var sRes = confirm("\u00bfEstas seguro que deseas quitar los tratamientos "
					 + "seleccionados de la lista de TRATAMIENTOS PROGRAMADOS?");
			if(sRes == true) {
				var sParams = "";
				for(var i = 0; i < aToDelTx.length; i++) {
					sParams += "&tpg[]=" + aToDelTx[i];
				}
				//alert(sParams);
				var valor = AjaxQuery("POST", "delProgramTx.php", false, sParams);
				//alert(valor);
				if(valor == "ERROR") {
					alert("Hubo un error al quitar los tratamientos de la lista. Regres\u00f3: " + valor);
					return false;
				}
				else {
					loadPrgTxObj();
				}
			}
		}
	}
}

/**
 * Muestra/oculta el odontograma dependiendo de la categoria seleccionada
 * @param {Object} oListItem Objeto que manda llamar a la funcion.
 * @param {Integer} catId Categoria de tratamientos.
 * @param {String} sColor Color de la categoria.
 * @param {Integer} trtId Id de tratamiento.
 * @param {String} trtName Nombre del tratamiento.
 * @return {Boolean}
 */
function getCategoryScheme(oListItem, catId, sColor, trtId, trtName) {
	sLastThoot = "";
	/**
	 * Variable que determina si se muestra o no el odontograma
	 * @type {Boolean} showDentalChart
	 */
	var showDentalChart = false;
	if(typeof(sColor) != 'undefined' && sColor != null && sColor != "#FFFFFF") {
		showDentalChart = true;
	}
	if(typeof(trtName) == 'undefined' || trtName == null) {
		trtName = "----";
	}
	var sTitle = "";
	if(oListItem != null) {
		if(oListItem.className == "cat_tx_list") {
			var oList = oListItem.offsetParent;
			oList.style.visibility = "hidden";
		}
		sTitle = eval("oListItem." + (ff ? "textContent" : "innerText"));
		sTitle = sTitle.replace(/^\s+|\s+$/g, '');
	}
	else if(oListItem == null) {
		sTitle = "Presupuesto";
		oListItem = document.getElementById("selBudget");
	}
	//alert(sTitle);
	var txTitle = document.getElementById(((sColor == "#FFFFFF" || sTitle == "Presupuesto")
	? "catTxTitle" : "dcAvalTxTitle"));
	if(typeof(txTitle) != 'undefined' && txTitle != null) {
		txTitle.innerHTML = "Tratamientos " + ((sTitle == "Presupuesto") ? "presupuestados" :
		"disponibles de la Categor&iacute;a \"" + sTitle + "\"");
	}

	//*** Obtiene la referencia a los objetos a usar.
	var dentalChartPanel = document.getElementById("dentalChartPanel");
	var txListPanel = document.getElementById("txListPanel");
	var dentalSlice = document.getElementById("dentalSlice");

	if(typeof(dentalSlice) != 'undefined' && dentalSlice != null) {
		dentalSlice.style.display = "none";
	}

	//*** Determina que panel debe mostrarse.
	dentalChartPanel.style.display = showDentalChart ? "block" : "none";
	if(typeof(txListPanel) != 'undefined' && txListPanel != null) {
		txListPanel.style.display = showDentalChart ? "none" : "block";
	}

	var tx_comb = document.getElementById("tx_comb");
	if(typeof(tx_comb) != 'undefined' && tx_comb != null) {
		tx_comb.innerHTML = trtName;
	}

	/**
	 * Variable que identifica el tipo de panel a mostrar, ya se el odontograma
	 * o bien la lista de tratamientos.
	 * @type {Object} oPanel
	 */
	var oPanel = showDentalChart ? dentalChartPanel : txListPanel;
	/**
	 * Funcion que crea y muestra objetos div como una lista de tratamientos.
	 * @param {Object} oTable Tabla contenedora de la lista.
	 * @param {Array} aTreats Arreglo con los tratamientos.
	 * @return {Boolean}
	 */
	HTMLElement.prototype.showTreatList = function(oTable, aTreats, aTxSessions, oCaller) {
		if(oTable.childNodes.length > 0) {
			for(var i = oTable.childNodes.length - 1; i >= 0; i--) {
				var oTableChild = oTable.childNodes[i];
				if(oTableChild.id != 'undefined' && oTableChild.id != "catTxTitle"
				&& oTableChild.id != "dcAvalTxTitle" && oTableChild.id != "dcSelTxTitle") {
					oTable.removeChild(oTable.childNodes[i]);
				}
			}
		}
		if(typeof(aTxSessions) == 'undefined' || aTxSessions == null) {
			var aTxSessions = new Array("", "");
		}
		/**
		 * Variable que almacena el valor de la altura de las "filas"
		 * @type {Integer} oTrTop
		 */
		var oTrTop = 20;

		for(var i = 0; i < aTreats.length; i++) {

			var oTx = aTreats[i].split(",");
			/**
			 * Variable que almacena el objeto "fila" creado.
			 * @type {Object} oTr
			 */
			var oTr = document.createElement("DIV");
			oTr.className = "txListTr";
			oTr.style.top = oTrTop + "px";
			oTr.id = oTx[0];
			oTr.trtName = oTx[1];
			oTr.txColor = oTx[6];
			oTr.txCategory = oTx[8];
			/** ################## Begin: Cambios para TotalDent */
			oTr.thtCid = oTx[10];
			oTr.trtComb = oTx[11];
			oTr.thtClass = oTx[12];
			oTr.thtVPos = oTx[13];
			oTr.thtZPos = oTx[14];
			oTr.trtGTOId = oTx[15];
			oTr.ttdGTO = oTx[16];
			oTr.iniAuth = oTx[17];
			oTr.btrId = oTx[18];
			oTr.budNumber = oTx[19];
			oTr.cliId = oTx[20];
			oTr.trpPrice = oTx[21];
			oTr.agtDiscount = oTx[22];
			oTr.trsAmount = oTx[23];
			/** ################## End: Cambios para TotalDent */

			var isTooth = (oTr.thtCid == null || oTr.thtCid == 0) ? 1 : 0;

			if(oTx[6] != "#FFFFFF") {
				oTr.style.backgroundColor = oTx[6];
				if(isTooth == 1) {
					oTr.mustRequireTooth = true;
				}
				else {
				    oTr.mustRequireTooth = false;
				}
			}
			else {
				oTr.style.backgroundColor = "#D0D0D0";
				oTr.mustRequireTooth = false;
			}
			/**
			 * Variable que almacena el objeto "celda" en la primera posicion del
			 * objeto "fila". Nombre del tratamiento.
			 * @type {Object} oTd1
			 */

			var oTd1 = document.createElement("DIV");
			oTd1.className = "txListTd1";
            if(agrId == "148" || agrId == "147" || agrId == "183"){
                oTd1.innerHTML = oTx[1] + " (" + oTx[10] + ") ";
            }else{
                oTd1.innerHTML = oTx[1];
            }
			oTd1.style.color = oTx[7];
			oTd1.onclick = function() {
				tx_comb.innerHTML = this.offsetParent.trtName;
				iCurrentTx = this.offsetParent.id;
				iSelTxArray = new Array(this.offsetParent.id, this.offsetParent.txColor);
			};
			oTr.appendChild(oTd1);
			/**
			 * Variable que almacena el objeto "celda" en la segunda posicion del
			 * objeto "fila". Sesiones del tratamiento.
			 * @type {Object} oTd2
			 */
			var oTd2 = document.createElement("DIV");
			oTd2.className = "txListTd2";
			oTd2.innerHTML = "(" + ((aTxSessions[1] != "") ? aTxSessions[1] : oTx[4]) + " ses)";
			oTd2.style.color = oTx[7];
			oTd2.minSess = oTx[4];
			oTd2.maxSess = oTx[9];
			if(oTx[9] > 1 && aTxSessions[1] == "") {
				oTd2.onclick = function(e) {
					tx_comb.innerHTML = this.offsetParent.trtName;
					var firedObj = ff ? e.target : event.srcElement;
					if(firedObj.tagName == "DIV") {
						showTxSessTextBox(this, this.minSess, this.maxSess);
					}
					iSelTxArray = new Array(this.offsetParent.id, this.offsetParent.txColor);
				};
			}
			else {
				oTd2.onclick = function() {
					tx_comb.innerHTML = this.offsetParent.trtName;
					iSelTxArray = new Array(this.offsetParent.id, this.offsetParent.txColor);
				};
			}
			oTr.appendChild(oTd2);
			/**
			 * Variable que almacena el objeto "celda" en la tercera posicion del
			 * objeto "fila".
			 * @type {Object} oTd3
			 */
			var oTd3 = document.createElement("DIV");
			oTd3.className = "txListTd3";
			var oImg1 = document.createElement("IMG");
			oImg1.minSess = oTx[4];
			oImg1.maxSess = oTx[9];
			if(oTx[4] < oTx[9] && oTx[9] > 1 && aTxSessions[1] == "") {
				oImg1.src = "images/add_1.png";
				oImg1.title = "Agregar sesi\u00f3n";
				oImg1.onclick = function() {
					tx_comb.innerHTML = this.offsetParent.offsetParent.trtName;
					/**
					 * Variable que almacena el objeto "celda" donde se muestra el
					 * numero maximo de sesiones para el tratamiento.
					 * @type {Object} oTxSess
					 */
					var oTxSess = this.offsetParent.offsetParent.childNodes[1];
					modifyTxSessions(oTxSess, this.minSess, this.maxSess, "+");
					iSelTxArray = new Array(this.offsetParent.offsetParent.id, this.offsetParent.offsetParent.txColor);
				};
			}
			else if(oTx[4] == oTx[9] || oTx[9] == 1 || aTxSessions[1] != "") {
				oImg1.src = "images/add_1_dis.png";
				oImg1.style.cursor = "default";
				oImg1.onclick = function() {
					tx_comb.innerHTML = this.offsetParent.offsetParent.trtName;
					iSelTxArray = new Array(this.offsetParent.offsetParent.id, this.offsetParent.offsetParent.txColor);
				};
			}
			oTd3.appendChild(oImg1);
			oTr.appendChild(oTd3);
			/**
			 * Variable que almacena el objeto "celda" en la cuarta posicion del
			 * objeto "fila".
			 * @type {Object} oTd4
			 */
			var oTd4 = document.createElement("DIV");
			oTd4.className = "txListTd4";
			var oImg2 = document.createElement("IMG");
			oImg2.minSess = oTx[4];
			oImg2.maxSess = oTx[9];
			if(oTx[4] < oTx[9] && oTx[9] > 1 && aTxSessions[1] == "") {
				oImg2.src = "images/substr_1.png";
				oImg2.title = "Quitar sesi\u00f3n";
				oImg2.onclick = function() {
					tx_comb.innerHTML = this.offsetParent.offsetParent.trtName;
					/**
					 * Variable que almacena el objeto "celda" donde se muestra el
					 * numero maximo de sesiones para el tratamiento.
					 * @type {Object} oTxSess
					 */
					var oTxSess = this.offsetParent.offsetParent.childNodes[1];
					modifyTxSessions(oTxSess, this.minSess, this.maxSess, "-");
					iSelTxArray = new Array(this.offsetParent.offsetParent.id, this.offsetParent.offsetParent.txColor);
				};
			}
			else if(oTx[4] == oTx[9] || oTx[9] == 1 || aTxSessions[1] != "") {
				oImg2.src = "images/substr_1_dis.png";
				oImg2.style.cursor = "default";
				oImg2.onclick = function() {
					tx_comb.innerHTML = this.offsetParent.offsetParent.trtName;
					iSelTxArray = new Array(this.offsetParent.offsetParent.id, this.offsetParent.offsetParent.txColor);
				};
			}
			oTd4.appendChild(oImg2);
			oTr.appendChild(oTd4);
			/**
			 * Variable que almacena el objeto "celda" en la quinta posicion del
			 * objeto "fila".
			 * @type {Object} oTd5
			 */
			var oTd5 = document.createElement("DIV");
			oTd5.className = "txListTd5";
			var oImg3 = document.createElement("IMG");
			oImg3.src = "images/arrowtx.png";
			oImg3.title = "Agregar a tratamientos actuales";
			oImg3.tag = oTx[4];
			oImg3.onclick = function(imgClickRes) {
				//alert("algoooooooooooooooooo");
				var adlclass = document.getElementById("adlclass");
				var infclass = document.getElementById("infclass");
				var thtclass = "ADL";
				if(typeof(adlclass) != 'undefined' && typeof(infclass) != 'undefined') {
					thtclass = (adlclass.style.backgroundColor == 'rgb(171, 217, 233)') ? "ADL" :
					((infclass.style.backgroundColor == 'rgb(171, 217, 233)') ? "INF" : "");
				}
				tx_comb.innerHTML = this.offsetParent.offsetParent.trtName;
				iSelTxArray = new Array(this.offsetParent.offsetParent.id, this.offsetParent.offsetParent.txColor);
				if(rec != "--" && rec != "0") {
					return false;
				}
				var iTxId = this.offsetParent.offsetParent.id;
				//alert(iTxId);
				/**
				 * Variable que almacena el objeto "celda" donde se muestra el
				 * numero maximo de sesiones para el tratamiento.
				 * @type {Object} oTxSess
				 */
				var oTxSess = this.offsetParent.offsetParent.childNodes[1];
				var iNumSess = getCellValue(oTxSess);

				var forceRequireTooth = true;
				var cameFromBudget = this.offsetParent.offsetParent.budNumber != "" && this.offsetParent.offsetParent.btrId != "";
				//alert("cameFromBudget=" + cameFromBudget);
				//alert(forceRequireTooth);
				if(this.offsetParent.offsetParent.mustRequireTooth == true) {
					if(sLastThoot != "") {
						var oLastThoot = document.getElementById(sLastThoot);
						if(typeof(oLastThoot) != 'undefined' && oLastThoot != null) {
							var cSections = getColoredSections(oLastThoot);
							if(cSections && cSections.indexOf("*") > -1) {
								var aSections = cSections.split("*");
								if(aSections.length > 1) {
									//&string=97288|17|DEESALDOTOIA|ADL|11=1=1=1=35=5*
									var sParams = "&string=" + UPD + "|" + cli + "|" + pat + "|" + thtclass
												+ "|" + iTxId + "=1=" + iNumSess + "="
												+ ((aTxSessions[0] == "") ? "1" : aTxSessions[0]) + "="
												+ aSections[0] + "=";
									aSections.shift();
									if(aSections[aSections.length - 1] == "") {
										aSections.pop();
									}
									aSections.sort();
									sParams += aSections.toString() + "*";
									//alert(sParams);
								}
							}
						}
					}
					else {
						if(oPanel.id != "dentalChartPanel") {
							document.getElementById("dentalSlice").style.display = "block";
							var iTxCat = this.offsetParent.offsetParent.txCategory;
							//alert("CAT=" + iTxCat + "<");
							var sTxColor = this.offsetParent.offsetParent.txColor;
							getTheet(((iTxCat == 6) ? "INF" : ""), sTxColor, iTxId, false, true);
							var oSelTxTable = document.getElementById("dcSelTx");
							var selTreats = new Array();
							selTreats = getCategoryTreats(iTxCat, sTxColor, this.offsetParent.offsetParent.id, agrId, this.offsetParent.offsetParent.btrId);
							if(selTreats != "BUDGET") {
								if(typeof(oSelTxTable) != 'undefined' && oSelTxTable != null) {
									oPanel.showTreatList(oSelTxTable, selTreats);
								}
							}
						}
						alert("Por favor selecciona \u00f3rgano dentario y superficies.");
						return false;
					}
				}
				else {
					//alert("forceRequireTooth="+forceRequireTooth);
					if(forceRequireTooth) {
						var sParams = "&string=" + UPD + "|" + cli + "|" + pat + "|" + thtclass
								   	+ "|" + iTxId + "=1=" + iNumSess + "=1=0=*";
					}
					//alert("NoRequiereTooth="+sParams);
				}

				var budNumber = this.offsetParent.offsetParent.budNumber;
				sParams += "&cadena=0|" + budNumber + "||";
				//alert("SETST= " + sParams);
				//alert(AjaxQuery);
				var valor = AjaxQuery("POST", "setSessionTreat.php", false, sParams);
				//alert(valor);
				if(valor != "OK") {
					alert("Ha ocurrido un error al asignar el tratamiento seleccionado. Regres\u00f3: " + valor);
					return false;
				}
				else if(valor == "OK") {
					loadActTxObj();
					getCategoryScheme(null, catId, sColor, trtId, trtName);
					if(typeof(oCaller) != 'undefined' && oCaller != null) {
						var sParams = "&tpg[]=" + oCaller.id + "&txs=" + aTxSessions[0] + "&txsm=" + aTxSessions[1];
						//alert(sParams);
						var valor = AjaxQuery("POST", "delProgramTx.php", false, sParams);
						//alert(valor);
					}
					loadPrgTxObj();
				}
			}; // !oImg3.onclick
			oTd5.appendChild(oImg3);
			oTr.appendChild(oTd5);

			oTable.appendChild(oTr);
			oTrTop += 19;
		}
		oTable.style.height = oTrTop + "px";
		oTable.offsetParent.style.height = ((oPanel.id == "dentalChartPanel") ? 423 : 300) + "px";

		if(typeof(oList) != 'undefined' && oList != null) {
			oList.style.visibility = "visible";
		}
		return true;
	};

	/**
	 * Function que obtiene el valor entero numerico de un objeto "celda".
	 * @param {Object} oCell
	 * @return {Integer}
	 */
	function getCellValue(oCell) {
		/**
		 * Variable que almacena el valor del objeto oCell, ya sea un DIV,
		 * una celda TD, un campo de texto o una lista desplegable.
		 * @type {String} sCellValue
		 */
		var sCellValue = (oCell.tagName == "DIV" || oCell.tagName == "TD") ? oCell.innerHTML : ((
						  oCell.tagName == "INPUT" && oCell.type == "text") ? oCell.value :
						  oCell.options[oCell.selectedIndex].value);
		sCellValue = sCellValue.replace(/([a-z ]+)/g, "");
		sCellValue = sCellValue.replace(/\(/g, "");
		sCellValue = sCellValue.replace(/\)/g, "");
		/**
		 * Variable que almacena el valor entero de la variable sCellValue
		 * (contenido del objeto oCell)
		 * @type {Integer} iVal
		 */
		var iVal = parseInt(sCellValue, 10);
		if(isNaN(iVal)) {
			iVal = 0;
		}

		return iVal;
	}

	/**
	 * Funcion que toma el valor de un objeto y lo descompone para finalmente
	 * sumarle o restarle y modificar dicho valor del objeto.
	 * @param {Object} oCell
	 * @param {Integer} iMaxTxSess
	 * @param {String} sOp (Opcional)
	 * @param {Integer} iPropVal Valor propuesto para la celda, obligatorio si sOp no esta definido.
	 * @return {Boolean}
	 */
	function modifyTxSessions(oCell, iMinTxSess, iMaxTxSess, sOp, iPropVal) {
		/**
		 * Variable que almacena el valor obtenido de la funcion getCellValue
		 * (contenido del objeto oCell)
		 * @type {Integer} iVal
		 */
		var iVal = getCellValue(oCell);
		if(typeof(sOp) == 'undefined' || sOp == null) {
			sOp = "";
		}
		if(typeof(iPropVal) == 'undefined' || iPropVal == null || iPropVal < iMinTxSess) {
			iPropVal = iMinTxSess;
		}
		if(iPropVal > iMaxTxSess) {
			iPropVal = iMaxTxSess;
		}
		if(sOp == "+") {
			if((iVal + 1) <= iMaxTxSess) {
				oCell.innerHTML = "(" + (iVal + 1) + " ses)";
			}
			else {
				//alert("El numero maximo de sesiones establecido para este tratamiento es " + iMaxTxSess + ".");
				return false;
			}
		}
		else if(sOp == "-") {
			if((iVal - 1) >= iMinTxSess) {
				oCell.innerHTML = "(" + (iVal - 1) + " ses)";
			}
			else {
				return false;
			}
		}
		else if(sOp == "") {
			oCell.innerHTML = "(" + iPropVal + " ses)";
		}

		return true;
	}

	/**
	 * Funcion que muestra un campo de texto en lugar de solo texto. Util
	 * para minimizar el numero de clics para decrementar o aumentar el
	 * numero de sesiones de oCell.
	 * @param {Object} oCell
	 * @param {Integer} iMaxTxSess
	 * @return {Boolean}
	 */
	function showTxSessTextBox(oCell, iMinTxSess, iMaxTxSess) {
		var sCellValue = oCell.innerHTML;
		oCell.innerHTML = "";
		var oTextBox = document.createElement("INPUT");
		oTextBox.type = "text";
		oTextBox.id = "txt" + oCell.offsetParent.id;
		oTextBox.onfocus = function() {
			this.select();
		};
		oTextBox.onkeydown = function(e) {
			var keyCode = ff ? e.keyCode : event.keyCode;
			if(keyCode > 31 && (keyCode < 48 || keyCode > 57)) {
				return false;
			}
			else if(keyCode == 13 || keyCode == 27 || keyCode == 9) {
				/**
				 * Variable que almacena el valor obtenido de la funcion getCellValue
				 * (contenido del objeto oCell)
				 * @type {Integer} iVal
				 */
				var iVal = getCellValue(oTextBox);
				oCell.removeChild(oTextBox);
				if(keyCode == 13 || keyCode == 9) {
					modifyTxSessions(oCell, iMinTxSess, iMaxTxSess, "", iVal);
				}
				else if(keyCode == 27) {
					oCell.innerHTML = sCellValue;
				}
			}
			return true;
		};
		oTextBox.onblur = function() {
			/**
			 * Variable que almacena el valor obtenido de la funcion getCellValue
			 * (contenido del objeto oCell)
			 * @type {Integer} iVal
			 */
			var iVal = getCellValue(oTextBox);
			oCell.removeChild(oTextBox);
			modifyTxSessions(oCell, iMinTxSess, iMaxTxSess, "", iVal);
		};
		oCell.appendChild(oTextBox);
		oTextBox.focus();
	} //*** end: function showTxSessTextBox()

	var budgetList = document.getElementById("budgetList");
	if(typeof(budgetList) != 'undefined' && budgetList != null) {
		budgetList.style.display = "none";
	}

	if(showDentalChart) {
		getTheet(((catId == 6) ? "INF" : ""), sColor, trtId, false);
		sLastColor = sColor;
	}

	if(typeof(oListItem) != 'undefined' && oListItem != null &&
	(oListItem.id == "selDentalChart" || oListItem.id == "selHistoricTx")) {
		var actTxDental = (oListItem.id == "selDentalChart") ? true : false;
		loadDentalChartTx(actTxDental);
	}

	/**
	 * Variable que almacena el tipo de lista donde se mostraran los
	 * tratamientos disponibles.
	 * @type {String} txTable
	 */
	var txTable = showDentalChart ? "dcAvalTx" : "catTx";
	/**
	 * Variable que almacena el objeto "tabla" donde se mostraran los
	 * tratamientos disponibles. Usa txTable como base.
	 * @type {Object} oTable
	 */
	var oTable = document.getElementById(txTable);
	if(typeof(oTable) != 'undefined' && oTable != null) {
		oTable.style.visibility = (sColor == "#123456") ? "hidden" : "visible";
	}

	if(typeof(oListItem) != 'undefined' && oListItem != null &&
	(oListItem.id == "selDentalChart" || oListItem.id == "selBudget" || oListItem.id == "selHistoricTx")) {
		oListItem.style.backgroundColor = "#ABD9E9";
		oListItem.style.color = "#084C9D";
		sLastPanel = oListItem.id;
	}

	if(sLastPanel == "selDentalChart" || sLastPanel == "selBudget" || sLastPanel == "selHistoricTx") {
		oLastPanel = document.getElementById(sLastPanel);
		oLastPanel.style.backgroundColor = "#084C9D";
		oLastPanel.style.color = "#FFFFFF";
	}


	if(sColor == "#123456") {
		oPanel.style.height = "330px";
		return false;
	}
	/**
	 * Arreglo con los tratamientos de la categoria
	 * @type {Array} aTreats
	 */
	var aTreats = new Array();
	aTreats = getCategoryTreats(catId, sColor, trtId, agrId);
	if(aTreats != "BUDGET") {
		if(typeof(oTable) != 'undefined' && oTable != null) {
			oPanel.showTreatList(oTable, aTreats);
		}
	}
	else if(aTreats == "BUDGET") {
		oTable.style.visibility = "hidden";
		budgetList.style.display = "block";
		oPanel.style.height = "330px";
	}

	return true;
}

/**
 * Funcion que obtiene una lista de tratamientos de acuerdo con la
 * categoria que se haya seleccionado. Si se agrega el parametro sColor
 * hace un filtro en los tratamientos. El parametro trtId indica que
 * solamente debe devolver la informacion de ese tratamiento.
 * @param {Integer} catId
 * @param {String} sColor Filtro de color
 * @param {Integer} trtId Clave de tratamiento
 * @return {Array|Boolean}
 */
function getCategoryTreats(catId, sColor, trtId, agrId, btrId) {
	if(typeof(catId) != 'undefined' && catId != null) {
		if(typeof(sColor) == 'undefined' || sColor == null) {
			sColor = "0";
		}
		if(typeof(trtId) == 'undefined' || trtId == null) {
			trtId = "0";
		}
		if(typeof(btrId) == 'undefined' || btrId == null) {
			btrId = "0";
		}
		/**
		 * Guarda la cadena de consulta URL
		 * @type {String} sParams
		 */
		var sParams = "&cat=" + catId + "&color=0&trt=" + trtId + "&pat=" + pat + "&agr=" + agrId
					+ "&btr=" + btrId;
		//alert("getCategoryTreats=SPARAMS " + sParams);
		/**
		 * Obtiene el resultado de la consulta AJAX
		 * @type {String} valor
		 */
		var valor = AjaxQuery("POST", "getCategoryTreat.php", false, sParams);
		//alert("getCategoryTreats=VALOR " + valor);
		if(valor != null && valor.toString().length > 0 && valor.toString().indexOf("*") > -1) {
			var txArray = valor.split("*");
			txArray.pop();
			return txArray;
		}
		else if(valor == "ERROR") {
			alert("No se pudo recuperar la lista de tratamientos. Regres\u00f3: " + valor);
			return false;
		}
		else if(valor == "BUDGET") {
			return "BUDGET";
		}
	}
	return false;
}

function getTheet(sTheetClass, sColor, trtId, loadTx, showOnSlice) {
	if(!removeTheet(showOnSlice)) {
		return false;
	}
	if(typeof(sTheetClass) == 'undefined' || sTheetClass == null || sTheetClass == "") {
		sTheetClass = "ADL";
	}
	if(typeof(sColor) == 'undefined' || sColor == null) {
		if(sLastColor != "") {
			sColor = sLastColor;
		}
	}
	if(typeof(showOnSlice) == 'undefined' || showOnSlice == null) {
		showOnSlice = false;
	}
	var sTab;
	if(sLastTab.length > 0) {
		sTab = document.getElementById(sLastTab);
		if(typeof(sTab) != 'undefined' && sTab != null) {
			sTab.style.backgroundColor = "#FFF";
		}
	}
	sTab = document.getElementById(sTheetClass.toLowerCase() + "class");
	if(typeof(sTab) != 'undefined' && sTab != null) {
		sTab.style.backgroundColor = "#ABD9E9";
		sLastTab = sTheetClass.toLowerCase() + "class";
	}
	/**
	 * Variable que almacena la cadena de consulta URL
	 * @var {String} sParams
	 */
	var sParams = "&tclass=" + sTheetClass;
	//alert(sParams);
	var tx_comb = document.getElementById("tx_comb");

	/**
	 * Obtiene el resultado de la consulta AJAX
	 * @var {String} valor
	 */
	var valor = AjaxQuery("POST", sFilePath + "getTheet.php", false, sParams);
	if(valor != "" && valor != "ERROR" && valor.indexOf("*") > -1) {
		var sThtArray = valor.split("*");
		for(var i = 0; i < sThtArray.length; i++) {
			var sTooth = sThtArray[i].split(",");
			var sQuad = sTooth[2] + (showOnSlice ? "Slice" : "");
			new Thoot(sTooth[0], sQuad, sTooth[3], trtId, sColor, tx_comb);
		}
	}
	if(typeof(loadTx) == 'undefined' || loadTx ==  true) {
		loadDentalChartTx();
	}
}

/**
 * Funcion que elimina todos los objetos "diente" de los cuatro cuadrantes
 * @return {Boolean}
 */
function removeTheet(showOnSlice) {
	for(var i = 1; i <= 4; i++) {
		/**
		 * @var {String} sQuad El cuadrante actual
		 */
		var sQuad = "C" + i + (showOnSlice ? "Slice" : "");
		/**
		 * @var {Object} oParent El objeto referente al cuadrante de sQuad
		 */
		var oParent = document.getElementById(sQuad);
		if(typeof(oParent) != 'undefined' && oParent != null) {
			while(oParent.hasChildNodes()) {
				oParent.removeChild(oParent.lastChild);
			}
		}
		else
			return false;
	}
	return true;
}

/**
 * Funcion que crea un nuevo objeto diente y lo posiciona en el cuadrante
 * adecuado de acuerdo a sQuad
 * @param {Integer} iTid ID del diente.
 * @param {String} sQuad Cuadrante donde se muestra el diente.
 * @param {String} sVPos Posicion vertical del diente
 * @param {Integer} iTrtId Clave del tratamiento seleccionado
 * @param {String} sColor Color del que debe pintarse alguna seccion del diente
 * @param {Object} oSnood Objeto que va a mostrar el texto de la seccion
 * @return {Object}
 */
function Thoot(iTid, sQuad, sVPos, iTrtId, sColor, oSnood) {
	this.thootID = iTid;
	this.parentQuad = sQuad;

	/**
	 * Variable que almacena el objeto DIV creado como parte del diente
	 * @var {Object} oSection
	 */
	var oSection;
	/**
	 * Variable que almacena el objeto diente
	 * @var {Object} oToothContainer
	 */
	var oToothContainer = document.createElement("DIV");
	oToothContainer.className = "tooth";
	var oParent = document.getElementById(this.parentQuad);
	//alert(oParent);
	if(typeof(oParent) == 'undefined' || oParent == null) {
		alert("No se pudo crear el objeto debido a que no se encontr\u00f3 el cuadrante.");
		return false;
	}
	if(typeof(sVPos) == 'undefined' || sVPos == null) {
		sVPos = "SUP";
	}
	var iLeft = 0;
	var iTop = 0;
	var iThtOffsetWidth = 0;

	/**
	 * Funcion que escribe cierto texto en un objeto "celda" determinado.
	 * @param {Object} oSnood Celda donde debe escribirse el texto.
	 * @param {String} sText El texto a escribir.
	 * @return {Boolean}
	 */
	function setSnoodText(oSnood, sText) {
		if(typeof(oSnood) != 'undefined' && oSnood != null) {
			/**
			 * @type {Object} oSnoodText Almacena el texto del objeto "celda".
			 */
			var oSnoodText = eval("oSnood." + (ff ? "textContent" : "innerText"));
			oSnoodText = oSnoodText.replace("----", "");
			if(sText == "") {
				if(oSnoodText.indexOf(",") > -1) {
					/**
					 * @type {Array} oSnoodTextArray Almacena la cadena como arreglo.
					 */
					var oSnoodTextArray = oSnoodText.split(",");
					if(oSnoodTextArray.length > 0) {
						oSnood.innerHTML = oSnoodTextArray[0];
						return true;
					}
				}
			}
			if(oSnoodText.indexOf(sText) > -1) {
				oSnoodText = oSnoodText.replace(", " + sText, "");
			}
			else {
				oSnoodText += ", " + sText;
			}
			if(oSnoodText.length < 1) {
				oSnoodText = "----";
			}
			oSnood.innerHTML = oSnoodText;
			return true;
		}
	}

	/**
	 * Funcion que pinta el fondo de la seccion del objeto del color
	 * deseado. Existe una variante que indica que pinte todas las secciones,
	 * dependiendo del Id del tratamiento.
	 * @param {Object} oObject
	 * @param {String} sColor
	 * @param {Integer} iTrtId
	 * @param {Object} oSnood
	 */
	function toogleBackgroundColor(oObject, sColor, iTrtId, sThtSurface) {
		if(typeof(oObject) != 'undefined' && oObject != null) {

			var iSelThtId = oObject.offsetParent.id;

			if(typeof(iTrtId) == 'undefined') {
				if(iSelTxArray.length > 1) {
					iTrtId = iSelTxArray[0];
					sColor = iSelTxArray[1];
				}
			}
			/**
			 * Almacena el color que debe mostrarse en el objeto, en funcion
			 * al color que tiene actualmente.
			 * @var {String} sNewColor
			 */
			var sNewColor = (oObject.style.backgroundColor == "") ? sColor : "";
			var sParams = "&trt=" + iTrtId + "&tht=" + iSelThtId + "&comb=" + sThtSurface;
			//alert(sParams);
			var valor = AjaxQuery("POST", "getTrtComb.php", false, sParams);
			//alert(valor);

			//if(iTrtId == 15 || iTrtId == 16 || iTrtId == 17 || iTrtId == 130 || iTrtId == 133) {
			if(valor == "CROWN") {
				toogleCrownBackgroundColor(oObject, sNewColor);
				setSnoodText(oSnood, "");
				return true;
			}
			else if(valor == "OK" || valor == "EMPTY") {
				oObject.style.backgroundColor = sNewColor;
				return true;
			}
			else if(valor == "NO") {
				alert("No aplica esta superficie para el tratamiento seleccionado.");
				return false;
			}
		}
	}

	/**
	 * Funcion que obtiene la clave del diente y pinta todas las secciones del
	 * diente del color sColor.
	 * @param {Object} oObject El objeto que va pintarse.
	 * @param {String} sColor El color que va a mostrarse.
	 */
	function toogleCrownBackgroundColor(oObject, sColor) {
		if(typeof(oObject) != 'undefined' && oObject != null) {
			var sRegEx = new RegExp("tht([0-9]+)s([0-9])");
			var sThtIdArray = sRegEx.exec(oObject.id.toString());
			for(var i = 1; i <= 5; i++) {
				var oSection = document.getElementById("tht" + sThtIdArray[1] + "s" + i);
				oSection.style.backgroundColor = sColor;
			}
		}
	}

	/**
	 * Funcion que quita el color al diente anterior y asigna como ultimo
	 * diente el obtenido como argumento oThoot
	 * @param {Object} oTooth
	 * @param {Object} oSnood
	 */
	function clearThoot(oTooth) {
		if(oTooth.id != sLastThoot && sLastThoot != "") {
			var oThootToClear = document.getElementById(sLastThoot);
			if(typeof(oThootToClear) != 'undefined' && oThootToClear != null && oThootToClear.hasChildNodes) {
				for(var i = 0; i < oThootToClear.childNodes.length; i++) {
					oThootToClear.childNodes[i].style.backgroundColor = "";
				}
				setSnoodText(oSnood, "");
			}
		}
		sLastThoot = oTooth.id;
	}
	//alert(this.parentQuad);
	switch(this.parentQuad) {
		case "C1Slice":
		case "C1":
			iLeft = oParent.offsetWidth - 7;
			iTop = oParent.offsetHeight - 108;
			iThtOffsetWidth = getChildrenWidth(oParent);
			iLeft = iLeft - (25 - 2) - iThtOffsetWidth;
			break;
		case "C2Slice":
		case "C2":
			iLeft = 2;
			iTop = oParent.offsetHeight - 108;
			iThtOffsetWidth = getChildrenWidth(oParent);
			iLeft = iLeft + iThtOffsetWidth;
			break;
		case "C3Slice":
		case "C3":
			iLeft = 2;
			iTop = 0;
			iThtOffsetWidth = getChildrenWidth(oParent);
			iLeft = iLeft + iThtOffsetWidth;
			break;
		case "C4Slice":
		case "C4":
			iLeft = oParent.offsetWidth - 7;
			iTop = 0;
			iThtOffsetWidth = getChildrenWidth(oParent);
			iLeft = iLeft - (25 - 2) - iThtOffsetWidth;
			break;
		default:
			return false;
	}

	if(sVPos == "SUP") {
		var oPost = document.createElement("DIV");
		oPost.className = "thtPost";
		oPost.id = "tht" + this.thootID + "s7";
		oPost.title = "POSTE";
		oPost.innerHTML = "<img src='" + sFilePath + "images/post.png' width='25' height='10' />";
		oPost.onclick = function() {
			if(oSnood.innerHTML == "----") {
				alert("Por favor selecciona un tratamiento.");
				return false;
			}
			toogleBackgroundColor(this, sColor, iTrtId, "E");
			clearThoot(this.offsetParent);
		};
		oPost.style.top = ((sVPos == "SUP") ? 0 : 18) + "px";
		oToothContainer.appendChild(oPost);

		var oRoot = document.createElement("DIV");
		oRoot.className = "thtRoot";
		oRoot.id = "tht" + this.thootID + "s6";
		oRoot.innerHTML = "<img src='" + sFilePath + "images/" + this.thootID + ".png' width='25' height='50' />";
		oRoot.onclick = function() {
			if(oSnood != null && oSnood.innerHTML == "----") {
				alert("Por favor selecciona un tratamiento.");
				return false;
			}
			toogleBackgroundColor(this, sColor, iTrtId, "R");
			clearThoot(this.offsetParent);
		};
		oRoot.style.top = ((sVPos == "SUP") ? 10 : 18) + "px";
		oToothContainer.appendChild(oRoot);
	}

	var oSection = document.createElement("DIV");
	oSection.className = "thtSectionV";
	oSection.id = "tht" + iTid + "s1";
	oSection.title = (sVPos == "SUP") ? "VESTIBULAR" : "LINGUAL";
	oSection.onclick = function() {
		if(oSnood != null && oSnood.innerHTML == "----") {
			alert("Por favor selecciona un tratamiento.");
			return false;
		}
		var sText = (sVPos == "SUP") ? "VESTIBULAR" : "LINGUAL";
		var sAbbr = (sVPos == "SUP") ? "V" : "L";
		clearThoot(this.offsetParent);
		//setSnoodText(oSnood, sText);
		if(toogleBackgroundColor(this, sColor, iTrtId, sAbbr)) {
			setSnoodText(oSnood, sText);
		}
	};
	oSection.style.top = ((sVPos == "SUP") ? 61 : 18) + "px";
	oToothContainer.appendChild(oSection);

	var oSection = document.createElement("DIV");
	oSection.className = "thtSectionD";
	oSection.id = "tht" + iTid + "s4";
	oSection.title = (sQuad == "C1" || sQuad == "C4") ? "DISTAL" : "MESIAL";
	oSection.onclick = function() {
		if(oSnood != null && oSnood.innerHTML == "----") {
			alert("Por favor selecciona un tratamiento.");
			return false;
		}
		var sText = (sQuad == "C1" || sQuad == "C4") ? "DISTAL" : "MESIAL";
		var sAbbr = (sQuad == "C1" || sQuad == "C4") ? "D" : "M";
		clearThoot(this.offsetParent);
		setSnoodText(oSnood, sText);
		toogleBackgroundColor(this, sColor, iTrtId, sAbbr);
	};
	oSection.style.top = ((sVPos == "SUP") ? 70 : 26) + "px";
	oToothContainer.appendChild(oSection);

	var oSection = document.createElement("DIV");
	oSection.className = "thtSectionO";
	oSection.id = "tht" + iTid + "s5";
	oSection.title = "OCLUSAL";
	oSection.onclick = function() {
		if(oSnood != null && oSnood.innerHTML == "----") {
			alert("Por favor selecciona un tratamiento.");
			return false;
		}
		var sText = "OCLUSAL";
		clearThoot(this.offsetParent);
		setSnoodText(oSnood, sText);
		toogleBackgroundColor(this, sColor, iTrtId, "O");
	};
	oSection.style.top = ((sVPos == "SUP") ? 70 : 26) + "px";
	oToothContainer.appendChild(oSection);

	var oSection = document.createElement("DIV");
	oSection.className = "thtSectionM";
	oSection.id = "tht" + iTid + "s2";
	oSection.title = (sQuad == "C2" || sQuad == "C3") ? "DISTAL" : "MESIAL";
	oSection.onclick = function() {
		if(oSnood != null && oSnood.innerHTML == "----") {
			alert("Por favor selecciona un tratamiento.");
			return false;
		}
		var sText = (sQuad == "C2" || sQuad == "C3") ? "DISTAL" : "MESIAL";
		var sAbbr = (sQuad == "C2" || sQuad == "C3") ? "D" : "M";
		clearThoot(this.offsetParent);
		setSnoodText(oSnood, sText);
		toogleBackgroundColor(this, sColor, iTrtId, sAbbr);
	};
	oSection.style.top = ((sVPos == "SUP") ? 70 : 26) + "px";
	oToothContainer.appendChild(oSection);

	var oSection = document.createElement("DIV");
	oSection.className = "thtSectionL";
	oSection.id = "tht" + iTid + "s3";
	oSection.title = (sVPos == "SUP") ? "PALATINO" : "VESTIBULAR";
	oSection.onclick = function() {
		if(oSnood != null && oSnood.innerHTML == "----") {
			alert("Por favor selecciona un tratamiento.");
			return false;
		}
		var sText = (sVPos == "SUP") ? "PALATINO" : "VESTIBULAR";
		var sAbbr = (sVPos == "SUP") ? "P" : "V";
		clearThoot(this.offsetParent);
		setSnoodText(oSnood, sText);
		toogleBackgroundColor(this, sColor, iTrtId, sAbbr);
	};
	oSection.style.top = ((sVPos == "SUP") ? 79 : 34) + "px";
	oToothContainer.appendChild(oSection);

	if(sVPos == "SUP") {
		var oSection = document.createElement("DIV");
		oSection.className = "thtSectionNumSup";
		oSection.innerHTML = iTid;
		oSection.style.top = "87px";
		oToothContainer.appendChild(oSection);
	}
	if(sVPos == "INF") {
		var oSection = document.createElement("DIV");
		oSection.className = "thtSectionNumInf";
		oSection.innerHTML = iTid;
		oToothContainer.appendChild(oSection);
	}
	//*** Raiz y poste inferior
	if(sVPos == "INF") {
		var oRoot = document.createElement("DIV");
		oRoot.className = "thtRoot";
		oRoot.id = "tht" + this.thootID + "s6";
		oRoot.innerHTML = "<img src='" + sFilePath + "images/" + this.thootID + ".png' width='25' height='50' />";
		oRoot.onclick = function() {
			if(oSnood != null && oSnood.innerHTML == "----") {
				alert("Por favor selecciona un tratamiento.");
				return false;
			}
			toogleBackgroundColor(this, sColor, iTrtId, "R");
			clearThoot(this.offsetParent);
		};
		oRoot.style.top = "44px";
		oToothContainer.appendChild(oRoot);

		var oPost = document.createElement("DIV");
		oPost.className = "thtPost";
		oPost.id = "tht" + this.thootID + "s7";
		oPost.title = "POSTE";
		oPost.innerHTML = "<img src='" + sFilePath + "images/post.png' width='25' height='10' />";
		oPost.onclick = function() {
			if(oSnood != null && oSnood.innerHTML == "----") {
				alert("Por favor selecciona un tratamiento.");
				return false;
			}
			toogleBackgroundColor(this, sColor, iTrtId, "E");
			clearThoot(this.offsetParent);
		};
		oPost.style.top = "95px";
		oToothContainer.appendChild(oPost);
	}

	oToothContainer.style.left = iLeft + "px";
	oToothContainer.style.top = iTop + "px";
	oToothContainer.id = "tht" + iTid;
	oParent.appendChild(oToothContainer);

	return oToothContainer;
}

function getColoredSections(oThoot) {
	if(oThoot.hasChildNodes()) {
		var iThooth = 0;
		var sSelSection = "";
		for(var i = 0; i < oThoot.childNodes.length; i++) {
			var oObject = oThoot.childNodes[i];
			if(oObject.style.backgroundColor != "") {
				var sRegEx = new RegExp("tht([0-9]+)s([0-9])");
				var sThtIdArray = sRegEx.exec(oObject.id.toString());
				iThooth = sThtIdArray[1];
				sSelSection += sThtIdArray[2] + "*";
			}
		}
		if(iThooth != 0 && sSelSection.length > 1) {
			return iThooth + "*" + sSelSection;
		}
	}
	return false;
}

/**
 * Funcion que determina el ancho que ocupan los objetos hijos dentro
 * del objeto padre
 * @param {Object} oParent Objeto padre
 * @return {Integer|Boolean}
 */
function getChildrenWidth(oParent) {
	if(typeof(oParent) != 'undefined' && oParent != null) {
		var iOffsetWidth = 0;
		for(var i = 0; i < oParent.childNodes.length; i++) {
			iOffsetWidth = iOffsetWidth - oParent.childNodes[i].offsetWidth - 4;
		}
		iOffsetWidth = Math.abs(iOffsetWidth);

		return iOffsetWidth;
	}
	else
		return false;
}

document.onclick = function() {
	if(top.frames && top.frames.length > 1) {
		deleteMenu();
		top.leftFrame.menuBehavior(null, true);
	}
};

document.oncontextmenu = function() {
	return true;
};


function getDoctor(sessId, sURL, event) {
	if(typeof(sessId) != 'undefined' && sessId != null) {
		var sParams = "&UPD=" + sessId;
		//alert(sParams);
		var drExists = AjaxQuery("POST", "../../classes/getDoctor.php", false, sParams);
		//alert(drExists);
		if(typeof(drExists) != null && drExists != "" && drExists == "OK") {
			document.location.href = sURL;
			//location.reload(true);
		}
		else {
			alert("No hay un doctor relacionado con \u00e9sta sesi\u00f3n. Por favor agrega un doctor.");
		}
	}
}