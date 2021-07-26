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
		modulo = document.getElementById("modulo");
		plataforma = document.getElementById("plataforma");
		tipo = document.getElementById("tipo");
		prioridad = document.getElementById("prioridad");
		persona = document.getElementById("persona");
		desc = document.getElementById("desc");
		
		if(modulo.value !=="" && plataforma.value !=="" && tipo.value !=="" && prioridad.value !=="" && desc.value !==""){
			abrir();
			xajax_Grabar_Incidente(modulo.value,plataforma.value,tipo.value,persona.value,desc.value,prioridad.value);
		}else{
			if(modulo.value ===""){
				modulo.className = "form-danger";
			}else{
				modulo.className = "form-control";
			}
			if(plataforma.value ===""){
				plataforma.className = "form-danger";
			}else{
				plataforma.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(prioridad.value ===""){
				prioridad.className = "form-danger";
			}else{
				prioridad.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById("cod");
		modulo = document.getElementById("modulo");
		plataforma = document.getElementById("plataforma");
		tipo = document.getElementById("tipo");
		prioridad = document.getElementById("prioridad");
		persona = document.getElementById("persona");
		desc = document.getElementById("desc");
		
		if(modulo.value !=="" && plataforma.value !=="" && tipo.value !=="" && prioridad.value !=="" && desc.value !==""){
			abrir();
			xajax_Modificar_Incidente(cod.value,modulo.value,plataforma.value,tipo.value,persona.value,desc.value,prioridad.value);
		}else{
			if(modulo.value ===""){
				modulo.className = "form-danger";
			}else{
				modulo.className = "form-control";
			}
			if(plataforma.value ===""){
				plataforma.className = "form-danger";
			}else{
				plataforma.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(prioridad.value ===""){
				prioridad.className = "form-danger";
			}else{
				prioridad.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Informacion(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/helpdesk/informacion.php",{codigo:codigo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function Eliminacion(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/helpdesk/eliminar.php",{codigo:codigo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function Situacion(codigo,situacion){
		obs = document.getElementById("obs");
		xajax_Situacion_Incidente(codigo,obs.value,situacion);
	}

	
	function Eliminar_Incidente(codigo){
		obs = document.getElementById("obs");
		if(obs.value !== ""){
			swal({
				text: "\u00BFEsta seguro de cancelar este Incidente?, No podra ser tramitado con esta situaci\u00F3n...",
				icon: "warning",
				buttons: {
					cancel: "Cancelar",
					ok: { text: "Aceptar", value: true},
				}
			}).then((value) => {
				switch (value) {
					case true:
						abrir();
						xajax_Situacion_Incidente(codigo,obs.value,10);
						break;
					default:
						return;
					  //swal("", "Acci\u00F3n Cancelada...", "info");
				}
			});
		}else{
			obs.className = "form-danger";
			swal("Ohoo!", "La justificaci\u00F3n es obligatoria...", "error");
		}
	}

	
