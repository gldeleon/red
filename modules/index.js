window.onload = function() {
	var m = document.getElementById("m");
	m.style.height = parseInt(document.body.clientHeight) - 402 + "px";
	document.getElementById("a").focus();
};

window.onresize = function() {
	var m = document.getElementById("m");
	m.style.height = parseInt(document.body.clientHeight) - 402 + "px";
	document.getElementById("a").focus();
};

function selectAll(oTextBox) {
	oTextBox.select();
};