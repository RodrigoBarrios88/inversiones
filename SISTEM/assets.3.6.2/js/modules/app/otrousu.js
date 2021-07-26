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
		cui = document.getElementById('cui');
		nom = document.getElementById('nom');
		ape = document.getElementById("ape");
		titulo = document.getElementById("titulo");
		fecnac = document.getElementById("fecnac");
		mail = document.getElementById('mail');
		tel = document.getElementById("tel");
		
		if(cui.value !=="" && nom.value !=="" && ape.value !== "" && titulo.value !== "" && fecnac.value !== "" && tel.value !== "" && mail.value !== ""){
			abrir();
			xajax_Grabar_OtroUsu(cui.value,nom.value,ape.value,titulo.value,fecnac.value,tel.value,mail.value);
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
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(fecnac.value ===""){
				fecnac.className = "form-danger";
			}else{
				fecnac.className = "form-control";
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
		titulo = document.getElementById("titulo");
		fecnac = document.getElementById("fecnac");
		mail = document.getElementById('mail');
		tel = document.getElementById("tel");
		
		if(cui.value !=="" && nom.value !=="" && ape.value !== "" && titulo.value !== "" && fecnac.value !== "" && tel.value !== "" && mail.value !== ""){
			abrir();
			xajax_Modificar_OtroUsu(cui.value,nom.value,ape.value,titulo.value,fecnac.value,tel.value,mail.value);
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
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(fecnac.value ===""){
				fecnac.className = "form-danger";
			}else{
				fecnac.className = "form-control";
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
	
	function Deshabilita_OtroUsu(cui){
		swal({
			text: "\u00BFEsta seguro de Inhabilitar esta autoridad (Director(a) u otro)?, No podra ser visualizado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_OtroUsu(cui,0);
					break;
				default:
					return;
			}
		});
	}
	
	function Habilita_OtroUsu(cui){
		swal({
			text: "\u00BFEsta seguro de Re-Activar esta autoridad (Director(a) u otro)?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_OtroUsu(cui,0);
					break;
				default:
					return;
			}
		});
	}
	
	function Busca_Grupos_OtroUsu(cui,area){
		if (cui !== "") {
			xajax_Grupos_OtroUsu(cui,area);
		}
	}
	
	
	function Busca_Grados_OtroUsu(cui,pensum,nivel){
		
		if (cui !== "") {
			xajax_Lista_Grados_OtroUsu(cui,pensum,nivel);
		}
	}
	
	function Asigna_Trabajo_OtroUsu(){
		cui = document.getElementById("cui");
		filas =  document.getElementById("xasignarrows").value;
		//--
		tipoasi = document.getElementById('tipoAsi');
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		//--
		area = document.getElementById('area');
		//--
		
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
					if(tipoasi.value == 1) {
						//alert("entro 1");
						xajax_Graba_OtroUsu_Grados(cui.value,pensum.value,nivel.value,arrgrupos,cuantos);
					}else if(tipoasi.value == 3) {
						//alert(autoridad.value+","+area.value);
						xajax_Graba_OtroUsu_Grupos(cui.value,area.value,arrgrupos,cuantos);
					}
				}else{
					swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
				}
			}else{
				swal("Ohoo!", "Debe seleccionar almenos una (01) Autoridad...", "error");
			}	
		}else{
			swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
		}
	}
	
	
	
	function Quitar_trabajo_OtroUsu(){
		cui = document.getElementById("cui");
		filas =  document.getElementById("asignadosrows").value;
		//--
		tipoasi = document.getElementById('tipoAsi');
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		//--
		area = document.getElementById('area');
		
		if(filas > 0) {
			if(cui.value) {
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
					if(tipoasi.value == 1) {
						//alert("entro 1");
						xajax_Quitar_OtroUsu_Grados(cui.value,pensum.value,nivel.value,arrgrupos,cuantos);
					}else if(tipoasi.value == 3) {
						//alert(autoridad.value+","+area.value);
						xajax_Quitar_OtroUsu_Grupos(cui.value,area.value,arrgrupos,cuantos);
					}
				}else{
					swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
				}
			}else{
				swal("Ohoo!", "Debe seleccionar almenos el \u00E1rea...", "error");
			}	
		}else{
			swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "error");
		}
	}
	
	
	function Tipo_Asignacion(tipoasi){
		area = document.getElementById("area");
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");

			if(tipoasi == 1) {
				//--
				area.disabled = true;
				pensum.disabled = false;
				nivel.disabled = false;
			}else if(tipoasi == 3) {
				//--
				area.disabled = false;
				pensum.disabled = true;
				nivel.disabled = true;
			}else{
				area.value = '';
				pensum.value = '';
				nivel.value = '';
				//--
				area.disabled = true;
				pensum.disabled = true;
				nivel.disabled = true;
			}
	}
	
	
	function Asignar_Curso_Autoridad(autoridad,curso){
		abrir();
		xajax_Graba_Autoridad_Curso(autoridad,curso);
	}
	
	
	function Desasignar_Curso_Autoridad(autoridad,curso){
		swal({
			text: "\u00BFEsta seguro de des-asignar a esta autoridad (Director(a) u otro) de este Curso?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Delete_Autoridad_Curso(autoridad,curso);
					break;
				default:
					return;
			}
		});
	}
