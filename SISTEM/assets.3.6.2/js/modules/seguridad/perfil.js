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
						
	function comprueba_vacios(n,x){
		texto = n.value;
		if(texto === ""){ 
			document.getElementById(x).className="text-warning glyphicon glyphicon-warning-sign";
		}else{
			document.getElementById(x).className="text-success fa fa-check";
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
				document.getElementById('pas2').className="text-warning glyphicon glyphicon-warning-sign";
			}else{
				document.getElementById('pas2').className="text-danger glyphicon glyphicon-remove";
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

	function ModificarPreg(){
		cod = document.getElementById('cod');
		usu = document.getElementById('usu');
		preg = document.getElementById("preg");
		resp = document.getElementById("resp");
						
		if(cod.value !=="" && usu.value !=="" && preg.value !== "" && resp.value !== ""){
			abrir();
			xajax_Modificar_Usuario_Pregunta(cod.value,usu.value,preg.value,resp.value);
		}else{
			if(preg.value ===""){
				preg.className = " form-danger";
			}else{
				preg.className = " form-control";
			}
			if(resp.value ===""){
				resp.className = " form-danger";
			}else{
				resp.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
///////// Perfil /////////////

	function ModificarPerfil(){
		cod = document.getElementById('cod');
		nom = document.getElementById("nom");
		mail = document.getElementById("mail");
		tel = document.getElementById("tel");
						
		if(cod.value !== "" && nom.value !== "" && mail.value !== "" && tel.value !== ""){
			abrir();
			xajax_Modificar_Usuario_Perfil(cod.value,nom.value,mail.value,tel.value);
		}else{
			if(nom.value === ""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(mail.value === ""){
				mail.className = " form-danger text-libre";
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
	
	
	///////// Contrase\u00F1a /////////////

	function ModificarPass(){
		cod = document.getElementById('cod');
		usu = document.getElementById('usu');
		pass1 = document.getElementById("pass1");
		pass2 = document.getElementById("pass2");
						
		if(cod.value !=="" && usu.value !=="" && pass1.value !== ""  && pass2.value !== ""){
			if(pass1.value === pass2.value){
				abrir();
				xajax_Modificar_Usuario_Pass(cod.value,usu.value,pass1.value);
			}else{
				//--
				pass1.className = " form-danger";
				pass2.className = " form-danger";
				//--
				swal("Alto!", "El usuario y la contrase\u00F1a son distintos...", "error");
			}
		}else{
			if(pass1.value ===""){
				pass1.className = " form-danger";
			}else{
				pass1.className = " form-control";
			}
			if(pass2.value ===""){
				pass2.className = " form-danger";
			}else{
				pass2.className = " form-control";
			}
			if(usu.value ===""){
				usu.className = " form-danger text-libre";
			}else{
				usu.className = " form-control text-libre";
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
		nom = document.getElementById("nom");
		doc = document.getElementById("doc");
		if(doc.value !== ""){
			exdoc = comprueba_extension(doc.value);
			if(exdoc === 1){
				abrir();				
				myform = document.forms.f1;
				myform.submit();
			}else{
				swal("Alto!", "Este archivo no es extencion .jpg \u00F3 .png", "error");
			}		
		}else{
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function validarEmail(valor) {
		var filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;	
		if (filtro.test(valor)){
			return true;
		} else {
			return false;
		}
	}
	
	
	
	///////// Utilitarias ///////////
	
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
			if (".jpg" === extension || ".png" === extension) {
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
	
	