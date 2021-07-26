//funciones javascript y validaciones
	function Limpiar(){
		swal({
			text: "\u00BFDesea Limpiar la p\u00E1gina?",
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
	
	function openBoleta(hashkey){
		window.open("../../CONFIG/BOLETAS/REPboleta.php?hashkey="+hashkey);
		window.location.reload();
	}
	
	function openBoletas(hashkey,banco,cuenta,anio){
		window.open("../../CONFIG/BOLETAS/REPboletas.php?hashkey="+hashkey+"&ban="+banco+"&cue="+cuenta+"&anio="+anio);
		window.location.href="FRMprogramar.php?hashkey="+hashkey+"&pensum=2";
	}
					
	
	function VerBoleta(alumno,boleta){	
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/datos_boleta.php",{boleta:boleta,alumno:alumno}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
			
	}
	
	
	function EditBoleta(cod){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/editar_boleta.php",{codigo:cod}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
			
	}
	
	function EnlazarBoleta(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/enlazar_boleta.php",{codigo:codigo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
			
	}
	
	function EnlazarBoletaPeriodo(codigo,periodo){
		contenedor = document.getElementById("promt-result");
		contenedor.innerHTML = '<div class="text-center"><br><i class="fa fa-cogs fa-2x"></i><br><br></div>';
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/enlazar_boleta.php",{codigo:codigo,periodo:periodo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
	}
	
	
	function ChangeBoleta(alumno,boleta,cuenta,banco,pago){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/cambiar_boleta.php",{boleta:boleta,cuenta:cuenta,banco:banco,alumno:alumno,pago:pago}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
			
	}
	
	
	function VerBoletaMora(codigo,cuenta,banco){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/datos_mora.php",{cod:codigo,cue:cuenta,ban:banco}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function ConfirmEliminarArchivoCarga(fila){
		swal({
			text: "\u00BFEsta seguro de Eliminar este Archivo?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					var archivo = document.getElementById("archivo"+fila).value;
					xajax_Eliminar_Archivo_Carga_Electronica(archivo);
					break;
				default:
				  return;
			}
		});
	}
	
	function ConfirmEliminarCarga(codigo){
		swal({
			text: "\u00BFEsta seguro de Eliminar esta Carga Electr\u00F3nica? se eliminar\u00E1n los pagos realizados con esta carga, pero no asi los depositos realizados...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Eliminar_Carga_Electronica(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	function ValidarBoletaCobro(){
		cui = document.getElementById("cui").value;
		boleta = document.getElementById("boleta").value;
		if(boleta !== "" && cui !== ""){
			abrir();
			xajax_Valida_Boleta_Cobro(boleta,cui);
		}
	}
	
	function VisualizarBoletas(){
		cui = document.getElementById("cui").value;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/boletas/lista_boleta_alumno.php",{alumno:cui}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
			
	}
	
	function SeleccionarBoletaCobro(fila){
		//// formulario
		banco = document.getElementById("ban");
		cuenta = document.getElementById("cue");
		boleta = document.getElementById("boleta");
		efectivo = document.getElementById("efectivo");
		pagada = document.getElementById("pagada");
		//// modal
		ban = document.getElementById("ban"+fila);
		cue = document.getElementById("cue"+fila);
		pagado = document.getElementById("pagado"+fila);
		doc = document.getElementById("doc"+fila);
		monto = document.getElementById("monto"+fila);
		if(ban !== "" && cue !== "" && doc !== "" && monto !== ""){
			banco.value = ban.value;
			cuenta.value = cue.value;
			pagada.value = pagado.value;
			boleta.value = doc.value;
			efectivo.value = monto.value;
			//---
			banco.setAttribute("disabled","disabled");
			cuenta.setAttribute("disabled","disabled");
			cerrar();
			return;
		}
	}
	
	function GrabarPagosIndividual(){
		periodo = document.getElementById("periodo");
		cui = document.getElementById("cui");
		codint = document.getElementById("codint");
		codboleta = document.getElementById("codboleta");
		cue = document.getElementById("cue");
		ban = document.getElementById("ban");
		pagado = document.getElementById("pagada");
		referencia = document.getElementById("referencia");
		fecha = document.getElementById("fecha");
		hora = document.getElementById("hora");
		efectivo = document.getElementById("efectivo");
		chp = document.getElementById("chp");
		otb = document.getElementById("otb");
		online = document.getElementById("online");
		
		if(periodo.value !=="" && cue.value !=="" && ban.value !=="" && codboleta.value !=="" && referencia.value !=="" && fecha.value !=="" && hora.value !=="" && efectivo.value !=="" && chp.value !=="" && otb.value !=="" && online.value !==""){
			if(parseInt(pagado.value) != 1){
				abrir();
				xajax_Grabar_Pago_Boleta(periodo.value,cui.value,codint.value,codboleta.value,referencia.value,cue.value,ban.value,fecha.value,hora.value,efectivo.value,chp.value,otb.value,online.value);
				//botones
				gra = document.getElementById('grab');
				mod = document.getElementById("mod");
				mod.className = 'btn btn-primary hidden';
				gra.className = 'btn btn-primary hidden';
			}else{
				swal("Ohoo!", "Esta Boleta ya esta reportada como pagada!...", "error");
			}
		}else{
			if(periodo.value ===""){
				periodo.className = "form-danger";
			}else{
				periodo.className = "form-control";
			}
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
			if(referencia.value ===""){
				referencia.className = "form-danger";
			}else{
				referencia.className = "form-control";
			}
			if(fecha.value ===""){
				fecha.className = "form-danger";
			}else{
				fecha.className = "form-control";
			}
			if(hora.value ===""){
				hora.className = "form-danger";
			}else{
				hora.className = "form-control";
			}
			if(efectivo.value ===""){
				efectivo.className = "form-danger";
			}else{
				efectivo.className = "form-control";
			}
			if(chp.value ===""){
				chp.className = "form-danger";
			}else{
				chp.className = "form-control";
			}
			if(otb.value ===""){
				otb.className = "form-danger";
			}else{
				otb.className = "form-control";
			}
			if(online.value ===""){
				online.className = "form-danger";
			}else{
				online.className = "form-control";
			}
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarPagosIndividual(){
		cod = document.getElementById("cod");
		cui = document.getElementById("cui");
		codint = document.getElementById("codint");
		cue = document.getElementById("cue");
		ban = document.getElementById("ban");
		codboleta = document.getElementById("codboleta");
		referencia = document.getElementById("referencia");
		fecha = document.getElementById("fecha");
		efectivo = document.getElementById("efectivo");
		chp = document.getElementById("chp");
		otb = document.getElementById("otb");
		online = document.getElementById("online");
		
		if(cod.value !=="" && cue.value !=="" && ban.value !=="" && codboleta.value !=="" &&  referencia.value !=="" && fecha.value !=="" && efectivo.value !=="" && chp.value !=="" && otb.value !=="" && online.value !==""){
			abrir();
			xajax_Modificar_Pago_Boleta(cod.value,cui.value,codint.value,codboleta.value,referencia.value,cue.value,ban.value,fecha.value,efectivo.value,chp.value,otb.value,online.value);
			//botones
			gra = document.getElementById('grab');
			mod = document.getElementById("mod");
			mod.className = 'btn btn-primary hidden';
			gra.className = 'btn btn-primary hidden';
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
			if(referencia.value ===""){
				referencia.className = "form-danger";
			}else{
				referencia.className = "form-control";
			}
			if(fecha.value ===""){
				fecha.className = "form-danger";
			}else{
				fecha.className = "form-control";
			}
			if(efectivo.value ===""){
				efectivo.className = "form-danger";
			}else{
				efectivo.className = "form-control";
			}
			if(chp.value ===""){
				chp.className = "form-danger";
			}else{
				chp.className = "form-control";
			}
			if(otb.value ===""){
				otb.className = "form-danger";
			}else{
				otb.className = "form-control";
			}
			if(online.value ===""){
				online.className = "form-danger";
			}else{
				online.className = "form-control";
			}
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ConfirmAnularPago(codpago){
		swal({
			text: "\u00BFEsta seguro de anular este pago? se eliminar\u00E1 el pago realizado, pero no asi los depositos realizados a las cuentas bancarias...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true},
			},
			dangerMode: true,
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Eliminar_Pago(codpago);
					break;
				default:
				  return;
			}
		});
	}
	
	
	
	function EditarPagosCarga(){
		abrirMixPromt();
		cod = document.getElementById("cod");
		cui = document.getElementById("cui");
		codint = document.getElementById("codint");
		boleta = document.getElementById("boleta");
		monto = document.getElementById("monto");
		fecha = document.getElementById("fecha");
		hora = document.getElementById("hora");
		
		if(cod.value !=="" && cui.value !=="" && boleta.value !==""){
			xajax_Modificar_Pago_Boleta_Carga(cod.value,cui.value,codint.value,boleta.value,monto.value,fecha.value,hora.value);
		}else{
			if(boleta.value ===""){
				boleta.className = "form-danger";
			}else{
				boleta.className = "form-control";
			}
			if(cui.value ===""){
				cui.className = "form-danger";
			}else{
				cui.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(fecha.value ===""){
				fecha.className = "form-danger";
			}else{
				fecha.className = "form-control";
			}
			if(hora.value ===""){
				hora.className = "form-danger";
			}else{
				hora.className = "form-control";
			}
			
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ConfirmEnlazarBoletas(bolcodigo,bolnumero,bolperiodo,pagcodigo){
		swal({
			text: "\u00BFEsta seguro de enlazar estas 2 boletas (la programada y la registrada en esta Carga Electr\u00F3nica)? \n al realizar esta acci\u00F3n, ya no podr\u00E1 ser revertida...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Enlazar_Boletas(bolcodigo,bolnumero,bolperiodo,pagcodigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function CambiarPagosBoletas(){
		bolcod = document.getElementById("bolcod");
		cuenta = document.getElementById("cuenta");
		banco = document.getElementById("banco");
		pagcod = document.getElementById("pagcod");
		bolnumero = document.getElementById("bolnumero");
		pagnumero = document.getElementById("pagnumero");
		
		if(bolcod.value !=="" && pagcod.value !=="" && bolnumero.value !=="" && pagnumero.value !==""){
			abrirMixPromt();
			xajax_Cambiar_Boletas(bolcod.value,cuenta.value,banco.value,pagcod.value,bolnumero.value,pagnumero.value);
		}else{
			if(bolcod.value ===""){
				swal("Ohoo!", "No se registra el c\u00F3digo de la boleta, probablemente no exista...", "error");
			}
			if(pagcod.value ===""){
				swal("Ohoo!", "No se registra el c\u00F3digo de pago, probablemente no exista...", "error");
			}
			if(bolnumero.value ===""){
				bolnumero.className = "form-danger";
				swal("Ohoo!", "El n\u00FAmero de la boleta es obligatorio", "error");
			}else{
				bolnumero.className = "form-control";
			}
			if(pagnumero.value ===""){
				pagnumero.className = "form-danger";
				swal("Ohoo!", "El n\u00FAmero de boleta en el pago es obligatorio", "error");
			}else{
				pagnumero.className = "form-control";
			}
		}
	}
	
	
	function ConfirmEnlazarPagoAlumno(pago,cuiCorrecto){
		swal({
			text: "\u00BFEsta seguro de enlazar este pago a este Alumno? \n al realizar esta acci\u00F3n, ya no podr\u00E1 ser revertida...",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Enlazar_Pago_Alumno(pago,cuiCorrecto);
					break;
				default:
				  return;
			}
		});
	}
	
/////////////////------------ ALUMNOS  -------------------/////////////
	
	
	function verificar_alumno(cui){
		if(cui !== ""){
			abrir();
			xajax_Buscar_Alumno(cui);
		}
	}
	
	
	function BuscaAlumno(){
		alumno = 0;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/alumno/busca_alumno.php",{alumno:alumno}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function SeleccionarAlumno(fila){
		cui = document.getElementById("Acui"+fila).value;
		nom = document.getElementById("Anom"+fila).value;
		ape = document.getElementById("Aape"+fila).value;
		cli = document.getElementById("Acli"+fila).value;
		nit = document.getElementById("Anit"+fila).value;
		cliente = document.getElementById("Aclinom"+fila).value;
		//--
		//alert(cui);
		document.getElementById("alumno").value = cui;
		document.getElementById("nombre").value = nom + ' ' + ape;
		document.getElementById("cli").value = cli;
		document.getElementById("nit").value = nit;
		document.getElementById("cliente").value = cliente;
		cerrar();
	}
	
	
/////////////////------------ CLIENTES  -------------------/////////////

	function validaCliente(nit,fila){
		swal({
			text: "\u00BFEste Cliente no existe, desea agregarlo?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					document.getElementById("nit"+fila).value = "";
					document.getElementById("cliente"+fila).value = "";
					NewCliente(nit,fila);
					break;
				default:
					cerrar();	
					return;
			}
		});
	}
	
	function Cliente(fila){
		nit = document.getElementById('nit'+fila);
		if(nit.value !=""){
			abrir();
			xajax_Show_Cliente(nit.value,fila);
		}
	}
	
	function ResetCli(fila){
		nom = document.getElementById('cliente'+fila);
		nit = document.getElementById('nit'+fila);
		prov = document.getElementById('cli'+fila);
		nom.value = "";
		nit.value = "";
		prov.value = "";
	}
	
	function NewCliente(nit,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/new_cliente.php",{nit:nit,fila:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function GrabarCliente(fila){
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !="" && nom.value !="" && direc.value != ""){
			abrirMixPromt();
			xajax_Grabar_Cliente(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,fila);
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
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModCliente(codigo,fila){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/mod_cliente.php",{codigo:codigo,fila:fila}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ModificarCliente(fila){
		codigo = document.getElementById('cod1');
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !="" && nom.value !="" && direc.value != ""){
			abrirMixPromt();
			xajax_Modificar_Cliente(codigo.value,nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,fila);
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
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function SeleccionarCliente(fila){
		cod = document.getElementById('Cpcod'+fila);
		nit = document.getElementById('Cpnit'+fila);
		nom = document.getElementById('Cpnom'+fila);
		//--
		filaalumno = document.getElementById('filaalumno').value; //detecta al alumno que se le esta configurando la facturaci\u00F3n
		inpcod = document.getElementById('cli'+filaalumno);
		inpnit = document.getElementById('nit'+filaalumno);
		inpnom = document.getElementById('cliente'+filaalumno);
		//---
		inpcod.value = cod.value;
		inpnit.value = nit.value;
		inpnom.value = nom.value;
		cerrar();
	}
	