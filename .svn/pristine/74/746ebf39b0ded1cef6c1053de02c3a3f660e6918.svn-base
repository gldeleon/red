jQuery.noConflict();
var $j = jQuery;

$j(document).ready(function() {

   var $jcalendar = $j('#calendar');
   var id = 10;
   var sillones = longitud;

   $jcalendar.weekCalendar({
	  timeFormat: "H:i",
	  timeSeparator: ' - ',
	  use24Hour: true,
      displayOddEven:true,
      timeslotsPerHour : 4,
      allowCalEventOverlap : false,
      overlapEventsSeparate: false,
      firstDayOfWeek : 7,
      businessHours :{start: 6, end: 23, limitDisplay: true},
      daysToShow : 7,
      timeslotHeight: 9,
      users: sillones,
      displayOddEven : false,
      showAsSeparateUser: true,
	  displayFreeBusys: true,
	  newEventText: '',
	  buttonText: {
          today: 'Hoy',
          lastWeek: 'Anterior',
          nextWeek: 'Siguiente'
        },
	  closeOnEscape: false,
	  headerSeparator: ' ',
	  dateFormat: "d F Y",
	  shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
	  longMonths: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	  shortDays: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
	  longDays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      //switchDisplay: {'1 día': 1, '3 días siguientes': 3, 'semana laboral': 5, 'toda la semana': 7},
      title: function(daysToShow) {
			return daysToShow == 1 ? '%date%' : '%start% - %end%';
      },
      height : function($jcalendar) {
         return $j(window).height() - $j("h1").outerHeight() - 1;
      },
      eventRender : function(calEvent, $jevent) {
//         if (calEvent.end.getTime() < new Date().getTime()) {
//            $jevent.css("backgroundColor", "#aaa");
//            $jevent.find(".wc-time").css({
//               "backgroundColor" : "#999",
//               "border" : "1px solid #888"
//            });
//         }
      },
      eventHeader: function(calEvent, calendar){
    	  
    	  return calEvent.titulo;
    	  
      },
      draggable : function(calEvent, $jevent) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $jevent) {
         return calEvent.readOnly != true;
      },
      eventNew : function(calEvent, $jevent, FreeBusyManager, calendar) {
    	  var isFree = true;
			$j.each(FreeBusyManager.getFreeBusys(calEvent.start, calEvent.end), function(){
				if(
					this.getStart().getTime() != calEvent.end.getTime()
					&& this.getEnd().getTime() != calEvent.start.getTime()
					&& !this.getOption('free')
				){
					isFree = false; return false;
				}
			});
			if(!isFree) {
				alert('No puedes asignar doctores en horarios no disponibles.');
				$jcalendar.weekCalendar('removeEvent',calEvent.id);
				return false;
			}
			
			
         var $jdialogContent = $j("#event_edit_container");
         resetForm($jdialogContent);
         
         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
         var spcField = $jdialogContent.find("select[name='spc']");
         var drField = $jdialogContent.find("select[name='dr']");
         var dateIni = $jdialogContent.find("input[name='date_ini']");
         var dateEnd = $jdialogContent.find("input[name='date_end']");
         var schType = document.getElementsByName("schType");         	   
         var radDate = document.getElementsByName("radDate");
         var quinDate = document.getElementById("quincena_date_ini");
         var sillon = calEvent.userId;
         
         schType[0].checked = true;
         radDate[0].checked = true;
         document.getElementById("specialOptions").style.display = "none";
       	 document.getElementById("specialOptions2").style.display = "none";
       	 document.getElementById("specialOptions6").style.display = "none";
       	 document.getElementById("date_ini").disabled = true;
    	 document.getElementById("date_end").disabled = true;
         
         $jdialogContent.dialog({
            modal: true,
            width: 500,
            resizable: false,
            title: "Nuevo Horario",
            close: function() {
                $jdialogContent.dialog("destroy");
                $jdialogContent.hide();
                $j('#calendar').weekCalendar("removeUnsavedEvents");
             },
            Cerrar: function() {
               $jdialogContent.dialog("destroy");
               $jdialogContent.hide();
               $j('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               Guardar : function() {
            	  
                  var selDate = "";
                  var sT = "";
                  var inactivity = 0;
                  var quincenal = 0;
                  var quincenal_date_ini = "0000-00-00";
                  
                  for(var i = 0; i<radDate.length; i++){

                         if(radDate[i].checked){
                             selDate = radDate[i].getAttribute("valor");
                         }

                     }
                  
                  for(var i = 0 ; i<schType.length; i++){ 
	                   	 if(schType[i].checked){
	                   		 sT = schType[i].id;
	                   	 } 
                 }
                 //*****************************************//
                 // sT = 1 : Horario Fijo
                 // sT = 2 : Horario Periodico
                 // sT = 3 : Horario Inactivo
                 // sT = 4 : Horario Quincenal
                 // selDate = 1 : Rango de Fechas
                 // selDate = 2 : Fecha Seleccionada
                 //*****************************************//
                  calEvent.id = id;
                  id++;
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.cli = cli
                  calEvent.spc = spcField.val();
                  calEvent.dr = drField.val();
//                calEvent.title = drField.text();
                  calEvent.date_ini = "0000-00-00";
                  calEvent.date_end = "0000-00-00";
                  
                  
                  if(sT == 2){
	                      if(selDate == 1){
	                          
	                          calEvent.date_ini = dateIni.val();
	                          calEvent.date_end = dateEnd.val();
	
	                      }
	                      else{
	
	                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
	                          calEvent.date_end = calEvent.date_ini;
	
	                      }
                  }
                  if(sT == 3){
	                      if(selDate == 1){
	                          
	                          calEvent.date_ini = dateIni.val();
	                          calEvent.date_end = dateEnd.val();
	
	                      }
	                      else{
	
	                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
	                          calEvent.date_end = calEvent.date_ini;
	
	                      }
	                      inactivity = 1;
	                      
                  }
                  if(sT == 4){
                	  
                	  	quincenal_date_ini = quinDate.value;
                	  	quincenal = 1;
                	  
                  }
                  
                  /*******************************/
                  /***** VALIDACIONES ************/
                  /*******************************/
                 
                  if(selDate == 1){
                	  
                	  if(dateIni.val() == "" || dateIni.val() == "0000-00-00"){
                		  alert("Debes asignar un rango de fechas para la opcion seleccionada.");
                		  return false;
                	  }
                	  if(dateEnd.val() == "" || dateEnd.val() == "0000-00-00"){
                		  alert("Debes asignar un rango de fechas para la opcion seleccionada.");
                		  return false;
                	  }
                	  
                	  var dias = daysBetween(dateEnd.val(), dateIni.val());

                      if(dias < 0){
                    	  
                    	  alert("Las fechas especificadas no son validas.");
                    	  return false;
                      }
                	  
                  }
                  
                  if(spcField.val() == ""){
                	  alert("Debes elegir una especialidad para el horario.");
                	  return false;
                	  
                  }
                  
                  if(drField.val() == ""){
                	  alert("Debes elegir un doctor para este horario.");
                	  return false;
                  }
                  
                  /*******************************/
                  /*******************************/

                  
                  var data = retriveInfo(calEvent.start, calEvent.end, calEvent.cli, calEvent.spc, calEvent.dr, calEvent.date_ini, calEvent.date_end, sillon, inactivity, quincenal, quincenal_date_ini);
                  
                  calEvent.color = data.color;
                  calEvent.headerColor = data.headerColor;
                  calEvent.id = data.key;
                  calEvent.titulo = data.dr;
                  $jcalendar.weekCalendar("removeUnsavedEvents");
                  $jcalendar.weekCalendar("updateEvent", calEvent);
                  $jdialogContent.dialog("close");
              
               },
               Cancelar : function() {
//                  $jdialogContent.dialog("close");
                   $jdialogContent.dialog("destroy");
                   $jdialogContent.hide();
                   $j('#calendar').weekCalendar("removeUnsavedEvents");
               }
            }
         }).show();

         $jdialogContent.find(".date_holder").text($jcalendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $jcalendar.weekCalendar("getTimeslotTimes", calEvent.start));

      },
      eventDrop : function(calEvent, $jevent, freeBusyManager, $jcalEvent) {
    	  
    	  var dateIni = new Date(calEvent.start);
          var dateFin = new Date(calEvent.end);
    	  
    	  var isFree = true;
			$j.each(freeBusyManager.getFreeBusys(calEvent.start, calEvent.end), function(){
				if(
					this.getStart().getTime() != calEvent.end.getTime()
					&& this.getEnd().getTime() != calEvent.start.getTime()
					&& !this.getOption('free')
				){
					isFree = false; return false;
				}
			});
			if(!isFree) {

				alert('No puedes asignar doctores en horarios no disponibles.');
				$jcalendar.weekCalendar("refresh");
				return false;
			}
    	  
          
          //alert(calEvent.toSource());
          editInfo(dateIni, dateFin, calEvent.cli, calEvent.spc, calEvent.dr, calEvent.id, calEvent.date_ini, calEvent.date_end, calEvent.userId);
        
      },
      eventResize : function(calEvent, $jevent, $jcalEvent, freeBusyManager) {
          
    	  var isFree = true;
			$j.each(freeBusyManager.getFreeBusys(calEvent.start, calEvent.end), function(){
				if(
					this.getStart().getTime() != calEvent.end.getTime()
					&& this.getEnd().getTime() != calEvent.start.getTime()
					&& !this.getOption('free')
				){
					isFree = false; return false;
				}
			});
			if(!isFree) {

				alert('No puedes asignar doctores en horarios no disponibles.');
				$jcalendar.weekCalendar("refresh");
				return false;
			}
    	  
          var dateIni = new Date(calEvent.start);
          var dateFin = new Date(calEvent.end);

    	  $j("#confirmEdit").dialog({
    		  modal: true,
              resizable : false,
              title: "Edici&oacute;n de Horario",
              close: function() {
                  $j(this).dialog("destroy");
                  $j(this).hide();
                  $j('#calendar').weekCalendar("removeUnsavedEvents");
               },
              buttons: {
            	  
            	  Aceptar:function(){
            		  
            		  $j(this).dialog("close");
  
            		  editInfo(dateIni, dateFin, calEvent.cli, calEvent.spc, calEvent.dr, calEvent.id, calEvent.date_ini, calEvent.date_end, calEvent.userId);
            		  
            	  },
            	  Editar: function(){
            		  
            		  $j(this).dialog("close");
            		  /*************************************************************/
            		  /******          EDICIÓN DE HORARIO EN RESIZE          *******/
            		  /*************************************************************/
            		  
            		  	 var $jdialogContent = $j("#event_edit_container2");
            	         resetForm($jdialogContent);
            	         
            	         var startField = $jdialogContent.find("select[name='start2']").val(calEvent.start);
            	         var endField = $jdialogContent.find("select[name='end2']").val(calEvent.end);
            	         var spcField = $jdialogContent.find("select[name='spc2']").val(calEvent.spc);
            	         var drField = $jdialogContent.find("select[name='dr2']").val(calEvent.dr);
            	         var dateIni = $jdialogContent.find("input[name='date_ini2']").val(calEvent.date_ini);
            	         var dateEnd = $jdialogContent.find("input[name='date_end2']").val(calEvent.date_end);
            	         var schType = document.getElementsByName("schType2");         	   
            	         var radDate = document.getElementsByName("radDate2");
            	         getDoctors2(spcField.val(), calEvent.dr);
            	         var sillon = calEvent.userId;
            	         
            	         schType[0].checked = true;
            	         radDate[0].checked = true;
            	         document.getElementById("specialOptions3").style.display = "table-row";
            	       	 document.getElementById("specialOptions4").style.display = "table-row";
            	       	 document.getElementById("specialOptions4").style.display = "table-row";
            	       	 document.getElementById("date_ini2").disabled = true;
            	    	 document.getElementById("date_end2").disabled = true;
            	         
            	         $jdialogContent.dialog({
            	            modal: true,
            	            width: 500,
            	            resizable: false,
            	            title: "Nuevo Horario",
            	            Cerrar: function() {
            	               $jdialogContent.dialog("destroy");
            	               $jdialogContent.hide();
            	               $j('#calendar').weekCalendar("removeUnsavedEvents");
            	            },
            	            buttons: {
            	               Guardar : function() {
            	            	  
            	                  var selDate = "";
            	                  var sT = "";
            	                  
            	                  for(var i = 0; i<radDate.length; i++){

            	                         if(radDate[i].checked){
            	                             selDate = radDate[i].getAttribute("valor");
            	                         }

            	                     }
            	                  
            	                  for(var i = 0 ; i<schType.length; i++){ 
            		                   	 if(schType[i].checked){
            		                   		 sT = schType[i].id;
            		                   	 } 
            	                 }
            	                 //*****************************************//
            	                 // sT = 1 : Horario Fijo
            	                 // sT = 2 : Horario Periodico
            	                 // sT = 3 : Horario Inactivo
            	                 // sT = 4 : Horario Quincenal
            	                 // selDate = 1 : Rango de Fechas
            	                 // selDate = 2 : Fecha Seleccionada
            	                 //*****************************************//
            	                  calEvent.id = id;
            	                  id++;
            	                  calEvent.start = new Date(startField.val());
            	                  calEvent.end = new Date(endField.val());
            	                  calEvent.cli = cli
            	                  calEvent.spc = spcField.val();
            	                  calEvent.dr = drField.val();
//            	                  calEvent.title = drField.text();
            	                  calEvent.date_ini = "0000-00-00";
            	                  calEvent.date_end = "0000-00-00";
            	                  var inactivity = 0;
            	                  
            	                  if(sT == 2){
            		                      if(selDate == 1){
            		                          
            		                          calEvent.date_ini = dateIni.val();
            		                          calEvent.date_end = dateEnd.val();
            		
            		                      }
            		                      else{
            		
            		                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
            		                          calEvent.date_end = calEvent.date_ini;
            		
            		                      }
            	                  }
            	                  if(sT == 3){
            	                	  if(selDate == 1){
        		                          
        		                          calEvent.date_ini = dateIni.val();
        		                          calEvent.date_end = dateEnd.val();
        		
        		                      }
        		                      else{
        		
        		                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
        		                          calEvent.date_end = calEvent.date_ini;
        		
        		                      }
            	                	  
            	                	  inactivity = 1;
            	                	  
            	                  }
            	                  
            	                  /*******************************/
            	                  /***** VALIDACIONES ************/
            	                  /*******************************/
            	                 
            	                  if(selDate == 1){
            	                	  
            	                	  if(dateIni.val() == "" || dateIni.val() == "0000-00-00"){
            	                		  alert("Debes asignar un rango de fechas para la opcion seleccionada.");
            	                		  return false;
            	                	  }
            	                	  if(dateEnd.val() == "" || dateEnd.val() == "0000-00-00"){
            	                		  alert("Debes asignar un rango de fechas para la opcion seleccionada.");
            	                		  return false;
            	                	  }
            	                	  
            	                	  var dias = daysBetween(dateEnd.val(), dateIni.val());
                	                  
                	                  if(dias < 0){
                	                	  
                	                	  alert("Las fechas especificadas no son validas.");
                	                	  return false;
                	                  }
            	                	  
            	                  }
            	                  
            	                  
            	                  
            	                  if(spcField.val() == ""){
            	                	  alert("Debes elegir una especialidad para el horario.");
            	                	  return false;
            	                	  
            	                  }
            	                  
            	                  if(drField.val() == ""){
            	                	  alert("Debes elegir un doctor para este horario.");
            	                	  return false;
            	                  }
            	                  
            	                  /*******************************/
            	                  /*******************************/

            	                  
            	                  var data = retriveInfo(calEvent.start, calEvent.end, calEvent.cli, calEvent.spc, calEvent.dr, calEvent.date_ini, calEvent.date_end, sillon, inactivity);

            	                  calEvent.color = data.color;
            	                  calEvent.headerColor = data.headerColor;
            	                  calEvent.id = data.key;
            	                  calEvent.titulo = data.dr;
            	                  $jcalendar.weekCalendar("removeUnsavedEvents");
            	                  $jcalendar.weekCalendar("updateEvent", calEvent);
            	                  $jdialogContent.dialog("close");
            	                  
            	                  
            	                                 
            	               },
            	               Cancelar : function() {
//            	                  $jdialogContent.dialog("close");
            	                   $jdialogContent.dialog("destroy");
            	                   $jdialogContent.hide();
            	                   $j('#calendar').weekCalendar("refresh");
            	                   //$j('#calendar').weekCalendar("removeUnsavedEvents");
            	               }
            	            }
            	         }).show();

            	         $jdialogContent.find(".date_holder").text($jcalendar.weekCalendar("formatDate", calEvent.start));
            	         setupStartAndEndTimeFields(startField, endField, calEvent, $jcalendar.weekCalendar("getTimeslotTimes", calEvent.start));

            		 
            		  /*************************************************************/
            		  /*************************************************************/
            		  /*************************************************************/
            		  
            	  }
            	  ,
                  Cancelar : function() {
//                     $jdialogContent.dialog("close");
                      $j(this).dialog("destroy");
                      $j(this).hide();
                      $j('#calendar').weekCalendar("refresh");
                  }
            	  
              }
    	  });
            	  
          //alert("time start: "+dateIni+"\n time end: "+dateFin);
          
      },
      eventClick : function(calEvent, $jevent) {
    	  
         if (calEvent.readOnly) {
            return;
         }

         var $jdialogContent = $j("#event_edit_container");
         resetForm($jdialogContent);     
         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
         var spcField = $jdialogContent.find("select[name='spc']").val(calEvent.spc);
         var drField = $jdialogContent.find("select[name='dr']").val(calEvent.dr);
         var dateIni = $jdialogContent.find("input[name='date_ini']").val(calEvent.date_ini);
         var dateEnd = $jdialogContent.find("input[name='date_end']").val(calEvent.date_end);
         var quinDate = document.getElementById("quincena_date_ini").value = calEvent.quincenal_date_ini;
         var schType = document.getElementsByName("schType");
         var radDate = document.getElementsByName("radDate");
         getDoctors(spcField.val(), calEvent.dr);

         
         if(dateIni.val() != "0000-00-00"){
        	 if(calEvent.inactive == 1){
        		 schType[2].checked = true;
        	 }else if(calEvent.inactive == 0){
        		 schType[1].checked = true;
        	 }
        	 document.getElementById("specialOptions").style.display = "table-row";
           	 document.getElementById("specialOptions2").style.display = "table-row";

             
        	 if(dateIni.val() == dateEnd.val()){

        		 radDate[0].checked = true;
               	 document.getElementById("date_ini").disabled = true;
            	 document.getElementById("date_end").disabled = true;
        		 
        	 }
        	 else{

        		 radDate[1].checked = true;
               	 document.getElementById("date_ini").disabled = false;
            	 document.getElementById("date_end").disabled = false;
        	 }
         }
         else{
        	 
        	 if(calEvent.quincenal == 0){
	        	 schType[0].checked = true;
	        	 document.getElementById("specialOptions").style.display = "none";
	           	 document.getElementById("specialOptions2").style.display = "none";
	           	 document.getElementById("specialOptions6").style.display = "none";
	           	 radDate[0].checked = true;
	          	 document.getElementById("date_ini").disabled = true;
	          	 document.getElementById("date_end").disabled = true;
          	 } 
        	 else{
        		 schType[3].checked = true;
        		 document.getElementById("specialOptions").style.display = "none";
	           	 document.getElementById("specialOptions2").style.display = "none";
	           	 document.getElementById("specialOptions6").style.display = "table-row";
        		 radDate[0].checked = true;
               	 document.getElementById("date_ini").disabled = false;
            	 document.getElementById("date_end").disabled = false;
        		 
        		 
        	 }
        	 
        }

                  
         
         $jdialogContent.dialog({
            modal: true,
            width:500,
            resizable: false,
            title: "Editar Horario",
            Cerrar: function() {
               $jdialogContent.dialog("destroy");
               $jdialogContent.hide();
               $j('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               Editar : function() {
                  
            	   var selDate = "";
                   var sT = "";
                   var quincenal = 0;
                   var quincenal_date_ini = "0000-00-00";
                   for(var i = 0; i<radDate.length; i++){

                          if(radDate[i].checked){
                              selDate = radDate[i].getAttribute("valor");
                          }

                      }
                   
                   for(var i = 0 ; i<schType.length; i++){ 
 	                   	 if(schType[i].checked){
 	                   		 sT = schType[i].id;
 	                   	 } 
                  }
                  //*****************************************//
                  // sT = 1 : Horario Fijo
                  // sT = 2 : Horario Periodico
                  // sT = 3 : Horario Inactivo
                  // sT = 4 : Horario Quincenal
                  // selDate = 1 : Rango de Fechas
                  // selDate = 2 : Fecha Seleccionada
                  //*****************************************//
                  
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.cli = cli
                  calEvent.spc = spcField.val();
                  calEvent.dr = drField.val();
                  
                  var inactivity = 0;
                  
                  calEvent.date_ini = "0000-00-00";
                  calEvent.date_end = "0000-00-00";

                  
                  if(sT == 2){
                      if(selDate == 1){
                          
                          calEvent.date_ini = dateIni.val();
                          calEvent.date_end = dateEnd.val();

                      }
                      else{

                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
                          calEvent.date_end = calEvent.date_ini;

                      }
	              }
                  if(sT == 2){
                      if(selDate == 1){
                          
                          calEvent.date_ini = dateIni.val();
                          calEvent.date_end = dateEnd.val();

                      }
                      else{

                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
                          calEvent.date_end = calEvent.date_ini;

                      }
                      
                      inactivity = 1;
                      
	              }
                  if(sT == 4){
                	  
              	  	quincenal_date_ini = quinDate.value;
              	  	quincenal = 1;
              	  
                }
                  
                  /*******************************/
                  /***** VALIDACIONES ************/
                  /*******************************/
                 
                  if(selDate == 1){
                	  
                	  if(dateIni.val() == "" || dateIni.val() == "0000-00-00"){
                		  alert("Debes asignar un rango de fechas para la opcion seleccionada.");
                		  return false;
                	  }
                	  if(dateEnd.val() == "" || dateEnd.val() == "0000-00-00"){
                		  alert("Debes asignar un rango de fechas para la opcion seleccionada.");
                		  return false;
                	  }
                	  
                	  var dias = daysBetween(dateEnd.val(), dateIni.val());
	                  
	                  if(dias < 0){
	                	  
	                	  alert("Las fechas especificadas no son validas.");
	                	  return false;
	                  }
                	  
                  }
                  
                  if(spcField.val() == ""){
                	  alert("Debes elegir una especialidad para el horario.");
                	  return false;
                	  
                  }
                  
                  if(drField.val() == ""){
                	  alert("Debes elegir un doctor para este horario.");
                	  return false;
                  }
                  
                  /*******************************/
                  /*******************************/

                  
                  var color = editInfo(calEvent.start, calEvent.end, calEvent.cli, calEvent.spc, calEvent.dr, calEvent.id, calEvent.date_ini, calEvent.date_end, calEvent.userId, inactivity,quincenal, quincenal_date_ini);
                  
                  calEvent.color = color.color;
                  calEvent.headerColor = color.headerColor;
                  calEvent.titulo = color.dr;
                  $jcalendar.weekCalendar("updateEvent", calEvent);
                  $jdialogContent.dialog("close");

               },
               "Borrar" : function() {
                  
                  deleteInfo(calEvent.id)
                  $jcalendar.weekCalendar("removeEvent", calEvent.id);
                  $jdialogContent.dialog("close");
                  //alert(calEvent.id);
               },
               Cancelar : function() {
                  //$jdialogContent.dialog("close");
                   $jdialogContent.dialog("destroy");
                   $jdialogContent.hide();
                   $j('#calendar').weekCalendar("removeUnsavedEvents");
               }
            }
         }).show();

         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
         $jdialogContent.find(".date_holder").text($jcalendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $jcalendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $j(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
      eventMouseover : function(calEvent, $jevent) {
      },
      eventMouseout : function(calEvent, $jevent) {
      },
      noEvents : function() {
      },
      data : function(start, end, callback) {
         
          $j.getJSON("classes/getEvents.php",
          { 
              start: start.getFullYear()+"-"+parseInt(start.getMonth()+1)+"-"+start.getDate(),
              cli: cli
          }, 
          function(result){
        	  
        	  var free = 
        		  getFreeBusys();
        	  	  callback({freebusys : free, events: result}); 
          });
          
          function getFreeBusys(){
       	   
       	   
        	  var result = $j.ajax({
        		
        		  type: "GET",
        		  dataType: "json",
        		  url:"classes/getFreeBusy.php",
        		  data : "start="+start.getFullYear()+"-"+parseInt(start.getMonth()+1)+"-"+start.getDate()+"&cli="+cli,
        		  async:false,
        		  error: function(e){
        			  alert("Error");
        		  }
        	  }).responseText;
        	  
        	  var free = $j.parseJSON(result);
        	  
        	  return free;

          }   

      }
   });

   function resetForm($jdialogContent) {
      $jdialogContent.find("input").val("");
      $j("#spc").val("");
      $j("#dr").val("");
   }

   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($jstartTimeField, $jendTimeField, calEvent, timeslotTimes) {

      $jstartTimeField.empty();
      $jendTimeField.empty();

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $jstartTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $jendTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

         $jtimestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $jtimestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $jendTimeOptions = $jendTimeField.find("option");
      $jstartTimeField.trigger("change");
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
               return startTime < $jtimestampsOfOptions.end[$j(this).text()];
            })
            );

      var endTimeSelected = false;
      $jendTimeField.find("option").each(function() {
         if ($j(this).val() === currentEndTime) {
            $j(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $jendTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });
   
  
   
   
   

});
