var ff = document.getElementById && !document.all;

window.onload = function() {
	var m = document.getElementById("m");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 2 + "px";
};

function dateChange(oCell, bChange, iProfile) {
	if(typeof(bChange) == 'undefined' || bChange == null) {
		bChange = false;
	}
	var arrDate = oCell.id.replace("d", "").replace(/_/g, "/");
	var theUrl = "?profile=" + iProfile + "&showdate=" + arrDate + "&parent=schPanel.php";
	arrDate = arrDate.split("/");
    var oWindow = top.rightFrame;
	oWindow.calendarDay = arrDate[0];
	oWindow.calendarMonth = arrDate[1];
	oWindow.calendarYear = arrDate[2];
	if(bChange) {
        oWindow.schPanel.location.replace("schPanel.php" + theUrl);
    }
	oWindow.schCalendar.location.replace("schCalendar.php" + theUrl);
	oWindow.schCalendar.focus();
}

function changeProfile(oSelect, sDate) {
	var arrDate = sDate.replace("d", "").replace(/_/g, "/");
	var profile = oSelect.options[oSelect.selectedIndex].value;
	var theUrl = "?profile=" + profile + "&showdate=" + sDate + "&parent=schPanel.php";
	var oWindow = top.rightFrame;
	oWindow.calendarDay = arrDate[0];
	oWindow.calendarMonth = arrDate[1];
	oWindow.calendarYear = arrDate[2];
	oWindow.schPanel.location.replace("schPanel.php" + theUrl);
	oWindow.schCalendar.location.replace("schCalendar.php" + theUrl);
	oWindow.schCalendar.focus();
}

window.onresize = function() {
	var m = document.getElementById("m");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 2) + "px";
};

document.oncontextmenu = function(e) {
	return false;
};