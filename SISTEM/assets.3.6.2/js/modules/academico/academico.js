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
				
	
	//////////////////////// NIVELES ///////////////////////////////	
	
	function GrabarNivel(){
		pensum = document.getElementById('pensum');
		desc = document.getElementById('desc');
		
		if(desc.value !=="" && pensum.value !==""){
			abrir();
			xajax_Grabar_Nivel(pensum.value,desc.value);
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
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarNivel(){
		pensum = document.getElementById('pensum');
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		
		if(desc.value !=="" && pensum.value !==""){
			abrir();
			xajax_Modificar_Nivel(pensum.value,cod.value,desc.value);
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
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Confirm_Elimina_Nivel(pensum,codigo){
		swal({
			title: "\u00BFDeshabilitar Nivel?",
			text: "\u00BFEsta seguro de deshabilitar este Nivel con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_CambiaSit_Nivel(pensum,codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	//////////////////////// GRADOS ///////////////////////////////
	
	function Combo_Nivel_Grado(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !==""){
			xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"");
		}
	}
	
	function GrabarGrado(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		desc = document.getElementById('desc');
		
		if(desc.value !=="" && pensum.value !=="" && nivel.value !==""){
			abrir();
			xajax_Grabar_Grado(pensum.value,nivel.value,desc.value);
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
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarGrado(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		
		if(desc.value !=="" && pensum.value !=="" && nivel.value !==""){
			abrir();
			xajax_Modificar_Grado(pensum.value,nivel.value,cod.value,desc.value);
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
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Confirm_Elimina_Grado(pensum,nivel,codigo){
		swal({
			title: "\u00BFDeshabilitar Grado?",
			text: "\u00BFEsta seguro de deshabilitar este Grado con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_CambiaSit_Grado(pensum,nivel,codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	//////////////////////// SECCIONES ///////////////////////////////	
	
	function GrabarSeccion(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		desc = document.getElementById('desc');
		tipo = document.getElementById("tipo");
		
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && desc.value !=="" && tipo.value !==""){
			abrir();
			xajax_Grabar_Seccion(pensum.value,nivel.value,grado.value,tipo.value,desc.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				grado.className = "form-danger";
			}else{
				grado.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarSeccion(){
		
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		desc = document.getElementById('desc');
		tipo = document.getElementById("tipo");
		
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && desc.value !=="" && tipo.value !==""){
			abrir();
			xajax_Modificar_Seccion(pensum.value,nivel.value,grado.value,cod.value,tipo.value,desc.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary';
		}else{
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				grado.className = "form-danger";
			}else{
				grado.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Confirm_Elimina_Seccion(pensum,nivel,grado,codigo){
		swal({
			title: "\u00BFDeshabilitar Secci\u00F3n?",
			text: "\u00BFEsta seguro de deshabilitar esta Secci\u00F3n con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_CambiaSit_Seccion(pensum,nivel,grado,codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	//////////////////////// ASIGNACION DE GRADOS ///////////////////////////////
	
	function Tabla_Asignacion_Grado(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !=="" && nivel.value !==""){
			abrir();
			myform = document.forms.f1;
			myform.action ="FRMasiggrado.php";
			myform.submit();
		}
	}
	
	function Asignar_Grado(fila){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado"+fila);
		codigo = document.getElementById("codigo"+fila);
		alumno = document.getElementById("alumno"+fila);
		spancheck = document.getElementById("spancheck"+fila);
		spancheck.title = "Transaccion en proceso...";
		spancheck.className = 'btn btn-warning btn-xs';
		spancheck.innerHTML = '<span class="glyphicon glyphicon-hourglass"></span>';
		
		if(pensum.value !=="" && nivel.value !=="" && alumno.value !==""){
			if(grado.value !==""){
				xajax_Grabar_Grado_Alumno(pensum.value,nivel.value,grado.value,alumno.value,fila);
			}else{
				//alert("elimina");
				xajax_Eliminar_Grado_Alumno(pensum.value,nivel.value,alumno.value,fila);
			}
		}else{
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				grado.className = "form-danger";
			}else{
				grado.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	
	
	//////////////////////// ASIGNACION DE SECCIONES ///////////////////////////////
	
	function Combo_Nivel_Grado_Seccion(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !==""){
			xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Tabla_Asignacion_Seccion();");
		}
	}
	
	function Tabla_Asignacion_Seccion(){
		//alert("entro");
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		tipo = document.getElementById("tipo");
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && tipo.value !==""){
			abrir();
			myform = document.forms.f1;
			myform.action ="FRMasigseccion.php";
			myform.submit();
		}
	}
	
	function Asignar_Seccion(fila){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion"+fila);
		alumno = document.getElementById("alumno"+fila);
		spancheck = document.getElementById("spancheck"+fila);
		spancheck.title = "Transaccion en proceso...";
		spancheck.className = 'btn btn-warning btn-xs';
		spancheck.innerHTML = '<span class="glyphicon glyphicon-hourglass"></span>';
		
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && alumno.value !==""){
			if(seccion.value !==""){
				xajax_Grabar_Seccion_Alumno(pensum.value,nivel.value,grado.value,seccion.value,alumno.value,fila);
			}else{
				xajax_Eliminar_Seccion_Alumno(pensum.value,nivel.value,grado.value,alumno.value,fila);
			}
		}else{
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				grado.className = "form-danger";
			}else{
				grado.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
