/*Ejecuta el Modal Cargando*/
/*Manuel Sosa Julio 2014*/

$(function() {	    	    
	$('#myModal').modal({
		keyboard: false,
		backdrop: true
	});
	$('#myModal').modal('hide');
});


/////////// Modal Peque–o ////////////
function abrir(){
	document.getElementById('ModalDialog').className = "modal-dialog";
	document.getElementById('lblparrafo').style.display="bolck";
	document.getElementById('Pcontainer').style.display="none";
	$('#myModal').modal('show');
	return;
}

function cerrar(){
	$('#myModal').modal('hide');
	msj = '<img src = "../../CONFIG/images/img-loader.gif" width = "23px" /><br>';
	msj+= '<label align ="center">Transaccion en Proceso...</label>';
	document.getElementById('lblparrafo').innerHTML = msj;
	document.getElementById('Pcontainer').style.display="block";
	document.getElementById('lblparrafo').style.display="block";
	return;
}


/////////// Modal Mediano ////////////
function abrirModal(){
	document.getElementById('ModalDialog').className = "modal-dialog modal-lg";
	document.getElementById('Pcontainer').style.display="block";
	document.getElementById('lblparrafo').style.display="none";
	$('#myModal').modal('show');
	return;
}

function cerrarModal(){
	$('#myModal').modal('hide');
	document.getElementById('Pcontainer').innerHTML = '';
	document.getElementById('Pcontainer').style.display="block";
	document.getElementById('lblparrafo').style.display="block";
	return;
}


/////////// Modal Mixto ////////////
function abrirMixPromt(){
	msj = '<img src = "../../CONFIG/images/img-loader.gif" width = "23px" /><br>';
	msj+= '<label align ="center">Transaccion en Proceso...</label>';
	document.getElementById('lblparrafo').innerHTML = msj;
	document.getElementById('ModalDialog').className = "modal-dialog modal-lg";
	document.getElementById('Pcontainer').style.display="none";
	document.getElementById('lblparrafo').style.display="block";
}

function cerrarMixPromt(){
	document.getElementById('Pcontainer').style.display="block";
	document.getElementById('lblparrafo').style.display="none";
	return;
}
