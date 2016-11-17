var ff = document.getElementById && !document.all;
var MonthsArray = Array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

window.onload = function() {
	var m = document.getElementById("schedule_m");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 2 + "px";
	
	var pFrame = document.getElementById("pFrame");
	pFrame.style.width = parseInt(document.body.clientWidth) + "px";
	document.getElementById("week").innerHTML = getCurrentWeek();
	
	deleteMenu();
	pFrame.src = "fCalendar.php?profile=" + cli + "&showdate=" + showDate + "&pat=" + pat;
};

function getMonthText(MonthNumber) {
	if((MonthNumber > 0) && (MonthNumber < 13)) {
		return MonthsArray[MonthNumber - 1];
	}
	else {
		return "no_valido";
	}
}

function getCurrentWeek() {
	var text;
	text  = "Semana " + actualWeek + ": Del " + firstDate;
	if(firstMonth != lastMonth) {
		text += " de " + getMonthText(firstMonth);
	}
	if(firstYear != lastYear) {
		text += " de " + firstYear;
	}
	text += " al " + lastDate + " de " + getMonthText(lastMonth);
	if(firstYear != lastYear) {
		text += " de " + lastYear;
	}
	return text;
}

function openNewVisitDialog(e) {
	var pFrame = document.getElementById("pFrame");
	pFrame.contentWindow.openNewVisitDialog(e, null, false, null, null);
}

window.onresize = function() {
	var m = document.getElementById("schedule_m");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 2) + "px";
	
	var pFrame = document.getElementById("pFrame");
	pFrame.style.width = parseInt(document.body.clientWidth) - 2 + "px";
};

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};

document.oncontextmenu = function() {
	return true;
};