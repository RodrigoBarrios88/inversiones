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
						
	
//////////////////////// TAREAS ///////////////////////////////
	
	function Grabar(){
		abrir();
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		materia = document.getElementById("materia");
		tema = document.getElementById('tema');
		maestro = document.getElementById("maestro");
		nom = document.getElementById('nom');
		desc = document.getElementById('desc');
		tipo = document.getElementById("tipo");
		pondera = document.getElementById("pondera");
		tipocalifica = document.getElementById("tipocalifica");
		fec = document.getElementById("fec");
		hor = document.getElementById("hor");
		link = document.getElementById("link");
		
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && materia.value !== "" && seccion.value !=="" && tema.value !== "" && maestro.value !=="" &&
		   nom.value !=="" && desc.value !=="" && tipo.value !== "" && pondera.value !== "" && tipocalifica.value !== "" && fec.value !== "" && hor.value !== ""){
			xajax_Grabar_Tarea(pensum.value,nivel.value,grado.value,seccion.value,materia.value,tema.value,maestro.value,nom.value,desc.value,tipo.value,pondera.value,tipocalifica.value,fec.value,hor.value,link.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(tema.value ===""){
				tema.className = "form-danger";
			}else{
				tema.className = "form-control";
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
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(pondera.value ===""){
				pondera.className = "form-danger";
			}else{
				pondera.className = "form-control";
			}
			if(tipocalifica.value ===""){
				tipocalifica.className = "form-danger";
			}else{
				tipocalifica.className = "form-control";
			}
			if(fec.value ===""){
				fec.className = "form-danger";
			}else{
				fec.className = "form-control";
			}
			if(hor.value ===""){
				hor.className = "form-danger";
			}else{
				hor.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		abrir();
		codigo = document.getElementById('codigo');
		tema = document.getElementById('tema');
		maestro = document.getElementById("maestro");
		nom = document.getElementById('nom');
		desc = document.getElementById('desc');
		tipo = document.getElementById("tipo");
		pondera = document.getElementById("pondera");
		tipocalifica = document.getElementById("tipocalifica");
		fec = document.getElementById("fec");
		hor = document.getElementById("hor");
		link = document.getElementById("link");
		
		if(tema.value !== "" && nom.value !=="" && desc.value !=="" && tipo.value !== "" && pondera.value !== "" && tipocalifica.value !== "" && fec.value !== "" && hor.value !== ""){
			xajax_Modificar_Tarea(codigo.value,tema.value,maestro.value,nom.value,desc.value,tipo.value,pondera.value,tipocalifica.value,fec.value,hor.value,link.value);
				//botones
				gra = document.getElementById("gra");
				mod = document.getElementById("mod");
				mod.className = 'btn btn-primary';
				gra.className = 'btn btn-primary hidden';
		}else{
			if(tema.value ===""){
				tema.className = "form-danger";
			}else{
				tema.className = "form-control";
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
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(pondera.value ===""){
				pondera.className = "form-danger";
			}else{
				pondera.className = "form-control";
			}
			if(tipocalifica.value ===""){
				tipocalifica.className = "form-danger";
			}else{
				tipocalifica.className = "form-control";
			}
			if(fec.value ===""){
				fec.className = "form-danger";
			}else{
				fec.className = "form-control";
			}
			if(hor.value ===""){
				hor.className = "form-danger";
			}else{
				hor.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function GrabarCalificacion(fila){
		tarea = document.getElementById('tarea');
		alumno = document.getElementById("alumno");
		nota = document.getElementById('nota');
		obs = document.getElementById('obs');
		
		if(tarea.value !== "" && alumno.value !=="" && nota.value !==""){
			//alert(tarea.value+","+alumno.value+","+nota.value+","+obs.value+","+fila);
			xajax_Calificar_Tarea(tarea.value,alumno.value,nota.value,obs.value,fila);
		}else{
			if(nota.value ===""){
				nota.className = "form-danger";
			}else{
				nota.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Confirm_Elimina_Tarea(codigo){
		swal({
			text: "\u00BFEsta seguro de eliminar esta Tarea con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Eliminar_Tarea(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Calificar_Tarea(fila){	
		alumno = document.getElementById("alumno"+fila).value;
		tarea = document.getElementById("tarea"+fila).value;
		if(alumno !== "" && tarea !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("FRMcalificartareadoc.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
			
		}
	}
	
	function Modificar_Calificacion(fila){
		alumno = document.getElementById("alumno"+fila).value;
		tarea = document.getElementById("tarea"+fila).value;
		if(alumno !== "" && tarea !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/tarea/modificar.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
			
		}
	}
	
	function ValidaMaximoPunteo(puntos){
		var maximo = parseFloat(document.getElementById("maximo").value);
		var punteo = parseFloat(puntos);
		
		if(punteo > maximo){
			swal("Ohoo!", "La puntuaci\u00F3n es mayor al m\u00E1ximo de puntos permitido..", "warning");
		}
		return;
	}
	
	
	function Observaciones(fila){	
		alumno = document.getElementById("alumno"+fila).value;
		tarea = document.getElementById("tarea"+fila).value;
		if(alumno !== "" && tarea !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/tarea/observaciones.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
			
		}
	}
	
	
	function Resolucion(fila){
		alumno = document.getElementById("alumno"+fila).value;
		tarea = document.getElementById("tarea"+fila).value;
		if(alumno !== "" && tarea !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/tarea/resolucion.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
			
		}
	}
	
	
	function Combo_Nivel_Grado(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !==""){
			xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Combo_Grado_Materia_Seccion()");
		}
	}
	
	function Combo_Grado_Materia_Seccion(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById('grado');
		maestro = document.getElementById('maestro');
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== ""){
			xajax_Grado_Materia_Seccion(pensum.value,nivel.value,grado.value,maestro.value,'materia','divmateria','seccion','divseccion');
		}
	}
	
	
//////////////// ARCHIVOS DE TAREAS //////////////////////

	function NewFile(tarea,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/tarea/cargar_archivo_tarea.php",{tarea:tarea,fila:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function FileJs(){
		nom = document.getElementById("Filenom");
		desc = document.getElementById("Filedesc");
		
		if(nom.value !==""){
			inpfile = document.getElementById("archivo");
			inpfile.click();	
		}else{
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			msj = '<label class = "text-danger">* Debe llenar los Campos Obligatorios</label>';
			document.getElementById('PromtNota').innerHTML = msj;
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function GrabarArchivos(){
		tarea = document.getElementById("Filetarea");
		nom = document.getElementById("Filenom");
		desc = document.getElementById("Filedesc");
		inpfile = document.getElementById("archivo");
		inpextension = document.getElementById("Fileextension");
		
		if(nom.value !==""){
			/// valida la extension del archivo
			extension = getExtension(inpfile);
			validExten = validateExtension(extension);
			if(validExten === true){ // si la extension es valida, procede
				abrirMixPromt();
				inpextension.value = extension;
				xajax_Grabar_Archivo(tarea.value,nom.value,desc.value,inpextension.value);
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
			msj = '<label class = "text-danger">* La extensi&oacute;n del archivo no es valida...</label>';
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
			case "odp": valid = true; break;
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
	
	
	function Eliminar_Archivo(codigo,tarea,archivo){
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
					xajax_Delete_Archivo(codigo,tarea,archivo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function ReEnviarTodos(pensum,nivel,grado,seccion,tarea){
		swal({
			text: "\u00BFEsta seguro(a) de Reenviar esta tarea a todos los alumnos? si ya hay tareas calificadas se reiniciar\u00E1n sus estatus...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Reenviar_Tarea_Todos(pensum,nivel,grado,seccion,tarea);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function ReEnviarTarea(tarea,alumno){
		swal({
			text: "\u00BFEsta seguro(a) de Reenviar esta tarea a este(a) alumno(a)? si ya ha sido calificada se reiniciar\u00E1 su estatus...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Reenviar_Tarea_Alumno(tarea,alumno);
					break;
				default:
				  return;
			}
		});
	}
