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
				
	//////////////////////// PENSUMS ///////////////////////////////
	
	function Confirm_Importar_Pensum(){
		swal({
			title: "Importar Pensum",
			text: "\u00BFEsta seguro de importar esta estructura curricular en un nuevo pensum?, desabilitara las anteriores usadas...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					ImportarPensum();
					break;
				default:
				  return;
			}
		});
	}
	
	function ImportarPensum(){
		pensum = document.getElementById('pensum');
		desc = document.getElementById('desc');
		anio = document.getElementById("anio");
		
		if(pensum.value !== "" && desc.value !== "" && anio.value !== ""){
			abrir();
			xajax_Importar_Pensum(pensum.value,desc.value,anio.value);
		}else{
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(anio.value ===""){
				anio.className = "form-danger";
			}else{
				anio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function GrabarPensum(){
		desc = document.getElementById('desc');
		anio = document.getElementById("anio");
		
		if(desc.value !=="" && anio.value !==""){
			abrir();
			xajax_Grabar_Pensum(desc.value,anio.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(anio.value ===""){
				anio.className = "form-danger";
			}else{
				anio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarPensum(){
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		anio = document.getElementById("anio");
		
		if(desc.value !=="" && anio.value !==""){
			abrir();
			xajax_Modificar_Pensum(cod.value,desc.value,anio.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary';
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(anio.value ===""){
				anio.className = "form-danger";
			}else{
				anio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
   
   function activacionPensum(codigo){
      swal({
			title: "\u00BFActivar Pensum?",
			text: "\u00BFEsta seguro de activar este Pensum? Se establecera como principal y se desactivaran todos los demas...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Status_Pensum(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	function Confirm_Elimina_Pensum(codigo){
		swal({
			title: "\u00BFDeshabilitar Pensum?",
			text: "\u00BFEsta seguro de deshabilitar este Pensum con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_CambiaSit_Pensum(codigo);
					break;
				default:
				  return;
			}
		});
	}