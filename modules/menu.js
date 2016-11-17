var ff = document.getElementById && !document.all;
var thisMenuId = "0", lastMenuId = "0";
var sourceURL = "welcome";
var debug = true;
var aw = screen.availWidth;
var ah = screen.availHeight;

window.onload = function() {
	var m = document.getElementById("mn");
	var oMenu = document.getElementById("menu");
	var oClinicMenu =  document.getElementById("clinicList");
	
	if(typeof(m) != 'undefined' && m != null) {
		m.style.height = parseInt(document.body.clientHeight) - (85 * 2) + "px";
		if(ff) m.style.MozUserSelect = "none";
	}
	if(typeof(oMenu) != 'undefined' && oMenu != null) {
		oMenu.style.left = parseInt(document.body.clientWidth) - oMenu.offsetWidth + "px";
		oMenu.style.top = "100px";
	}
	if(typeof(oClinicMenu) != 'undefined' && oClinicMenu != null)
		oClinicMenu.style.top = parseInt(document.body.clientHeight) - (85 * 2) + 100 + "px";
	
	for(var i= 0; i < oMenu.childNodes.length; i++) {
		var oMenuItem = oMenu.childNodes[i];
		if(oMenuItem.nodeName == "DIV")
			oMenuItem.className = "menuItem";
	}
	if(ff) document.body.style.MozUserSelect = "none";
};

function getMouseEvt(oMenuItem, sEvent) {
	if(sEvent == 'over') {
		oMenuItem.className = "menuItemHover";
		thisMenuId = oMenuItem.id;
		showMenu(oMenuItem);
	}
	else if(sEvent == 'out') {
		lastMenuId = oMenuItem.id;
	}
	menuBehavior();
}

function showMenu(oMenu) {
	if(typeof(top.rightFrame) == 'undefined')
		return false;
	var oFrame = (top.rightFrame.mainFrame) ? "mainFrame" : ((top.rightFrame.schCalendar) ? "schCalendar" : "rightFrame");
	//alert(oFrame);
	if(oFrame == "mainFrame" || oFrame == "schCalendar") {
		//alert(top.rightFrame.frames[oFrame].createMenu);
		if(typeof(top.rightFrame.frames[oFrame]) != 'undefined') {
			if(typeof(top.rightFrame.frames[oFrame].createMenu) != 'undefined') {
				//alert(top.rightFrame.frames[oFrame].createMenu);
				top.rightFrame.frames[oFrame].createMenu(oMenu, parseInt(oMenu.parentNode.offsetTop));
			}
		}
	} 
	else {
		if(typeof(top.rightFrame.createMenu) != 'undefined') {
			top.rightFrame.createMenu(oMenu, parseInt(oMenu.parentNode.offsetTop));
		}
	}
}

function menuBehavior(oMenu, bForce) {
	if(typeof(bForce) == 'undefined' || bForce == null)
		bForce = false;
	if(typeof(oMenu) == 'undefined' || oMenu == null && thisMenuId != "0")
		oMenu = document.getElementById(thisMenuId);
	if(lastMenuId != thisMenuId) {
		oMenu.className = "menuItemHover";
		oLastMenu = document.getElementById(lastMenuId);
		if(oLastMenu != null) {
			oLastMenu.className = "menuItem";
		}
	}
	if(bForce == true) {
		if(typeof(oMenu) != 'undefined' && oMenu != null)
			oMenu.className = "menuItem";
	}
}

function clickMenu(oMenuId, iShowFrame) {
	var sParams = "&mid=" + oMenuId;
	var sURL = AjaxQuery("POST", "../classes/menuShift.php", false, sParams);
	if(typeof(sURL) == 'undefined' || sURL == null) {
		alert("Error en consulta AJAX. Valor: " + sURL);
		return false;
	}
	if(typeof(iShowFrame) == 'undefined' || iShowFrame == null) {
		iShowFrame = "1";
	}
	if(sURL.length > 0) {
		var destURL = "";
		var pos = 0;
		
		if(sURL.indexOf("*") > -1) {
			return false;
		}
		
		if(sURL.indexOf("=") > -1) {
			pos = sURL.indexOf("=") + 1;
			destURL = sURL.substr(pos, sURL.length - pos);
		}
		if(destURL.length < 1)
			return false;
		var sCompURL = "profile=" + profile;
		if((sourceURL != "schedule") && (destURL != "schedule") && iShowFrame == "1") {
			if(typeof(top.rightFrame.mainFrame) != 'undefined')
				top.rightFrame.mainFrame.location.href = destURL + ".php?" + sCompURL;
			else
				top.rightFrame.location.href = "content.php?" + sCompURL + "&url=" + destURL;
		}
		else if(destURL == "schedule" || iShowFrame == "0") {
			top.rightFrame.location.href = destURL + ".php?" + sCompURL;
		}
		else {
			top.rightFrame.location.href = "content.php?" + sCompURL + "&url=" + destURL;
		}
		sourceURL = destURL;
	}
}

function changeProfile(oSelect) {
	profile = oSelect.options[oSelect.selectedIndex].value;
	if(typeof(top.rightFrame) != 'undefined') {
		if(top.rightFrame.location.href.indexOf("schedule.php") > -1)
			top.rightFrame.location.href = "schedule.php?cli=" + profile;
		else if(typeof(top.rightFrame.bottomFrame) != 'undefined')
			top.rightFrame.bottomFrame.location.href = "sessions.php?cli=" + profile;
		if(typeof(top.rightFrame.mainFrame) != 'undefined') {
			if(typeof(top.rightFrame.mainFrame.cli != 'undefined'))
				top.rightFrame.mainFrame.cli = profile;
		}
	}
	setUserPref('cfg', 0, profile);
}

function setUserPref(oCont, sPos, sValue) {
	var oCont = document.getElementById(oCont);
	oContVal = ff ? oCont.textContent : oCont.innerText;
	var sParams = "&uid=" + oContVal;
	var userPref = AjaxQuery("POST", "../classes/getUserPrefs.php", false, sParams);
	if(typeof(userPref) == 'undefined' || userPref == null) {
		alert("Error en consulta AJAX. Valor: " + userPref);
		return false;
	}
	if(typeof(userPref) != 'undefined' && userPref != null && userPref.length > 0 && userPref != "ERROR") {
		if(typeof(sPos) == 'undefined' || typeof(sValue) == 'undefined')
			return false;
		sValue = sValue.toString();
		userPref = userPref.split(":");
		if(sValue.length < 2)
			sValue = "0" + sValue;
		userPref[sPos] = sValue;
		userPref = userPref.toString().replace(/[,]/gi, ":");
		sParams = "&uid=" + oContVal + "&pref=" + userPref;
		var valor = AjaxQuery("POST", "../classes/setUserPrefs.php", false, sParams);
		//alert(valor);
		if(typeof(valor) == 'undefined' || valor == null) {
			alert("Error en consulta AJAX. Valor: " + valor);
			return false;
		}
		if(typeof(valor) != 'undefined' && valor != null && valor == "ERROR") {
			alert("Error al guardar las preferencias del usuario.");
			return false;
		}
	}
	else {
		alert("Error al leer las preferencias del usuario.");
		return false;
	}
}

window.onresize = function() {
	var m = document.getElementById("mn");
	var oMenu = document.getElementById("menu");
	var oClinicMenu =  document.getElementById("clinicList");
	
	if(typeof(m) != 'undefined' && m != null) {
		m.style.height = parseInt(document.body.clientHeight) - (85 * 2) + "px";
		if(ff) m.style.MozUserSelect = "none";
	}
	if(typeof(oMenu) != 'undefined' && oMenu != null) {
		oMenu.style.left = parseInt(document.body.clientWidth) - oMenu.offsetWidth + "px";
		oMenu.style.top = "100px";
	}
	if(typeof(oClinicMenu) != 'undefined' && oClinicMenu != null)
		oClinicMenu.style.top = parseInt(document.body.clientHeight) - (85 * 2) + 100 + "px";
};

document.oncontextmenu = function() {
	return debug;
};

document.onmouseover = function(e) {
	var firedEvt = ff ? e : event;
	var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
	firedEvt.cancelBubble = true;
	if(typeof(firedObj) != 'undefined' && firedObj != null && firedObj.className == "" && firedObj.tagName != "BODY") {
		var oMenu = document.getElementById("menu");
		for(var i= 0; i < oMenu.childNodes.length; i++) {
			var oMenuItem = oMenu.childNodes[i];
			if(oMenuItem.nodeName == "DIV")
				oMenuItem.className = "menuItem";
		}
	}
	return false;
};

document.onselectstart = function() {
	return false;
};