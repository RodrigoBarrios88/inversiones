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

	function Asignar_Nota(fila){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		materia = document.getElementById('materia');
		unidad = document.getElementById("unidad");
		seccion = document.getElementById("seccion");
		tipo = document.getElementById("tipo"+fila);
		alumno = document.getElementById("alumno"+fila);
		zona = document.getElementById("zona"+fila);
		nota = document.getElementById("nota"+fila);
		spancheck = document.getElementById("spancheck"+fila);
		cantidad = document.getElementById("cantidadtotal"+fila);
		spancheck.title = "Transaccion en proceso...";
		spancheck.className = 'btn btn-warning btn-xs';
		spancheck.innerHTML = '<span class="glyphicon glyphicon-hourglass"></span>';

		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && materia.value !=="" && unidad.value !=="" && seccion.value !=="" && alumno.value !==""){
			xajax_Asignar_Nota_Alumno(alumno.value,pensum.value,nivel.value,grado.value,materia.value,unidad.value,zona.value,nota.value,seccion.value,tipo.value,fila,cantidad.value);
		}else{
			if(pensum.value ===""){
				 pensum.className = "form-danger";
			}else{
				 pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				 grado.className = "form-danger";
			}else{
				 grado.className = "form-control";
			}
			if(seccion.value ===""){
				 seccion.className = "form-danger";
			}else{
				 seccion.className = "form-control";
			}
			if(materia.value ===""){
				 materia.className = "form-danger";
			}else{
				 materia.className = "form-control";
			}
			if(unidad.value ===""){
				 unidad.className = "form-danger";
			}else{
				 unidad.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}

	function CertificarNotas(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		materia = document.getElementById('materia');
		unidad = document.getElementById("unidad");
		seccion = document.getElementById("seccion");

		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && materia.value !=="" && unidad.value !=="" && seccion.value !==""){
			pendientes = parseInt(document.getElementById("pendientes").value);
			if(pendientes <= 0){
				abrir();
				xajax_Certificar_Nota_Alumno(pensum.value,nivel.value,grado.value,seccion.value,materia.value,unidad.value);
			}else{
				swal({
					title: "\u00BFEst\u00E1 Seguro?",
					text: "A\u00FAn existen notas pendientes de ingresar para esta materia en esta unidad...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: "Certificar"
					},
					dangerMode: false,
				}).then((willDelete) => {
					if(willDelete) {
						abrir();
						xajax_Certificar_Nota_Alumno(pensum.value,nivel.value,grado.value,seccion.value,materia.value,unidad.value);
					}
				});
			}
		}else{
			if(pensum.value ===""){
				 pensum.className = "form-danger";
			}else{
				 pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				 grado.className = "form-danger";
			}else{
				 grado.className = "form-control";
			}
			if(seccion.value ===""){
				 seccion.className = "form-danger";
			}else{
				 seccion.className = "form-control";
			}
			if(materia.value ===""){
				 materia.className = "form-danger";
			}else{
				 materia.className = "form-control";
			}
			if(unidad.value ===""){
				 unidad.className = "form-danger";
			}else{
				 unidad.className = "form-control";
			}
			swal("Oho!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}

//////////////////////// GRADOS ///////////////////////////////

	function GrabarUnidad(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		desc = document.getElementById('desc');
		porcent = document.getElementById('porcent');

		if(desc.value !=="" && porcent.value !=="" && nivel.value !==""){
			abrir();
			xajax_Grabar_Unidad(pensum.value,nivel.value,desc.value,porcent.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(porcent.value ===""){
				porcent.className = "form-danger";
			}else{
				porcent.className = "form-control";
			}
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}

	function ModificarUnidad(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		porcent = document.getElementById('porcent');

		if(desc.value !=="" && porcent.value !=="" && pensum.value !=="" && nivel.value !==""){
			abrir();
			xajax_Modificar_Unidad(pensum.value,nivel.value,cod.value,desc.value,porcent.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary';
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(porcent.value ===""){
				porcent.className = "form-danger";
			}else{
				porcent.className = "form-control";
			}
			if(pensum.value ===""){
				pensum.className = "form-danger";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}

	function Confirm_Elimina_Unidad(pensum,nivel,unidad){
		swal({
			title: "\u00BFEst\u00E1 Seguro?",
			text: "\u00BFDesea deshabilitar este Unidad con todos sus registros?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: "Eliminar"
			},
			dangerMode: false,
		}).then((willDelete) => {
			if(willDelete) {
				abrir();
				xajax_CambiaSit_Unidad(pensum,nivel,unidad);
			}
		});
	}


//////////////////////// CORRE NOMINAS DE NOTAS ///////////////////////////////

	function Combo_Grado_Notas(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !==""){
			xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Combo_Seccion_Generador_Nominas();");
		}
	}


	function Lista_Materia_Notas(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		if(pensum.value !=="" && nivel.value !=="" && grado.value !==""){
			xajax_Seccion_Materia_Lista(pensum.value,nivel.value,grado.value,seccion.value,'materia','divmateria','Listado de Materias a Incluir');
		}
	}


	function tablaListaNotas(button){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		grado = document.getElementById("grado");
		tipo = document.getElementById("tipo");

		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && seccion.value !=="" && tipo.value !==""){
			myform = document.forms.f1;
			if (tipo.value == '1') {
				num = document.getElementById("num");
				if(num.value !== ""){
					switch(button){
						case 'PR': myform.action ="CPREPORTES/REPnomina_notas_parciales.php"; break;
						case 'VI': myform.action ="CPREPORTES/FRMlista_notas_parciales.php"; break;
						case 'EX': myform.action ="CPREPORTES/EXCELnomina_notas_parciales.php"; break;
					}
					//alert(myform.action);
					myform.target ="_blank";
					myform.submit();
					myform.action ="";
					myform.target ="";
					myform2 = document.forms.f1;
					myform2.action ="";
					myform2.target ="";
				}else{
					num.className = "form-warning";
					swal("Ohoo!", "Seleccione la Unidad a listar...", "warning");
				}
			}else if (tipo.value == '3') {
				switch(button){
					case 'PR': myform.action ="CPREPORTES/REPnomina_notas_finales.php"; break;
					case 'VI': myform.action ="CPREPORTES/FRMlista_notas_finales.php"; break;
					case 'EX': myform.action ="CPREPORTES/EXCELnomina_notas_finales.php"; break;
				}
				myform.target ="_blank";
				myform.submit();
				myform.action ="";
				myform.target ="";
				myform2 = document.forms.f1;
				myform2.target ="";
				myform2.action ="";
			}
		}else{
			if(pensum.value ===""){
				pensum.className = "form-info";
			}else{
				pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-info";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				grado.className = "form-info";
			}else{
				grado.className = "form-control";
			}
			if(seccion.value ===""){
				seccion.className = "form-info";
			}else{
				seccion.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los campos obligatorios...", "info");
		}
	}


	function confirmTarjetaNotasIndividual(fila,button){
		tipo = document.getElementById("tipo");
		parcial = document.getElementById("num");
		var validacion = false;
		if (tipo.value == '1') {
			if(parcial.value !==""){
				validacion = true;
			}else{
				parcial.className = "form-warning";
				swal("Ohoo!", "Seleccione la Unidad a listar...", "warning");
				return; //sale de la funcion
			}
		}else{
			validacion = true;
		}

		if(validacion === true){
			swal({
				text: "\u00BFDesea agregar un comentario o observaci\u00F3n en las tarjetas de Calificaci\u00F3n?",
				icon: "",
				buttons: { cancel: "Cancelar", ok: { text: "Aceptar", value: true } }
			}).then((value) => {
				switch (value) {
					case true:
						comentTarjetaNotasIndividual(fila,button);
						break;
					default:
					  Tarjeta_Notas_Individual(fila,button);
				}
			});
		}else{
			return;
		}
	}

	function comentTarjetaNotasIndividual(fila,button){
		//alert("entro");
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/notas/observaciones_individual.php",{fila:fila,boton:button}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}


	function Tarjeta_Notas_Individual(fila,button){
		////---- Form 1 -----////
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		tipo = document.getElementById("tipo");
		parcial = document.getElementById("num");
		font = document.getElementById("font");
		anchocols = document.getElementById("anchocols");
		papel = document.getElementById("papel");
		orientacion = document.getElementById("orientacion");
		titulo = document.getElementById("titulo");
		notaminima = document.getElementById("notaminima");
		caraA = document.getElementById("caraA");
		caraB = document.getElementById("caraB");
		alumno = document.getElementById("alumno"+fila);

		///--- Form2 ---///
		pensum2 = document.getElementById('pensum2');
		nivel2 = document.getElementById('nivel2');
		grado2 = document.getElementById("grado2");
		seccion2 = document.getElementById("seccion2");
		tipo2 = document.getElementById("tipo2");
		parcial2 = document.getElementById("parcial2");
		font2 = document.getElementById("font2");
		anchocols2 = document.getElementById("anchocols2");
		papel2 = document.getElementById("papel2");
		orientacion2 = document.getElementById("orientacion2");
		titulo2 = document.getElementById("titulo2");
		notaminima2 = document.getElementById("notaminima2");
		caraA2 = document.getElementById("caraA2");
		caraB2 = document.getElementById("caraB2");
		alumno2 = document.getElementById("cui2");
		///---- Entrega de datos ---//////
		pensum2.value = pensum.value;
		nivel2.value = nivel.value;
		grado2.value = grado.value;
		seccion2.value = seccion.value;
		tipo2.value = tipo.value;
		parcial2.value = parcial.value;
		font2.value = font.value;
		anchocols2.value = anchocols.value;
		papel2.value = papel.value;
		orientacion2.value = orientacion.value;
		titulo2.value = titulo.value;
		notaminima2.value = notaminima.value;
		alumno2.value = alumno.value;
		caraA2.value = (caraA.checked)?'1':'';
		caraB2.value = (caraB.checked)?'1':'';

		//alert(tipo.value);

		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && tipo.value !==""){
			myform = document.forms.f2;
			myform.target ="_blank";
			if(tipo.value == '1') {
				if(parcial.value !==""){
					switch(button){
						case 1: myform.action ="../../CONFIG/NOTAS/REPtarjeta_notas_parciales.php"; break;
						case 2: myform.action ="../../CONFIG/NOTAS/EXCELtarjeta_notas_parciales.php"; break;
						case 3: myform.action ="FRMtarjeta_notas_parciales.php"; break;
					}
				}else{
					cerrar();
					parcial.className = "form-warning";
					swal("Ohoo!", "Seleccione la Unidad a listar...", "warning");
					return; //sale de la funcion
				}
			}else if (tipo.value == '3') {
				switch(button){
					case 1: myform.action ="../../CONFIG/NOTAS/REPtarjeta_notas_finales.php"; break;
					case 2: myform.action ="../../CONFIG/NOTAS/EXCELtarjeta_notas_finales.php"; break;
					case 3: myform.action ="FRMtarjeta_notas_finales.php"; break;
				}
			}
			abrir();
			myform.submit();
			myform.action ="";
			myform.target ="";
			cerrar();
		}

	}

	function Observaciones2(tipo,fila,button){
		observaciones = document.getElementById("observaciones");
		observaciones2 = document.getElementById("observaciones2");

		if(observaciones.value !== ""){
			if(tipo == 'Masa'){
				observaciones2.value = observaciones.value;
				cerrar();
				Tarjeta_Notas_Masa(button);
				return;
			}else if(tipo == 'Individual'){
				observaciones2.value = observaciones.value;
				cerrar();
				Tarjeta_Notas_Individual(fila,button);
				return;
			}else{
				cerrar();
				return;
			}
		}else{
			swal("Ohoo!", 'Debe ingresar una observaci\u00F3n o presione "Cancelar"... ', "warning");
		}
	}

	function confirmTarjetaNotasMasa(button){
		tipo = document.getElementById("tipo");
		parcial = document.getElementById("num");
		var validacion = false;
		if (tipo.value == '1') {
			if(parcial.value !==""){
				validacion = true;
			}else{
				parcial.className = "form-warning";
				swal("Ohoo!", "Seleccione la Unidad a listar...", "warning");
				return; //sale de la funcion
			}
		}else{
			validacion = true;
		}

		if(validacion === true){
			swal({
				text: "\u00BFDesea agregar un comentario o observaci\u00F3n en las tarjetas de Calificaci\u00F3n?",
				icon: "",
				buttons: { cancel: "Cancelar", ok: { text: "Aceptar", value: true } }
			}).then((value) => {
				switch (value) {
					case true:
						comentTarjetaNotasMasa(button);
						break;
					default:
						Tarjeta_Notas_Masa(button);
				}
			});
		}else{
			return;
		}
	}

	function comentTarjetaNotasMasa(button){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/notas/observaciones_masa.php",{boton:button}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}


	function Tarjeta_Notas_Masa(button){
		////---- Form 1 -----////
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		tipo = document.getElementById("tipo");
		parcial = document.getElementById("num");
		font = document.getElementById("font");
		anchocols = document.getElementById("anchocols");
		papel = document.getElementById("papel");
		orientacion = document.getElementById("orientacion");
		titulo = document.getElementById("titulo");
		notaminima = document.getElementById("notaminima");
		caraA = document.getElementById("caraA");
		caraB = document.getElementById("caraB");
		///--- Form2 ---///
		pensum2 = document.getElementById('pensum2');
		nivel2 = document.getElementById('nivel2');
		grado2 = document.getElementById("grado2");
		seccion2 = document.getElementById("seccion2");
		tipo2 = document.getElementById("tipo2");
		parcial2 = document.getElementById("parcial2");
		font2 = document.getElementById("font2");
		anchocols2 = document.getElementById("anchocols2");
		papel2 = document.getElementById("papel2");
		orientacion2 = document.getElementById("orientacion2");
		titulo2 = document.getElementById("titulo2");
		notaminima2 = document.getElementById("notaminima2");
		caraA2 = document.getElementById("caraA2");
		caraB2 = document.getElementById("caraB2");
		///---- Entrega de datos ---//////
		pensum2.value = pensum.value;
		nivel2.value = nivel.value;
		grado2.value = grado.value;
		seccion2.value = seccion.value;
		tipo2.value = tipo.value;
		parcial2.value = parcial.value;
		font2.value = font.value;
		anchocols2.value = anchocols.value;
		papel2.value = papel.value;
		orientacion2.value = orientacion.value;
		titulo2.value = titulo.value;
		notaminima2.value = notaminima.value;
		caraA2.value = (caraA.checked)?'1':'';
		caraB2.value = (caraB.checked)?'1':'';
		//alert("entro");

		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && tipo.value !==""){
			myform = document.forms.f2;
			myform.target ="_blank";
			if (tipo.value == '1') {
				if(parcial.value !==""){
					switch(button){
						case 1: myform.action ="../../CONFIG/NOTAS/REPtarjeta_notas_parciales_masa.php"; break;
						case 2: myform.action ="../../CONFIG/NOTAS/EXCELtarjeta_notas_parciales.php"; break;
						case 3: myform.action ="FRMtarjeta_notas_parciales_masa.php"; break;
					}
				}else{
					cerrar();
					parcial.className = "form-warning";
					swal("Ohoo!", "Seleccione la Unidad a listar...", "warning");
					return; //sale de la funcion
				}
			}else if (tipo.value == '3') {
				switch(button){
					case 1: myform.action ="../../CONFIG/NOTAS/REPtarjeta_notas_finales_masa.php"; break;
					case 2: myform.action ="../../CONFIG/NOTAS/EXCELtarjeta_notas_finales.php"; break;
					case 3: myform.action ="FRMtarjeta_notas_finales_masa.php"; break;
				}
			}
			abrir();
			myform.submit();
			myform.action ="";
			myform.target ="";
			cerrar();
		}

	}



//////////////////////// REPORTE LISTADO DE NOTAS ///////////////////////////////

	function Combo_Grado_Notas_Reporte(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !==""){
			xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Lista_Materia_Notas_Reporte();");
		}
	}


	function Lista_Materia_Notas_Reporte(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		tipo = document.getElementById("tipo");
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && tipo.value !==""){
			xajax_Grado_Nomina_Lista(pensum.value,nivel.value,grado.value,tipo.value,1,'nomina','divnomina');
		}
	}


	function Tabla_Lista_Notas_Reporte(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		tipo = document.getElementById("tipo");
		nomina = document.getElementById("nomina");
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && tipo.value !=="" && nomina.value !==""){
			abrir();
			myform = document.forms.f1;
			myform.target ="_blank";
			myform.action ="REPnomina_notas.php";
			myform.submit();
			myform.action ="";
			myform.target ="";
			cerrar();
		}
	}

	function Tabla_Lista_Notas_Excel(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		tipo = document.getElementById("tipo");
		nomina = document.getElementById("nomina");
		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && tipo.value !=="" && nomina.value !==""){
			abrir();
			myform = document.forms.f1;
			myform.action ="EXCELnomina_notas.php";
			myform.submit();
			cerrar();
		}
	}

	/////////////// JUSTIFICA MODIFICACION //////////////

	function justificaModificacion(alumno,nombre,zona,nota,total){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/notas/justificacion_modifica.php",{alumno:alumno,nombre:nombre,zona:zona,nota:nota,total:total}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}

	function Modificar_Nota(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById("grado");
		materia = document.getElementById('materia');
		unidad = document.getElementById("unidad");
		seccion = document.getElementById("seccion");
		alumno = document.getElementById("alumnoX");
		zonaold = document.getElementById("zonaOLD");
		notaold = document.getElementById("notaOLD");
		totalold = document.getElementById("totalOLD");
		zona = document.getElementById("zonaX");
		nota = document.getElementById("notaX");
		justificacion = document.getElementById('justificacion');

		if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && materia.value !=="" && unidad.value !=="" && seccion.value !=="" && alumno.value !=="" && justificacion.value !==""){
			xajax_Modificar_Nota_Alumno(alumno.value,pensum.value,nivel.value,grado.value,materia.value,unidad.value,zonaold.value,notaold.value,totalold.value,zona.value,nota.value,justificacion.value);
		}else{
			if(pensum.value ===""){
				 pensum.className = "form-danger";
			}else{
				 pensum.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(grado.value ===""){
				 grado.className = "form-danger";
			}else{
				 grado.className = "form-control";
			}
			if(seccion.value ===""){
				 seccion.className = "form-danger";
			}else{
				 seccion.className = "form-control";
			}
			if(materia.value ===""){
				 materia.className = "form-danger";
			}else{
				 materia.className = "form-control";
			}
			if(unidad.value ===""){
				 unidad.className = "form-danger";
			}else{
				 unidad.className = "form-control";
			}
			if(justificacion.value ===""){
				 justificacion.className = "form-danger";
			}else{
				 justificacion.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}

	function hisotiralModificaciones(cui,pensum,nivel,grado,materia,unidad){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/notas/historial_modificacion.php",{cui:cui,pensum:pensum,nivel:nivel,grado:grado,materia:materia,unidad:unidad}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}


	/////////////// COMENTARIOS //////////////

	function promtComentario(cui,pensum,nivel,grado,materia,unidad){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/notas/comentarios_notas.php",{cui:cui,pensum:pensum,nivel:nivel,grado:grado,materia:materia,unidad:unidad}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}

	function GrabarComentario(cui,pensum,nivel,grado,materia,unidad){
		observaciones = document.getElementById('observaciones');

		if(observaciones.value !==""){
			xajax_Grabar_Comentario_Alumno(cui,pensum,nivel,grado,materia,unidad,observaciones.value);
		}else{
			if(observaciones.value ===""){
				 observaciones.className = "form-danger";
			}else{
				 observaciones.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
