<link href="<?=base_url();?>css/calendario.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/modal.css" rel="stylesheet" type="text/css" media="all" />
<?
// Aqui van las funciones genericoas

// Definimos que dia es hoy para sacar 1 dia antes y 2 despues en codigo
if ($this -> input -> get("dia")) {
	$hoy = $this -> input -> get("dia");
} else {
	$hoy = date("d");
}
if ($this -> input -> get("mes")) {
	//$mes = $this -> input -> get("mes");
	$mes_numero = $this -> input -> get("mes");
	$mes = date("M", mktime(1, 1, 1, $mes_numero, 1, 2000));
} elseif ($this -> uri -> segment(4)) {
	$mes_numero = $this ->uri -> segment(4);
	$mes = date("M", mktime(1, 1, 1, $mes_numero, 1, 2000));
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
// Esto solo activa en el calendario aquellos que tienen dia reservado (o dias, claro)
foreach ($reservas_mes as $row) {
	$fecha_trozo_inicio = substr($row -> inicio, 8, 2);
	$data[$fecha_trozo_inicio] = "?dia=".$fecha_trozo_inicio."&ano=".$ano."&mes=".$mes_numero."&sala=".$sala;
	//$data[$fecha_trozo_inicio] = "http://www.uva.es";
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
    	<form name="lugar" method="post" id="formulariosalas" action="<?=base_url()?>index.php/">
            Lugares
            <select name="lugar" class="form_select" id="lugar">
                <? foreach ($lugares as $row) { ?>
                	<? if ($lugar_estoy == $row->id_lugar) { ?>
                    	<option value="<?=$row->id_lugar?>" selected="selected"><?=$row->facultad?></option>
                    <? } else { ?>
                    	<option value="<?=$row->id_lugar?>"><?=$row->facultad?></option>
                    <? } ?>
				<? } // fin del foreach ?>
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
    <h1>
    	<? foreach ($lugares as $row) {?>
        	<?// if (!$lugar_estoy) { $lugar_estoy=1; } ?>
        	<? if ($lugar_estoy == $row -> id_lugar) { ?>
            	<span class="facultad"><?=$row -> facultad ?></span><br/><br />
			<? } ?>
		<? } ?>
		<?=$sala_nombre?>
    </h1>
    <?=$this -> calendar -> generate($ano, $mes_numero);?>
    <hr />
    <p><a href="<?=base_url()?>index.php?dia=<?=date("d")?>&mes=<?=date("m")?>&ano=<?=date("Y") ?>&sala=<?=$sala?>" class="form_boton"><img src="<?=base_url()?>img/today.png" border="0" width="40"/></a></p>
    <?=$this -> calendar -> generate($ano, $mes_numero, $data2);?>
    </div>
 	<div class="grid_9" id="horario">
    	<p><a href="<?=base_url()?>index.php/calendario/lista/?ano=<?=$ano?>&mes=<?=$mes_numero?>&sala=<?=$sala?>" class="form_boton" id="reservar">Lista</a> <a href="<?=base_url()?>" class="form_boton">Calendario</a></p>
    <?
	// Primero sacamos el sitio (el id) que esta mirando
	// Por ahora lo ñapeo
	$id_sala=$sala;
	// Obtenemos los datos de la sala
	$datos_sala = $this -> salas_model -> show_sala($id_sala);
	// Convertimos el paso
	$paso = $paso_horario;
	
	// Variable para las horas
	$i=0;
	$pasadas=0;
	// Comprobar cual es el ultimo dia del mes
	
	$ultimo_dia = $this -> funccalendario -> Ultimo_dia_mes($mes_numero, $ano);
	$fin = $hoy+2;
	// Datos del horario de la sala
	foreach ($datos_horario as $row) {
		$hora_inicio = substr($row->hora_inicio, 0, 2);
		$hora_fin = substr($row->hora_fin, 0, 2);
	}
	// Copia de variables para no perderlas
	$hoy_titulo = $hoy;
	$hoy_dentro = $hoy;
	$hoy_otro = $hoy;

	?>
    	<table width="550" align="right" border="1">
        	<tr>
            	<th width="40">&nbsp;</th>
                <? for (($hoy_titulo--);$hoy_titulo<=$fin;$hoy_titulo++) { ?>
                	<? if ($hoy_titulo>$ultimo_dia) {
						// Si es ultimo de mes, nada
						break 1;
					} elseif ($hoy_titulo<1) {
						// Si es anterior al primero
						$hoy_titulo = 1;
					}?>
                <th>
					<?=$hoy_titulo?>/<?=$mes?><? $pasadas++ ?>
                </th>
                <? 
				// Metemos aqui en el array los dias para luego
				// Esta funcion mete en el array $reservas_hoy todas las reservas de los dias que se muestran con la siguiente estructura
				// hora incio, minuto inicio, hora fin, minuto fin, descripcion, dia
				
				// Seguro que se puede meter en una funcion... más adelante.
				$reservas_hoy_tmp = $this -> reservas_model -> show_reservas_dia($sala, $ano."-".$mes_numero."-".$hoy_titulo);
				
				// Divisor de reservas del dia de hoy a varias
				foreach ($reservas_hoy_tmp as $row) {
					$hora_reserva_inicio = substr($row -> inicio, 11,2);
					$hora_reserva_fin = substr($row -> fin, 11, 2);
					
					$minuto_reserva_inicio = substr($row -> inicio, 14,2);
					$minuto_reserva_fin = substr($row -> fin, 14, 2);
					
					//$reservas_hoy [] = array($hora_reserva_inicio, $minuto_reserva_inicio, $hora_reserva_fin, $minuto_reserva_fin, $row -> descripcion, $hoy_titulo);
					//echo 
					if (strlen($hoy_titulo)<2) {
						$hoy_titulo="0".$hoy_titulo;
					}
					$reservas_hoy [] = array(
											$ano."-".$mes_numero."-".$hoy_titulo, 
											strtotime($ano."-".$mes_numero."-".$hoy_titulo." ".$hora_reserva_inicio.":".$minuto_reserva_inicio), 
											strtotime($ano."-".$mes_numero."-".$hoy_titulo." ".$hora_reserva_fin.":".$minuto_reserva_fin), 
											$row -> descripcion, 
											$hoy_titulo,
											$row -> id_reserva
											);
											
				}
				?>
				<? } ?>
            </tr>
        <? 
		$i2 = 0;
		
		$paso_tmp = (1/$paso);
		
		for ($hora=$hora_inicio; $hora<=$hora_fin; $hora=$hora+$paso_tmp) { 
			$dibujar = 60*$paso_tmp*$i2;
			if ($dibujar >= "60") {
				$dibujar = "00";
				$i2=0;
			} elseif ($dibujar == 0) {
				$dibujar = "00";
			}
			
		// Cargamos las reservas del dia para poner si hay una reserva
		
		?>
        	<tr>
            	<td align="right"><strong><?=$hora - ($i2*$paso_tmp)?>:<?=$dibujar?></strong></td>
                <? for ($i=0;$i<$pasadas;$i++) { ?>
                <? for ($i3=0; $i3<count($reservas_hoy); $i3++) {					
					
					$fecha_i = $reservas_hoy[$i3][1];
					$fecha_i2 =$reservas_hoy[$i3][2];
					$fecha_f = strtotime($ano."-".$mes_numero."-".($hoy_otro-1+$i)." ".($hora - ($i2*$paso_tmp)).":".$dibujar);

					$ocupado = $this -> funccalendario -> Ocupado($fecha_i, $fecha_i2, $fecha_f, true);
				
					if ($ocupado == true) {
						break 1;
					}
			
					} // Fin del for que revisa las reservas?>
                    <?
					if ($ocupado==true) {
						?><td id="ocupado" width="125" onclick="abrir_modal('<?=base_url()?>index.php/calendario/ver_reserva/?id=<?=$reservas_hoy[$i3][5]?>&sala=<?=$sala?>')"><a onclick="abrir_modal('<?=base_url()?>index.php/calendario/ver_reserva/?id=<?=$reservas_hoy[$i3][5]?>&sala=<?=$sala?>')"><?=substr($reservas_hoy[$i3][3], 0, 10); ?>...</a></td><?
					} else {
						?><td id="libre" width="125" onclick="abrir_modal('<?=base_url()?>index.php/calendario/reservar_vista?ano=<?=$ano?>&mes=<?=$mes_numero?>&dia=<?=($hoy_otro-1+$i)?>&hora=<?=($hora - ($i2*$paso_tmp))?>&sala=<?=$sala?>')"></td><?
					}
					?>
                <? } // Fin del for que revisa los dias?>
            </tr>
            <? $i++; $i2++;?>
		<? } ?>
        </table>
        <div class="clear"></div>
        <? if (count($recursos_sala)>0) { ?>
        <div id="informacion_sala">
        <h3>Recursos disponibles en la sala <?=$sala_nombre?></h3>
        	<? foreach ($recursos_sala as $row) { ?>
            	<li><?=$row -> recurso?></li>
			<? } ?>
        </div>
      	<? } ?>
        </div>
        
    </div>
</div>
<div class="clear"></div>
