//funciones javascript y validaciones
			
	//////////////////////////////////////////////////////
	
			function aceptar(){
				usu = document.getElementById('usu');
				pass1 = document.getElementById("pass1");
				pass2 = document.getElementById("pass2");
				nom = document.getElementById('nom');
				mail = document.getElementById('mail');
				tel = document.getElementById('tel');
				preg = document.getElementById("preg");
				resp = document.getElementById("resp");
				abrir();				
				if(nom.value !=="" && mail.value !=="" && tel.value !=="" && usu.value !=="" && pass1.value !== "" && pass2.value !== ""){
					if((preg.value !=="" && resp.value !== "") || (preg.value ==="" && resp.value === "")){
						if(pass1.value === pass2.value){
							document.forms["f1"].submit();
						}else{
								pass1.className = "form-danger";
								pass2.className = "form-danger";
								msj = '<h5>las contrase\u00F1as no son iguales...</h5><br><br>';
								msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
								document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
							preg.className = "form-danger";
							resp.className = "form-danger";
							msj = '<h5>Si usted selecciona la pregunta debe llenar la respuesta, o viceversa...</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
					}		
				}else{
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nomclassName = "form-control";
					}
					if(usu.value ===""){
						usu.className = "form-danger";
					}else{
						usuclassName = "form-control";
					}
					if(pass1.value ===""){
						pass1.className = "form-danger";
					}else{
						pass1className = "form-control";
					}
					if(pass2.value ===""){
						pass2.className = "form-danger";
					}else{
						pass2className = "form-control";
					}
					if(mail.value ===""){
						mail.className = "form-danger";
					}else{
						mailclassName = "form-control";
					}
					if(tel.value ===""){
						tel.className = "form-danger";
					}else{
						telclassName = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			