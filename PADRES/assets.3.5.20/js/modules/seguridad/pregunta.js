//funciones javascript y validaciones
			
	function Limpiar(){
		texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
		acc = "location.reload();";
		ConfirmacionJs(texto,acc);
	}
	
	function aceptar(){
		tipo = document.getElementById("tipo");
		mail = document.getElementById("email");
		if(tipo.value !=="" && mail.value !== ""){
			myform = document.forms.f1;
			myform.action ="FRMpide_pass_response.php";
			myform.submit();
		}else{
			if(tipo.value ===""){
				tipo.className = " form-warning";
			}else{
				tipo.className = " form-control";
			}
			if(mail.value ===""){
				mail.className = " form-warning";
			}else{
				mail.className = " form-control";
			}
			swal("Ohoo!", "Por favor, llene los campos obligatorios...", "warning");
		}
	}
	
	function enviar(){
		mail = document.getElementById("email");
		nom = document.getElementById("name");
		phone = document.getElementById("phone");
		msj = document.getElementById("message");
		if(mail.value !== "" && nom.value !== "" && phone.value !== "" && msj.value !== ""){
			myform = document.forms.f1;
			myform.action ="FRMmail.php";
			myform.submit();
		}else{
			if(nom.value ===""){
				nom.className = " form-warning";
			}else{
				nom.className = " form-control";
			}
			if(mail.value ===""){
				mail.className = " form-warning";
			}else{
				mail.className = " form-control";
			}
			if(phone.value ===""){
				phone.className = " form-warning";
			}else{
				phone.className = " form-control";
			}
			if(msj.value ===""){
				msj.className = " form-warning";
			}else{
				msj.className = " form-control";
			}
			swal("Ohoo!", "Por favor, llene los campos obligatorios...", "warning");
		}
	}