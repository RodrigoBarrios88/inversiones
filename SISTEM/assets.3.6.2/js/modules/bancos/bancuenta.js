//funciones javascript y validaciones
	function Limpiar(){
		texto = "Desea Limpiar la Pagina?, perdera los datos escritos...";
		acc = "location.reload();";
		ConfirmacionJs(texto,acc);
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
		ban = document.getElementById("ban");
		suc = document.getElementById("suc");
		num = document.getElementById("num");
		nom = document.getElementById("nom");
		tip = document.getElementById("tip");
		mon = document.getElementById("mon");
		fpag = document.getElementById("fpag");
		tasa = document.getElementById("tasa");
		dias = document.getElementById("dias");
		fini = document.getElementById("fini");
		monto = document.getElementById("monto");
		
		if(ban.value !=="" && suc.value !=="" && nom.value !=="" && num.value !=="" && tip.value !=="" && mon.value !=="" && fpag.value !=="" && tasa.value !=="" && dias.value !=="" && fini.value !=="" && monto.value !==""){
			abrir();
			xajax_Grabar_Cuenta(ban.value,suc.value,num.value,nom.value,tip.value,mon.value,fpag.value,tasa.value,dias.value,fini.value,monto.value);
		}else{
			if(ban.value ===""){
				ban.className = "form-danger";
			}else{
				ban.className = "form-control";
			}
			if(suc.value ===""){
				suc.className = "form-danger";
			}else{
				suc.className = "form-control";
			}
			if(num.value ===""){
				num.className = "form-danger";
			}else{
				num.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(tip.value ===""){
				tip.className = "form-danger";
			}else{
				tip.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(fpag.value ===""){
				fpag.className = "form-danger";
			}else{
				fpag.className = "form-control";
			}
			if(tasa.value ===""){
				tasa.className = "form-danger";
			}else{
				tasa.className = "form-control";
			}
			if(dias.value ===""){
				dias.className = "form-danger";
			}else{
				dias.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-danger";
			}else{
				fini.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");				
		}
	}
	
	function Modificar(){
		cod = document.getElementById("cod");
		ban = document.getElementById("ban");
		num = document.getElementById("num");
		nom = document.getElementById("nom");
		tip = document.getElementById("tip");
		mon = document.getElementById("mon");
		fpag = document.getElementById("fpag");
		tasa = document.getElementById("tasa");
		dias = document.getElementById("dias");
		fini = document.getElementById("fini");
		
		if(cod.value !=="" && ban.value !=="" && suc.value !=="" && num.value !=="" && nom.value !=="" && tip.value !=="" && mon.value !=="" && fpag.value !=="" && tasa.value !=="" && dias.value !=="" && fini.value !==""){
			abrir();
			xajax_Modificar_Cuenta(cod.value,ban.value,suc.value,num.value,nom.value,tip.value,mon.value,fpag.value,tasa.value,dias.value,fini.value);
			//botones
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
		}else{
			if(ban.value ===""){
				ban.className = "form-danger";
			}else{
				ban.className = "form-control";
			}
			if(suc.value ===""){
				suc.className = "form-danger";
			}else{
				suc.className = "form-control";
			}
			if(num.value ===""){
				num.className = "form-danger";
			}else{
				num.className = "form-control";
			}
			if(nom.value ===""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(tip.value ===""){
				tip.className = "form-danger";
			}else{
				tip.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(fpag.value ===""){
				fpag.className = "form-danger";
			}else{
				fpag.className = "form-control";
			}
			if(tasa.value ===""){
				tasa.className = "form-danger";
			}else{
				tasa.className = "form-control";
			}
			if(dias.value ===""){
				dias.className = "form-danger";
			}else{
				dias.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-danger";
			}else{
				fini.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}

	
	function BuscarSaldo(){
		ban = document.getElementById("ban");
		num = document.getElementById("num");
		tip = document.getElementById("tip");
		mon = document.getElementById("mon");
		
		if(ban.value !=="" || num.value !=="" || tip.value !=="" || mon.value !==""){
			abrir();
			xajax_Buscar_Cuenta_Saldo(ban.value,num.value,tip.value,mon.value);
		}else{
			if(ban.value ===""){
				ban.className = "form-info";
			}else{
				ban.className = "form-control";
			}
			if(num.value ===""){
				num.className = "form-info";
			}else{
				num.className = "form-control";
			}
			if(tip.value ===""){
				tip.className = "form-info";
			}else{
				tip.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-info";
			}else{
				mon.className = "form-control";
			}
			swal("Ohoo!", "Seleccione al menos un criterio de busqueda...", "info");
		}
	}
	
	function Deshabilita_Cuenta(cod,ban){
		swal({
			text: "\u00BFEsta seguro de deshabilitar esta Cuenta de Banco?, No podra ser usada con esta situaci&oacute;n...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Cuenta_Banco(cod,ban,0);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}
	
	function Habilita_Cuenta(cod,ban){
		swal({
			text: "\u00BFEsta seguro de habilitar esta Cuenta de Banco?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Situacion_Cuenta_Banco(cod,ban,1);
					break;
				default:
				  swal("", "Acci\u00F3n Cancelada...", "info");
			}
		});
	}
	
	
	function BuscarCuenta(acc){
		ban = document.getElementById("ban");
		num = document.getElementById("num");
		tip = document.getElementById("tip");
		mon = document.getElementById("mon");
		
		if(ban.value !=="" || num.value !=="" || tip.value !=="" || mon.value !==""){
			abrir();
			xajax_Buscar_Cuenta_Movimiento(ban.value,num.value,tip.value,mon.value,acc);
		}else{
			if(ban.value ===""){
				ban.className = "form-info";
			}else{
				ban.className = "form-control";
			}
			if(num.value ===""){
				num.className = "form-info";
			}else{
				num.className = "form-control";
			}
			if(tip.value ===""){
				tip.className = "form-info";
			}else{
				tip.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-info";
			}else{
				mon.className = "form-control";
			}
			swal("Ohoo!", "Seleccione al menos un criterio de busqueda...", "info");
		}
	}
	
	
	function Seleccionar_Cuenta(cuenta,banco,numero,nombre,tipo){
		//alert("entro");
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/bancos/movcuenta.php",{cue:cuenta,ban:banco,num:numero,bann:nombre,tip:tipo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function GrabarMovimiento(){
		ban = document.getElementById("ban1");
		cue = document.getElementById("cue1");
		mov = document.getElementById("mov1");
		mont = document.getElementById("mont1");
		doc = document.getElementById("doc1");
		tip = document.getElementById("tip1");
		mot = document.getElementById("mot1");
		fecha = document.getElementById("fecha1");
		
		if(ban.value !=="" && cue.value !=="" && mov.value !=="" && mont.value !=="" && doc.value !=="" && tip.value !=="" && fecha.value !==""){
			abrirMixPromt();
			xajax_Grabar_Movimiento_Cuenta(ban.value,cue.value,mov.value,mont.value,doc.value,tip.value,mot.value,fecha.value);
		}else{
			if(ban.value ===""){
				ban.className = "form-danger";
			}else{
				ban.className = "form-control";
			}
			if(cue.value ===""){
				cue.className = "form-danger";
			}else{
				cue.className = "form-control";
			}
			if(mov.value ===""){
				mov.className = "form-danger";
			}else{
				mov.className = "form-control";
			}
			if(mont.value ===""){
				mont.className = "form-danger";
			}else{
				mont.className = "form-control";
			}
			if(doc.value ===""){
				doc.className = "form-danger";
			}else{
				doc.className = "form-control";
			}
			if(tip.value ===""){
				tip.className = "form-danger";
			}else{
				tip.className = "form-control";
			}
			if(fecha.value ===""){
				fecha.className = "form-danger";
			}else{
				fecha.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
		