//funciones javascript y validaciones

function Limpiar(){
	texto = "¿Desea Limpiar la Pagina?, perdera los datos escritos...";
	acc = "location.reload();";
	ConfirmacionJs(texto,acc);
}

function Submit(){
	myform = document.forms.f1;
	myform.submit();
}
					
function pageprint(){
	boton = document.getElementById("print");
	boton.style.display="none";
	window.print();
	boton.style.display="block";
}


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// perfil FRMpassword ///////////////////////////////

function comprueba_vacios(n,x){
	texto = n.value;
	if(texto == ""){ 
		document.getElementById(x).className="text-warning icon icon-warning";
	}else{
		document.getElementById(x).className="text-success icon icon-checkmark";
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
	if(texto1 == texto2){
		document.getElementById('pas2').className="text-success icon icon-checkmark";
	}else{
		//alert(texto2);
		if(texto2 == ""){
			document.getElementById('pas2').className="text-warning icon icon-warning";
		}else{
			document.getElementById('pas2').className="text-danger icon icon-cancel-circle";
		}
	}
}

function seguridad_clave(clave){
	var seguridad = 0;
	if(clave.length!=0){
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

///////// Hijos /////////////

function Modificar(){
	var bandera_hijos = 0;
	//----
	hijos = parseInt(document.getElementById("hijos").value);
	if (hijos > 0) {
		var arrcui = new Array([]);
		var arrtipocui = new Array([]);
		var arrcodigo = new Array([]);
		var arrnombre = new Array([]);
		var arrapellido = new Array([]);
		var arrgenero = new Array([]);
		var arrfecnac = new Array([]);
		var arrnacionalidad = new Array([]);
		var arrreligion = new Array([]);
		var arridioma = new Array([]);
		var arrmail = new Array([]);
		var arrsangre = new Array([]);
		var arralergia = new Array([]);
		var arremergencia = new Array([]);
		var arremetel = new Array([]);
		var arrrecoge = new Array([]);
		var arrredesociales = new Array([]);
		var arrseguro = new Array([]);
		var arrnit = new Array([]);
		var arrclinombre = new Array([]);
		var arrclidireccion = new Array([]);
		var arrpoliza = new Array([]);
		var arrasegura = new Array([]);
		var arrplan = new Array([]);
		var arrasegurado = new Array([]);
		var arrinstuc = new Array([]);
		var arrcomment = new Array([]);
		for(i = 1; i <= hijos; i++){
			xcui = document.getElementById("cui"+i);
			xtipocui = document.getElementById("tipocui"+i);
			xcodigo = document.getElementById("codigo"+i);
			xnombre = document.getElementById("nombre"+i);
			xapellido = document.getElementById("apellido"+i);
			xgenero = document.getElementById("genero"+i);
			xnacionalidad = document.getElementById("nacionalidad"+i);
			xreligion = document.getElementById("religion"+i);
			xidioma = document.getElementById("idioma"+i);
			xmail = document.getElementById("mail"+i);
			xfecnac = document.getElementById("fecnac"+i);
			xsangre = document.getElementById("sangre"+i);
			xalergia = document.getElementById("alergia"+i);
			xemergencia = document.getElementById("emergencia"+i);
			xemetel = document.getElementById("emetel"+i);
			xrecoge = document.getElementById("recoge"+i);
			xredesociales = document.getElementById("redsoc"+i);
			//-- radiobutton
			var segsi = document.getElementById("segurosi"+i);
			var segno = document.getElementById("segurono"+i);
			if(segsi.checked){
				xseguro = 1;
			}else if(segno.checked){
				xseguro = 0;
			}else{
				xseguro = "";
			}
			//--
			xnit = document.getElementById("nit"+i);
			xclinombre = document.getElementById("clinombre"+i);
			xclidireccion = document.getElementById("clidireccion"+i);
			//--
			xpoliza = document.getElementById("poliza"+i);
			xasegura = document.getElementById("aseguradora"+i);
			xplan = document.getElementById("plan"+i);
			xasegurado = document.getElementById("asegurado"+i);
			xinstruc = document.getElementById("instrucciones"+i);
			xcomment = document.getElementById("comentarios"+i);
			//--
			//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
			if(xcui.value ===""){
				xcui.className = "form-danger";
			}else{
				xcui.className = "form-control";
			}
			if(xnombre.value ===""){
				xnombre.className = "form-danger";
			}else{
				xnombre.className = "form-control";
			}
			if(xapellido.value ===""){
				xapellido.className = "form-danger";
			}else{
				xapellido.className = "form-control";
			}
			if(xgenero.value ===""){
				xgenero.className = "form-danger";
			}else{
				xgenero.className = "form-control";
			}
			if(xfecnac.value ===""){
				xfecnac.className = "form-danger";
			}else{
				xfecnac.className = "form-control";
			}
			if(xsangre.value ===""){
				xsangre.className = "form-danger";
			}else{
				xsangre.className = "form-control";
			}
			if(xemergencia.value ===""){
				xemergencia.className = "form-danger";
			}else{
				xemergencia.className = "form-control";
			}
			if(xemetel.value ===""){
				xemetel.className = "form-danger";
			}else{
				xemetel.className = "form-control";
			}
			if(xseguro === ""){
				document.getElementById("labelsi"+i).className = "radio-danger" ; 
				document.getElementById("labelno"+i).className = "radio-danger" ; 
			}else{
				document.getElementById("labelsi"+i).className = ""; 
				document.getElementById("labelno"+i).className = ""; 
			}
			if(xnit.value ===""){
				xnit.className = "form-danger";
			}else{
				xnit.className = "form-control";
			}
			if(xclinombre.value ===""){
				xclinombre.className = "form-danger";
			}else{
				xclinombre.className = "form-control";
			}
			if(xclidireccion.value ===""){
				xclidireccion.className = "form-danger";
			}else{
				xclidireccion.className = "form-control";
			}
			//////-- PINTA LOS VACIOS OBLIGATORIOS --///////
			if(xcui.value ==="" || xnombre.value ==="" || xapellido.value ==="" || xgenero.value ==="" || xfecnac.value ==="" || xsangre.value ==="" || xemergencia.value ==="" || xemetel.value ==="" || xseguro ==="" || xnit.value ==="" || xclinombre.value ==="" || xclidireccion.value ===""){
				swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				return;
			}
			arrcui[i] = xcui.value;
			arrtipocui[i] = xtipocui.value;
			arrcodigo[i] = xcodigo.value;
			arrnombre[i] = xnombre.value;
			arrapellido[i] = xapellido.value;
			arrgenero[i] = xgenero.value;
			arrfecnac[i] = xfecnac.value;
			arralergia[i] = xalergia.value;
			arrsangre[i] = xsangre.value;
			arremergencia[i] = xemergencia.value;
			arremetel[i] = xemetel.value;
			arrseguro[i] = xseguro; // es variable, no es input
			arrnit[i] = xnit.value;
			arrclinombre[i] = xclinombre.value;
			arrclidireccion[i] = xclidireccion.value;
			//--
			arrnacionalidad[i] = xnacionalidad.value;
			arrreligion[i] = xreligion.value;
			arridioma[i] = xidioma.value;
			arrmail[i] = xmail.value;
			arrrecoge[i] = xrecoge.value;
			arrredesociales[i] = xredesociales.value;
			//---
			arrpoliza[i] = xpoliza.value;
			arrasegura[i] = xasegura.value;
			arrplan[i] = xplan.value;
			arrasegurado[i] = xasegurado.value;
			arrinstuc[i] = xinstruc.value;
			arrcomment[i] = xcomment.value;
		}
	}else{
		swal("Ohoo!", "Al menos un aulumno debe de ser inscrito...", "error");
		return;
	}
	
	abrir();
	//alert("Deshabilitado por el momento...");
	xajax_Modificar_Hijos(arrcui,arrtipocui,arrcodigo,arrnombre,arrapellido,arrgenero,arrfecnac,arrnacionalidad,arrreligion,arridioma,arrmail,arrsangre,arralergia,
			arremergencia,arremetel,arrrecoge,arrredesociales,arrseguro,arrnit,arrclinombre,arrclidireccion,arrpoliza,arrasegura,arrplan,arrasegurado,arrinstuc,arrcomment,hijos);
}



function valida_seguro(fila){
	cui = document.getElementById("cui"+fila);
	segsi = document.getElementById("segurosi"+fila);
	segno = document.getElementById("segurono"+fila);
	//--
	//--
	poliza = document.getElementById("poliza"+fila);
	asegura = document.getElementById("aseguradora"+fila);
	plan = document.getElementById("plan"+fila);
	asegurado = document.getElementById("asegurado"+fila);
	instruc = document.getElementById("instrucciones"+fila);
	comment = document.getElementById("comentarios"+fila);
	
	if(segsi.checked){
		abrir();
		xajax_Buscar_Seguro(cui.value,fila);
		//--
		poliza.removeAttribute("disabled");
		asegura.removeAttribute("disabled");
		plan.removeAttribute("disabled");
		asegurado.removeAttribute("disabled");
		instruc.removeAttribute("disabled");
		comment.removeAttribute("disabled");
	}else if(segno.checked){
		poliza.value = "";
		asegura.value = "";
		plan.value = "";
		asegurado.value = "";
		instruc.value = "";
		comment.value = "";
		//--
		poliza.setAttribute("disabled","disabled");
		asegura.setAttribute("disabled","disabled");
		plan.setAttribute("disabled","disabled");
		asegurado.setAttribute("disabled","disabled");
		instruc.setAttribute("disabled","disabled");
		comment.setAttribute("disabled","disabled");
	}else{
		return;
	}
	
}


/////////////////------------ CLIENTES  -------------------/////////////

function Cliente(fila){
	nit = document.getElementById('nit'+fila);
	if(nit.value !=""){
		abrir();
		xajax_Show_Cliente(nit.value,fila);
	}
}

///////// Fotografia /////////////
function FotoJs(fila){
	inpfile = document.getElementById("imagen"+fila);
	inpfile.click();
}

function Cargar(fila){
	imagen = document.getElementById("imagen"+fila);
	foto = document.getElementById("foto"+fila);
	if(imagen.value != ""){
		exdoc = comprueba_extension(imagen.value);
		if(exdoc == 1){
			/////////// POST /////////
			var contenedor = document.getElementById("img-container"+fila);
			var boton = document.getElementById("btn-cargar"+fila);
			loadingDiv(contenedor);
			loadingBtn(boton);
			var http = new FormData();
			http.append("request","ajustes");
			http.append("fila", fila);
			http.append("foto", foto.value);
			http.append("imagen", imagen.files[0]);
			var request = new XMLHttpRequest();
			request.open("POST", "EXEcarga_foto.php");
			request.send(http);
			request.onreadystatechange = function(){
				console.log( request );
				if(request.readyState != 4) return;
				if(request.status === 200){
				console.log( request.responseText );
				resultado = JSON.parse(request.responseText);
					if(resultado.status !== true){
						swal("Error", resultado.message , "error").then((value) => {
							console.log( value );
							deloadingDiv(contenedor,'<img class="img-thumbnail" src="../CONFIG/Fotos/ALUMNOS/nofoto.png" alt="..." >');
							deloadingBtn(boton,'<i class="fa fa-camera"></i> Cambiar Fotograf&iacute;a...');
						});	
						return;
					}
					//console.log( resultado );
					swal("Excelente!", resultado.message, "success").then((value) => {
						console.log( value );
						window.location.href = "FRMeditfoto.php?cui="+foto.value;
					});
				}
			};     	
		}else{
			if(exdoc != 1){
				imagen.className = "form-danger";
			}else{
				imagen.className = "form-control";
			}
			swal("Ohoo!", "Este archivo no es extencion .jpg \u00F3 .png.", "error");
		}		
	}else{
		if(imagen.value ==""){
			imagen.className = "form-danger";
		}else{
			imagen.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}


///////// Utilitarias ///////////

function comprueba_extension(archivo) {
	//mierror = "";
	if (!archivo) {
		//Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
		// mierror = "No has seleccionado ningún archivo";
		swal("Ohoo!", "No ha seleccionado un archivo...", "error");
	}else{
		//recupero la extensión de este nombre de archivo
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		//alert (extension);
		//compruebo si la extensión está entre las permitidas
		permitida = false;
		if (".jpg" == extension || ".jpeg" == extension || ".png" == extension) {
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


function valida_fecha(nombre,fila){
	inpfecha = document.getElementById(nombre+fila);
	dia = document.getElementById(nombre+'dia'+fila);
	mes = document.getElementById(nombre+'mes'+fila);
	anio = document.getElementById(nombre+'anio'+fila);
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
		dia.className = "form-control";
	}
	if(mesN > 12){
		mes.className = "form-danger";
		detalle+= "<li>Mes fuera de rango.</li>";
		contador++;
	}else{
		mes.className = "form-control";
	}
	if(anioN > year){
		anio.className = "form-danger";
		detalle = "<li>A&ntilde;o fuera de rango.</li>";
		contador++;
	}else{
		anio.className = "form-control";
	}
	
	if(contador > 0){
		abrir(); 
		msj = '<h5>Formato de fecha no valido!</h5><br> <ol>'+detalle+'</ol><br><br>';
		msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		document.getElementById('lblparrafo').innerHTML = msj;
	}else{
		if(dia.value !== "" && mes.value !== "" && anio.value !== ""){
			var fecha = diaN+"/"+mesN+"/"+anioN;
			inpfecha.value = fecha;
			xajax_Calcular_Edad(fecha,fila);
		}
	}
	
	return;
}
