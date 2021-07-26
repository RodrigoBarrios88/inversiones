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
						
//////////////////////// PHOTO ALBUM ///////////////////////////////

	function FotoJs(){
		inpfile = document.getElementById("fotos");
		inpfile.click();
	}
	
	function TextoFoto(){
		etiqueta = document.getElementById('etiqueta');
		foto = document.getElementById("fotos");
		cuantos = document.getElementById("cuantos");
		archivos = foto.files.length;
		cuantos.value = foto.files.length;
		var maximo = 1;
		var msj = '';
		if(archivos <= maximo && archivos > 0){
			msj = '<label class = "text-success" ><i class="fa fa-check"></i> '+archivos+' Archivo(s) seleccionados</label>';
		}else if(archivos > maximo){
			msj = '<label class = "text-danger" ><i class="fa fa-warning"></i> '+archivos+' Archivo(s) seleccionados (excede el n&uacute;mero permitido que es '+maximo+')</label>';
			swal("Ohoo!", "Excede el n\u00FAmero permitido de imagenes...", "error");	
		}else{
			msj = '';
		}
		//// Validacion
		extension = getExtension(foto);
		validExten = validateExtension(extension);
		if(validExten !== true){ // si la extension es valida, procede
			msj = '<label class = "text-danger">* La extensi&oacute;n del archivo no es valida...</label>';
			swal("Ohoo!", "La extensi\u00F3n del archivo no es valida...", "warning");
		}
		
		etiqueta.innerHTML = msj;
	}
	
	function ValidaFoto(){
		etiqueta = document.getElementById('etiqueta');
		foto = document.getElementById("fotos");
		extension = getExtension(foto);
		validExten = validateExtension(extension);
		if(validExten === true){ // si la extension es valida, procede
			myform = document.forms.f1;
			myform.submit();
		}else{ // extension no valida
			var msj = '';
			msj = '<label class = "text-danger">* La extensi&oacute;n del archivo no es valida...</label>';
			swal("Ohoo!", "La extensi\u00F3n del archivo no es valida...", "warning");
		}
		
		etiqueta.innerHTML = msj;
	}
	
	
	function test(){
		var filas = 0;
		$('#target option:selected').each(function() {
			alert($(this).val());
			filas++;
	   });
		alert(filas);
	}
	
	function Grabar(){
		maestro = document.getElementById("maestro");
		desc = document.getElementById('desc');
		cuantos = parseInt(document.getElementById("cuantos").value);
		///---
		var filas = 0;
		var target = new Array([]);
		$('#target option:selected').each(function() {
			target[filas] = $(this).val();
			filas++;
	    });
		
		if(maestro.value !==""){
			if(filas > 0){
				if(cuantos > 0){
					abrir();
					xajax_Grabar_Photo(maestro.value,desc.value,target,filas);
				}else{
					swal("Ohoo!", "No hay imagenes seleccionadas...", "error");	
				}
			}else{
				swal("Ohoo!", "No hay alumnos seleccionados...", "error");	
			}
		}else{
			swal("Error", "Error en la transacci\u00F3n, no contiene las credenciales del maestro(a) o autoridad...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		desc = document.getElementById('desc');
		
		if(codigo.value !==""){
			abrir();
			xajax_Modificar_Photo(codigo.value,desc.value);
		}else{
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	
	function ModificarTarget(){
		codigo = document.getElementById("codigo");
		///---
		var filas = 0;
		var target = new Array([]);
		$('#target option:selected').each(function() {
			target[filas] = $(this).val();
			filas++;
	    });
		
		if(codigo.value !==""){
			if(filas > 0){
				abrir();
				xajax_Modifca_Target(codigo.value,target,filas);
			}else{
				swal("Ohoo!", "No hay alumnos seleccionados...", "error");	
			}
		}else{
			swal("Error", "Error en la transacci\u00F3n, no contiene las credenciales del maestro(a) o autoridad...", "error");
		}
	}
	
	
	function deleteAlbum(codigo){
		swal({
			title: "Confirmaci\u00F3n",
			text: "\u00BFEsta seguro de eliminar este Photo Album?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: "Aceptar"
			},
			dangerMode: false,
		}).then((willDelete) => {
			if(willDelete) {
				xajax_Eliminar_Photo(codigo);
			}
		});
	}
	
	function deleteFoto(codigo,imagen){
		swal({
			title: "Confirmaci\u00F3n",
			text: "\u00BFEsta seguro de eliminar esta imagen del album?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: "Aceptar"
			},
			dangerMode: false,
		}).then((willDelete) => {
			if(willDelete) {
				xajax_Eliminar_Imagen(codigo,imagen);
			}
		});
	}
	
	function verPhoto(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/app/photo.php",{codigo:codigo}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function editAlbum(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/app/photo_edit.php",{codigo:codigo}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function targetAlbum(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/app/photo_target.php",{codigo:codigo}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	
	
	
//////////////////////// UTILITARIAS ///////////////////////////////

	function validateExtension(exten){
		var valid = false;
		switch(exten){
			case "jpg": valid = true; break;
			case "jpeg": valid = true; break;
			case "png": valid = true; break;
			default: valid = false;
		}
		return valid;
	}
	
	
	function getExtension(fileInput) {
		path = fileInput.files[0].name;
		var basename = path.split(/[\\/]/).pop(), // extract file name from full path ...
		pos = basename.lastIndexOf(".");       // get last position of `.`
		if (basename === "" || pos < 1){       // if file name is empty or ...
			return "";                         //  `.` not found (-1) or comes first (0)
		}
		
		return basename.slice(pos + 1);  // extract extension ignoring `.`
	}
