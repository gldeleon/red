/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('document').ready(function () {
    //$('#guardarclinic').click(function(){
    function ObtieneEdoMunCol(cp) {
        var url = 'https://api-codigos-postales.herokuapp.com/v2/codigo_postal/' + cp;
        $.ajax({
            // En data puedes utilizar un objeto JSON, un array o un query string
            //data: {"parametro1": "valor1", "parametro2": "valor2"},
            //Cambiar a type: POST si necesario
            type: "GET",
            // Formato de datos que se espera en la respuesta
            dataType: "json",
            // URL a la que se enviará la solicitud Ajax
            url: url,
        })
                .done(function (data, textStatus, jqXHR) {
                    if (console && console.log) {
                        $('#estado').val(data.estado);
                        $('#municipio').val(data.municipio);
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }
                });
    }

    $('#cp').focusout(function () {
        var cp = $(this).val();
        ObtieneEdoMunCol(cp);
    });

    $('#nombre').focusout(function () {
        var clinic = $(this).val();

        $.ajax({
            data: {"nombre": clinic},
            type: "POST",
            dataType: "json",
            url: "guardaClinica.php",
        })
                .done(function (data, textStatus, jqXHR) {
                    if (console && console.log) {
                        if (data == 'ok') {
                            //alert('Bien ese nombre de clinica está disponible');
                            $('#respuesta').empty();
                            $('#respuesta').removeClass('alert-warning');
                            $('#respuesta').append('Nombre Disponible <i class="fa fa-check" aria-hidden="true"></i><br />');
                            $('#respuesta').addClass('alert-success');
                        } else {
                            $('#respuesta').empty();
                            $('#respuesta').removeClass('alert-success');
                            $('#respuesta').append('Nombre ya existe <i class="fa fa-times" aria-hidden="true"></i><br />');
                            $('#respuesta').addClass('alert-warning');
                            //alert('Ya existe una clinica con ese nombre favor de revisarlo');
                        }
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }
                });
    });

    function limpiaCampos() {
        var address = $('#address').val('');
        var nombreclinica = $('#nombre').val('');
        var nombrecorto = $('#nombrecorto').val('');
        var telefono = $('#tel').val('');
        var email = $('#email').val('');
        var direccion = $('#direccion').val('');
        var municipio = $('#municipio').val('');
        var cp = $('#cp').val('');
        var ngoogle = $('#ngoogle').val('');
        var estado = $('#estado').val('');
        var latitud = $('#latitud').val('');
        var longitud = $('#longitud').val('');
        var usuario = $('#usuario').val('');
        var contrasena = $('#contrasena').val('');
    }

    $('#guardarclinic').confirm({
        title: '',
        content: 'Todos los datos están correctos?!',
        confirmButton: 'Seguro!',
        cancelButton: 'Cancelar!!',
        confirm: function () {
            var msj = '';
            var nombreclinica = $('#nombre').val();
            if (nombreclinica == '') {
                msj += 'Favor de capturar un nombre de clinica <br />';
            }
            var nombrecorto = $('#nombrecorto').val();
            if (nombrecorto == '') {
                msj += 'Favor de capturar un nombre corto de clinica <br />';
            }
            var telefono = $('#tel').val();
            if (telefono == '') {
                msj += 'Favor de capturar un número telefonico <br />';
            }
            var email = $('#email').val();
            if (email == '') {
                msj += 'Favor de capturar un correo electrónico <br />';
            }
            var direccion = $('#direccion').val();
            if (direccion == '') {
                msj += 'Favor de capturar una dirección válida <br />';
            }
            var municipio = $('#municipio').val();
            if (municipio == '') {
                msj += 'Favor de capturar el municipio correspondiente <br />';
            }
            var cp = $('#cp').val();
            if (cp == '') {
                msj += 'Favor de capturar el Código Postal <br />';
            }
            var ngoogle = $('#ngoogle').val();
            if (ngoogle == '') {
                msj += 'Favor de capturar el número de google <br />';
            }
            var estado = $('#estado').val();
            if (estado == '') {
                msj += 'Favor de capturar un Estado válido <br />';
            }
            var latitud = $('#latitud').val();
            if (latitud == '') {
                msj += 'Favor de capturar latitud <br />';
            }
            var longitud = $('#longitud').val();
            if (longitud == '') {
                msj += 'Favor de capturar longitud <br />';
            }
            var usuario = $('#usuario').val();
            if (usuario == '') {
                msj += 'Favor de capturar un nombre de usuario <br />';
            }
            var contrasena = $('#contrasena').val();
            if (contrasena == '') {
                msj += 'Favor de capturar una contraseña <br />';
            }
            if (msj == '') {
                var params = {
                    "altaclinica": "altaclinica",
                    "nclinica": nombreclinica,
                    "ncclinica": nombrecorto,
                    "tel": telefono,
                    "email": email,
                    "dir": direccion,
                    "municipio": municipio,
                    "cp": cp,
                    "ngoogle": ngoogle,
                    "edo": estado,
                    "lat": latitud,
                    "lng": longitud,
                    "usr": usuario,
                    "pwd": contrasena
                }
                $.ajax({
                    data: params,
                    type: "POST",
                    dataType: "json",
                    url: "guardaClinica.php",
                })
                        .done(function (data, textStatus, jqXHR) {
                            //
                            if (data == 'OK') {
                                $.alert({
                                    title: 'Red Kobe!',
                                    content: 'Clinica Guardada Correctamente!',
                                    confirm: function () {
                                        limpiaCampos();
                                    }
                                });
                            }

                            /*if ( console && console.log ) {
                             console.log( "La solicitud se ha completado correctamente." + data.param);
                             }*/
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            //alert('Algo salió mal, por favor intentalo de nuevo o comunicate con el área de sistemas.');
                            $.alert('Algo salió mal, por favor intentalo de nuevo o comunicate con el área de sistemas.');
                            /*if ( console && console.log ) {
                             console.log( "La solicitud a fallado: " +  textStatus);
                             }*/
                        });
                //$.alert('Se guardó la clinica ' + nombreclinica);
            } else {
                $.alert(msj);
            }

        },
        cancel: function () {
            $.alert('Cancelado!');
        }
    });


});