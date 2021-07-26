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
								
	
//////////////////////// REPORTE DE GOLPE ///////////////////////////////
	
	function Grabar(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		alumno = document.getElementById("alumno");
		lugar = document.getElementById("lugar");
		hora = document.getElementById("hora");
		desc = document.getElementById('desc');
		medida = document.getElementById('medida');
		dosis = document.getElementById('dosis');
		texto = document.getElementById('texto');
		
		if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && seccion.value !=="" && alumno.value !== "" && lugar.value !==""  && hora.value !=="" && desc.value !=="" && medida.value !==""){
			xajax_Grabar_Golpe(pensum.value,nivel.value,grado.value,seccion.value,alumno.value,lugar.value,hora.value,desc.value,medida.value,dosis.value,texto.value);
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
			if(lugar.value ===""){
				lugar.className = "form-danger";
			}else{
				lugar.className = "form-control";
			}
			if(hora.value ===""){
				hora.className = "form-danger";
			}else{
				hora.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
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
		desc = document.getElementById('desc');
		medida = document.getElementById('medida');
		hora = document.getElementById("hora");
		dosis = document.getElementById('dosis');
		
		if(alumno.value !== "" && lugar.value !==""  && hora.value !=="" && desc.value !=="" && medida.value !==""){
			xajax_Modificar_Golpe(codigo.value,alumno.value,lugar.value,hora.value,desc.value,medida.value,dosis.value);
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
			if(lugar.value ===""){
				lugar.className = "form-danger";
			}else{
				lugar.className = "form-control";
			}
			if(hora.value ===""){
				hora.className = "form-danger";
			}else{
				hora.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(medida.value ===""){
				medida.className = "form-danger";
			}else{
				medida.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	
	function Confirm_Elimina_Golpe(codigo){
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
				xajax_Eliminar_Golpe(codigo);
			}
		});
	}
