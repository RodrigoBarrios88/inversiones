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
	
	function TipoTarget(){
		target = document.getElementById('target');
		tipo = document.getElementById('tipotarget');
		
		if(target.value === "SELECT"){
			tipo.removeAttribute("disabled");
			if(target.value !== "" && tipo.value !== ""){
				xajax_Target_Grupos(target.value,tipo.value);
			}
		}else{
			tipo.value = "0";
			tipo.setAttribute("disabled","disabled");
			xajax_Target_Grupos(target.value,tipo.value);
		}
	}
	
	function Grabar(){
		target = document.getElementById('target');
		tipo = document.getElementById('tipotarget');
		titulo = document.getElementById('titulo');
		destinatarios = document.getElementById('destinatarios');
		desc = document.getElementById("desc");
		feclimit = document.getElementById('feclimit');
		
		if(target.value !=="" && titulo.value !=="" && desc.value !== "" && feclimit.value !== "" && destinatarios.value !== ""){
			if (target.value === "SELECT") {
					var filas = parseInt(document.getElementById('gruposrows').value);
					var arrgrupos = Array([]);
					var cuantos = 1;
					for(i = 1; i <= filas; i++){
						chk = document.getElementById("grupos"+i);
						if(chk.checked) {
							arrgrupos[cuantos] = chk.value;
							cuantos++;
						}
					}
					cuantos--; //resta la ultima fila
					if(cuantos > 0) {
						abrir();
						xajax_Grabar_Encuesta(target.value,tipo.value,destinatarios.value,titulo.value,desc.value,feclimit.value,arrgrupos,cuantos);
					}else{
						swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
					}
			}else{
				var arrgrupos = Array([]);
				var cuantos = 0;
				xajax_Grabar_Encuesta(target.value,tipo.value,destinatarios.value,titulo.value,desc.value,feclimit.value,arrgrupos,cuantos);
			}
		}else{
			if(target.value ===""){
				target.className = "form-danger";
			}else{
				target.className = "form-control";
			}
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
			if(feclimit.value ===""){
				feclimit.className = "form-danger text-libre";
			}else{
				feclimit.className = "form-control text-libre";
			}
			if(destinatarios.value ===""){
				destinatarios.className = "form-danger text-libre";
			}else{
				destinatarios.className = "form-control text-libre";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		titulo = document.getElementById('titulo');
		desc = document.getElementById("desc");
		feclimit = document.getElementById('feclimit');
		destinatarios = document.getElementById('destinatarios');
		
		if(codigo.value !==""){
			if(titulo.value !=="" && desc.value !== "" && feclimit.value !== "" && destinatarios.value !== ""){
				abrir();
				xajax_Modificar_Encuesta(codigo.value,titulo.value,desc.value,feclimit.value,destinatarios.value);
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
				if(feclimit.value ===""){
					feclimit.className = "form-danger text-libre";
				}else{
					feclimit.className = "form-control text-libre";
				}
				if(destinatarios.value ===""){
					destinatarios.className = "form-danger text-libre";
				}else{
					destinatarios.className = "form-control text-libre";
				}
				swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			}
		}else{
			swal("Ups", "Si quiere crear una encuesta nueva esta en la pantalla equivocada, aqui solo puede actualizar las existentes...\n\nPara editar, seleccione la encuesta que quiere modificar y realice los cambios... ", "warning");
		}
	}
	
	function ModificarTarget(){
		myform = document.forms.f1;
		target = document.getElementById('target');
		tipo = document.getElementById('tipotarget');
		
		if(target.value !==""){
			if (target.value === "SELECT") {
					var filas = parseInt(document.getElementById('gruposrows').value);
					var arrgrupos = "";
					var cuantos = 0;
					//alert(filas);
					for(i = 1; i <= filas; i++){
						chk = document.getElementById("grupos"+i);
						if(chk.checked) {
							arrgrupos+= chk.value+"|";
							cuantos++;
						}
					}
					if(cuantos > 0) {
						document.getElementById('gruposrows').value = cuantos; //actualiza solo la cantidad de chequeados
						document.getElementById('chequeados').value = arrgrupos; //genera un string tipo array
						myform.action = "EXEmodtarget.php";
						Submit();
					}else{
						cerrar();
						swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
					}
			}else{
				myform.action = "EXEmodtarget.php";
				Submit();
			}
		}else{
			if(target.value ===""){
				target.className = "form-danger";
			}else{
				target.className = "form-control";
			}
			swal("Ups", "Debe llenar los Campos Obligatorios...", "error");
			
		}
	}
	
	
	function ConfirmEliminar(codigo){
		swal({
			title: "\u00BFEsta Seguro?",
			text: "\u00BFDesea Eliminar esta Encuesta? \n No podra ser contestada ni revisar sus resultados con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Encuesta(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function ConfirmCerrar(codigo){
		swal({
			title: "\u00BFEsta Seguro?",
			text: "\u00BFDesea Cerrar esta Encuesta? \n Ya no podra ser contestada con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Cerrar_Encuesta(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function ConfirmNotificar(codigo){
		swal({
			title: "\u00BFEsta Seguro?",
			text: "\u00BFDesea notificar esta encuesta? \n enviada la notificaci\u00F3n la recibir\u00E1n los usuarios..",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Publicar_Encuesta(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
//--------- PREGUNTAS ---------------//
	function GrabarPregunta(){
		encuesta = document.getElementById("encuesta");
		pregunta = document.getElementById("pregunta");
		tipo = document.getElementById("tipo");
		
		if(pregunta.value !=="" && tipo.value !==""){
			abrir();
			xajax_Grabar_Pregunta(encuesta.value,pregunta.value,tipo.value);
			//botones
			grab = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			grab.className = 'btn btn-primary hidden';
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
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarPregunta(){
		codigo = document.getElementById('codigo');
		encuesta = document.getElementById("encuesta");
		pregunta = document.getElementById("pregunta");
		tipo = document.getElementById("tipo");
		
		if(codigo.value !=="" && pregunta.value !=="" && tipo.value !==""){
			abrir();
			xajax_Modificar_Pregunta(codigo.value,encuesta.value,pregunta.value,tipo.value);
			//botones
			grab = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			grab.className = 'btn btn-primary hidden';
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
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Eliminar_Pregunta(codigo,encuesta){
		swal({
			text: "\u00BFDesea eliminar esta pregunta?, No podra ser visualizada con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Pregunta(codigo,encuesta);
					break;
				default:
				  return;
			}
		});
	}
	
	function Responder(encuesta,pregunta,persona,tipo,ponderacion,respuesta){
		swal({
			text: "\u00BFQuiere responder esta pregunta?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Grabar_Respuesta(encuesta,pregunta,persona,tipo,ponderacion,respuesta);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Notificar(codigo){
		if(codigo !== ""){
			xajax_Notificar_Encuesta(codigo);
		}
	}
	
	