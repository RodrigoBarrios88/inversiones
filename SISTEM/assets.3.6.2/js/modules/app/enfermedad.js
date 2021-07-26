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
				
	
//////////////////////// REPORTE DE ENFERMEDAD ///////////////////////////////
	
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		alumno = document.getElementById("alumno");
		sintomas = document.getElementById("sintomas");
		hora = document.getElementById("hora");
		aviso = document.getElementById('aviso');
		medida = document.getElementById('medida');
		dosis = document.getElementById('dosis');
		texto = document.getElementById('texto');
		
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && seccion.value !=="" && alumno.value !== "" && sintomas.value !==""  && hora.value !=="" && aviso.value !=="" && medida.value !==""){
			xajax_Grabar_Enfermedad(pensum.value,nivel.value,grado.value,seccion.value,alumno.value,sintomas.value,hora.value,aviso.value,medida.value,dosis.value,texto.value);
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
			if(sintomas.value ===""){
				sintomas.className = "form-danger";
			}else{
				sintomas.className = "form-control";
			}
			if(hora.value ===""){
				hora.className = "form-danger";
			}else{
				hora.className = "form-control";
			}
			if(aviso.value ===""){
				aviso.className = "form-danger";
			}else{
				aviso.className = "form-control";
			}
			if(medida.value ===""){
				medida.className = "form-danger";
			}else{
				medida.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		alumno = document.getElementById("alumno");
		aviso = document.getElementById('aviso');
		medida = document.getElementById('medida');
		hora = document.getElementById("hora");
		dosis = document.getElementById('dosis');
		
		if(alumno.value !== "" && sintomas.value !==""  && hora.value !=="" && aviso.value !=="" && medida.value !==""){
			xajax_Modificar_Enfermedad(codigo.value,alumno.value,sintomas.value,hora.value,aviso.value,medida.value,dosis.value);
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
			if(sintomas.value ===""){
				sintomas.className = "form-danger";
			}else{
				sintomas.className = "form-control";
			}
			if(hora.value ===""){
				hora.className = "form-danger";
			}else{
				hora.className = "form-control";
			}
			if(aviso.value ===""){
				aviso.className = "form-danger";
			}else{
				aviso.className = "form-control";
			}
			if(medida.value ===""){
				medida.className = "form-danger";
			}else{
				medida.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	
	function Confirm_Elimina_Enfermedad(codigo){
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
				xajax_Eliminar_Enfermedad(codigo);
			}
		});
	}
