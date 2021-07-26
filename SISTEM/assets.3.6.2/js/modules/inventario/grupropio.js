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
				nom = document.getElementById("nom");
				porcent = document.getElementById("porcent");
				
				if(nom.value !=="" && porcent.value !==""){
					xajax_Grabar_Grupo_Articulo(nom.value,porcent.value);
						//botones
						gra = document.getElementById("grab");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(porcent.value ===""){
						porcent.className = " form-danger";
					}else{
						porcent.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				nom = document.getElementById("nom");
				porcent = document.getElementById("porcent");
				
				if(cod.value !=="" && nom.value !=="" && porcent.value !==""){
					xajax_Modificar_Grupo_Articulo(cod.value,nom.value,porcent.value);
						//botones
						gra = document.getElementById("grab");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(porcent.value ===""){
						porcent.className = " form-danger";
					}else{
						porcent.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Deshabilita_Grupo(grup){
				texto = "Esta seguro de Deshabilitar este Grupo de Art\u00E1culos?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Grupo_Articulo("+grup+",0)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_Grupo(grup){
				texto = "Esta seguro de habilitar este Grupo de Art\u00E1culos?";
				acc = "xajax_Situacion_Grupo_Articulo("+grup+",1)";
				ConfirmacionJs(texto,acc);
			}
				