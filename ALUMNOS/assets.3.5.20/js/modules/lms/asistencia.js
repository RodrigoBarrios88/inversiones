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
			

			function Reservar(fila,seleccion){
				horario = document.getElementById('horario'+fila);
				fecha = document.getElementById('fecha'+fila);
				alumno = document.getElementById("alumno"+fila);
				if(horario.value !== "" && fecha.value !== "" && alumno.value !== "") {
					xajax_Grabar_Reserva(horario.value,fecha.value,alumno.value,seleccion);
				}
			}
			
			function Eliminar_Reservar(horario,fecha,alumno){
				texto = "\u00BFEsta seguro de ELIMINAR este registro de reserva de cupo?";
				acc = "xajax_Eliminar_Reserva('"+horario+"','"+fecha+"','"+alumno+"');";
				ConfirmacionJs(texto,acc);
			}