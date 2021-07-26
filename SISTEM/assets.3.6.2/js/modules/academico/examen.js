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
						
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		materia = document.getElementById("materia");
		unidad = document.getElementById('unidad');
		tema = document.getElementById('tema');
		maestro = document.getElementById("maestro");
		tipo = document.getElementById('tipo');
		titulo = document.getElementById('titulo');
		desc = document.getElementById("desc");
		tipocalifica = document.getElementById("tipocalifica");
		fecini = document.getElementById('fecini');
		horini = document.getElementById('horini');
		fecfin = document.getElementById('fecfin');
		horfin = document.getElementById('horfin');
		repetir = document.getElementById('repetir');
		acalificar = document.getElementById('acalificar');
		
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && materia.value !== "" && seccion.value !=="" && unidad.value !== "" && maestro.value !=="" &&
			titulo.value !=="" && desc.value !== "" && tipocalifica.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== "" && tipo.value !== "" && repetir.value !== "" && acalificar.value !== ""){
			abrir();
			xajax_Grabar_Examen(pensum.value,nivel.value,grado.value,seccion.value,materia.value,maestro.value,unidad.value,tema.value,tipo.value,titulo.value,desc.value,tipocalifica.value,fecini.value,horini.value,fecfin.value,horfin.value,repetir.value,acalificar.value);
		}else{
			if(unidad.value ===""){
				unidad.className = "form-danger";
			}else{
				unidad.className = "form-control";
			}
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger text-libre";
			}else{
				tipo.className = "form-control text-libre";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(tipocalifica.value ===""){
				tipocalifica.className = "form-danger";
			}else{
				tipocalifica.className = "form-control";
			}
			if(fecini.value ===""){
				fecini.className = "form-danger text-libre";
			}else{
				fecini.className = "form-control text-libre";
			}
			if(horini.value ===""){
				horini.className = "form-danger text-libre";
			}else{
				horini.className = "form-control text-libre";
			}
			if(fecfin.value ===""){
				fecfin.className = "form-danger text-libre";
			}else{
				fecfin.className = "form-control text-libre";
			}
			if(horfin.value ===""){
				horfin.className = "form-danger text-libre";
			}else{
				horfin.className = "form-control text-libre";
			}
			if(repetir.value ===""){
				repetir.className = "form-danger";
			}else{
				repetir.className = "form-control";
			}
			if(acalificar.value ===""){
				acalificar.className = "form-danger";
			}else{
				acalificar.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		abrir();
		codigo = document.getElementById('codigo');
		unidad = document.getElementById('unidad');
		tema = document.getElementById('tema');
		maestro = document.getElementById("maestro");
		tipo = document.getElementById('tipo');
		titulo = document.getElementById('titulo');
		desc = document.getElementById("desc");
		tipocalifica = document.getElementById("tipocalifica");
		fecini = document.getElementById('fecini');
		horini = document.getElementById('horini');
		fecfin = document.getElementById('fecfin');
		horfin = document.getElementById('horfin');
		repetir = document.getElementById('repetir');
		acalificar = document.getElementById('acalificar');
		
		if(unidad.value !=="" && titulo.value !=="" && desc.value !== "" && tipocalifica.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== "" && tipo.value !== "" && repetir.value !=="" && acalificar.value !== "" ){
			xajax_Modificar_Examen(codigo.value,unidad.value,tema.value,tipo.value,titulo.value,desc.value,tipocalifica.value,fecini.value,horini.value,fecfin.value,horfin.value,repetir.value,acalificar.value);
		}else{
			if(unidad.value ===""){
				unidad.className = "form-danger";
			}else{
				unidad.className = "form-control";
			}
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger text-libre";
			}else{
				tipo.className = "form-control text-libre";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(tipocalifica.value ===""){
				tipocalifica.className = "form-danger";
			}else{
				tipocalifica.className = "form-control";
			}
			if(fecini.value ===""){
				fecini.className = "form-danger text-libre";
			}else{
				fecini.className = "form-control text-libre";
			}
			if(horini.value ===""){
				horini.className = "form-danger text-libre";
			}else{
				horini.className = "form-control text-libre";
			}
			if(fecfin.value ===""){
				fecfin.className = "form-danger text-libre";
			}else{
				fecfin.className = "form-control text-libre";
			}
			if(horfin.value ===""){
				horfin.className = "form-danger text-libre";
			}else{
				horfin.className = "form-control text-libre";
			}
			if(repetir.value ===""){
				repetir.className = "form-danger text-libre";
			}else{
				repetir.className = "form-control text-libre";
			}if(acalificar.value ===""){
				acalificar.className = "form-danger text-libre";
			}else{
				acalificar.className = "form-control text-libre";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ConfirmEliminar(codigo){
		swal({
			text: "\u00BFEsta seguro de eliminar este ex\u00E1men con todos sus registros? No podra ser contestado, ni revisar sus resultados con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Examen(codigo);
					break;
				default:
				  return;
			}
		});
	}

	
	//--------- PREGUNTAS ---------------//
	function GrabarPregunta(){
		opcion1 = document.getElementById('option1')
		opcion = document.getElementById('options')
		examen = document.getElementById("examen");
		pregunta = document.getElementById("pregunta");
		tipo = document.getElementById("tipo");
		puntos = document.getElementById("puntos");
		var arr_respuestas2=['Verdadero','Falso'];
		let arr_respuestas1 = new Array();
		let listaInputs = document.getElementsByName("field_name[]");
		listaInputs.forEach( elemento =>{
			//console.log( elemento.value );
			arr_respuestas1.push( elemento.value );
		});
		
		if(tipo.value == "2"){
			arr_respuestas = arr_respuestas2;
		}else{
			arr_respuestas = arr_respuestas1;
		}
		//console.log(arr_respuestas);
		if(pregunta.value !=="" && tipo.value !=="" && puntos.value !==""){
			if(tipo.value !== "3" ){
				abrir();
				//console.log(examen.value,pregunta.value,tipo.value,puntos.value,arr_respuestas);
				xajax_Grabar_Pregunta_Respuestas(examen.value,pregunta.value,tipo.value,puntos.value,arr_respuestas);
			}else{
				abrir();
				xajax_Grabar_Pregunta(examen.value,pregunta.value,tipo.value,puntos.value);
				//botones
				grab = document.getElementById('grab');
				mod = document.getElementById("mod");
				mod.className = 'btn btn-primary hidden';
				grab.className = 'btn btn-primary hidden';
			}
		}else{
			if(pregunta.value ===""){
				pregunta.className = " form-danger";
			}else{
				pregunta.className = " form-control";
			}
			if(tipo.value ===""){
				tipo.className = " form-danger";
			}else{
				tipo.className = " form-control";
			}
			if(puntos.value ===""){
				puntos.className = " form-danger";
			}else{
				puntos.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarPregunta(){
		abrir();
		codigo = document.getElementById('codigo');
		examen = document.getElementById("examen");
		pregunta = document.getElementById("pregunta");
		tipo = document.getElementById("tipo");
		puntos = document.getElementById("puntos");
		var arr_respuestas2=['Verdadero','Falso'];
		let arr_respuestas1 = new Array();
		let listaInputs = document.getElementsByName("field_name[]");
		listaInputs.forEach( elemento =>{
			//console.log( elemento.value );
			arr_respuestas1.push( elemento.value );
		});
		
		if(tipo.value == "2"){
			arr_respuestas = arr_respuestas2;
		}else{
			arr_respuestas = arr_respuestas1;
		}
		
		if(codigo.value !=="" && pregunta.value !=="" && tipo.value !=="" && puntos.value !==""){
				if(tipo.value !== "3" ){
					abrir();
					xajax_Modificar_Pregunta_Respuesta(codigo.value,examen.value,pregunta.value,tipo.value,puntos.value,arr_respuestas);
					//botones
					grab = document.getElementById('grab');
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
					grab.className = 'btn btn-primary hidden';
				}else{
					abrir();
					xajax_Modificar_Pregunta(codigo.value,examen.value,pregunta.value,tipo.value,puntos.value);
					//botones
					grab = document.getElementById('grab');
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
				}
			
		}else{
			if(pregunta.value ===""){
				pregunta.className = " form-danger";
			}else{
				pregunta.className = " form-control";
			}
			if(tipo.value ===""){
				tipo.className = " form-danger";
			}else{
				tipo.className = " form-control";
			}
			if(puntos.value ===""){
				puntos.className = " form-danger";
			}else{
				puntos.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Eliminar_Pregunta(codigo,examen){
		swal({
			text: "\u00BFEsta seguro de Deshabilitar esta pregunta?, No podra ser contestada, ni revisar sus resultados con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Pregunta(codigo,examen);
					break;
				default:
				  return;
			}
		});
	}
	
	////////////////// CALIFICAR //////////////////////////////
	
	function Calificar_Examen(fila){	
		alumno = document.getElementById("alumno"+fila).value;
		examen = document.getElementById("examen"+fila).value;
		if(alumno !== "" && examen !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/examen/calificar.php",{examen:examen,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
		}
	}
	
	function Modificar_Calificacion(fila){
		alumno = document.getElementById("alumno"+fila).value;
		examen = document.getElementById("examen"+fila).value;
		if(alumno !== "" && examen !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/examen/modificar.php",{examen:examen,alumno:alumno,fila:fila}, function(data){
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
	
	function GrabarCalificacion(){
		examen = document.getElementById('examen');
		alumno = document.getElementById("alumno");
		nota = document.getElementById('nota');
		obs = document.getElementById('obs');
		
		if(examen.value !== "" && alumno.value !=="" && nota.value !==""){
			//alert(examen.value+","+alumno.value+","+nota.value+","+obs.value+","+fila);
			xajax_Calificar_Examen(examen.value,alumno.value,nota.value,obs.value);
		}else{
			if(nota.value ===""){
				nota.className = "form-danger";
			}else{
				nota.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Observaciones(fila){
		alumno = document.getElementById("alumno"+fila).value;
		examen = document.getElementById("examen"+fila).value;
		if(alumno !== "" && examen !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/examen/observaciones.php",{examen:examen,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
			
		}
	}
	
	
	//////////////// ARCHIVOS DEL EXAMEN //////////////////////
	
	function NewFile(examen,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/examen/cargar_archivo_examen.php",{examen:examen,fila:fila}, function(data){
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
		examen = document.getElementById("Fileexamen");
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
				xajax_Grabar_Archivo(examen.value,nom.value,desc.value,inpextension.value);
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
	
	
	function Eliminar_Archivo(codigo,examen,archivo){
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
					xajax_Delete_Archivo(codigo,examen,archivo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function ReEnviarTodos(pensum,nivel,grado,seccion,tarea){
		swal({
			text: "\u00BFEsta seguro(a) de Reenviar este ex\u00E1men a todos los alumnos? si ya hay ex\u00E1menes calificados se reiniciar\u00E1n sus estatus...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Reenviar_Examen_Todos(pensum,nivel,grado,seccion,tarea);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function ReEnviarExamen(examen,alumno){
		swal({
			text: "\u00BFEsta seguro(a) de Reenviar este ex\u00E1men a este(a) alumno(a)? si ya ha sido calificado se reiniciar\u00E1 su estatus...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Reenviar_Examen_Alumno(examen,alumno);
					break;
				default:
				  return;
			}
		});
	}
 

	function showOption(sel){
		div = document.getElementById("field_wrapper");
		if(sel.value =="1" ){ 
			div.className = "";
		}else{
			div.className = "hidden";
		}
	}
	
	function addPregunta(){
		let respuestas = document.getElementById("respuestas");
		let contador = parseInt(respuestas.value);
		let wraper = document.getElementById("field_wrapper");
		let fieldHTML = '';
		fieldHTML+= '<div class="form-group">';
			fieldHTML+= '<div class="input-group">';
				fieldHTML+= '<input type="text" name="field_name[]" id="field_name_'+(contador + 1)+'" class="form-control" />';
				fieldHTML+= '<a href="javascript:void(0)" onclick = "removePregunta(this);" title = "Agregar Pregunta" class="input-group-addon addon-danger">';
				fieldHTML+= '<i class="fa fa-trash"></i>';
				fieldHTML+= '</a>';
			fieldHTML+= '</div>';
		fieldHTML+= '</div><br>';
		//---
		let contenedor = document.createElement("DIV");
		contenedor.innerHTML = fieldHTML;
		wraper.appendChild(contenedor);
		contador++;
		respuestas.value = contador;
	}
	
	
	function removePregunta(e){
		let respuestas = document.getElementById("respuestas");
		let contador = parseInt(respuestas.value);
		let wraper = document.getElementById("field_wrapper");
		if(contador > 1){
			e.parentNode.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode.parentNode);
			//e.parentNode.parentNode.removeChild(e.parentNode);
			contador--;
			respuestas.value = contador;
		}
	}
	
	function removeTabla(){
		elemento = document.getElementById("tabla");
		elemento.className = "hidden";
	}
	