<?
$this-> load-> helper('url');
$this -> load -> library -> ldap;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lista de reservas para el mes <?=$mes_letras?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/imprimir.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
</head>

<body>
<table>
	<tr>
    	<td><img src="<?=base_url()?>img/logo_uva_azul.png" width="200" /></td>
        <td>
        	<h1>Lista de reservas para el mes <?=$mes_letras?></h1>
			<h2>Para <?=$datos_sala?></h2>
        </td>
    </tr>
</table>
<br />
<? if (count($reservas_pollo)>0) { ?>
<table border="0" id="lista">
        <tr>
            <th width="70">Fecha</th>
            <th width="80">Hora</th>
            <th>Descripci&oacute;n</th>
            <th>Reservado por</th>
        </tr>
        <?
        foreach ($reservas_pollo as $row) { 
            $fechai = substr($row->inicio,8,2)."/".substr($row->inicio,5,2)."/".substr($row->inicio,0,4);
            $fechaf = substr($row->fin,8,2)."/".substr($row->fin,5,2)."/".substr($row->fin,0,4);
            $horai = substr($row->inicio,11,5);
            $horaf = substr($row->fin,11,5);
        ?>
        <tr id="linea">
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
            <td>
            	<?=$row->persona ?>
            	<? $usuario = $this -> ldap -> sacar_datos_ldap($row -> persona) ?>
                <?=$usuario["nombre"] ?> - Extensión: <?=$usuario["mail"] ?> - Contacto: <?=$row -> contacto ?>
            </td>
        </tr>
        <? } ?>
</table>
<script>
$(document).ready(function() {
	window.print();
	window.close();
});
</script>
<? } else { ?>
<p>No existen reservas para el mes <?=$mes_letras?>. Pulse <a href="javascript:window.close()">aquí para cerrar esta ventana sin imprimir</a>.
<? } ?>
</body>
</html>