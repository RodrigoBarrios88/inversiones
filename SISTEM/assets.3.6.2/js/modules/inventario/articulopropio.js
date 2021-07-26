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
						
	
	function PromtCaptura(){
		var n1 = 1;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/articulopropio/get_masa.php",{variable1:n1}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function DownloadFormato(){
		window.location = '../promts/articulopropio/download_formato.php';
	}
	
	function ConfirmCargar(){
		gru = document.getElementById('gru1');
		doc = document.getElementById('doc');
		
		if(gru.value !=="" && doc.value !== ""){
			myform = document.forms["f2"];
			myform.submit();
		}else{
			if(gru.value ===""){
				gru.className = " form-danger";
			}else{
				gru.className = " form-control";
			}
			if(doc.value ===""){
				doc.className = " form-danger";
			}else{
				doc.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Grabar(){
		gru = document.getElementById('gru');
		nom = document.getElementById("artnom");
		desc = document.getElementById('desc');
		marca = document.getElementById("marca");
		umed = document.getElementById("umed");
		
		if(gru.value !=="" && nom.value !=="" && desc.value !=="" && marca.value !=="" && umed.value !== ""){
			abrir();
			 xajax_Grabar_Articulo(gru.value,nom.value,desc.value,marca.value,umed.value);
			//botones
			gra = document.getElementById("grab");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(gru.value ===""){
				gru.className = " form-danger";
			}else{
				gru.className = " form-control";
			}
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(marca.value ===""){
				marca.className = " form-danger";
			}else{
				marca.className = " form-control";
			}
			if(umed.value ===""){
				umed.className = " form-danger";
			}else{
				umed.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function Modificar(){
		gru = document.getElementById('gru');
		nom = document.getElementById("artnom");
		desc = document.getElementById('desc');
		marca = document.getElementById("marca");
		umed = document.getElementById("umed");
		
		if(gru.value !=="" && nom.value !== "" && desc.value !=="" && marca.value !=="" && umed.value !== ""){
			abrir();
			xajax_Modificar_Articulo(cod.value,gru.value,nom.value,desc.value,marca.value,umed.value);
			//botones
			gra = document.getElementById("grab");
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
		}else{
			if(gru.value ===""){
				gru.className = " form-danger";
			}else{
				gru.className = " form-control";
			}
			if(nom.value ===""){
				nom.className = " form-danger";
			}else{
				nom.className = " form-control";
			}
			if(desc.value ===""){
				desc.className = " form-danger";
			}else{
				desc.className = " form-control";
			}
			if(marca.value ===""){
				marca.className = " form-danger";
			}else{
				marca.className = " form-control";
			}
			if(umed.value ===""){
				umed.className = " form-danger";
			}else{
				umed.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Articulo(art,grup){
		swal({
			text: "\u00BFEsta seguro de deshabilitar este Art\u00E1culo?, No podra ser usado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Articulo(art,grup,0);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Habilita_Articulo(art,grup){
		swal({
			text: "\u00BFEsta seguro de habilitar este Art\u00E1culo?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Articulo(art,grup,1);
					break;
				default:
				  return;
			}
		});
	}	
	

///////////// Articulos en Masa
	function ConfirmGrabarList(){
		swal({
			text: "\u00BFDesea guardar el listado de articulos?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					GrabarMasa();
					break;
				default:
				  return;
			}
		});
	}	
	
	function GrabarMasa(){
		filas = document.getElementById('filas').value;
		gru = document.getElementById('gru').value;
		suc = document.getElementById('suc').value;
		//--
		if(filas > 0){
			arrnombre = new Array([]);
			arrdesc = new Array([]);
			arrmarca = new Array([]);
			arrserie = new Array([]);
			arrprei = new Array([]);
			arrprea = new Array([]);
			arrmon = new Array([]);
			arrtcambio = new Array([]);
			for (var i = 1; i <= filas; i++) {
				arrnombre[i] = document.getElementById('nombre'+i).value;
				arrdesc[i] = document.getElementById('desc'+i).value;
				arrmarca[i] = document.getElementById('marca'+i).value;
				arrserie[i] = document.getElementById('serie'+i).value;
				arrprei[i] = document.getElementById('preini'+i).value;
				arrprea[i] = document.getElementById('preact'+i).value;
				arrmon[i] = document.getElementById('mon'+i).value;
				arrtcambio[i] = document.getElementById('tcambio'+i).value;
			}
			xajax_Grabar_Masa(gru,suc,arrnombre,arrdesc,arrmarca,arrserie,arrprei,arrprea,arrmon,arrtcambio,filas);
		}else{
			swal("Ohoo!", "No hay filas de registros para ser cargados...", "info");
		}	
	}
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// INVENTARIO ///////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
				
	function NewFilaCarga(){
		nfilas = document.getElementById("filas").value;
		cant = document.getElementById("cant").value;
		if(cant >= 1){
			abrir();
			var bandera = false;
			var arrnum = "|";
			var arrpreini = "|";
			var arrprefin = "|";
			var arrmon = "|";
			
			for(var i = 1; i <= nfilas; i ++){
				//extrae datos del grid
				desc = document.getElementById("desc"+i).value;
				marca = document.getElementById("marca"+i).value;
				num = document.getElementById("num"+i).value;
				mon = document.getElementById("mon"+i).value;
				//-- crea string a convertir en arrays
				arrnum+= desc+"|";
				arrpreini+= marca+"|";
				arrprefin+= num+"|";
				arrmon+= mon+"|";
			}
			// ejecuta la funcion de ajax para refrescar el grid
			xajax_Grid_Fila_Carga(cant,arrnum,arrpreini,arrprefin,arrmon);
		}else{
			swal("Ohoo!", "El minimo de articulos ingresados debe ser uno (01)...", "error");
		}
	}
	
	
	function QuitarFilaCarga(x){
		nfilas = document.getElementById("filas").value;
		if(nfilas > 1){
			nfilas = document.getElementById("filas").value;
			abrir();
			var bandera = false;
			var arrnum = "|";
			var arrpreini = "|";
			var arrprefin = "|";
			var arrmon = "|";
			var C = 1;
			for(var i = 1; i <= nfilas; i ++){
				num = document.getElementById("num"+i).value;
				preini = document.getElementById("preini"+i).value;
				prefin = document.getElementById("prefin"+i).value;
				mon = document.getElementById("mon"+i).value;
				//-- llena arrays
				if(i !== x){
					arrnum+= num+"|";
					arrpreini+= preini+"|";
					arrprefin+= prefin+"|";
					arrmon+= mon+"|";
				}
			}
			nfilas--;
			xajax_Grid_Fila_Carga(nfilas,arrnum,arrpreini,arrprefin,arrmon);
		}
	}
	
	function GrabarCarga(){
		abrir();
		nfilas = document.getElementById("filas").value;
		cant = document.getElementById("cant");
		gru = document.getElementById("gru");
		art = document.getElementById("art");
		suc = document.getElementById("suc");
		if(cant.value === nfilas){
			if (gru.value !=="" && art.value !=="" && suc.value !== "") {
				var arrnum = "|";
				var arrpreini = "|";
				var arrprefin = "|";
				var arrmon = "|";
				
				for(var i = 1; i <= nfilas; i ++){
					//extrae datos del grid
					num = document.getElementById("num"+i).value;
					preini = document.getElementById("preini"+i).value;
					prefin = document.getElementById("prefin"+i).value;
					mon = document.getElementById("mon"+i).value;
					if (num !=="" && preini !=="" && prefin !== "" && mon !== "") {
						//-- crea string a convertir en arrays
						arrnum+= num+"|";
						arrpreini+= preini+"|";
						arrprefin+= prefin+"|";
						arrmon+= mon+"|";
					}else{
						swal("Ohoo!", "Uno o mas datos de la carga estan vacios en la fila "+i+" ...", "error");
						return;
					}
				}
				// ejecuta la funcion de ajax para refrescar el grid
				xajax_Grabar_Carga(nfilas,gru.value,art.value,suc.value,arrnum,arrpreini,arrprefin,arrmon);
			}else{
				if(gru.value ===""){
					gru.className = " form-danger";
				}else{
					gru.className = " form-control";
				}
				if(art.value ===""){
					art.className = " form-danger";
				}else{
					art.className = " form-control";
				}
				if(suc.value ===""){
					suc.className = " form-danger";
				}else{
					suc.className = " form-control";
				}
			}
		}else{
			cant.className = " form-danger";
			swal("Ohoo!", "Las filas en la tabla de cargas y la cantidad deseada para carga no coinciden...", "error");
		}
	}
	
	function ConfirmCargaJS(){
		swal({
			text: "\u00BFEsta seguro de cargar a inventario est(e)(os) articulo(s)?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					GrabarCarga();
					break;
				default:
				  return;
			}
		});
	}	
	
	function Deshabilita_Inventario(cod,art,grup){
		swal({
			text: "\u00BFEsta seguro de deshabilitar este detalle de inventario?, No podra ser usado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Inventario(cod,grup,art,0);
					break;
				default:
				  return;
			}
		});
	}	
	
	function Habilita_Inventario(cod,art,grup){
		swal({
			text: "\u00BFEsta seguro de habilitar este detalle de inventario?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Inventario(cod,grup,art,1);
					break;
				default:
				  return;
			}
		});
	}	
	
	function ModificarInv(){
		abrir();
		cod = document.getElementById('cod');
		gru = document.getElementById('gru');
		art = document.getElementById('art');
		suc = document.getElementById("suc");
		num = document.getElementById("num");
		preini = document.getElementById("preini");
		prefin = document.getElementById("prefin");
		mon = document.getElementById("mon");
		
		if(cod.value !=="" && gru.value !=="" && art.value !== "" && preini.value !== "" && prefin.value !== "" && suc.value !== "" && num.value !== "" && mon.value !== ""){
			xajax_Modificar_Inventario(cod.value,gru.value,art.value,suc.value,num.value,preini.value,prefin.value,mon.value);
		}else{
			if(gru.value ===""){
				gru.className = " form-danger";
			}else{
				gru.className = " form-control";
			}
			if(art.value ===""){
				art.className = " form-danger";
			}else{
				art.className = " form-control";
			}
			if(preini.value ===""){
				preini.className = " form-danger";
			}else{
				preini.className = " form-control";
			}
			if(prefin.value ===""){
				prefin.className = " form-danger";
			}else{
				prefin.className = " form-control";
			}
			if(suc.value ===""){
				suc.className = " form-danger";
			}else{
				suc.className = " form-control";
			}
			if(num.value ===""){
				num.className = " form-danger";
			}else{
				num.className = " form-control";
			}
			if(mon.value ===""){
				mon.className = " form-danger";
			}else{
				mon.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
////////////////////// DEPRECIACIONES /////////////////////////////////

	function ConfirmDepreciacionesJS(){
		swal({
			text: "\u00BFEsta seguro de calcular la depreciaci\u00F3n de est(e)(os) mes(es)? Los datos son irreversibles despues de esta acci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					GabarDepreciaciones();
					break;
				default:
				  return;
			}
		});
	}	

	function GabarDepreciaciones(){
		abrir();
		anio = document.getElementById('anio');
		arrmeses = new Array();
		if(anio.value !==""){
			var C = 1;
			for(i = 1; i <= 12; i++){
				chk = document.getElementById('chk'+i);
				if (chk.checked) {
					arrmeses[C] = i;
					C++;
				}
			}
			C--;
			if (C > 0) {
				xajax_Grabar_Depreciacion(anio.value,arrmeses,C);
			}else{
				swal("Ohoo!", "No ha llenado seleccionado ningun mes...", "info");
			}
		}else{
			if(anio.value ===""){
				anio.className = " form-danger";
			}else{
				anio.className = " form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
////////------ Reportes ------------------//////////////

	function ReporteGrupo(){
		myform = document.forms.f1;
		myform.action ="REPgrupos.php";
		myform.submit();
	}
	
	function ReporteArticulo(){
		myform = document.forms.f1;
		myform.action ="REParticulos.php";
		myform.submit();
	}
	
		
	