var ff = document.getElementById && !document.all;

jQuery.noConflict();
var $j = jQuery;

$j(function(){

    var agregarClinica = $j("input#agregarClinica");
    var agregarPuesto = $j("input#agregarPuesto");

    agregarClinica.live("click", function(){

        $j.ajax({

            type: "POST",
            url: "getLists.php",
            data: "section=1&name=clinic",
            error: function(){
                alert("Error");
                },
              success: function(strData){

                  $j("td#clinicas").append(strData);

              }

            });

    });

    agregarPuesto.live("click", function(){

       $j.ajax({

            type: "POST",
            url: "getLists.php",
            data: "section=2",
            error: function(){
                alert("Error");
                },
              success: function(strData){

                   $j("td#puestos").append(strData);

              }

            });
      

    });

});


$j(function() {
	var quitarClinica = $j("img.quitarClinica");
	var quitarPuesto = $j("img.quitarPuesto");
	quitarClinica.live("click", function() {
		$j(this).parent("label").remove();
	});
	
	quitarPuesto.live("click", function() {
	   $j(this).parent("label").remove();
   });
});

$j(function(){

   

   $j("input#alta").click(function(){

            var lastname = $j("input#lastname");
            var surename = $j("input#surename");
            var name = $j("input#name");
            var phone = $j("input#phone");
            var cel = $j("input#cel");
            var clinic = $j("input#clinic");
            var usrclinic = $j("input#userclinic");
            var post = $j("input#post");
            var usr = $j("#uid").val();

            var aData = "lastname=" + lastname.val() + "&surename=" + surename.val() + "&name=" + name.val() + "&phone=" + phone.val() + "&cel=" + cel.val() +
                        "&clinic=" + clinic.val() + "&post=" + post.val()+"&usr="+usr;

            if(true){
                    $j.ajax({

                    type: "POST",
                    url: "alta.php",
                    data: aData,
                    error: function(){
                        alert("Error");
                        },
                      success: function(strData){

                            if(strData == "OK"){
                                alert("¡Alta insertada exitosamente!");
                                var input = window.parent.document.getElementsByTagName("input");
                                var select = window.parent.document.getElementsByTagName("select");
                                for(var i = 0; i<input.length; i++){
                                    if(input[i].type != "button"){
                                        input[i].value = "";
                                    }
                                }
                                for(var i = 0; i<select.length; i++){
                                    select[i].value = "";
                                }
                                window.parent.Lightview.hide();

                            }
                            else{
                                alert(strData);
                            }

                      }

                    });
            }

   });

});


document.observe("lightview:loaded", function() {

    var lastnamerequire = document.getElementById("lastnamerequire");
    var surenamerequire = document.getElementById("surenamerequire");
    var namerequire = document.getElementById("namerequire");
    var postrequire = document.getElementById("postrequire");
    var clinicrequire = document.getElementById("clinicrequire");

    lastnamerequire.style.display = "none";
    surenamerequire.style.display = "none";
    namerequire.style.display = "none";
    postrequire.style.display = "none";
    clinicrequire.style.display = "none";


      $("previa").observe('click', function() {

            var lastname = $("lastname");
            var surename = $("surename");
            var name = $("name");
            var phone = $("phone");
            var cel = $("cel");
            var clinic = document.getElementsByName("clinic");
            var userclinic = document.getElementsByName("userclinic");
            var post = document.getElementsByName("post");
            var usr = document.getElementById("cfg");
            var clinicList = "";
            var postList = "";
            var i;
            var j;

            if(typeof(clinic) != 'undefined' && clinic != null){

                    for(i=0; i<clinic.length; i++){
                        if(clinic[i].value != ""){
                            clinicList += clinic[i].value + "*";
                        }
                    }
            }

            if(typeof(post) != 'undefined' && post != null){

                    for(j=0; j<post.length; j++){
                        if(post[j].value != ""){
                            postList += post[j].value + "*";
                        }
                    }
            }

            if(lastname.getValue() == ""){
                lastnamerequire.style.display = "inline";
            }
            else if(surename.getValue() == ""){
                surenamerequire.style.display = "inline";
            }
            else if(name.getValue() == ""){
                namerequire.style.display = "inline";
            }   
            else if(clinicList == ""){
                clinicrequire.style.display = "inline";
            }
            else if(postList == ""){
                postrequire.style.display = "inline";
            }
            else{

            lastnamerequire.style.display = "none";
            surenamerequire.style.display = "none";
            namerequire.style.display = "none";
            postrequire.style.display = "none";
            clinicrequire.style.display = "none";

            var aData = "preview.php?lastname=" + lastname.getValue() + "&surename=" + surename.getValue() + "&name=" + name.getValue() + "&phone=" + phone.getValue() + "&cel=" + cel.getValue() +
                        "&clinic=" + clinicList + "&post=" + postList + "&usr=" + usr.innerHTML;

            Lightview.show({
                href: aData,
                rel: 'iframe',
                options: {
                width: 600,
                height: 500
                }


            });
            }
      });
});

function closeLightview(){
	window.parent.Lightview.hide();
}

$j(function(){

    $j("img.deleteEmp").click(function(){

        var usr = $j("#cfg").html();
        var id = $j(this).attr("id");
        var aData = "id="+id+"&section=1&usr_id=1";

        var confirma = confirm("\u00bfEstas seguro que quieres dar de baja a este empleado?");

        if(confirma){
            $j.ajax({

                type: "POST",
                url: "deleteEmp.php",
                data: aData,
                error: function(){
                    alert("Error");
                },
                  success: function(strData) {
                        if(strData == "OK") {
                            alert("Empleado dado de baja.");
                            window.location.reload();
                        }
                        else{
                            alert("Error al dar de baja el empleado.");
                        }

                  }

                });
        }

    });

});

$j(function(){
	var deleteClinic = $j("img.deleteClinica");
	var deletePost = $j("img.deletePuesto");
	
	deleteClinic.click(function() {
       var cli_id = $j(this).attr("id");
       var emp_id = document.getElementById("emp");
       var aData = "clinica="+cli_id+"&id="+emp_id.value+"&section=2";
       var confirmDelete = confirm("\u00bfEstas seguro que deseas quitar esta cl\u00ednica?");

       if(confirmDelete){
                $j(this).parent("label").remove();
               $j.ajax({

                    type: "POST",
                    url: "deleteEmp.php",
                    data: aData,
                    error: function(){
                        alert("Error");
                        }

               });


       }


    });
	
   deletePost.click(function(){
       var pst_id = $j(this).attr("id");
       var emp_id = document.getElementById("emp");
       var usr = $j("#uid").val();
       //alert(pst_id);
       var aData = "puesto="+pst_id+"&id="+emp_id.value+"&usr="+usr+"&section=3";
       //alert(aData);
       var confirmDelete = confirm("\u00bfEstas seguro que deseas quitar este puesto?");

       if(confirmDelete){
               $j(this).parent("label").remove();
               $j.ajax({

                    type: "POST",
                    url: "deleteEmp.php",
                    data: aData,
                    error: function(){
                        alert("Error");
                        }

               });
       }


   });


});

$j(function(){

   $j("#editar").click(function(){

            var lastname = $j("input#lastname");
            var surename = $j("input#surename");
            var name = $j("input#name");
            var phone = $j("input#phone");
            var cel = $j("input#cel");
            var alta = $j("input#alta");
            var clinic = document.getElementsByName("clinic");
            var post = document.getElementsByName("post");
            var exPost = document.getElementsByName("existingPost");
            var clinicList = "";
            var postList = "";
            var exPostList = "";
            var empid = $j("#emp").val();
            var uid = $j("#uid").val();
            var i;
            var j;
            var k;

            if(typeof(clinic) != 'undefined' && clinic != null){

                    for(i=0; i<clinic.length; i++){
                        if(clinic[i].value != ""){
                            clinicList += clinic[i].value + "*";
                        }
                    }
            }

            if(typeof(post) != 'undefined' && post != null){

                    for(j=0; j<post.length; j++){
                        if(post[j].value != ""){
                            postList += post[j].value + "*";
                        }
                    }
            }

            if(typeof(exPost) != 'undefined' && exPost != null){

                    for(k=0; k<exPost.length; k++){
                        if(exPost[k].value != ""){
                            exPostList += exPost[k].value + "*";
                        }
                    }
            }

            var aData = "lastname=" + lastname.val() + "&surename=" + surename.val() + "&name=" + name.val() + "&phone=" + phone.val() + "&cel=" + cel.val() +
                        "&clinic=" + clinicList + "&post=" + postList + "&empid="+empid+"&usr="+uid+"&exPost="+exPostList+"&alta="+alta.val();

        var confirma = confirm("\u00bfEstas seguro que los datos son correctos?");

        if(confirma){
            $j.ajax({

                type: "POST",
                url: "editEmployeeInfo.php",
                data: aData,
                error: function(){
                    alert("Error");
                    },
                  success: function(strData){

                        if(strData == "OK"){
                            alert("Empleado editado.");
                            window.parent.Lightview.hide();
                            window.parent.location.reload();
                        }
                        else{
                            alert("Error al editar empleado.");
                        }

                  }

                });
        }


   });

});

document.onclick = function(e) {
	deleteMenu();
	top.leftFrame.menuBehavior(null, true);
};