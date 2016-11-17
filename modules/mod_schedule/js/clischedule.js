jQuery.noConflict();
var $j = jQuery;

$j(document).ready(function() {

   var $jcalendar = $j('#calendar');
   var id = 10;
   var sillones = longitud;
//   var d = new Date();
//	d.setDate(d.getDate() - d.getDay());
//	var year = d.getFullYear();
//	var month = d.getMonth();
//	var day = d.getDate();
//
//   var eventData1 = {
//				options: {
//				defaultFreeBusy: {free: false}
//			},
//			events : [
//				
//			],
//			freebusys: [
//
//				{"start": "Mon Sep 05 2011 14:00:00 GMT-0500", "end": "Mon Sep 05 2011 18:00:00 GMT-0500", "free": true, userId: [0,1,2,3]},
//				
//			]
//		};
	
   $jcalendar.weekCalendar({
	  timeFormat: "H:i",
	  timeSeparator: ' - ',
	  use24Hour: true,
      displayOddEven:false,
      timeslotsPerHour : 4,
      allowCalEventOverlap : false,
      overlapEventsSeparate: false,
      firstDayOfWeek : 7,
      businessHours :{start: 6, end: 23, limitDisplay: true},
      daysToShow : 7,
      timeslotHeight: 9,
      users: sillones,
      showAsSeparateUser: true,
//		displayFreeBusys: true,
      //switchDisplay: {'1 día': 1, '3 días siguientes': 3, 'semana laboral': 5, 'toda la semana': 7},
//      title: function(daysToShow) {
//			return daysToShow == 1 ? '%date%' : '%start% - %end%';
//      },
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
      
      draggable : function(calEvent, $jevent) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $jevent) {
         return calEvent.readOnly != true;
      },
      eventNew : function(calEvent, $jevent) {
    	  
         var $jdialogContent = $j("#event_edit_container");
         resetForm($jdialogContent);
         
         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
         var dateIni = $jdialogContent.find("input[name='date_ini']");
         var dateEnd = $jdialogContent.find("input[name='date_end']");
         var schType = document.getElementsByName("schType");         	   
         var radDate = document.getElementsByName("radDate");
         var sillon = calEvent.userId;
         var usr = document.getElementById("cfg").innerHTML;

         schType[0].checked = true;
         radDate[0].checked = true;
         
         document.getElementById("specialOptions").style.display = "none";
         document.getElementById("specialOptions2").style.display = "none";
       	 document.getElementById("date_ini").disabled = true;
    	 document.getElementById("date_end").disabled = true;
         
         $jdialogContent.dialog({
            modal: true,
            width: 500,
            resizable : false,
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
                  var inactivity = 0;
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
                 // selDate = 1 : Rango de Fechas
                 // selDate = 2 : Fecha Seleccionada
                 //*****************************************//
                  calEvent.id = id;
                  id++;
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.cli = cli
//                calEvent.title = drField.text();
                  calEvent.date_ini = "0000-00-00";
                  calEvent.date_end = "0000-00-00";
                  
                  if(sT == 2){
                	  
	                      if(selDate == 1){
	                          
	                          calEvent.date_ini = dateIni.val();
	                          calEvent.date_end = dateEnd.val();
	                          
	                          var dias = daysBetween(dateEnd.val(), dateIni.val());

	                          if(dias < 0){
	                        	  
	                        	  alert("Las fechas especificadas no son validas.");
	                        	  return false;
	                          }
	
	                      }
	                      else{
	
	                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
	                          calEvent.date_end = calEvent.date_ini;
	
	                      }
	                      inactivity = 1
	                      
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
                	  
                	  
                  }

                  
                  var data = retriveInfo(clid, sillon, calEvent.start, calEvent.end, calEvent.date_ini, calEvent.date_end, usr, inactivity);
                  						
                  calEvent.color = data.color;
                  calEvent.id = data.key;
                  calEvent.title = "";
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
      eventDrop : function(calEvent, $jevent) {
          
          var dateIni = new Date(calEvent.start);
          var dateFin = new Date(calEvent.end);
          var usr = document.getElementById("cfg").innerHTML;

          editInfo(clid, calEvent.userId, dateIni, dateFin, calEvent.date_ini, calEvent.date_end, usr, calEvent.inactive, calEvent.id);
        
      },
      eventResize : function(calEvent, $jevent) {

    	  var dateIni = new Date(calEvent.start);
          var dateFin = new Date(calEvent.end);
          var usr = document.getElementById("cfg").innerHTML
    	  
    	  $j("#confirmEdit").dialog({
    		  modal: true,
              resizable : false,
              title: "Edici&oacute;n de Horario",
              buttons: {
            	  
            	  Aceptar:function(){
            		  
            		  $j(this).dialog("close");
  
            		  editInfo(clid, calEvent.userId, dateIni, dateFin, calEvent.date_ini, calEvent.date_end, usr, calEvent.inactive, calEvent.id);
            		  
            	  },
            	  Editar: function(){
            		  
            		  $j(this).dialog("close");
            		  /*************************************************************/
            		  /******          EDICIÓN DE HORARIO EN RESIZE          *******/
            		  /*************************************************************/
            		  
            	         var $jdialogContent = $j("#event_edit_container2");
            	         resetForm($jdialogContent);
            	         
            	         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
            	         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
            	         var dateIni = $jdialogContent.find("input[name='date_ini']").val(calEvent.date_ini);
            	         var dateEnd = $jdialogContent.find("input[name='date_end']").val(calEvent.date_end);
            	         var schType = document.getElementsByName("schType2");         	   
            	         var radDate = document.getElementsByName("radDate2");
            	         var sillon = calEvent.userId;
            	         var usr = document.getElementById("cfg").innerHTML;

            	         schType[0].checked = true;
            	         radDate[0].checked = true;
            	         
            	         document.getElementById("specialOptions3").style.display = "table-row";
            	       	 document.getElementById("specialOptions4").style.display = "table-row";
            	       	 document.getElementById("date_ini2").disabled = true;
            	    	 document.getElementById("date_end2").disabled = true;
            	         
            	    	 
            	    	 
            	         $jdialogContent.dialog({
            	            modal: true,
            	            width: 500,
            	            resizable : false,
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
            	                  var inactivity = 0;
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
            	                 // selDate = 1 : Rango de Fechas
            	                 // selDate = 2 : Fecha Seleccionada
            	                 //*****************************************//
            	                  calEvent.id = id;
            	                  id++;
            	                  calEvent.start = new Date(startField.val());
            	                  calEvent.end = new Date(endField.val());
            	                  calEvent.cli = cli
//            	                  calEvent.title = drField.text();
            	                  calEvent.date_ini = "0000-00-00";
            	                  calEvent.date_end = "0000-00-00";
            	                  
            	                  //if(sT == 2){
            		                      if(selDate == 1){
            		                          
            		                          calEvent.date_ini = dateIni.val();
            		                          calEvent.date_end = dateEnd.val();
            		                          
            		                          var dias = daysBetween(dateEnd.val(), dateIni.val());

            		                          if(dias < 0){
            		                        	  
            		                        	  alert("Las fechas especificadas no son validas.");
            		                        	  return false;
            		                          }
            		                          
            		
            		                      }
            		                      else{
            		
            		                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
            		                          calEvent.date_end = calEvent.date_ini;
            		
            		                      }
            		                      //inactivity = 1
            		                      
            	                 // }

            	                  
            	                  var data = retriveInfo(clid, sillon, calEvent.start, calEvent.end, calEvent.date_ini, calEvent.date_end, usr, inactivity);
            	                  						
            	                  calEvent.color = data.color;
            	                  calEvent.id = data.key;
            	                  calEvent.title = "";
            	                  $jcalendar.weekCalendar("removeUnsavedEvents");
            	                  $jcalendar.weekCalendar("updateEvent", calEvent);
            	                  $jdialogContent.dialog("close");
            	                  
            	                  
            	                                 
            	               },
            	               Cancelar : function() {
//            	                  $jdialogContent.dialog("close");
            	                   $jdialogContent.dialog("destroy");
            	                   $jdialogContent.hide();
            	                   $j('#calendar').weekCalendar("removeUnsavedEvents");
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
//                      $j('#calendar').weekCalendar("removeUnsavedEvents");
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
         var dateIni = $jdialogContent.find("input[name='date_ini']").val(calEvent.date_ini);
         var dateEnd = $jdialogContent.find("input[name='date_end']").val(calEvent.date_end);
         var schType = document.getElementsByName("schType");
         var radDate = document.getElementsByName("radDate");
         var usr = document.getElementById("cfg").innerHTML
         var inactivity = 0;
         
         if(calEvent.inactive == 1){
        	 schType[1].checked = true;
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
        	 schType[0].checked = true;
        	 document.getElementById("specialOptions").style.display = "none";
           	 document.getElementById("specialOptions2").style.display = "none";
           	 radDate[0].checked = true;
          	 document.getElementById("date_ini").disabled = true;
          	 document.getElementById("date_end").disabled = true;
         }

                  
         
         $jdialogContent.dialog({
            modal: true,
            resizable:false,
            width:500,
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
                  // sT = 2 : Horario Inactividad
                  // sT = 3 : Horario Especial
                  // selDate = 1 : Rango de Fechas
                  // selDate = 2 : Fecha Seleccionada
                  //*****************************************//
                  
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
//                  calEvent.cli = cli

                  
                  calEvent.date_ini = "0000-00-00";
                  calEvent.date_end = "0000-00-00";

                  
                  if(sT == 2){
                      if(selDate == 1){
                          
                          calEvent.date_ini = dateIni.val();
                          calEvent.date_end = dateEnd.val();
                          
                          var dias = daysBetween(dateEnd.val(), dateIni.val());
    	                  
    	                  if(dias < 0){
    	                	  
    	                	  alert("Las fechas especificadas no son validas.");
    	                	  return false;
    	                  }

                      }
                      else{

                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
                          calEvent.date_end = calEvent.date_ini;

                      }
                      inactivity = 1;
	              }
                  
                  if(sT == 3){
                	  
	                	 if(selDate == 1){
	                          
	                          calEvent.date_ini = dateIni.val();
	                          calEvent.date_end = dateEnd.val();
	                          
	                          var dias = daysBetween(dateEnd.val(), dateIni.val());
        	                  
        	                  if(dias < 0){
        	                	  
        	                	  alert("Las fechas especificadas no son validas.");
        	                	  return false;
        	                  }
	
	                      }
	                      else{
	
	                          calEvent.date_ini = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
	                          calEvent.date_end = calEvent.date_ini;
	
	                      }
	                	  
                  }

                	  
                	  if(sT == 2 || sT == 3){
                		  
                		  var data = retriveInfo(clid, calEvent.userId, calEvent.start, calEvent.end, calEvent.date_ini, calEvent.date_end, usr, inactivity);
  						
    	                  calEvent.color = data.color;
    	                  calEvent.id = data.key;
    	                  $jcalendar.weekCalendar("removeUnsavedEvents");
    	                  $jcalendar.weekCalendar("updateEvent", calEvent);
    	                  $jdialogContent.dialog("close");
                		  
                	  }else{
                  
		                  var color = editInfo(clid, calEvent.userId, startField.val(), endField.val(), calEvent.date_ini, calEvent.date_end, usr, inactivity, calEvent.id);
		                  calEvent.color = color.color;
		                  $jcalendar.weekCalendar("updateEvent", calEvent);
		                  $jdialogContent.dialog("close");
		                  
                	  }
		                  

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
              cli: clid
          }, 
          function(result){
             callback(result); 
          });

      }
   });

   function resetForm($jdialogContent) {
      $jdialogContent.find("input").val("");
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
