<link href="<?=base_url();?>css/calendario.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/mis.css" rel="stylesheet" type="text/css" media="all" />
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

$reservas_mes = $this -> reservas_model -> show_reservas_sala($sala ,$mes_numero);

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
<div class="grid_64 horarios">
    <div class="grid_3" id="calendario">
    <h1><?=$sala_nombre?></h1>
    <?=$this -> calendar -> generate($ano, $mes_numero, $data);?>
    <hr />
    <p><a href="<?=base_url()?>index.php?dia=<?=date("d")?>&mes=<?=date("m")?>&ano=<?=date("Y") ?>&sala=<?=$sala?>" class="form_boton"><img src="<?=base_url()?>img/today.png" border="0" width="40"/></a></p>
    <?=$this -> calendar -> generate($ano, $mes_numero, $data2);?>
    </div>
 	<div class="grid_9 alpha" id="horario">
    	<div class="grid_3">
        	<h2>Mis reservas</h2>
        </div>
        <div class="alaizquierda">
        	<img src="<?=base_url()?>img/trash_blanco.png" class="form_boton" onclick="borra_muchas_reservas()" alt="borrar reservas" width="10" />
        </div>
        <div class="alaizquierda">
        	Seleccionar <a href="#" onclick="selecciona_todas_reserva()">Todos</a> / <a href="#" onclick="no_selecciona_todas_reserva()">Ninguno</a>
        </div>
        <div class="alaizquierda">
        	<a href="<?=base_url()?>index.php/mis/ics">descargar ICS</a> <a href="<?=base_url()?>index.php/mis/ics"><img src="<?=base_url()?>img/ics.png" alt="calendario en ics" align="middle" width="25" /></a> (beta)
        </div>
        <div class="clear"></div>
        
        <table width="650" align="right" border="1">
        	<tr>
            	<th></th>
            	<th width="90">Fecha</th>
                <th width="120">Hora</th>
                <th width="430">Descripci&oacute;n</th>
                <th width="60">Opciones</th>
            </tr>
        <? foreach ($mis_reservas as $row) { ?>
        <?
			$id_reserva = $row -> id_reserva;
			$fechai = substr($row->inicio,8,2)."/".substr($row->inicio,5,2)."/".substr($row->inicio,0,4);
			$fechaf = substr($row->fin,8,2)."/".substr($row->fin,5,2)."/".substr($row->fin,0,4);
			$horai = substr($row->inicio,11,5);
			$horaf = substr($row->fin,11,5);
			
			if (strlen($row -> descripcion)>150) {
				$descripcion = substr($row -> descripcion,0, 150)." (...)";
			} else {
				$descripcion = $row -> descripcion;
			}
		?>
        	<tr>
            	<td><input type="checkbox" value="<?=$id_reserva?>" name="id_reserva" id="id_reserva" /></td>
            	<td valign="top"><span class="fecha"><?=$fechai?></span><br /><span class="fecha"><?=$fechaf?></span></td>
                <td valign="top"><span class="hora"><?=$horai?></span> - <span class="hora"><?=$horaf?></span></td>
                <td valign="top"><?=$descripcion;?></td>
                <td valign="top" align="center"><p align="center"><a href="#" onclick="borrar_reserva_stream(<?=$id_reserva?>)"><img src="<?=base_url()?>img/trash.png" alt="eliminar" width="15" border="0" /></a>  <a href="#" onclick="abrir_modal('<?=base_url()?>index.php/calendario/editar_reserva/?id=<?=$id_reserva?>&id_reserva=<?=$id_reserva?>')"><img src="<?=base_url()?>img/clipboard.png" alt="editar" width="15" border="0" /></p></td>
            </tr>
		<? } ?>
        </table>
    </div>
</div>
<div class="clear"></div>