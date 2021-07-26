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
						
	
	//////////////////////// CONDUCTA ///////////////////////////////
	
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		alumno = document.getElementById("alumno");
		obs = document.getElementById('obs');
		//-- radiobutton
		var conducta = 0;
		var conducta1 = document.getElementById("conducta1");
		var conducta2 = document.getElementById("conducta2");
		var conducta3 = document.getElementById("conducta3");
		var conducta4 = document.getElementById("conducta4");
		if(conducta1.checked){
			conducta = 1;
		}else if(conducta2.checked){
			conducta = 2;
		}else if(conducta3.checked){
			conducta = 3;
		}else if(conducta4.checked){
			conducta = 4;
		}else{
			conducta = 0;
		}
		//--
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && seccion.value !=="" && alumno.value !== ""){
			if(conducta !== 0){
				abrir();
				xajax_Grabar_Conducta(pensum.value,nivel.value,grado.value,seccion.value,alumno.value,conducta,obs.value);
				//botones
				gra = document.getElementById("gra");
				mod = document.getElementById("mod");
				mod.className = 'btn btn-primary hidden';
				gra.className = 'btn btn-primary hidden';
			}else{
				swal("Alto", "Seleccione una calificaci\u00F3n de conducta...", "warning");
			}
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
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		alumno = document.getElementById("alumno");
		obs = document.getElementById('obs');
		//-- radiobutton
		var conducta = 0;
		var conducta1 = document.getElementById("conducta1");
		var conducta2 = document.getElementById("conducta2");
		var conducta3 = document.getElementById("conducta3");
		var conducta4 = document.getElementById("conducta4");
		if(conducta1.checked){
			conducta = 1;
		}else if(conducta2.checked){
			conducta = 2;
		}else if(conducta3.checked){
			conducta = 3;
		}else if(conducta4.checked){
			conducta = 4;
		}else{
			conducta = 0;
		}
		//--
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && seccion.value !=="" && alumno.value !== ""){
			if(conducta !== 0){
				abrir();
				xajax_Modificar_Conducta(codigo.value,alumno.value,conducta,obs.value);
				//botones
				gra = document.getElementById("gra");
				mod = document.getElementById("mod");
				mod.className = 'btn btn-primary hidden';
				gra.className = 'btn btn-primary hidden';
			}else{
				swal("Alto", "Seleccione una calificaci\u00F3n de conducta...", "warning");
			}
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

	
	function Confirm_Elimina_Conducta(codigo){
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
				xajax_Eliminar_Conducta(codigo);
			}
		});
	}
