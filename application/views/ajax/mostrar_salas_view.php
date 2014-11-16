<form name="lugar" method="post" id="formulariosalas">
    Lugares
    <select name="lugar" class="form_select" id="lugar">
    <? foreach ($lugares as $row) { ?>
		<? if ($row->id_lugar==$lugar_estoy) { ?>
        	<option value="<?=$row->id_lugar?>" selected="selected"><?=$row->facultad?></option>
		<? }else { ?>
        	<option value="<?=$row->id_lugar?>"><?=$row->facultad?></option>
		<? } ?>
	<? } // fin del foreach ?>
    </select>
    <input type="button" onclick="cambiasala()" value="&raquo;" class="form_boton" />
    <select name="sala" id="sala" class="form_select">
    <? foreach ($salas as $row) { ?><option value="<?=$row->id_sala?>"><?=$row->nombre?></option><? } ?>
    </select>
    <!-- 
    <input type="button" onclick="enviasala()" value="ir" class="form_boton" />
    -->
    <input type="submit" class="form_boton" value="ir" />
</form>
