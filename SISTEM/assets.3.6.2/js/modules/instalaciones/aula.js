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
						
	function Grabar(){
		sede = document.getElementById("sede");
		tipo = document.getElementById("tipo");
		desc = document.getElementById("desc");
		
		if(sede.value !=="" && tipo.value !=="" && desc.value !==""){
			abrir();
			xajax_Grabar_Aula(sede.value,tipo.value,desc.value);
			//botones
			gra = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(sede.value ===""){
				sede.className = " form-danger";
			}else{
				sede.className = " form-control";
			}
			if(tipo.value ===""){
				tipo.className = " form-danger";
			}else{
				tipo.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById('cod');
		sede = document.getElementById("sede");
		tipo = document.getElementById("tipo");
		desc = document.getElementById("desc");
		
		if(cod.value !=="" && sede.value !=="" && tipo.value !=="" && desc.value !==""){
			abrir();
			xajax_Modificar_Aula(cod.value,sede.value,tipo.value,desc.value);
			//botones
			gra = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(sede.value ===""){
				sede.className = " form-danger";
			}else{
				sede.className = " form-control";
			}
			if(tipo.value ===""){
				tipo.className = " form-danger";
			}else{
				tipo.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Aula(codigo){
		swal({
			text: "\u00BFEsta seguro de Deshabilitar esta Aula?, No podr\u00E1 ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Aula(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
		