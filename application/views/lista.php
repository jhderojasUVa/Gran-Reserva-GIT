<link href="<?=base_url();?>css/calendario.css" rel="stylesheet" type="text/css" media="all" />
<?
// Aqui van las funciones genericoas

// Definimos que dia es hoy para sacar 1 dia antes y 2 despues en codigo
if ($this -> input -> get("dia")) {
	$hoy = $this -> input -> get("dia");
} else {
	$hoy = date("d");
}
if ($this -> input -> get("mes")) {
	$mes = $this -> input -> get("mes");
	$mes_numero = $this -> input -> get("mes");
} elseif ($this -> uri -> segment(4)) {
	$mes_numero = $this ->uri -> segment(4);
} else {
	$mes = date("M");
	$mes_numero = date("n");
}

if ($this -> input -> get("ano")) {
	$ano = $this -> input -> get("ano");
} elseif ($this -> uri -> segment(3)) {
	$ano = $this -> uri -> segment(3);
} else {
	$ano = date("Y");
}

$reservas_mes = $this -> reservas_model -> show_reservas_sala(1,$mes_numero);

// Metemos todo en el array para mostrar
foreach ($reservas_mes as $row) {
	$fecha_trozo_inicio = substr($row->inicio,8,2);
	$data[$fecha_trozo_inicio]="?dia=".$fecha_trozo_inicio."&ano=".$ano."&mes=".$mes_numero."&sala=".$sala;
}

// Para el calendario para que elija el dia
// Ya veremos como lo junto

$ultimo_dia_mes = $this -> funccalendario -> Ultimo_dia_mes($mes_numero, $ano);

for ($i=1; $i<=$ultimo_dia_mes; $i++) {
	$data2[$i] = "?dia=".$i."&ano=".$ano."&mes=".$mes_numero."&sala=".$sala;
}
?>

<div class="grid_64 fondo_gris">
	<div class="grid_7 izq_todo" id="calendario_lugares">
    	<form name="lugar" method="post" id="formulariosalas">
            Lugares
            <select name="lugar" class="form_select" id="lugar">
                <? foreach ($lugares as $row) { ?><option value="<?=$row->id_lugar?>"><?=$row->facultad?></option><? } ?>
            </select>
            <input type="button" onclick="cambiasala()" class="form_boton" value="&raquo;" />
        </form>
    </div>
    <div id="grid_5">
    	<form action="<?=base_url()?>index.php/buscar" method="post" class="form">
          	<input type="text" name="buscar" placeholder="buscar..." class="form_buscar"/> <input type="image" src="<?=base_url()?>img/lupa.png" align="right" width="20" class="form_boton" />
        </form>
    </div>
    <div class="clear"></div>
</div>
<div class="grid_64">
    <div class="grid_3" id="calendario">
    <h1><?=$sala_nombre?></h1>
    <?=$this -> calendar -> generate($ano, $mes_numero, $data);?>
    <hr />
    <p><a href="<?=base_url()?>index.php?dia=<?=date("d")?>&mes=<?=date("m")?>&ano=<?=date("Y") ?>&sala=<?=$sala?>" class="form_boton"><img src="<?=base_url()?>img/today.png" border="0" width="40"/></a></p>
    <?=$this -> calendar -> generate($ano, $mes_numero, $data2);?>
    </div>
 	<div class="grid_9" id="horario">
    	<p><a href="<?=base_url()?>index.php/calendario/lista/?ano=<?=$ano?>&mes=<?=$mes_numero?>&sala=<?=$sala?>" class="form_boton">Lista</a> <a href="<?=base_url()?>" class="form_boton">Calendario</a></p>
        <!-- lista de reservas -->
        <table width="550" align="right" border="1">
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
    </div>
</div>
<div class="clear"></div>
