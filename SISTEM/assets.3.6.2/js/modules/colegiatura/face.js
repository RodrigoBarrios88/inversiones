//funciones javascript y validaciones
	function Limpiar(){
		swal({
			text: "\u00BFDesea Limpiar la p\u00E1gina?",
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
						

//////////////// FACTURAS //////////////////////

	function GrabarFACE(){
		swal({
			title: "Facturas",
			text: "\u00BFDesea grabar estas facturas?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					GrabarFacutras();
					break;
				default:
				  return;
			}
		});
	}
	
	
	function GrabarFacutras(){
		filas = parseInt(document.getElementById("filas").value);
		if(filas > 0){
			arrcentro = new Array([]);
			arrfecha = new Array([]);
			arrtipo = new Array([]);
			arroperacion = new Array([]);
			arrserie = new Array([]);
			arrnumero = new Array([]);
			arrnit = new Array([]);
			arrbienes = new Array([]);
			arrservicios = new Array([]);
			arriva = new Array([]);
			arrtotal = new Array([]);
			
			for(var i = 1; i <= filas; i++){
				arrcentro[i] = document.getElementById("centro"+i).value;
				arrfecha[i] = document.getElementById("fecha"+i).value;
				arrtipo[i] = document.getElementById("tipo"+i).value;
				arroperacion[i] = document.getElementById("operacion"+i).value;
				arrserie[i] = document.getElementById("serie"+i).value;
				arrnumero[i] = document.getElementById("numero"+i).value;
				arrnit[i] = document.getElementById("nit"+i).value;
				arrbienes[i] = document.getElementById("bienes"+i).value;
				arrservicios[i] = document.getElementById("servicios"+i).value;
				arriva[i] = document.getElementById("iva"+i).value;
				arrtotal[i] = document.getElementById("total"+i).value;
			}
			if(filas > 0){
				abrir();
				xajax_Grabar_Facturas_FACE(arrcentro,arrfecha,arrtipo,arroperacion,arrserie,arrnumero,arrnit,arrbienes,arrservicios,arriva,arrtotal, filas);
			}else{
				swal("Alto!", "No hay filas de registros para ser cargados...", "warning");
			}
		}else{
			swal("Alto!", "No hay filas de registros para ser cargados...", "warning");
		}
	}
	
