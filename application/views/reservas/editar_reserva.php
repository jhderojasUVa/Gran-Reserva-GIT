<? $this-> load-> helper('url'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gran Reserva - Reserva de Sala</title>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/formulario_reserva.css" />
<link href="<?=base_url();?>css/general.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/menus.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
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
</script>
</head>
<?
// Datos de la sala
foreach ($datos_sala as $row) {
	$nombre_sala = $row -> nombre;
}
foreach ($datos_reserva as $row) {
	$inicio = $this -> funccalendario -> devuelve_fecha_formateada($row -> inicio);
	$fin = $this -> funccalendario -> devuelve_fecha_formateada($row -> fin);
	$descripcion = $row -> descripcion;
	$id_reserva = $row -> id_reserva;
	$contacto = $row -> contacto;
}
?>
<body>
<div id="contenido">
	<h2>Reserva</h2>
    <p>Rellene el siguiente formulario para realizar su reserva en <strong><?=$nombre_sala?></strong></p>
    <form method="post" id="form_reserva" onsubmit="arranca_spinner();" action="<?=base_url()?>index.php/calendario/editar_reserva">
    <input type="hidden" name="id" value="<?=$sala?>">
    <input type="hidden" name="id_reserva" value="<?=$id_reserva?>" />
    <input type="hidden" name="cambio" value="1" />
    <table align="center" width="550" id="tabla_form_reserva">
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
        <tr>
            <td valign="top">Descripci&oacute;n</td>
            <td><textarea name="descripcion" rows="10" cols="25"><?=$descripcion?></textarea></td>
        </tr>
        <tr>
        	<td valign="top">Contacto</td>
            <td><input type="tel" name="contacto" id="contacto" size="20" value="<?=$contacto?>"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="editar reserva" class="boton"/>&nbsp;<a href="#" onclick="borra_reserva()" class="boton">borrar reserva</a><div id="spinner"></div></td>
        </tr>
    </table>
    </form>
    <div id="vuelta">Estado:</div>
</div>
</body>
</html>