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
			
			function Grabar(){
				abrir();
				desc = document.getElementById('desc');
				clv = document.getElementById('clv');
				
				if(desc.value !== "" && clv.value !== ""){
					xajax_Grabar_Grupo(desc.value,clv.value);
					//botones
					gra = document.getElementById("gra");
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
					gra.className = 'btn btn-primary hidden';
				}else{
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					if(clv.value ===""){
						clv.className = " form-danger";
					}else{
						clv.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				desc = document.getElementById('desc');
				clv = document.getElementById('clv');
				
				if(cod.value !== "" && desc.value !== "" && clv.value !== ""){
					xajax_Modificar_Grupo(cod.value,desc.value,clv.value);
					//botones
					gra = document.getElementById("gra");
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
					gra.className = 'btn btn-primary hidden';
				}else{
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					if(clv.value ===""){
						clv.className = " form-danger";
					}else{
						clv.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
						