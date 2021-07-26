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

	
	function Grabar(){
		ciu = document.getElementById('cui');
		nom = document.getElementById('nom');
		ape = document.getElementById("ape");
		parentesco = document.getElementById("parentesco");
		mail = document.getElementById('mail');
		tel = document.getElementById("tel");
		dir = document.getElementById('dir');
		trab = document.getElementById("trab");
		
		if(cui.value !=="" && nom.value !=="" && ape.value !== "" && parentesco.value !== "" && tel.value !== "" && mail.value !== ""){
			abrir();
			xajax_Grabar_Padre(cui.value,nom.value,ape.value,parentesco.value,tel.value,mail.value,dir.value,trab.value);
		}else{
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-control";
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
			if(parentesco.value ===""){
				parentesco.className = "form-danger";
			}else{
				parentesco.className = "form-control";
			}
			if(tel.value ===""){
				tel.className = "form-danger";
			}else{
				tel.className = "form-control";
			}
			if(mail.value ===""){
				mail.className = "form-danger text-libre";
			}else{
				mail.className = "form-control text-libre";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cui = document.getElementById('cui');
		nom = document.getElementById('nom');
		ape = document.getElementById("ape");
		parentesco = document.getElementById("parentesco");
		mail = document.getElementById('mail');
		tel = document.getElementById("tel");
		dir = document.getElementById('dir');
		trab = document.getElementById("trab");
		
		if(nom.value !=="" && ape.value !== "" && parentesco.value !== "" && tel.value !== "" && mail.value !== ""){
			abrir();
			xajax_Modificar_Padre(cui.value,nom.value,ape.value,parentesco.value,tel.value,mail.value,dir.value,trab.value);
		}else{
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-control";
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
			if(parentesco.value ===""){
				parentesco.className = "form-danger";
			}else{
				parentesco.className = "form-control";
			}
			if(tel.value ===""){
				tel.className = "form-danger";
			}else{
				tel.className = "form-control";
			}
			if(mail.value ===""){
				mail.className = "form-danger text-libre";
			}else{
				mail.className = "form-control text-libre";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function redirigeEdicion(){
		cui = document.getElementById('cui');
		boton = document.getElementById('btn-edit');
		//alert(boton.disabled);
		if(cui.value !== "" && boton.disabled === false){
			xajax_Redirige_Editar(cui.value);
		}else{
			swal("Ohoo!", "Seleccione a un padre...", "warning");
		}
	}
	
	
	function ModificarCompleto(){
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
		
		if(dpi.value !== "" && tipodpi.value !== "" && nombre.value !=="" && apellido.value !=="" && fecnac.value !=="" && parentesco.value !=="" && nacionalidad.value !=="" && ecivil.value !=="" && direccion.value !=="" && departamento.value !=="" && municipio.value !=="" && trabajo.value !=="" && profesion.value !==""){
				abrir();
				xajax_Modificar_Completo(dpi.value,tipodpi.value,nombre.value,apellido.value,fecnac.value,parentesco.value,ecivil.value,nacionalidad.value,mail.value,telcasa.value,celular.value,direccion.value,departamento.value,municipio.value,trabajo.value,teltrabajo.value,profesion.value);
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
	
	
	function Deshabilita_Padre(cui){
		swal({
			text: "\u00BFEsta seguro de inhabilitar este(a) Padre/Madre o Encargado(a)?, No podra ser listado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Padre(cui,0);
					break;
				default:
					return;
			}
		});
	}
	
	
	function Habilita_Padre(cui){
		swal({
			text: "\u00BFEsta seguro de Re-Activar este(a) Padre/Madre o Encargado(a)?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Padre(cui,1);
					break;
				default:
					return;
			}
		});
	}
	
	
	function invitarCorreo(cui){
		swal({
			text: "\u00BFEsta seguro de enviar un correo de invitaci\u00F3n a este(a) Padre/Madre o Encargado(a)?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Send_Mail(cui);
					break;
				default:
					return;
			}
		});
	}
	
	
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
			dia.className = "form-danger";
			detalle+= "<li>D&iacute;a fuera de rango.</li>";
			contador++;
		}else{
			dia.className = "form-date";
		}
		if(mesN > 12){
			mes.className = "form-danger";
			detalle+= "<li>Mes fuera de rango.</li>";
			contador++;
		}else{
			mes.className = "form-date";
		}
		if(anioN > year){
			anio.className = "form-danger";
			detalle = "<li>A&ntilde;o fuera de rango.</li>";
			contador++;
		}else{
			anio.className = "form-date";
		}
		
		if(contador > 0){
			abrir(); 
			swal("Ohoo!", "Formato de fecha no valido!", "error");
		}else{
			if(dia.value !== "" && mes.value !== "" && anio.value !== ""){
				var fecha = diaN+"/"+mesN+"/"+anioN;
				inpfecha.value = fecha;
				//xajax_Calcular_Edad(fecha);
			}
		}
		
		return;
	}
