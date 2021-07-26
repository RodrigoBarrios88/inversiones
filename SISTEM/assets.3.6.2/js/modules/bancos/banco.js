//funciones javascript y validaciones
	function Set_Pais(valor){
		pai = document.getElementById('pai');
		pai.value = valor;
	}
	
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
		dct = document.getElementById("dct");
		dlg = document.getElementById("dlg");
		pai = document.getElementById("pai");
		
		if(dct.value !=="" && dlg.value !=="" && pai.value !==""){
			abrir();
			xajax_Grabar_Banco(dct.value,dlg.value,pai.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(dct.value ===""){
				dct.className = "form-danger";
			}else{
				dct.className = "form-control";
			}
			if(dlg.value ===""){
				dlg.className = "form-danger";
			}else{
				dlg.className = "form-control";
			}
			if(pai.value ===""){
				pai.className = "form-danger";
			}else{
				pai.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById("cod");
		dct = document.getElementById("dct");
		dlg = document.getElementById("dlg");
		pai = document.getElementById("pai");
		
		if(cod.value !=="" && dct.value !=="" && dlg.value !=="" && pai.value !==""){
			abrir();
			xajax_Modificar_Banco(cod.value,dct.value,dlg.value,pai.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(dct.value ===""){
				dct.className = "form-danger";
			}else{
				dct.className = "form-control";
			}
			if(dlg.value ===""){
				dlg.className = "form-danger";
			}else{
				dlg.className = "form-control";
			}
			if(pai.value ===""){
				pai.className = "form-danger";
			}else{
				pai.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}


	function Limpia_campos(){
		//limpia campos
		document.getElementById('cod').value = "";
		document.getElementById('dct').value = "";
		document.getElementById('dlg').value = "";
		document.getElementById('pai').value = "502";
		document.getElementById("sit").value = "";
	}	
	
	
	function Deshabilita_Banco(codigo){
		swal({
			text: "\u00BFEsta seguro de deshabilitar este Banco?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Banco(codigo,0);
					break;
				default:
				  return;
			}
		});
	}
	
	function Habilita_Banco(codigo){
		swal({
			text: "\u00BFEsta seguro de habilitar este Banco?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Banco(codigo,1);
					break;
				default:
					return;
			}
		});
	}
	
