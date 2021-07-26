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
						

//////////////// BOLETAS DE COBRO //////////////////////

	function Carga(){
		abrir();
		archivo = document.getElementById("archivo");
		
		if(archivo.value !==""){
			Submit();
		}else{
			if(archivo.value ===""){
				archivo.className = "form-danger";
			}else{
				archivo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function GrabarPagosCarga(){
		ban = document.getElementById("ban");
		cue = document.getElementById("cue");
		desc = document.getElementById("desc");
		archivo = document.getElementById("archivo");
		filas = parseInt(document.getElementById("filas").value);
		var filas_validas = 1;
		
		if(ban.value !=="" && cue.value !=="" && archivo.value !==""){
			if(filas > 0){
				arralumno = new Array([]);
				arrcodint = new Array([]);
				arrcodigo = new Array([]);
				arrperiodo = new Array([]);
				arrreferencia = new Array([]);
				arrfecha = new Array([]);
				arrmes = new Array([]);
				arrefectivo = new Array([]);
				arrechp = new Array([]);
				arreotb = new Array([]);
				arreonline = new Array([]);
				
				for(var i = 1; i <= filas; i++){
					pagada = document.getElementById("pagado"+i).value;
					if(pagada !== 1){ //valida que filas ya fueron pagadas y cuales no
						arralumno[filas_validas] = document.getElementById("alumno"+i).value;
						arrcodint[filas_validas] = document.getElementById("codint"+i).value;
						arrcodigo[filas_validas] = document.getElementById("codigo"+i).value;
						arrperiodo[filas_validas] = document.getElementById("periodo"+i).value;
						arrreferencia[filas_validas] = document.getElementById("referencia"+i).value;
						arrfecha[filas_validas] = document.getElementById("fecha"+i).value;
						arrmes[filas_validas] = document.getElementById("mes"+i).value;
						arrefectivo[filas_validas] = document.getElementById("efectivo"+i).value;
						arrechp[filas_validas] = document.getElementById("chp"+i).value;
						arreotb[filas_validas] = document.getElementById("otb"+i).value;
						arreonline[filas_validas] = document.getElementById("online"+i).value;
						filas_validas++;
					}
				}
				filas_validas--;
				
				if(filas_validas > 0){
					abrir();
					xajax_Grabar_Pago_Carga_Electronica(cue.value,ban.value,desc.value,archivo.value,arralumno,arrcodint,arrcodigo,arrperiodo,arrreferencia,arrfecha,arrmes,arrefectivo,arrechp,arreotb,arreonline,filas_validas);
				}else{
					swal("Alto!", "Todas las boletas reportadas en esta Carga Elect\u00F3nica ya se encuentra reportadas como pagadas en el sistema, no hay filas validas para registrar...", "warning");
				}
			}else{
				swal("Alto!", "No hay filas de registros para ser cargados...", "warning");
			}
		}else{
			if(ban.value ===""){
				ban.className = "form-danger";
			}else{
				ban.className = "form-control";
			}
			if(cue.value ===""){
				cue.className = "form-danger";
			}else{
				cue.className = "form-control";
			}
			if(archivo.value ===""){
				archivo.className = "form-danger";
			}else{
				archivo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	