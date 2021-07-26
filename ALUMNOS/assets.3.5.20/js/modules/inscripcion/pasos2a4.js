var arrbloqueados = [];

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
	
	function generarBoleta(fila){
		abrir();
		cui = document.getElementById("cui"+fila).value;
		if(cui != ""){
			////valida que el CUI no este en lista negra
			var resultado = "";
			for (var i = 0; i < arrbloqueados.length; i++) {
				if(arrbloqueados[i].cui === cui) {
					swal("Nota", "Este alumno(a) se encuentra en una lista reservada en el Colegio.   No se girar\u00E1 boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.", "warning");
					swal.stopLoading();
					swal.close();
					cerrar();
					return;
				}
			}
			///// valida que el nombre del aulumno no este en lista negra 
			if(CompareNombreBloqueado(fila)){
				xajax_Generar_Boleta_Inscripcion(cui);
			}else{
				cerrar();
				return;
			}
			//alert(cui);
		}else{
			swal("Ohoo!", "Hay un error al reportar el c\u00F3digo del alumno, por favor refresque la p\u00E1gina, si los problemas continuan contacte al administrador....", "error");
		}
	}
	
	function openBoleta(boleta,cuenta,banco){
		//alert("CPREPORTES/REPboleta.php?boleta="+boleta+"&cuenta="+cuenta+"&banco="+banco);
		window.location.reload();
		window.open("../../CONFIG/INSCRIPCIONES/REPboleta.php?boleta="+boleta+"&cuenta="+cuenta+"&banco="+banco);
	}
	
	function Solicitar_Aprobacion(cui){
		abrir();
			
		if(cui != ""){
			xajax_Solicitar_Aprobacion(cui);
		}else{
			swal("Ohoo!", "Hay un error al reportar el c\u00F3digo del alumno, por favor refresque la p\u00E1gina, si los problemas continuan contacte al administrador....", "error");
		}
	}	
		
	function verComentarios(contrato,alumno){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/inscripcion/comentarios.php",{contrato:contrato,alumno:alumno}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
		
	function Triger_Paso3(){
		window.location.href='FRMpaso3.php';
	}
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function JsonString(url){
		
		//let url = 'https://losolivos.inversionesd.com/SISTEM/API/API_inscripciones.php?request=bloqueados';
		fetch(url).then(res => res.json()).then((out) => {
		  //console.log('Checkout this JSON! ', out);
		  arrbloqueados = out;
		}).catch(err => {
			console.log('Error: ', err);	
		});
	}
	
	
	function CompareNombreBloqueado(fila){
		nom = document.getElementById("nombre"+fila);
		ape = document.getElementById("apellido"+fila);
		var nombre = nom.value+ape.value;
		///-- limpia la cadena
		nombre = nombre.toUpperCase();
		//nombre = "VALDEZ MORALES";
		//--
		purename = nombre;
		/*purename = nombre.replace(/Á/gi, "A");
		purename = purename.replace(/É/gi,"E");
		purename = purename.replace(/Í/gi,"I");
		purename = purename.replace(/Ó/gi,"O");
		purename = purename.replace(/Ú/gi,"U");
		//dierecis
		purename = purename.replace(/Ä/gi,"A");
		purename = purename.replace(/Ë/gi,"E");
		purename = purename.replace(/Ï/gi,"I");
		purename = purename.replace(/Ö/gi,"O");
		purename = purename.replace(/Ü/gi,"U");
		//Ñ
		purename = purename.replace(/Ñ/gi,"N");*/
		///espacios y otros
		purename = purename.replace(/ /gi,"");
		purename = purename.replace(/,/gi,"");
		purename = purename.toLowerCase();
		//alert(purename);
		var matchscore = "";
		for (var i = 0; i < arrbloqueados.length; i++) {
			//alert(arrbloqueados[i].purename+", "+purename);
			matchscore = purename.score(arrbloqueados[i].purename);
			matchscore = matchscore * 100;
			if(matchscore >= 85) {
				//alert("El Nombre coinciden demasiado: "+arrbloqueados[i].nombre+" en la fila "+i+". Coincidencia:"+matchscore+" %");
				swal("Nota","El nombre de este alumno se encuentra en una lista reservada en el Colegio.   No se girar\u00E1 boleta de inscripci\u00F3n hasta que solucione su situaci\u00F3n.","warning").then((value) => {
					document.getElementById("btnnext").setAttribute("disabled","disabled");
				});
				return false;
			}
		}
		return true;
	}