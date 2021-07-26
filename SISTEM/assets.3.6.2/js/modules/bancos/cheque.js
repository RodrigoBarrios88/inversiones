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
						
	function pageprint(){
		boton = document.getElementById("print");
		boton.className = "hidden";
		window.print();
		boton.className = "btn btn-default";
	}
	
	function Num_Cheque(){
		ban = document.getElementById("ban");
		cue = document.getElementById("cue");
		
		if(ban.value !=="" && cue.value !==""){
			xajax_Last_Cheque(cue.value,ban.value);
			
		}
	}						
			
	function Seleccionar_Cuenta(cuenta,banco,numero,nombre,tipo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/bancos/movcuenta.php",{cue:cuenta,ban:banco,num:numero,bann:nombre,tip:tipo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
				
	function Grabar(){
		ban = document.getElementById("ban");
		cue = document.getElementById("cue");
		num = document.getElementById("num");
		monto = document.getElementById("monto");
		quien = document.getElementById("quien");
		concept = document.getElementById("concept");
		
		if(cue.value !=="" && ban.value !=="" && num.value !=="" && monto.value !=="" && quien.value !=="" && concept.value !==""){
			abrir();
			xajax_Grabar_Cheque(cue.value,ban.value,num.value,monto.value,quien.value,concept.value);
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
			if(num.value ===""){
				num.className = "form-danger";
			}else{
				num.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(quien.value ===""){
				quien.className = "form-danger";
			}else{
				quien.className = "form-control";
			}
			if(concept.value ===""){
				concept.className = "form-danger";
			}else{
				concept.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Modificar(){
		cod = document.getElementById("cod");
		ban = document.getElementById("ban");
		cue = document.getElementById("cue");
		num = document.getElementById("num");
		monto = document.getElementById("monto");
		quien = document.getElementById("quien");
		concept = document.getElementById("concept");
		
		if(cod.value !==""){
			if(cue.value !=="" && ban.value !=="" && num.value !=="" && monto.value !=="" && quien.value !=="" && concept.value !==""){
				abrir();
				xajax_Modificar_Cheque(cod.value,cue.value,ban.value,num.value,monto.value,quien.value,concept.value);
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
				if(num.value ===""){
					num.className = "form-danger";
				}else{
					num.className = "form-control";
				}
				if(monto.value ===""){
					monto.className = "form-danger";
				}else{
					monto.className = "form-control";
				}
				if(quien.value ===""){
					quien.className = "form-danger";
				}else{
					quien.className = "form-control";
				}
				if(concept.value ===""){
					concept.className = "form-danger";
				}else{
					concept.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			}
		}else{
			swal("Ohoo!", "Error de Traslaci\u00F3n de Datos, Refresque la pagina e intente de nuevo...", "error");
		}
	}
	
	
	function Deshabilita_Cheque(cod,cue,ban){
		swal({
			text: "\u00BFEsta seguro de anular este Cheque?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Cheque(cod,cue,ban,0);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}
	
	
	function Habilita_Cheque(cod,cue,ban){
		swal({
			text: "\u00BFEsta seguro de re-habilitar este Cheque?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Cheque(cod,cue,ban,1);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}
	
	function Confirma_Ejecutar_Cheque(fila){
		swal({
			text: "\u00BFEsta seguro de ejecutar el monto confirmando el pago de este Cheque?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					Ejecutar_Cheque(fila);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}
	
	function Ejecutar_Cheque(fila){
		abrir();
		if(fila > 0){
			che = document.getElementById("Tcod"+fila);
			ban = document.getElementById("Tban"+fila);
			cue = document.getElementById("Tcue"+fila);
			monto = document.getElementById("Tmonto"+fila);
			doc = document.getElementById("Tnum"+fila);
			mot = document.getElementById("Tconcepto"+fila);					
			xajax_Ejecutar_Monto_Cheque(che.value,ban.value,cue.value,monto.value,doc.value,mot.value);
		}
	}	
		