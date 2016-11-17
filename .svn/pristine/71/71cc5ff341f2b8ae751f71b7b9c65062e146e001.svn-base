jQuery.noConflict();
var $j = jQuery;

$j(function() {
		function log( message ) {
			$j( "#clinic_coord" ).val( message );
		}

		$j( "#clicoord" ).autocomplete({
			source: "classes/mod_schedule_get_data.php?section=empList",
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ? ui.item.id : "" );
			}
		});
	});

$j(function() {
	function log( message ) {
		$j( "#dental_coord" ).val( message );
	}

	$j( "#dentalcoord" ).autocomplete({
		source: "classes/mod_schedule_get_data.php?section=empList",
		minLength: 2,
		select: function( event, ui ) {
			log( ui.item ? ui.item.id : "" );
		}
	});
});

$j(function() {
	function log( message ) {
		$j( "#clinic_coordEdit" ).val( message );
	}

	$j( "#clicoordEdit" ).autocomplete({
		source: "classes/mod_schedule_get_data.php?section=empList",
		minLength: 2,
		select: function( event, ui ) {
			log( ui.item ? ui.item.id : "" );
		}
	});
});

$j(function() {
function log( message ) {
	$j( "#dental_coordEdit" ).val( message );
}

$j( "#dentalcoordEdit" ).autocomplete({
	source: "classes/mod_schedule_get_data.php?section=empList",
	minLength: 2,
	select: function( event, ui ) {
		log( ui.item ? ui.item.id : "" );
	}
});
});

$j(function(){
	
	$j("#clinicSchedule").tabs();
	
});



	
$j(function() {
		$j( "#success" ).dialog({
			autoOpen: false,
			draggable : false,
			modal:true,
			resizable: false,
			height: 120,
			buttons: {
				Aceptar: function() {
	               $j(this).dialog("close");

	            }
			}
			
		});
		
		$j( "#fail" ).dialog({
			autoOpen: false,
			draggable : false,
			modal:true,
			resizable: false,
			buttons: {
				Cerrar: function() {
	               $j(this).dialog("close");

	            }
			}
			
		});

		$j( "#alta" ).live("click", function() {
			
			var cli_name = $j("#cliname").val();
			var cli_shortname = $j("#clishortname").val();
			var cli_chair = $j("#clichair");
			var cli_class = $j("#cliclass").val();
			var state = $j("#states").val();
			var uid = $j("#cfg").html();
			
			var regExp = /\d/;
			var valida = regExp.test(cli_chair.val());
		    
			if(valida){
	            
	             var valor = parseInt(cli_chair.val());
	             
	             if(valor < 0 ){
	                 cli_chair.val(0);
	             }
	             if(isNaN(valor)){
	            	 cli_chair.val(0);
	             }
	             
	             
		     }
		     else{
		    	 alert("Solo puedes ingresar numeros en el campo de sillones.");
		    	 return false;
		     }
		    
		    
			if(cli_name == ""){
				
				alert("Escriba el nombre de la clinica.");
				return false;
			}
			if(cli_shortname == ""){
				
				alert("Escriba un nombre abreviado para la clinica.");
				return false;
				
			}
			if(cli_chair.val() == "" || cli_chair.val() == 0){
				alert("Especifica el numero de sillones para la clinica.");
				return false;
			}
			if(cli_class == ""){
				
				alert("Especifica el tipo de clinica.");
				return false;
				
			}
			if(state == ""){
				
				alert("Seelccione el estado al que pertenece la clinica.");
				return false;
				
			}
			
			var aData = "cliname="+cli_name+"&clishortname="+cli_shortname+
						"&clichair="+cli_chair.val()+"&cli_class="+cli_class+
						"&state="+state+
						"&usr="+uid+"&section=altaClinica";
			
			$j.ajax({
				
				type : "POST",
				url : "classes/insertData.php",
				data : aData,
				cache : false,
				dataType : "json",
				error: function(){
	                alert("Error");
	                },
				success: function(data){
					//alert(data.toSource());
					if(data.respuesta == "OK"){
						
						window.location.reload();
						$j( "#success" ).dialog( "open" );
						$j("#cliname").val("");
						$j("#clishortname").val("");
						$j("#clichair").val("");
						$j("#cliclass").val("");
						$j("#states").val("");
						return false;
						
					}else{
						$j("#fail").append(data.respuesta);
						$j( "#fail" ).dialog( "open" );
						return false;
						
					}
				
				}

			});
			
		});
});

function editClinicDialog(clid, active){

	$j( "#edit-clinic-dialog" ).dialog({
		autoOpen: false,
		draggable : false,
		modal:true,
		width: 450,
		resizable: false,
		buttons: {
			Cerrar: function() {
               $j(this).dialog("close");

            },
            Guardar: function(){
            	var cli_name = $j("#clinameEdit").val();
    			var cli_shortname = $j("#clishortnameEdit").val();
    			var cli_chair = $j("#clichairEdit");
    			var cli_class = $j("#cliclassEdit").val();
    			var state = $j("#statesEdit").val();
    			var clid = $j("#clid").val();
    			var uid = $j("#cfg").html();
            	
    			var regExp = /\d/;
    			var valida = regExp.test(cli_chair.val());
    		    
    		    if(valida){
    		            
    		             var valor = parseInt(cli_chair.val());
    		             
    		             if(valor < 0 ){
    		                 cli_chair.val(0);
    		             }
    		             if(isNaN(valor)){
    		            	 cli_chair.val(0);
    		             }
    		             
    		             
    		     }
    		     else{
    		    	 alert("Solo puedes ingresar numeros en el campo de sillones.");
    		    	 return false;
    		     }
    		    
    		    
    			if(cli_name == ""){
    				
    				alert("Escriba el nombre de la clinica.");
    				return false;
    			}
    			if(cli_shortname == ""){
    				
    				alert("Escriba un nombre abreviado para la clinica.");
    				return false;
    				
    			}
    			if(cli_chair.val() == "" || cli_chair.val() == 0){
    				alert("Especifica el numero de sillones para la clinica.");
    				return false;
    			}
    			if(cli_class == ""){
    				
    				alert("Especifica el tipo de clinica.");
    				return false;
    				
    			}
    			if(state == ""){
    				
    				alert("Seelccione el estado al que pertenece la clinica.");
    				return false;
    				
    			}

    			
            	var editData = editClinic(cli_name, cli_shortname, cli_chair.val(), cli_class, state, clid, uid);
            }
		}
		
	});
	
	var aData = "clid="+clid+"&active="+active+"&section=datosClinica";

	var respuesta = $j.ajax({
	
			type : "POST",
			url : "classes/retriveData.php",
			data : aData,
			cache : false,
			dataType : "json",
			async: false,
			error: function(){
				alert("Error");
			}

		}).responseText;
	
		var data = jQuery.parseJSON(respuesta);

		$j("#clinameEdit").val(data.cli_name);
		$j("#clishortnameEdit").val(data.cli_shortname);
		$j("#clichairEdit").val(data.cli_chairs);
		$j("#cliclassEdit").val(data.clc_id);
		$j("#statesEdit").val(data.stt_id);
		$j("#clid").val(data.cli_id);
		
		$j("#edit-clinic-dialog").dialog("open");
	
}

function changeStatus(clid, active){
	
	var aData = "clid="+clid+"&active="+active+"&section=activeClinic";
	
	$j.ajax({
		
		type : "POST",
		url : "classes/insertData.php",
		data : aData,
		cache : false,
		dataType : "json",
		error: function(){
            alert("Error");
            },
		success: function(data){
			//alert(data.toSource());
			if(data.respuesta == "OK"){
				
				$j("#active").html(data.active);
				$j("#inactive").html(data.inactive);
				$j( "#edit-clinic-dialog" ).dialog("close");
				
			}else{
				
				$j("#fail").append(data.respuesta);
				$j( "#fail" ).dialog( "open" );
				return false;
				
			}
		
		}
				
	});	
	
}

function editClinic(cli_name, cli_shortname, cli_chair, cli_class, state, clid, uid){
	
	var aData = "cliname="+cli_name+"&clishortname="+cli_shortname+
				"&clichair="+cli_chair+"&cli_class="+cli_class+
				"&state="+state+"&clid="+clid+
				"&usr="+uid+"&section=editClinica";
	
	$j.ajax({
		
		type : "POST",
		url : "classes/insertData.php",
		data : aData,
		cache : false,
		dataType : "json",
		error: function(){
            alert("Error");
            },
		success: function(data){
			//alert(data.toSource());
			if(data.respuesta == "OK"){
				
				$j("#active").html(data.active);
				$j("#inactive").html(data.inactive);
				$j( "#edit-clinic-dialog" ).dialog("close");
				
			}else{
				
				$j("#fail").append(data.respuesta);
				$j( "#fail" ).dialog( "open" );
				return false;
				
			}
		
		}
				
	});	
	
}
	
function openOptions(schSel){
	   
	   
    var visible = (schSel == 1) ? "none" : "table-row";
    
   	 document.getElementById("specialOptions").style.display = visible;
   	 document.getElementById("specialOptions2").style.display = visible;

    
}

function enablePeriod(spcOptions, event){
	
	var disabled = (spcOptions == 2) ? true : false;
	
	document.getElementById("date_ini"+event).disabled = disabled;
	document.getElementById("date_end"+event).disabled = disabled;
	
}

function retriveInfo(cli_id,cli_chair,csc_ini,csc_end,csc_date,csc_date_end,csc_modusr, inactivity){

	var aData = "cli_id="+cli_id+"&cli_chair="+cli_chair+
				"&csc_ini="+csc_ini+"&csc_end="+csc_end+"&csc_date="+csc_date+
				"&csc_date_end="+csc_date_end+
				"&csc_modusr="+csc_modusr+"&inactive="+inactivity+"&section=cliSch";
	
	var response = $j.ajax({
		
		type : "POST",
		url : "classes/insertData.php",
		data : aData,
		cache : false,
		dataType : "json",
		async: false,
		error: function(){
            alert("Error");
            }
				
	}).responseText;	
	
	var jsonObj = $j.parseJSON(response);
	
	if(jsonObj.response == "OK"){
		   
	       var data = {"key" : jsonObj.id, "color" : jsonObj.color};     
	       return data;
	   }
	   else{
	       alert("Error al ingresar datos a la agenda");
	       return false;
	   }
	
}


function editInfo(cli_id,cli_chair,csc_ini,csc_end,csc_date,csc_date_end,csc_modusr, inactivity, id){

	var aData = "cli_id="+cli_id+"&cli_chair="+cli_chair+
				"&csc_ini="+csc_ini+"&csc_end="+csc_end+"&csc_date="+csc_date+
				"&csc_date_end="+csc_date_end+
				"&csc_modusr="+csc_modusr+"&csc_id="+id+"&inactive="+inactivity+"&section=editCliSch";
	
	var response = $j.ajax({
		
		type : "POST",
		url : "classes/insertData.php",
		data : aData,
		cache : false,
		dataType : "json",
		async: false,
		error: function(){
            alert("Error");
            }
				
	}).responseText;	
	
	var jsonObj = $j.parseJSON(response);
	
	if(jsonObj.response == "OK"){
		   
	       var data = {"color" : jsonObj.color};     
	       return data;
	   }
	   else{
	       alert("Error al editar los datos de la agenda");
	       return false;
	   }
	
}

function deleteInfo(id){
    
    var usr = document.getElementById("cfg").innerHTML;
    //alert(id);
    var aData = "usr="+usr+"&csc_id="+id+"&section=deleteSch";
    
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
