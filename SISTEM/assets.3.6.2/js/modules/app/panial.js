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
	
//////////////////////// REPORTES DE PAÑAL ///////////////////////////////
	
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		alumno = document.getElementById("alumno");
		pipi = document.getElementById("pipi");
		popo = document.getElementById("popo");
		tipo = document.getElementById('tipo');
		obs = document.getElementById('obs');
		
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && seccion.value !=="" && alumno.value !== "" && pipi.value !==""  && popo.value !=="" && tipo.value !==""){
			xajax_Grabar_Panial(pensum.value,nivel.value,grado.value,seccion.value,alumno.value,pipi.value,popo.value,tipo.value,obs.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(alumno.value ===""){
				alumno.className = "form-danger";
			}else{
				alumno.className = "form-control";
			}
			if(pipi.value ===""){
				pipi.className = "form-danger";
			}else{
				pipi.className = "form-control";
			}
			if(popo.value ===""){
				popo.className = "form-danger";
			}else{
				popo.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		alumno = document.getElementById("alumno");
		tipo = document.getElementById('tipo');
		obs = document.getElementById('obs');
		popo = document.getElementById("popo");
		
		if(alumno.value !== "" && tipo.value !==""){
			xajax_Modificar_Panial(codigo.value,alumno.value,pipi.value,popo.value,tipo.value,obs.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			abrir();
			if(alumno.value ===""){
				alumno.className = "form-danger";
			}else{
				alumno.className = "form-control";
			}
			if(pipi.value ===""){
				pipi.className = "form-danger";
			}else{
				pipi.className = "form-control";
			}
			if(popo.value ===""){
				popo.className = "form-danger";
			}else{
				popo.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	
	function Confirm_Elimina_Panial(codigo){
		swal({
			title: "Confirmaci\u00F3n",
			text: "\u00BFEsta seguro de eliminar este reporte?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: "Aceptar"
			},
			dangerMode: false,
		}).then((willDelete) => {
			if(willDelete) {
				xajax_Eliminar_Panial(codigo);
			}
		});
	}
