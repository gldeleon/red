function changeCal(iProfile) {
	document.mcalendar.submit();
}

function choiceDate(oCell, bChange, iProfile) {
	if(typeof(bChange) == 'undefined' || bChange == null) {
		return false;
	}
	if(typeof(top.rightFrame) != 'undefined') {
		top.rightFrame.dateChange(oCell, bChange, iProfile);
	}
	else {
		parent.dateChange(oCell, bChange, iProfile);
	}
}

document.oncontextmenu = function() {
	return false;
};