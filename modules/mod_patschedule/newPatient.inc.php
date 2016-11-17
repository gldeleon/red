<?
	/** Determina el tipo de navegador del usuario. */
	$browser = (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false) ? "IE" : ((strpos($_SERVER['HTTP_USER_AGENT'], "Firefox") !== false) ? "FF" : "SF");
?>
<div id="newPatient" style="position: absolute; left: 0px; top: 0px; z-index: 100000000000000; visibility: hidden">
	<form name="np" id="np">
	<input type="hidden" name="recid" id="recid" value="" />
	<table border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="outf1y2" style="vertical-align: bottom; border-bottom: none"><img src="../../images/outfitw1.png" width="43" height="43" /></td>
		<td class="title2" style="border-bottom: none"><label class="title2">Agregar Paciente</label></td>
		<td colspan="2" class="outf1y2" style="vertical-align: bottom; border-bottom: none"><img src="../../images/outfitw2.png" width="50" height="43" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center" id="mWindow" style="border: none; border-top: 1px solid #084C8D; border-left: 1px solid #084C8D; border-bottom: 1px solid #084C8D">
		<iframe id="cpFrame" name="cpFrame" src="createPatient.php?cli=<?=$cli; ?>" width="100%" height="315" frameborder="0" scrolling="no"></iframe>
		</td>
		<td width="42" style="background-color: #FFF; border-top: 1px solid #084C8D; border-right: 1px solid #084C8D; border-bottom: 1px solid #084C8D"><img src="../../images/spacer.gif" width="1" height="1" /></td>
		<td width="7"><img src="../../images/outfitws1.png" width="7" height="320" /></td>
	</tr>
	<tr>
		<td class="outf3y4" rowspan="2" style="border-top: none"><img src="../../images/outfitw4.png" width="43" height="48" /></td>
		<td valign="bottom" class="wtbottom" style="text-align: right; border-top: none; <?="height: ".(($browser == "IE") ? 39 : 41)."px"; ?>">
		<input type="button" value="Alta" onclick="addPatient();" />
		<input type="button" value="Cancelar" onclick="hideNewPatientDialog();" />	</td>
		<td class="outf3y4" colspan="2" rowspan="2" style="border-top: none"><img src="../../images/outfitw3.png" width="50" height="48" /></td>
	</tr>
	<tr>
		<td><img src="../../images/outfitws2.png" width="450" height="7" /></td>
	</tr>
	</table>
	</form>
</div>