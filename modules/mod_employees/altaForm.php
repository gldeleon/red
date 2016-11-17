<div id="sessHeader" style="position: fixed; left: 1px; width: 97%; background: #FFFFFF;">
<table align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td class="btnHeader<?=(($section == "1") ? " btnHeaderOver" : ""); ?>"><a href="?section=1" target="_self">Lista de Doctores</a></td>
	<td class="btnHeader<?=(($section == "2") ? " btnHeaderOver" : ""); ?>"><a href="?section=2" target="_self">Alta</a></td>
	<td class="btnHeader<?=(($section == "3") ? " btnHeaderOver" : ""); ?>"><a href="?section=3" target="_self">Baja</a></td>
</tr>
</table>
</div>

            <div style="margin-top:50px;">
                <h1 style="text-align: center; font-size:15px;color:#084C9D;">Alta de Doctor</h1>
                <table align="center" id="altaTable" cellspacing="2" cellpadding="2">
                        <tr>
                            <td width="150" class="labelitem">Apellido Paterno:</td><td colspan="2" width="150"><input type="text" id="lastname" /> <span id="lastnamerequire" class="require">*Campo obligatorio*</span></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Apellido Materno:</td><td colspan="2" width="150"><input type="text" id="surename" /> <span id="surenamerequire" class="require">*Campo obligatorio*</span></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Nombre(s):</td><td colspan="2" width="150"><input type="text" id="name" /> <span id="namerequire" class="require">*Campo obligatorio*</span></td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Tel&eacute;fono:</td><td colspan="2" width="150"><input type="text" id="phone" /> </td>
                        </tr>
                        <tr>
                            <td width="150" class="labelitem">Celular:</td><td colspan="2" width="150"><input type="text" id="cel" /> </td>
                        </tr>
                        <tr>
                            <td valign="top" width="150" class="labelitem">Cl&iacute;nica(s):</td>
                            <td valign="top" width="150" id="clinicas">
                                <input type="button" class="large" value="Atiende En..." id="agregarClinica" /><span id="clinicrequire" class="require">*Campo obligatorio*</span>
                                <label>
                                    <select name="clinic">
                                        <option value="">---</option>
                                        <?php
                                        for($i=0; $i<count($clinicas); $i++){

                                            list($cli_id, $cli_name) = explode("*", $clinicas[$i]);
                                            echo "<option value='{$cli_id}'>".ucwords(lowercase($cli_name, true))."</option>";

                                        }
                                        ?>
                                    </select>

                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="150" class="labelitem">Puesto(s):</td>
                            <td colspan="2" id="puestos">
                                <label>
                                    <select name="post">
                                        <option value="">---</option>
                                        <?php
                                        for($i=0; $i<count($posts); $i++){

                                            list($pst_id, $pst_name) = explode("*", $posts[$i]);
                                            echo "<option value='{$pst_id}'>".ucfirst(lowercase($pst_name, true))."</option>";

                                        }
                                        ?>
                                    </select>
                                    <input type="button" class="large" value="Agregar Puesto" id="agregarPuesto" /><span id="postrequire" class="require">*Campo obligatorio*</span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">
                                <input class="large" id="previa" type="button" value="Vista Previa" />
                            </td>
                        </tr>
                    </table>
            </div>
