<link href="<?=base_url();?>css/calendario.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/modal.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/busquedas.css" rel="stylesheet" type="text/css" media="all" />
<div class="grid_64 fondo_gris">
	<div class="grid_7 izq_todo" id="calendario_lugares">
    </div>
    <div id="grid_5">
    	<form action="<?=base_url()?>index.php/buscar" method="post" class="form">
          	<input type="text" name="buscar" placeholder="buscar..." class="form_buscar" value="<?=$busqueda?>"/> <input type="image" src="<?=base_url()?>img/lupa.png" align="right" width="20" class="form_boton" />
        </form>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>

<div class="container_8">
<h1 class="resultados"><span>Resultados de la búsqueda</span></h1>

<div class="grid_8" id="calendario">
<h1 align="left">Resultados de Reservas</h1>

<? if (count($reservas)>0) { ?>
<table align="center" width="500" name="reservas">
	<tr>
    	<th width="300">Descripcion</th>
        <th></th>
    </tr>
    <? foreach ($reservas as $row) { ?>
    <tr>
    	<td width="300" valign="middle">
        	<? if (strlen($row -> descripcion)>200) { ?>
            	<a href="#" onclick="abrir_modal('<?=base_url()?>index.php/calendario/ver_reserva?id=<?=$row -> id_reserva?>&sala=<?=$row -> sala?>')"><?=substr($row -> descripcion, 0, 180)."(...)"?></a>
            <? } else { ?>
            	<a href="#" onclick="abrir_modal('<?=base_url()?>index.php/calendario/ver_reserva?id=<?=$row -> id_reserva?>&sala=<?=$row -> sala?>')"><?=$row -> descripcion?></a>
            <? } ?>
        </td>
        <td valign="top" width="21"><a href="#" onclick="abrir_modal('<?=base_url()?>index.php/calendario/ver_reserva?id=<?=$row -> id_reserva?>&sala=<?=$row -> sala?>')"><img src="<?=base_url()?>img/flechader.png" alt="ver reserva" width="20" border="0"/></a></td>
    </tr>
	<? } ?>
</table>
<script>
$("tr:odd").css("background-color", "#f4f4f4");
</script>
<? } else { ?>
<p align="left">No se encontraron resultados para <strong><?=$busqueda?></strong>.</p>
<? } ?>
</div>
<div class="clear"></div>
<div class="grid_8" id="calendario">
<h1 align="left">Resultados de Lugares</h1>
<? if (count($lugares)>0) { ?>
<table align="center" width="500" name="lugares">
	<tr>
    	<th>Nombre</th>
        <th></th>
    </tr>
    <? foreach ($lugares as $row) { ?>
    <tr>
    	<td width="300"><?=$row -> facultad?></td>
        <td></td>
    </tr>
	<? } ?>
</table>
<script>
$("tr:odd").css("background-color", "#f4f4f4");
</script>
<? } else { ?>
<p align="left">No se encontraron resultados para <strong><?=$busqueda?></strong>.</p>
<? } ?>
</div>
</div> <!-- fin del container12 -->

<div class="container_3">
<div class="grid_3 beta" id="busquedas">
	<h2 align="left">Ayuda en las busquedas</h2>
    <p align="left"><strong>1</strong>. Escriba los terminos por los que quiere buscar separados por espacios.</p>
    <p align="left"><strong>2</strong>. Si no aparece su busqueda, pruebe a poner terminos más genericos.</p>
</div>
</div> <!-- fin del container3 -->

<div class="clear"></div>