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
		nombre = document.getElementById("nombre");
		if(nombre.value !==""){
			abrir();
			xajax_Grabar_Grupo(nombre.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById("codigo");
		nombre = document.getElementById("nombre");
		if(codigo.value !=="" && nombre.value !==""){
			abrir();
			xajax_Modificar_Grupo(codigo.value,nombre.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Deshabilita_Grupo(codigo){
		swal({
			text: "\u00BFEsta seguro de deshabilitar este Grupo?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Grupo(codigo,0);
					break;
				default:
				  return;
			}
		});
	}
	
	function Habilita_Grupo(codigo){
		swal({
			text: "\u00BFEsta seguro de habilitar este Grupo?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Grupo(codigo,1);
					break;
				default:
					return;
			}
		});
	}
	