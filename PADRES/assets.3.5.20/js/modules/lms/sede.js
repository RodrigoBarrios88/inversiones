//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "\u00BFDesea Limpiar la Pagina?, perdera los datos escritos...";
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
				dir = document.getElementById("dir");
				dep = document.getElementById("dep");
				mun = document.getElementById("mun");
				
				if(nom.value !=="" && dir.value !=="" && dep.value !=="" && mun.value !==""){
					xajax_Grabar_Sede(nom.value,dir.value,dep.value,mun.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(dir.value ===""){
						dir.className = " form-danger";
					}else{
						dir.className = " form-control";
					}
					if(dep.value ===""){
						dep.className = " form-danger";
					}else{
						dep.className = " form-control";
					}
					if(mun.value ===""){
						mun.className = " form-danger";
					}else{
						mun.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				dir = document.getElementById("dir");
				nom = document.getElementById("nom");
				dep = document.getElementById("dep");
				mun = document.getElementById("mun");
				
				if(cod.value !=="" && nom.value !=="" && dir.value !=="" && dep.value !=="" && mun.value !==""){
					xajax_Modificar_Sede(cod.value,nom.value,dir.value,dep.value,mun.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(dir.value ===""){
						dir.className = " form-danger";
					}else{
						dir.className = " form-control";
					}
					if(dep.value ===""){
						dep.className = " form-danger";
					}else{
						dep.className = " form-control";
					}
					if(mun.value ===""){
						mun.className = " form-danger";
					}else{
						mun.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Deshabilita_Sede(cod){
				texto = "\u00BFEsta seguro de Deshabilitar esta Sede?, No podra ser usado con esta situaci&oacute;n...";
				acc = "xajax_Situacion_Sede("+cod+");";
				ConfirmacionJs(texto,acc);
			}
			
		
				