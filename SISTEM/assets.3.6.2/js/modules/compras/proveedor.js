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
		nit = document.getElementById('nit');
		nom = document.getElementById('nom');
		direc = document.getElementById("direc");
		tel1 = document.getElementById("tel1");
		tel2 = document.getElementById("tel2");
		credito = document.getElementById("credito");
		contac = document.getElementById("contac");
		telc = document.getElementById("telc");
		mail = document.getElementById("mail");
		
		if(nit.value !=="" && nom.value !=="" && direc.value !== "" && tel1.value !== "" && credito.value !== "" && contac.value !== ""){
			abrir();
			xajax_Grabar_Proveedor(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,credito.value,contac.value,telc.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
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
			if(tel1.value ===""){
				tel1.className = "form-danger";
			}else{
				tel1.className = "form-control";
			}
			if(credito.value ===""){
				credito.className = "form-danger";
			}else{
				credito.className = "form-control";
			}
			if(contac.value ===""){
				contac.className = "form-danger";
			}else{
				contac.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			
		}
	}
	
	function Modificar(){
		cod = document.getElementById('cod');
		nit = document.getElementById('nit');
		nom = document.getElementById('nom');
		direc = document.getElementById("direc");
		tel1 = document.getElementById("tel1");
		tel2 = document.getElementById("tel2");
		credito = document.getElementById("credito");
		contac = document.getElementById("contac");
		telc = document.getElementById("telc");
		mail = document.getElementById("mail");
		     
		if(nit.value !=="" && nom.value !=="" && direc.value !== "" && tel1.value !== "" && credito.value !== "" && contac.value !== ""){
			abrir();
			xajax_Modificar_Proveedor(cod.value,nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,credito.value,contac.value,telc.value);
			//botones
			gra = document.getElementById("gra");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
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
			if(tel1.value ===""){
				tel1.className = "form-danger";
			}else{
				tel1.className = "form-control";
			}
			if(credito.value ===""){
				credito.className = "form-danger";
			}else{
				credito.className = "form-control";
			}
			if(contac.value ===""){
				contac.className = "form-danger";
			}else{
				contac.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Historial_Compras(proveedor){
		var x = 0;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/proveedor/historial_compras.php",{codigo:proveedor}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function Lista_Articulos(proveedor){
		var x = 0;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/proveedor/lista_articulos.php",{codigo:proveedor}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function Lista_Gastos(proveedor){
		var x = 0;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/proveedor/lista_gastos.php",{codigo:proveedor}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
