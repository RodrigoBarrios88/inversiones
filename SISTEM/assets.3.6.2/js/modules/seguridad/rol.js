//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Submit(tipo){
				myform = document.forms.f1;
				if(tipo === 1){
					myform.action ="REProles.php";
				}else if(tipo === 2){
					myform.action ="REProlesexe.php";
				}
				myform.submit();
			}
								
			function pageprint(){
				boton = document.getElementById("print");
				boton.className = "hidden";
				window.print();
				boton.className = "btn btn-default";
			}
						
			function Grabar(){
				abrir();
				nom = document.getElementById('nom');
				desc = document.getElementById('desc');
				cant = document.getElementById('cant').value;
				var C = 1;
				if(cant > 0){
					if(nom.value !== "" && desc.value !== ""){
						var arrperm = Array([]);
						var arrgrup = Array([]);
						for (var i = 1; i <= cant; i++){
							chk = document.getElementById('chk'+i);
							if(chk.checked){
								perm = document.getElementById('cod'+i).value;
								grup = document.getElementById('gru'+i).value;
								arrperm[C] = perm;
								arrgrup[C] = grup;
								C++;
							}
						}
						C--;//le quita la ultima vuelta al contador...
						if(C > 0){
							xajax_Grabar_Rol(nom.value,desc.value,arrperm,arrgrup,C);
						}else{
							msj = '<h5>Seleccione los permisos a asignar en este rol...</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						if(nom.value ===""){
							nomclassName = " form-danger";
						}else{
							nomclassName = " form-control";
						}
						if(desc.value ===""){
							descclassName = " form-danger";
						}else{
							descclassName = " form-control";
						}
						msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<h5>No hay permisos por asignar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				nom = document.getElementById('nom');
				desc = document.getElementById('desc');
				cant = document.getElementById('cant').value;
				var C = 1;
				if(cant > 0){
					if(cod.value !== "" && nom.value !== "" && desc.value !== ""){
						var arrperm = Array([]);
						var arrgrup = Array([]);
						for (var i = 1; i <= cant; i++){
							chk = document.getElementById('chk'+i);
							if(chk.checked){
								perm = document.getElementById('cod'+i).value;
								grup = document.getElementById('gru'+i).value;
								arrperm[C] = perm;
								arrgrup[C] = grup;
								C++;
							}
						}
						C--;//le quita la ultima vuelta al contador...
						if(C > 0){
							xajax_Actualizar_Rol(cod.value,nom.value,desc.value,arrperm,arrgrup,C);
						}else{
							msj = '<h5>Seleccione los permisos a asignar en este rol...</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						if(nom.value ===""){
							nomclassName = " form-danger";
						}else{
							nomclassName = " form-control";
						}
						if(desc.value ===""){
							descclassName = " form-danger";
						}else{
							descclassName = " form-control";
						}
						msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						
					}
				}else{
					msj = '<h5>No hay permisos por asignar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			function Rol_AccionJs(rol,acc){
				if(acc === 'M'){
					xajax_Cuadro_Actualizar_roles(rol);
				}else if(acc === 'V'){
					xajax_Ver_Roles(rol);
				}else if(acc === 'D'){
					Cuadro_Quitar_roles(rol);
				}
			}
			
			function Dashbord(){
				nom = document.getElementById('nom');
				desc = document.getElementById('desc');
				xajax_Dashbord_Roles(nom.value,desc.value);
			}
			
			function Cuadro_Quitar_roles(cod){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/roles/cambia_sit.php",{roll:cod}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function msjAlert(texto,pagina){
				msj = '<h5>'+texto+'</h5><br><br>';
				msj+= '<input type = "button" value = "Aceptar" onclick="window.location=\''+pagina+'\'" />';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
			
			function CambiarSitConfirm(){
				abrirMixPromt();
				texto = "&iquest;Desea realmente Deshabilitar este Rol de Permiso?...";
				acc = "CambiarSit();";
				ConfirmacionJs(texto,acc);
			}
			
			function CambiarSit(){
				cod = document.getElementById("cod1");
				sit = document.getElementById("sit1");
				
				if(cod.value !== "" && sit.value !== ""){
					xajax_CambiaSit_Roles(cod.value,sit.value);
				}else{
					if(cod.value ===""){
						codclassName = " form-danger";
					}else{
						codclassName = " form-control";
					}
					if(sit.value ===""){
						sitclassName = " form-danger";
					}else{
						sitclassName = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
		////---- Checkbox de asignacion de permisos en el rol
		
			function check_todo_grupo(grupo){
				chkg = document.getElementById("chkg"+grupo);
				glist = document.getElementById("gruplist"+grupo);
				var cadena = glist.value;
				var separador = cadena.split("-");
				var cuantos = separador[1];
				var inicia = (parseInt(separador[1])-parseInt(separador[0]))+1;
				//alert(inicia+"-"+cuantos);
				if(chkg.checked) {
					for(var i = inicia; i <= cuantos; i++){
						document.getElementById("chk"+i).checked = true;
					}
				}else{
					for(var i = inicia; i <= cuantos; i++){
						document.getElementById("chk"+i).checked = false;
					}
				}
			}
						