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
						
	
//////////////////////// TAREAS ///////////////////////////////
	
    function printTable(){
    	contenedor = document.getElementById("result");
    	curso = document.getElementById('curso');
		tema = document.getElementById('tema');
		maestro = document.getElementById("maestro");
    	loadingCogs(contenedor);
    	/////////// POST /////////
    	var http = new FormData();
    	http.append("request","tabla");
    	http.append("curso", curso.value);
    	http.append("tema", tema.value);
    	http.append("maestro", maestro.value);
    	var request = new XMLHttpRequest();
    	request.open("POST", "ajax_funct_lms.php");
    	request.send(http);
    	request.onreadystatechange = function(){
    		//console.log( request );
    		if(request.readyState != 4) return;
    		if(request.status === 200){
    			//console.log(request.responseText);
    			resultado = JSON.parse(request.responseText);
    			if(resultado.status !== true){
    				  //console.log( resultado );
    				  contenedor.innerHTML = '...';
    				  swal("Error", resultado.message , "error");
    				  return;
    			}
    			//tabla
    			var data = resultado.tabla;
    			contenedor.innerHTML = data;
    		}
    	};     
    }
	
	function Grabar(){
		curso = document.getElementById('curso');
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
		
		if(curso.value !=="" && tema.value !== "" && maestro.value !=="" && nom.value !=="" && desc.value !=="" && tipo.value !== "" && pondera.value !== "" && tipocalifica.value !== "" && fec.value !== "" && hor.value !== ""){
				/////////// POST /////////
        		var boton = document.getElementById('gra');
        		var http = new FormData();
        		http.append("request","grabarLmsTarea");
        		http.append("curso", curso.value);
        		http.append("tema", tema.value);
        		http.append("maestro", maestro.value);
        		http.append("nom", nom.value);
        		http.append("desc", desc.value);
        		http.append("tipo", tipo.value);
        		http.append("pondera", pondera.value);
        		http.append("tipocalifica", tipocalifica.value);
        		http.append("fec", fec.value);
        		http.append("hor", hor.value);
        		http.append("link", link.value);
        		var request = new XMLHttpRequest();
        		request.open("POST", "ajax_funct_lms.php");
        		request.send(http);
        		request.onreadystatechange = function(){
        		   //console.log( request );
        		   if(request.readyState != 4) return;
        		   if(request.status === 200){
        				resultado = JSON.parse(request.responseText);
        				if(resultado.status !== true){
        					swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar'); });
        					return;
        				}
        				//console.log( resultado );
        				swal("Excelente!", resultado.message, "success").then((value) => {
        				    	codigo.value = '';
            				    nom.value = '';
            					desc.value = '';
            					tipo.value = '';
            					pondera.value = '';
            					tipocalifica.value = '';
            					fec.value = '';
            					hor.value = '';
            					link.value = '';
        					deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar');
        					printTable('');
        				});
        			}
        		}; 
        	
			//botones
			//gra = document.getElementById("gra");
			//mod = document.getElementById("mod");
			//mod.className = 'btn btn-primary';
			//gra.className = 'btn btn-primary hidden';
		}else{
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
		codigo = document.getElementById('codigo');
		nom = document.getElementById('nom');
		desc = document.getElementById('desc');
		tipo = document.getElementById("tipo");
		pondera = document.getElementById("pondera");
		tipocalifica = document.getElementById("tipocalifica");
		fec = document.getElementById("fec");
		hor = document.getElementById("hor");
		link = document.getElementById("link");
		
		if(nom.value !=="" && desc.value !=="" && tipo.value !== "" && pondera.value !== "" && tipocalifica.value !== "" && fec.value !== "" && hor.value !== ""){
			/////////// POST /////////
        		var boton = document.getElementById('gra');
        		var http = new FormData();
        		http.append("request","editarLmsTarea");
        		http.append("codigo", codigo.value);
        		http.append("nom", nom.value);
        		http.append("desc", desc.value);
        		http.append("tipo", tipo.value);
        		http.append("pondera", pondera.value);
        		http.append("tipocalifica", tipocalifica.value);
        		http.append("fec", fec.value);
        		http.append("hor", hor.value);
        		http.append("link", link.value);
        		var request = new XMLHttpRequest();
        		request.open("POST", "ajax_funct_lms.php");
        		request.send(http);
        		request.onreadystatechange = function(){
        		   //console.log( request );
        		   if(request.readyState != 4) return;
        		   if(request.status === 200){
        				resultado = JSON.parse(request.responseText);
        				if(resultado.status !== true){
        					swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar'); });
        					return;
        				}
        				//console.log( resultado );
        				swal("Excelente!", resultado.message, "success").then((value) => {
        				    	codigo.value = '';
            				    nom.value = '';
            					desc.value = '';
            					tipo.value = '';
            					pondera.value = '';
            					tipocalifica.value = '';
            					fec.value = '';
            					hor.value = '';
            					link.value = '';
        					deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar');
        					printTable('');
        				});
        			}
        		}; 
        
			//botones
				document.getElementById("gra").focus(); 
			document.getElementById("mod").className = "btn btn-primary btn-sm hidden";
			document.getElementById("gra").className = "btn btn-primary btn-sm";
		}else{
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
	
	function Buscar_tarea(codigo){
	/////////// POST /////////
	var http = new FormData();
	http.append("request","buscarTarea");
	http.append("codigo",codigo);
	var request = new XMLHttpRequest();
	request.open("POST", "ajax_funct_lms.php");
	request.send(http);
	request.onreadystatechange = function(){
		//console.log( request );
		if(request.readyState != 4) return;
		if(request.status === 200){
			resultado = JSON.parse(request.responseText);
			if(resultado.status !== true){
				swal("Error", resultado.message , "error");
				return;
			}
			var data = resultado.data;
			//console.log( data );
			//set
			document.getElementById("nom").value = data.nombre;
			document.getElementById("curso").value = data.curso;
			document.getElementById("tema").value = data.tema;
			document.getElementById("maestro").value = data.maestro;
			document.getElementById("codigo").value = data.codigo;
			document.getElementById("tipo").value = data.tipo;
			document.getElementById("fec").value = data.fecha;
			document.getElementById("hor").value = data.hora;
			document.getElementById("link").value = data.link;
			document.getElementById("pondera").value = data.ponderacion;
			document.getElementById("tipocalifica").value = data.tipocalifica;
			document.getElementById("desc").value = data.desc;
			//tabla
			var tabla = resultado.tabla;
			contenedor.innerHTML = tabla;
			printTable(codigo);
			//botones
			document.getElementById("nom").focus(); 
			document.getElementById("gra").className = "btn btn-primary btn-sm hidden";
			document.getElementById("mod").className = "btn btn-primary btn-sm";
			//--
		}
	};     
}
	
	function GrabarCalificacion(){
		tarea = document.getElementById('tarea');
		alumno = document.getElementById("alumno");
		nota = document.getElementById('nota');
		obs = document.getElementById('obs');
		
		if(tarea.value !== "" && alumno.value !=="" && nota.value !==""){
			//alert(tarea.value+","+alumno.value+","+nota.value+","+obs.value+","+fila);
			xajax_Calificar_Tarea(tarea.value,alumno.value,nota.value,obs.value);
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
        				var boton = document.getElementById('gra');
                		var http = new FormData();
                		http.append("request","eliminarLmsTarea");
                		http.append("codigo", codigo);
                		var request = new XMLHttpRequest();
                		request.open("POST", "ajax_funct_lms.php");
                		request.send(http);
                		request.onreadystatechange = function(){
                		   //console.log( request );
                		   if(request.readyState != 4) return;
                		   if(request.status === 200){
                				resultado = JSON.parse(request.responseText);
                				if(resultado.status !== true){
                					swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar'); });
                					return;
                				}
                				//console.log( resultado );
                				swal("Excelente!", resultado.message, "success").then((value) => {
                					deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar');
                					printTable('');
                				});
                			}
                		}; 
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
			$.post("../promts/tareacursos/calificar.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
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
			$.post("../promts/tareacursos/modificar.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
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
			$.post("../promts/tareacursos/observaciones.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
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
			$.post("../promts/tareacursos/resolucion.php",{tarea:tarea,alumno:alumno,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
			
		}
	}
	
//////////////// ARCHIVOS DE TAREAS //////////////////////

	function NewFile(tarea,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/tareacursos/cargar_archivo_tarea.php",{tarea:tarea,fila:fila}, function(data){
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
		myform = document.forms.f1;
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
	
	
	function ReEnviarTodos(curso,tarea){
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
				    abrir()
                		var http = new FormData();
                		http.append("request","ReenviarLmsTareaTodos");
                		http.append("curso", curso);
                		http.append("tarea", tarea);
                		var request = new XMLHttpRequest();
                		request.open("POST", "ajax_funct_lms.php");
                		request.send(http);
                		request.onreadystatechange = function(){
                		   //console.log( request );
                		   if(request.readyState != 4) return;
                		   if(request.status === 200){
                				resultado = JSON.parse(request.responseText);
                				if(resultado.status !== true){
                					swal("Error", resultado.message , "error").then((value) => { 
                					   
                					});
                					return;
                				}
                				//console.log( resultado );
                				swal("Excelente!", resultado.message, "success").then((value) => {
                				     cerrar()
                				});
                			}
                		}; 
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
					abrir()
                		var http = new FormData();
                		http.append("request","ReenviarLmsTarea");
                		http.append("alumno", alumno);
                		http.append("tarea", tarea);
                		var request = new XMLHttpRequest();
                		request.open("POST", "ajax_funct_lms.php");
                		request.send(http);
                		request.onreadystatechange = function(){
                		   //console.log( request );
                		   if(request.readyState != 4) return;
                		   if(request.status === 200){
                				resultado = JSON.parse(request.responseText);
                				if(resultado.status !== true){
                					swal("Error", resultado.message , "error").then((value) => { 
                					   
                					});
                					return;
                				}
                				//console.log( resultado );
                				swal("Excelente!", resultado.message, "success").then((value) => {
                				     cerrar()
                				});
                			}
                		}; 
					break;
				default:
				  return;
			}
		});
	}
	

		