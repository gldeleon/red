<?php
	//echo $pat;
	$fnac = array();
	$dir = $other = array(0, 0);
	$tel = "";

	$pth_id = $agr_id = $pat_balance = $pat_nson = 0;
	$pat_ndate = $pat_ldate = "0000-00-00";
	$pat_lastname = $pat_surename = $pat_name = $pat_complete = $pat_gender = $pat_mail = "";
	$pat_occupation = $pat_mtstatus = $pat_address = $pat_okmail = $pat_telcontact = "";
	$query = "select null, agr_id, pat_lastname, pat_surename, pat_name, pat_complete,
	pat_ldate, pat_gender, pat_balance, pat_mail, pat_occupation, pat_ndate, pat_mtstatus, pat_nson,
	pat_address, pat_okmail, pat_telcontact from {$DBName}.patient
	where pat_id = '".utf8_decode($pat)."' limit 1";
	if($result = @mysql_query($query, $link)) {
		list($pth_id, $agr_id, $pat_lastname, $pat_surename, $pat_name, $pat_complete, $pat_ldate,
		$pat_gender, $pat_balance, $pat_mail, $pat_occupation, $pat_ndate, $pat_mtstatus, $pat_nson,
		$pat_address, $pat_okmail, $pat_telcontact) = @mysql_fetch_array($result);
		@mysql_free_result($result);
	}

	$pth_id = $num = 0;
	$pth_date = date("Y-m-d");
	$pth_penic = $pth_antib = $pth_anfinf = $pth_analg = $pth_sulf = $pth_oth = $pth_other = "";
	$pth_diab = $pth_hepat = $pth_asthma = $pth_heart = $pth_coagul = $pth_reum = $pth_hemo = "";
	$pth_hypot = $pth_hypert = $pth_pres = $pth_faint = $pth_oper = $pth_convul = $pth_othd = "";
	$pth_othdis = $pth_anes = $pth_anrct = $pth_react = $pth_caut = $pth_health = $pth_teethf = "";
	$pth_chang = $pth_smile = $pth_smiled = $pth_tcolor = $pth_tcolord = $pth_ences = $pth_encesd = "";
	$pth_lastv = $pth_pregnan = $pth_pregmon = $pth_pregnum = $pth_painst = $pth_acpain = $pth_mouth = "";
	$pth_expan = $pth_cold = $pth_sweet = $pth_chew = $pth_drink = $pth_touch = $pth_physef = "";
	$pth_fever = $pth_dentp = $pth_bleeding = $pth_ease = $pth_medicin = $pth_mdcwch = $pth_stand = "";
	$pth_othmed = $pth_comm = $pth_prxcli = $pth_oprxcli = $pth_knowd = $pth_recd = $pth_orecd = $pth_pain = "";
	$query1 = "select pth_id, pth_penic, pth_antib, pth_anfinf, pth_analg, pth_sulf, pth_oth,
	pth_other, pth_diab, pth_hepat, pth_asthma, pth_heart, pth_coagul, pth_reum, pth_hemo, pth_hypot,
	pth_hypert, pth_pres, pth_faint, pth_oper, pth_convul, pth_othd, pth_othdis, pth_anes, pth_anrct,
	pth_react, pth_caut, pth_health, pth_teethf, pth_chang, pth_smile, pth_smiled, pth_tcolor, pth_tcolord,
	pth_ences, pth_encesd, pth_lastv, pth_pregnan, pth_pregmon, pth_pregnum, pth_painst, pth_acpain, pth_mouth,
	pth_expan, pth_cold, pth_sweet, pth_chew, pth_drink, pth_touch, pth_physef, pth_fever, pth_dentp, pth_bleeding,
	pth_ease, pth_medicin, pth_mdcwch, pth_stand, pth_othmed, pth_comm, pth_prxcli, pth_oprxcli, pth_knowd,
	pth_recd, pth_orecd, pth_pain, pth_date from {$DBName}.pathistory where pat_id = '".utf8_decode($pat)."'";
	if($result = @mysql_query($query1, $link)) {
		$num = @mysql_num_rows($result);
		if($num > 0) {
			$row = @mysql_fetch_array($result);
			//array_walk($row, "array_utf8_encode");
			list($pth_id, $pth_penic, $pth_antib, $pth_anfinf, $pth_analg, $pth_sulf, $pth_oth, $pth_other,
			$pth_diab, $pth_hepat, $pth_asthma, $pth_heart, $pth_coagul, $pth_reum, $pth_hemo, $pth_hypot,
			$pth_hypert, $pth_pres, $pth_faint, $pth_oper, $pth_convul, $pth_othd, $pth_othdis, $pth_anes,
			$pth_anrct, $pth_react, $pth_caut, $pth_health, $pth_teethf, $pth_chang, $pth_smile, $pth_smiled,
			$pth_tcolor, $pth_tcolord, $pth_ences, $pth_encesd, $pth_lastv, $pth_pregnan, $pth_pregmon,
			$pth_pregnum, $pth_painst, $pth_acpain, $pth_mouth, $pth_expan, $pth_cold, $pth_sweet, $pth_chew,
			$pth_drink, $pth_touch, $pth_physef, $pth_fever, $pth_dentp, $pth_bleeding, $pth_ease, $pth_medicin,
			$pth_mdcwch, $pth_stand, $pth_othmed, $pth_comm, $pth_prxcli, $pth_oprxcli, $pth_knowd, $pth_recd,
			$pth_orecd, $pth_pain, $pth_date) = $row;
			$pth_id = is_null($pth_id) ? 0 : $pth_id;
		}
	}

	$query3 = "select pta_date from {$DBName}.pthaudit where pta_type = 1 and pth_id = {$pth_id}";
?>
<style type="text/css">
<!--
	em { color: #F00; font-family: Tahoma, Arial, Helvetica; font-size: 14px; font-weight: bold; line-height: 12px; }
	input[type="radio"] { background-color: #FFF; width: 12px; height: 12px; margin: 0px; padding: 0px; margin-top: 5px; }
	.borde { border: 1px solid; }
	hr { color: #E6701D; background-color: #E6701D; height: 1px; width: 100%; border: 1px solid; margin-top: 5px; text-align: center; }
-->
</style>
<script language="JavaScript" type="text/javascript">
/* [CDATA[ */
	function validausuario(){
		if(document.getElementById('usr').value == '' || document.getElementById('psw').value == ''){
			alert('El usuario o contrase\u00f1a no es correcto, por favor intenta de nuevo.');
			return false;
		}
		var valores = '&user=' + document.getElementById('usr').value + '&pswd=' + document.getElementById('psw').value;
		var resp = AjaxQuery("POST", "../modules/mod_pat_history/checkuser.php", false, valores);
		var respuesta = resp.split("*");
		var msg = respuesta[0];
		var empid = respuesta[1];
		if(msg != "EXISTE" ){
			alert('El usuario o contrase\u00f1a no es correcto, por favor intenta de nuevo.');
			return false;
		}
		else{
			validadatosform(empid);
		}
	}

	function auditor(){
		var user = document.getElementById("user").value;
		var paswd = document.getElementById("paswd").value;
		if(user == '' || paswd == ''){
			alert('El usuario o contrase\u00f1a no es correcto, por favor intenta de nuevo');
			return false;
		}
		var valores = '&user='+user+'&paswd='+paswd;
		var resp = AjaxQuery("POST", "../modules/mod_pat_history/userAudit.php", false, valores);
		//alert(resp);
		var respuesta = resp.split("*");
		var msg = respuesta[0];
		var empid = respuesta[1];
		if(msg != "EXISTE"){
			if(empid == "DENEGADO"){
				alert('No estas autorizado para realizar la auditoria');
				return false;
			}
			alert('El usuario o contrase\u00f1a no es correcto, por favor intenta de nuevo');
			return false;
		}
		else{
			auditoria(empid);
		}
	}
	function validadatosform(empid){
		var employee = empid;
		/*if(document.getElementById('col').value == '0' || document.getElementById('col').value == ''){
			alert('Datos incompletos por favor verifica 1');
			return false;
		}
		if(document.getElementById('cp').value == '0' || document.getElementById('cp').value == ''){
			alert('Datos incompletos por favor verifica 2');
			return false;
		}*/
		if(document.getElementById('enteraste1').checked == false && document.getElementById('enteraste2').checked == false && document.getElementById('enteraste3').checked == false && document.getElementById('enteraste4').checked == false && document.getElementById('enteraste5').checked == false){
			alert('Datos incompletos. Por favor verifica secci\u00f3n de \"C\u00f3mo te enteraste de Red Kobe\"');
			return false;
		}
		if(document.getElementById('enteraste4').checked == true && document.getElementById('patient').value==''){
			alert('Datos incompletos, quien recomendo?');
			return false;
		}
		if(document.getElementById('contacto1').checked == false && document.getElementById('contacto2').checked == false && document.getElementById('contacto3').checked == false && document.getElementById('contacto4').checked == false){
			alert('Datos incompletos, forma de contacto');
			return false;
		}
		if(document.getElementById('pnc1').checked == false && document.getElementById('pnc2').checked == false){
			alert('Datos incompletos, seccion alergias');
			return false;
		}
		if(document.getElementById('atb1').checked == false && document.getElementById('atb2').checked == false){
			alert('Datos incompletos, seccion alergias');
			return false;
		}
		if(document.getElementById('antf1').checked == false && document.getElementById('antf2').checked == false){
			alert('Datos incompletos, seccion alergias');
			return false;
		}
		if(document.getElementById('ang1').checked == false && document.getElementById('ang2').checked == false){
			alert('Datos incompletos, seccion alergias');
			return false;
		}
		if(document.getElementById('slf1').checked == false && document.getElementById('slf2').checked == false){
			alert('Datos incompletos, seccion alergias');
			return false;
		}
		/*if(document.getElementById('ots1').checked == true && document.getElementById('otroaler').value ==''){
			alert('Datos incompletos por favor verifica 11');
			return false;
		}*/
		if(document.getElementById('db1').checked == false && document.getElementById('db2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('hp1').checked == false && document.getElementById('hp2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('asm1').checked == false && document.getElementById('asm2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('heart1').checked == false && document.getElementById('heart2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('pc1').checked == false && document.getElementById('pc2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('fr1').checked == false && document.getElementById('fr2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('hm1').checked == false && document.getElementById('hm2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('hipo1').checked == false && document.getElementById('hipo2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('hipe1').checked == false && document.getElementById('hipe2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('pres1').checked == false && document.getElementById('pres2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('df1').checked == false && document.getElementById('df2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('opc1').checked == false && document.getElementById('opc2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		if(document.getElementById('cv1').checked == false && document.getElementById('cv2').checked == false){
			alert('Datos incompletos, seccion enfermedades');
			return false;
		}
		/*if(document.getElementById('oth1').checked == true && document.getElementById('otroenf').value ==''){
			alert('Datos incompletos por favor verifica 24');
			return false;
		}*/
		if(document.getElementById('adntl1').checked == false && document.getElementById('adntl2').checked == false){
			alert('Datos incompletos, por favor verifica \"Anestesia dental\"');
			return false;
		}
		if(document.getElementById('reac1').checked == false && document.getElementById('reac2').checked == false){
			alert('Datos incompletos, por favor verifica \"Reacci\u00f3n adversa a la anestesia\"');
			return false;
		}
		if(document.getElementById('reac1').checked == true && document.getElementById('descreac').value == ''){
			alert('Datos incompletos, por favor verifica \"Descripci\u00f3n de reacci\u00f3n a la anestesia\"');
			return false;
		}
		if(document.getElementById('v1').checked == false && document.getElementById('v2').checked == false && document.getElementById('v3').checked == false && document.getElementById('v4').checked == false){
			alert('Datos incompletos, por favor verifica \"Ultima visita al dentista\".');
			return false;
		}
		if(document.getElementById('embda1').disabled == false ){
			if(document.getElementById('embda1').checked == false && document.getElementById('embda2').checked == false){
				alert('Datos incompletos, por favor verifica \"S\u00f3lo mujeres\"');
				return false;
			}
			if(document.getElementById('embda1').checked == true && document.getElementById('meses').value == ''){
				alert('Datos incompletos, por favor verifica \"Meses de embarazo\"');
				return false;
			}
			if(document.getElementById('embzos').value == ''){
				alert('Datos incompletos, por favor verifica \"N\u00famero de embarazos\".');
				return false;
			}
		}
		if(document.getElementById('tiene1').checked == false && document.getElementById('tiene2').checked == false){
			alert('Datos incompletos, por favor verifica \"Presencia de dolor en el paciente\".');
			return false;
		}
		if(document.getElementById('coment').value == ''){
			alert('Datos incompletos, por favor verifica \"Comentarios o aclaraciones\".');
			return false;
		}
		enviadatosform(employee);
	}

	function checkselected(radio) {
		for(i = 0; i < radio.length; i++) {
			if (radio[i].checked) {
				return radio[i].value;
			}
		}
		return false;
	}

	function checkProximity() {
		proxim = '';
		proxim += ((document.getElementById('casa').checked) ? document.getElementById('casa').value + ',' : '');
		proxim += ((document.getElementById('oficina').checked) ? document.getElementById('oficina').value + ',' : '');
		proxim += ((document.getElementById('escuela').checked) ? document.getElementById('escuela').value + ',' : '');
		proxim += ((document.getElementById('otroproxch').checked) ? document.getElementById('otroproxch').value : '');
		return proxim;
	}

	function enviadatosform(employee){
		var empid = employee;
		var okmail = (document.getElementById('mailchk').checked) ? '1' : '0';
		var param = '';
		param += '&opcion=guarda' + '&pthid=' + document.getElementById('pthid').value + '&empid=' + empid + '&cli=' + cli + '&pat_id=' + document.getElementById('pat').value;
		param += '&sexo=' + document.getElementById('sexo').options[document.getElementById('sexo').selectedIndex].value;
		if(document.getElementById('ocupacion').options[document.getElementById('ocupacion').selectedIndex].value == '46'){
			if(document.getElementById('occupation').value == ''){
				alert('Datos incompletos, por favor verifica \"Ocupaci\u00fen\".');
				return false;
			}
			else{
				param += '&job='+document.getElementById('ocupacion').options[document.getElementById('ocupacion').selectedIndex].value+'-'+document.getElementById('occupation').value;
			}
		}
		else{
			param += '&job=' + document.getElementById('ocupacion').options[document.getElementById('ocupacion').selectedIndex].value;
		}
		param+='&col='+document.getElementById('col').value+'&cp='+document.getElementById('cp').value;
		param+='&dia='+document.getElementById('dia').value+'&mes='+document.getElementById('mes').value+'&anio='+document.getElementById('anio').value;
		param+='&edociv='+document.getElementById('edocivil').options[document.getElementById('edocivil').selectedIndex].value;
		param+='&nohijo='+document.getElementById('nohijo').value;
		param+='&proxim='+checkProximity()+'&otrproxim='+document.getElementById('otroprox').value;
		param+='&recom='+checkselected(document.history.enteraste)+'&rec='+document.getElementById('patient').value+'&recotro='+document.getElementById('recotro').value;
		param+='&mail='+document.getElementById('mail').value+'&okmail='+okmail;
		param+='&telcasa='+document.getElementById('telcasa').value+'&teloficina='+document.getElementById('teloficina').value;
		param+='&telcel='+document.getElementById('telcel').value+'&telnex='+document.getElementById('telnex').value+'&foncontact='+checkselected(document.history.contacto);
		param+='&penic='+checkselected(document.history.pnc)+'&antb='+checkselected(document.history.atb);
		param+='&antf='+checkselected(document.history.antf)+'&ang='+checkselected(document.history.ang);
		param+='&slf='+checkselected(document.history.slf)+'&ots='+checkselected(document.history.ots);
		param+='&otroaler='+document.getElementById('otroaler').value;
		param+='&adntl='+checkselected(document.history.adntl)+'&reac='+checkselected(document.history.reac);
		param+='&db='+checkselected(document.history.db)+'&hp='+checkselected(document.history.hp);
		param+='&asm='+checkselected(document.history.asm)+'&heart='+checkselected(document.history.heart);
		param+='&pc='+checkselected(document.history.pc)+'&fr='+checkselected(document.history.fr);
		param+='&hm='+checkselected(document.history.hm)+'&hipo='+checkselected(document.history.hipo);
		param+='&hipe='+checkselected(document.history.hipe);
		param+='&pres='+checkselected(document.history.pres)+'&df='+checkselected(document.history.df);
		param+='&opc='+checkselected(document.history.opc)+'&cv='+checkselected(document.history.cv);
		param+='&otroenf='+document.getElementById('otroenf').value;
		param+='&oth='+checkselected(document.history.oth)+'&descreac='+document.getElementById('descreac').value;
		param+='&prectrt='+document.getElementById('prectrt').value+'&embda='+checkselected(document.history.embda);
		param+='&meses='+document.getElementById('meses').value+'&embzos='+document.getElementById('embzos').value;
		param+='&salud='+document.getElementById('salud').value;
		param+='&dientes='+document.getElementById('dientes').value+'&cambios='+document.getElementById('cambios').value;
		param+='&smile='+checkselected(document.history.smile)+'&sonrisa='+document.getElementById('sonrisa').value;
		param+='&like='+checkselected(document.history.like)+'&colordte='+document.getElementById('colordte').value;
		param+='&encia='+checkselected(document.history.encia)+'&ensiasna='+document.getElementById('ensiasna').value;
		param+='&visit='+checkselected(document.history.visita)+'&dolor=no';
		param+='&tiene='+checkselected(document.history.tiene);
		param+='&dlragudo=0'+'&mandi=0';
		param+='&cuerpo=0'+'&almf=0';
		param+='&alml=0'+'&mast=0';
		param+='&beber=0'+'&touch=0';
		param+='&esfzo=0'+'&feber=0';
		param+='&pdp=0'+'&sang=0';
		param+='&alivio=""'+'&mejoro=0';
		param+='&medicamentos=""';//'&razon='+document.getElementById('razon').value+
		param+='&reposo=0';//+'&rznreposo='+document.getElementById('rznreposo').value
		param+='&tomamdto=""'+'&coment='+document.getElementById('coment').value;
		param+='&day='+document.getElementById('day').options[document.getElementById('day').selectedIndex].value;
		param+='&month='+document.getElementById('month').options[document.getElementById('month').selectedIndex].value;
		param+='&year='+document.getElementById('year').options[document.getElementById('year').selectedIndex].value;
		//alert(param);
		var valor = AjaxQuery("POST", "../modules/mod_pat_history/sethistory.php", false, param);
		//alert(valor);
		var respuesta = valor.split("*");
		var msg = respuesta[0];
		if(msg != "OK" ){
//			alert("Hubo un problema al guardar la informaci\u00f3n. Por favor, revisa los datos.");
			alert("Historia clínica completa. Gracias");
			return false;
		}
		else{
			alert("\u00a1Cambios guardados!");
			location.reload(true);
		}

	}

	function auditoria(employee) {
		var pthid = document.getElementById('pthid').value;
		var empid = employee;
		var correcta = checkselected(document.history.correcta);
		if(document.getElementById("correcta1").checked == false && document.getElementById("correcta2").checked == false){
			alert("Debes seleccionar una opci\u00f3n");
			return false;
		}
		var param = 'opcion=audita'+'&pthid='+pthid+'&empid='+empid+'&cli='+cli+'&correcta='+correcta;
		//alert(param);
		var valor = AjaxQuery("POST","../modules/mod_pat_history/sethistory.php", false, param);
		//alert(valor);
		var respuesta = valor.split("*");
		var msg = respuesta[0];
		if(msg != "OK"){
//			alert("Hubo un problema al guardar la informaci\u00f3n. Por favor, revise los datos.");
			alert("Historia clínica completa. Gracias");
			return false;
		}
		else{
			alert("\u00a1Cambios guardados!");
			location.reload(true);
		}
	}

	function habilitainput(id) {
		var object = document.getElementById(id);
		if(object.disabled == true){
			object.disabled = false;
			object.focus();
		}
		else{
			object.disabled = true;
			object.value = '';
		}
	}

	function habilita(Id) {
		var object = document.getElementById(Id);
		if(object.disabled == true){
			object.disabled = false;
			object.focus();
		}
	}

	function deshabilita(Id) {
		var object = document.getElementById(Id);
		if(object.disabled == false){
			object.disabled = true;
			object.value='';
		}
	}

	function mujer(id) {
		var sexo = id;
		if(sexo == "FE") {
			document.getElementById('embda1').disabled = false;
			document.getElementById('embda2').disabled = false;
		}
		else{
			document.getElementById('embda1').disabled = true;
			document.getElementById('embda2').disabled = true;
		}
	}

	function habilitamujer() {
		if(document.getElementById('sexo').options[document.getElementById('sexo').selectedIndex].value=='FE'){
			document.getElementById('embda1').disabled = false;
			document.getElementById('embda2').disabled = false;
		}
	}

	function otherjob(id) {
		var other = id;
		if(other == '46') {
			document.getElementById('occupation').disabled = false;
			document.getElementById('occupation').value = '';
			document.getElementById('occupation').focus();
		}
		else{
			document.getElementById('occupation').value = '';
			document.getElementById('occupation').disabled = true;
		}
	}

	function deselecciona() {
		/*var rad = document.getElementsByTagName('input');
		if(typeof(rad) != 'undefined' && rad != null) {
			var num = rad.length;
			if(num != null && num > 0) {
				for(j = 0; j <= num; j++) {
					if(rad[j].type == 'radio') {
						rad[j].checked = false;
					}
				}
			}
		}*/
	}

	function addLoadEvent(func) {
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		}
		else {
			window.onload = function() {
				oldonload();
				func();
			};
		}
	}

	var row = parseInt('<?=$num; ?>');
	row = isNaN(row) ? 0 : row;
	if(row < 1 ) {
		addLoadEvent(habilitamujer);
		addLoadEvent(deselecciona);
	}

	function validar(e) { // 1
		tecla = (document.all) ? e.keyCode : e.which; // 2
		if (tecla==8) return true; // 3
		patron = /\d/; // 4
		te = String.fromCharCode(tecla); // 5
		return patron.test(te); // 6
	}

	function setAutoCompleteValue(oField, type) {
		hideAutoComplete();
		var oType = document.getElementById(type);
		if(typeof(oType) != 'undefined' && oType != null)
			oType.value = ff ? oField.textContent : oField.innerText;
		var oID = (type == "doctor") ? "empid" : (type == "patient") ? "patid" : "";
		var oObj = document.getElementById(oID);
		if(typeof(oObj) != 'undefined' && oObj != null)
			oObj.value = oField.id;
		oType.focus();
	}

	function showAutoComplete(oTextBox, searchType, e) {
		var firedEvt = ff ? e : event;
		var rf = document.getElementById("resFilter");
		if(typeof(rf) == 'undefined' || rf == null)
			return false;
		if(firedEvt.keyCode && firedEvt.keyCode == 27) {
			if(rf.style.visibility == "visible")
				rf.style.visibility = "hidden";
			else
				oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.style.visibility = "hidden";
			firedEvt.cancelBubble = true;
		}
		var bShown = false;
		if(oTextBox.value.length > 3) {
			rf.style.left = parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetLeft) +
			+ parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetLeft) +
			+ parseInt(oTextBox.offsetParent.offsetLeft) + parseInt(oTextBox.offsetParent.offsetParent.offsetLeft) + 155 + "px";
			rf.style.top = parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetParent.offsetTop) +
			+ parseInt(oTextBox.offsetParent.offsetParent.offsetParent.offsetTop) + parseInt(oTextBox.offsetTop) +
			+ parseInt(oTextBox.offsetHeight) + parseInt(oTextBox.offsetParent.offsetTop) - 95 + "px";
			rf.style.width = (oTextBox.offsetWidth - 2) + "px";
			var oTextBox_value = oTextBox.value.replace(/�/gi, "n");
			var oTexBoxID = (typeof(searchType) == 'undefined' || searchType == null) ? oTextBox.id : searchType;
			var sParams = "&filter=" + escape(oTextBox_value) + "&type=" + oTexBoxID + "&cli=" + cli;
			var valor = AjaxQuery("POST", "../classes/mFilter.php", false, sParams);
			if(valor.length > 0) {
				bShown = true;
				rf.innerHTML = valor;
			}
			else
				bShown = false;
		}
		rf.style.visibility = (bShown) ? "visible" : "hidden";
	}

	function hideAutoComplete() {
		document.getElementById("resFilter").style.visibility = "hidden";
	}

	function showAgreementDesc(oObj, iAgrId) {
		return false;
	}
/* ]] */
</script>
<div id="subMenu" style="position: absolute; visibility: hidden;"></div>
<div id="resFilter" style="top: 0px; left: 0px; overflow-x: hidden; overflow-y: scroll;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="3" id="n">
		<!-- <div id="mContent" style="width: 100%; height: 100%;" onscroll="hideAutoComplete();">
		<center>
		<br/><br/> -->
		<form name="history" id="history">
		<input type="hidden" name="pat" id="pat" value="<?=($pat); ?>" />
		<input type="hidden" name="pthid" id="pthid" value="<?=$pth_id; ?>" />
		<table width="800" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td height="30" colspan="7" align="center" valign="top" style="font-size: 14px; color: #000;"><b>Por favor llena aqu&iacute; la informaci&oacute;n tal cual como el paciente la llen&oacute; en su historia cl&iacute;nica.</b></td>
		</tr>
		<tr>
			<td height="30" colspan="7" align="center" valign="top" style="font-size: 12px; color: #000;">Todos los campos marcados con <em>*</em> son obligatorios</td>
		</tr>
		<tr>
			<td align="right">
				<table>
				<tr>
					<td height="20" valign="top" style="font-size: 12px; color: #000;"><em>*</em><b>&nbsp;&nbsp;Fecha de llenado de la Historia Cl&iacute;nica f&iacute;sica:</b></td>
					<td width="50">
					<?
						$fsave = explode("-", $pth_date);
					?>
						<select name="day" id="day" style="border: 1px solid #E6701D; font-size: 12px; width: 50px;">
							<option value="0">---</option>
							<?
							for($i=1; $i <= 31; $i++) {
								$selected = ($i == $fsave[2]) ? " selected = \"selected\"" : "";
								echo "<option value = \"".$i."\"".$selected.">".$i."</option>\n";
							}
							?>
						</select>
					</td>
					<td width="120">
						<select name="month" id="month" style="border: 1px solid #E6701D; font-size: 12px; width: 120px;">
							<option value="0">---</option>
							<option value="1" <?if($fsave[1]=='1') echo "selected";?>>Enero</option>
							<option value="2" <?if($fsave[1]=='2') echo "selected";?>>Febrero</option>
							<option value="3" <?if($fsave[1]=='3') echo "selected";?>>Marzo</option>
							<option value="4" <?if($fsave[1]=='4') echo "selected";?>>Abril</option>
							<option value="5" <?if($fsave[1]=='5') echo "selected";?>>Mayo</option>
							<option value="6" <?if($fsave[1]=='6') echo "selected";?>>Junio</option>
							<option value="7" <?if($fsave[1]=='7') echo "selected";?>>Julio</option>
							<option value="8" <?if($fsave[1]=='8') echo "selected";?>>Agosto</option>
							<option value="9" <?if($fsave[1]=='9') echo "selected";?>>Septiembre</option>
							<option value="10" <?if($fsave[1]=='10') echo "selected";?>>Octubre</option>
							<option value="11" <?if($fsave[1]=='11') echo "selected";?>>Noviembre</option>
							<option value="12" <?if($fsave[1]=='12') echo "selected";?>>Diciembre</option>
						</select>
					</td>
					<td width="80">
						<select name="year" id="year" style="border: 1px solid #E6701D; font-size: 12px; width: 70px;">
							<option value="0">---</option>
						<?
							$year = date("Y");
							for($n = $year; $n >= 1920; $n--) {
								$selected = ($n == $fsave[0]) ? " selected = \"selected\"" : "";
								echo "<option value = \"".$n."\"".$selected.">".$n."</option>\n";
							}
						?>
						</select>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="30" colspan="7" align="left" valign="top" style="font-size: 12px; color: #000;"><em>*</em><b>&nbsp;&nbsp;Datos Personales</b></td>
		</tr>
		<tr>
			<td colspan="7">
				<table  cellpadding="0" cellspacing="0" border="0">
				<tr valign="top">
					<td align="left" width="380">
						<table cellpadding="0" cellspacing="4" border="0">
							<tr>
								<td width="100" valign="top" style="font-size: 12px; color: #000;">Apellido Paterno:</td>
								<td><input type="text" name="ap" id="ap" value="<?=utf8_encode($pat_lastname); ?>" readonly="readonly" style="border: 1px solid #E6701D; font-size: 12px; width: 240px;"/></td>
							</tr>
							<tr>
								<td width="100" valign="top" style="font-size: 12px; color: #000;">Apellido Materno:</td>
								<td><input type="text" name="am" id="am" value="<?=utf8_encode($pat_surename); ?>" readonly="readonly" style="border: 1px solid #E6701D; font-size: 12px; width: 240px;"/></td>
							</tr>
							<tr>
								<td width="100" valign="top" style="font-size: 12px; color: #000;">Nombre(s):</td>
								<td><input type="text" name="names" id="names" value="<?=utf8_encode($pat_name); ?>" readonly="readonly" style="border: 1px solid #E6701D; font-size: 12px; width: 240px;"/></td>
							</tr>
							<tr>
							<?
								if(strpos($pat_occupation, "-") !== false) {
									$other = explode("-", $pat_occupation);
								}
							?>
								<td width="100">Ocupaci&oacute;n:</td>			<!--	pat_occupation	 -->
								<td><select name="ocupacion" id="ocupacion" onchange="otherjob(this.value);" style="border: 1px solid #E6701D; font-size: 12px; width: 242px;">
										<option value="0">---</option>
										<option value="1" <?=(($pat_occupation == "1") ? "selected=\"selected\"" : ""); ?>>ABOGADO</option>
										<option value="2" <?=(($pat_occupation == "2") ? "selected=\"selected\"" : ""); ?>>ACTOR</option>
										<option value="3" <?=(($pat_occupation == "3") ? "selected=\"selected\"" : ""); ?>>ACTUARIO</option>
										<option value="4" <?=(($pat_occupation == "4") ? "selected=\"selected\"" : ""); ?>>ADMINISTRADOR</option>
										<option value="5" <?=(($pat_occupation == "5") ? "selected=\"selected\"" : ""); ?>>AMA DE CASA</option>
										<option value="6" <?=(($pat_occupation == "6") ? "selected=\"selected\"" : ""); ?>>ARQUITECTO</option>
										<option value="7" <?=(($pat_occupation == "7") ? "selected=\"selected\"" : ""); ?>>ARTESANO</option>
										<option value="8" <?=(($pat_occupation == "8") ? "selected=\"selected\"" : ""); ?>>ARTISTA</option>
										<option value="9" <?=(($pat_occupation == "9") ? "selected=\"selected\"" : ""); ?>>AUXILIAR / ASISTENTE</option>
										<option value="10" <?=(($pat_occupation == "10") ? "selected=\"selected\"" : ""); ?>>CARTERO</option>
										<option value="11" <?=(($pat_occupation == "11") ? "selected=\"selected\"" : ""); ?>>CHEF / COCINERO</option>
										<option value="12" <?=(($pat_occupation == "12") ? "selected=\"selected\"" : ""); ?>>CIENT&Iacute;FICO</option>
										<option value="13" <?=(($pat_occupation == "13") ? "selected=\"selected\"" : ""); ?>>CINEASTA</option>
										<option value="14" <?=(($pat_occupation == "14") ? "selected=\"selected\"" : ""); ?>>COMERCIANTE</option>
										<option value="15" <?=(($pat_occupation == "15") ? "selected=\"selected\"" : ""); ?>>COMPRADOR</option>
										<option value="16" <?=(($pat_occupation == "16") ? "selected=\"selected\"" : ""); ?>>CONSTRUCTOR</option>
										<option value="17" <?=(($pat_occupation == "17") ? "selected=\"selected\"" : ""); ?>>CONSULTOR</option>
										<option value="18" <?=(($pat_occupation == "18") ? "selected=\"selected\"" : ""); ?>>CONTADOR P&Uacute;BLICO</option>
										<option value="19" <?=(($pat_occupation == "19") ? "selected=\"selected\"" : ""); ?>>DIPLOM&Aacute;TICO</option>
										<option value="20" <?=(($pat_occupation == "20") ? "selected=\"selected\"" : ""); ?>>DIRECTOR</option>
										<option value="21" <?=(($pat_occupation == "21") ? "selected=\"selected\"" : ""); ?>>DISE&Ntilde;ADOR</option>
										<option value="22" <?=(($pat_occupation == "22") ? "selected=\"selected\"" : ""); ?>>EMPLEADO</option>
										<option value="23" <?=(($pat_occupation == "23") ? "selected=\"selected\"" : ""); ?>>ENFERMERA</option>
										<option value="24" <?=(($pat_occupation == "24") ? "selected=\"selected\"" : ""); ?>>ESTILISTA</option>
										<option value="25" <?=(($pat_occupation == "25") ? "selected=\"selected\"" : ""); ?>>ESTUDIANTE</option>
										<option value="26" <?=(($pat_occupation == "26") ? "selected=\"selected\"" : ""); ?>>FOT&Oacute;GRAFO</option>
										<option value="27" <?=(($pat_occupation == "27") ? "selected=\"selected\"" : ""); ?>>FUNCIONARIO P&Uacute;BLICO</option>
										<option value="28" <?=(($pat_occupation == "28") ? "selected=\"selected\"" : ""); ?>>GERENTE</option>
										<option value="29" <?=(($pat_occupation == "29") ? "selected=\"selected\"" : ""); ?>>JARDINERO</option>
										<option value="30" <?=(($pat_occupation == "30") ? "selected=\"selected\"" : ""); ?>>MAESTRO / PROFESOR</option>
										<option value="31" <?=(($pat_occupation == "31") ? "selected=\"selected\"" : ""); ?>>Mec&Aacute;NICO</option>
										<option value="32" <?=(($pat_occupation == "32") ? "selected=\"selected\"" : ""); ?>>M&Eacute;DICO</option>
										<option value="33" <?=(($pat_occupation == "33") ? "selected=\"selected\"" : ""); ?>>MESERO</option>
										<option value="34" <?=(($pat_occupation == "34") ? "selected=\"selected\"" : ""); ?>>NEGOCIO PROPIO</option>
										<option value="35" <?=(($pat_occupation == "35") ? "selected=\"selected\"" : ""); ?>>ODONT&Oacute;LOGO</option>
										<option value="36" <?=(($pat_occupation == "36") ? "selected=\"selected\"" : ""); ?>>PERIODISTA</option>
										<option value="37" <?=(($pat_occupation == "37") ? "selected=\"selected\"" : ""); ?>>PERSONAL DE LIMPIEZA</option>
										<option value="38" <?=(($pat_occupation == "38") ? "selected=\"selected\"" : ""); ?>>POL&Iacute;TICO</option>
										<option value="39" <?=(($pat_occupation == "39") ? "selected=\"selected\"" : ""); ?>>PROGRAMADOR DE SISTEMAS</option>
										<option value="40" <?=(($pat_occupation == "40") ? "selected=\"selected\"" : ""); ?>>PSIC&Oacute;LOGO</option>
										<option value="41" <?=(($pat_occupation == "41") ? "selected=\"selected\"" : ""); ?>>RECEPCIONISTA</option>
										<option value="42" <?=(($pat_occupation == "42") ? "selected=\"selected\"" : ""); ?>>REPARTIDOR</option>
										<option value="43" <?=(($pat_occupation == "43") ? "selected=\"selected\"" : ""); ?>>SECRETARIA</option>
										<option value="44" <?=(($pat_occupation == "44") ? "selected=\"selected\"" : ""); ?>>SIRVIENTA</option>
										<option value="45" <?=(($pat_occupation == "45") ? "selected=\"selected\"" : ""); ?>>VENDEDOR</option>
										<option value="46" <?=(($other[0] == "46") ? "selected=\"selected\"" : ""); ?>>OTRO</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td align="right">
					<?
						$fnac = explode("-", $pat_ndate);
					?>
						<table cellpadding="0" cellspacing="3" border="0">
						<tr>
							<td rowspan="2" valign="top">Fecha de Nacimiento:</td>		<!--	pat_ndate	 -->
							<td>&nbsp;</td>
							<td><select name="dia" id="dia" style="border: 1px solid #E6701D; font-size: 12px; width: 50px;">
								<? for($n = 1; $n <= 31; $n++) {
										$selected = ($n == $fnac[2]) ? " selected = \"selected\"" : "";
										echo "<option value = \"".$n."\"".$selected.">".$n."</option>\n";
									}
								?>
								</select>
							</td>
							<td><select name="mes" id="mes" style="border: 1px solid #E6701D; font-size: 12px; width: 120px;">
									<option value="1" <?=(($fnac[1] == "1") ? "selected=\"selected\"" : ""); ?>>ENERO</option>
									<option value="2" <?=(($fnac[1] == "2") ? "selected=\"selected\"" : ""); ?>>FEBRERO</option>
									<option value="3" <?=(($fnac[1] == "3") ? "selected=\"selected\"" : ""); ?>>MARZO</option>
									<option value="4" <?=(($fnac[1] == "4") ? "selected=\"selected\"" : ""); ?>>ABRIL</option>
									<option value="5" <?=(($fnac[1] == "5") ? "selected=\"selected\"" : ""); ?>>MAYO</option>
									<option value="6" <?=(($fnac[1] == "6") ? "selected=\"selected\"" : ""); ?>>JUNIO</option>
									<option value="7" <?=(($fnac[1] == "7") ? "selected=\"selected\"" : ""); ?>>JULIO</option>
									<option value="8" <?=(($fnac[1] == "8") ? "selected=\"selected\"" : ""); ?>>AGOSTO</option>
									<option value="9" <?=(($fnac[1] == "9") ? "selected=\"selected\"" : ""); ?>>SEPTIEMBRE</option>
									<option value="10" <?=(($fnac[1] == "10") ? "selected=\"selected\"" : ""); ?>>OCTUBRE</option>
									<option value="11" <?=(($fnac[1] == "11") ? "selected=\"selected\"" : ""); ?>>NOVIEMBRE</option>
									<option value="12" <?=(($fnac[1] == "12") ? "selected=\"selected\"" : ""); ?>>DICIEMBRE</option>
								</select>
							</td>
							<td><select name="anio" id="anio" style="border: 1px solid #E6701D; font-size: 12px; width: 70px;">
								<?
									$year = date("Y");
									for($n = $year; $n >= 1920; $n--) {
										$selected = ($n == $fnac[0]) ? " selected = \"selected\"" : "";
										echo "<option value = \"".$n."\"".$selected.">".$n."</option>\n";
									}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="center" style="font-size: 9px; font-weight: bold; margin-bottom: 5px;">D&iacute;a</td>
							<td align="center" style="font-size: 9px; font-weight: bold; margin-bottom: 5px;">Mes</td>
							<td align="center" style="font-size: 9px; font-weight: bold; margin-bottom: 5px;">A&ntilde;o</td>
						</tr>
						<tr>
							<td colspan="6">
								<table cellpadding="0" cellspacing="3" border="0">
								<tr>
									<td>Sexo:</td>				<!--	pat_gender	 -->
									<td>
										<select name="sexo" id="sexo" onchange="mujer(this.value);" style="border: 1px solid #E6701D; font-size: 12px; width: 100px;">
											<option value="0">---</option>
											<option id="FE" value="FE" <?=(($pat_gender == "FE") ? "selected=\"selected\"" : ""); ?>>Femenino</option>
											<option id="MA" value="MA" <?=(($pat_gender == "MA") ? "selected=\"selected\"" : ""); ?>>Masculino</option>
										</select>
									</td>
									<td>Estado Civil:</td>		<!--	pat_mstatus	 -->
									<td>
										<select name="edocivil" id="edocivil" style="border: 1px solid #E6701D; font-size: 12px; width: 100px;">
											<option value="0">---</option>
											<option value="1" <?=(($pat_mtstatus == "1") ? "selected=\"selected\"" : ""); ?>>Soltero[a]</option>
											<option value="2" <?=(($pat_mtstatus == "2") ? "selected=\"selected\"" : ""); ?>>Casado[a]</option>
											<option value="3" <?=(($pat_mtstatus == "3") ? "selected=\"selected\"" : ""); ?>>Divorciado[a]</option>
											<option value="4" <?=(($pat_mtstatus == "4") ? "selected=\"selected\"" : ""); ?>>Uni&oacute;n libre</option>
											<option value="5" <?=(($pat_mtstatus == "5") ? "selected=\"selected\"" : ""); ?>>Viudo[a]</option>
										</select>
									</td>
									<td>No. Hijos</td>					<!--	pat_nson	 -->
									<td><input type="text" onkeypress="return validar(event)" name="nohijo" id="nohijo" value="<?=$pat_nson; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 30px;"></td>
								</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="6">
								<table>
								<tr>
									<td>Especificar:</td>
									<td><input type="text" name="occupation" id="occupation" disabled="disabled" value="<?=$other[1];?>" style="border: 1px solid #E6701D; font-size: 12px; width: 250px;"></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">		<!--	pat_addres	 -->
				<?
					if(strpos($pat_address, "cp-") !== false) {
						$dir = explode("cp-", $pat_address);
					}
				?>
				<table cellpadding="4" cellspacing="4" border="0">
				<tr>
					<td valign="top" style="font-size: 12px; color: #E6701D;"><em>*</em><b>&nbsp;&nbsp;Direcci&oacute;n:</b></td>
				</tr>
				<tr>
					<td width="80" align="left">Colonia:</td><td><input type="text" name="col" id="col" value="<?=$dir[0]; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 250px;"/></td>
					<td>C.P.</td><td><input onkeypress="return validar(event)" type="text" name="cp" id="cp" value="<?=$dir[1]; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 150px;"/></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table border="0">
				<tr>
					<td width="200">Esta cl&iacute;nica est&aacute; cerca de:</td>		<!--	pth_prxcli	 -->
					<td width="90"><input type="checkbox" name="casa" id="casa" value="1" <?=((strpos($pth_prxcli, "1") !== false) ? " checked=\"checked\"" : ""); ?> />Casa</td>
					<td width="90"><input type="checkbox" name="oficina" id="oficina" value="2" <?=((strpos($pth_prxcli, "2") !== false) ? " checked=\"checked\"" : ""); ?> />Oficina</td>
					<td width="90"><input type="checkbox" name="escuela" id="escuela" value="3" <?=((strpos($pth_prxcli, "3") !== false) ? " checked=\"checked\"" : ""); ?> />Escuela</td>
					<td width="140"><input type="checkbox" name="otroproxch" id="otroproxch" value="4" <?=((strpos($pth_prxcli, "4") !== false) ? " checked=\"checked\"" : ""); ?> onclick="habilitainput('otroprox');"/>Otro [especificar]</td>
					<td width="210"><input type="text" name="otroprox" id="otroprox" value="<?=$pth_oprxcli; ?>" disabled="disabled" style="border: 1px solid #E6701D; font-size: 12px; width: 200px;"></td>			<!--	pth_oprxcli	 -->
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table>
				<tr>
					<td colspan="4"><em>*</em>&nbsp;&nbsp;&iquest;C&oacute;mo te enteraste de Red Kobe?</td>				<!--	pth_knowd	 -->
				</tr>
				<tr>
					<td width="180"><input type="radio" name="enteraste" id="enteraste1" value="1" <?=((strpos($pth_knowd, "1") !== false) ? " checked=\"checked\"" : ""); ?> />Pasando por la cl&iacute;nica</td>
					<td width="110"><input type="radio" name="enteraste" id="enteraste2" value="2" <?=((strpos($pth_knowd, "2") !== false) ? " checked=\"checked\"" : ""); ?> />Internet</td>
					<td width="105"><input type="radio" name="enteraste" id="enteraste3" value="3" <?=((strpos($pth_knowd, "3") !== false) ? " checked=\"checked\"" : ""); ?> />Convenio</td>
					<td><input type="radio" name="enteraste" id="enteraste4" value="4" <?=((strpos($pth_knowd, "4") !== false) ? " checked=\"checked\"" : ""); ?> onclick="habilitainput('patient');" />Recomendaci&oacute;n &iquest;de qui&eacute;n?&nbsp;</td>
					<td><input type="text" name="patient" id="patient" onkeydown="showAutoComplete(this, null, event)" onclick="this.select()" style="border: 1px solid #E6701D; font-size: 12px; width: 200px;" value="<?=$pth_recd; ?>" disabled="disabled"/></td>		<!--	pth_recd	 -->
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table>
				<tr>
					<td width="120"><input type="radio" name="enteraste" id="enteraste5" value="5" <?=((strpos($pth_knowd, "5") !== false) ? " checked=\"checked\"" : ""); ?> onclick="habilitainput('recotro');" />Otro [especificar] </td>
					<td width="230"><input type="text" name="recotro" id="recotro" style="border: 1px solid #E6701D; font-size: 12px; width: 150px;" value="<?=$pth_orecd; ?>" disabled="disabled"/></td>		<!--	pth_orecd	 -->
					<td style="font-size:11px;" align="right"><em>*</em>&nbsp;&nbsp;Nota: si quien recomend&oacute; no te aparece en sistema, anota la palabra <b>&quot;EXTERNO&quot;</b></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7" valign="top" style="font-size: 12px; color: #E6701D;"><em>*</em>&nbsp;&nbsp;Datos de contacto.</td>
		</tr>
		<tr>
			<td colspan="7">Incluye aqu&iacute; todos los datos de contacto que haya dado el paciente, y selecciona la casilla debajo de la
				opci&oacute;n que haya se&ntilde;alado como preferente.
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="5" border="0">
						<tr>
							<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
							<td>Telefonos</td>
						</tr>
						<tr>
							<td width="60">E-mail:</td>
							<td><input type="text" name="mail" id="mail" value="<?=$pat_mail; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 190px;"/></td>		<!--	pat_mail	 -->
							<td width="50"><input type="checkbox" name="mailchk" id="mailchk" <?=(($pat_okmail == "1") ? " checked=\"checked\"" : ""); ?> /></td>		<!--	pat_okmail	 -->
							<td>
								<?
									$query = "select tel_number from {$DBName}.telephone where pat_id = '".utf8_decode($pat)."' and tlt_id = 1";
									list($tel) = @mysql_fetch_array(@mysql_query($query, $link));
								?>
								<input type="text" name="telcasa" id="telcasa" value="<?=$tel; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 110px;"/>
							</td>
							<td width="70">
								<?
									$query = "select tel_number from {$DBName}.telephone where pat_id = '".utf8_decode($pat)."' and tlt_id = 2";
									list($tel) = @mysql_fetch_array(@mysql_query($query, $link));
								?>
								<input type="text" name="teloficina" id="teloficina" value="<?=$tel; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 110px;" />
							</td>
							<td width="70">
								<?
									$query = "select tel_number from {$DBName}.telephone where pat_id = '".utf8_decode($pat)."' and tlt_id = 3";
									list($tel) = @mysql_fetch_array(@mysql_query($query, $link));
								?>
								<input type="text" name="telcel" id="telcel" value="<?=$tel; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 110px;" />
							</td>
							<td width="70">
								<?
									$query = "select tel_number from {$DBName}.telephone where pat_id = '".utf8_decode($pat)."' and tlt_id = 4";
									list($tel) = @mysql_fetch_array(@mysql_query($query, $link));
								?>
								<input type="text" name="telnex" id="telnex" value="<?=$tel; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 110px;" />
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>		<!--	pat_telcontatc	 -->
							<td align="left"><input type="radio" name="contacto" id="contacto1" value="1" <?=(($pat_telcontact == "1") ? " checked=\"checked\"" : ""); ?> />Casa</td>
							<td align="left"><input type="radio" name="contacto" id="contacto2" value="2" <?=(($pat_telcontact == "2") ? " checked=\"checked\"" : ""); ?> />Oficina</td>
							<td align="left"><input type="radio" name="contacto" id="contacto3" value="3" <?=(($pat_telcontact == "3") ? " checked=\"checked\"" : ""); ?> />Celular</td>
							<td align="left"><input type="radio" name="contacto" id="contacto4" value="4" <?=(($pat_telcontact == "4") ? " checked=\"checked\"" : ""); ?> />Nextel</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7"><hr/></td>
		</tr>
		<tr>
			<td colspan="7" valign="top" style="font-size: 12px; color: #E6701D;"><b>Historia Cl&iacute;nica</b></td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr valign="top">
					<td width="50%" align="center">
						<label class="list_item"><em>*</em>&nbsp;&nbsp;&iquest;Padece alguna de las siguientes alergias?</label>
						<table style="border:1px solid;" cellspacing="0" cellpadding="3" id="alergias">
						<tr style="background-color: #ABD9E9; border: 1px solid;">
							<td class="borde" width="120">&nbsp;</td>
							<td class="borde" width="50" align="center">Si</td>
							<td class="borde" width="50" align="center">No</td>
						</tr>
						<tr class="borde">
							<td class="borde">Penicilinas</td>
							<td class="borde" align="center"><input type="radio" name="pnc" id="pnc1" value="1" <?=(($pth_penic == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="pnc" id="pnc2" value="0" <?=(($pth_penic == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Antibi&oacute;ticos</td>
							<td class="borde"align="center"><input type="radio" name="atb" id="atb1" value="1" <?=(($pth_antib == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde"align="center"><input type="radio" name="atb" id="atb2" value="0" <?=(($pth_antib == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Antinflamatorios</td>
							<td class="borde"align="center"><input type="radio" name="antf" id="antf1" value="1" <?=(($pth_anfinf == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="antf" id="antf2" value="0" <?=(($pth_anfinf == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Analg&eacute;sicos</td>
							<td class="borde" align="center"><input type="radio" name="ang" id="ang1" value="1" <?=(($pth_analg == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="ang" id="ang2" value="0" <?=(($pth_analg == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Sulfas</td>
							<td class="borde" align="center"><input type="radio" name="slf" id="slf1" value="1" <?=(($pth_sulf == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="slf" id="slf2" value="0" <?=(($pth_sulf == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Otras</td>
							<td class="borde" align="center"><input type="radio" name="ots" id="ots1" value="1" <?=(($pth_oth == "1") ? "checked=\"checked\"" : ""); ?> onclick="habilita('otroaler');"/></td>
							<td class="borde" align="center"><input type="radio" name="ots" id="ots2" value="0" <?=(($pth_oth == "0") ? "checked=\"checked\"" : ""); ?> onclick="deshabilita('otroaler');"/></td>
						</tr>
						<tr class="borde">
							<td colspan="3" class="borde"><textarea style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 235px;" rows="2" name="otroaler" id="otroaler" disabled="disabled"><?=$pth_other; ?></textarea></td>
						</tr>
						</table>
					</td>
					<td align="center">
						<label class="list_item"><em>*</em>&nbsp;&nbsp;&iquest;Padece o ha padecido alguna de las siguientes enfermedades?</label>
						<table style="border:1px solid;" cellspacing="0" cellpadding="3" id="enfermedades">
						<tr style="background-color: #ABD9E9; border:1px solid;">
							<td class="borde" width="250">&nbsp;</td>
							<td class="borde" width="50" align="center">Si</td>
							<td class="borde" width="50" align="center">No</td>
						</tr>
						<tr class="borde">
							<td class="borde">Diabetes</td>
							<td class="borde" align="center"><input type="radio" name="db" id="db1" value="1" <?=(($pth_diab == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="db" id="db2" value="0" <?=(($pth_diab == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Hepatitis</td>
							<td class="borde" align="center"><input type="radio" name="hp" id="hp1"value="1" <?=(($pth_hepat == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="hp" id="hp2" value="0" <?=(($pth_hepat == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Asma</td>
							<td class="borde" align="center"><input type="radio" name="asm" id="asm1" value="1" <?=(($pth_asthma == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="asm" id="asm2" value="0" <?=(($pth_asthma == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Problemas de coraz&oacute;n</td>
							<td class="borde" align="center"><input type="radio" name="heart" id="heart1" value="1" <?=(($pth_heart == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="heart" id="heart2" value="0" <?=(($pth_heart == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Problemas de coagulaci&oacute;n</td>
							<td class="borde" align="center"><input type="radio" name="pc" id="pc1" value="1" <?=(($pth_coagul == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="pc" id="pc2" value="0" <?=(($pth_coagul == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Fieble reum&aacute;tica</td>
							<td class="borde" align="center"><input type="radio" name="fr" id="fr1" value="1" <?=(($pth_reum == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="fr" id="fr2" value="0" <?=(($pth_reum == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Hemorragias</td>
							<td class="borde" align="center"><input type="radio" name="hm" id="hm1" value="1" <?=(($pth_hemo == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="hm" id="hm2" value="0" <?=(($pth_hemo == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Hipotiroidismo</td>
							<td class="borde" align="center"><input type="radio" name="hipo" id="hipo1" value="1" <?=(($pth_hypot == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="hipo" id="hipo2" value="0" <?=(($pth_hypot == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Hipertiroidismo</td>
							<td class="borde" align="center"><input type="radio" name="hipe" id="hipe1" value="1" <?=(($pth_hypert == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="hipe" id="hipe2" value="0" <?=(($pth_hypert == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Presi&oacute;n</td>
							<td class="borde" align="center"><input type="radio" name="pres" id="pres1" value="1" <?=(($pth_pres == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="pres" id="pres2" value="0" <?=(($pth_pres == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Desmayos frecuentes</td>
							<td class="borde" align="center"><input type="radio" name="df" id="df1" value="1" <?=(($pth_faint == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="df" id="df2" value="0" <?=(($pth_faint == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Operaciones</td>
							<td class="borde" align="center"><input type="radio" name="opc" id="opc1" value="1" <?=(($pth_oper == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="opc" id="opc2" value="0" <?=(($pth_oper == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Convulsiones</td>
							<td class="borde" align="center"><input type="radio" name="cv" id="cv1" value="1" <?=(($pth_convul == "1") ? "checked=\"checked\"" : ""); ?>/></td>
							<td class="borde" align="center"><input type="radio" name="cv" id="cv2" value="0" <?=(($pth_convul == "0") ? "checked=\"checked\"" : ""); ?>/></td>
						</tr>
						<tr class="borde">
							<td class="borde">Otras enfermedades:</td>
							<td class="borde" align="center"><input type="radio" name="oth" id="oth1" value="1" <?=(($pth_othd == "1") ? "checked=\"checked\"" : ""); ?> onclick="habilita('otroenf');"/></td>
							<td class="borde" align="center"><input type="radio" name="oth" id="oth2" value="0" <?=(($pth_othd == "0") ? "checked=\"checked\"" : ""); ?> onclick="deshabilita('otroenf');"/></td>
						</tr>
						<tr class="borde">
							<td colspan="3" class="borde"><textarea style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 370px;" rows="2" name="otroenf" id="otroenf" disabled="disabled"><?=$pth_othdis; ?></textarea></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td width="300"><em>*</em>&nbsp;&nbsp;&iquest;Alguna vez ha recibido anestesia dental? </td>
					<td width="50" align="center"><input type="radio" name="adntl" id="adntl1" value="1" <?=(($pth_anes == "1") ? "checked=\"checked\"" : ""); ?>/>Si</td>
					<td width="50" align="center"><input type="radio" name="adntl" id="adntl2" value="0" <?=(($pth_anes == "0") ? "checked=\"checked\"" : ""); ?>/>No</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td width="300"><em>*</em>&nbsp;&nbsp;&iquest;Tuvo alguna reacci&oacute;n adversa a &eacute;sta?</td>
					<td width="50" align="center"><input type="radio" name="reac" id="reac1" value="1" <?=(($pth_anrct == "1") ? "checked=\"checked\"" : ""); ?> onclick="habilita('descreac');"/>Si</td>
					<td width="50" align="center"><input type="radio" name="reac" id="reac2" value="0" <?=(($pth_anrct == "0") ? "checked=\"checked\"" : ""); ?> onclick="deshabilita('descreac');"/>No</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">Describa dicha reacci&oacute;n:</td>
		</tr>
		<tr>
			<td><textarea name="descreac" id="descreac" style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 790px;"disabled="disabled"><?=$pth_react; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="7">&iquest;Existe alguna precauci&oacute;n que su m&eacute;dico le haya hecho notar con respecto al tratamiento dental?</td>
		</tr>
		<tr>
			<td colspan="7"><textarea name="prectrt" id="prectrt" style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 790px;"><?=$pth_caut; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="7">&iquest;C&oacute;mo considera su estado de salud?</td>
		</tr>
		<tr>
			<td colspan="7"><textarea name="salud" id="salud" style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 790px;"><?=$pth_health; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="7">&iquest;C&oacute;mo considera la forma de sus dientes? </td>
		</tr>
		<tr>
			<td colspan="7"><textarea name="dientes" id="dientes" style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 790px;"><?=$pth_teethf; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="7">&iquest;Qu&eacute; cambios le gustar&iacute;a observar en su boca?</td>
		</tr>
		<tr>
			<td colspan="7"><textarea name="cambios" id="cambios" style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 790px;"><?=$pth_chang; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td width="230">&iquest;Le gusta su sonrisa?</td>
					<td width="70" align="center">
						<input type="radio" name="smile" id="smile1" value="1" <?=(($pth_smile == "1") ? "checked=\"checked\"" : ""); ?>>Si
					</td>
					<td width="70" align="center">
						<input type="radio" name="smile" id="smile2" value="0" <?=(($pth_smile == "0") ? "checked=\"checked\"" : ""); ?>>No
					</td>
					<td>&iquest;Por qu&eacute;?&nbsp;&nbsp;&nbsp;<input type="text" name="sonrisa" id="sonrisa" value="<?=$pth_smiled; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 340px;"></td>
				</tr>
				<tr>
					<td width="230">&iquest;Le gusta el color de sus dientes?</td>
					<td width="70" align="center">
						<input type="radio" name="like" id="like1" value="1" <?=(($pth_tcolor == "1") ? "checked=\"checked\"" : ""); ?>>Si
					</td>
					<td width="70" align="center">
						<input type="radio" name="like" id="like2" value="0" <?=(($pth_tcolor == "0") ? "checked=\"checked\"" : ""); ?>>No
					</td>
					<td>&iquest;Por qu&eacute;?&nbsp;&nbsp;&nbsp;<input type="text" name="colordte" id="colordte" value="<?=$pth_tcolord; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 340px;"></td>
				</tr>
				<tr>
					<td width="230">&iquest;Siente que sus encias est&aacute;n sanas?</td>
					<td width="70" align="center">
						<input type="radio" name="encia" id="encia1" value="1" <?=(($pth_ences == "1") ? "checked=\"checked\"" : ""); ?>>Si
					</td>
					<td width="70" align="center">
						<input type="radio" name="encia" id="encia2" value="0" <?=(($pth_ences == "0") ? "checked=\"checked\"" : ""); ?>>No
					</td>
					<td>&iquest;Por qu&eacute;?&nbsp;&nbsp;&nbsp;<input type="text" name="ensiasna" id="ensiasna" value="<?=$pth_encesd; ?>" style="border: 1px solid #E6701D; font-size: 12px; width: 340px;"></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td width="270"><em>*</em>&nbsp;&nbsp;&iquest;Hace cu&aacute;nto fue su &uacute;ltima visita al dentista?</td>
					<td width="120"><input type="radio" name="visita" id="v1" value="1" <?=(($pth_lastv == "1") ? "checked=\"checked\"" : ""); ?>> 0 a 6 Meses</td>
					<td width="120"><input type="radio" name="visita" id="v2" value="2" <?=(($pth_lastv == "2") ? "checked=\"checked\"" : ""); ?>> 6 Meses a 1 a&ntilde;o</td>
					<td width="120"><input type="radio" name="visita" id="v3" value="3" <?=(($pth_lastv == "3") ? "checked=\"checked\"" : ""); ?>> 1 a 2 a&ntilde;os</td>
					<td width="120"><input type="radio" name="visita" id="v4" value="4" <?=(($pth_lastv == "4") ? "checked=\"checked\"" : ""); ?>> M&aacute;s de 2 a&ntilde;os</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7"><hr/></td>
		</tr>
		<tr>
			<td colspan="7" valign="top" style="font-size: 12px; color: #E6701D;"><em>*</em><b>&nbsp;&nbsp;S&oacute;lo Mujeres</b></td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td width="250">&iquest;Est&aacute; usted embarazada?</td>
					<td width="70"><input type="radio" name="embda" id="embda1" value="1" <?=(($pth_pregnan == "1") ? "checked=\"checked\"" : ""); ?> disabled="disabled" onclick="habilita('embzos'); habilita('meses');">Si</td>
					<td width="70"><input type="radio" name="embda" id="embda2" value="0" <?=(($pth_pregnan == "0") ? "checked=\"checked\"" : ""); ?> disabled="disabled" onclick="deshabilita('meses'); habilita('embzos');">No</td>
				</tr>
				<tr>
					<td width="250">&iquest;En qu&eacute; mes de embarazo se encuentra? </td>
					<td><input type="text" onkeypress="return validar(event)" name="meses" id="meses" value="<?=$pth_pregmon; ?>" disabled="disabled" style="border: 1px solid #E6701D; font-size: 12px; width: 50px;"/></td>
				</tr>
				<tr>
					<td width="250">N&uacute;mero de embarazos</td>
					<td><input type="text" onkeypress="return validar(event)" name="embzos" id="embzos" value="<?=$pth_pregnum; ?>" disabled="disabled" style="border: 1px solid #E6701D; font-size: 12px; width: 50px;"/></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7"><hr/></td>
		</tr>
		<tr>
			<td colspan="7">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td width="250"><em>*</em>&nbsp;&nbsp;&iquest;El paciente presenta dolor?</td>
					<td width="70" align="center"><input type="radio" name="tiene" id="tiene1" value="1" onclick="" <?=(($pth_pain == "1") ? "checked=\"checked\"" : ""); ?>/>Si</td>
					<td width="70" align="center"><input type="radio" name="tiene" id="tiene2" value="0" onclick="" <?=(($pth_pain == "0") ? "checked=\"checked\"" : ""); ?>/>No</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7"><em>*</em>&nbsp;&nbsp;Utilice &eacute;ste espacio para cualquier comentario o aclaraci&oacute;n que quiera agregar</td>
		</tr>
		<tr>
			<td colspan="7" style="font-size: 12px; color: #E6701D;"><b>Nota:</b> Si el paciente dejo este campo en blanco, anotar "Sin comentarios"</td>
		</tr>
		<tr>
			<td colspan="7"><textarea name="coment" id="coment" style="border: 1px solid #E6701D; font-size: 12px; height: 40px; width: 790px;"><?=$pth_comm; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="right">
			<table border="0" cellpadding="0" cellspacing="0" style="margin-top: 2px;">
			<tr>
				<td width="150" class="labelitem">Usuario:</td>
				<td width="110" align="left"><input type="text" name="usr" id="usr" style="border: 1px solid #E6701D; font-size: 12px; width: 100px;" /></td>
				<td width="150" class="labelitem">Contrase&ntilde;a:</td>
				<td><input type="password" name="psw" id="psw" style="border: 1px solid #E6701D; font-size: 12px; width: 100px;" /></td>
				<td><input type="button" value="Enviar" id="enviar" onclick="validausuario();" style="margin-left: 10px;"/></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table width="800" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #084D9C;" align="center">
				<tr style="height: 20px;">
					<td width="40" class="list_header" style="font-size: 11px">Fecha</td>
					<td width="200" class="list_header" style="font-size: 11px">Nombre</td>
					<td width="120" class="list_header" style="font-size: 11px">Acci&oacute;n</td>
				</tr>
				<?
					$query = "select pt.pta_date, e.emp_complete, pt.pta_type from {$DBName}.pthaudit as pt
							left join employee as e on e.emp_id = pt.emp_id
							where pt.pth_id = {$pth_id} and pta_type != 3";
					if($result = @mysql_query($query,$link)){
						$numrows = @mysql_num_rows($result);
						if($numrows > 0){
							while($row = @mysql_fetch_row($result)){
								$fecha = $row[0];
								$name = uppercase($row[1], true);
								$type = ($row[2] == '1') ? "Guardo" : "Edito";
				?>
							<tr style="height: 25px;">
								<td class="list_item" align="center" style="font-size: 10px"><?=$fecha;?></td>
								<td class="list_item" align="center" style="font-size: 10px"><?=$name; ?></td>
								<td class="list_item" align="center" style="font-size: 10px"><?=$type; ?></td>
							</tr>
				<?
							}
						}
					}
				?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7"><hr/></td>
		</tr>
		<tr>
			<td colspan="7" align="left">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" colspan="2" style="font-size: 12px; color: #E6701D;"><b>Auditor&iacute;as</b></td>
				</tr>
				<tr>
					<td width="30"><input type="radio" name="correcta" id="correcta1" value="1"></td>
					<td>Captura correcta</td>
				</tr>
				<tr>
					<td width="30"><input type="radio" name="correcta" id="correcta2" value="0"></td>
					<td>Captura con errores</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<table border="0" cellpadding="0" cellspacing="0" style="margin-top: 2px;">
				<tr>
					<td width="150" class="labelitem">Usuario:</td>
					<td width="110" align="left"><input type="text" name="user" id="user" style="border: 1px solid #E6701D; font-size: 12px; width: 100px;" /></td>
					<td width="150" class="labelitem">Contrase&ntilde;a:</td>
					<td><input type="password" name="paswd" id="paswd" style="border: 1px solid #E6701D; font-size: 12px; width: 100px;" /></td>
					<td><input type="button" value="Enviar" id="enviar" onclick="auditor();" style="margin-left: 10px;"/></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<table width="800" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #084D9C;" align="center">
				<tr style="height: 20px;">
					<td width="40" class="list_header" style="font-size: 11px">Fecha</td>
					<td width="200" class="list_header" style="font-size: 11px">Nombre</td>
					<td width="120" class="list_header" style="font-size: 11px">Acci&oacute;n</td>
					<td width="120" class="list_header" style="font-size: 11px">Correcta</td>
				</tr>
				<?
				$fecha = "";
				$name = $type = 0;
				$query = "select pt.pta_date, e.emp_complete, pt.pta_correct, pt.pta_type from {$DBName}.pthaudit as pt
						left join {$DBName}.employee as e on e.emp_id = pt.emp_id
						where pt.pth_id = {$pth_id} and pta_type = 3 and pt.pth_id != 0";
				if($result = @mysql_query($query,$link)){
					$numrows = @mysql_num_rows($result);
					if($numrows > 0){
						while($row = @mysql_fetch_row($result)){
							$date = $row[0];
							$auditor = uppercase($row[1], true);
							$correcta = ($row[2] == '1') ? "Si" : "No";
							$tipo = ($row[3] == '3') ? "Auditoria" : "";
				?>
				<tr style="height: 25px;">
					<td class="list_item" align="center" style="font-size: 10px"><?=$date; ?></td>
					<td class="list_item" align="center" style="font-size: 10px"><?=$auditor; ?></td>
					<td class="list_item" align="center" style="font-size: 10px"><?=$tipo; ?></td>
					<td class="list_item" align="center" style="font-size: 10px"><?=$correcta; ?></td>
				</tr>
				<?
						}
					}
					@mysql_free_result($result);
				}
				?>
				</table>
			</td>
		</tr>
		</table>
	</form>
	<!--</center>
	 </div> -->
	</td>
</tr>
</table>