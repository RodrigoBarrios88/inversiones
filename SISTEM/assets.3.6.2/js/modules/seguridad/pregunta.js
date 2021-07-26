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
			/////////// POST /////////
			var boton = document.getElementById("btn-aceptar");
			loadingBtn(boton);
			var http = new FormData();
			http.append("request","mail");
			http.append("tipo", tipo.value);
			http.append("mail", mail.value);
			var request = new XMLHttpRequest();
			request.open("POST", "ajax_fns_usuario.php");
			request.send(http);
			request.onreadystatechange = function(){
			   //console.log( request );
			   if(request.readyState != 4) return;
			   if(request.status === 200){
				console.log( request.responseText );
				resultado = JSON.parse(request.responseText);
					if(resultado.status !== true){
						//console.log( resultado.data );
						swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fas fa-paper-plane"></i> Enviar'); });
						return;
					}
					//console.log( resultado );
					swal("Excelente!", resultado.message, "success").then((value) => {
						tipo.value = '';
						mail.value = '';
						deloadingBtn(boton,'<i class="fas fa-paper-plane"></i> Enviar');
					});
				}
			};      			
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
			/////////// POST /////////
			var boton = document.getElementById("btn-enviar");
			loadingBtn(boton);
			var http = new FormData();
			http.append("request","admin");
			http.append("email", mail.value);
			http.append("name", nom.value);
			http.append("phone", phone.value);
			http.append("message", msj.value);
			var request = new XMLHttpRequest();
			request.open("POST", "ajax_fns_usuario.php");
			request.send(http);
			request.onreadystatechange = function(){
			   //console.log( request );
			   if(request.readyState != 4) return;
			   if(request.status === 200){
				console.log( request.responseText );
				resultado = JSON.parse(request.responseText);
					if(resultado.status !== true){
						//console.log( resultado.data );
						swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fas fa-paper-plane"></i> Enviar'); });
						return;
					}
					//console.log( resultado );
					swal("Excelente!", resultado.message, "success").then((value) => {
						mail.value = '';
						nom.value = '';
						phone.value = '';
						msj.value = '';
						deloadingBtn(boton,'<i class="fas fa-paper-plane"></i> Enviar');
					});
				}
			};      		
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