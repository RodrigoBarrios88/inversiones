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
			xajax_Grabar_Maestro(cui.value,nom.value,ape.value,titulo.value,fecnac.value,tel.value,mail.value);
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
		
		if(nom.value !=="" && ape.value !== "" && titulo.value !== "" && fecnac.value !== "" && tel.value !== "" && mail.value !== ""){
			abrir();
			xajax_Modificar_Maestro(cui.value,nom.value,ape.value,titulo.value,fecnac.value,tel.value,mail.value);
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
	

	function Deshabilita_Maestro(cui){
		swal({
			text: "\u00BFEsta seguro de Inhabilitar este(a) Maestro?, No podra ser visualizado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Maestro(cui,0);
					break;
				default:
					return;
			}
		});
	}
	
	
	function Habilita_Maestro(cui){
		swal({
			text: "\u00BFEsta seguro de Re-Activar este(a) Maestro?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Maestro(cui,1);
					break;
				default:
					return;
			}
		});
	}
	
	
	function Busca_Secciones_Maestro(cui,pensum,nivel,grado,tipo){
		if (cui !== "") {
			xajax_Lista_Seccion_Maestro(cui,pensum,nivel,grado,tipo);
		}
	}
	
	function Busca_Materias_Maestro(cui,pensum,nivel,grado,tipo){
		if (cui !== "") {
			xajax_Lista_Materia_Maestro(cui,pensum,nivel,grado,tipo);
		}
	}
	
	
	//////////////////////// ASIGNACION USUARIOS A EMPRESAS ////////////////////////////////////

	
	function Asigna_Trabajo_Maestro(arrcodigos){
		cui = document.getElementById("cui");
		//--
		tipoasi = document.getElementById('tipoAsi');
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById('grado');
		tipo = document.getElementById('tipo');
		//--
		area = document.getElementById('area');
		//--
		
		if(cui.value) {
			if(tipoasi.value == 1) {
				//alert("entro 1");
				xajax_Graba_Maestro_Seccion(cui.value,pensum.value,nivel.value,grado.value,arrcodigos);
			}else if(tipoasi.value == 2) {
				//alert("entro 2");
				xajax_Graba_Maestro_Materia(cui.value,pensum.value,nivel.value,grado.value,arrcodigos);
			}else if(tipoasi.value == 3) {
				//alert(maestro.value+","+area.value);
				xajax_Graba_Maestro_Grupos(cui.value,arrcodigos);
			}
		}else{
			swal("Ohoo!", "Debe seleccionar almenos un (01) Maestro...", "error");
		}	
	}
	
	
	
	function Quitar_trabajo_Maestro(){
		cui = document.getElementById("cui");
		filas =  document.getElementById("asignadosrows").value;
		//--
		tipoasi = document.getElementById('tipoAsi');
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById('grado');
		tipo = document.getElementById('tipo');
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
						xajax_Quitar_Maestro_Seccion(cui.value,pensum.value,nivel.value,grado.value,tipo.value,arrgrupos,cuantos);
					}else if(tipoasi.value == 2) {
						//alert("entro 2");
						xajax_Quitar_Maestro_Materia(cui.value,pensum.value,nivel.value,grado.value,tipo.value,arrgrupos,cuantos);
					}else if(tipoasi.value == 3) {
						//alert(maestro.value+","+area.value);
						xajax_Quitar_Maestro_Grupos(cui.value,area.value,arrgrupos,cuantos);
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
	
	
	function Asignar_Curso_Maestro(maestro,curso){
		abrir();
		xajax_Graba_Maestro_Curso(maestro,curso);
	}
	
	
	function Desasignar_Curso_Maestro(maestro,curso){
		swal({
			text: "\u00BFEsta seguro de des-asignar al maestro de este Curso?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Delete_Maestro_Curso(maestro,curso);
					break;
				default:
					return;
			}
		});
	}
	
	
	function Tipo_Asignacion(tipoasi){
		area = document.getElementById("area");
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		tipo = document.getElementById("tipo");
		
			if(tipoasi == 1) {
				//--
				area.disabled = true;
				pensum.disabled = false;
				nivel.disabled = false;
				grado.disabled = false;
				tipo.disabled = false;
			}else if(tipoasi == 2) {
				//--
				area.disabled = true;
				pensum.disabled = false;
				nivel.disabled = false;
				grado.disabled = false;
				tipo.disabled = false;
			}else if(tipoasi == 3) {
				//--
				area.disabled = false;
				pensum.disabled = true;
				nivel.disabled = true;
				grado.disabled = true;
				tipo.disabled = true;
			}else{
				area.value = '';
				pensum.value = '';
				nivel.value = '';
				grado.value = '';
				tipo.value = '';
				//--
				area.disabled = true;
				pensum.disabled = true;
				nivel.disabled = true;
				grado.disabled = true;
				tipo.disabled = true;
			}
	}
	
	function Limpia_Tipo(){
		document.getElementById("tipo").value = "";
		//--
		xajax_Lista_Limpia();
	}
	
	
	function Combo_Nivel_Grado(){
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		if(pensum.value !==""){
			xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Limpia_Tipo();");
		}
	}
	
	
	function Lista_Nivel_Grado(){
		maestro = document.getElementById('cui');
		//--
		tipoasi = document.getElementById('tipoAsi');
		pensum = document.getElementById('pensum');
		nivel = document.getElementById('nivel');
		grado = document.getElementById('grado');
		tipo = document.getElementById('tipo');
		//--
		area = document.getElementById('area');
		if(tipoasi.value === 1) {
			//alert("entro 1");
			xajax_Lista_Seccion_Maestro(maestro.value,pensum.value,nivel.value,grado.value,tipo.value);
		}else if(tipoasi.value === 2) {
			//alert("entro 2");
			xajax_Lista_Materia_Maestro(maestro.value,pensum.value,nivel.value,grado.value,tipo.value);
		}else if(tipoasi.value === 3) {
			//alert(maestro.value+","+area.value);
			xajax_Lista_Grupo_Maestro(maestro.value,area.value);
		}
	}
	
	
	function Desasignar_Materia_Seccion_Maestro(pensum,nivel,grado,seccion,materia,maestro){
		swal({
			text: "\u00BFEsta seguro de des-asignar al maestro de esta secci\u00F3n?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Delete_Materia_Seccion_Maestro(pensum,nivel,grado,seccion,materia,maestro);
					break;
				default:
					return;
			}
		});
	}