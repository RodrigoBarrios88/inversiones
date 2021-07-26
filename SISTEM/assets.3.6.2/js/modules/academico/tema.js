//funciones javascript y validaciones
	
	function Limpiar(){
		texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
		acc = "location.reload();";
		ConfirmacionJs(texto,acc);
	}
	
	function Submit(){
		myform = document.forms.f1;
		myform.submit();
	}
										
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		materia = document.getElementById("materia");
		unidad = document.getElementById("unidad");
		nom = document.getElementById("nom");
		desc = document.getElementById('desc');
		periodos = document.getElementById("periodos");
		
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && seccion.value !=="" && materia.value !=="" && nom.value !=="" && desc.value !=="" && unidad.value !=="" && periodos.value !==""){
			abrir();
			xajax_Grabar_Tema(pensum.value,nivel.value,grado.value,seccion.value,materia.value,unidad.value,nom.value,desc.value,periodos.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(materia.value ===""){
				materia.className = "form-danger";
			}else{
				materia.className = "form-control";
			}
			if(unidad.value ===""){
				unidad.className = "form-danger";
			}else{
				unidad.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(periodos.value ===""){
				periodos.className = "form-danger";
			}else{
				periodos.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");	
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		materia = document.getElementById("materia");
		unidad = document.getElementById("unidad");
		nom = document.getElementById("nom");
		desc = document.getElementById('desc');
		periodos = document.getElementById("periodos");
		
		if(codigo.value !=="" && materia.value !=="" && unidad.value !=="" && nom.value !=="" && desc.value !=="" && periodos.value !==""){
			abrir();
			xajax_Modificar_Tema(codigo.value,materia.value,unidad.value,nom.value,desc.value,periodos.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary';
		}else{
			if(materia.value ===""){
				materia.className = "form-danger";
			}else{
				materia.className = "form-control";
			}
			if(unidad.value ===""){
				unidad.className = "form-danger";
			}else{
				unidad.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(periodos.value ===""){
				periodos.className = "form-danger";
			}else{
				periodos.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Confirm_Elimina(codigo){
		swal({
			title: "",
			text: "\u00BFEsta seguro de Deshabilitar esta Tema?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Eliminar_Tema(codigo);
					break;
				default:
				  return;
			}
		});
	}
	

//////////////// ARCHIVOS //////////////////////

	function NewFile(tema,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/temas/cargar_archivo_tema.php",{tema:tema,fila:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function FileJs(){
		nom = document.getElementById("Filenom");
		desc = document.getElementById("Filedesc");
		
		if(nom.value !=="" && desc.value !==""){
			inpfile = document.getElementById("archivo");
			inpfile.click();	
		}else{
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			msj = '<label class = "text-danger">* Debe llenar los Campos Obligatorios</label>';
			document.getElementById('PromtNota').innerHTML = msj;
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function GrabarArchivos(){
		curso = document.getElementById("Filecurso");
		tema = document.getElementById("Filetema");
		nom = document.getElementById("Filenom");
		desc = document.getElementById("Filedesc");
		inpfile = document.getElementById("archivo");
		inpextension = document.getElementById("Fileextension");
		
		if(nom.value !=="" && desc.value !==""){
			/// valida la extension del archivo
			extension = getExtension(inpfile);
			validExten = validateExtension(extension);
			if(validExten === true){ // si la extension es valida, procede
				abrirMixPromt();
				inpextension.value = extension;
				xajax_Grabar_Archivo(tema.value,nom.value,desc.value,inpextension.value);
			}else{ // extension no valida
				msj = '<label class = "text-danger">* La extensi\u00F3n del archivo no es valida...</label>';
				document.getElementById('PromtNota').innerHTML = msj;
				swal("Ohoo!", "La extensi\u00F3n del archivo no es valida...", "warning");
			}
		}else{
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			msj = '<label class = "text-danger">* Debe llenar los Campos Obligatorios</label>';
			document.getElementById('PromtNota').innerHTML = msj;
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function CargaArchivos(){
		myform = document.forms.f2;
		inpfile = document.getElementById("archivo");
		/// valida la extension del archivo
		extension = getExtension(inpfile);
		validExten = validateExtension(extension);
		if(validExten === true){ // si la extension es valida, procede
			document.getElementById("Fileextension").value = extension;
			myform.submit();
		}else{ // extension no valida
			msj = '<label class = "text-danger">* La extensi\u00F3n del archivo no es valida...</label>';
			document.getElementById('PromtNota').innerHTML = msj;
			swal("Ohoo!", "La extensi\u00F3n del archivo no es valida...", "warning");
		}
	}
	
	
	function validateExtension(exten){
		var valid = false;
		switch(exten){
			case "doc": valid = true; break;
			case "docx": valid = true; break;
			case "ppt": valid = true; break;
			case "pptx": valid = true; break;
			case "xls": valid = true; break;
			case "xlsx": valid = true; break;
			case "jpg": valid = true; break;
			case "jpeg": valid = true; break;
			case "png": valid = true; break;
			case "pdf": valid = true; break;
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
	
	
	function Eliminar_Archivo(codigo,tema,archivo){
		swal({
			text: "\u00BFEsta seguro de Eliminar este Archivo?, No podra ser usado despues...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Delete_Archivo(codigo,tema,archivo);
					break;
				default:
				  return;
			}
		});
	}

		