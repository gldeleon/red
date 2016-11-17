var debug = false;

function AjaxQuery(sMethod, sURL, bAsync, sParameters) {
	if((sMethod == null) || (sURL == null) || (bAsync == null))
		return false;
	if((sParameters == null) || (typeof(sParameters) == 'undefined'))
		sParameters = "";
	var xmlhttp = false;
	if(window.XMLHttpRequest)
		xmlhttp = new XMLHttpRequest;
	else if(window.ActiveXObject) {
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(E) {
				xmlhttp = false;
			}
		}
	}
	
	if(!xmlhttp && typeof XMLHttpRequest != 'undefined')
		xmlhttp = new XMLHttpRequest();
	if(typeof(degub) != 'undefined' && debug) alert(sURL);
	if(typeof(degub) != 'undefined' && debug) alert(sParameters);
	
	xmlhttp.open(sMethod, sURL, bAsync);
	if(sMethod == "POST") {
		xmlhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("content-length", sParameters.length);
		try {
			xmlhttp.send(sParameters);
		}
		catch(Excep) {
			//no hagas nada!
		}
	}
	else
		xmlhttp.send(null);
	if(typeof(degub) != 'undefined' && debug) alert(sMethod);
	
	if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
		var sReturn = xmlhttp.responseText;
		if(typeof(degub) != 'undefined' && debug) alert(xmlhttp.responseText);
	}
	xmlhttp = false;
	return sReturn;
}