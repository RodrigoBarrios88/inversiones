//funciones javascript y validaciones
	
	function Limpiar(){
		swal({
			text: "\u00BFDesea Limpiar la p\u00E1gina?, si a\u00FAn no a grabado perdera los datos escritos...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					window.location.reload();
					break;
				default:
				  return;
			}
		});
	}
	
	function Submit(){
		myform = document.forms.f1;
		myform.submit();
	}
						
	function Asignar_Curso_Alumno(alumno,curso){
		abrir();
		xajax_Graba_Alumno_Curso(alumno,curso);
	}
	
	
	function Desasignar_Curso_Alumno(alumno,curso){
		swal({
			text: "\u00BFEsta seguro de desasignar al alumno de este curso?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Delete_Alumno_Curso(alumno,curso);
					break;
				default:
				  return;
			}
		});
	}