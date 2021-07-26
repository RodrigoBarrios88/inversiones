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
						

			function Asignar_Curso_Alumno(alumno,curso){
				abrir();
				xajax_Graba_Alumno_Curso(alumno,curso);
			}
			
			
			function Desasignar_Curso_Alumno(alumno,curso){
				texto = "\u00BFEsta seguro de desasignar al alumno de este curso?";
				acc = "xajax_Delete_Alumno_Curso('"+alumno+"','"+curso+"');";
				ConfirmacionJs(texto,acc);
			}