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
									
			function ActualizaCodigo(fila){
				alumno = document.getElementById('alumno'+fila);
				codigo = document.getElementById('codigo'+fila);
				
				if(alumno.value !==""){
					xajax_Codigo_Mineduc(alumno.value,codigo.value,fila);
				}
			}