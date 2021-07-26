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
				
	//////////////////////// PERIODO FISCAL ///////////////////////////////
	function GrabarPeriodo(){
		desc = document.getElementById('desc');
		anio = document.getElementById("anio");
		
		if(desc.value !=="" && anio.value !==""){
			abrir();
			xajax_Grabar_Periodo(desc.value,anio.value);
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
	
	function ModificarPeriodo(){
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		anio = document.getElementById("anio");
		
		if(desc.value !=="" && anio.value !==""){
			abrir();
			xajax_Modificar_Periodo(cod.value,desc.value,anio.value);
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
   
   function activacionPeriodo(codigo){
      swal({
			title: "\u00BFActivar Periodo?",
			text: "\u00BFEsta seguro de activar este Periodo? Se establecera como principal y se desactivaran todos los demas...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Status_Periodo(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	function Confirm_Elimina_Periodo(codigo){
		swal({
			title: "\u00BFDeshabilitar Periodo Fiscal?",
			text: "\u00BFEsta seguro de deshabilitar este periodo fiscal con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_CambiaSit_Periodo(codigo);
					break;
				default:
				  return;
			}
		});
	}