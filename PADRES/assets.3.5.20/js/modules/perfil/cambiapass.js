//funciones javascript y validaciones

//////////////////////////////////////////////////////

function aceptar(){
	codigo = document.getElementById('cod');
	usu = document.getElementById('usu');
	pass1 = document.getElementById("pass1");
	pass2 = document.getElementById("pass2");
	nompant = document.getElementById('nompant');
	mail = document.getElementById('mail');
	tel = document.getElementById('tel');
	preg = document.getElementById("preg");
	resp = document.getElementById("resp");
	if(nompant.value !="" && mail.value !="" && usu.value !="" && pass1.value != "" && pass2.value != ""){
		if((preg.value !="" && resp.value != "") || (preg.value =="" && resp.value == "")){
			if(pass1.value == pass2.value){
				abrir();				
				xajax_Activa_Usuario(codigo.value,nompant.value,mail.value,tel.value,usu.value,pass1.value,preg.value,resp.value);
			}else{
				pass1.className = "form-danger";
				pass2.className = "form-danger";
				swal("Ohoo!", "las contraseñas no son iguales...", "error");
			}
		}else{
			preg.className = "form-danger";
			resp.className = "form-danger";
			swal("Ohoo!", "Si usted selecciona la pregunta debe llenar la respuesta, o viceversa...", "error");
		}		
	}else{
		nompant.className = "form-danger";
		mail.className = "form-danger";
		tel.className = "form-danger";
		usu.className = "form-danger";
		pass1.className = "form-danger";
		pass2.className = "form-danger";
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}
