<div id="newPatient" style="position: absolute; left: 0px; top: 0px; z-index: 1000; visibility: hidden">
	<form name="np" id="np">
	<input type="hidden" name="recid" id="recid" value="" />
	<table border="0" align="center" cellpadding="0" cellspacing="0" style="background-color: #FFF;">
	<tr>
		<td class="outf_f1y2" style="border-left: 1px solid #811E53;">&nbsp;</td>
		<td class="pTd_f" style="width: 450px;">Agregar Paciente</td>
		<td class="outf_f1y2" style="border-right: 1px solid #811E53;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="center" id="mWindow" style="border-left: 1px solid #811E53;">
		<iframe id="cpFrame" name="cpFrame" src="createPatient.php?cli=<?=$cli; ?>" width="100%" height="315" frameborder="0" scrolling="no"></iframe></td>
		<td style="border-right: 1px solid #811E53;">&nbsp;</td>
	</tr>
	<tr>
		<td class="outf_f3y4" style="border-left: 1px solid #811E53;"><img src="../images/spacer.gif" width="40" height="40" /></td>
		<td class="wtbottom" style="border-bottom: 1px solid #811E53; border-top: 1px solid #811E53; text-align: right;"><input type="button" value="Alta" onclick="addPatient();" />&nbsp;<input type="button" value="Cancelar" onclick="hideNewPatientDialog();" /></td>
		<td class="outf_f3y4" style="border-right: 1px solid #811E53;"><img src="../images/spacer.gif" width="40" height="40" /></td>
	</tr>
	</table>
	</form>
</div>