<? $this-> load-> helper('url'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gran Reserva</title>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/text.css" />
<link href="<?=base_url();?>css/general.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/menus.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/formulario_reserva.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<script src="<?=base_url();?>js/simplemodal.js"></script>
<script src="<?=base_url();?>js/func_ajax.js"></script>
</head>

<body>
<div id="contenido">
    <h1>A&ntilde;ada o modifique datos de la persona</h1>
    <p>Estos datos son de uso interno y no se muestran de cara al publico.</p>
    <form action="<?=base_url()?>index.php/panel_control/comentar" method="post">
    <input type="hidden" name="iduser"  value="<?=$usuario_denuncia?>" />
    <input type="hidden" name="idreserva" value="<?=$reserva_denuncia?>" />
    <input type="hidden" name="enviado" value="1" />
    <table align="center">
        <tr>
            <td>Usuario <strong><?=$usuario?></strong></td>
        </tr>
        <tr>
            <td align="center"><textarea name="observaciones" cols="80" rows="12"><?=$observaciones?></textarea></td>
        </tr>
        <tr>
            <td align="center"><input type="submit" value="a&ntilde;adir denuncia" class="boton" /></td>
        </tr>
    </table>
    </form>
</div>
</body>
</html>