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
						
	function TipoTarget(){
		target = document.getElementById('target');
		tipo = document.getElementById('tipotarget');
		
		if(target.value === "SELECT"){
			tipo.removeAttribute("disabled");
			if(target.value !== "" && tipo.value !== ""){
				xajax_Target_Grupos(target.value,tipo.value);
			}
		}else{
			tipo.value = "0";
			tipo.setAttribute("disabled","disabled");
			xajax_Target_Grupos(target.value,tipo.value);
		}
	}
	
	function Grabar(){
		target = document.getElementById('target');
		tipo = document.getElementById('tipotarget');
		nom = document.getElementById('nom');
		desc = document.getElementById("desc");
		link = document.getElementById("link");
		fecini = document.getElementById('fecini');
		horini = document.getElementById('horini');
		fecfin = document.getElementById('fecfin');
		horfin = document.getElementById('horfin');
		//--
		imagen = document.getElementById("imagen");
		if(imagen.files.length > 0){
			filename = imagen.files[0].name;
		}else{
			filename = "";   
		}
		
		if(target.value !=="" && nom.value !=="" && desc.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== ""){
			if (target.value === "SELECT") {
					var filas = parseInt(document.getElementById('gruposrows').value);
					var arrgrupo = Array([]);
					var cuantos = 0;
					//alert(filas);
					for(i = 1; i <= filas; i++){
						chk = document.getElementById("grupos"+i);
						if(chk.checked) {
							arrgrupo[cuantos] = chk.value;
							cuantos++;
						}
					}
					if(cuantos > 0) {
						abrir();
						xajax_Grabar_Informacion(nom.value,desc.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,filename,link.value,arrgrupo,cuantos);
					}else{
						swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
					}
			}else{
				var arrgrupo = Array([]);
				var cuantos = 0;
				xajax_Grabar_Informacion(nom.value,desc.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,filename,link.value,arrgrupo,cuantos);
			}
		}else{
			if(target.value ===""){
				target.className = "form-danger";
			}else{
				target.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(fecini.value ===""){
				fecini.className = "form-danger text-libre";
			}else{
				fecini.className = "form-control text-libre";
			}
			if(horini.value ===""){
				horini.className = "form-danger text-libre";
			}else{
				horini.className = "form-control text-libre";
			}
			if(fecfin.value ===""){
				fecfin.className = "form-danger text-libre";
			}else{
				fecfin.className = "form-control text-libre";
			}
			if(horfin.value ===""){
				horfin.className = "form-danger text-libre";
			}else{
				horfin.className = "form-control text-libre";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById('codigo');
		nom = document.getElementById('nom');
		desc = document.getElementById("desc");
		link = document.getElementById("link");
		fecini = document.getElementById('fecini');
		horini = document.getElementById('horini');
		fecfin = document.getElementById('fecfin');
		horfin = document.getElementById('horfin');
		//--
		imagen = document.getElementById("imagen");
		var filename = '';
		if(imagen.files.length > 0){
			filename = imagen.files[0].name;
		}
		
		if(cod.value !==""){
			if(cod.value !=="" && nom.value !=="" && desc.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== ""){
				abrir();
				xajax_Modificar_Informacion(cod.value,nom.value,desc.value,fecini.value,horini.value,fecfin.value,horfin.value,filename,link.value);
			}else{
				if(nom.value ===""){
					nom.className = "form-danger";
				}else{
					nom.className = "form-control";
				}
				if(desc.value ===""){
					desc.className = "form-danger";
				}else{
					desc.className = "form-control";
				}
				if(fecini.value ===""){
					fecini.className = "form-danger text-libre";
				}else{
					fecini.className = "form-control text-libre";
				}
				if(horini.value ===""){
					horini.className = "form-danger text-libre";
				}else{
					horini.className = "form-control text-libre";
				}
				if(fecfin.value ===""){
					fecfin.className = "form-danger text-libre";
				}else{
					fecfin.className = "form-control text-libre";
				}
				if(horfin.value ===""){
					horfin.className = "form-danger text-libre";
				}else{
					horfin.className = "form-control text-libre";
				}
				swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			}
		}else{
			swal("Ohoo!", "Si quiere crear una actividad nueva esta en la pantalla equivocada, aqu\u00ED solo puede actualizar las existentes.\nPara editar, seleccione la actividad que quiere modificar y realice los cambios...", "error");
		}
	}
	
	function ModificarTarget(){
		target = document.getElementById('target');
		tipo = document.getElementById('tipotarget');
		
		if(target.value !==""){
			if (target.value === "SELECT") {
					var filas = parseInt(document.getElementById('gruposrows').value);
					var arrgrupos = "";
					var cuantos = 0;
					//alert(filas);
					for(i = 1; i <= filas; i++){
						chk = document.getElementById("grupos"+i);
						if(chk.checked) {
							arrgrupos+= chk.value+"|";
							cuantos++;
						}
					}
					if(cuantos > 0) {
						abrir();
						document.getElementById('gruposrows').value = cuantos; //actualiza solo la cantidad de chequeados
						document.getElementById('chequeados').value = arrgrupos; //genera un string tipo array
						Submit();
					}else{
						swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
					}
			}else{
				Submit();
			}
		}else{
			if(target.value ===""){
				target.className = "form-danger";
			}else{
				target.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ConfirmEliminar(codigo){
		swal({
			text: "\u00BFDesea eliminar esta actividad del calendario?, No podra ser visualizada con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Informacion(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	function ConfirmRecordatorio(codigo){
		swal({
			title: "\u00BFNotificar Recordatorio?",
			text: "\u00BFDesea notificar un recordatorio de esta actividad?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Recordatorio(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Ver_Informacion(cod){	
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/informacion/informacion.php",{codigo:cod}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	