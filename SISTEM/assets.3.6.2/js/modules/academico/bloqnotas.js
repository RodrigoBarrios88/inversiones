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
				
	//////////////////////// PENSUMS ///////////////////////////////
	
   
   function activacionNota(codigo){
      swal({
			title: "Activar Notas",
			text: "\u00BFDesea activar la visualizaci\u00F3n de notas para este nivel?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Status_Nota(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	function vistaNota(codigo){
      swal({
			title: "Activar Notas",
			text: "Desea activar la visualizacion de notas para este nivel?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Status_Nota(codigo);
					break;
				default:
				  return;
			}
		});
	}
		function NovistaNota(codigo){
      swal({
			title: "Inhabilitar Notas",
			text: "\u00BFDesea inhabilitar la visualizaci\u00F3n de notas para este nivel?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_quitar_Nota(codigo);
					break;
				default:
				  return;
			}
		});
	}