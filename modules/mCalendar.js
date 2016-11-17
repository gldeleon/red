function changeCal(iProfile) {
	if(wParent == "schPanel.php") {
		var oWindow = top.rightFrame;
		oWindow.calendarMonth = document.getElementById("selMonth").value;
		oWindow.calendarYear = document.getElementById("selYear").value;
	}
	document.mcalendar.submit();
}

function choiceDate(oCell, oLastCell, bChange, iProfile) {
	if(typeof(bChange) == 'undefined' || bChange == null) {
		return false;
	}
	if(wParent != "schPanel.php") {
		return false;
	}
	if(document.getElementById("calendarTable").disabled != true) {
		//alert(window.frames.length);
		if(!oCell.name) {
			if(typeof(oLastCell) != 'undefined' && oLastCell != null) {
				oLastCell.style.borderColor = "#084C8D";
			}
			oCell.style.borderColor = "#FF9900";
			oLastCell = oCell;
		}
		var oWindow = top.rightFrame.schPanel;
		oWindow.dateChange(oCell, bChange, iProfile);
	}
	return oLastCell;
}

document.oncontextmenu = function() {
	return false;
};