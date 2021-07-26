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
				curso = document.getElementById("curso");
				min = document.getElementById("min");
				desc = document.getElementById("desc");
				
				if(curso.value !== "" && min.value !== "" && desc.value !== ""){
					xajax_Grabar_Tipo_Periodo(curso.value,min.value,desc.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(curso.value ===""){
						curso.className = " form-danger";
					}else{
						curso.className = " form-control";
					}
					if(min.value ===""){
						min.className = " form-danger";
					}else{
						min.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></h5> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				curso = document.getElementById("curso");
				min = document.getElementById("min");
				desc = document.getElementById("desc");
				
				if(cod.value !== "" && curso.value !== "" && min.value !== "" && desc.value !== ""){
					xajax_Modificar_Tipo_Periodo(cod.value,curso.value,min.value,desc.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(curso.value ===""){
						curso.className = " form-danger";
					}else{
						curso.className = " form-control";
					}
					if(min.value ===""){
						min.className = " form-danger";
					}else{
						min.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></h5> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Deshabilita_Tipo(cod,curso){
				texto = "&iquest;Esta seguro de Deshabilitar este Tipo de Servicios?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Tipo_Periodo("+cod+","+curso+");";
				ConfirmacionJs(texto,acc);
			}
			
		
				