jQuery.noConflict();
var $j = jQuery;

$j(function() {
		function log( message ) {
			$j( "#pat_id" ).val( message );
		}
		$j( "#patient" ).autocomplete({
			source: "classes/mod_patschedule_get_data.php?section=patList",
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ? ui.item.id : "" );
			}
		});
	});


function getTrtDr(spc, trtindex){
//	alert(spc);
	var aData = "cli="+cli+"&spc="+spc+"&trtindex="+trtindex+"&section=drtrt";

	$j.ajax({
			url : "classes/mod_patschedule_get_data.php",
			data : aData,
			type : "GET",
			cache : false,
			error : function(e){
				alert(e);
			},
			success : function(strData){

				$j("#trt").html(strData);
				
			}
		
	});
	
}

function spcPorDr(dr, trtindex){
	
	var aData = "dr="+dr+"&section=spcdr";
	
	$j.ajax({
		url : "classes/mod_patschedule_get_data.php",
		data : aData,
		type : "GET",
		cache : false,
		async : false,
		error : function(e){
			alert(e);
		},
		success : function(strData){

			$j("#spc").val(strData);
			getTrtDr(strData, trtindex);
		}
		
	})
	
}

function insertData(start, end, cli, dr, trt, patid, obs, sillon){
	
	var usr = document.getElementById("cfg").innerHTML;
	
	var aData = "cli_id="+cli+"&pat_id="+patid+"&usr_id="+usr+"&emp_id="+dr+
				"&cli_chair="+sillon+"&vst_ini="+start+"&vst_end="+end+
				"&vst_descr="+escape(obs)+"&trt="+trt+"&section=save";
	
	var response = $j.ajax({
		
						url : "classes/mod_patschedule_save_data.php",
						data : aData,
						type : "POST",
						dataType : "json",
						cache : false,
						async : false,
						error : function(){
							alert("Error");
						}
									
					}).responseText;
	
	var jsonObj = $j.parseJSON(response);
	
	if(jsonObj.response == "OK"){
		
		var data = {"color" : jsonObj.color, "headerColor" : jsonObj.headerColor, 
				    "key" : jsonObj.key, "title" : jsonObj.title};
		return data;
		
	}else{
		alert("Error al agendar la cita. \n Error:"+jsonObj.response);
		return false;
	}
	
}

function editData(start, end, cli, dr, trt, patid, obs, sillon, id, vta){
	
	var usr = document.getElementById("cfg").innerHTML;
	
	var aData = "cli_id="+cli+"&pat_id="+patid+"&usr_id="+usr+"&emp_id="+dr+
				"&cli_chair="+sillon+"&vst_ini="+start+"&vst_end="+end+
				"&vst_descr="+escape(obs)+"&trt="+trt+"&id="+id+"&vta="+vta+"&section=edit"; 
	
	var response = $j.ajax({
						url : "classes/mod_patschedule_save_data.php",
						data : aData,
						dataType : "json",
						type : "POST",
						cache : false,
						async : false,
						error : function(){
									alert("Error");
								}
		
					}).responseText;
	
    var jsonObj = $j.parseJSON(response);
	
	if(jsonObj.response == "OK"){
		
		var data = {"color" : jsonObj.color, "headerColor" : jsonObj.headerColor, 
			    	"title" : jsonObj.title, "userId" : jsonObj.userId};
		return data;
	
	}else{
		alert("Error al agendar la cita. \n Error: "+jsonObj.response);
		return false;
	}
	
	
	
}

function deleteData(id, val){
	
	var usr = document.getElementById("cfg").innerHTML;
	
	$j.ajax({
		url : "classes/mod_patschedule_save_data.php",
		data : "id="+id+"&usr="+usr+"&vta="+val+"&section=delete",
		type : "POST",
		cache : false,
		error : function(){
					alert("Error");
				},
		success: function(strData){
			
//				if(strData != "OK"){
//					alert("Error al eliminar la cita. \n Error: "+strData);
//				}
			
		}

	});
	
}


function getSpcSch(spc, color){
	
	start = document.getElementById("iniDate").value;
	
	var response = $j.ajax({
		
		url : "classes/spcSchedules.php",
		data : "cli="+cli+"&spc="+spc+"&startDate="+start,
	    type : "GET",
	    cache : false,
	    async : false,
	    dataType : "json",
	    error : function(){
	    			alert("Error");
	    		}
		
	}).responseText;

	var jsonObj = $j.parseJSON(response);
	var top = "";
	
	$j("#calendar").weekCalendar("updateFreeBusy", jsonObj);

	$j(".free-busy-busy").each(function(){
		top += $j(this).css("top");
		top += ($j(this).css("top") == "0px") ? "," : "";
	});
		
	var divTop = getTop(top);
	
	$j(".free-busy-busy").each(function(){
		if($j(this).css("top") != "0px"){
			$j(this).css("background-color", color);
		}
		
		for(var i=0; i<divTop.length-1;i++){
			if(parseInt($j(this).css("top")) == divTop[i]){
				$j(this).css("background-color", "transparent");
			}
		}
		
	});
 
}

function getFreeBusys(){
	   
	 start = document.getElementById("iniDate").value;
	   
	  var result = $j.ajax({
		
		  type: "GET",
		  dataType: "json",
		  url:"classes/getFreeBusy.php",
		  data : "startDate="+start+"&cli="+cli,
		  async:false,
		  error: function(e){
			  alert("Error");
		  }
	  }).responseText;
	  
	  var free = $j.parseJSON(result);
	  
	  $j("#calendar").weekCalendar("updateFreeBusy", free);

}

function updateCalendar(date){
	$j("#calendar").weekCalendar("gotoWeek", date);
}

function drEnTurno(cli, dia, hora, chair, fecha){
	
	var result = $j.ajax({
		
		type : "GET",
		url : "classes/mod_patschedule_get_data.php",
		data : "cli="+cli+"&dia="+dia+"&hora="+hora+"&chair="+chair+"&fecha="+fecha+"&section=drTurno",
		dataType : "json",
		cache : false,
		async : false,
		error : function(){
			alert("Error");
		}
		
	}).responseText;
//	
	
	var jsonObj = $j.parseJSON(result);
//	
//	var data = {"emp_id" : jsonObj.emp_id};
	
	return jsonObj;
	
}

function getTop(top){
	
	var top2 = "";
	var toptop = "";
	var compare = 0;
	var compare2 = 0;
	var comtop = "";
	
	top = top.split("0px,");
	for(var i=0; i<top.length; i++){
		
		var sp = top[i].split("px");
		
		for(var j=0; j<sp.length; j++){
			if(sp[j] > compare){
				compare = sp[j];
			}
		}
		if(compare > 0){
			top2 += compare+",";
		}	
	}
	
	top2 = top2.split(",");

	for(var i=0;i<top2.length-1;i++){
		
		if(top2[i] != compare2){

			toptop += top2[i]+",";
			
		}
		compare2 = top2[i];
		
	}
	
//	alert(toptop);
	comtop = toptop.split(",");

	return comtop;
	
}


function getFreeDr(){
	
	var spc = $j("#spc2").val();
	var clinic = $j("#clinic").val();
	var hour = $j("#horaIni").val();
	
	if(spc == ""){
		alert("Debes elegir una especialidad.");
		return false;
	}
	
	var aData = "spc="+spc+"&cli="+clinic+"&ini="+hour;
	
	$j.ajax({
		
		url : "classes/schSearchResults.php",
		type : "post",
		data : aData,
		cache : false,
		error : function(){
			alert("Error");
		},
		beforeSend : function(){
			
			var loader = "<img id='loader' src='../../images/loadinfo24w.gif' />";
			
			$j("#searchResults").html(loader);
			
		},
		success : function(strData){
			
			$j("#searchResults").html(strData);
			
		}
		
	});
	
}

function gotoDate(fecha, clid){
	
	document.location.href = "index.php?profile="+clid+"&fecha="+fecha;
	
}

//******* Cambiar fecha *************//

$j(function(){
	$j("#selDate").datepicker({
		dateFormat: "d MM yy",
		onSelect: function(dateText,inst){
			
			var fecha =  new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay);
			
			var selected = $j("#start").find("option:selected").text();
			var selectedEnd = $j("#end").find("option:selected").text();
			
			setupStartAndEndTimeFieldsFromNewDay2($j("#start"), $j("#end"), selected, selectedEnd, $j("#calendar").weekCalendar("getTimeslotTimes", fecha));
			
		}
	});
});

function setupStartAndEndTimeFieldsFromNewDay2($jstartTimeField, $jendTimeField, selected, selectedEnd, timeslotTimes) {
	
    $jstartTimeField.empty();
    $jendTimeField.empty();

    for (var i = 0; i < timeslotTimes.length; i++) {
       var startTime = timeslotTimes[i].start;
       var endTime = timeslotTimes[i].end;
       var startSelected = (timeslotTimes[i].startFormatted == selected) ? " selected='selected' " : "";
       var endSelected = (timeslotTimes[i].endFormatted == selectedEnd) ? " selected='selected' " : ""; 
       
       $jstartTimeField.append("<option value=\"" + startTime + "\" "+startSelected+">" + timeslotTimes[i].startFormatted + "</option>");
       $jendTimeField.append("<option value=\"" + endTime + "\" "+endSelected+">" + timeslotTimes[i].endFormatted + "</option>");

       $jtimestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
       $jtimestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

    }
    $jendTimeOptions = $jendTimeField.find("option");
//    $jstartTimeField.trigger("change");
    
}


var $jendTimeField = $j("select[name='end']");
var $jendTimeOptions = $jendTimeField.find("option");
var $jtimestampsOfOptions = {start:[],end:[]};

//reduces the end time options to be only after the start time options.
$j("select[name='start']").change(function() {
   var startTime = $jtimestampsOfOptions.start[$j(this).find(":selected").text()];
   var currentEndTime = $jendTimeField.find("option:selected").val();
   $jendTimeField.html(
         $jendTimeOptions.filter(function() {
            
            var res = startTime < $jtimestampsOfOptions.end[$j(this).text()];
            if($jtimestampsOfOptions.end[$j(this).text()] >= (parseInt(startTime)+15300000)){
         	   return false;
            } 
            return res;
            
         })
         );

//   var endTimeSelected = false;
//   $jendTimeField.find("option").each(function() {
//      if ($j(this).val() === currentEndTime) {
//         $j(this).attr("selected", "selected");
//         endTimeSelected = true;
//         return false;
//      }
//   });
//
//   if (!endTimeSelected) {
//      //automatically select an end date 2 slots away.
//      $jendTimeField.find("option:eq(1)").attr("selected", "selected");
//   }

});


//**********************************************************//
//**************Agregar Nuevo Paciente**********************//
//**********************************************************//

function addToList(oList, oTel, sTelType) {
	var oList = document.getElementById(oList);
	var oTel = document.getElementById(oTel);
	var sTelType = document.getElementById(sTelType);
	if(typeof(oList) == 'undefined' || oList == null)
		return false;
	if(typeof(oTel) == 'undefined' || oTel == null)
		return false;
	if(typeof(sTelType) == 'undefined' || sTelType == null)
		return false;
	sTelType = sTelType.options[sTelType.selectedIndex].value;
	var bSelected = ((sTelType == "0") ? false : true);

	if(!bSelected) {
		alert("Selecciona un tipo de telefono.");
		return false;
	}
	var sNumTel = oTel.value.toString().replace(/ /g, "");
	sNumTel = sNumTel.replace(/[()+-]/g, "");
	if(sNumTel.length < 1) {
		alert("Numero telefonico no valido. Por favor verifica.");
		return false;
	}
	bExiste = false;
	for(var i = 0; i < oList.options.length; i++) {
		if(oList.options[i].value == sNumTel) {
			bExiste = true;
			break;
		}
	}
	if(!bExiste) {
		oList.options[oList.options.length] = new Option(oTel.value + " - " + sTelType, sNumTel);
	} else {
		alert("El numero ya existe.");
		return false;
	}
}

function removeFromList(oList) {
	var oList = document.getElementById(oList);
	if(typeof(oList) == 'undefined' || oList == null)
		return false;
	for(var i = 0; i < oList.options.length; i++) {
		if(oList.options[i].selected) {
			oList.options[i] = null;
			break;
		}
	}
}

function addPatient(oList) {
	
	var wFrame = window.cpFrame;
	var lastname = wFrame.document.getElementById("lastname").value;
	var surename = wFrame.document.getElementById("surename").value;
	var name = wFrame.document.getElementById("name").value;
	var email = wFrame.document.getElementById("email").value;
	var agreelist = wFrame.document.getElementById("agreelist");
	agreelist = agreelist.options[agreelist.selectedIndex].value;
	var oList = wFrame.document.getElementById("telList");
	var poliza = wFrame.document.getElementById("poliza");
	var meetform = wFrame.document.getElementById("meetform");
	meetform = meetform.options[meetform.selectedIndex].value;
	var uid = document.getElementById("cfg").innerHTML;
	
	
	if(lastname == "" || name == "") {
		alert("Debes escribir el nombre y apellidos del Paciente.");
		return false;
	}

	if(typeof(poliza) != 'undefined' && poliza != null && poliza.value != "") {
		if(agreelist == "180" || agreelist == "185") {
			poliza = poliza.value;
			var regexp =/([a-zA-Z0-9]){1}(\d){7}/g;
			var valido = regexp.test(poliza);
			if(poliza.length != 8) {
				alert("El n\u00famero de p\u00f3liza debe ser de 8 caracteres alfanum\u00e9ricos.");
				return false;
			}
			else if(!valido){
				alert("El n\u00famero de p\u00f3liza debe tener el siguiente formato: A1111111 \u00f3 11111111.");
				return false;
			}
		}
		else {
			poliza = "";
		}
	}
	else {
		poliza = "";
	}
	//alert(poliza == "" && (agreelist == "180" || agreelist == "185"));
	if(poliza == "" && (agreelist == "180" || agreelist == "185")) {
		alert("El n\u00famero de p\u00f3liza debe ser de 8 caracteres alfanum\u00e9ricos.");
		return false;
	}

	var sParams = "&ln=" + lastname + "&sn=" + surename + "&nm=" + name + "&mail=" + email + "&agr="
				+ agreelist + "&option=false" + "&pol=" + poliza + "&uid=" + uid + "&cli=" + cli
				+ "&mtu=" + meetform;
	var sRes = "";
	for(var i = 0; i < oList.options.length; i++) {
		sRes += oList.options[i].text + "*";
	}
	sParams += "&tel=" + sRes;
	//alert(sParams);
	var valor = AjaxQuery("POST", "../../classes/newPatient.php", false, sParams);
	//alert(valor);
	var bError = true;
	if(typeof(valor) != 'undefined' && valor != null) {
		var valPos = valor.split("*");
		valor = valPos[0];
		if(valor == "ERROR") {
			alert("Error al ingresar al paciente. Valor :" + valor);
			return false;
		}
		else if(valor == "EXISTE") {
			var sRes = confirm("Al parecer el paciente ya existe. Deseas agregarlo de todos modos (no recomendado) ?");
			if(sRes == true) {
				var sParams = "&ln=" + lastname + "&sn=" + surename + "&nm=" + name + "&mail=" + email + "&agr="
							+ agreelist + "&option=true" + "&pol=" + poliza + "&uid=" + uid + "&cli=" + cli
							+ "&mtu=" + meetform;
				sRes = "";
				for(var i = 0; i < oList.options.length; i++) {
					sRes += oList.options[i].text + "*";
				}
				sParams += "&tel=" + sRes;
				var valor = AjaxQuery("POST", "../../classes/newPatient.php", false, sParams);
				if(valor != "OK") {
					alert("Error al ingresar al paciente. Valor :" + valor);
					return false;
				} else if(valor == "OK") {
					bError = false;
				}
			}
			return false;
		}
		else if(valor == "OK") {
			bError = false;
			hideNewPatientDialog();
		}

		if(!bError) {
			return valPos[1];
		}
	}
	else if(typeof(valor) == 'undefined' || valor == null) {
		alert("Fallo en consulta AJAX. Valor: " + valor);
		return false;
	}
}
