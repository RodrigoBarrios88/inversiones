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
		usuario = document.getElementById('usuario');
		cui = document.getElementById('cui');
		nombre = document.getElementById('nombre');
		titulo = document.getElementById("titulo");
		mail = document.getElementById('mail');
		hini = document.getElementById("hini");
		hfin = document.getElementById("hfin");
		obs = document.getElementById("obs");
		
		if(usuario.value !=="" && cui.value !=="" && nombre.value !=="" && mail.value !== "" && titulo.value !== "" && hini.value !== "" && hfin.value !== "" && obs.value !== ""){
			abrir();
			xajax_Grabar_Usuario(usuario.value,cui.value,nombre.value,titulo.value,mail.value,hini.value,hfin.value,obs.value);
		}else{
			if(usuario.value ===""){
				usuario.className = "form-danger";
			}else{
				usuario.className = "form-control";
			}
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-control";
			}
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(mail.value ===""){
				mail.className = "form-danger text-libre";
			}else{
				mail.className = "form-control text-libre";
			}
			if(hini.value ===""){
				hini.className = "form-danger";
			}else{
				hini.className = "form-control";
			}
			if(hfin.value ===""){
				hfin.className = "form-danger";
			}else{
				hfin.className = "form-control";
			}
			if(obs.value ===""){
				obs.className = "form-danger";
			}else{
				obs.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		usuario = document.getElementById('usuario');
		cui = document.getElementById('cui');
		nombre = document.getElementById('nombre');
		titulo = document.getElementById("titulo");
		mail = document.getElementById('mail');
		hini = document.getElementById("hini");
		hfin = document.getElementById("hfin");
		obs = document.getElementById("obs");
		
		if(usuario.value !=="" && cui.value !=="" && nombre.value !=="" && mail.value !== "" && titulo.value !== "" && hini.value !== "" && hfin.value !== "" && obs.value !== ""){
			abrir();
			xajax_Modificar_Usuario(usuario.value,cui.value,nombre.value,titulo.value,mail.value,hini.value,hfin.value,obs.value);
		}else{
			if(usuario.value ===""){
				usuario.className = "form-danger";
			}else{
				usuario.className = "form-control";
			}
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-control";
			}
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(mail.value ===""){
				mail.className = "form-danger text-libre";
			}else{
				mail.className = "form-control text-libre";
			}
			if(hini.value ===""){
				hini.className = "form-danger";
			}else{
				hini.className = "form-control";
			}
			if(hfin.value ===""){
				hfin.className = "form-danger";
			}else{
				hfin.className = "form-control";
			}
			if(obs.value ===""){
				obs.className = "form-danger";
			}else{
				obs.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	

	function Deshabilita_Usuario(cui){
		swal({
			text: "\u00BFEsta seguro de Inhabilitar este(a) Usuario?, No podra ser visualizado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Usuario(cui,0);
					break;
				default:
					return;
			}
		});
	}
	
	
	function Habilita_Usuario(cui){
		swal({
			text: "\u00BFEsta seguro de Re-Activar este(a) Usuario?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Usuario(cui,1);
					break;
				default:
					return;
			}
		});
	}
	
	
	//////////////////////// ASIGNACION USUARIOS A EMPRESAS ////////////////////////////////////

	
	function Asigna_Grado_Usuario(arrcodigos){
		cui = document.getElementById("cui");
		//--
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		
		if(cui.value) {
			xajax_Graba_Usuario_Grado(cui.value,pensum.value,nivel.value,arrcodigos);
		}else{
			swal("Ohoo!", "Debe seleccionar almenos un (01) Usuario...", "error");
		}	
	}
	