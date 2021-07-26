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
				pensum = document.getElementById("pensum");
				nivel = document.getElementById("nivel");
				min = document.getElementById("min");
				desc = document.getElementById("desc");
				
				if(pensum.value !=="" && nivel.value !=="" && min.value !=="" && desc.value !==""){
					xajax_Grabar_Tipo_Periodo(pensum.value,nivel.value,min.value,desc.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(pensum.value ===""){
						pensum.className = " form-danger";
					}else{
						pensum.className = " form-control";
					}
					if(nivel.value ===""){
						nivel.className = " form-danger";
					}else{
						nivel.className = " form-control";
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
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></h5> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				pensum = document.getElementById("pensum");
				nivel = document.getElementById("nivel");
				min = document.getElementById("min");
				desc = document.getElementById("desc");
				
				if(cod.value !=="" && pensum.value !=="" && nivel.value !=="" && min.value !=="" && desc.value !==""){
					xajax_Modificar_Tipo_Periodo(cod.value,pensum.value,nivel.value,min.value,desc.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(pensum.value ===""){
						pensum.className = " form-danger";
					}else{
						pensum.className = " form-control";
					}
					if(nivel.value ===""){
						nivel.className = " form-danger";
					}else{
						nivel.className = " form-control";
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
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></h5> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Deshabilita_Tipo(cod,pensum,nivel){
				texto = "&iquest;Esta seguro de Deshabilitar este Tipo de Servicios?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Tipo_Periodo("+cod+","+pensum+","+nivel+")";
				ConfirmacionJs(texto,acc);
			}
			
		
				