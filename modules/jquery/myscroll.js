/**
 * @author dzepeda
 * 
 * Funcion para el scroll
 * 
 */
window.onload = function() {
	var m = document.getElementById("m");
	if(parseInt(document.body.clientHeight) > 8) {
		m.style.height = parseInt(document.body.clientHeight) - (40 * 2) - 5 + "px";
	}
	var w = parseInt(document.body.clientWidth);
	w = ff ? (w - 4) : w;
	if(typeof(top.leftFrame) != 'undefined') {
		deleteMenu();
	}
        
        var calendar = document.getElementById("calendarButton1");
        
        if(typeof(calendar) != 'undefined' && calendar != null){
            Calendar.setup({
              dateField      : 'fecha_ini',
              triggerElement : 'calendarButton1'
            });
        }
        
}