//funciones javascript y validaciones
function Limpiar(){
	texto = "Desea Limpiar la Pagina?, perdera los datos escritos...";
	acc = "location.reload();";
	ConfirmacionJs(texto,acc);
}	

function Submit(){
	myform = document.forms.f1;
	myform.submit();
}
					

function VerBoleta(alumno,boleta){	
	//Realiza una peticion de contenido a la contenido.php
	$.post("../promts/boletas/datos_boleta.php",{boleta:boleta,alumno:alumno}, function(data){
	// Ponemos la respuesta de nuestro script en el DIV recargado
	$("#Pcontainer").html(data);
	});
	abrirModal();
		
}

function VerBoletaMora(codigo,cuenta,banco){
	//Realiza una peticion de contenido a la contenido.php
	$.post("../promts/boletas/datos_mora.php",{cod:codigo,cue:cuenta,ban:banco}, function(data){
	// Ponemos la respuesta de nuestro script en el DIV recargado
	$("#Pcontainer").html(data);
	});
	abrirModal();
}