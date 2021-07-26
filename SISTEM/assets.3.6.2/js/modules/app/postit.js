//funciones javascript y validaciones
	
	function Limpiar(){
		swal({
			text: "\u00BFDesea Limpiar la p\u00E1gina?, si a\u00FAn no a grabado perdera los datos escritos...",
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
						
//////////////////////// POSTIT ///////////////////////////////

	function test(){
		var filas = 0;
		$('#target option:selected').each(function() {
			alert($(this).val());
			filas++;
	   });
		alert(filas);
	}
	
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		maestro = document.getElementById("maestro");
		titulo = document.getElementById('titulo');
		desc = document.getElementById('desc');
		///---
		var filas = 0;
		var target = new Array([]);
		$('#target option:selected').each(function() {
			target[filas] = $(this).val();
			filas++;
	   });
		
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && seccion.value !=="" && maestro.value !=="" && titulo.value !=="" && desc.value !==""){
			abrir();
			xajax_Grabar_Postit(pensum.value,nivel.value,grado.value,seccion.value,maestro.value,titulo.value,desc.value,target,filas);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		titulo = document.getElementById('titulo');
		desc = document.getElementById('desc');
		
		if(titulo.value !=="" && desc.value !==""){
			abrir();
			xajax_Modificar_Postit(codigo.value,titulo.value,desc.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	
	function Confirm_Elimina_Postit(codigo){
		swal({
			title: "Confirmaci\u00F3n",
			text: "\u00BFEsta seguro de eliminar esta notificaci\u00F3n?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: "Aceptar"
			},
			dangerMode: false,
		}).then((willDelete) => {
			if(willDelete) {
				xajax_Eliminar_Postit(codigo);
			}
		});
	}
	
	
	function Tipo_Target(tipo){
		divalumnos = document.getElementById("divalumnos");
		target = document.getElementById("target");
		
		if(tipo == 1){
			divalumnos.className = "col-xs-5";
			$('.chosen-select').chosen({width: "100%"});
		}else{
			target.value = "";
			divalumnos.className = "col-xs-5 hidden";
		}
	}
	
	
	function verPostit(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/app/postit.php",{codigo:codigo}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function ConfirmRecordatorio(codigo){
		swal({
			title: "\u00BFNotificar Recordatorio?",
			text: "\u00BFDesea notificar un recordatorio de esta nota?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Recordatorio(codigo);
					break;
				default:
				  return;
			}
		});
	}
