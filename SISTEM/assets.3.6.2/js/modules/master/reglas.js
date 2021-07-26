	//funciones javascript y validaciones
	
	function Seteo_config(x,y){
		document.getElementById("mon").value = x;
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
					
	function Cargar(){
		nom = document.getElementById("nom");
		doc = document.getElementById("doc");
		n = parseInt(document.getElementById("clase").value);
		var nombre;
		switch (n){
			case 1: nombre = "logo.jpg"; break;
			case 2: nombre = "replogo.jpg"; break;
			case 3: nombre = "baner.png"; break;
			case 4: nombre = "FondoCarne.png"; break;
		}
		nom.value = nombre;
		if(nom.value !=="" && doc.value !== ""){
			exdoc = comprueba_extension(doc.value);
			if(exdoc === 1){
				abrir();				
				myform = document.forms.f1;
				myform.submit();
			}else{
				if(exdoc !== 1){
					doc.className = " form-danger";
				}else{
					doc.className = " form-control";
				}
				swal("Ohoo!", "Este archivo no es extencion .jpg \u00F3 .png", "error");
			}		
		}else{
			if(doc.value ===""){
				doc.className = " form-danger";
			}else{
				doc.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		mail = document.getElementById("mail");
		pais = document.getElementById("pais");
		dep = document.getElementById("dep");
		mun = document.getElementById("mun");
		//--
		regimen = document.getElementById("regimen");
		iva = document.getElementById("iva");
		mon = document.getElementById("mon");
		var facturar = "";
		var facsi = document.getElementById("facsi");
		var facno = document.getElementById("facno");
		if(facsi.checked){
			facturar = 1;
		}else if(facno.checked){
			facturar = 0;
		}else{
			facturar = "";
		}
		serie = document.getElementById("serie");
		//--
		margen = document.getElementById("margen");
		minimo = document.getElementById("minimo");
		var descargar = "";
		var descsi = document.getElementById("descsi");
		var descno = document.getElementById("descno");
		if(descsi.checked){
			descargar = 1;
		}else if(descno.checked){
			descargar = 0;
		}else{
			descargar = "";
		}
		var cargar = "";
		var carsi = document.getElementById("carsi");
		var carno = document.getElementById("carno");
		if(carsi.checked){
			cargar = 1;
		}else if(carno.checked){
			cargar = 0;
		}else{
			cargar = "";
		}
		//--
		igssemp = document.getElementById("igssemp");
		igsspat = document.getElementById("igsspat");
		irtra = document.getElementById("irtra");
		intecap = document.getElementById("intecap");
		
		if(mail.value !== "" && pais.value !== "" && dep.value !== "" && mun.value !== "" && regimen.value !=="" && iva.value !=="" && mon.value !== "" && facturar !=="" && serie.value !== "" && margen.value !== "" && minimo.value !== "" && descargar !== "" && cargar !== "" && igssemp.value !== "" && igsspat.value !== "" && irtra.value !== "" && intecap.value !== ""){              
			abrir();				
			xajax_Modificar_Reglas(mail.value,pais.value,dep.value,mun.value,regimen.value,iva.value,mon.value,facturar,serie.value,margen.value,minimo.value,descargar,cargar,igssemp.value,igsspat.value,irtra.value,intecap.value);
			//alert("entro");
		}else{
			if(mail.value === ""){
				mail.className = " form-danger text-libre";
			}else{
				mail.className = " form-control text-libre";
			}
			if(pais.value === ""){
				pais.className = " form-danger";
			}else{
				pais.className = " form-control";
			}
			if(dep.value === ""){
				dep.className = " form-danger";
			}else{
				dep.className = " form-control";
			}
			if(mun.value === ""){
				mun.className = " form-danger";
			}else{
				mun.className = " form-control";
			}
			if(regimen.value === ""){
				regimen.className = " form-danger";
			}else{
				regimen.className = " form-control";
			}
			if(mon.value === ""){
				mon.className = " form-danger";
			}else{
				mon.className = " form-control";
			}
			if(facturar === ""){
				document.getElementById("labelfacsi").className = "radio-danger" ; 
				document.getElementById("labelfacno").className = "radio-danger" ; 
			}else{
				document.getElementById("labelfacsi").className = ""; 
				document.getElementById("labelfacno").className = ""; 
			}
			if(iva.value === ""){
				iva.className = " form-danger";
			}else{
				iva.className = " form-control";
			}
			if(serie.value === ""){
				serie.className = " form-danger";
			}else{
				serie.className = " form-control";
			}
			if(margen.value === ""){
				margen.className = " form-danger";
			}else{
				margen.className = " form-control";
			}
			if(minimo.value === ""){
				minimo.className = " form-danger";
			}else{
				minimo.className = " form-control";
			}
			if(descargar === ""){
				document.getElementById("labeldescsi").className = "radio-danger" ; 
				document.getElementById("labeldescno").className = "radio-danger" ; 
			}else{
				document.getElementById("labeldescsi").className = ""; 
				document.getElementById("labeldescno").className = ""; 
			}
			if(cargar === ""){
				document.getElementById("labelcarsi").className = "radio-danger" ; 
				document.getElementById("carno").className = "radio-danger" ; 
			}else{
				document.getElementById("labelcarsi").className = ""; 
				document.getElementById("labelcarno").className = ""; 
			}
			if(igssemp.value === ""){
				igssemp.className = " form-danger";
			}else{
				igssemp.className = " form-control";
			}
			if(igsspat.value === ""){
				igsspat.className = " form-danger";
			}else{
				igsspat.className = " form-control";
			}
			if(irtra.value === ""){
				irtra.className = " form-danger";
			}else{
				irtra.className = " form-control";
			}
			if(intecap.value === ""){
				intecap.className = " form-danger";
			}else{
				intecap.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	
	function ModificarCorreo(){
		mail = document.getElementById("mail");
		if(mail.value !== ""){
			abrir();				
			xajax_Modificar_Regla_Mail(mail.value);
		}else{
			if(mail.value === ""){
				mail.className = " form-danger";
			}else{
				mail.className = " form-control";
			}
			swal("Ohoo!", "El Correo es un campo obligatorio...", "error");
		}
	}
	
	function ModificarMoneda(){
		mon = document.getElementById("mon");
		if(mon.value !== ""){
			abrir();				
			xajax_Modificar_Moneda(mon.value);
		}else{
			if(mon.value === ""){
				mon.className = " form-danger";
			}else{
				mon.className = " form-control";
			}
			swal("Ohoo!", "Seleccione la Moneda a Utilizar...", "error");
		}
	}
	
	function ModificarIntentos(){
		cont = document.getElementById("cont");
		if(cont.value !== ""){
			abrir();				
			xajax_Modificar_Regla_Seguridad(cont.value);
		}else{
			if(cont.value === ""){
				cont.className = " form-danger";
			}else{
				cont.className = " form-control";
			}
			swal("Ohoo!", "El No. de Intentos es un campo obligatorio...", "error");
		}
	}
	
	
	function AgregaMoneda(){
		var cod = 0;
		cerrar();
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/regla/masmonedas.php",{pag:cod}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function QuitarMoneda(){
		var cod = 0;
		cerrar();
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/regla/menosmonedas.php",{pag:pagina}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function GrabarMoneda(){
		desc = document.getElementById("desc1");
		simb = document.getElementById("simb1");
		pais = document.getElementById("pais1");
		camb = document.getElementById("cambio1");
		if(desc.value !== "" && simb.value !== "" && pais.value !== "" && camb.value !== ""){
			xajax_Grabar_Moneda(desc.value,simb.value,pais.value,camb.value);
		}else{
			if(desc.value === ""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(simb.value === ""){
				simb.className = " form-danger";
			}else{
				simb.className = " form-control";
			}
			if(pais.value === ""){
				pais.className = " form-danger";
			}else{
				pais.className = " form-control";
			}
			if(camb.value === ""){
				camb.className = " form-danger";
			}else{
				camb.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarMoneda(){
		cod = document.getElementById("cod1");
		desc = document.getElementById("desc1");
		simb = document.getElementById("simb1");
		pais = document.getElementById("pais1");
		camb = document.getElementById("cambio1");
		if(cod.value !== "" && desc.value !== "" && simb.value !== "" && pais.value !== "" && camb.value !== ""){
			xajax_Modificar_Moneda(cod.value,desc.value,simb.value,pais.value,camb.value);
		}else{
			if(desc.value === ""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(simb.value === ""){
				simb.className = " form-danger";
			}else{
				simb.className = " form-control";
			}
			if(pais.value === ""){
				pais.className = " form-danger";
			}else{
				pais.className = " form-control";
			}
			if(camb.value === ""){
				camb.className = " form-danger";
			}else{
				camb.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
				
	
	function CambiaSitMoneda(pagina){
		mon = document.getElementById("mon1");
		if(mon.value !== ""){
			swal({
				text: "\u00BFEsta seguro de quitar esta moneda del listado?",
				icon: "warning",
				buttons: {
					cancel: "Cancelar",
					ok: { text: "Aceptar", value: true,},
				}
			}).then((value) => {
				switch (value) {
					case true:
						xajax_Cambia_Sit_Moneda(mon.value,pagina);
						break;
					default:
					  return;
				}
			});
		}else{
			if(mon.value === ""){
				mon.className = " form-danger";
			}else{
				mon.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function GrabarTasaCambio(){
		mon = document.getElementById("mon");
		tcamb = document.getElementById("tcamb");
		
		if(mon.value !== "" && tcamb.value !== ""){
			abrir();				
			xajax_Actualiza_Tipo_Cambio(mon.value,tcamb.value);
		}else{
			if(mon.value === ""){
				mon.className = " form-danger";
			}else{
				mon.className = " form-control";
			}
			if(tcamb.value === ""){
				tcamb.className = " form-danger";
			}else{
				tcamb.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function AgregaSerie(){
		var cod = 0;
		cerrar();
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/regla/masserie.php",{x:cod}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
							
	function GrabarSerie(){
		desc = document.getElementById("desc1");
		num = document.getElementById("num1");
		
		if(desc.value !== "" && num.value !== ""){
			xajax_Grabar_Serie(num.value,desc.value);
		}else{
			if(desc.value === ""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(num.value === ""){
				num.className = " form-danger";
			}else{
				num.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarSerie(){
		cod = document.getElementById("cod1");
		desc = document.getElementById("desc1");
		num = document.getElementById("num1");
		
		if(cod.value !== "" && desc.value !== "" && num.value !== ""){
			xajax_Modificar_Serie(cod.value,num.value,desc.value);
		}else{
			if(desc.value === ""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(num.value === ""){
				num.className = " form-danger";
			}else{
				num.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
				
	
