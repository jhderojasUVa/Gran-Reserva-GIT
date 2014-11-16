<? $this-> load-> helper('url'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gran Reserva - Reserva de Sala</title>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/formulario_reserva.css" />
<link href="<?=base_url();?>css/general.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/menus.css" rel="stylesheet" type="text/css" media="all" />
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
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

function stop_spinner() {
	// Funcion que para el spinner	
	spinner.stop();
}
</script>
</head>
<?
// Datos de la sala
foreach ($datos_sala as $row) {
	$nombre_sala = $row -> nombre;
	$precio = $row -> precio;
	$descripcion = $row -> descripcion;
}

// Sacamos los recursos de la sala

?>
<body>
<div id="contenido">
	<h2>Reserva</h2>
    <p>Rellene el siguiente formulario para realizar su reserva en <strong><?=$nombre_sala?></strong></p>
    <form method="post" id="form_reserva" onsubmit="arranca_spinner();enviareserva();" >
    <input type="hidden" name="sala" value="<?=$sala?>">
    <table align="center" width="550" id="tabla_form_reserva">
        <tr>
            <td>Inicio de la reserva</td>
            <td>
            	<select name="diai">
                	<? for ($i=1;$i<=31;$i++) { ?>
						<? if ($i==$horario["dia"]) { ?>
                        <option value="<?=$i?>" selected><?=$i?></option>
                        <? } else { ?>
                        <option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select> / 
                <select name="mesi">
	                <? for ($i=1;$i<=12;$i++) { ?>
                    	<? if ($i==$horario["mes"]) { ?>
                        	<option value="<?=$i?>" selected><?=$i?></option>
                        <? } else { ?>
                        	<option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select> / 
                <select name="anoi">
                	<? for ($i=(date("Y"));$i<=(date("Y")+3);$i++) { ?>
                    	<? if ($i==$horario["ano"]) { ?>
                        	<option value="<?=$i?>" selected="selected"><?=$i?></option>
                        <? } else { ?>
                        	<option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select>&nbsp;&nbsp;
                <select name="horai">
                	<? for ($i=0;$i<=24;$i++) { ?>
                    <? if ($i<10) {
						$i="0".$i;
					} ?>
						<? if ($i==$horario["hora"]) { ?>
                            <option value="<?=$i?>" selected="selected"><?=$i?></option>
                        <? } else { ?>
                            <option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select>
                :
                <select name="minutoi">
                	<? for ($i=0;$i<60;$i=$i+30) { ?>
                    <? if ($i<10) {
						$i="0".$i;
					} ?>
                    <option value="<?=$i?>"><?=$i?></option>
					<? } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Fin de la reserva</td>
            <td>
            	<select name="diaf">
                	<? for ($i=1;$i<=31;$i++) { ?>
						<? if ($i==$horario["dia"]) { ?>
                        	<option value="<?=$i?>" selected><?=$i?></option>
                        <? } else { ?>
                        	<option value="<?=$i?>"><?=$i?></option>
                        <? } ?><? } ?>
                </select> / 
                <select name="mesf">
	                <? for ($i=1;$i<=12;$i++) { ?>
                    	<? if ($i==$horario["mes"]) { ?>
                        	<option value="<?=$i?>" selected><?=$i?></option>
                        <? } else { ?>
                        	<option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select> / 
                <select name="anof">
                	<? for ($i=(date("Y"));$i<=(date("Y")+3);$i++) { ?>
                    	<? if ($i==$horario["ano"]) { ?>
                        	<option value="<?=$i?>" selected="selected"><?=$i?></option>
                        <? } else { ?>
                        	<option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select>&nbsp;&nbsp;
                <select name="horaf">
                	<? for ($i=0;$i<=24;$i++) { ?>
                    <? if ($i<10) {
						$i="0".$i;
					} ?>
                    	<? if ($i==($horario["hora"]+1)) { ?>
                            <option value="<?=$i?>" selected="selected"><?=$i?></option>
                        <? } else { ?>
                            <option value="<?=$i?>"><?=$i?></option>
                        <? } ?>
					<? } ?>
                </select>
                :
                <select name="minutof">
                	<? for ($i=0;$i<60;$i=$i+30) { ?>
                    <? if ($i<10) {
						$i="0".$i;
					} ?>
                    <option value="<?=$i?>"><?=$i?></option>
					<? } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">Descripci&oacute;n<br /><div id="atencion">Si se necesita con antelaci&oacute;n la sala, por favor, escribalo en la descripci&oacute;n</div></td>
            <td><textarea name="descripcion" id="descripcion" rows="10" cols="35" class="caja"></textarea></td>
        </tr>
        <tr>
        	<td valign="top">Contacto</td>
            <td><input type="tel" name="contacto" id="contacto" size="50" class="caja"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="button" value="comprobar reserva" class="boton" onclick="arranca_spinner();enviareserva();" /><div id="spinner"></div></td>
        </tr>
        <tr>
        	<td>Necesidades</td>
            <td>
            	<? foreach ($recursos_sala as $row) { ?>
                	<input type="checkbox" name="recurso[]" value="<?=$row -> id_recurso?>" class="caja" />&nbsp;<?=$row -> recurso?><br />
				<? } ?>
            </td>
        </tr>
        <? if ($precio<>0) { ?>
        <tr>
        	<td>&nbsp;</td>
            <td><a href="#">Descargar las Condiciones de servicio</a></td>
        </tr>
		<? } ?>
    </table>
    </form>
    <div id="extras">
    	<?=$descripcion?>
    </div>
    <? if ($precio<>0) { ?>
    <div id="extras">Esta reserva tiene un precio de: <strong><?=$precio?></strong> euros</div>
    <? } ?>
    <div id="vuelta">Estado:</div>
</div>
</body>
</html>