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
				
	
//////////////////////// MULTIMEDIA ///////////////////////////////
	
	function Grabar(){
		titulo = document.getElementById('titulo');
		link = document.getElementById('link');
		tipo = document.getElementById("tipo");
		categoria = document.getElementById("categoria");
		
		if(titulo.value !=="" && link.value !== "" && tipo.value !== "" && categoria.value !==""){
			abrir();
			xajax_Grabar_Multimedia(titulo.value,link.value,tipo.value,categoria.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(link.value ===""){
				link.className = "form-danger";
			}else{
				link.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(categoria.value ===""){
				categoria.className = "form-danger";
			}else{
				categoria.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	function Modificar(){
		codigo = document.getElementById('codigo');
		titulo = document.getElementById('titulo');
		link = document.getElementById('link');
		tipo = document.getElementById("tipo");
		categoria = document.getElementById("categoria");
		
		if(titulo.value !== "" && link.value !=="" && tipo.value !==""){
			abrir();
			xajax_Modificar_Multimedia(codigo.value,titulo.value,link.value,tipo.value,categoria.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(link.value ===""){
				link.className = "form-danger";
			}else{
				link.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(categoria.value ===""){
				categoria.className = "form-danger";
			}else{
				categoria.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
		}
	}
	
	
	function Confirm_Eliminar_Multimedia(codigo){
		swal({
			title: "\u00BFEsta Seguro?",
			text: "\u00BFDesea quitar este video del listado?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Eliminar_Multimedia(codigo);
					break;
				default:
					return;
			}
		});
	}
	

