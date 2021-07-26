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
	
	function Limpiar1(){
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
					window.location.href='FRMpaso1.php';
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
	
	function ActualizaPadre(){
		dpi = document.getElementById("dpi");
		tipodpi = document.getElementById("tipodpi");
		nombre = document.getElementById("nombre");
		apellido = document.getElementById("apellido");
		fecnac = document.getElementById("padrefecnac");
		parentesco = document.getElementById("parentesco");
		ecivil = document.getElementById("ecivil");
		nacionalidad = document.getElementById("nacionalidad");
		mail = document.getElementById("mail");
		direccion = document.getElementById("direccion");
		departamento = document.getElementById("departamento");
		municipio = document.getElementById("municipio");
		telcasa = document.getElementById("telcasa");
		celular = document.getElementById("celular");
		trabajo = document.getElementById("trabajo");
		teltrabajo = document.getElementById("teltrabajo");
		profesion = document.getElementById("profesion");
		if(dpi.value !== "" && tipodpi.value !== "" && nombre.value !=="" && apellido.value !=="" && fecnac.value !=="" && parentesco.value !=="" && nacionalidad.value !=="" && 
			ecivil.value !=="" && direccion.value !=="" && departamento.value !=="" && municipio.value !=="" && trabajo.value !=="" && profesion.value !==""){
			////////------------------
			xajax_Actualizar_Padre(dpi.value,tipodpi.value,nombre.value,apellido.value,fecnac.value,parentesco.value,ecivil.value,nacionalidad.value,mail.value,telcasa.value,celular.value,direccion.value,departamento.value,municipio.value,trabajo.value,teltrabajo.value,profesion.value);
		}else{
			if(dpi.value ===""){
				dpi.className = "form-danger";
			}else{
				dpi.className = "form-control";
			}
			if(tipodpi.value ===""){
				tipodpi.className = "form-danger";
			}else{
				tipodpi.className = "form-control";
			}
			if(nombre.value ===""){
				nombre.className = "form-danger";
			}else{
				nombre.className = "form-control";
			}
			if(apellido.value ===""){
				apellido.className = "form-danger";
			}else{
				apellido.className = "form-control";
			}
			if(fecnac.value ===""){
				fecnac.className = "form-danger";
			}else{
				fecnac.className = "form-control";
			}
			if(parentesco.value ===""){
				parentesco.className = "form-danger";
			}else{
				parentesco.className = "form-control";
			}
			if(nacionalidad.value ===""){
				nacionalidad.className = "form-danger";
			}else{
				nacionalidad.className = "form-control";
			}
			if(ecivil.value ===""){
				ecivil.className = "form-danger";
			}else{
				ecivil.className = "form-control";
			}
			if(direccion.value ===""){
				direccion.className = "form-danger";
			}else{
				direccion.className = "form-control";
			}
			if(departamento.value ===""){
				departamento.className = "form-danger";
			}else{
				departamento.className = "form-control";
			}
			if(municipio.value ===""){
				municipio.className = "form-danger";
			}else{
				municipio.className = "form-control";
			}
			if(trabajo.value ===""){
				trabajo.className = "form-danger";
			}else{
				trabajo.className = "form-control";
			}
			if(profesion.value ===""){
				profesion.className = "form-danger";
			}else{
				profesion.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}	
	}
	
	function agregarExistente(alumno,padre,mensaje){
		swal({
			text: mensaje,
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Agregar_Existente(alumno,padre);
					break;
				default:
				  swal("", "Acci\u00F3n cancelada...", "");
			}
		});
	}
	
	function agregarNuevo(alumno,padre,mensaje){
		swal({
			text: mensaje,
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Agregar_Nuevo(alumno,padre);
					break;
				default:
				  swal("", "Acci\u00F3n cancelada...", "");
			}
		});
	}
	
	function ActualizaHijos(){
		var bandera_hijos = 0;
		//----
		padre = document.getElementById("dpi").value;
		hijos = parseInt(document.getElementById("alumnos").value);
		if (hijos > 0) {
			var arrcontrato = new Array([]);
			var arrcuinew = new Array([]);
			var arrcuiold = new Array([]);
			var arrcodigo = new Array([]);
			var arrtipocui = new Array([]);
			var arrnombre = new Array([]);
			var arrapellido = new Array([]);
			var arrgenero = new Array([]);
			var arrfecnac = new Array([]);
			var arrnacionalidad = new Array([]);
			var arrreligion = new Array([]);
			var arridioma = new Array([]);
			var arrmail = new Array([]);
			var arrsangre = new Array([]);
			var arralergia = new Array([]);
			var arremergencia = new Array([]);
			var arremetel = new Array([]);
			//--
			
			for(i = 1; i <= hijos; i++){
				xcontrato = document.getElementById("contrato"+i);
				xcuinew = document.getElementById("cuinew"+i);
				xcuiold = document.getElementById("cuiold"+i);
				xcodigo = document.getElementById("codigo"+i);
				xtipocui = document.getElementById("tipocui"+i);
				xnombre = document.getElementById("nombre"+i);
				xapellido = document.getElementById("apellido"+i);
				xgenero = document.getElementById("genero"+i);
				xfecnac = document.getElementById("fecnac"+i);
				xnacionalidad = document.getElementById("nacionalidad"+i);
				xreligion = document.getElementById("religion"+i);
				xidioma = document.getElementById("idioma"+i);
				xmail = document.getElementById("mail"+i);
				xsangre = document.getElementById("sangre"+i);
				xalergia = document.getElementById("alergico"+i);
				xemergencia = document.getElementById("emergencia"+i);
				xemetel = document.getElementById("emertel"+i);
				//--
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
					if(xcuinew.value ===""){
						xcuinew.className = "form-danger";
					}else{
						xcuinew.className = "form-control";
					}
					if(xcuiold.value ===""){
						xcuiold.className = "form-danger";
					}else{
						xcuiold.className = "form-control";
					}
					if(xtipocui.value ===""){
						xtipocui.className = "form-danger";
					}else{
						xtipocui.className = "form-control";
					}
					if(xnombre.value ===""){
						xnombre.className = "form-danger";
					}else{
						xnombre.className = "form-control";
					}
					if(xapellido.value ===""){
						xapellido.className = "form-danger";
					}else{
						xapellido.className = "form-control";
					}
					if(xgenero.value ===""){
						xgenero.className = "form-danger";
					}else{
						xgenero.className = "form-control";
					}
					if(xfecnac.value ===""){
						xfecnac.className = "form-danger";
					}else{
						xfecnac.className = "form-control";
					}
					if(xsangre.value ===""){
						xsangre.className = "form-danger";
					}else{
						xsangre.className = "form-control";
					}
					if(xemergencia.value ===""){
						xemergencia.className = "form-danger";
					}else{
						xemergencia.className = "form-control";
					}
					if(xemetel.value ===""){
						xemetel.className = "form-danger";
					}else{
						xemetel.className = "form-control";
					}
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				if(xcuinew.value ==="" || xtipocui.value ==="" ||  xnombre.value ==="" || xapellido.value ==="" || xgenero.value ==="" || xfecnac.value ==="" || xsangre.value ==="" || xemergencia.value ==="" || xemetel.value ===""){
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
					return;
				}
				///valida la cantidad de caracteres del CUI del Hijo
				var codigoUnico = xcuinew.value;
				if(codigoUnico.length < 13){
					xcuinew.className = "form-danger";
					swal("Ohoo!", "El C\u00F3digo de Identificaci\u00F3n Unico (CUI) debe contener 13 caracteres numericos.  Este c\u00F3digo es proporcionado y asignado en el Acta de Nacimiento por el RENAP.", "error");
					return;
				}
				arrcontrato[i] = xcontrato.value;
				arrcuinew[i] = xcuinew.value;
				arrcuiold[i] = xcuiold.value;
				arrtipocui[i] = xtipocui.value;
				arrcodigo[i] = xcodigo.value;
				arrnombre[i] = xnombre.value;
				arrapellido[i] = xapellido.value;
				arrgenero[i] = xgenero.value;
				arrfecnac[i] = xfecnac.value;
				arralergia[i] = xalergia.value;
				arrsangre[i] = xsangre.value;
				arremergencia[i] = xemergencia.value;
				arremetel[i] = xemetel.value;
				//--
				arrnacionalidad[i] = xnacionalidad.value;
				arrreligion[i] = xreligion.value;
				arridioma[i] = xidioma.value;
				arrmail[i] = xmail.value;
				
			}
		}else{
			swal("Ohoo!", "Al menos un aulumno debe de ser inscrito...", "error");
			return;
		}
		xajax_Actualiza_Hijos(padre,arrcontrato,arrcuinew,arrcuiold,arrtipocui,arrcodigo,arrnombre,arrapellido,arrgenero,arrfecnac,arrnacionalidad,arrreligion,arridioma,arrmail,arrsangre,arralergia,arremergencia,arremetel,hijos);
	}
	
	
	function ActualizaDatos(){
		var bandera_hijos = 0;
		//----
		hijos = parseInt(document.getElementById("alumnos").value);
		if (hijos > 0) {
			var arrcontrato = new Array([]);
			var arrcuinew = new Array([]);
			var arrnivel = new Array([]);
			var arrgrado = new Array([]);
			var arrnit = new Array([]);
			var arrclinombre = new Array([]);
			var arrclidireccion = new Array([]);
			for(i = 1; i <= hijos; i++){
				xstatus= document.getElementById("status"+i);
				xcontrato = document.getElementById("contrato"+i);
				xcuinew = document.getElementById("cuinew"+i);
				xnivel = document.getElementById("nivel"+i);
				xgrado = document.getElementById("grado"+i);
				//--
				xnit = document.getElementById("nit"+i);
				xclinombre = document.getElementById("clinombre"+i);
				xclidireccion = document.getElementById("clidireccion"+i);
				//--
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				if(xcuinew.value ===""){
					xcuinew.className = "form-danger";
				}else{
					xcuinew.className = "form-control";
				}
				if(xnivel.value ===""){
					xnivel.className = "form-danger";
				}else{
					xnivel.className = "form-control";
				}
				if(xgrado.value ===""){
					xgrado.className = "form-danger";
				}else{
					xgrado.className = "form-control";
				}
				if(xnit.value ===""){
					xnit.className = "form-danger";
				}else{
					xnit.className = "form-control";
				}
				if(xclinombre.value ===""){
					xclinombre.className = "form-danger";
				}else{
					xclinombre.className = "form-control";
				}
				if(xclidireccion.value ===""){
					xclidireccion.className = "form-danger";
				}else{
					xclidireccion.className = "form-control";
				}
				if(xcuinew.value ==="" || xnivel.value ==="" || xgrado.value ==="" ||  xnit.value ==="" || xnit.value ==="" || xclinombre.value ==="" || xclidireccion.value ===""){
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
					return;
				}
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				arrcontrato[i] = xcontrato.value;
				arrcuinew[i] = xcuinew.value;
				arrnivel[i] = xnivel.value;
				arrgrado[i] = xgrado.value;
				arrnit[i] = xnit.value;
				arrclinombre[i] = xclinombre.value;
				arrclidireccion[i] = xclidireccion.value;
			}
		}else{
			swal("Ohoo!", "Al menos un aulumno debe de ser inscrito...", "error");
			return;
		}
		xajax_Actualiza_Datos_Generales(arrcontrato,arrcuinew,arrnivel,arrgrado,arrnit,arrclinombre,arrclidireccion,hijos);
	}
	
	
	function ActualizaSeguro(){
		var bandera_hijos = 0;
		//----
		hijos = parseInt(document.getElementById("alumnos").value);
		if (hijos > 0) {
			var arrcontrato = new Array([]);
			var arrcuinew = new Array([]);
			//--
			var arrseguro = new Array([]);
			var arrpoliza = new Array([]);
			var arrasegura = new Array([]);
			var arrplan = new Array([]);
			var arrasegurado = new Array([]);
			var arrinstuc = new Array([]);
			var arrcomment = new Array([]);
			for(i = 1; i <= hijos; i++){
				xstatus= document.getElementById("status"+i);
				xcontrato = document.getElementById("contrato"+i);
				xcuinew = document.getElementById("cuinew"+i);
				//-- radiobutton
				var segsi = document.getElementById("segurosi"+i);
				var segno = document.getElementById("segurono"+i);
				if(segsi.checked){
					xseguro = 1;
				}else if(segno.checked){
					xseguro = 0;
				}else{
					xseguro = "";
				}
				//--
				xpoliza = document.getElementById("poliza"+i);
				xasegura = document.getElementById("aseguradora"+i);
				xplan = document.getElementById("plan"+i);
				xasegurado = document.getElementById("asegurado"+i);
				xinstruc = document.getElementById("instrucciones"+i);
				xcomment = document.getElementById("comentarios"+i);
				//--
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
					if(xcuinew.value ===""){
						xcuinew.className = "form-danger";
					}else{
						xcuinew.className = "form-control";
					}
					if(xseguro === ""){
						document.getElementById("labelsi"+i).className = "radio-danger" ; 
						document.getElementById("labelno"+i).className = "radio-danger" ; 
					}else{
						document.getElementById("labelsi"+i).className = ""; 
						document.getElementById("labelno"+i).className = ""; 
					}
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				if(xcuinew.value ==="" || xseguro.value ===""){
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
					return;
				}
				arrcontrato[i] = xcontrato.value;
				arrcuinew[i] = xcuinew.value;
				arrseguro[i] = xseguro;
				arrpoliza[i] = xpoliza.value;
				arrasegura[i] = xasegura.value;
				arrplan[i] = xplan.value;
				arrasegurado[i] = xasegurado.value;
				arrinstuc[i] = xinstruc.value;
				arrcomment[i] = xcomment.value;
			}
		}else{
			swal("Ohoo!", "Al menos un aulumno debe de ser inscrito...", "error");
			return;
		}
		
		xajax_Actualiza_Seguro(arrcontrato,arrcuinew,arrseguro,arrpoliza,arrasegura,arrplan,arrasegurado,arrinstuc,arrcomment,hijos);
	}
	
	
	
	function ActualizaContrato(){
		var bandera_hijos = 0;
		//----
		padre = document.getElementById("dpi").value;
		hijos = parseInt(document.getElementById("alumnos").value);
		if (hijos > 0) {
			var arrcontrato = new Array([]);
			var arrcuinew = new Array([]);
			//--
			var arrdpi = new Array([]);
			var arrtipodpi = new Array([]);
			var arrnomc = new Array([]);
			var arrapec = new Array([]);
			var arrfecnacc = new Array([]);
			var arrparentesco = new Array([]);
			var arrecivil = new Array([]);
			var arrnacionalidad = new Array([]);
			var arrmail = new Array([]);
			var arrdireccion = new Array([]);
			var arrdepartamento = new Array([]);
			var arrmunicipio = new Array([]);
			var arrtelcasa = new Array([]);
			var arrcelular = new Array([]);
			var arrtrabajo = new Array([]);
			var arrteltrabajo = new Array([]);
			var arrprofesion = new Array([]);
			for(i = 1; i <= hijos; i++){
				xcontrato = document.getElementById("contrato"+i);
				xcuinew = document.getElementById("cuinew"+i);
				//--
				xdpi = document.getElementById("contradpi"+i);
				xtipodpi = document.getElementById("contratipodpi"+i);
				xnomc = document.getElementById("contranombre"+i);
				xapec = document.getElementById("contraapellido"+i);
				xfecnacc = document.getElementById("contrafecnac"+i);
				xparentesco = document.getElementById("contraparentesco"+i);
				xecivil = document.getElementById("contraecivil"+i);
				xnacionalidad = document.getElementById("contranacionalidad"+i);
				xmail = document.getElementById("contramail"+i);
				xdireccion = document.getElementById("contradireccion"+i);
				xdepartamento = document.getElementById("contradep"+i);
				xmunicipio = document.getElementById("contramun"+i);
				xtelcasa = document.getElementById("contratelcasa"+i);
				xcelular = document.getElementById("contracelular"+i);
				xtrabajo = document.getElementById("contratrabajo"+i);
				xteltrabajo = document.getElementById("contrateltrabajo"+i);
				xprofesion = document.getElementById("contraprofesion"+i);
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
					if(xcuinew.value ===""){
						xcuinew.className = "form-danger";
					}else{
						xcuinew.className = "form-control";
					}
					if(xdpi.value ===""){
						xdpi.className = "form-danger";
					}else{
						xdpi.className = "form-control";
					}
					if(xtipodpi.value ===""){
						xtipodpi.className = "form-danger";
					}else{
						xtipodpi.className = "form-control";
					}
					if(xnomc.value ===""){
						xnomc.className = "form-danger";
					}else{
						xnomc.className = "form-control";
					}
					if(xapec.value ===""){
						xapec.className = "form-danger";
					}else{
						xapec.className = "form-control";
					}
					if(xfecnacc.value ===""){
						xfecnacc.className = "form-danger";
					}else{
						xfecnacc.className = "form-control";
					}
					if(xparentesco.value ===""){
						xparentesco.className = "form-danger";
					}else{
						xparentesco.className = "form-control";
					}
					if(xecivil.value ===""){
						xecivil.className = "form-danger";
					}else{
						xecivil.className = "form-control";
					}
					if(xnacionalidad.value ===""){
						xnacionalidad.className = "form-danger";
					}else{
						xnacionalidad.className = "form-control";
					}
					if(xdireccion.value ===""){
						xdireccion.className = "form-danger";
					}else{
						xdireccion.className = "form-control";
					}
					if(xdepartamento.value ===""){
						xdepartamento.className = "form-danger";
					}else{
						xdepartamento.className = "form-control";
					}
					if(xmunicipio.value ===""){
						xmunicipio.className = "form-danger";
					}else{
						xmunicipio.className = "form-control";
					}
					if(xtrabajo.value ===""){
						xtrabajo.className = "form-danger";
					}else{
						xtrabajo.className = "form-control";
					}
					if(xprofesion.value ===""){
						xprofesion.className = "form-danger";
					}else{
						xprofesion.className = "form-control";
					}
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				if(xcuinew.value ==="" || xdpi.value ==="" ||  xtipodpi.value ==="" || xnomc.value ==="" || xapec.value ==="" || xfecnacc.value ==="" || xparentesco.value ==="" || xecivil.value ==="" || xnacionalidad.value ==="" || xdireccion.value ==="" || xdepartamento.value ==="" || xmunicipio.value ==="" || xtrabajo.value ==="" || xprofesion.value ===""){        
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
					return;
				}
				//--
				arrcontrato[i] = xcontrato.value;
				arrcuinew[i] = xcuinew.value;
				//--
				arrdpi[i] = xdpi.value;
				arrtipodpi[i] = xtipodpi.value;
				arrnomc[i] = xnomc.value;
				arrapec[i] = xapec.value;
				arrfecnacc[i] = xfecnacc.value;
				arrparentesco[i] = xparentesco.value;
				arrecivil[i] = xecivil.value;
				arrnacionalidad[i] = xnacionalidad.value;
				arrmail[i] = xmail.value;
				arrdireccion[i] = xdireccion.value;
				arrdepartamento[i] = xdepartamento.value;
				arrmunicipio[i] = xmunicipio.value;
				arrtelcasa[i] = xtelcasa.value;
				arrcelular[i] = xcelular.value;
				arrtrabajo[i] = xtrabajo.value;
				arrteltrabajo[i] = xteltrabajo.value;
				arrprofesion[i] = xprofesion.value;
			}
		}else{
			swal("Ohoo!", "Al menos un aulumno debe de ser inscrito...", "error");
			return;
		}
		
		xajax_Actualiza_Datos_Contrato(arrcontrato,arrcuinew,arrdpi,arrtipodpi,arrnomc,arrapec,arrfecnacc,arrparentesco,arrecivil,arrnacionalidad,arrmail,arrtelcasa,arrcelular,arrdireccion,arrdepartamento,arrmunicipio,arrtrabajo,arrteltrabajo,arrprofesion,hijos);        
	}
	
	
	
///////////------------ UTILITARIAS ----------/////////////

	function MasFilasHijos(){
		padre = document.getElementById("dpi").value;
		swal({
			text: "Ingrese el numero de CUI de su hijo:",
			icon: "info",
			content: "input",
			button: {
			  text: "Aceptar",
			  closeModal: false,
			},
		}).then(cui => {
			if (!cui){
				swal("Ohoo!", "El CUI es un campos obligatorios...", "error");
			}else{
				var resultado = "";
				for (var i = 0; i < arrbloqueados.length; i++) {
					if(arrbloqueados[i].cui === cui) {
						swal("Nota", "Este alumno(a) se encuentra en una lista reservada en el Colegio.   No se girar\u00E1 boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.", "warning");
						swal.stopLoading();
						swal.close();
						return;
					}
				}
				xajax_Valida_CUI(cui,padre);
			}
		});
	}
	
	function quitarAlumno(cui){
		if(cui !== ""){
			swal({
				text: "\u00BFEst\u00E1 seguro de quitar a este alumno del listado?, perder\u00E1 todos los datos registrados de el durante la inscripci\u00F3n",
				icon: "warning",
				buttons: {
					cancel: "Cancelar",
					ok: { text: "Aceptar", value: true,},
				}
			}).then((value) => {
				switch (value) {
					case true:
						xajax_Quitar_Alumno(cui);
						break;
					default:
					  return;
				}
			});
		}
	}
	
	function CambiaCUI(){
		cui = document.getElementById('cui');
		cuinew = document.getElementById('cuinew');
		
		if(cui.value !="" && cuinew.value !=""){
			/// valida el CUI en el listado de bloqueados
			var resultado = "";
			for (var i = 0; i < arrbloqueados.length; i++) {
				if(arrbloqueados[i].cui === cuinew.value) {
					swal("Nota", "Este alumno(a) se encuentra en una lista reservada en el Colegio.   No se girar\u00E1 boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.", "warning");
					swal.stopLoading();
					swal.close();
					return;
				}
			}
			abrir();
			xajax_Modificar_CUI(cui.value,cuinew.value);
		}else{
			if(cuinew.value ===""){
				cuinew.className = "form-danger";
			}else{
				cuinew.className = "form-control";
			}
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-info";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	

	function trasladaNombres(fila){
		///Labels <h5>
			NomAdmin = document.getElementById("NomAdmin"+fila);
			NomSeg = document.getElementById("NomSeg"+fila);
			NomContrat = document.getElementById("NomContrat"+fila);
		//--- Nombre de hijos
			nombre = document.getElementById("nombre"+fila);
			apellido = document.getElementById("apellido"+fila);
			var nombres = nombre.value + " " + apellido.value;
		//--- Asignacion a etiquetas
			NomAdmin.innerHTML = nombres.toUpperCase();
			NomSeg.innerHTML = nombres.toUpperCase();
			NomContrat.innerHTML = nombres.toUpperCase();
	}	
	
	
	function DePadreHaciaCotrato(dpi,fila){
		if(dpi !== ""){
			abrir();
			xajax_Padre_Contrato(dpi,fila);
		}	
	}
	
	
	function valida_fecha(nombre,fila){
		inpfecha = document.getElementById(nombre+fila);
		dia = document.getElementById(nombre+'dia'+fila);
		mes = document.getElementById(nombre+'mes'+fila);
		anio = document.getElementById(nombre+'anio'+fila);
		//--
		diaN = parseInt(dia.value);
		mesN = parseInt(mes.value);
		anioN = parseInt(anio.value);
		//--
		var fecObj = new Date();
		var year = fecObj.getFullYear();
		//--
		var detalle = "";
		var contador = 0;
		if(diaN > 31){
			dia.className = "form-danger";
			detalle+= "<li>D&iacute;a fuera de rango.</li>";
			contador++;
		}else{
			dia.className = "form-control";
		}
		if(mesN > 12){
			mes.className = "form-danger";
			detalle+= "<li>Mes fuera de rango.</li>";
			contador++;
		}else{
			mes.className = "form-control";
		}
		if(anioN > year){
			anio.className = "form-danger";
			detalle = "<li>A&ntilde;o fuera de rango.</li>";
			contador++;
		}else{
			anio.className = "form-control";
		}
		
		if(contador > 0){
			abrir(); 
			msj = '<h5>Formato de fecha no valido!</h5><br> <ol>'+detalle+'</ol><br><br>';
			msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			document.getElementById('lblparrafo').innerHTML = msj;
		}else{
			if(dia.value !== "" && mes.value !== "" && anio.value !== ""){
				var fecha = diaN+"/"+mesN+"/"+anioN;
				inpfecha.value = fecha;
				xajax_Calcular_Edad(fecha,fila);
			}
		}
		
		return;
	}
	

/////////////////------------ CLIENTES  -------------------/////////////
	
	function Cliente(fila){
		nit = document.getElementById('nit'+fila);
		if(nit.value !=""){
			abrir();
			xajax_Show_Cliente(nit.value,fila);
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function JsonString(url){
		
		//let url = 'https://losolivos.inversionesd.com/SISTEM/API/API_inscripciones.php?request=bloqueados';
		fetch(url).then(res => res.json()).then((out) => {
		  //console.log('Checkout this JSON! ', out);
		  arrbloqueados = out;
		}).catch(err => {
			console.log('Error: ', err);	
		});
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
				return;
			}
		}
		return;
	}
