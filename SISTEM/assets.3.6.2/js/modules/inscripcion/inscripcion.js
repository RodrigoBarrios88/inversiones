var arrbloqueados = [];

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
						
	function Situacion_Boleta(boleta,contrato){
		swal({
			text: "\u00BFEsta seguro de dar esta boleta como Pagada?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Boleta(boleta,contrato);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Anular_Boleta(boleta){
		swal({
			text: "\u00BFEsta seguro de ANULAR esta Boleta?, No podra ser activada despues...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			},
			dangerMode: true,
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Anular_Boleta(boleta);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Aprobar_Contrato(contrato){
		swal({
			text: "\u00BFEsta seguro de Validar la Informaci\u00F3n de este Contrato?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Aprobacion_Contrato(contrato);
					break;
				default:
				  return;
			}
		});
	}
	
	function Recepcion_Contrato(contrato){
		swal({
			text: "\u00BFEsta seguro de marcar este Contrato como recibido?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Recepcion_Contrato(contrato);
					break;
				default:
				  return;
			}
		});
	}
	
	function Inscripcion(nivel,grado,cuinew,cuiold,codint){
		pensum = document.getElementById("pensum");
		if(pensum.value !== ""){
			abrir();
			xajax_Inscribir_Alumno(pensum.value,nivel,grado,cuinew,cuiold,codint);
		}else{
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			swal("Ohoo!", "Seleccione al menos un criterio de busqueda...", "warning");
		}
	}
	
	
	function Regresar_Contrato(contrato,alumno){
		//alert("entro");
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/inscripcion/comentarios.php",{contrato:contrato,alumno:alumno}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function RegresarContrato(){
		contrato = document.getElementById("contrato");
		alumno = document.getElementById("alumno");
		coment = document.getElementById("coment");
		
		if(contrato.value !=="" && alumno.value !=="" && coment.value !==""){
			cerrar();
			abrir();
			xajax_Regresar_Contrato(contrato.value,alumno.value,coment.value);
		}else{
			if(coment.value ===""){
				coment.className = "form-danger";
			}else{
				coment.className = "form-control";
			}
			swal("Ohoo!", "Seleccione al menos un criterio de busqueda...", "warning");
		}
	}
	
	function Quitar_Bloqueo(cui){
		swal({
			text: "\u00BFEsta seguro de quetar a este alumno de la lista reservada?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Quitar_Bloqueo(cui);
					break;
				default:
				  return;
			}
		});
	}
	
	function Deshabilita_Comentario(codigo, contrato, alumno){
		swal({
			text: "\u00BFEsta seguro de elimianr este comentario?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Eliminar_Comentario(codigo, contrato, alumno);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Ingresar_Boleta(fila){
		cui = document.getElementById("cui"+fila).value;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/inscripcion/nueva_boleta.php",{alumno:cui,fila:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#lblparrafo").html(data);
		});
		abrir();
	}
	
	function Solicitar_Boleta(){
		fila = document.getElementById("fila").value;
		cui = document.getElementById("alumno").value;
		documento = document.getElementById("documento");
		if(documento.value !== ""){
			////valida que el CUI no este en lista negra
			var resultado = "";
			for (var i = 0; i < arrbloqueados.length; i++) {
				if(arrbloqueados[i].cui === cui) {
					swal("Nota", "Este alumno(a) se encuentra en una lista reservada en el Colegio.   No se girar\u00E1 boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.", "warning");
					swal.stopLoading();
					swal.close();
					cerrar();
					return;
				}
			}
			///// valida que el nombre del aulumno no este en lista negra 
			if(CompareNombreBloqueado(fila)){
				xajax_Solicitar_Boleta_Inscripcion(cui,documento.value);
			}else{
				cerrar();
				return;
			}
		}else{
			documento.className = " form-danger";
			swal("Ohoo!", "Ingrese el numero de boleta por favor", "warning");
		}
	}
	
	
	function JsonString(url){
		
		//let url = 'https://losolivos.inversionesd.com/SISTEM/API/API_inscripciones.php?request=bloqueados';
		fetch(url).then(res => res.json()).then((out) => {
		  //console.log('Checkout this JSON! ', out);
		  arrbloqueados = out;
		}).catch(err => {
			console.log('Error: ', err);	
		});
	}
	
	
	function CompareCuiBloqueado(fila){
		cui = document.getElementById("cui"+fila).value;
		var resultado = "";
		for (var i = 0; i < arrbloqueados.length; i++) {
			if(arrbloqueados[i].cui === cui) {
				//alert("Iguales! CUI: "+cui+" en la fila "+i);
				swal({
					title: "Nota",
					text: "El nombre de este alumno(a) se encuentra en una lista reservada en el Colegio.   No se girará boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.",
					type: "warning",
				  },
					function(){
						$('.wizard-actions .btn-prev').attr("disabled", "disabled");
						$('.wizard-actions .btn-next').attr("disabled", "disabled");
						$(".wizard-actions .btn-finish").attr("disabled", "disabled");
					});
				return;
			}
		}
		return true;  //si todo esta bien devuelve true
	}
	
	
	function CompareNombreBloqueado(fila){
		nom = document.getElementById("nombre"+fila);
		ape = document.getElementById("apellido"+fila);
		var nombre = nom.value+ape.value;
		///-- limpia la cadena
		nombre = nombre.toUpperCase();
		//nombre = "VALDEZ MORALES";
		//--
		purename = nombre;
		/*purename = nombre.replace(/Á/gi, "A");
		purename = purename.replace(/É/gi,"E");
		purename = purename.replace(/Í/gi,"I");
		purename = purename.replace(/Ó/gi,"O");
		purename = purename.replace(/Ú/gi,"U");
		//dierecis
		purename = purename.replace(/Ä/gi,"A");
		purename = purename.replace(/Ë/gi,"E");
		purename = purename.replace(/Ï/gi,"I");
		purename = purename.replace(/Ö/gi,"O");
		purename = purename.replace(/Ü/gi,"U");
		//Ñ
		purename = purename.replace(/Ñ/gi,"N");*/
		///espacios y otros
		purename = purename.replace(/ /gi,"");
		purename = purename.replace(/,/gi,"");
		purename = purename.toLowerCase();
		//alert(purename);
		var matchscore = "";
		for (var i = 0; i < arrbloqueados.length; i++) {
			//alert(arrbloqueados[i].purename+", "+purename);
			matchscore = purename.score(arrbloqueados[i].purename);
			matchscore = matchscore * 100;
			if(matchscore >= 85) {
				//alert("El Nombre coinciden demasiado: "+arrbloqueados[i].nombre+" en la fila "+i+". Coincidencia:"+matchscore+" %");
				swal("Nota","El nombre de este alumno se encuentra en una lista reservada en el Colegio.   No se girar\u00E1 boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.","warning").then((value) => {
					document.getElementById("btnnext").setAttribute("disabled","disabled");
				});
				return false;
			}
		}
		return true;
	}
	