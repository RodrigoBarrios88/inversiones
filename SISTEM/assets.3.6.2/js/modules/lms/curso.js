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
						
	function pageprint(){
		boton = document.getElementById("print");
		boton.className = "hidden";
		window.print();
		boton.className = "btn btn-default";
	}
				
	function Grabar(){
		nom = document.getElementById("nom");
		desc = document.getElementById("desc");
		clase = document.getElementById("clase");
		sede = document.getElementById("sede");
		cupo = document.getElementById("cupo");
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(nom.value !=="" && desc.value !=="" && clase.value !=="" && sede.value !=="" && cupo.value !=="" && fini.value !=="" && ffin.value !==""){
			abrir();
			xajax_Grabar_Curso(nom.value,desc.value,clase.value,sede.value,cupo.value,fini.value,ffin.value);
			//botones
			gra = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(clase.value ===""){
				clase.className = " form-danger";
			}else{
				clase.className = " form-control";
			}
			if(sede.value ===""){
				sede.className = " form-danger";
			}else{
				sede.className = " form-control";
			}
			if(cupo.value ===""){
				cupo.className = " form-danger";
			}else{
				cupo.className = " form-control";
			}
			if(fini.value ===""){
				fini.className = " form-danger";
			}else{
				fini.className = " form-control";
			}
			if(ffin.value ===""){
				ffin.className = " form-danger";
			}else{
				ffin.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById("cod");
		nom = document.getElementById("nom");
		desc = document.getElementById("desc");
		clase = document.getElementById("clase");
		sede = document.getElementById("sede");
		cupo = document.getElementById("cupo");
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(cod.value !=="" && nom.value !=="" && desc.value !=="" && clase.value !=="" && sede.value !=="" && cupo.value !=="" && fini.value !=="" && ffin.value !==""){
			abrir();
			xajax_Modificar_Curso(cod.value,nom.value,desc.value,clase.value,sede.value,cupo.value,fini.value,ffin.value);
			//botones
			gra = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(clase.value ===""){
				clase.className = " form-danger";
			}else{
				clase.className = " form-control";
			}
			if(sede.value ===""){
				sede.className = " form-danger";
			}else{
				sede.className = " form-control";
			}
			if(cupo.value ===""){
				cupo.className = " form-danger";
			}else{
				cupo.className = " form-control";
			}
			if(fini.value ===""){
				fini.className = " form-danger";
			}else{
				fini.className = " form-control";
			}
			if(ffin.value ===""){
				ffin.className = " form-danger";
			}else{
				ffin.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Curso(cod){
		swal({
			text: "\u00BFEsta seguro de Deshabilitar esta Curso?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Curso(cod);
					break;
				default:
				  return;
			}
		});
	}
	

		