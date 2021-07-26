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
	
	function pageprint(){
		boton = document.getElementById("print");
		boton.className = "hidden";
		window.print();
		boton.className = "btn btn-default";
	}
						
	function Grabar(){
		var bandera_alumnos = 0;
		var bandera_padres = 0;
		//----
		alumnos = parseInt(document.getElementById("alumnos").value);
		if (alumnos > 0) {
			var arrcui = new Array([]);
			var arrcodigo = new Array([]);
			var arrnombre = new Array([]);
			var arrapellido = new Array([]);
			var arrgenero = new Array([]);
			var arrfecnac = new Array([]);
			var arrpensum = new Array([]);
			var arrnivel = new Array([]);
			var arrgrado = new Array([]);
			var arrseccion = new Array([]);
			var arrnit = new Array([]);
			var arrclinombre = new Array([]);
			for(i = 1; i <= alumnos; i++){
				xcui = document.getElementById("cui"+i);
				xcodigo = document.getElementById("codigo"+i);
				xnombre = document.getElementById("nombre"+i);
				xapellido = document.getElementById("apellido"+i);
				xgenero = document.getElementById("genero"+i);
				xfecnac = document.getElementById("fecnac"+i);
				xpensum = document.getElementById("pensum"+i);
				xnivel = document.getElementById("nivel"+i);
				xgrado = document.getElementById("grado"+i);
				xseccion = document.getElementById("seccion"+i);
				xnit = document.getElementById("nit"+i);
				xclinombre = document.getElementById("clinombre"+i);
				if(xcui.value ==="" || xnombre.value ==="" || xapellido.value ==="" || xgenero.value ==="" || xfecnac.value ==="" || xnivel.value ==="" || xgrado.value ==="" || xnit.value ==="" || xclinombre.value ===""){
					bandera_alumnos++;
				} 
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				if(xcui.value ===""){
					xcui.className = "form-danger";
				}else{
					xcui.className = "form-control";
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
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				arrcui[i] = xcui.value;
				arrcodigo[i] = xcodigo.value;
				arrnombre[i] = xnombre.value;
				arrapellido[i] = xapellido.value;
				arrgenero[i] = xgenero.value;
				arrfecnac[i] = xfecnac.value;
				arrpensum[i] = xpensum.value;
				arrnivel[i] = xnivel.value;
				arrgrado[i] = xgrado.value;
				arrseccion[i] = xseccion.value;
				arrnit[i] = xnit.value;
				arrclinombre[i] = xclinombre.value;
			}
		}else{
			swal("Ohoo!", "Al menos un aulumno debe de ser inscrito...", "warning");
		}
		//----
		padres = parseInt(document.getElementById("padres").value);
		if (padres > 0) {
			var arrdpi = new Array([]);
			var arrnom = new Array([]);
			var arrape = new Array([]);
			var arrparent = new Array([]);
			var arrtel = new Array([]);
			var arrmail = new Array([]);
			var arrexist = new Array([]);
			for(i = 1; i <= padres; i++){
				xdpi = document.getElementById("dpi"+i);
				xnom = document.getElementById("nom"+i);
				xape = document.getElementById("ape"+i);
				xparent = document.getElementById("parentesco"+i);
				xtel = document.getElementById("tel"+i);
				xmail = document.getElementById("mail"+i);
				xexist = document.getElementById("existe"+i);
				if(xdpi.value ==="" || xnom.value ==="" || xape.value ==="" || xtel.value ==="" || xmail.value ===""){
					bandera_padres++;
				}
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				if(xdpi.value ===""){
					xdpi.className = "form-danger";
				}else{
					xdpi.className = "form-control";
				}
				if(xnom.value ===""){
					xnom.className = "form-danger";
				}else{
					xnom.className = "form-control";
				}
				if(xape.value ===""){
					xape.className = "form-danger";
				}else{
					xape.className = "form-control";
				}
				if(xparent.value ===""){
					xparent.className = "form-danger";
				}else{
					xparent.className = "form-control";
				}
				if(xtel.value ===""){
					xtel.className = "form-danger";
				}else{
					xtel.className = "form-control";
				}
				if(xmail.value ===""){
					xmail.className = "form-danger text-libre";
				}else{
					xmail.className = "form-control text-libre";
				}
				//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
				arrdpi[i] = xdpi.value;
				arrnom[i] = xnom.value;
				arrape[i] = xape.value;
				arrparent[i] = xparent.value;
				arrtel[i] = xtel.value;
				arrmail[i] = xmail.value;
				arrexist[i] = xexist.value;
			}
		}else{
			swal("Ohoo!", "Debe de tener al menos un padre o responsable...", "warning");
		}
		if(bandera_alumnos === 0 && bandera_padres === 0){
			abrir();
			xajax_Grabar_Alumno(arrcui,arrcodigo,arrnombre,arrapellido,arrgenero,arrfecnac,arrpensum,arrnivel,arrgrado,arrseccion,arrnit,arrclinombre,alumnos,arrdpi,arrnom,arrape,arrparent,arrtel,arrmail,arrexist,padres);
		}else{
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cui = document.getElementById("cui");
		tipocui = document.getElementById("tipocui");
		codigo = document.getElementById("codigo");
		nombre = document.getElementById("nombre");
		apellido = document.getElementById("apellido");
		fecnac = document.getElementById("fecnac");
		genero = document.getElementById("genero");
		//--
		religion = document.getElementById("religion");
		nacionalidad = document.getElementById("nacionalidad");
		idioma = document.getElementById("idioma");
		sangre = document.getElementById("sangre");
		alergia = document.getElementById("alergia");
		emergencia = document.getElementById("emergencia");
		emetel = document.getElementById("emetel");
		recoge = document.getElementById("recoge");
		redsoc = document.getElementById("redsoc");
		mail = document.getElementById("mail");
		//--
		segsi = document.getElementById("segurosi");
		segno = document.getElementById("segurono");
		var seguro;
		if(segsi.checked){
			seguro = 1;
		}else if(segno.checked){
			seguro = 0;
		}else{
			seguro = "";
		}
		poliza = document.getElementById("poliza");
		asegura = document.getElementById("aseguradora");
		plan = document.getElementById("plan");
		asegurado = document.getElementById("asegurado");
		instruc = document.getElementById("instrucciones");
		comment = document.getElementById("comentarios");
		//-
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		nit = document.getElementById("nit");
		clinombre = document.getElementById("clinombre");
		clidireccion = document.getElementById("clidireccion");
		if(cui.value !=="" && tipocui.value !=="" && nombre.value !=="" && apellido.value !=="" && genero.value !=="" && fecnac.value !=="" && nivel.value !=="" && grado.value !=="" && nit.value !=="" && clinombre.value !=="" && clidireccion.value !==""){
			abrir();
			xajax_Modificar_Alumno(cui.value,tipocui.value,codigo.value,nombre.value,apellido.value,genero.value,fecnac.value,religion.value,nacionalidad.value,idioma.value,sangre.value,alergia.value,emergencia.value,emetel.value,mail.value,recoge.value,redsoc.value,pensum.value,nivel.value,grado.value,seccion.value,nit.value,clinombre.value,clidireccion.value,seguro,poliza.value,asegura.value,plan.value,asegurado.value,instruc.value,comment.value);   
		}else{
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-control";
			}
			if(tipocui.value ===""){
				tipocui.className = "form-danger";
			}else{
				tipocui.className = "form-control";
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
			if(genero.value ===""){
				genero.className = "form-danger";
			}else{
				genero.className = "form-control";
			}
			if(fecnac.value ===""){
				fecnac.className = "form-danger";
			}else{
				fecnac.className = "form-control";
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
			if(nit.value ===""){
				nit.className = "form-danger";
			}else{
				nit.className = "form-control";
			}
			if(clinombre.value ===""){
				clinombre.className = "form-danger";
			}else{
				clinombre.className = "form-control";
			}
			if(clidireccion.value ===""){
				clidireccion.className = "form-danger";
			}else{
				clidireccion.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function AgregarPadre(){
		cui = document.getElementById("cui");
		dpi = document.getElementById("dpi");
		nom = document.getElementById("nom");
		ape = document.getElementById("ape");
		parent = document.getElementById("parentesco");
		tel = document.getElementById("tel");
		mail = document.getElementById("mail");
		exist = document.getElementById("existe");
		
		if(dpi.value !=="" && nom.value !=="" && ape.value !=="" && parent.value !=="" && tel.value !=="" && mail.value !==""){
			xajax_Agregar_Padre(cui.value,dpi.value,nom.value,ape.value,parent.value,tel.value,mail.value,exist.value);
		}else{
			if(dpi.value ===""){
				dpi.className = "form-danger";
			}else{
				dpi.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(ape.value ===""){
				ape.className = "form-danger";
			}else{
				ape.className = "form-control";
			}
			if(parent.value ===""){
				parent.className = "form-danger";
			}else{
				parent.className = "form-control";
			}
			if(tel.value ===""){
				tel.className = "form-danger";
			}else{
				tel.className = "form-control";
			}
			if(mail.value ===""){
				mail.className = "form-danger";
			}else{
				mail.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}	
	}
	
	
	function Deshabilita_Alumno(cui){
		swal({
			text: "\u00BFEsta seguro de Inhabilitar este(a) Alumn(a)?, No podra ser usado con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Alumno(cui,2);
					break;
				default:
					return;
			}
		});
	}
	
	function Habilita_Alumno(cui){
		swal({
			text: "\u00BFEsta seguro de Re-Activada a este(a) Alumn(a)?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Alumno(cui,1);
					break;
				default:
					return;
			}
		});
	}
	
	function Desligar_Padre(alumno,padre){
		swal({
			text: "\u00BFEsta seguro de desligar a este padre/madre o encargado de este(a) Alumn(a)?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Desligar_Padre(alumno,padre);
					break;
				default:
					return;
			}
		});
	}
	
///////////--------- Asignacion a Grupos-----//////////

	function Busca_Grupos_Alumno(cui,area){
		if (cui !== "") {
			xajax_Grupos_Alumno(cui,area);
		}
	}
	
	function Asigna_Grupos_Alumno(){
		cui = document.getElementById("cui");
		area = document.getElementById("area");
		filas =  document.getElementById("xasignarrows").value;
		if(filas > 0) {
			if(cui.value) {
				arrgrupos = new Array([]);
				var cuantos = 0;
				for(i = 1; i <= filas; i++){
					chk = document.getElementById("xasignar"+i);
					if(chk.checked) {
						arrgrupos[cuantos] = chk.value;
						cuantos++;
					}
				}
				if(cuantos > 0) {
					abrir();
					xajax_Graba_Alumno_Grupos(cui.value,area.value,arrgrupos,cuantos);
				}else{
					swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
				}
			}else{
				swal("Ohoo!", "Debe seleccionar almenos un (01) Alumno...", "error");
			}	
		}else{
			swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
		}
	}
	
	
	
	function Quitar_Grupos_Alumno(){
		cui = document.getElementById("cui");
		area = document.getElementById("area");
		filas =  document.getElementById("asignadosrows").value;
		if(filas > 0) {
			if(area.value) {
				arrgrupos = new Array([]);
				var cuantos = 0;
				for(i = 1; i <= filas; i++){
					chk = document.getElementById("asignados"+i);
					if(chk.checked) {
						arrgrupos[cuantos] = chk.value;
						cuantos++;
					}
				}
				if(cuantos > 0) {
					abrir();
					xajax_Quitar_Alumno_Grupos(cui.value,area.value,arrgrupos,cuantos);
				}else{
					swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
				}
			}else{
				swal("Ohoo!", "Debe seleccionar almenos el area...", "error");
			}	
		}else{
			swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
		}
	}
	
	
///////////------------ Padres----------/////////////

	function MasFilasHijos(){
		hijos = parseInt(document.getElementById("alumnos").value);
		if (hijos > 0) {
			hijos++;
			document.getElementById("alumnos").value = hijos;
			Submit();
		}
	}
	
	function MenosFilasHijos(){
		hijos = parseInt(document.getElementById("alumnos").value);
		if (hijos > 1) {
			hijos--;
			document.getElementById("alumnos").value = hijos;
			Submit();
		}
	}

	function MasFilasPadres(){
		padres = parseInt(document.getElementById("padres").value);
		if (padres > 0) {
			padres++;
			document.getElementById("padres").value = padres;
			Submit();
		}
	}
	
	function MenosFilasPadres(){
		padres = parseInt(document.getElementById("padres").value);
		if (padres > 1) {
			padres--;
			document.getElementById("padres").value = padres;
			Submit();
		}
	}
	
	


/////////////////------------ CLIENTES  -------------------/////////////
	
	function Cliente(fila){
		nit = document.getElementById('nit'+fila);
		if(nit.value !=""){
			abrir();
			xajax_Show_Cliente(nit.value,fila);
		}
	}
	
	function ResetCli(fila){
		nom = document.getElementById('cliente'+fila);
		nit = document.getElementById('nit'+fila);
		cli = document.getElementById('cli'+fila);
		nom.value = "";
		nit.value = "";
		cli.value = "";
	}
	
	function confirmNewCliente(nit,fila){
		swal({
			title: "Este Cliente no existe",
			text: "\u00BFDesea agregarlo?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					NewCliente(nit,fila);
					break;
				default:
					return;
			}
		});
	}
	
	function NewCliente(nit,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/new_cliente_inscripcion.php",{nit:nit,fila:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function editCliente(fila){
		var codigo = document.getElementById('cli'+fila).value;
		if(codigo !== ""){
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/cliente/mod_cliente.php",{codigo:codigo,fila:fila}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
		}else{
			nit = document.getElementById("nit"+fila);
			if(codigo.value ===""){
				nit.className = "form-warning";
			}else{
				nit.className = "form-control";
			}
			swal("Ohoo!", "No hay ning\u00FAn cliente seleccionado a\u00FAn...", "error");
		}

	}
	
	
	function SearchCliente(fila){
		//alert(fila);
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/busca_cliente_inscripcion.php",{filaalumno:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function SeleccionarCliente(fila){
		cod = document.getElementById('Cpcod'+fila);
		nit = document.getElementById('Cpnit'+fila);
		nom = document.getElementById('Cpnom'+fila);
		//--
		filaalumno = document.getElementById('filaalumno').value; //detecta al alumno que se le esta configurando la facturaci\u00F3n
		inpcod = document.getElementById('cli'+filaalumno);
		inpnit = document.getElementById('nit'+filaalumno);
		inpnom = document.getElementById('cliente'+filaalumno);
		//---
		inpcod.value = cod.value;
		inpnit.value = nit.value;
		inpnom.value = nom.value;
		cerrar();
	}
	
	function GrabarCliente(fila){
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !="" && nom.value !="" && direc.value != ""){
			xajax_Grabar_Cliente(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,fila);
		}else{
			if(nit.value ===""){
				nit.className = "form-danger";
			}else{
				nit.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(direc.value ===""){
				direc.className = "form-danger";
			}else{
				direc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarCliente(fila){
		codigo = document.getElementById('cod1');
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !="" && nom.value !="" && direc.value != ""){
			xajax_Modificar_Cliente(codigo.value,nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,fila);
		}else{
			if(nit.value ===""){
				nit.className = "form-danger";
			}else{
				nit.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(direc.value ===""){
				direc.className = "form-danger";
			}else{
				direc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
///////// Fotografia /////////////
	
	function FotoJs(){
		inpfile = document.getElementById("doc");
		inpfile.click();
	}
	
	
	function Cargar(){
		var msj = '';
		doc = document.getElementById("doc");
		if(doc.value !== ""){
			exdoc = comprueba_extension(doc.value);
			if(exdoc == 1){
				myform = document.forms.f1;
				myform.submit();
			}else{
				if(exdoc != 1){
					doc.className = "form-danger";
				}else{
					doc.className = "form-control";
				}
				swal("Ohoo!", "Este archivo no es .jpg o .png", "error");
			}		
		}else{
			if(doc.value ===""){
				doc.className = "form-danger";
			}else{
				doc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function comprueba_extension(archivo) {
		//mierror = "";
		if (!archivo) {
		  //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
		  // mierror = "No has seleccionado ningún archivo";
		  alert("No archivo");
		}else{
		  //recupero la extensi\u00F3n de este nombre de archivo
		  extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		  //alert (extension);
		  //compruebo si la extensi\u00F3n está entre las permitidas
		  permitida = false;
			if (".jpg" == extension || ".jpeg" == extension || ".png" == extension) {
			 permitida = true;
			}
		  if (!permitida) {
			return 0;
		  }else{
			  //todo correcto!
			 return 1;
		  }
		}
		return 0;
	} 
	

/////////////////------------ FICHA PSICOPEDAGOGICA  -------------------/////////////
	
	function NuevoComentario(alumno){
		//alert(fila);
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/alumno/nuevo_comentario.php",{cui:alumno}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function EditaComentario(codigo,alumno){
		//alert(fila);
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/alumno/edita_comentario.php",{codigo:codigo,cui:alumno}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function GrabarComentario(){
		cui = document.getElementById("cui");
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		coment = document.getElementById("coment");
		
		if(cui.value !=="" && pensum.value !=="" && nivel.value !=="" && grado.value !=="" && seccion.value !=="" && coment.value !==""){
			xajax_Grabar_Comentario(cui.value, pensum.value, nivel.value, grado.value, seccion.value, coment.value);
		}else{
			if(coment.value ===""){
				coment.className = " form-danger";
			}else{
				coment.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarComentario(){
		cod = document.getElementById('cod');
		cui = document.getElementById("cui");
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		seccion = document.getElementById("seccion");
		coment = document.getElementById("coment");
		
		if(cod.value !=="" && cui.value !=="" && pensum.value !=="" && nivel.value !=="" && grado.value !=="" && seccion.value !=="" && coment.value !==""){
			xajax_Modificar_Comentario(cod.value, cui.value, coment.value);
		}else{
			if(coment.value ===""){
				coment.className = " form-danger";
			}else{
				coment.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Comentario(cod,cui){
		swal({
			text: "\u00BFEsta seguro de eliminar esta Comentario?, No podra ser visualizado con esta situaci\u00F3n...?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Comentario(cod,cui);
					break;
				default:
					return;
			}
		});
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
			swal("Ohoo!", "Formato de fecha no valido!", "error");
		}else{
			if(dia.value !== "" && mes.value !== "" && anio.value !== ""){
				var fecha = diaN+"/"+mesN+"/"+anioN;
				inpfecha.value = fecha;
				xajax_Calcular_Edad(fecha,fila);
			}
		}
		
		return;
	}
	
	