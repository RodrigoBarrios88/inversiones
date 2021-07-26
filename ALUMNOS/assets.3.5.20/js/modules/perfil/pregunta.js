//funciones javascript y validaciones
			
	function Limpiar(){
		texto = "¿Desea Limpiar la Pagina?, perdera los datos escritos...";
		acc = "location.reload();";
		ConfirmacionJs(texto,acc);
	}
			
	function BuscaPregunta(){
		abrir();
		mail = document.getElementById("email");
		if(mail.value != ""){
			xajax_Buscar_Pregunta_C(mail.value);
		}else{
			if(mail.value ==""){
				mail.className = " form-danger";
			}else{
				mail.className = " form-control";
			}
			msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
			msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
			document.getElementById('lblparrafo').innerHTML = msj;
		}
	}
	
	function aceptar(){
		abrir();
		id = document.getElementById("cod");
		usu = document.getElementById("usu");
		mail = document.getElementById("email");
		preg = document.getElementById("preg");
		resp = document.getElementById("resp");
		if(id.value !="" && mail.value != "" && preg.value != "" && resp.value != ""){
			myform = document.forms.f1;
			myform.action ="FRMpide_pass_response.php";
			myform.submit();
		}else{
			if(preg.value ==""){
				preg.className = " form-danger";
			}else{
				preg.className = " form-control";
			}
			if(resp.value ==""){
				resp.className = " form-danger";
			}else{
				resp.className = " form-control";
			}
			if(mail.value ==""){
				mail.className = " form-danger";
			}else{
				mail.className = " form-control";
			}
			msj = '<span>Debe llenar los campos obligatorios...</span><br><br>';
			msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar()" />';
			document.getElementById('lblparrafo').innerHTML = msj;
		}
	}
