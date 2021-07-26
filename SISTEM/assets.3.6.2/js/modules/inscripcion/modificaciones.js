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
	
	function ActualizaAlumno(){
			
		contrato = document.getElementById("contrato");
		cuinew = document.getElementById("cuinew");
		cuiold = document.getElementById("cuiold");
		codigo = document.getElementById("codigo");
		tipocui = document.getElementById("tipocui");
		nombre = document.getElementById("nombre");
		apellido = document.getElementById("apellido");
		genero = document.getElementById("genero");
		fecnac = document.getElementById("fecnac");
		nacionalidad = document.getElementById("nacionalidad");
		religion = document.getElementById("religion");
		idioma = document.getElementById("idioma");
		mail = document.getElementById("mail");
		sangre = document.getElementById("sangre");
		alergia = document.getElementById("alergico");
		emergencia = document.getElementById("emergencia");
		emetel = document.getElementById("emertel");
				
		if(cuinew.value !=="" && tipocui.value !=="" &&  nombre.value !=="" && apellido.value !=="" && genero.value !=="" && fecnac.value !=="" && sangre.value !=="" && emergencia.value !=="" && emetel.value !==""){
			var codigoUnico = cuinew.value;
			if(codigoUnico.length < 13){
				cuinew.className = "form-danger";
				swal("Ohoo!", "El C\u00F3digo de Identificaci\u00F3n Unico (CUI) debe contener 13 caracteres numericos.  Este c\u00F3digo es proporcionado y asignado en el Acta de Nacimiento por el RENAP.", "error");
				return;
			}else{
				xajax_Actualiza_Alumno(cuinew.value,cuiold.value,tipocui.value,codigo.value,nombre.value,apellido.value,genero.value,fecnac.value,nacionalidad.value,religion.value,idioma.value,mail.value,sangre.value,alergia.value,emergencia.value,emetel.value);
			}
		}else{
			if(cuinew.value ===""){
				cuinew.className = "form-danger";
			}else{
				cuinew.className = "form-control";
			}
			if(cuiold.value ===""){
				cuiold.className = "form-danger";
			}else{
				cuiold.className = "form-control";
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
			if(sangre.value ===""){
				sangre.className = "form-danger";
			}else{
				sangre.className = "form-control";
			}
			if(emergencia.value ===""){
				emergencia.className = "form-danger";
			}else{
				emergencia.className = "form-control";
			}
			if(emetel.value ===""){
				emetel.className = "form-danger";
			}else{
				emetel.className = "form-control";
			}
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ActualizaGrado(){
		
		cuinew = document.getElementById("cuinew");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		
		if(cuinew.value !=="" && nivel.value !=="" && grado.value !==""){
			xajax_Actualiza_Grado(cuinew.value,nivel.value,grado.value);
		}else{
			//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
			if(cuinew.value ===""){
				cuinew.className = "form-danger";
			}else{
				cuinew.className = "form-control";
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
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ActualizaNit(){
		
		cuinew = document.getElementById("cuinew");
		cli = document.getElementById("cli");
		cliente = document.getElementById("cliente");
		
		if(cuinew.value !=="" && cli.value !=="" && cliente.value !==""){
			xajax_Actualiza_Nit(cuinew.value,cli.value);
		}else{
			//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
			if(cuinew.value ===""){
				cuinew.className = "form-danger";
			}else{
				cuinew.className = "form-control";
			}
			if(cliente.value ===""){
				cliente.className = "form-danger";
			}else{
				cliente.className = "form-control";
			}
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ActualizaSeguro(){
		
		cuinew = document.getElementById("cuinew");
		//-- radiobutton
		var segsi = document.getElementById("segurosi");
		var segno = document.getElementById("segurono");
		if(segsi.checked){
			seguro = 1;
		}else if(segno.checked){
			seguro = 0;
		}else{
			seguro = "";
		}
		//--
		poliza = document.getElementById("poliza");
		asegura = document.getElementById("aseguradora");
		plan = document.getElementById("plan");
		asegurado = document.getElementById("asegurado");
		instruc = document.getElementById("instrucciones");
		comment = document.getElementById("comentarios");
		//--
		
		if(cuinew.value !=="" && seguro.value !==""){
			xajax_Actualiza_Seguro(cuinew.value,seguro,poliza.value,asegura.value,plan.value,asegurado.value,instruc.value,comment.value);
		}else{
			if(cuinew.value ===""){
				cuinew.className = "form-danger";
			}else{
				cuinew.className = "form-control";
			}
			if(seguro === ""){
				document.getElementById("labelsi").className = "radio-danger" ; 
				document.getElementById("labelno").className = "radio-danger" ; 
			}else{
				document.getElementById("labelsi").className = ""; 
				document.getElementById("labelno").className = ""; 
			}
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	
	function ActualizaContrato(){
		
		xcontrato = document.getElementById("contrato");
		xcuinew = document.getElementById("cuinew");
		xdpi = document.getElementById("contradpi");
		xtipodpi = document.getElementById("contratipodpi");
		xnomc = document.getElementById("contranombre");
		xapec = document.getElementById("contraapellido");
		xfecnacc = document.getElementById("contrafecnac");
		xparentesco = document.getElementById("contraparentesco");
		xecivil = document.getElementById("contraecivil");
		xnacionalidad = document.getElementById("contranacionalidad");
		xmail = document.getElementById("contramail");
		xdireccion = document.getElementById("contradireccion");
		xdepartamento = document.getElementById("contradep");
		xmunicipio = document.getElementById("contramun");
		xtelcasa = document.getElementById("contratelcasa");
		xcelular = document.getElementById("contracelular");
		xtrabajo = document.getElementById("contratrabajo");
		xteltrabajo = document.getElementById("contrateltrabajo");
		xprofesion = document.getElementById("contraprofesion");
				
		if(xcontrato.value !=="" && xcuinew.value !=="" && xdpi.value !=="" &&  xtipodpi.value !=="" && xnomc.value !=="" && xapec.value !=="" && xfecnacc.value !=="" && xparentesco.value !=="" && xecivil.value !=="" && xnacionalidad.value !=="" && xdireccion.value !=="" && xdepartamento.value !=="" && xmunicipio.value !=="" && xtrabajo.value !=="" && xprofesion.value !==""){                            
			xajax_Actualiza_Datos_Contrato(xcontrato.value,xcuinew.value,xdpi.value,xtipodpi.value,xnomc.value,xapec.value,xfecnacc.value,xparentesco.value,xecivil.value,xnacionalidad.value,xmail.value,xtelcasa.value,xcelular.value,xdireccion.value,xdepartamento.value,xmunicipio.value,xtrabajo.value,xteltrabajo.value,xprofesion.value);  
		}else{
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
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
		
	}
	
	
	function CambiaCUI(){
		cui = document.getElementById('cui');
		cuinew = document.getElementById('cuinew');
		
		if(cui.value !="" && cuinew.value !=""){
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
	
	
///////////------------ UTILITARIAS ----------/////////////

	
	function valida_fecha(nombre){
		inpfecha = document.getElementById(nombre);
		dia = document.getElementById(nombre+'dia');
		mes = document.getElementById(nombre+'mes');
		anio = document.getElementById(nombre+'anio');
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
			dia.className = "form-date-danger";
			detalle+= "D\u00EDa fuera de rango.";
			contador++;
		}else{
			dia.className = "form-date";
		}
		if(mesN > 12){
			mes.className = "form-date-danger";
			detalle+= "Mes fuera de rango.";
			contador++;
		}else{
			mes.className = "form-date";
		}
		if(anioN > year){
			anio.className = "form-date-danger";
			detalle = "A\u00F1o fuera de rango.";
			contador++;
		}else{
			anio.className = "form-date";
		}
		
		if(contador > 0){
			swal("Formato de fecha no valido!", detalle, "error");
		}else{
			if(dia.value !== "" && mes.value !== "" && anio.value !== ""){
				var fecha = diaN+"/"+mesN+"/"+anioN;
				inpfecha.value = fecha;
				xajax_Calcular_Edad(fecha);
			}
		}
		
		return;
	}
	

/////////////////------------ CLIENTES  -------------------/////////////

	function validaCliente(nit){
		swal({
			text: "\u00BFEste Cliente no existe, desea agregarlo?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					document.getElementById("nit").value = "";
					document.getElementById("cliente").value = "";
					NewCliente(nit);
					break;
				default:
					cerrar();	
					return;
			}
		});
	}
	
	function Cliente(fila){
		nit = document.getElementById('nit');
		if(nit.value !=""){
			abrir();
			xajax_Show_Cliente(nit.value);
		}
	}
	
	function ResetCli(fila){
		nom = document.getElementById('cliente');
		nit = document.getElementById('nit');
		prov = document.getElementById('cli');
		nom.value = "";
		nit.value = "";
		prov.value = "";
	}
	
	function NewCliente(nit){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/new_cliente.php",{nit:nit}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function GrabarCliente(){
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !="" && nom.value !="" && direc.value != ""){
			abrirMixPromt();
			xajax_Grabar_Cliente(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value);
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
	
	function ModCliente(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/mod_cliente.php",{codigo:codigo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ModificarCliente(){
		codigo = document.getElementById('cod1');
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !="" && nom.value !="" && direc.value != ""){
			abrirMixPromt();
			xajax_Modificar_Cliente(codigo.value,nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value);
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