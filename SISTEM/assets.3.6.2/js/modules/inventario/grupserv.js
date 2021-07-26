//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "¿Desea Limpiar la Pagina?, perdera los datos escritos...";
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
				nom = document.getElementById("nom");
				
				if(nom.value !=""){
					xajax_Grabar_Grupo_Servicio(nom.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ==""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></h5> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				nom = document.getElementById("nom");
				
				if(cod.value !="" && nom.value !=""){
					xajax_Modificar_Grupo_Servicio(cod.value,nom.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ==""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></h5> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}

			
			function Limpia_campos(){
				//limpia campos
				document.getElementById('cod').value = "";
				document.getElementById('nom').value = "";
				document.getElementById("sit").value = "";
			}	
			
			
			function Deshabilita_Grupo(grup){
				texto = "¿Esta seguro de Deshabilitar este Grupo de Servicios?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Grupo_Servicio("+grup+",0)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_Grupo(grup){
				texto = "¿Esta seguro de habilitar este Grupo de Servicios?";
				acc = "xajax_Situacion_Grupo_Servicio("+grup+",1)";
				ConfirmacionJs(texto,acc);
			}
				