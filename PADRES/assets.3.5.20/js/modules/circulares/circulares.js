//funciones javascript y validaciones

			function AutorizarCircular(circular){
				swal({
					title: "\u00BFEsta Seguro?",
					text: "\u00BFAcepta o autoriza los terminos, condiciones y solicitudes en este documento?",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: {
						  text: "Aceptar",
						  value: true,
						},
					},
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Autorizacion_Circular(circular,1);
							break;
				   
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			function DenegarCircular(circular){
				swal({
					title: "\u00BFEsta Seguro?",
					text: "\u00BFNo autorizo los terminos, condiciones y solicitudes en este documento? Yo no estoy de acuredo...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: {
						  text: "Aceptar",
						  value: true,
						},
					},
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Autorizacion_Circular(circular,2);
							break;
				   
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			