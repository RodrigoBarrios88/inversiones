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

function openFacturas(hashkey){
	window.open("../../CONFIG/FACTURAS/REPfacturas_carga.php?hashkey="+hashkey);
	window.location.href="FRMlist_cargas.php";
} 

function openFactura(hashkey1,hashkey2,hashkey){
	window.open("../CPBOLETAFACTURAS/CPREPORTES/REPfactura.php?hashkey1="+hashkey1+"&hashkey2="+hashkey2);
	window.location.href="FRMalumno.php?hashkey="+hashkey+"&acc=FAC";
}

function openRecibos(hashkey){
	window.open("../../CONFIG/FACTURAS/REPrecibos_carga.php?hashkey="+hashkey);
	window.location.href="FRMlist_cargas.php";
}

function openRecibo(hashkey1,hashkey2,hashkey){
	window.open("../../CONFIG/FACTURAS/REPrecibo.php?hashkey1="+hashkey1+"&hashkey2="+hashkey2);
	window.location.href="FRMalumno.php?hashkey="+hashkey+"&acc=REC"; 
	//console.log("hashkey3");
}
				
function VerBoleta(alumno,boleta,cuenta,banco){	
	//Realiza una peticion de contenido a la contenido.php
	$.post("../promts/boletas/datos_boleta.php",{boleta:boleta,cuenta:cuenta,banco:banco,alumno:alumno}, function(data){
	// Ponemos la respuesta de nuestro script en el DIV recargado
	$("#Pcontainer").html(data);
	});
	abrirModal();
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

///////////////////////// FACTURAS POR BOLETAS /////////////////////////////////

function GrabarFacturasCarga(){
	abrir();
	carga = document.getElementById("carga"); 
	suc = document.getElementById("suc");
	pv = document.getElementById("pv");
	serie = document.getElementById("serie");
	numero = document.getElementById("facc");
	mon = document.getElementById("mon");
	var montext = mon.options[mon.selectedIndex].text;
		//-- extrae el simbolo de la moneda y tipo de cambio
		monchunk = montext.split("/");
		//var Vmond = monchunk[0]; // Simbolo de Moneda
		//var Vmons = monchunk[1]; // Simbolo de Moneda
		var tcambio = monchunk[2]; // Tipo de Cambio
			tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
			tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
	//--
	filas = parseInt(document.getElementById("filas").value);
	var filas_validas = 1;
	if(suc.value !=="" && pv.value !=="" && serie.value !=="" && numero.value !=="" && mon.value !==""){
		if(filas > 0){
			arralumno = new Array([]);
			arrcodpago = new Array([]);
			arrboleta = new Array([]);
			arrfecha = new Array([]);
			arrcli = new Array([]);
			arrmonto = new Array([]);
			arrdesc = new Array([]);
			
			for(var i = 1; i <= filas; i++){
				facturado = parseInt(document.getElementById("facturado"+i).value);
				if(facturado === 0){
					arralumno[filas_validas] = document.getElementById("alumno"+i).value;
					arrcodpago[filas_validas] = document.getElementById("codpago"+i).value;
					arrboleta[filas_validas] = document.getElementById("boleta"+i).value;
					arrfecha[filas_validas] = document.getElementById("fecha"+i).value;
					arrcli[filas_validas] = document.getElementById("cli"+i).value;
					arrmonto[filas_validas] = document.getElementById("monto"+i).value;
					arrdesc[filas_validas] = document.getElementById("desc"+i).value;
					filas_validas++;
				}
			}
			filas_validas--;
			
			if(filas_validas > 0){
				xajax_Grabar_Factura_Carga_Electronica(numero.value,serie.value,suc.value,pv.value,arralumno,arrcli,carga.value,arrcodpago,arrboleta,arrdesc,arrmonto,mon.value,tcambio,arrfecha,filas_validas);
			}else{
				swal("Ohoo!", "Los pagos en esta carga ya se les gener\u00F3 factura o recibo.  No hay pagos pendientes de facturaci\u00F3n...", "info");
			}
		}else{
			swal("Ohoo!", "No hay filas de registros para ser cargados", "info");
		}
	}else{
		if(suc.value ===""){
			suc.className = "form-danger";
		}else{
			suc.className = "form-control";
		}
		if(pv.value ===""){
			pv.className = "form-danger";
		}else{
			pv.className = "form-control";
		}
		if(serie.value ===""){
			serie.className = "form-danger";
		}else{
			serie.className = "form-control";
		}
		if(numero.value ===""){
			numero.className = "form-danger";
		}else{
			numero.className = "form-control";
		}
		if(mon.value ===""){
			mon.className = "form-danger";
		}else{
			mon.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}


function GrabarFactura(){
	abrir();
	codpago = document.getElementById("codpago");
	suc = document.getElementById("suc");
	pv = document.getElementById("pv");
	serie = document.getElementById("serie");
	numero = document.getElementById("facc");
	desc = document.getElementById("desc");
	mon = document.getElementById("mon");
	var montext = mon.options[mon.selectedIndex].text;
	//-- extrae el simbolo de la moneda y tipo de cambio
	monchunk = montext.split("/");
	//var Vmond = monchunk[0]; // Simbolo de Moneda
	//var Vmons = monchunk[1]; // Simbolo de Moneda
	var tcambio = monchunk[2]; // Tipo de Cambio
		tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
		tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1 
	//--
	alumno = document.getElementById("cui");
	boleta = document.getElementById("boleta");
	fecha = document.getElementById("fecha");
	cli = document.getElementById("cli");
	nit = document.getElementById("nit");
	monto = document.getElementById("monto");
	if(suc.value !=="" && pv.value !=="" && serie.value !=="" && numero.value !=="" && desc.value !=="" && mon.value !=="" && alumno.value !=="" && boleta.value !=="" && fecha.value !=="" && monto.value !==""){
		xajax_Grabar_Factura_Individual(numero.value,serie.value,suc.value,pv.value,alumno.value,cli.value,codpago.value,boleta.value,desc.value,monto.value,mon.value,tcambio,fecha.value);
	}else{
		if(suc.value ===""){
			suc.className = "form-danger";
		}else{
			suc.className = "form-control";
		}
		if(pv.value ===""){
			pv.className = "form-danger";
		}else{
			pv.className = "form-control";
		}
		if(serie.value ===""){
			serie.className = "form-danger";
		}else{
			serie.className = "form-control";
		}
		if(numero.value ===""){
			numero.className = "form-danger";
		}else{
			numero.className = "form-control";
		}
		if(desc.value ===""){
			desc.className = "form-danger";
		}else{
			desc.className = "form-control";
		}
		if(mon.value ===""){
			mon.className = "form-danger";
		}else{
			mon.className = "form-control";
		}
		if(alumno.value ===""){
			alumno.className = "form-danger";
		}else{
			alumno.className = "form-control";
		}
		if(boleta.value ===""){
			boleta.className = "form-danger";
		}else{
			boleta.className = "form-control";
		}
		if(fecha.value ===""){
			fecha.className = "form-danger";
		}else{
			fecha.className = "form-control";
		}
		if(monto.value ===""){
			monto.className = "form-danger";
		}else{
			monto.className = "form-control";
		}
		if(nit.value ===""){
			nit.className = "form-danger";
		}else{
			nit.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}


function ModificarFactura(){
	abrir();
	codpago = document.getElementById("codpago");
	suc = document.getElementById("suc");
	pv = document.getElementById("pv");
	serie = document.getElementById("serie");
	numero = document.getElementById("facc");
	desc = document.getElementById("desc");
	mon = document.getElementById("mon");
	var montext = mon.options[mon.selectedIndex].text;
	//-- extrae el simbolo de la moneda y tipo de cambio
	monchunk = montext.split("/");
	//var Vmond = monchunk[0]; // Simbolo de Moneda
	//var Vmons = monchunk[1]; // Simbolo de Moneda
	var tcambio = monchunk[2]; // Tipo de Cambio
		tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
		tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1 
	//--
	alumno = document.getElementById("cui");
	boleta = document.getElementById("boleta");
	fecha = document.getElementById("fecha");
	cli = document.getElementById("cli");
	nit = document.getElementById("nit");
	monto = document.getElementById("monto");
	if(suc.value !=="" && pv.value !=="" && serie.value !=="" && numero.value !=="" && desc.value !=="" && mon.value !=="" && alumno.value !=="" && boleta.value !=="" && fecha.value !=="" && monto.value !==""){
		xajax_Modificar_Factura_Individual(numero.value,serie.value,suc.value,pv.value,alumno.value,cli.value,codpago.value,boleta.value,desc.value,monto.value,mon.value,tcambio,fecha.value);
	}else{
		if(suc.value ===""){
			suc.className = "form-danger";
		}else{
			suc.className = "form-control";
		}
		if(pv.value ===""){
			pv.className = "form-danger";
		}else{
			pv.className = "form-control";
		}
		if(serie.value ===""){
			serie.className = "form-danger";
		}else{
			serie.className = "form-control";
		}
		if(numero.value ===""){
			numero.className = "form-danger";
		}else{
			numero.className = "form-control";
		}
		if(desc.value ===""){
			desc.className = "form-danger";
		}else{
			desc.className = "form-control";
		}
		if(mon.value ===""){
			mon.className = "form-danger";
		}else{
			mon.className = "form-control";
		}
		if(alumno.value ===""){
			alumno.className = "form-danger";
		}else{
			alumno.className = "form-control";
		}
		if(boleta.value ===""){
			boleta.className = "form-danger";
		}else{
			boleta.className = "form-control";
		}
		if(fecha.value ===""){
			fecha.className = "form-danger";
		}else{
			fecha.className = "form-control";
		}
		if(monto.value ===""){
			monto.className = "form-danger";
		}else{
			monto.className = "form-control";
		}
		if(nit.value ===""){
			nit.className = "form-danger";
		}else{
			nit.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}

function ConfirmAnularFactura(serie,numero,codpago){
	swal({
		title: "\u00BFANULAR?",
		text: "\u00BFEsta seguro de ANULAR esta Factura?",
		icon: "warning",
		buttons: {
			cancel: "Cancelar",
			ok: { text: "Aceptar", value: true,},
		}
	}).then((value) => {
		switch (value) {
			case true:
				xajax_Anular_Factura(serie,numero,codpago);
				break;
			default:
			  return;
		}
	});
}


///////////////////////// RECIBOS POR BOLETAS /////////////////////////////////

function GrabarRecibosCarga(){
	abrir();
	carga = document.getElementById("carga");
	suc = document.getElementById("suc");
	pv = document.getElementById("pv");
	serie = document.getElementById("serie");
	numero = document.getElementById("numero");
	mon = document.getElementById("mon");
	var montext = mon.options[mon.selectedIndex].text;
		//-- extrae el simbolo de la moneda y tipo de cambio
		monchunk = montext.split("/");
		//var Vmond = monchunk[0]; // Simbolo de Moneda
		//var Vmons = monchunk[1]; // Simbolo de Moneda
		var tcambio = monchunk[2]; // Tipo de Cambio
			tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
			tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
	//--
	filas = parseInt(document.getElementById("filas").value);
	var filas_validas = 1;
	if(suc.value !=="" && pv.value !=="" && serie.value !=="" && numero.value !=="" && mon.value !==""){
		if(filas > 0){
			arralumno = new Array([]);
			arrcodpago = new Array([]);
			arrboleta = new Array([]);
			arrfecha = new Array([]);
			arrcli = new Array([]);
			arrmonto = new Array([]);
			arrdesc = new Array([]);
			
			for(var i = 1; i <= filas; i++){
				facturado = parseInt(document.getElementById("facturado"+i).value);
				if(facturado === 0){
					arralumno[filas_validas] = document.getElementById("alumno"+i).value;
					arrcodpago[filas_validas] = document.getElementById("codpago"+i).value;
					arrboleta[filas_validas] = document.getElementById("boleta"+i).value;
					arrfecha[filas_validas] = document.getElementById("fecha"+i).value;
					arrcli[filas_validas] = document.getElementById("cli"+i).value;
					arrmonto[filas_validas] = document.getElementById("monto"+i).value;
					arrdesc[filas_validas] = document.getElementById("desc"+i).value;
					filas_validas++;
				}
			}
			filas_validas--;
			if(filas_validas > 0){
				xajax_Grabar_Recibo_Carga_Electronica(numero.value,serie.value,suc.value,pv.value,arralumno,arrcli,carga.value,arrcodpago,arrboleta,arrdesc,arrmonto,mon.value,tcambio,arrfecha,filas_validas);
			}else{
				swal("Ohoo!", "Los pagos en esta carga ya se les gener\u00F3 factura o recibo.  No hay pagos pendientes de generar recibo...", "info");
			}
		}else{
			swal("Ohoo!", "No hay filas de registros para ser cargados", "info");
		}
	}else{
		if(suc.value ===""){
			suc.className = "form-danger";
		}else{
			suc.className = "form-control";
		}
		if(pv.value ===""){
			pv.className = "form-danger";
		}else{
			pv.className = "form-control";
		}
		if(serie.value ===""){
			serie.className = "form-danger";
		}else{
			serie.className = "form-control";
		}
		if(numero.value ===""){
			numero.className = "form-danger";
		}else{
			numero.className = "form-control";
		}
		if(mon.value ===""){
			mon.className = "form-danger";
		}else{
			mon.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}


function GrabarRecibo(){
	abrir();
	codpago = document.getElementById("codpago");
	suc = document.getElementById("suc");
	pv = document.getElementById("pv");
	serie = document.getElementById("serie");
	numero = document.getElementById("numero");
	desc = document.getElementById("desc");
	mon = document.getElementById("mon");
	var montext = mon.options[mon.selectedIndex].text;
	//-- extrae el simbolo de la moneda y tipo de cambio
	monchunk = montext.split("/");
	//var Vmond = monchunk[0]; // Simbolo de Moneda
	//var Vmons = monchunk[1]; // Simbolo de Moneda
	var tcambio = monchunk[2]; // Tipo de Cambio
		tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
		tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1 
	//--
	alumno = document.getElementById("cui");
	boleta = document.getElementById("boleta");
	fecha = document.getElementById("fecha");
	cli = document.getElementById("cli");
	nit = document.getElementById("nit");
	monto = document.getElementById("monto");
	if(suc.value !=="" && pv.value !=="" && serie.value !=="" && numero.value !=="" && desc.value !=="" && mon.value !=="" && alumno.value !=="" && boleta.value !=="" && fecha.value !=="" && monto.value !==""){
		xajax_Grabar_Recibo_Individual(numero.value,serie.value,suc.value,pv.value,alumno.value,nit.value,codpago.value,boleta.value,desc.value,monto.value,mon.value,tcambio,fecha.value);
	}else{
		if(suc.value ===""){
			suc.className = "form-danger";
		}else{
			suc.className = "form-control";
		}
		if(pv.value ===""){
			pv.className = "form-danger";
		}else{
			pv.className = "form-control";
		}
		if(serie.value ===""){
			serie.className = "form-danger";
		}else{
			serie.className = "form-control";
		}
		if(numero.value ===""){
			numero.className = "form-danger";
		}else{
			numero.className = "form-control";
		}
		if(desc.value ===""){
			desc.className = "form-danger";
		}else{
			desc.className = "form-control";
		}
		if(mon.value ===""){
			mon.className = "form-danger";
		}else{
			mon.className = "form-control";
		}
		if(alumno.value ===""){
			alumno.className = "form-danger";
		}else{
			alumno.className = "form-control";
		}
		if(boleta.value ===""){
			boleta.className = "form-danger";
		}else{
			boleta.className = "form-control";
		}
		if(fecha.value ===""){
			fecha.className = "form-danger";
		}else{
			fecha.className = "form-control";
		}
		if(monto.value ===""){
			monto.className = "form-danger";
		}else{
			monto.className = "form-control";
		}
		if(nit.value ===""){
			nit.className = "form-danger";
		}else{
			nit.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}


function ModificarRecibo(){  
	abrir();
	codpago = document.getElementById("codpago");
	suc = document.getElementById("suc");
	pv = document.getElementById("pv");
	serie = document.getElementById("serie");
	numero = document.getElementById("numero");
	desc = document.getElementById("desc");
	mon = document.getElementById("mon");
	var montext = mon.options[mon.selectedIndex].text;
	//-- extrae el simbolo de la moneda y tipo de cambio
	monchunk = montext.split("/");
	//var Vmond = monchunk[0]; // Simbolo de Moneda
	//var Vmons = monchunk[1]; // Simbolo de Moneda
	var tcambio = monchunk[2]; // Tipo de Cambio
		tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
		tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1 
	//--
	alumno = document.getElementById("cui");
	boleta = document.getElementById("boleta");
	fecha = document.getElementById("fecha");
	cli = document.getElementById("cli");
	nit = document.getElementById("nit");
	monto = document.getElementById("monto");
	if(suc.value !=="" && pv.value !=="" && serie.value !=="" && numero.value !=="" && desc.value !=="" && mon.value !=="" && alumno.value !=="" && boleta.value !=="" && fecha.value !=="" && monto.value !==""){
		xajax_Modificar_Recibo_Individual(numero.value,serie.value,suc.value,pv.value,alumno.value,cli.value,codpago.value,boleta.value,desc.value,monto.value,mon.value,tcambio,fecha.value);
	}else{
		if(suc.value ===""){
			suc.className = "form-danger";
		}else{
			suc.className = "form-control";
		}
		if(pv.value ===""){
			pv.className = "form-danger";
		}else{
			pv.className = "form-control";
		}
		if(serie.value ===""){
			serie.className = "form-danger";
		}else{
			serie.className = "form-control";
		}
		if(numero.value ===""){
			numero.className = "form-danger";
		}else{
			numero.className = "form-control";
		}
		if(desc.value ===""){
			desc.className = "form-danger";
		}else{
			desc.className = "form-control";
		}
		if(mon.value ===""){
			mon.className = "form-danger";
		}else{
			mon.className = "form-control";
		}
		if(alumno.value ===""){
			alumno.className = "form-danger";
		}else{
			alumno.className = "form-control";
		}
		if(boleta.value ===""){
			boleta.className = "form-danger";
		}else{
			boleta.className = "form-control";
		}
		if(fecha.value ===""){
			fecha.className = "form-danger";
		}else{
			fecha.className = "form-control";
		}
		if(monto.value ===""){
			monto.className = "form-danger";
		}else{
			monto.className = "form-control";
		}
		if(nit.value ===""){
			nit.className = "form-danger";
		}else{
			nit.className = "form-control";
		}
		swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
	}
}

function ConfirmAnularRecibo(serie,numero,codpago){
	swal({
		title: "\u00BFANULAR?",
		text: "\u00BFEsta seguro de ANULAR este Recibo?",
		icon: "warning",
		buttons: {
			cancel: "Cancelar",
			ok: { text: "Aceptar", value: true,},
		}
	}).then((value) => {
		switch (value) {
			case true:
				xajax_Anular_Recibo(serie,numero,codpago);
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

function SearchCliente(){
  var x = 0;
  document.getElementById('Pcontainer').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>';
  //Realiza una peticion de contenido a la contenido.php
  $.post("../promts/cliente/busca_cliente.php",{variable:x}, function(data){
  // Ponemos la respuesta de nuestro script en el DIV recargado
  $("#Pcontainer").html(data);
  });
  abrirModal();
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


function generarTXT(){
	carga = document.getElementById('carga');
	fecha = document.getElementById('fecha');
	suc = document.getElementById('suc');
	pv = document.getElementById('pv');
	
	if(carga.value !=""){
		if(fecha.value !="" && suc.value !="" && pv.value != ""){
			myform = document.forms.f1;
			myform.method = "get";
			myform.target ="_blank";
			myform.action ="EXEfaceTXT.php";
			myform.submit();
			myform.action ="";
			myform.target ="";
			myform.method = "get";
		}else{
			if(fecha.value ===""){
				fecha.className = "form-danger";
			}else{
				fecha.className = "form-control";
			}
			if(suc.value ===""){
				suc.className = "form-danger";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-danger";
			}else{
				pv.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}else{
		swal("Error", "Error en el traslado de par\u00E1metros al servidor, falta el n\u00FAmero de carga...", "error");
	}
}