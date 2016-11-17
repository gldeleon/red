var ff = document.getElementById && !document.all;
var uid;
window.onload = function () {
    resetForm();
    uid = eval("document.getElementById('cfg')." + (ff ? "textContent" : "innerText"));
};
function setAutoCompleteValue(oField, type) {
    hideAutoComplete();
    var oType = document.getElementById(type);
    if (typeof (oType) != 'undefined' && oType != null) {
        oType.value = ff ? oField.textContent : oField.innerText;
    }
    var oID = (type == "doctor" || type == "clidoc") ? "empid" : (type == "patient") ? "patid" : (type == "recommendation") ? "recid" : "";
    var oObj = document.getElementById(oID);
    if (typeof (oObj) != 'undefined' && oObj != null) {
        oObj.value = oField.id;
    }
    oType.focus();
}

function showAutoComplete(oTextBox, searchType, e) {
    var firedEvt = ff ? e : event;
    var rf = document.getElementById("resFilter");
    if (typeof (rf) == 'undefined' || rf == null)
        return false;
    if (firedEvt.keyCode && firedEvt.keyCode == 27) {
        rf.style.visibility = "hidden";
        firedEvt.cancelBubble = true;
    }
    var bShown = false;
    if (oTextBox.value.length > 3) {
        rf.style.left = parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetParent.offsetLeft) +
                +parseInt(oTextBox.offsetParent.offsetLeft) + parseInt(oTextBox.offsetParent.offsetParent.offsetLeft) + 1 + "px";
        rf.style.top = parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetParent.offsetTop) +
                +parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetTop) + parseInt(oTextBox.offsetTop) +
                +parseInt(oTextBox.offsetHeight) + parseInt(oTextBox.offsetParent.offsetTop) - 1 + "px";
        rf.style.width = (oTextBox.offsetWidth - 2) + "px";
        var oTextBox_value = oTextBox.value.replace(/ñ/gi, "n");
        var oTexBoxID = (typeof (searchType) == 'undefined' || searchType == null) ? oTextBox.id : searchType;
        var sParams = "&filter=" + escape(oTextBox_value) + "&type=" + oTexBoxID + "&cli=" + cli;
        var valor = AjaxQuery("POST", "../classes/mFilter.php", false, sParams);
        if (valor.length > 0) {
            bShown = true;
            rf.innerHTML = valor;
        } else
            bShown = false;
    }
    rf.style.visibility = (bShown) ? "visible" : "hidden";
}

/** Se mantiene para efectos de compatibilidad. */
function showAgreementDesc(oObj, iAgrId) {
    return false;
}

function hideAutoComplete() {
    var resFilter = document.getElementById("resFilter");
    if (typeof (resFilter) != 'undefined' && resFilter != null)
        resFilter.style.visibility = "hidden";
}

function selectTelType(oId) {
    var oTelType = document.getElementById("teltype" + oId);
    if (typeof (oTelType) != 'undefined' && oTelType != null) {
        oTelType.checked = true;
    }
}

function resetForm() {
    var lastname = document.getElementById("lastname");
    var surename = document.getElementById("surename");
    var name = document.getElementById("name");
    var telnum = document.getElementById("telnum");
    var email = document.getElementById("email");
    if (typeof (lastname) == 'undefined' || typeof (surename) == 'undefined' || typeof (name) == 'undefined' ||
            typeof (telnum) == 'undefined' || typeof (email) == 'undefined') {
        return false;
    }
    for (var i = 1; i <= 3; i++) {
        var oTelType = document.getElementById("teltype" + i);
        if (typeof (oTelType) != 'undefined' && oTelType != null) {
            oTelType.checked = false;
        }
    }
    var telList = document.getElementById("telList");
    if (typeof (telList) != 'undefined' && telList != null) {
        for (var i = telList.options.length; i >= 0; i--)
            telList.options[i] = null;
    }
    lastname.value = "";
    surename.value = "";
    name.value = "";
    telnum.value = "";
    email.value = "";
}

function addToList(oList, oTel, sTelType) {
    var oList = document.getElementById(oList);
    var oTel = document.getElementById(oTel);
    var sTelType = document.getElementById(sTelType);
    if (typeof (oList) == 'undefined' || oList == null)
        return false;
    if (typeof (oTel) == 'undefined' || oTel == null)
        return false;
    if (typeof (sTelType) == 'undefined' || sTelType == null)
        return false;
    sTelType = sTelType.options[sTelType.selectedIndex].value;
    var bSelected = ((sTelType == "0") ? false : true);
    if (!bSelected) {
        alert("Selecciona un tipo de telefono.");
        return false;
    }
    var sNumTel = oTel.value.toString().replace(/ /g, "");
    sNumTel = sNumTel.replace(/[()+-]/g, "");
    if (sNumTel.length < 1) {
        alert("Numero telefonico no valido. Por favor verifica.");
        return false;
    }
    bExiste = false;
    for (var i = 0; i < oList.options.length; i++) {
        if (oList.options[i].value == sNumTel) {
            bExiste = true;
            break;
        }
    }
    if (!bExiste) {
        oList.options[oList.options.length] = new Option(oTel.value + " - " + sTelType, sNumTel);
    } else {
        alert("El numero ya existe.");
        return false;
    }
}

function removeFromList(oList) {
    var oList = document.getElementById(oList);
    if (typeof (oList) == 'undefined' || oList == null)
        return false;
    for (var i = 0; i < oList.options.length; i++) {
        if (oList.options[i].selected) {
            oList.options[i] = null;
            break;
        }
    }
}

function addPatient(oList) {
    var lastname = document.getElementById("lastname").value;
    var surename = document.getElementById("surename").value;
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var oList = document.getElementById("telList");
    var meetform = document.getElementById("meetform");
    meetform = meetform.options[meetform.selectedIndex].value;
    if (lastname == "" || name == "") {
        alert("Debes escribir el nombre y apellidos del Paciente.");
        return "VACIO";
    }

    var sParams = "&ln=" + lastname + "&sn=" + surename + "&nm=" + name + "&mail=" + email
            + "&option=false" + "&uid=" + uid + "&cli=" + cli + "&mtu=" + meetform;
    var sRes = "";
    for (var i = 0; i < oList.options.length; i++) {
        sRes += oList.options[i].text + "*";
    }
    sParams += "&tel=" + sRes;
    //alert(sParams);
    var valor = AjaxQuery("POST", "../classes/newPatient.php", false, sParams);
    //alert(valor);
//    if (valor == "OK" && valor.length > 8) {
//        alert("Paciente agregado correctamente");
//    } else {
//        alert("Ocurrio un error al agregar al paciente, favor de informar al administrador del sistema - Descripcion del error:  " + valor);
//    }
    //alert(valor);
    var bError = true;
    if (typeof (valor) != 'undefined' && valor != null) {
        var valPos = valor.split("*");
        valor = valPos[0];
        if (valor == "ERROR") {
            alert("Error al ingresar al paciente. Valor :" + valor);
            return false;
        } else if (valor == "EXISTE") {
            var sRes = confirm("El paciente ya está dado de alta. ¿Deseas agregarlo de cualquier forma? (no recomendado)");
            if (sRes == true) {
                var sParams = "&ln=" + lastname + "&sn=" + surename + "&nm=" + name + "&mail=" + email
                        + "&option=true" + "&uid=" + uid + "&cli=" + cli + "&mtu=" + meetform;
                sRes = "";
                for (var i = 0; i < oList.options.length; i++) {
                    sRes += oList.options[i].text + "*";
                }
                sParams += "&tel=" + sRes;
                var valor = AjaxQuery("POST", "../classes/newPatient.php", false, sParams);
                if (valor != "OK") {
                    alert("Error al ingresar al paciente. Valor :" + valor);
                    return false;
                } else if (valor == "OK") {
                    alert("Paciente agregado correcamente");
                    bError = false;
                }
            }
            return false;
        } else if (valor == "OK") {
            alert("Paciente agregado correctamente");
            bError = false;
        }

        if (!bError) {
            return valPos[1];
        }
    } else if (typeof (valor) == 'undefined' || valor == null) {
        alert("Fallo en consulta AJAX. Valor: " + valor);
        return false;
    }

}

document.oncontextmenu = function (e) {
    return true;
};