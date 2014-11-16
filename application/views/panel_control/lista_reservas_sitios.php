<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/panel_control.css" />
<?
	// Para el navegador de fechas
	switch ($mes) {
			case 12:
				$mes_sig = 1;
				$mes_ant = $mes-1;
				$ano_sig = $ano + 1;
				$ano_ant = $ano;
				break;
			case 1:
				$mes_sig = $mes+1;
				$mes_ant = 12;
				$ano_sig = $ano;
				$ano_ant = $ano - 1;
				break;
			default:
				$mes_sig = $mes+1;
				$mes_ant = $mes-1;
				$ano_sig = $ano_ant = $ano;
		}
?>
<div class="grid_8" id="calendario">
	<br />
	<p align="right"><a href="<?=base_url()?>index.php/panel_control/sitio?id=<?=$sala?>&mes=<?=$mes_ant?>&ano=<?=$ano_ant?>"><img src="<?=base_url()?>img/izquierda_blanco.png" width="20" class="form_boton" /></a>&nbsp;<a href="<?=base_url()?>index.php/panel_control/imprimir/?mes=<?=$mes?>&ano=<?=$ano?>&id=<?=$sala?>" target="_blank"><img src="<?=base_url()?>img/impresora_blanco.png" alt="imprimir" width="20" class="form_boton" /></a>&nbsp;<a href="<?=base_url()?>index.php/panel_control/sitio?id=<?=$sala?>&mes=<?=$mes_sig?>&ano=<?=$ano_sig?>"><img src="<?=base_url()?>img/derecha_blanco.png" width="20" class="form_boton" /></a></p>
    <? if (count($reservas_pollo)>0) { ?>
	<table width="750" align="center" border="1">
        	<tr>
            	<th width="70">Fecha</th>
                <th width="80">Hora</th>
                <th>Descripci&oacute;n</th>
                <th width="130">Reservado por</th>
                <th></th>
            </tr>
            <?
            foreach ($reservas_pollo as $row) { 
				$fechai = substr($row->inicio,8,2)."/".substr($row->inicio,5,2)."/".substr($row->inicio,0,4);
				$fechaf = substr($row->fin,8,2)."/".substr($row->fin,5,2)."/".substr($row->fin,0,4);
				$horai = substr($row->inicio,11,5);
				$horaf = substr($row->fin,11,5);
				$persona = $this -> ldap -> sacar_datos_ldap($row -> persona);
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
                <td valign="top"><a href="mailto:<?=$persona["mail"]?>"><?=$persona["nombre"]?> (<?=$persona["extension"]?>)</a> <a href="#" onclick="abrir_modal('<?=base_url()?>index.php/panel_control/comentar?idreserva=<?=$row->id_reserva?>&iduser=<?=$row->persona?>')"><img src="<?=base_url()?>img/stop_icon.png" width="15" align="absmiddle" alt="informacion del usuario"/></a></td>
                <td valign="top"><a href="#" onclick="abrir_modal('<?=base_url()?>index.php/calendario/editar_reserva/?id_reserva=<?=$row -> id_reserva?>&id=<?=$sala?>')"><img src="<?=base_url()?>img/editar.png" alt="editar" width="20" border="0" id="imagen"></a>
                </td>
            </tr>
            <? } ?>
    </table>
    <script>
	$("tr:even").css("background-color", "#f4f4f4");
	</script>
    <? } else { ?>
    	<p>No existes reservas para este mes.</p>
    <? } ?>
</div>
<div class="clear"></div>