    <div class="grid_9" class="panel_control_central">
    	<div class="alaizquierda">
		<h2>Reservas sin confirmar</h2>
        <p>Existen <strong><?=$sin_confirmar_total?></strong> reservas sin confirmar.</p>
        <p>Tiene <strong><?=$todas_reservas_pendientes?></strong> reservas pendientes para el día de hoy, <?=$this -> funccalendario -> muestra_dia_hoy("largo")?> para la sala <strong><?=$this -> salas_model -> nombre_sala($sala)?></strong>.</p>
        <h2>Reservas para hoy de <?=$sala_nombre?></h2>
        
        <? if (count($reservas_pollo)>0) { ?>
        <div class="grid_5 omega" id="calendario">
        	<table width="550" border="1">
                <tr>
                    <th width="70">Fecha</th>
                    <th width="80">Hora</th>
                    <th>Descripci&oacute;n</th>
                </tr>
                <?
                foreach ($reservas_pollo as $row) { 
                    $fechai = substr($row->inicio,8,2)."/".substr($row->inicio,5,2)."/".substr($row->inicio,0,4);
                    $fechaf = substr($row->fin,8,2)."/".substr($row->fin,5,2)."/".substr($row->fin,0,4);
                    $horai = substr($row->inicio,11,5);
                    $horaf = substr($row->fin,11,5);
                ?>
                <tr>
                    <td valign="top">
                        <? if ($fechai==$fechaf) {
                            ?><span class="fecha"><?=$fechai?></span><?
                        } else {
                            ?><span class="fecha"><?=$fechai?><br /><img src="<?=base_url()?>img/flecha_abajo.png" alt="" /><br /><?=$fechaf?></span><?
                        }
                        ?>
                    </td>
                    <td valign="top">
                        <? if ($horai==$horaf) {
                            ?><span class="hora"><?=$horai?></span><?
                        } else {
                            ?><span class="hora"><?=$horai?><br /><img src="<?=base_url()?>img/flecha_abajo.png" alt="" /><br /><?=$horaf?></span><?
                        }
                        ?>
                        
                    </td>
                    <td valign="top"><?=$row->descripcion?></td>
                </tr>
                <? } ?>
            </table>
            </div> <!-- fin div calendario -->
            <? } else { ?>
            <p>No existen reservas para este mes. ¿Debería seleccionar otro mes u otra sala?.</p>
            <? } ?>
        
        </div>
    </div>
</div>
<div class="clear"></div>