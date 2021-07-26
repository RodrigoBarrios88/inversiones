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
						
	
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// perfil FRMpassword ///////////////////////////////
	
	function comprueba_vacios(n,x){
		texto = n.value;
		if(texto === ""){ 
			document.getElementById(x).className="text-warning icon icon-warning";
		}else{
			document.getElementById(x).className="text-success icon icon-checkmark";
			var rojo = 0;
			var amar = 0;
			var verd = 0;
			var seguridad = seguridad_clave(texto);
			seguridad = parseInt(seguridad);
			
			if (seguridad <= 35) {
				rojo = parseInt(seguridad);
				document.getElementById("progress1").style.width = rojo + "%";
				document.getElementById("progress2").style.width = 0 + "%";
				document.getElementById("progress3").style.width = 0 + "%";
			}if (seguridad > 35 && seguridad <= 70) {
				rojo = 35;
				amar = parseInt(seguridad)-35;
				document.getElementById("progress1").style.width = rojo + "%";
				document.getElementById("progress2").style.width = amar + "%";
				document.getElementById("progress3").style.width = 0 + "%";
			}if (seguridad > 70) {
				rojo = 35;
				amar = 35;
				verd = parseInt(seguridad)-70;
				document.getElementById("progress1").style.width = rojo + "%";
				document.getElementById("progress2").style.width = amar + "%";
				document.getElementById("progress3").style.width = verd + "%";
			}
			
		}
	}

	function comprueba_iguales(n1,n2){
		texto1 = n1.value;
		texto2 = n2.value;
		if(texto1 === texto2){
			document.getElementById('pas2').className="text-success fa fa-check";
		}else{
			//alert(texto2);
			if(texto2 === ""){
				document.getElementById('pas2').className="text-warning fa fa-warning";
			}else{
				document.getElementById('pas2').className="text-danger fa fa-times";
			}
		}
	}
	
	function seguridad_clave(clave){
		var seguridad = 0;
		if(clave.length!==0){
			if (tiene_numeros(clave) && tiene_letras(clave)){
				  seguridad += 30;
			}
			if (tiene_minusculas(clave) && tiene_mayusculas(clave)){
				  seguridad += 30;
			}
			if (clave.length >= 4 && clave.length <= 5){
				  seguridad += 10;
			}else{
				if (clave.length >= 6 && clave.length <= 8){
					  seguridad += 30;
				}else{
					if (clave.length > 8){
						seguridad += 40;
					}
				}
			}
		}
		return seguridad;           
	}
	
///////// Pregunta Clave /////////////
	function ModificarPerfil(){
		dpi = document.getElementById("dpi");
		tipodpi = document.getElementById("tipodpi");
		nombre = document.getElementById("nombre");
		apellido = document.getElementById("apellido");
		fecnac = document.getElementById("fecnac");
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
		//--
		usuid = document.getElementById('usuid');
		nompant = document.getElementById('nompant');
		usu = document.getElementById('usu');
		preg = document.getElementById("preg");
		resp = document.getElementById("resp");
		//--
		pass1 = document.getElementById("pass1");
		pass2 = document.getElementById("pass2");
		
		if(dpi.value !== "" && tipodpi.value !== "" && nombre.value !=="" && apellido.value !=="" && fecnac.value !=="" && parentesco.value !=="" && nacionalidad.value !=="" && 
			ecivil.value !=="" && direccion.value !=="" && departamento.value !=="" && municipio.value !=="" && usu.value !== ""){
			////////------------------
			if(pass1.value === pass2.value){
				abrir();
				xajax_Modificar_Perfil(dpi.value,tipodpi.value,nombre.value,apellido.value,fecnac.value,parentesco.value,ecivil.value,nacionalidad.value,mail.value,
										telcasa.value,celular.value,direccion.value,departamento.value,municipio.value,trabajo.value,teltrabajo.value,profesion.value,
										usuid.value,nompant.value,usu.value,pass1.value,preg.value,resp.value);
			}else{
				pass1.className = " form-danger";
				pass2.className = " form-danger";
				msj = '<h5>La Contrase&ntilde;a y la Confirmaci&oacute;n no son iguales...</h5><br><br>';
				msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
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
			if(usu.value ===""){
				usu.className = "form-danger";
			}else{
				usu.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}	
	}

	
	function NewUser(){
		cod = document.getElementById('cod');
		padre = document.getElementById('padre');
		dpi = document.getElementById('dpi');
		nom = document.getElementById("nom");
		ape = document.getElementById("ape");
		parentesco = document.getElementById("parentesco");
		mail = document.getElementById("mail");
		tel = document.getElementById("tel");
						
		if(cod.value !== "" && padre.value !== ""  && dpi.value !== "" && mail.value !== "" && tel.value !== "" && nom.value !== "" && ape.value !== "" && parentesco.value !== ""){
			filas = parseInt(document.getElementById("filas").value);
			if(filas > 0){
				var arrhijos = new Array([]);
				var C = 1; // contador de chequeados
				for(var i = 1; i <= filas; i++){
					hijo = document.getElementById("hijo"+i);
					if(hijo.checked){
						arrhijos[C] = hijo.value;
						C++;
					}
				}
				C--; //quita la ultima vuelta
				abrir();
				xajax_Nuevo_Usuario(padre.value,dpi.value,nom.value,ape.value,parentesco.value,tel.value,mail.value,arrhijos,C);
			}else{
				swal("Ohoo!", "No hay hijos a asignar...", "info");
			}
		}else{
			if(dpi.value === ""){
				dpi.className = " form-danger";
			}else{
				dpi.className = " form-control";
			}
			if(nom.value === ""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(ape.value === ""){
				ape.className = " form-danger";
			}else{
				ape.className = " form-control";
			}
			if(parentesco.value === ""){
				parentesco.className = " form-danger";
			}else{
				parentesco.className = " form-control";
			}
			if(mail.value === ""){
				mail.className = " form-control text-libre alert-danger";
			}else{
				mail.className = " form-control text-libre";
			}
			if(tel.value === ""){
				tel.className = " form-danger";
			}else{
				tel.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	/////////////////////////////////////////////////////////// FAMILIA ///////////////////////////////////////////////////////////
	
	function datosFamilia(dpi){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/perfil/familia.php",{dpi:dpi}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ModificarFamilia(){
		dpi = document.getElementById("dpi");
		tipodpi = document.getElementById("tipodpi");
		nombre = document.getElementById("nombre");
		apellido = document.getElementById("apellido");
		fecnac = document.getElementById("fecnac");
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
		
		if(dpi.value !== "" && tipodpi.value !== "" && nombre.value !=="" && apellido.value !=="" && fecnac.value !=="" && parentesco.value !=="" && nacionalidad.value !=="" && ecivil.value !=="" && direccion.value !=="" && departamento.value !=="" && municipio.value !==""){
			abrir();
			xajax_Modificar_Familiar(dpi.value,tipodpi.value,nombre.value,apellido.value,fecnac.value,parentesco.value,ecivil.value,nacionalidad.value,mail.value,telcasa.value,celular.value,direccion.value,departamento.value,municipio.value,trabajo.value,teltrabajo.value,profesion.value);
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
			if(exdoc === 1){
				myform = document.forms.f1;
				myform.submit();
			}else{
				if(exdoc !== 1){
					doc.className = "form-danger";
				}else{
					doc.className = "form-control";
				}
				msj+= '<div class="alert alert-danger alert-dismissable" style="width:100%" >';
				msj+= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				msj+= 'Este archivo no es extencion .jpg ó .png';
				msj+= '</div>';
				document.getElementById('alerta').innerHTML = msj;
				swal("Ohoo!", "Este archivo no es extencion .jpg ó .png...", "error");
			}		
		}else{
			if(doc.value ===""){
				doc.className = "form-danger";
			}else{
				doc.className = "form-control";
			}
			msj+= '<div class="alert alert-danger alert-dismissable" style="width:100%" >';
			msj+= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			msj+= 'Debe llenar los Campos Obligatorios';
			msj+= '</div>';
			document.getElementById('alerta').innerHTML = msj;
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
		  //recupero la extensión de este nombre de archivo
		  extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		  //alert (extension);
		  //compruebo si la extensión está entre las permitidas
		  permitida = false;
			if (".jpg" === extension || ".jpeg" === extension || ".png" === extension) {
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
	
	
	function Bloquear(usuario,dispositivo){
		swal({
			title: "\u00BFEsta Seguro?",
			text: "\u00BFDesea bloquear este dispositivo?, no prodr\u00E1 ingresar al App desde el...",
			icon: "warning",
			dangerMode: true,
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Dispositivo(usuario,dispositivo,0);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Reactivar(usuario,dispositivo){
		swal({
			title: "\u00BFEsta Seguro?",
			text: "\u00BFDesea Re-Activar este dispositivo?, dar\u00E1 acceso a la aplicaci\u00F3n...",
			icon: "info",
			dangerMode: true,
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Dispositivo(usuario,dispositivo,1);
					break;
				default:
				  return;
			}
		});
	}	