<?
// Cabecera del ICS
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=gran_reserva.ics");

$this -> load -> model("salas_model");

function limpiatexto($texto) {
	$texto = str_replace("á", "a", $texto);
	$texto = str_replace("é", "e", $texto);
	$texto = str_replace("í", "i", $texto);
	$texto = str_replace("ó", "o", $texto);
	$texto = str_replace("ú", "u", $texto);
	
	$texto = str_replace("Á", "A", $texto);
	$texto = str_replace("É", "E", $texto);
	$texto = str_replace("Í", "I", $texto);
	$texto = str_replace("Ó", "O", $texto);
	$texto = str_replace("Ú", "U", $texto);
	
	$texto = str_replace("ñ", "n", $texto);
	$texto = str_replace("Ñ", "N", $texto);
	
	return $texto;
}
// Datos
?>
BEGIN:VCALENDAR<?="\n"?>
VERSION:2.0<?="\n"?>
CALSCALE:GREGORIAN<?="\n"?>
<? foreach ($mis_reservas as $row) { ?>
BEGIN:VEVENT<?="\n"?>
UID:<?=rand(1000,9999)?>-<?=rand(1000,9999)?>-<?=rand(1000,9999)?><?="\n"?>
CREATED:<?=date("Y")?><?=date("m")?><?=date("d")?>T<?=date("H")?><?=date("i")?>00<?="\n"?>
DTSTAMP:<?=date("Y")?><?=date("m")?><?=date("d")?>T<?=date("H")?><?=date("i")?>00<?="\n"?>
ORGANIZER;CN="<?=$datos_usuario["cn"]?>":MAILTO:<?=$datos_usuario["mail"]?>@uva.es<?="\n"?>
DTSTART:<?=$this -> funccalendario -> devuelve_fecha_ics($row -> inicio)?><?="\n"?>
DTEND:<?=$this -> funccalendario -> devuelve_fecha_ics($row -> fin)?><?="\n"?>
SUMMARY;LANGUAGE=es:"Reserva de <?=$this -> salas_model -> nombre_sala($row -> sala)?>"<?="\n"?>
DESCRIPTION;LANGUAGE=es:<?=trim(limpiatexto($row -> descripcion))?><?="\n"?>
END:VEVENT<?="\n"?>
<? } ?>
END:VCALENDAR
