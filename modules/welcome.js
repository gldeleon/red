var ff = document.getElementById && !document.all;

window.onload = function() {
	var m = document.getElementById("mn");
	m.style.height = parseInt(document.body.clientHeight) - (40 * 4) - 5 + "px";
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	var mWin2 = document.getElementById("newPatient");
	if(mWin2 != null && typeof(mWin2) != 'undefined') {
		mWin2.style.left = ((w / 2) - (parseInt(mWin2.offsetWidth, 10) / 2)) + "px";
		mWin2.style.top = "0px";
	}
	mWin2.style.visibility = "hidden";
	if(ff) document.body.style.mozUserSelect = "none";
	deleteMenu();
};

document.onclick = function() {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};

document.oncontextmenu = function() {
	return true;
};

document.onselectstart = function() {
	return false;
};