<? $this-> load-> helper('url'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gran Reserva</title>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/text.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>css/960.css" />
<link href="<?=base_url();?>css/general.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>css/menus.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<script src="<?=base_url();?>js/simplemodal.js"></script>
<script src="<?=base_url();?>js/func_ajax.js"></script>
</head>

<body>

<div class="container_12"> <!-- contenedor de 12 columnas principal -->

    <div class="grid_64">
        <div id="menu_superior">
        	
            <? if ($_SESSION["es_admin"]==false && $_SESSION["usuario_normal"]==false) { ?>
            <li><a href="<?=base_url() ?>index.php/identificar">Identificarse</a></li>
            <? } else { ?>
            <li><strong><?=$usuario?></strong></li>
            <li> | </li>
            <li><a href="<?=base_url()?>index.php/principal/logout">Salir</a></li>
            <li> | </li>
            <? if ($_SESSION["es_admin"]==false) { ?>
            <li><a href="<?=base_url() ?>index.php/mis">Mis reservas</a></li>
            <? } else { // Si es administrador ?>
            <li><a href="<?=base_url() ?>index.php/panel_control"><strong>Panel de control</strong></a></li>
            <? } // fin de si es administrador ?>
            <? if ($_SESSION["fue_admin"] == true) { ?>
            <li> | </li>
            <li><a href="<?=base_url() ?>index.php/panel_control/entrar_como_user_normal">Cambiar tipo usuario</a></li>
            <? } // fin de si fue admin?>
            <? } // fin del identificado ?>
            <li> | </li>
            <li><a href="<?=base_url()?>">Inicio</a></li>
        </div>
    </div>
	<div class="clear"></div>