//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
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
						
			
		//////////////////////// TAREAS ///////////////////////////////
			
			function Grabar(){
				user_id = document.getElementById('user_id');
				device_id = document.getElementById('device_id');
				device_token = document.getElementById("device_token");
				device_type = document.getElementById("device_type");
				certificate_type = document.getElementById("certificate_type");
				status = document.getElementById("status");
				created_at = document.getElementById("created_at");
				updated_at = document.getElementById('updated_at');
				
				if(user_id.value !=="" && device_id.value !== "" && device_token.value !== "" && certificate_type.value !== "" && device_type.value !=="" && status.value !=="" && created_at.value !=="" && updated_at.value !==""){
					abrir();
					xajax_Grabar_Push(user_id.value,device_id.value,device_token.value,device_type.value,certificate_type.value,status.value,created_at.value,updated_at.value);
				}else{
					if(user_id.value ===""){
						user_id.className = "form-danger";
					}else{
						user_id.className = "form-control";
					}
					if(device_id.value ===""){
						device_id.className = "form-danger";
					}else{
						device_id.className = "form-control";
					}
					if(device_token.value ===""){
						device_token.className = "form-danger";
					}else{
						device_token.className = "form-control";
					}
					if(certificate_type.value ===""){
						certificate_type.className = "form-danger";
					}else{
						certificate_type.className = "form-control";
					}
					if(device_type.value ===""){
						device_type.className = "form-danger";
					}else{
						device_type.className = "form-control";
					}
					if(status.value ===""){
						status.className = "form-danger";
					}else{
						status.className = "form-control";
					}
					if(created_at.value ===""){
						created_at.className = "form-danger";
					}else{
						created_at.className = "form-control";
					}
					if(updated_at.value ===""){
						updated_at.className = "form-danger";
					}else{
						updated_at.className = "form-control";
					}
					swal('Error', 'Debe llenar los Campos Obligatorios...', 'warning');	
				}
			}		
			
			function DeletePush(user_id,device_id){
				swal({
					title: "\u00BFEsta Seguro?",
					text: "\u00BFDesea realmente eliminar Usuario de Pushups?, una vez realizada esta acci\u00F3n no podr\u00E1 ser usada de nuevo...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: {
						  text: "Aceptar",
						  value: true,
						},
					},
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Eliminar_Push(user_id,device_id);
							break;
				   
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
