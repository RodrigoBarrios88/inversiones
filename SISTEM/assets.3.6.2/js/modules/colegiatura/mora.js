//funciones javascript y validaciones
function Limpiar(){
	swal({
		text: "\u00BFDesea Limpiar la p\u00E1gina?",
		icon: "info",
		buttons: {
			cancel: "Cancelar",
			ok: { text: "Aceptar", value: true,},
		}
	}).then((value) => {
		switch (value) {
			case true:
				window.location.reload();
				break;
			default:
			  return;
		}
	});
}

function Submit(){
	myform = document.forms.f1;
	myform.submit();
}

	function openBoletas(bloque){
		window.open("../../CONFIG/BOLETAS/REPboletas_mora_colores.php?bloque="+bloque);
		window.location.href="FRMmora.php";
	}

//////////////// BOLETAS DE COBRO //////////////////////

function GrabarMora(){
	
	division = document.getElementById("division");
	grupo = document.getElementById("grupo");
	periodo = document.getElementById("periodo");
	nivel = document.getElementById("nivel");
	grado = document.getElementById("grado");
	seccion = document.getElementById("seccion");
	desde = document.getElementById("desde");
	hasta = document.getElementById("hasta");
	tipomora = document.getElementById("tipomora");
	monto = document.getElementById("monto");
	motivo = document.getElementById("motivo");

	if(division.value !=="" && grupo.value !=="" && monto.value !=="" && motivo.value !=="" && tipomora.value !==""){
		abrir();
		xajax_Grabar_Mora(division.value, grupo.value, periodo.value, nivel.value, grado.value, seccion.value, desde.value, hasta.value, tipomora.value, monto.value, motivo.value);
	}else{
		if(grupo.value ===""){
			grupo.className = "form-danger";
		}else{
			grupo.className = "form-control";
		}
		if(division.value ===""){
			division.className = "form-danger";
		}else{
			division.className = "form-control";
		}
		if(monto.value ===""){
			monto.className = "form-danger";
		}else{
			monto.className = "form-control";
		}
		if(motivo.value ===""){
			motivo.className = "form-danger";
		}else{
			motivo.className = "form-control";
		}
		if(tipomora.value ===""){
			tipomora.className = "form-danger";
		}else{
			tipomora.className = "form-control";
		}
		
		swal("Error","Debe llenar los Campos Obligatorios","error");
	}
}


function Confirm_EliminarMora(grupo){	
	//Realiza una peticion de contenido a la contenido.php
	$.post("../promts/boletas/eliminar_moras.php",{grupo:grupo}, function(data){
	// Ponemos la respuesta de nuestro script en el DIV recargado
	$("#Pcontainer").html(data);
	});
	abrirModal();		
}


function EliminarMoras(){
	grupo = document.getElementById("grupo1");
	justifica = document.getElementById("justifica1");
	if(justifica.value !==""){
		abrirMixPromt();
		xajax_Eliminar_Moras(grupo.value, justifica.value);
	}else{
		if(justifica.value ===""){
			justifica.className = "form-danger";
		}else{
			justifica.className = "form-control";
		}
		swal("Error","Debe llenar los Campos Obligatorios","error");
	}
}