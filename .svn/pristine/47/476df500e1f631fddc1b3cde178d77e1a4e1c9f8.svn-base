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
      businessHours :{start: 6, end: 24, limitDisplay: true},
      daysToShow : 7,
      timeslotHeight: 13,
      defaultEventLength: 1,
      users: sillones,
      showAsSeparateUser: true,
      displayFreeBusys: true,
      newEventText: '',
      buttonText: {
          today: 'Hoy',
          lastWeek: 'Anterior',
          nextWeek: 'Siguiente'
        },
      headerSeparator: ' ',
      closeOnEscape: false,
      dateFormat: "d F Y",
      shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      longMonths: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      shortDays: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
      longDays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      //switchDisplay: {'1 día': 1, '3 días siguientes': 3, 'semana laboral': 5, 'toda la semana': 7},
      title: function(daysToShow) {
			return daysToShow == 1 ? '%date%' : '%start% al %end%';
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
    	  
    	  	var curYear = new Date().getFullYear();
			var curMonth = new Date().getMonth();
			var curDate = new Date().getDate();
			var fullDate = calEvent.end.getFullYear()+"-"+calEvent.end.getMonth()+"-"+calEvent.end.getDate();
			var getToday = curYear+"-"+curMonth+"-"+curDate;
			
			if(fullDate != getToday && (calEvent.end.getTime() < new Date().getTime())){
				
				return false;
			}
			if(argument == 0){
    		  rightClick($jevent, calEvent);
			}

      },
      calendarBeforeLoad: function(calendar){
    	  
    	  $j("#cargar").show();
    	  
      },
      calendarAfterLoad : function(calendar, calEvent){
    	  $j("#cargar").hide();
    	  $j('#calendar').weekCalendar("removeUnsavedEvents");
    	  if(pat != ""){

    		  //$j(".date_holder").hide();
//    		  $j("#selDate").show();
    		  
    		  var ini = new Date();
    		  var oldDate = calEvent.start; 
    		  var $jdialogContent = $j("#event_edit_container");
		      resetForm($jdialogContent);
		      
		      	var hora = calEvent.start.getHours()+":"+calEvent.start.getMinutes();
				var fecha = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
		      
		      	 var startField = $jdialogContent.find("select[name='start']").val(ini);
		         var endField = $jdialogContent.find("select[name='end']");
		         var drField = $jdialogContent.find("select[name='dr']");
		         var trtField = $jdialogContent.find("select[name='trt']");
		         var patient = $j("#patient").val(patname);
		         var spc = $jdialogContent.find("select[name='spc']");
		         var patid = $j("#pat_id").val(pat);
		         var obs = $jdialogContent.find("textarea[name='obs']");
		         var sillon = $j("#sillon");

		         $jdialogContent.dialog({
		            modal: true,
		            width: 450,
		            resizable: false,
		            title: "Agregar Cita",
		            close: function() {
		               $jdialogContent.dialog("destroy");
		               $jdialogContent.hide();
		               $j('#calendar').weekCalendar("removeUnsavedEvents");
		               document.getElementById("trSillon").style.display = "none";
		               pat = "";
		               //$j(".date_holder").show();
//		     		   $j("#selDate").hide();
		            },
		            buttons: {
		               Guardar : function() {
		            	  
		                  calEvent.start = new Date(startField.val());
		                  calEvent.end = new Date(endField.val());

		                  calEvent.id = id;
		                  id++;
		                  
		                  var trtIndex = document.getElementById("trt").selectedIndex;
		                  var drIndex = document.getElementById("dr").selectedIndex;
		                  
		                  if(drField.val() == ""){
		                	  alert("Debes seleccionar un doctor.");
		                	  return false;
		                  }
		                  if(sillon.val() == ""){
		                	  alert("Debes seleccionar un sillon.");
		                	  return false;
		                  }
		                  if(patid.val() == ""){
		                	  alert("Debes seleccionar un paciente valido.");
		                	  return false;
		                  }
		                  if(spc.val() == ""){
		                	  alert("Debes seleccionar una especialidad.");
		                	  return false;
		                  }
		                  if(trtField.val() == ""){
		                	  alert("Debes seleccionar un tratamiento.");
		                	  return false;
		                  }
		                  
		                  var newDate = new Date(startField.val());
			            	 
		            	  var nueva = newDate.getFullYear()+"-"+parseInt(newDate.getMonth()+1)+"-"+newDate.getDate();
		                  var vieja = oldDate.getFullYear()+"-"+parseInt(oldDate.getMonth()+1)+"-"+oldDate.getDate();


		                  calEvent.cli = cli;
		                  calEvent.dr = drField.val();
		                  calEvent.trt = trtField.val();
		                  calEvent.patid = patid.val();
		                  calEvent.patient = patient.val();
		                  calEvent.spc = spc.val();
		                  calEvent.obs = obs.val();
		                  calEvent.vta = 1;
		                  calEvent.status = "Normal";
		                  calEvent.trtName = document.getElementById("trt").options[trtIndex].text;
		                  calEvent.drName = document.getElementById("dr").options[drIndex].text;
		                  
		                  //alert(calEvent.start+" "+calEvent.end+" "+calEvent.cli+" "+calEvent.dr+" "+calEvent.trt+" "+calEvent.patid+" "+calEvent.obs+" "+sillon.val());
		                  
		                  var data = insertData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, (sillon.val()-1));
		                  
		                  if(vieja != nueva){
		                	  
		                	  gotoDate(nueva, calEvent.cli);
		                	  
		                  }
		                  else{
		                	  calEvent.color = data.color;
			                  calEvent.headerColor = data.headerColor;
			                  calEvent.id = data.key;
			                  calEvent.titulo = data.title;
			                  calEvent.userId = sillon.val()-1;
			                  $jcalendar.weekCalendar("removeUnsavedEvents");
			                  $jcalendar.weekCalendar("updateEvent", calEvent);
			                  $jdialogContent.dialog("close");
			                  document.getElementById("trSillon").style.display = "none";
			                  pat = "";
		                  }

		              
		               },
		               Cancelar : function() {
		                   $jdialogContent.dialog("destroy");
		                   $jdialogContent.hide();
		                   $j('#calendar').weekCalendar("removeUnsavedEvents");
		                   document.getElementById("trSillon").style.display = "none";
		                   pat = "";
//		                   $j(".date_holder").show();
//			     		   $j("#selDate").hide();
		               }
		            }
		         }).show();
		         
		         //alert($jcalendar.weekCalendar("formatDate", ini, "h:i:s"));
		         
		         $jdialogContent.find(".selDate").val($jcalendar.weekCalendar("formatDate", ini));
		         setupStartAndEndTimeFieldsFromNewDay(startField, endField, $jcalendar.weekCalendar("getTimeslotTimes", ini));
		      
		      
    	  }
    	  
    	  
    	  
      },
      eventHeader: function(calEvent, calendar){
    	  
    	  return calEvent.titulo;
    	  
      },
      draggable : function(calEvent, $jevent) {
    	  if(argument == 0){
    		  if (calEvent.end.getTime() > new Date().getTime()) {
    			  return calEvent.readOnly != true;
		     }
    	  }
      },
      resizable : function(calEvent, $jevent) {
    	  if(argument == 0){
    		  if (calEvent.end.getTime() > new Date().getTime()) {
    			  return calEvent.readOnly != true;
		     }
    		  
    	  }
      },
      eventNew : function(calEvent, $jevent, FreeBusyManager, calendar) {
    	  
    	  if(argument == 0){
		    	 if (calEvent.end.getTime() < new Date().getTime()) {
				        alert("No puedes agendar en fechas ni horarios anteriores.");
				        $j('#calendar').weekCalendar("removeUnsavedEvents");
				        return false;
			     }
		    	 var oldDate = calEvent.start; 
		    	 
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
						alert('No puedes agendar en horarios no disponibles.');
						$jcalendar.weekCalendar('removeEvent',calEvent.id);
						return false;
					}
				
				var hora = calEvent.start.getHours()+":"+calEvent.start.getMinutes();
				var fecha = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
				
				 var drTurno = drEnTurno(cli, calEvent.start.getDay(), hora, calEvent.userId, fecha);
				 getTrtDr(drTurno.spc_id);
		         var $jdialogContent = $j("#event_edit_container");
		         resetForm($jdialogContent);
		         document.getElementById("patient").disabled = false;
		         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
		         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
		         var drField = $jdialogContent.find("select[name='dr']").val(drTurno.emp_id);
		         var trtField = $jdialogContent.find("select[name='trt']");
		         var patient = $jdialogContent.find("input[id='patient']");
		         var spc = $jdialogContent.find("select[name='spc']").val(drTurno.spc_id);
		         var patid = $j("#pat_id");
		         var obs = $jdialogContent.find("textarea[name='obs']");
		         var sillon = calEvent.userId;
		
		         $jdialogContent.dialog({
		            modal: true,
		            width: 450,
		            resizable: false,
		            title: "Agregar Cita",
		            close: function() {
		               $jdialogContent.dialog("destroy");
		               $jdialogContent.hide();
		               $j('#calendar').weekCalendar("removeUnsavedEvents");
		            },
		            buttons: {
		               Guardar : function() {
		            	  
		                   calEvent.start = new Date(startField.val());
		                   calEvent.end = new Date(endField.val());
		            	   
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
			       				alert('No puedes agendar en horarios no disponibles.');
			       				$jcalendar.weekCalendar('removeEvent',calEvent.id);
			       				return false;
			       			}
		            	   
		                  calEvent.id = id;
		                  id++;
		                  
		                  var trtIndex = document.getElementById("trt").selectedIndex;
		                  var drIndex = document.getElementById("dr").selectedIndex;
		                  
		                  if(drField.val() == ""){
		                	  alert("Debes seleccionar un doctor.");
		                	  return false;
		                  }
		                  if(spc.val() == ""){
		                	  alert("Debes seleccionar una especialidad.");
		                	  return false;
		                  }
		                  if(trtField.val() == ""){
		                	  alert("Debes seleccionar un tratamiento.");
		                	  return false;
		                  }
		                  if(patid.val() == ""){
		                	  alert("Debes seleccionar un paciente valido.");
		                	  return false;
		                  }
		                  
		                  var newDate = new Date(startField.val());
		            	 
		            	  
		            	  var nueva = newDate.getFullYear()+"-"+parseInt(newDate.getMonth()+1)+"-"+newDate.getDate();
		                  var vieja = oldDate.getFullYear()+"-"+parseInt(oldDate.getMonth()+1)+"-"+oldDate.getDate();
		                  
		                  calEvent.cli = cli
		                  calEvent.dr = drField.val();
		                  calEvent.trt = trtField.val();
		                  calEvent.patid = patid.val();
		                  calEvent.patient = patient.val();
		                  calEvent.spc = spc.val();
		                  calEvent.obs = obs.val();
		                  calEvent.vta = 1;
		                  calEvent.status = "Normal";
		                  calEvent.trtName = document.getElementById("trt").options[trtIndex].text;
		                  calEvent.drName = document.getElementById("dr").options[drIndex].text;
		                  
		                  var data = insertData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, sillon);
		               
		                  //alert("Vieja="+vieja+" Nueva="+nueva);
		                  
		                  if(vieja != nueva){
		                	  
		                	  gotoDate(nueva, calEvent.cli);
		                	  
		                  }
		                  else{
		                	  calEvent.color = data.color;
			                  calEvent.headerColor = data.headerColor;
			                  calEvent.id = data.key;
			                  calEvent.titulo = data.title;
			                  calEvent.vst_place = 0;   
			                  $jcalendar.weekCalendar("removeUnsavedEvents");
			                  $jcalendar.weekCalendar("updateEvent", calEvent);
			                  $jdialogContent.dialog("close");
		                  }
		                  
		                  
		              
		               },
		               Cancelar : function() {
		//                  $jdialogContent.dialog("close");
		                   $jdialogContent.dialog("destroy");
		                   $jdialogContent.hide();
		                   $j('#calendar').weekCalendar("removeUnsavedEvents");
		               }
		            }
		         }).show();
		
		         $jdialogContent.find("#selDate").val($jcalendar.weekCalendar("formatDate", calEvent.start));
		         setupStartAndEndTimeFields(startField, endField, calEvent, $jcalendar.weekCalendar("getTimeslotTimes", calEvent.start));
      		}
    	  else{
    		  $jcalendar.weekCalendar('removeEvent',calEvent.id);
    		  var oGParent = parent.parent;
    		  var gmtime = calEvent.start;
    		  //Thu Oct 06 2011 16:30:00 GMT-0500
    		  var time = gmtime.toString().split(" ");
    		  var hora = time[4].split(":");
    		  var sillon = (parseInt(calEvent.userId)+1);
    		  var fecha = calEvent.start.getFullYear()+"-"+(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
    		  
    	      oGParent.document.getElementById("iframe").style.display = "none";
    	      oGParent.document.getElementById("chooseClinic").checked = true;
    		  oGParent.document.getElementById("min_ini").selectedIndex = hora[0];
    		  oGParent.document.getElementById("vstdate").value = fecha;
    		  oGParent.document.getElementById("vstcli").value = cli;
    	      oGParent.selectDoctor(cli, sillon);
    	      oGParent.appointment();
	  
    	  }
      },
      eventDrop : function(calEvent, $jevent, $calEvent, freeBusyManager) {

    	  
	    	  if (calEvent.end.getTime() < new Date().getTime()) {
			        alert("No puedes modificar citas anteriores.");
			        $jcalendar.weekCalendar("refresh");
			        return false;
	    	  }

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
					alert('No puedes agendar en horarios no disponibles.');
					$jcalendar.weekCalendar("refresh");
					return false;
				}
				
				/*************************************************************************************/
				/*** Alert para avisar que se cambiara el dr. automaticamente por cambio de sillon ***/
				/*************************************************************************************/
				
				if($jevent.userId != calEvent.userId){
					var drChange = confirm("Al cambiar la cita de sill\u00F3n el doctor asignado tambi\u00E9n cambiar\u00E1 \n adicionalmente tendra que cambiar el tratamiento ¿seguro que desea continuar?");
					
					if(drChange){
					
						var hora = calEvent.start.getHours()+":"+calEvent.start.getMinutes();
						var fecha = calEvent.start.getFullYear()+"-"+parseInt(calEvent.start.getMonth()+1)+"-"+calEvent.start.getDate();
						var drTurno = drEnTurno(cli, calEvent.start.getDay(), hora, calEvent.userId, fecha);
						calEvent.trt = "";
						if(typeof(drTurno.emp_id) != "undefined" && drTurno.emp_id != null){
//							alert(drTurno.emp_id);
							calEvent.dr = drTurno.emp_id;
							calEvent.drName = drTurno.emp_complete;
							calEvent.titulo = drTurno.emp_abbr;
						}
					
					}else{
						$jcalendar.weekCalendar("refresh");
						return false;
					}
					
				}
				
				/*****************************************************************/
				/*** Cambiamos el status de la cita a normal al moverla de dia ***/
				/*****************************************************************/
				
				if($jevent.start.getDay() != dateIni.getDay()){		
					calEvent.vta = 1;
				}

	          var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, calEvent.vta);
	          
	          calEvent.color = data.color;
	          calEvent.headerColor = data.headerColor;
    	  
      },
      eventResize : function(calEvent, $jevent,$calEvent, freeBusyManager) {
    	 
	    	  if (calEvent.end.getTime() < new Date().getTime()) {
			        alert("No puedes modificar citas anteriores.");
			        $jcalendar.weekCalendar("refresh");
			        return false;
		     }
	    	  
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
					alert('No puedes agendar en horarios no disponibles.');
					$jcalendar.weekCalendar("refresh");
					return false;
				}
	          
			  var fourhours = calEvent.start.getTime() + 14400000;
			  if(calEvent.end.getTime() > fourhours){
				  alert("No puedes tener citas mayores de 4 horas.");
				  $jcalendar.weekCalendar("refresh");
				  return false;
			  }
				
	          editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, calEvent.vta);
    	  
      },
      eventClick : function(calEvent, $jevent) {
//    	  if (calEvent.end.getTime() < new Date().getTime()) {
//		        alert("No puedes modificar citas anteriores.");
//		        return false;
//	     }
    	  
         if (calEvent.readOnly) {
            return;
         }
         //alert(calEvent.toSource());
         var $jdialogContent = $j("#schInfoBox");
		$j("#infoDoctor").html(calEvent.drName);
		$j("#infoPaciente").html(calEvent.patient);
		$j("#infoTel").html(calEvent.tel);
		$j("#infoCita").html("Cita "+calEvent.status);
		$j("#infoTratamiento").html(calEvent.trtName);
		$j("#infoObs").html(calEvent.obs);
		
		$jdialogContent.dialog({
			modal: true,
            width: 450,
            resizable: false,
            title: "Información de la Cita",
            close: function() {
               $jdialogContent.dialog("destroy");
               $jdialogContent.hide();
            },
            buttons : {
            	
	               Cerrar : function() {
	                  //$jdialogContent.dialog("close");
	                   $jdialogContent.dialog("destroy");
	                   $jdialogContent.hide();
	                   $j('#calendar').weekCalendar("removeUnsavedEvents");
	               }
            	
            }
		});
		
		$jdialogContent.find(".date_holder").text($jcalendar.weekCalendar("formatDate", calEvent.start));
		
      },
      eventMouseover : function(calEvent, $jevent) {
      },
      eventMouseout : function(calEvent, $jevent) {
      },
      noEvents : function() {

      },
      data : function(start, end, callback) {
         
    	  document.getElementById("iniDate").value = start.getFullYear()+"-"+parseInt(start.getMonth()+1)+"-"+start.getDate();
    	  
          $j.getJSON("classes/getEvents.php",
          { 
              startDate: start.getFullYear()+"-"+parseInt(start.getMonth()+1)+"-"+start.getDate(),
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
        		  data : "startDate="+start.getFullYear()+"-"+parseInt(start.getMonth()+1)+"-"+start.getDate()+"&cli="+cli,
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
      $jdialogContent.find("select").val("");
      //$jdialogContent.find("textarea").val("");
   }

   function rightClick(event, calEvent){

	   if(calEvent.vst_place == 0){
				event.contextMenu('context-menu1',{
					
					'Iniciar Sesión':{
						click : function(element){
		//					if (calEvent.end.getTime() < new Date().getTime()) {
		//				        return false;
		//			 	    }
							var curYear = new Date().getFullYear();
							var curMonth = new Date().getMonth();
							var curDate = new Date().getDate();
							var fullDate = calEvent.end.getFullYear()+"-"+calEvent.end.getMonth()+"-"+calEvent.end.getDate();
							var getToday = curYear+"-"+curMonth+"-"+curDate;
							var usr = document.getElementById("cfg").innerHTML;
							
							if(fullDate != getToday){
								alert("Sólo puedes iniciar sesiones del día en curso.");
								return false;
							}
							
							  if(calEvent.vta == 5){
			            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
			            		   return false;
			            	   }
			            	   if(calEvent.vta == 6){
			            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
			            		   return false;
			            	   }
			            	   
			            	   var resp = confirm("¿Esta seguro que quiere iniciar sesión?");
			            	   
			            	   if(resp){
				                   
				                   /*********************************/
				                   /******* INICIAR SESION **********/
				                   /*********************************/
		
				                   
				                   var valor = $j.ajax({
				                	   
				                	   url : "../../classes/getAxaAuthStatus.php",
				                	   type : "POST",
				                	   data : "pat="+calEvent.patid,
				                	   async : false,
				                	   error : function(){
				                		   alert("Error");
				                	   }
				                	   
				                   }).responseText;
		
				                   if(valor != "OK") {
			       						alert("No se cuenta con un n\u00famero de autorizaci\u00f3n para este Paciente, por lo tanto " +
			       						"no se puede iniciar sesi\u00f3n. Consulta la descripci\u00f3n de plan en Empresas.");
			       						return false;
			       				   }
				                   
				                   $j.ajax({
				                	  
				                	   url : "../../classes/newSession.php",
				                	   type : "POST",
				                	   data : "cli="+cli+"&pat="+calEvent.patid+"&usr="+usr,
				                	   error : function(){
				                		   alert("Error");
				                	   },
				                   	   success : function(strData){
				                   		   
				                   		   
				                   		   if(valor == "OK"){
			   
				                   			var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, 5);
				                   			top.rightFrame.location.href = "../../classes/content.php?url=patients&profile=" + cli;
		//				            	   calEvent.color = data.color;
		//				                   calEvent.headerColor = data.headerColor;
		//				                   calEvent.titulo = data.title;
		//				                   calEvent.vta = 5;
		//				                   calEvent.status = "Asistida";
		//				                   $jcalendar.weekCalendar("updateEvent", calEvent);
						                   
				                   		   }else{
				                   			
				                   			   alert("Error al iniciar sesi\u00f3n. Regres\u00f3: " + valor);
				       						
				                   		   }
				                   		   
				                   	   }
				                	   
				                   });
				                   
				       				
				       			
				                   
				                   /*********************************/
				                   /*********************************/
				                   
			            	   }
						}
					},
					'Editar...':{
						click : function(element){
							if (calEvent.end.getTime() < new Date().getTime()) {
						        return false;
					 	    }
							var $jdialogContent = $j("#event_edit_container");
					         resetForm($jdialogContent);
					         
					         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
					         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
					         var drField = $jdialogContent.find("select[name='dr']").val(calEvent.dr);
					         var trtField = $jdialogContent.find("select[name='trt']").val(calEvent.trt);
					         var patid = $j("#pat_id").val(calEvent.patid);
					         document.getElementById("patient").disabled = true;
					         var patname = $j("#patient").val(calEvent.patient);
					         var observaciones = document.getElementById("obs"); 
					         
					         observaciones.textContent = calEvent.obs;
					         //alert(observaciones.textContent);
//					         var spc = $jdialogContent.find("select[name='spc']").val(calEvent.spc);
//					         var sillon = calEvent.userId;
//					         getTrtDr(spc.val(), calEvent.trt);
					         spcPorDr(calEvent.dr, calEvent.trt);
		
					         $jdialogContent.dialog({
					            modal: true,
					            width:420,
					            resizable: false,
		
					            title: "Editar Horario",
					            close: function() {
					               $jdialogContent.dialog("destroy");
					               $jdialogContent.hide();
					               $j('#calendar').weekCalendar("removeUnsavedEvents");
					            },
					            buttons: {
		
					               Editar : function() {

					            	   
					            	   if(calEvent.vta == 5){
					            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
					            		   return false;
					            	   }
					            	   if(calEvent.vta == 6){
					            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
					            		   return false;
					            	   }
					            	   
					            	   
					            	   	  if(drField.val() == ""){
						                	  alert("Debes seleccionar un doctor.");
						                	  return false;
						                  }
						                  if(patid.val() == ""){
						                	  alert("Debes seleccionar un paciente valido.");
						                	  return false;
						                  }
						                  if(trtField.val() == ""){
						                	  alert("Debes seleccionar un tratamiento.");
						                	  return false;
						                  }
					            	  
					            	  var newDate = new Date(startField.val());
					            	  var oldDate = calEvent.start; 
					            	  
					            	  var nueva = newDate.getFullYear()+"-"+parseInt(newDate.getMonth()+1)+"-"+newDate.getDate();
					                  var vieja = oldDate.getFullYear()+"-"+parseInt(oldDate.getMonth()+1)+"-"+oldDate.getDate();
					                  
//					                  alert("nueva: "+nueva+" | vieja: "+vieja);
//					                  return false;
					            	  
					                  calEvent.start = new Date(startField.val());
					                  calEvent.end = new Date(endField.val());
					                  calEvent.dr = drField.val();
					                  calEvent.trt = trtField.val();
					                  calEvent.cli = cli;
					                  calEvent.patid = patid.val();
					                  calEvent.obs = observaciones.value;
					                  
					                  var trtIndex = document.getElementById("trt").selectedIndex;
					                  var drIndex = document.getElementById("dr").selectedIndex;
					                  
					                  calEvent.patid = patid.val();
					                  calEvent.patient = patname.val();
					                  calEvent.vta = 1;
					                  calEvent.trtName = document.getElementById("trt").options[trtIndex].text;
					                  calEvent.drName = document.getElementById("dr").options[drIndex].text;
					                  
					                  
					                  var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, calEvent.vta);
					                  
					                  if(vieja != nueva){
					                	  
					                	  gotoDate(nueva, calEvent.cli);
					                	  
					                  }
					                  else{
						                  calEvent.color = data.color;
						                  calEvent.headerColor = data.headerColor;
						                  calEvent.titulo = data.title;
						                  $jcalendar.weekCalendar("updateEvent", calEvent);
						                  $jdialogContent.dialog("close");
					                  }
		
					               },
					               Cerrar : function() {
					                  //$jdialogContent.dialog("close");
					                   $jdialogContent.dialog("destroy");
					                   $jdialogContent.hide();
					                   $j('#calendar').weekCalendar("removeUnsavedEvents");
					               }
					            }
					         }).show();
		
					         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
					         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
					         $jdialogContent.find("#selDate").val($jcalendar.weekCalendar("formatDate", calEvent.start));
					         setupStartAndEndTimeFields(startField, endField, calEvent, $jcalendar.weekCalendar("getTimeslotTimes", calEvent.start));
					         $j(window).resize().resize(); //fixes a bug in modal overlay size ??
							
						}
					},
					'Confirmar':{
						click : function(element){
							if (calEvent.end.getTime() < new Date().getTime()) {
						        return false;
					 	    }
							   if(calEvent.vta == 5){
			            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
			            		   return false;
			            	   }
			            	   if(calEvent.vta == 2){
			            		   alert("Esta acción no esta permitida porque la cita ya esta confirmada.");
			            		   return false;
			            	   }
			            	   if(calEvent.vta == 6){
			            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
			            		   return false;
			            	   }
			            	   
			            	   var resp = confirm("¿Esta seguro que quiere confirmar esta cita?");
			            	   
			            	   if(resp){
				            	   var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, 2);
				            	   calEvent.color = data.color;
				                   calEvent.headerColor = data.headerColor;
				                   calEvent.titulo = data.title;
				                   calEvent.vta = 2;
				                   calEvent.status = "Confirmada";
				                   $jcalendar.weekCalendar("updateEvent", calEvent);
			            	   }
						}
					},
					'Cancelar':{
						click : function(element){
							if (calEvent.end.getTime() < new Date().getTime()) {
						        return false;
					 	    }
							if(calEvent.vta == 5){
			            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
			            		   return false;
			            	   }
			            	   if(calEvent.vta == 6){
			            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
			            		   return false;
			            	   }
			            	   
			            	  var resp = confirm("¿Esta seguro que quiere cancelar esta cita?");
			            	  
			            	  if(resp){
					                  deleteData(calEvent.id,7);
					                  $jcalendar.weekCalendar("removeEvent", calEvent.id);
			            	  }
						}
					},
					'Cerrar' : {
						click : function(element){
							
						}
					}
		//			,
		//			'Eliminar':{
		//				click : function(element){
		//					if (calEvent.end.getTime() < new Date().getTime()) {
		//				        return false;
		//			 	    }
		//					if(calEvent.vta == 5){
		//	            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
		//	            		   return false;
		//	            	   }
		//	            	   if(calEvent.vta == 6){
		//	            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
		//	            		   return false;
		//	            	   }
		//	            	   
		//	            	  var resp = confirm("¿Esta seguro que quiere eliminar esta cita?");
		//	            	  
		//	            	  if(resp){
		//			                  deleteData(calEvent.id,9);
		//			                  $jcalendar.weekCalendar("removeEvent", calEvent.id);
		//	            	  }
		//				}
		//				
		//			}
					
					
				});
				
   		}else{
   			
   			
			event.contextMenu('context-menu1',{
				
				'Iniciar Sesión':{
					click : function(element){
	//					if (calEvent.end.getTime() < new Date().getTime()) {
	//				        return false;
	//			 	    }
						var curYear = new Date().getFullYear();
						var curMonth = new Date().getMonth();
						var curDate = new Date().getDate();
						var fullDate = calEvent.end.getFullYear()+"-"+calEvent.end.getMonth()+"-"+calEvent.end.getDate();
						var getToday = curYear+"-"+curMonth+"-"+curDate;
						var usr = document.getElementById("cfg").innerHTML;
						
						if(fullDate != getToday){
							alert("Sólo puedes iniciar sesiones del día en curso.");
							return false;
						}
						
						  if(calEvent.vta == 5){
		            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
		            		   return false;
		            	   }
		            	   if(calEvent.vta == 6){
		            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
		            		   return false;
		            	   }
		            	   
		            	   var resp = confirm("¿Esta seguro que quiere iniciar sesión?");
		            	   
		            	   if(resp){
			                   
			                   /*********************************/
			                   /******* INICIAR SESION **********/
			                   /*********************************/
	
			                   
			                   var valor = $j.ajax({
			                	   
			                	   url : "../../classes/getAxaAuthStatus.php",
			                	   type : "POST",
			                	   data : "pat="+calEvent.patid,
			                	   async : false,
			                	   error : function(){
			                		   alert("Error");
			                	   }
			                	   
			                   }).responseText;
	
			                   if(valor != "OK") {
		       						alert("No se cuenta con un n\u00famero de autorizaci\u00f3n para este Paciente, por lo tanto " +
		       						"no se puede iniciar sesi\u00f3n. Consulta la descripci\u00f3n de plan en Empresas.");
		       						return false;
		       				   }
			                   
			                   $j.ajax({
			                	  
			                	   url : "../../classes/newSession.php",
			                	   type : "POST",
			                	   data : "cli="+cli+"&pat="+calEvent.patid+"&usr="+usr,
			                	   error : function(){
			                		   alert("Error");
			                	   },
			                   	   success : function(strData){
			                   		   
			                   		   
			                   		   if(valor == "OK"){
		   
			                   			var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, 5);
			                   			top.rightFrame.location.href = "../../classes/content.php?url=patients&profile=" + cli;
	//				            	   calEvent.color = data.color;
	//				                   calEvent.headerColor = data.headerColor;
	//				                   calEvent.titulo = data.title;
	//				                   calEvent.vta = 5;
	//				                   calEvent.status = "Asistida";
	//				                   $jcalendar.weekCalendar("updateEvent", calEvent);
					                   
			                   		   }else{
			                   			
			                   			   alert("Error al iniciar sesi\u00f3n. Regres\u00f3: " + valor);
			       						
			                   		   }
			                   		   
			                   	   }
			                	   
			                   });
			                   
			       				
			       			
			                   
			                   /*********************************/
			                   /*********************************/
			                   
		            	   }
					}
				},
//				'Editar...':{
//					click : function(element){
//						if (calEvent.end.getTime() < new Date().getTime()) {
//					        return false;
//				 	    }
//						var $jdialogContent = $j("#event_edit_container");
//				         resetForm($jdialogContent);     
//				         
//				         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
//				         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
//				         var drField = $jdialogContent.find("select[name='dr']").val(calEvent.dr);
//				         var trtField = $jdialogContent.find("select[name='trt']").val(calEvent.trt);
//				         var patid = $j("#pat_id").val(calEvent.patid);
//				         document.getElementById("patient").disabled = true;
//				         var patname = $j("#patient").val(calEvent.patient);
//				         var observaciones = document.getElementById("obs"); 
//				         
//				         observaciones.textContent = calEvent.obs;
//				         //alert(observaciones.textContent);
//				         var spc = $jdialogContent.find("select[name='spc']").val(calEvent.spc);
//				         var sillon = calEvent.userId;
//				         getTrtDr(spc.val(), calEvent.trt);
//				                  
//	
//				         $jdialogContent.dialog({
//				            modal: true,
//				            width:420,
//				            resizable: false,
//	
//				            title: "Editar Horario",
//				            close: function() {
//				               $jdialogContent.dialog("destroy");
//				               $jdialogContent.hide();
//				               $j('#calendar').weekCalendar("removeUnsavedEvents");
//				            },
//				            buttons: {
//	
//				               Editar : function() {
//				                  
//				            	   if(calEvent.vta == 5){
//				            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
//				            		   return false;
//				            	   }
//				            	   if(calEvent.vta == 6){
//				            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
//				            		   return false;
//				            	   }
//				            	   
//				                  calEvent.start = new Date(startField.val());
//				                  calEvent.end = new Date(endField.val());
//				                  calEvent.dr = drField.val();
//				                  calEvent.trt = trtField.val();
//				                  calEvent.cli = cli;
//				                  calEvent.patid = patid.val();
//				                  calEvent.obs = observaciones.value;
//				                  
//				                  var trtIndex = document.getElementById("trt").selectedIndex;
//				                  var drIndex = document.getElementById("dr").selectedIndex;
//				                  
//				                  calEvent.patid = patid.val();
//				                  calEvent.patient = patient.val();
//				                  calEvent.spc = spc.val();
//				                  calEvent.vta = 1;
//				                  calEvent.trtName = document.getElementById("trt").options[trtIndex].text;
//				                  calEvent.drName = document.getElementById("dr").options[drIndex].text;
//				                  
//				                  var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, calEvent.vta);
//				                  
//				                  calEvent.color = data.color;
//				                  calEvent.headerColor = data.headerColor;
//				                  calEvent.titulo = data.title;
//				                  $jcalendar.weekCalendar("updateEvent", calEvent);
//				                  $jdialogContent.dialog("close");
//	
//				               },
//				               Cerrar : function() {
//				                  //$jdialogContent.dialog("close");
//				                   $jdialogContent.dialog("destroy");
//				                   $jdialogContent.hide();
//				                   $j('#calendar').weekCalendar("removeUnsavedEvents");
//				               }
//				            }
//				         }).show();
//	
//				         var startField = $jdialogContent.find("select[name='start']").val(calEvent.start);
//				         var endField = $jdialogContent.find("select[name='end']").val(calEvent.end);
//				         $jdialogContent.find(".date_holder").text($jcalendar.weekCalendar("formatDate", calEvent.start));
//				         setupStartAndEndTimeFields(startField, endField, calEvent, $jcalendar.weekCalendar("getTimeslotTimes", calEvent.start));
//				         $j(window).resize().resize(); //fixes a bug in modal overlay size ??
//						
//					}
//				},
				'Confirmar':{
					click : function(element){
						if (calEvent.end.getTime() < new Date().getTime()) {
					        return false;
				 	    }
						   if(calEvent.vta == 5){
		            		   alert("Esta acción no esta permitida ya que el paciente ha iniciado su sesion.");
		            		   return false;
		            	   }
		            	   if(calEvent.vta == 2){
		            		   alert("Esta acción no esta permitida porque la cita ya esta confirmada.");
		            		   return false;
		            	   }
		            	   if(calEvent.vta == 6){
		            		   alert("Esta acción no esta permitida porque la sesión no fue asistida");
		            		   return false;
		            	   }
		            	   
		            	   var resp = confirm("¿Esta seguro que quiere confirmar esta cita?");
		            	   
		            	   if(resp){
			            	   var data = editData(calEvent.start, calEvent.end, calEvent.cli, calEvent.dr, calEvent.trt, escape(calEvent.patid), calEvent.obs, calEvent.userId, calEvent.id, 2);
			            	   calEvent.color = data.color;
			                   calEvent.headerColor = data.headerColor;
			                   calEvent.titulo = data.title;
			                   calEvent.vta = 2;
			                   calEvent.status = "Confirmada";
			                   $jcalendar.weekCalendar("updateEvent", calEvent);
		            	   }
					}
				},
				'Cerrar' : {
					click : function(element){
						
					}
				}
			});
   			
   		}
				
		
	};
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
               
               
               var res = startTime < $jtimestampsOfOptions.end[$j(this).text()];
               if($jtimestampsOfOptions.end[$j(this).text()] >= (parseInt(startTime)+15300000)){
            	   return false;
               } 
               return res;
               
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
        // $jendTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });
   
   
   
   
   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFieldsFromNewDay($jstartTimeField, $jendTimeField, timeslotTimes) {

      $jstartTimeField.empty();
      $jendTimeField.empty();

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         $jstartTimeField.append("<option value=\"" + startTime + "\">" + timeslotTimes[i].startFormatted + "</option>");
         $jendTimeField.append("<option value=\"" + endTime + "\">" + timeslotTimes[i].endFormatted + "</option>");

         $jtimestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $jtimestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $jendTimeOptions = $jendTimeField.find("option");
      $jstartTimeField.trigger("change");
      
   }
   

});
