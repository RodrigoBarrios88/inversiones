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
		grupo = document.getElementById("grupo");
		empresa = document.getElementById("empresa");
		nombre = document.getElementById("nombre");
		moneda = document.getElementById("moneda");
		
		if(grupo.value !=="" && nombre.value !=="" && empresa.value !=="" && moneda.value !==""){
			abrir();
			xajax_Grabar_Division(grupo.value,nombre.value,empresa.value,moneda.value);
		}else{
			if(grupo.value ===""){
				grupo.className = "form-danger";
			}else{
				grupo.className = "form-control";
			}
			if(empresa.value ===""){
				empresa.className = "form-danger";
			}else{
				empresa.className = "form-control";
			}
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			if(moneda.value ===""){
				moneda.className = "form-danger";
			}else{
				moneda.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");				
		}
	}
	
	function Modificar(){
		codigo = document.getElementById("codigo");
		grupo = document.getElementById("grupo");
		empresa = document.getElementById("empresa");
		nombre = document.getElementById("nombre");
		moneda = document.getElementById("moneda");
		
		if(codigo.value !=="" && grupo.value !=="" && nombre.value !=="" && empresa.value !=="" && moneda.value !==""){
			abrir();
			xajax_Modificar_Division(codigo.value,grupo.value,nombre.value,empresa.value,moneda.value);
			//botones
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
		}else{
			if(grupo.value ===""){
				grupo.className = "form-danger";
			}else{
				grupo.className = "form-control";
			}
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			if(empresa.value ===""){
				empresa.className = "form-danger";
			}else{
				empresa.className = "form-control";
			}
			if(moneda.value ===""){
				moneda.className = "form-danger";
			}else{
				moneda.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}


	function Deshabilita_Division(codigo,grupo){
		swal({
			text: "\u00BFEsta seguro de deshabilitar esta Divisi\u00F3n?, No podra ser usada con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Division(codigo,grupo,0);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}
	
	function Habilita_Division(codigo,grupo){
		swal({
			text: "\u00BFEsta seguro de habilitar esta Divisi\u00F3n?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Division(codigo,grupo,1);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}