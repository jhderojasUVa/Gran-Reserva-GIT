// JavaScript Document


function devuevleselect(idselect) {
	// Funcion jquery que devuelve el valor de un select cuando varia
	// En caso de un multi, devolvera un array (a tener en cuenta)
	$("#"+idselect).change(function() {
	   var valor_a_devolver = $("#"+idselect).val();
   });
   
   return valor_a_devolver
}

function devuelvetexto(idtexto) {
	// Funcion que devuelve el valor de un texto
	$("#"+idtexto).keyup(function () {
      var value = $(this).val();
	  return value;
    }).keyup();
}

function cambiasala() {
	// Funcion que cambia la sala segun el lugar seleccionado
	$.post("/gran_reserva/index.php/ajax/mostrar_sitios", { lugar: $("#lugar").val() },
		function(data) {
			$("#formulariosalas").html(data);
		});
}

function enviasala() {
	alert("enviando sala: ".$("#sala").val());
	$.post("/gran_reserva/index.php", { sala: $("#sala").val() },
		function(data) {
		});
}

function enviareserva() {
	// Funcion que envia una reserva
	$.post("/gran_reserva/index.php/calendario/reservar", {
			diai: $("select[name=diai]").val(),
			mesi: $("select[name=mesi]").val(),
			anoi: $("select[name=anoi]").val(),
			horai: $("select[name=horai]").val(),
			minutoi: $("select[name=minutoi]").val(),
			diaf: $("select[name=diaf]").val(),
			mesf: $("select[name=mesf]").val(),
			anof: $("select[name=anof]").val(),
			horaf: $("select[name=horaf]").val(),
			minutof: $("select[name=minutof]").val(),
			descripcion: $("textarea#descripcion").val(),
			sala: $("input[name=sala]").val(),
			contacto: $("input[name=contacto").val(),
			recurso: $("input[name=recurso").val()
		},
		function(data) {
			$("#vuelta").html(data);
		});
	// Paramos el spinner
	stop_spinner();
}

function selecciona_todas_reserva() {
	// Funcion que selecciona todos los id_reserva
	$("input").attr("checked", true);
}

function no_selecciona_todas_reserva() {
	// Funcion que selecciona todos los id_reserva
	$("input").attr("checked", false);
}

function borra_muchas_reservas () {
	// Funcion que ajaxea y borra muchas reservas
	var valor_del_id = "";
	$("input[type='checkbox']:checked").each (
			function (id, objetohtml) {
				valor_del_id = $(objetohtml).val();
				$.get("/gran_reserva/index.php/calendario/borrar_reserva/?id="+valor_del_id+"&ok=1", {
				},
				function (data) {
					$("#vuelta").html(data);
					alert("Se han borrado todas las reservas.\nEl borrado se ha realizado con exito.");
				});
			});
}

function borra_reserva() { 
	var id_reserva = $('[name=id_reserva]').val();
	//	alert("ID VALE="+id_reserva);
	if (confirm("Desea eliminar la reserva")) {
		$.get("/gran_reserva/index.php/calendario/borrar_reserva/?id="+id_reserva+"&ok=1", {
			},
			function (data) {
				$("#vuelta").html(data);
			});
		alert("Se ha eliminado la reserva.");
	} else {
		return false;
	}
}

function borrar_reserva_stream(id) {
	if (confirm("Desea eliminar la reserva")) {
		$.get("/gran_reserva/index.php/calendario/borrar_reserva/?id="+id+"&ok=1", {
			},
			function (data) {
				$("#vuelta").html(data);
			});
		alert("Se ha eliminado la reserva.");
		location.href="/gran_reserva/index.php/mis";
	} else {
		return false;
	}
}

function abrir_modal(url) {
	// Funcion que abre un modal con una url determinada
	$.modal("<iframe src='"+url+"' frameborder='0' width='650' height='700' scrolling='auto'></iframe>", {
		close: true,
		escClose: true,
		onClose: function() {
			window.location.reload(true);
		}
	});
}