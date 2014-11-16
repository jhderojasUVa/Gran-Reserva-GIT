<script src="<?=base_url()?>js/jeip.js"></script>
<div class="grid_8" id="calendario">
	<br>
	<h2>Sitios en los que es usted administrador</h2>
	<table align="center" width="700">
    	<tr>
        	<th width="250">Nombre</th>
            <th width="400">Descripcion</th>
            <th width="250">Gestion</th>
            <th width="25"></th>
        </tr>
        <? foreach ($sitios as $row) { ?>
        <tr>
        	<td valign="top"><span id="nombre<?=$row["id"]?>"><?=$row["nombre"]?></span></td>
            <td><span id="descripcion<?=$row["id"]?>"><?=$row["descripcion"]?></span></td>
            <td align="center">
            	<span id="gestion<?=$row["id"]?>">
                <? if ($row["gestion"]==true) { ?>SI
                <? } else { ?>NO
                <? } ?>
            	</span>
            </td>
            <td align="center" valign="top"><a href="#"><img src="<?=base_url()?>img/trash.png" alt="eliminar, desabilitado" width="20" border="0"></a></td>
        </tr>
        <? } ?>
        <script>
		$("tr:even").css("background-color", "#f4f4f4");
		<? foreach ($sitios as $row) { ?>	
			$("#nombre<?=$row["id"]?>").eip("<?=base_url()?>index.php/ajax/cambiar_nombre_sala", {
				select_text: true, 
				save_on_enter: true,
				size: 20,
				savebutton_class: "form_boton",
				cancelbutton_class: "form_boton",
				editfield_class: "caja_form",
				size: 20 });
			$("#descripcion<?=$row["id"]?>").eip("<?=base_url()?>index.php/ajax/cambiar_descripcion_sala", {
				select_text: true, 
				save_on_enter: true,
				size: 50,
				savebutton_class: "form_boton",
				cancelbutton_class: "form_boton",
				editfield_class: "caja_form",
				size: 90 });
			$("#gestion<?=$row["id"]?>").eip("<?=base_url()?>index.php/ajax/cambiar_gestion_sala", {
				form_type: "select",
				select_options: {
					0:"NO",
					1:"SI"
				},
				save_on_enter: true,
				savebutton_class: "form_boton",
				cancelbutton_class: "form_boton",
				editfield_class: "caja_form",
				});
		<? } ?>
		</script>
    </table>
    <p align="left">Para <strong>borrar sitios</strong> o <strong>crear nuevos sitios</strong>, por favor <a href="mailto:soporteweb@uva.es">consulte con el administrador</a>.</p>
</div>
<div class="clear"></div>