<? $this-> load-> helper('url'); ?>
<?

$array_colectivos = array ("2" => "PDI", "3" => "PAS", "9" => "PAS con labores de PDI");

// Datos de la sala
foreach ($datos_sala as $row) {
	$nombre_sala = $row -> nombre;
	$precio = $row -> precio;
	
}

foreach ($datos_reserva as $row) {
	$inicio = $this -> funccalendario -> devuelve_fecha_formateada($row -> inicio);
	$fin = $this -> funccalendario -> devuelve_fecha_formateada($row -> fin);
	$descripcion = $row -> descripcion;
	$id_reserva = $row -> id_reserva;
	$usuario_reserva = $row -> persona;
	$contacto = $row -> contacto;
}

$nombre_usuario_reserva = $this -> ldap -> sacar_datos_ldap($usuario_reserva);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gran Reserva - Reserva de Sala</title>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/formulario_reserva.css" />
<link href="<?=base_url();?>css/general.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/menus.css" rel="stylesheet" type="text/css" media="all" />
<ascript src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="<?=base_url();?>js/func_ajax.js"></script>
<script src="<?=base_url();?>js/spin.js"></script>
<script language="javascript">
function arranca_spinner() {
	// Funcion que saca un spinner segun
	var opts = {
	  lines: 12, // The number of lines to draw
	  length: 4, // The length of each line
	  width: 3, // The line thickness
	  radius: 6, // The radius of the inner circle
	  color: '#000', // #rgb or #rrggbb
	  speed: 1, // Rounds per second
	  trail: 60, // Afterglow percentage
	  shadow: false // Whether to render a shadow
	};
	var target = document.getElementById('spinner');
	var spinner = new Spinner(opts).spin(target);
}
function mensaje() {
	if (confirm("¿Estas seguro que quieres borrar la reserva?.")) {
		window.location="<?=base_url()?>index.php/calendario/borrar_reserva/?id=<?=$id_reserva?>&ok=1";
		return true;
	}
}
</script>
</head>
<body>
<div id="contenido">
	<h2>Reserva</h2>
    <p>Datos de la reserva en <strong><?=$nombre_sala?></strong></p>
    <table align="center" width="500" id="tabla_form_reserva">
        <tr>
            <td>Inicio de la reserva</td>
            <td>
            	<?=$inicio["dia"]."/".$inicio["mes"]."/".$inicio["ano"]." ".$inicio["hora"].":".$inicio["minuto"]?>
            </td>
        </tr>
        <tr>
            <td>Fin de la reserva</td>
            <td>
            	<?=$fin["dia"]."/".$fin["mes"]."/".$fin["ano"]." ".$fin["hora"].":".$fin["minuto"]?>
            </td>
        </tr>
        <tr>
            <td valign="top">Descripci&oacute;n</td>
            <td>
            	<?=$descripcion?>
                <? if ($precio<>0) { ?>
                <hr />Precio de la reserva: <strong><?=$precio?></strong>
				<? } ?>
            </td>
        </tr>
        <? if ($_SESSION["es_admin"]==true || $_SESSION["fue_admin"]==true) { ?>
        <tr>
        	<td valign="top">Contacto</td>
            <td valign="top"><?=$contacto?></td>
        </tr>
        <tr>
        	<td valign="top">Extensi&oacute;n UVa</td>
            <td valign="top"><?=$nombre_usuario_reserva["extension"]?></td>
        </tr>
        <tr>
        	<td valign="top">Colectivo UVa</td>
            <td valign="top">
            	<?
					switch ($nombre_usuario_reserva["colectivo"]) {
						case 2:
							echo "PDI";
							break;
						case 3:
							echo "PAS";
							break;
						case 9:
							echo "PAS con labores de PDI";
							break;
						default:
							echo "Pertenece a la UVa";
							break;
					}
				?>
            </td>
        </tr>
        <? } ?>
        <tr>
        	<td>Reservado por</td>
            <td><?=$nombre_usuario_reserva["nombre"]?><? if ($_SESSION["es_admin"]==true) { ?>&nbsp;&nbsp;&nbsp;<a href="mailto:<?=$nombre_usuario_reserva["mail"]?>"  class="boton">enviar correo</a><? } ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
            <? if ($duenyo_reserva == TRUE) { ?>
            	<a href="#" class="boton" onclick="borra_reserva()">Borrar</a>&nbsp;<a href="<?=base_url()?>index.php/calendario/editar_reserva/?id=<?=$id_reserva?>&id_reserva=<?=$id_reserva?>" class="boton">Editar</a>&nbsp;
			<? } ?>
            <a href="<?=base_url()?>index.php/mis/ics/?id_reserva=<?=$id_reserva?>" class="boton">descargar ICS</a></td>
        </tr>
    </table>
    <div id="vuelta">Estado:</div>
</div>
</body>
</html>