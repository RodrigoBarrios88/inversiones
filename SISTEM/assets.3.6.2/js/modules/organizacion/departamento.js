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
						
			function Grabar(){
				abrir();
				suc = document.getElementById("suc");
				dct = document.getElementById("dct");
				dlg = document.getElementById("dlg");
				
				if(suc.value !="" && dct.value != "" && dlg.value != ""){
					xajax_Grabar_Departamento(suc.value,dct.value,dlg.value);
					//botones
					gra = document.getElementById("gra");
					gra.className = 'btn btn-primary hidden';
				}else{
					if(suc.value ==""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					if(dct.value ==""){
						dct.className = "form-danger";
					}else{
						dct.className = "form-control";
					}
					if(dlg.value ==""){
						dlg.className = "form-danger";
					}else{
						dlg.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById("cod");
				suc = document.getElementById("suc");
				dct = document.getElementById("dct");
				dlg = document.getElementById("dlg");
				if(suc.value !="" && dct.value != "" && dlg.value != ""){
					xajax_Modificar_Departamento(cod.value,suc.value,dct.value,dlg.value);
					//botones
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
				}else{
					if(suc.value ==""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					if(dct.value ==""){
						dct.className = "form-danger";
					}else{
						dct.className = "form-control";
					}
					if(dlg.value ==""){
						dlg.className = "form-danger";
					}else{
						dlg.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function EliminarDepartamento(codigo){
				abrir();
				texto = "Desea realmente eliminar este departamento?...";
				acc = "xajax_Eliminar_Departamento('"+codigo+"');";
				ConfirmacionJs(texto,acc);
			}
