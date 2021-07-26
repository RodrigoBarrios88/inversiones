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
	
	function Lista_Multiple(){
		existe = parseInt(document.getElementById("asistencia").value);
		if(existe > 0){ /// si ya fue chequeada la asistencia
			//SI
		}else{
			check_lista_multiple('asist'); //Aun No entonces Chequea todos los alumnos
		}
	}

	function Grabar(){
		cui = document.getElementById("cui");
		filas =  document.getElementById("asistrows").value;
		//--
		horario = document.getElementById('horario');
		fecha = document.getElementById('fecha');
		if(filas > 0) {
			abrir();
			arrpresentes = new Array([]);
			arrausentes = new Array([]);
			presentes = 0;
			ausentes = 0;
			for(i = 1; i <= filas; i++){
				chk = document.getElementById("asist"+i);
				if(chk.checked) {
					arrpresentes[presentes] = chk.value;
					presentes++;
				}else{
					arrausentes[ausentes] = chk.value;
					ausentes++;
				}
			}
			xajax_Grabar_Asistencia(horario.value,fecha.value,arrpresentes,presentes,arrausentes,ausentes);
		}else{
			swal("Ohoo!", "No se listan alumnos en este horario...", "warning");
		}
	}
	
	
	
	function Modificar(){
		cui = document.getElementById("cui");
		filas =  document.getElementById("asistrows").value;
		//--
		horario = document.getElementById('horario');
		fecha = document.getElementById('fecha');
		if(filas > 0) {
			abrir();
			arrpresentes = new Array([]);
			arrausentes = new Array([]);
			presentes = 0;
			ausentes = 0;
			for(i = 1; i <= filas; i++){
				chk = document.getElementById("asist"+i);
				if(chk.checked) {
					arrpresentes[presentes] = chk.value;
					presentes++;
				}else{
					arrausentes[ausentes] = chk.value;
					ausentes++;
				}
			}
			xajax_Modificar_Asistencia(horario.value,fecha.value,arrpresentes,presentes,arrausentes,ausentes);
		}else{
			swal("Ohoo!", "No se listan alumnos en este horario...", "warning");
		}
	}
	
	
	
	function Eliminar_Asistencia(horario,fecha){
		swal({
			text: "\u00BFEsta seguro de ELIMINAR este registro de asistencia? se guardara una alerta en la bitacora del sistema...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true }
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Eliminar_Asistencia(horario,fecha);
					break;
				default:
				  return;
			}
		});
	}
	
	
	