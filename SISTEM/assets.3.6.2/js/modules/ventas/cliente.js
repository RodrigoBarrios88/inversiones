//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "Desea Limpiar la Pagina?, perdera los datos escritos...";
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
						
			function Grabar(){
				abrir();
				nit = document.getElementById('nit');
				nom = document.getElementById('nom');
				direc = document.getElementById("direc");
				tel1 = document.getElementById("tel1");
				tel2 = document.getElementById("tel2");
				mail = document.getElementById("mail");
				   
				if(nit.value !=="" && nom.value !=="" && direc.value !== ""){
					xajax_Grabar_Cliente(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nit.value ===""){
						nit.className = "form-danger";
					}else{
						nit.className = "form-control";
					}
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(direc.value ===""){
						direc.className = "form-danger";
					}else{
						direc.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				nit = document.getElementById('nit');
				nom = document.getElementById('nom');
				direc = document.getElementById("direc");
				tel1 = document.getElementById("tel1");
				tel2 = document.getElementById("tel2");
				mail = document.getElementById("mail");
				
				if(nit.value !=="" && nom.value !=="" && direc.value !== ""){
					xajax_Modificar_Cliente(cod.value,nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nit.value ===""){
						nit.className = "form-danger";
					}else{
						nit.className = "form-control";
					}
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(direc.value ===""){
						direc.className = "form-danger";
					}else{
						direc.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}

			function Historial_Compras(cliente){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/cliente/historial_compras.php",{codigo:cliente}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			
			function Lista_Articulos(cliente){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/cliente/lista_articulos.php",{codigo:cliente}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			