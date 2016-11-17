var sourceURL = "welcome";
var aw = screen.availWidth;
var ah = screen.availHeight;

function createMenu(oMenu, iTop) {
	deleteMenu();
	var sParams = "&mid=" + oMenu.id;
	var oHTMLMenu = top.leftFrame.document.getElementById("mnu" + oMenu.id);
	if(oHTMLMenu != null) {
		var oMenuDiv = document.getElementById("subMenu");
		if(typeof(oMenuDiv) != 'undefined' && oMenuDiv != null) {
			oMenuDiv.style.top = parseInt(oMenu.offsetTop) + iTop - 1 + "px";
			oMenuDiv.innerHTML = oHTMLMenu.innerHTML;
			oMenuDiv.style.visibility = "visible";
		}
	}
}

function deleteMenu() {
	var oMenuDiv = document.getElementById("subMenu");
	if(typeof(oMenuDiv) != 'undefined' && oMenuDiv != null) {
		oMenuDiv.style.visibility = "hidden";
	}
}

function clickMenu(oMenuId, iShowFrame) {
	var modStr = "modules/";
	var modPos = location.href.toString().indexOf(modStr);
	var sURLMod = "";
	if(modPos > -1) {
		var modLocation = location.href.toString().substr(modPos + modStr.length);
		var locationArray = modLocation.split("/");
		for(var i = 0; i < locationArray.length - 1; i++) {
			sURLMod += "../";
		}
	}
	var sParams = "&mid=" + oMenuId;
	var sURL = AjaxQuery("POST", sURLMod + "../classes/menuShift.php", false, sParams);
	if(typeof(sURL) == 'undefined' || sURL == null) {
		alert("Error en consulta AJAX. Valor: " + sURL);
		return false;
	}
	if(typeof(iShowFrame) == 'undefined' || iShowFrame == null) {
		iShowFrame = "0";
	}
	if(sURL.length > 0) {
		var destURL = "";
		var pos = 0;

		if(sURL.indexOf("=") > -1) {
			pos = sURL.indexOf("=") + 1;
			destURL = sURL.substr(pos, sURL.length - pos);
		}

		if(destURL.length < 1) {
			return false;
		}
		var sCompURL = "profile=" + cli;
		if((sourceURL != "schedule") && (destURL != "schedule") && iShowFrame == "1") {
			if(typeof(top.rightFrame.mainFrame) != 'undefined')
				top.rightFrame.mainFrame.location.href = sURLMod + "../classes/" + destURL + ".php?" + sCompURL;
			else
				top.rightFrame.location.href = sURLMod + "../classes/content.php?" + sCompURL + "&url=" + destURL;
		}
		else if(destURL == "schedule" || iShowFrame == "0") {
			top.rightFrame.location.href = sURLMod + "../classes/" + destURL + ".php?" + sCompURL;
		}
		else {
			top.rightFrame.location.href = sURLMod + "../classes/content.php?" + sCompURL + "&url=" + destURL;
		}
		sourceURL = destURL;
	}
}