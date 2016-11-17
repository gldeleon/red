var ff = document.getElementById && !document.all;
var oPatIdContainer, oPatNameContainer;

function showNewPatientDialog(oPatTextBox, oPatIdTextbox) {
	var oFrame = "";
	var newPatient = document.getElementById("newPatient");
	var oFrame = (typeof(top.rightFrame.bottomFrame) != 'undefined') ? "bottomFrame" : "schCalendar";
	if(typeof(newPatient) == 'undefined' || newPatient == null) {
		return false;
	}
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	newPatient.style.left = ((w / 2) - (parseInt(newPatient.offsetWidth) / 2)) + "px";
	newPatient.style.top = (ff ? window.pageYOffset : truebody().scrollTop) + ((oFrame == "schCalendar") ? (parseInt(newPatient.offsetHeight) / 2) : 0) - ((oFrame == "schCalendar") ? 120 : 0) + "px";
	newPatient.style.visibility = "visible";
	oPatIdContainer = oPatIdTextbox;
	oPatNameContainer = oPatTextBox;
}

function hideNewPatientDialog() {
	var newPatient = document.getElementById("newPatient");
	if(typeof(newPatient) != 'undefined' && newPatient != null) {
		newPatient.style.visibility = "hidden";
	}
}

function truebody() {
	return (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body;
}

function addPatient() {
	var cpFrame = window.frames["cpFrame"];
	if(typeof(cpFrame) != 'undefined' && cpFrame != null) {
		var valor = cpFrame.addPatient();
		//alert("addPatient=" + valor);
		if(typeof(valor) != 'undefined' && valor != null && valor != false && valor.length > 1) {
			if(valor == "VACIO") {
				return false;
			}
			var patValue = valor.split("-");
			if(typeof(oPatNameContainer) != 'undefined' && oPatNameContainer != null &&
			   typeof(oPatIdContainer) != 'undefined' && oPatIdContainer != null) {
				if(typeof(top.rightFrame.bottomFrame) != 'undefined') {
					oPatIdContainer = top.rightFrame.bottomFrame.document.getElementById(oPatIdContainer);
					oPatNameContainer = top.rightFrame.bottomFrame.document.getElementById(oPatNameContainer);
				}
				else if(typeof(top.rightFrame.schCalendar) != 'undefined') {
					oPatIdContainer = document.getElementById(oPatIdContainer);
					oPatNameContainer = document.getElementById(oPatNameContainer);
				}
				if(typeof(oPatIdContainer) != 'undefined' && oPatIdContainer != null) {
					oPatIdContainer.value = patValue[0];
				}
				if(typeof(oPatNameContainer) != 'undefined' && oPatNameContainer != null) {
					oPatNameContainer.value = patValue[1];
				}
			}
		}
		hideNewPatientDialog();
		location.reload(true);
	}
}