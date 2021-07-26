	//funciones javascript y validaciones
	
	function Seteo_config(x,y){
		document.getElementById("municipio").value = x;
		document.getElementById("ser").value = y;
	}
	
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
				
	
	function Modificar(){
		nombre = document.getElementById("nombre");
		rotulo = document.getElementById("rotulo");
		rotulo2 = document.getElementById("rotulo2");
		nreporte = document.getElementById("nreporte");
		direccion1 = document.getElementById("direccion1");
		direccion2 = document.getElementById("direccion2");
		departamento = document.getElementById("departamento");
		municipio = document.getElementById("municipio");
		telefono = document.getElementById("telefono");
		correo = document.getElementById("correo");
		website = document.getElementById("website");
		//--
		nivel = document.getElementById("nivel");
		ciclo = document.getElementById("ciclo");
		modalidad = document.getElementById("modalidad");
		jornada = document.getElementById("jornada");
		sector = document.getElementById("sector");
		area = document.getElementById("area");
		
		if(nombre.value !== "" && rotulo.value !== "" && rotulo2.value !== "" && nreporte.value !== "" && direccion1.value !== "" && direccion2.value !=="" && departamento.value !=="" && municipio.value !== "" && telefono.value !== "" && correo.value !== "" && website.value !== "" && nivel.value !== "" && ciclo.value !== "" && modalidad.value !== "" && jornada.value !== "" && sector.value !== "" && area.value !== ""){              
			abrir();				
			xajax_Modificar_Credenciales(nombre.value,rotulo.value,rotulo2.value,nreporte.value,direccion1.value,direccion2.value,departamento.value,municipio.value,telefono.value,correo.value,website.value,nivel.value,ciclo.value,modalidad.value,jornada.value,sector.value,area.value);
			//alert("entro");
		}else{
			if(nombre.value === ""){
				nombre.className = " form-danger text-libre";
			}else{
				nombre.className = " form-control text-libre";
			}
			if(rotulo.value === ""){
				rotulo.className = " form-danger";
			}else{
				rotulo.className = " form-control";
			}
			if(rotulo2.value === ""){
				rotulo2.className = " form-danger";
			}else{
				rotulo2.className = " form-control";
			}
			if(nreporte.value === ""){
				nreporte.className = " form-danger";
			}else{
				nreporte.className = " form-control";
			}
			if(direccion1.value === ""){
				direccion1.className = " form-danger";
			}else{
				direccion1.className = " form-control";
			}
			if(direccion2.value === ""){
				direccion2.className = " form-danger";
			}else{
				direccion2.className = " form-control";
			}
			if(municipio.value === ""){
				municipio.className = " form-danger";
			}else{
				municipio.className = " form-control";
			}
			if(departamento.value === ""){
				departamento.className = " form-danger";
			}else{
				departamento.className = " form-control";
			}
			if(telefono.value === ""){
				telefono.className = " form-danger";
			}else{
				telefono.className = " form-control";
			}
			if(correo.value === ""){
				correo.className = " form-danger";
			}else{
				correo.className = " form-control";
			}
			if(website.value === ""){
				website.className = " form-danger";
			}else{
				website.className = " form-control";
			}
			if(nivel.value === ""){
				nivel.className = " form-danger";
			}else{
				nivel.className = " form-control";
			}
			if(ciclo.value === ""){
				ciclo.className = " form-danger";
			}else{
				ciclo.className = " form-control";
			}
			if(modalidad.value === ""){
				modalidad.className = " form-danger";
			}else{
				modalidad.className = " form-control";
			}
			if(jornada.value === ""){
				jornada.className = " form-danger";
			}else{
				jornada.className = " form-control";
			}
			if(sector.value === ""){
				sector.className = " form-danger";
			}else{
				sector.className = " form-control";
			}
			if(area.value === ""){
				area.className = " form-danger";
			}else{
				area.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function modificarModulos(){
		var filas = parseInt(document.getElementById("modulorows").value);
		//alert(inicia+"-"+cuantos);
		if(filas > 0){
			var arrmodulos = new Array();
			var arrsituacion = new Array();
			for(var i = 1; i <= filas; i++){
				var modulo = document.getElementById("modulo"+i);
				console.log(modulo.value, modulo.checked);
				if(modulo.checked){
					arrmodulos[i] = modulo.value;
					arrsituacion[i] = 1;
				}else{
					arrmodulos[i] = modulo.value;
					arrsituacion[i] = 0;
				}
			}
			xajax_Modulos(arrmodulos,arrsituacion,filas);
		}else{
			swal("Ohoo!", "No hay ningun m\u00F3dulo en el listado...", "error");
		}
		return;
	}
