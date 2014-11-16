<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/panel_control.css" />
<script>
function borrar(id_reserva) {
	// Funcion de borrado del administrador
	// Hay que revisar esto ya que, seguramente sea una fuente de XSS
	if (confirm("¿Esta seguro de que quiere borrar la reserva?")) {
	$.get("/gran_reserva/index.php/calendario/borrar_reserva/?id="+id_reserva+"&ok=1", {
		},
		function (data) {
			$("#vuelta").html(data);
		});
	window.location.reload(true);
	} else {
		return false;
	}
}
</script>
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
	
	foreach ($mis_lugares as $row) {
		$mislugares[] = array("id" => $row -> id_sala, "nombre" => $row -> nombre);
	}
?>
<div class="grid_8" id="calendario">
	<br />
    <p align="right">
		<? for ($i=0; $i<count($mislugares); $i++) { ?>
        <a href="<?=base_url()?>index.php/panel_control/sin_confirmar?sala=<?=$mislugares[$i]["id"]?>" class="form_boton"><?=$mislugares[$i]["nombre"]?></a>
		<? } ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?=base_url()?>index.php/panel_control/sin_confirmar?id=<?=$sala?>&mes=<?=$mes_ant?>&ano=<?=$ano_ant?>"><img src="<?=base_url()?>img/izquierda_blanco.png" width="20" class="form_boton" /></a>&nbsp;&nbsp;<a href="<?=base_url()?>index.php/panel_control/sin_confirmar?id=<?=$sala?>&mes=<?=$mes_sig?>&ano=<?=$ano_sig?>"><img src="<?=base_url()?>img/derecha_blanco.png" width="20" class="form_boton" /></a>
    </p>
	<h2>Reservas sin confirmar para la sala <strong><?=$nombre_sala?></strong></h2>
    <? if (count($sin_confirmar)>0) { ?>
	<table align="center" width="750">
    	<tr>
        	<th>Fecha</th>
            <th>Hora</th>
            <th>Descripcion</th>
            <th></th>
        </tr>
        <? foreach ($sin_confirmar as $row) {
			$fechai = substr($row->inicio,8,2)."/".substr($row->inicio,5,2)."/".substr($row->inicio,0,4);
			$fechaf = substr($row->fin,8,2)."/".substr($row->fin,5,2)."/".substr($row->fin,0,4);
			$horai = substr($row->inicio,11,5);
			$horaf = substr($row->fin,11,5);	
		?>
        <form action="<?=base_url()?>index.php/panel_control/sin_confirmar" method="post">
        <input type="hidden" name="id_res" value="<?=$row -> id_reserva?>">
        <input type="hidden" name="sala" value="<?=$sala?>">
        <input type="hidden" name="mes" value="<?=$mes?>">
        <input type="hidden" name="ano" value="<?=$ano?>">
        <input type="hidden" name="confirmando" value="1" />
        <tr>
        	<td width="150" valign="top"><span class="fecha"><?=$fechai?> &gt; <?=$fechaf?></span></td>
            <td width="80" valign="top"><span class="hora"><?=$horai?> &gt; <?=$horaf?></span></td>
            <td><?=$row -> descripcion?></td>
            <td valign="top" width="155"><input type="button" class="form_boton" value="ver" onclick="abrir_modal('/gran_reserva/index.php/calendario/ver_reserva/?id=<?=$row -> id_reserva?>');" /><input type="button" class="form_boton" value="borrar" onclick="borrar(<?=$row -> id_reserva?>)" /><input type="submit" value="confirmar" class="form_boton"></td>
        </tr>
        </form>
        <? } ?>
    </table>
    <? } else { ?>
    <p>No existen reservas para confirmar este mes.</p>
    <? } ?>
</div>