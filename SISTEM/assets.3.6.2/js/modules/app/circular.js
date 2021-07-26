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
	
	function verDocumento(documento){
		myform = document.forms.f2;
		myform.action = "../../CONFIG/Circulares/"+documento;
		myform.target = "_blank";
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
		titulo = document.getElementById('titulo');
		desc = document.getElementById("desc");
		//-- autorizacion
		var autorizacion = "";
		var autorizacionsi = document.getElementById("autorizacionsi");
		var autorizacionno = document.getElementById("autorizacionno");
		if(autorizacionsi.checked){
			autorizacion = 1;
		}else if(autorizacionno.checked){
			autorizacion = 0;
		}else{
			autorizacion = "";
		}
		//--
		documento = document.getElementById("documento");
		if(documento.files.length > 0){
			if(target.value !=="" && titulo.value !==""){
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
							xajax_Grabar_Circular(titulo.value,desc.value,target.value,tipo.value,autorizacion,arrgrupo,cuantos);
						}else{
							swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
						}
				}else{
					var arrgrupo = Array([]);
					var cuantos = 0;
					abrir();
					xajax_Grabar_Circular(titulo.value,desc.value,target.value,tipo.value,autorizacion,arrgrupo,cuantos);
				}
			}else{
				if(target.value ===""){
					target.className = "form-danger";
				}else{
					target.className = "form-control";
				}
				if(titulo.value ===""){
					titulo.className = "form-danger";
				}else{
					titulo.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			}
		}else{
			swal("No hay documento", "A\u00FAn no ha adjuntado ning\u00FAn documento...", "error");
		}
	}
	
	function Modificar(){
		cod = document.getElementById('codigo');
		titulo = document.getElementById('titulo');
		desc = document.getElementById("desc");
		//-- autorizacion
		var autorizacion = "";
		var autorizacionsi = document.getElementById("autorizacionsi");
		var autorizacionno = document.getElementById("autorizacionno");
		if(autorizacionsi.checked){
			autorizacion = 1;
		}else if(autorizacionno.checked){
			autorizacion = 0;
		}else{
			autorizacion = "";
		}
		//--
		documento = document.getElementById("documento");
		documentoold = document.getElementById("documentoold");
		if(documento.files.length > 0 || documentoold.value !==""){
			var filename = '';
			if(documento.files.length > 0){
				filename = documento.files[0].name;
			}
			if(cod.value !=="" && titulo.value !==""){
				abrir();
				xajax_Modificar_Circular(cod.value,titulo.value,desc.value,filename,autorizacion);
			}else{
				if(titulo.value ===""){
					titulo.className = "form-danger";
				}else{
					titulo.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			}
		}else{
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
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
			text: "\u00BFDesea eliminar esta circular del archivo del colegio?, No podra ser visualizada desp\u00FAes con esta situaci\u00F3n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Circular(codigo);
					break;
				default:
				  return;
			}
		});
	}
	