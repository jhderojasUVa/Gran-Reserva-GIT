<link href="<?=base_url();?>css/panel_control.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/calendario.css" rel="stylesheet" type="text/css" media="all" />
<?
foreach ($mis_lugares as $row) {
	$mislugares[] = array("id" => $row -> id_sala, "nombre" => $row -> nombre);
}

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

?>
<div class="grid_64">
	<div class="grid_2">
    	<img src="<?=base_url()?>img/uva_rojo.jpg" alt="uva" width="50" align="absmiddle" />
    </div>
    <div id="grid_10">    
        <li class="menu_panel"><a href="<?=base_url()?>index.php/panel_control/missitios">Sitios</a></li>
        <li class="menu_panel"><a href="<?=base_url()?>index.php/panel_control/sin_confirmar">Sin confirmar (<?=$sin_confirmar_total?>)</a></li> 
        <li class="menu_panel"><a href="<?=base_url()?>index.php/panel_control/estadisticas">Estadisticas</a></li>
    </div>
</div>
<div class="clear"></div>

<div class="grid_64">
	<div class="grid_3">
    
    <div id="caja_menu">
    	<h1>Mis sitios</h1>
        <? for ($i=0; $i<count($mislugares); $i++) { ?>
        <li><a href="<?=base_url()?>index.php/panel_control/sitio?id=<?=$mislugares[$i]["id"]?>"><?=$mislugares[$i]["nombre"]?></a></li>
		<? } ?>
        <br />
    </div>
    
    <div id="caja_menu">
    	<h1><a href="<?=base_url()?>index.php/panel_control/sin_confirmar">Sin confirmar (<?=$sin_confirmar_total?>)</a></h1>
    </div>
    
    <div id="caja_menu">
    	<h1><a href="<?=base_url()?>index.php/panel_control/sin_confirmar">Mis reservas (<?=$todas_reservas_pendientes?>)</a></h1>
    </div>
    
    <div id="caja_menu">
    	<div id="calendario">
  	  <?=$this -> calendar -> generate($ano, $mes_numero);?>
      </div>
    </div>
    
    </div> <!-- fin grid_2 -->
   