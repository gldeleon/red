//Insert Schedule

function retriveInfo(start, end, cli, spc, dr, date_ini, date_end, sillon, inactive, quincenal, quincenal_date_ini){
    
    var usr = document.getElementById("cfg").innerHTML;

    var aData = "start="+start+
    			"&end="+end+
    			"&cli="+cli+
    			"&spc="+spc+
    			"&dr="+dr+
    			"&usr="+usr+
    			"&date_ini="+date_ini+
    			"&date_end="+date_end+
    			"&sillon="+sillon+
    			"&inactive="+inactive+
    			"&quincenal="+quincenal+
    			"&quincenal_date_ini="+quincenal_date_ini+
    			"&section=save";

    var respuesta = $j.ajax({

            type: "POST",
            url: "classes/insertData.php",
            data: aData,
            cache: false,
            dataType: "json",
            async: false,
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error");
                }
              
    }).responseText;
    
    var jsonObj = jQuery.parseJSON(respuesta);
   
   if(jsonObj.response == "OK"){
	   
       var data = {"color" : jsonObj.color, "key" : jsonObj.key, "dr" : jsonObj.dr, "headerColor" : jsonObj.headerColor};     
       return data;
   }
   else{
       alert("Error al ingresar datos a la agenda");
       return false;
   }
    
    

    
}

//Edit Schedule

function editInfo(start, end, cli, spc, dr, id, date_ini, date_end, sillon, inactive, quincenal, quincenal_date_ini){

    var usr = document.getElementById("cfg").innerHTML;
    var aData = "start="+start+
    			"&end="+end+
    			"&cli="+cli+
    			"&spc="+spc+
    			"&dr="+dr+
    			"&usr="+usr+
                "&id="+id+
                "&date_ini="+date_ini+
                "&date_end="+date_end+
                "&sillon="+sillon+
                "&inactive="+inactive+
                "&quincenal="+quincenal+
    			"&quincenal_date_ini="+quincenal_date_ini+
                "&section=edit";

    var respuesta = $j.ajax({

            type: "POST",
            url: "classes/insertData.php",
            data: aData,
            cache: false,
            dataType: "json",
            async: false,
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error");
                }
         
    }).responseText;
    
    var jsonObj = jQuery.parseJSON(respuesta);
   
    if(jsonObj.response == "OK"){
     
    	var data = {"color" : jsonObj.color, "dr" : jsonObj.dr, "headerColor" : jsonObj.headerColor};
        return data;
    }
    else{
        alert("Error al editar los datos de la agenda");
        return false;
    }
    
    
}

function deleteInfo(id){
    
    var usr = document.getElementById("cfg").innerHTML;

    var aData = "usr="+usr+"&id="+id+"&section=delete";
    
    var strData = $j.ajax({

            type: "POST",
            url: "classes/insertData.php",
            data: aData,
            cache: false,
            dataType: "json",
            async: false,
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error");
                }
         
    }).responseText;
    
    
    var jsonObj = jQuery.parseJSON(strData);
    
    if(jsonObj.response != "OK"){
                    
        alert("Error al borrar datos de la agenda. \n Error: "+strData.response);
        return false;
                    
     }
   
}

function getDoctors(spc, dr){

    var drSel = $j("#dr");
    //var clinic = $j("#cli");
    var aData = "section=spc&spc="+spc+
    			"&cli="+cli+
    			"&index="+dr;
    
    $j.ajax({

            type: "POST",
            url: "classes/retriveData.php",
            data: aData,
            cache: false,
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error");
                },
              success: function(strData){
                  
                  drSel.html(strData);
                  

              }
              
    });
    
}

function getDoctors2(spc, dr){

    var drSel = $j("#dr2");
    //var clinic = $j("#cli");
    var aData = "section=spc&spc="+spc+"&cli="+cli+"&index="+dr;
    
    $j.ajax({

            type: "POST",
            url: "classes/retriveData.php",
            data: aData,
            cache: false,
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error");
                },
              success: function(strData){
                  
                  drSel.html(strData);
                  

              }
              
    });
    
}

function getSpcDates(){
    
    var result = $j.ajax({
        
            type: "POST",
            url: "classes/retriveData.php",
            data: "section=schedule",
            cache: false,
            async: false,
            dataType : "json",
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error al enviar informacion");
                }
       
    }).responseText;
    
    return result;
    
}

function getClinics(){
  
    var respuesta = $j.ajax({

            type: "POST",
            url: "includes/clinics.php",
            cache: false,
            async: false,
            beforeSend: function(){
                //dContent.html(loader);
            },
            error: function(){
                alert("Error");
                }
              
    }).responseText;
    
    return respuesta;
  
}

function openOptions(schSel){
	
	var sO1 = document.getElementById("specialOptions");
  	var sO2 = document.getElementById("specialOptions2");
  	var sO3 = document.getElementById("specialOptions6");
	var message = "aqui "+schSel;

	switch(schSel){
	
		case "1":
			sO1.style.display = "none";
			sO2.style.display = "none";
			sO3.style.display = "none";
			break;
			
		case "2":
			sO1.style.display = "table-row";
			sO2.style.display = "table-row";
			sO3.style.display = "none";
			break;
			
		case "3":
			sO1.style.display = "table-row";
			sO2.style.display = "table-row";
			sO3.style.display = "none";
			break;
			
		case "4":
			sO1.style.display = "none";
			sO2.style.display = "none";
			sO3.style.display = "table-row";
			break;
		default:
			sO1.style.display = "none";
			sO2.style.display = "none";
			sO3.style.display = "none";

	}
	   
}

function enablePeriod(spcOptions, event){
	
	var disabled = (spcOptions == 2) ? true : false;
	
	document.getElementById("date_ini"+event).disabled = disabled;
	document.getElementById("date_end"+event).disabled = disabled;
	
}


document.onclick = function(e) {
	var firedEvt = ff ? e : event;
	var firedObj = ff ? firedEvt.target : firedEvt.srcElement;
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
}

/****************************************************/
/********** DIAS ENTRE DOS FECHAS *******************/
/****************************************************/


function daysBetween(date1, date2){
	   if (date1.indexOf("-") != -1) { date1 = date1.split("-"); } else if (date1.indexOf("/") != -1) { date1 = date1.split("/"); } else { return 0; }
	   if (date2.indexOf("-") != -1) { date2 = date2.split("-"); } else if (date2.indexOf("/") != -1) { date2 = date2.split("/"); } else { return 0; }
	   if (parseInt(date1[0], 10) >= 1000) {
	       var sDate = new Date(date1[0]+"/"+date1[1]+"/"+date1[2]);
	   } else if (parseInt(date1[2], 10) >= 1000) {
	       var sDate = new Date(date1[2]+"/"+date1[0]+"/"+date1[1]);
	   } else {
	       return 0;
	   }
	   if (parseInt(date2[0], 10) >= 1000) {
	       var eDate = new Date(date2[0]+"/"+date2[1]+"/"+date2[2]);
	   } else if (parseInt(date2[2], 10) >= 1000) {
	       var eDate = new Date(date2[2]+"/"+date2[0]+"/"+date2[1]);
	   } else {
	       return 0;
	   }
	   var one_day = 1000*60*60*24;
	   var daysApart = Math.ceil((sDate.getTime()-eDate.getTime())/one_day);
	   return daysApart;
	}


function newBusys(){
	
	var d = new Date();
	d.setDate(d.getDate() - d.getDay());
	var year = d.getFullYear();
	var month = d.getMonth();
	var day = d.getDate();

					var fb = [
					          {"start": new Date(year, month, day+0, 00), "end": new Date(year, month, day+3, 00, 00), "free": false, userId: [0,1]},
					{"start": new Date(year, month, day+0, 08), "end": new Date(year, month, day+0, 12, 00), "free": true, userId: [0,1]},
					{"start": new Date(year, month, day+1, 08), "end": new Date(year, month, day+1, 12, 00), "free": true, userId: [0,1]},
					{"start": new Date(year, month, day+2, 08), "end": new Date(year, month, day+2, 12, 00), "free": true, userId: [0,1]},
					{"start": new Date(year, month, day+1, 14), "end": new Date(year, month, day+1, 18, 00), "free": true, userId: [0,1]},
					{"start": new Date(year, month, day+2, 08), "end": new Date(year, month, day+2, 12, 00), "free": true, userId: 0},
					{"start": new Date(year, month, day+2, 14), "end": new Date(year, month, day+2, 18, 00), "free": true, userId: 1}]


	   $j("#calendar").weekCalendar("updateFreeBusy", fb);
	   
}