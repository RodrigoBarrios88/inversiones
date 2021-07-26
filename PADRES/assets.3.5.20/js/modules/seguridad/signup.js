//funciones javascript y validaciones
			
	///////// Validacion /////////////
	
	function Buscar_CUI(cui){
		
		if(cui.value !== ""){
			xajax_Buscar_CUI(cui.value);
		}
	}
	
	///////// Sign UP /////////////
	
	function Actualizar(){
		abrir();
		cod = document.getElementById('cod');
		cui = document.getElementById('cui');
		mail = document.getElementById("mail");
						
		if(cod.value !== "" && cui.value !== "" && mail.value !== "" ){
			document.getElementById('mod').setAttribute("disabled","disabled");
			xajax_Actualizar(cod.value,cui.value,mail.value);
		}else{
			if(nom.value === ""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(mail.value === ""){
				mail.className = " form-danger";
			}else{
				mail.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
		
	function NewUser(){
		abrir();
		dpi = document.getElementById('cui');
		nom = document.getElementById("nom");
		ape = document.getElementById("ape");
		mail = document.getElementById("mail");
							
		if(dpi.value !== "" && mail.value !== "" && nom.value !== "" && ape.value !== "" ){
			document.getElementById('new').setAttribute("disabled","disabled");
			xajax_Nuevo_Usuario(dpi.value,nom.value,ape.value,mail.value);
		}else{
			if(dpi.value === ""){
				dpi.className = " form-danger";
			}else{
				dpi.className = " form-control";
			}
			if(nom.value === ""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(ape.value === ""){
				ape.className = " form-danger";
			}else{
				ape.className = " form-control";
			}
			if(mail.value === ""){
				mail.className = " form-danger";
			}else{
				mail.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
		