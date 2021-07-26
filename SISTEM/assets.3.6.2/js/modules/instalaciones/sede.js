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
						
	function Grabar(){
		nom = document.getElementById("nom");
		dir = document.getElementById("dir");
		dep = document.getElementById("dep");
		mun = document.getElementById("mun");
		
		if(nom.value !=="" && dir.value !=="" && dep.value !=="" && mun.value !==""){
			abrir();
			xajax_Grabar_Sede(nom.value,dir.value,dep.value,mun.value);
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
			if(dir.value ===""){
				dir.className = " form-danger";
			}else{
				dir.className = " form-control";
			}
			if(dep.value ===""){
				dep.className = " form-danger";
			}else{
				dep.className = " form-control";
			}
			if(mun.value ===""){
				mun.className = " form-danger";
			}else{
				mun.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById('cod');
		dir = document.getElementById("dir");
		nom = document.getElementById("nom");
		dep = document.getElementById("dep");
		mun = document.getElementById("mun");
		
		if(cod.value !=="" && nom.value !=="" && dir.value !=="" && dep.value !=="" && mun.value !==""){
			abrir();
			xajax_Modificar_Sede(cod.value,nom.value,dir.value,dep.value,mun.value);
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
			if(dir.value ===""){
				dir.className = " form-danger";
			}else{
				dir.className = " form-control";
			}
			if(dep.value ===""){
				dep.className = " form-danger";
			}else{
				dep.className = " form-control";
			}
			if(mun.value ===""){
				mun.className = " form-danger";
			}else{
				mun.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Sede(codigo){
		swal({
			text: "\u00BFEsta seguro de Deshabilitar esta Sede?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Sede(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
		