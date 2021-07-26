	//funciones javascript y validaciones
	
	function Set_Inicial(empresa,pventa,moneda){
		suc = document.getElementById('suc');
		suc.value = empresa;
		xajax_SucPuntVnt(suc.value,'pv');
		mon = document.getElementById('Tmon');
		mon.value = moneda;
		window.setTimeout ("Set_Punto_Venta("+pventa+")", 1500);
	}
	
	function Set_Punto_Venta(pventa){
		pv = document.getElementById('pv');
		pv.value = pventa;
	}
	
	function Cancelar(){
		texto = "\u00BFDesea Cancelar esta transacci\u00F3n?, perdera los datos escritos...";
		acc = "location.reload();";
		ConfirmacionJs(texto,acc);
	}
	
	function Limpiar(){
		texto = "\u00BFDesea Cancelar esta transacci\u00F3n?, perdera los datos escritos...";
		acc = "location.reload();";
		ConfirmacionJs(texto,acc);
	}
													
	function Submit(tipo){
		myform = document.forms.f1;
		if(tipo === 1){
			myform.action ="REPvale.php";
		}else if(tipo === 2){
			myform.action ="REPvaleexe.php";
		}
		myform.submit();
	}
						
	function pageprint(){
		boton = document.getElementById("print");
		boton.className = "hidden";
		window.print();
		boton.className = "btn btn-default";
	}
	
	function cerrarProgress(){
		document.getElementById('progress').innerHTML = "";
	}
	
	function Empresa_CajaJS(valor){
		xajax_SucPuntVnt(valor,"caja1","scaja1","");
	}
	
	function BuscarVenta(){
		ser = document.getElementById('ser');
		facc = document.getElementById('facc');
		vent = document.getElementById("vent");
		//--
		if(ser.value !=="" || facc.value !=="" || vent.value !== ""){
			abrir();
			xajax_Buscar_Venta(vent.value,ser.value,facc.value);
		}
	}
	
	
	function Factura(x){
		lbf1 = document.getElementById('lbf1');
		lbf2 = document.getElementById('lbf2');
		//---
		ttotal = document.getElementById('ttotal');
		spanttotal = document.getElementById('spanttotal');
		// manejo del texto del combo moneda
			inpmon = document.getElementById('Tmon');
			var montext = inpmon.options[inpmon.selectedIndex].text;
		//-- extrae el simbolo de la moneda y tipo de cambio
			monchunk = montext.split("/");
			var Vmons = monchunk[1]; // Simbolo de Moneda
			var Vmonc = monchunk[2]; // Tipo de Cambio
			Vmonc = Vmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
			Vmonc = Vmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
		//--
		if(x.checked){
			lbf1.style.display = "block";
			lbf2.style.display = "block";
		}else{
			lbf1.style.display = "none";
			lbf2.style.display = "none";
		}
	}
	
				
	function NextFactura(){
		suc = document.getElementById('suc');
		pv = document.getElementById("pv");
		ser = document.getElementById("ser");
		
		if(suc.value !=="" && pv.value !== "" && ser.value !== ""){
			xajax_Next_Factura(suc.value,pv.value,ser.value);
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-info";
			}else{
				ser.className = "form-control";
			}
			ser.value = ""; //resetea el combo de series para poder seleccionarse nuevamente
			swal("Ups!", "Determinar los criterios obligatorios para facturar (Empresa, Punto de Venta y Serie de Fac.)", "info");
		}
	}
	
	
	function NextFacturaAnterior(){
		suc = document.getElementById('suc1');
		pv = document.getElementById("pv1");
		ser = document.getElementById("ser");
		
		if(suc.value !=="" && pv.value !== "" && ser.value !== ""){
			xajax_Next_Factura(suc.value,pv.value,ser.value);
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-info";
			}else{
				ser.className = "form-control";
			}
			ser.value = ""; //resetea el combo de series para poder seleccionarse nuevamente
			swal("Ups!", "Determinar los criterios obligatorios para facturar (Empresa, Punto de Venta y Serie de Fac.)", "info");
		}
	}		
	
	
	///////////////////------------------ Venta --------------//////////////////////////////
	function LimpiarVenta(){
		suc = document.getElementById('suc');
		pv = document.getElementById("pv");
		if(suc.value !=="" && pv.value !== ""){
			texto = "\u00BFDesea limpiar los datos de esta venta?, perdera los datos ingresados en el detalle...";
			acc = "xajax_Limpiar_Fila_Venta("+pv.value+","+suc.value+");";
			ConfirmacionJs(texto,acc);
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			swal("Ups!", "Determinar los criterios obligatorios (Empresa y Punto de Venta)", "info");
		}
	}
	
	function TipoVenta(x){
		row1 = document.getElementById('row1');
		row2 = document.getElementById('row2');
		row3 = document.getElementById('row3');
		if(x === "P"){
			row1.className = 'row';
			row2.className = 'row hidden';
			row3.className = 'row hidden';
			$(".select2").select2();
		}else if(x === "S"){
			row1.className = 'row hidden';
			row2.className = 'row';
			row3.className = 'row hidden';
			$(".select2").select2();
		}else if(x === "O"){
			row1.className = 'row hidden';
			row2.className = 'row hidden';
			row3.className = 'row';
			document.getElementById('mon').removeAttribute("disabled");
		}
	}
	
	function NewFilaVenta(){
		fac = document.getElementById("fac");
		pv = document.getElementById("pv");
		suc = document.getElementById("suc");
		// trae los input de ingreso de datos
		inptipo = document.getElementById("tip");
		inpdesc = document.getElementById("desc");
		inpbarc = document.getElementById("barc");
		inpart = document.getElementById("art");
		inpartn = document.getElementById("artn");
		inpprev = document.getElementById("prev");
		inpmon = document.getElementById("mon");
		inptdsc = document.getElementById("tdsc");
		inpdsc = document.getElementById("dsc");
		inpdsc.value = (inpdsc.value !== "")?inpdsc.value:0;
		inpcant = document.getElementById("cant");
		inpclimit = document.getElementById("cantlimit");
		inpclimit.value = (inpclimit.value !== "")?inpclimit.value:0;
		//--
		var IVA = (fac.checked)?"V":"F";
		//--
		// manejo del texto del combo moneda
			var montext = inpmon.options[inpmon.selectedIndex].text;
		//-- extrae el simbolo de la moneda y tipo de cambio
			monchunk = montext.split("/");
			var tcamb = monchunk[2]; // Tipo de Cambio
			tcamb = tcamb.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
			tcamb = tcamb.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
		//--
		//alert(inptipo.value+","+inpprev.value+","+inpmon.value+","+inpdsc.value+","+inpcant.value);
		if(inptipo.value !== "" && inpprev.value !== "" && inpmon.value !== "" && inpdsc.value !== "" && inpcant.value !== ""){
			if((inptipo.value == "P" && inpart.value !== "" && inpartn.value !== "") || (inptipo.value == "S" && inpart.value !== "" && inpartn.value !== "") || (inptipo.value == "O" && inpdesc.value !== "")){
				if(inptipo.value == "O" || (parseInt(inpclimit.value)  >= parseInt(inpcant.value) && inptipo.value != "O")){
					abrir();
					if(inptipo.value != "O"){ ///////// realiza limpieza de descripci\u00F3n
						var texto = inpartn.value;
						texto = decode_utf8(texto);
						inpdesc.value = texto.toString();
					}
					xajax_Grid_Fila_Venta(pv.value,suc.value,inptipo.value,inpdesc.value,inpart.value,inpcant.value,inpprev.value,inpmon.value,tcamb,inptdsc.value,inpdsc.value);
				}else{
					inpcant.className = "form-warning";
					swal("Ups!", "No hay existencia suficiente de ese lote de articulos. Existencia : "+inpclimit.value+". Usted desea "+inpcant.value+"...", "warning");
				}
			}else{
				if(inpart.value ===""){
					inpart.className = "form-danger";
				}else{
					inpart.className = "form-control";
				}
				if(inpartn.value ===""){
					inpartn.className = "form-danger";
				}else{
					inpartn.className = "form-control";
				}
				if(inpbarc.value ===""){
					inpbarc.className = "form-danger";
				}else{
					inpbarc.className = "form-control";
				}
				if(inpdesc.value ===""){
					inpdesc.className = "form-danger";
				}else{
					inpdesc.className = "form-control";
				}
				swal("Ups!", "No ha ingresado uno o mas datos de la venta...", "warning");
			}
		}else{
			if(inptipo.value ===""){
				inptipo.className = "form-danger";
			}else{
				inptipo.className = "form-control";
			}
			if(inpprev.value ===""){
				inpprev.className = "form-danger";
			}else{
				inpprev.className = "form-control";
			}
			if(inpcant.value ===""){
				inpcant.className = "form-danger";
			}else{
				inpcant.className = "form-control";
			}
			if(inpmon.value ===""){
				inpmon.className = "form-danger";
			}else{
				inpmon.className = "form-control";
			}
			if(inpdsc.value ===""){
				inpdsc.className = "form-danger";
			}else{
				inpdsc.className = "form-control";
			}
			swal("Ups!", "No ha ingresado uno o mas datos de la venta...", "warning");
		}
	}
	
	
	
	function NewFilaPago(){
		nfilas = document.getElementById("PagFilas").value;
		var bandera = false;
		var arrtipo = "|";
		var arrmonto = "|";
		var arrmoneda = "|";
		var arrcambio = "|";
		var arropera = "|";
		var arrdoc = "|";
		var arrobs = "|";
		// trae los input de ingreso de datos
			inptipo = document.getElementById("tpag1");
			inpopera = document.getElementById("opera1");
			inpdoc = document.getElementById("bouch1");
			inpmonto = document.getElementById("montp1");
			inpmon = document.getElementById("monP1");
			inpmonFac = document.getElementById("Tmon");
			inpobs = document.getElementById("obs1");
			spanx = (inptipo.value === 3)?2:inptipo.value; // indica que si el pago es con tarjeta de credito lo agregue a t. debito
			spannum = document.getElementById("spanpago"+spanx); //recibe span de stot en la fila
			//-					
			inpPag = document.getElementById("Pag"+spanx);
		//**********Moneda de facturacion
			// manejo del texto del combo moneda
				var montext = inpmonFac.options[inpmonFac.selectedIndex].text;
			//-- extrae el simbolo de la moneda y tipo de cambio
					monchunk = montext.split("/");
					var Fmons = monchunk[1]; // Simbolo de Moneda
					var Fmonc = monchunk[2]; // Tipo de Cambio
					Fmonc = Fmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
					Fmonc = Fmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
			//--
		//****** Compara si el Monto a pagar no excede a la compra
			// manejo del texto del combo moneda
				var montext = inpmon.options[inpmon.selectedIndex].text;
			//-- extrae el simbolo de la moneda y tipo de cambio
					monchunk = montext.split("/");
					var Vmons = monchunk[1]; // Simbolo de Moneda
					var Vmonc = monchunk[2]; // Tipo de Cambio
					Vmonc = Vmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
					Vmonc = Vmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
			//--
			inpttotal = IFdetalle.detalle.ttotal;
			inppagtotal = document.getElementById("PagTotal");
			Dcambiar = MonedaTipoCambio(Vmonc,Fmonc,inpmonto.value);
			Pagtotal = parseFloat(Dcambiar) + parseFloat(inppagtotal.value); //suma las cantidades;
		//****					
		if(parseFloat(Pagtotal) <= parseFloat(inpttotal.value)){	
			if(inptipo.value !== "" && inpmonto.value !== "" && inpmon.value !== "" && inpmonFac.value !== ""){
				if((inptipo.value == 1) || (inptipo.value == 2 && inpopera.value !== "" && inpdoc.value !== "") || (inptipo.value == 3 && inpopera.value !== "" && inpdoc.value !== "") ||
					(inptipo.value == 4 && inpopera.value !== "" && inpdoc.value !== "" && inpobs.value !== "") || (inptipo.value == 5 && inpopera.value !== "" && inpdoc.value !== "") ||
					(inptipo.value == 6 && inpopera.value !== "" && inpdoc.value !== "")){
					
					var iguales = false; //valida si ya existe ese lote en la lista
					var codigo = spanx;
					//------------
						var total = 0;
						for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
							tipoc = document.getElementById("Ttpag"+i).value;
							//alert(codigo +","+ artc);
							if(codigo === tipoc){ //si ya esta listado el pago
								ntcamb = document.getElementById("Ttipcambio"+i); //recibe input hidden de fila ya listada
								nmonto = document.getElementById("Tmonto"+i); //recibe input hidden de fila ya listada
								Dcambiar = MonedaTipoCambio(ntcamb.value,Vmonc,nmonto.value);
								total += parseFloat(Dcambiar); //suma las cantidades;
								iguales = true;
							}
						}
						if(iguales === false){
							inpPag.value = inpmonto.value;
							spannum.innerHTML = Vmons+" "+inpmonto.value;
						}else{
							total += parseFloat(inpmonto.value);
							total = total * 100;//-- inicia proceso de redondeo
							total = Math.round(total); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
							total = total/100;//-- finaliza proceso de redondeo
							inpPag.value = total;
							spannum.innerHTML = Vmons+" "+total;
						}
					//- Procedimiento para listar los pagos
							for(var i = 1; i <= nfilas; i ++){
								//extrae datos del grid
								tipo = document.getElementById("Ttpag"+i).value;
								opera = document.getElementById("Toperador"+i).value;
								doc = document.getElementById("Tboucher"+i).value;
								monto = document.getElementById("Tmonto"+i).value;
								mon = document.getElementById("Tmoneda"+i).value;
								cambio = document.getElementById("Ttipcambio"+i).value;
								obs = document.getElementById("Tobserva"+i).value;
								//-- crea string a convertir en arrays
								arrtipo+= tipo+"|";
								arrmonto+= monto+"|";
								arrmoneda+= mon+"|";
								arrcambio+= cambio+"|";
								arropera+= opera+"|";
								arrdoc+= doc+"|";
								arrobs+= obs+"|";
							}
							nfilas++;
							//-- llena el array con los datos en el grid
								arrtipo+= inptipo.value;
								arrmonto+= inpmonto.value;
								arrmoneda+= inpmon.value;
								arrcambio+= Vmonc;
								arropera+= inpopera.value;
								arrdoc+= inpdoc.value;
								arrobs+= inpobs.value;
								
							// ejecuta la funcion de ajax para refrescar el grid
							abrirMixPromt();
							xajax_Grid_Fila_Venta_Pago(nfilas,arrtipo,arrmonto,arrmoneda,arrcambio,arropera,arrdoc,arrobs,Fmonc);
							cerrarModal();
							
				}else{
					if(inpopera.value ===""){
						inpopera.className = "form-danger";
					}else{
						inpopera.className = "form-control";
					}
					if(inpdoc.value ===""){
						inpdoc.className = "form-danger";
					}else{
						inpdoc.className = "form-control";
					}
					if(inptipo.value === 4){
						if(inpobs.value ===""){
							inpobs.className = "form-danger";
						}else{
							inpobs.className = "form-control";
						}
					}
					swal("Ups!", "No ha ingresado uno o mas datos del pago...", "warning");
				}
			}else{
				if(inptipo.value ===""){
					inptipo.className = "form-danger";
				}else{
					inptipo.className = "form-control";
				}
				if(inpmonto.value ===""){
					inpmonto.className = "form-danger";
				}else{
					inpmonto.className = "form-control";
				}
				if(inpmon.value ===""){
					inpmon.className = "form-danger";
				}else{
					inpmon.className = "form-control";
				}
				if(inpmonFac.value ===""){
					inpmonFac.className = "form-danger";
				}else{
					inpmonFac.className = "form-control";
				}
				swal("Ohoo!", "No ha ingresado uno o mas datos del pago...", "warning");
			}
		}else{
			swal("Ohoo!", "El monto a pagar excede el monto total de la compra...", "warning");
		}
	}
	
	
	function NewFilaPago2(){
		nfilas = document.getElementById("PagFilas").value;
		var bandera = false;
		var arrtipo = "|";
		var arrmonto = "|";
		var arrmoneda = "|";
		var arrcambio = "|";
		var arropera = "|";
		var arrdoc = "|";
		var arrobs = "|";
		// trae los input de ingreso de datos
			inptipo = document.getElementById("tpag1");
			inpopera = document.getElementById("opera1");
			inpdoc = document.getElementById("bouch1");
			inpmonto = document.getElementById("montp1");
			inpmon = document.getElementById("mon1");
			inpobs = document.getElementById("obs1");
			spanx = (inptipo.value === 3)?2:inptipo.value; // indica que si el pago es con tarjeta de credito lo agregue a t. debito
			spannum = document.getElementById("spanpago"+spanx); //recibe span de stot en la fila
			//-					
			inpPag = document.getElementById("Pag"+spanx);
		//****** Compara si el Monto a pagar no excede a la compra
			// manejo del texto del combo moneda
				var montext = inpmon.options[inpmon.selectedIndex].text;
			//-- extrae el simbolo de la moneda y tipo de cambio
					monchunk = montext.split("/");
					var Vmons = monchunk[1]; // Simbolo de Moneda
					var Vmonc = monchunk[2]; // Tipo de Cambio
					Vmonc = Vmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
					Vmonc = Vmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
			//--
			inpsaldo = document.getElementById("saldo");
			venmoneda = document.getElementById("moneda");
			tcambiodia = document.getElementById("tcambio");
			inppagtotal = document.getElementById("PagTotal");
			Dcambiar = MonedaTipoCambio(Vmonc,tcambiodia.value,inpmonto.value);
			Pagtotal = parseFloat(Dcambiar) + parseFloat(inppagtotal.value); //suma las cantidades;
		//****					
		if(parseFloat(Pagtotal) <= parseFloat(inpsaldo.value)){	
			if(inptipo.value !== "" && inpmonto.value !== "" && inpmon.value !== "" && tcambiodia.value !== ""){
				if((inptipo.value == 1) || (inptipo.value == 2 && inpopera.value !== "" && inpdoc.value !== "") || (inptipo.value == 3 && inpopera.value !== "" && inpdoc.value !== "") ||
					(inptipo.value == 4 && inpopera.value !== "" && inpdoc.value !== "" && inpobs.value !== "") || (inptipo.value == 5 && inpopera.value !== "" && inpdoc.value !== "") ||
					(inptipo.value == 6 && inpopera.value !== "" && inpdoc.value !== "")){
					
					var iguales = false; //valida si ya existe ese lote en la lista
					var codigo = spanx;
					//------------
						var total = 0;
						for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
							tipoc = document.getElementById("Ttpag"+i).value;
							//alert(codigo +","+ artc);
							if(codigo === tipoc){ //si ya esta listado el pago combierte las filas anteriores a la ultima moneda puesta
								ntcamb = document.getElementById("Ttipcambio"+i); //recibe input hidden de fila ya listada
								nmonto = document.getElementById("Tmonto"+i); //recibe input hidden de fila ya listada
								Dcambiar = MonedaTipoCambio(ntcamb.value,Vmonc,nmonto.value);
								total += parseFloat(Dcambiar); //suma las cantidades;
								iguales = true;
							}
						}
						if(iguales === false){
							inpPag.value = inpmonto.value;
							spannum.innerHTML = Vmons+" "+inpmonto.value;
						}else{
							total += parseFloat(inpmonto.value);
							total = total * 100;//-- inicia proceso de redondeo
							total = Math.round(total); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
							total = total/100;//-- finaliza proceso de redondeo
							inpPag.value = total;
							spannum.innerHTML = Vmons+" "+total;
						}
					//- Procedimiento para listar los pagos
							for(var i = 1; i <= nfilas; i ++){
								//extrae datos del grid
								tipo = document.getElementById("Ttpag"+i).value;
								opera = document.getElementById("Toperador"+i).value;
								doc = document.getElementById("Tboucher"+i).value;
								monto = document.getElementById("Tmonto"+i).value;
								mon = document.getElementById("Tmoneda"+i).value;
								cambio = document.getElementById("Ttipcambio"+i).value;
								obs = document.getElementById("Tobserva"+i).value;
								//-- crea string a convertir en arrays
								arrtipo+= tipo+"|";
								arrmonto+= monto+"|";
								arrmoneda+= mon+"|";
								arrcambio+= cambio+"|";
								arropera+= opera+"|";
								arrdoc+= doc+"|";
								arrobs+= obs+"|";
							}
							nfilas++;
							//-- llena el array con los datos en el grid
								arrtipo+= inptipo.value;
								arrmonto+= inpmonto.value;
								arrmoneda+= inpmon.value;
								arrcambio+= Vmonc;
								arropera+= inpopera.value;
								arrdoc+= inpdoc.value;
								arrobs+= inpobs.value;
								
							// ejecuta la funcion de ajax para refrescar el grid
							abrirMixPromt();
							xajax_Grid_Fila_Venta_Pago(nfilas,arrtipo,arrmonto,arrmoneda,arrcambio,arropera,arrdoc,arrobs,tcambiodia.value);
							cerrarModal();
							
				}else{
					if(inpopera.value ===""){
						inpopera.className = "form-danger";
					}else{
						inpopera.className = "form-control";
					}
					if(inpdoc.value ===""){
						inpdoc.className = "form-danger";
					}else{
						inpdoc.className = "form-control";
					}
					if(inptipo.value === 4){
						if(inpobs.value ===""){
							inpobs.className = "form-danger";
						}else{
							inpobs.className = "form-control";
						}
					}
					swal("Ups!", "No ha ingresado uno o mas datos del pago...", "warning");
				}
			}else{
				if(inptipo.value ===""){
					inptipo.className = "form-danger";
				}else{
					inptipo.className = "form-control";
				}
				if(inpmonto.value ===""){
					inpmonto.className = "form-danger";
				}else{
					inpmonto.className = "form-control";
				}
				if(inpmon.value ===""){
					inpmon.className = "form-danger";
				}else{
					inpmon.className = "form-control";
				}
				if(tcambiodia.value ===""){
					tcambiodia.className = "form-danger";
				}else{
					tcambiodia.className = "form-control";
				}
				swal("Ups!", "No ha ingresado uno o mas datos del pago...", "warning");
			}
		}else{
			swal("Ups!", "El monto a pagar excede el monto total de la compra...", "info");
		}
	}
	
	function PromtPagoJS(tipoP){	
		Venta = document.getElementById("ventC").value;
		vtotal = document.getElementById("factotal").value;
		saldo = document.getElementById("saldo").value;
		pagtotal = document.getElementById("PagTotal").value;
		pagmonto = parseFloat(saldo) - parseFloat(pagtotal);
		moneda = document.getElementById("montext").value;
		monid = document.getElementById("moneda").value;
		if(saldo > 0){
			if(pagmonto > 0){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/ventas/pago2.php",{comp:Venta,montext:moneda,monc:monid,total:vtotal,monto:pagmonto,tipo:tipoP}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}else{
				swal("Ups!", "El total del monto a pagar ya esta completo...", "info");
			}
		}else{
			swal("Ya esta!", "Esta Compra ya esta cancelada en su totalidad...", "success");
		}
	}
	
	function ConfirmPagoJS(){	
		nfilas = document.getElementById("PagFilas").value;
		saldo = document.getElementById("saldo").value;
		pagtotal = document.getElementById("PagTotal").value;
		if(nfilas > 0){
			if(parseFloat(saldo) >= parseFloat(pagtotal)){
				swal({
					title: "\u00BFDesea registrar este pago?",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							PagoJS();
							break;
						default:
						  return;
					}
				});
			}else{
				swal("Ups!", "El pago es mayor al saldo del crédito...", "warning");
			}
		}else{
			swal("Ups!", "Faltan los datos del pago...", "warning");
		}
	}
	
	
	function PagoJS(){
		vent = document.getElementById("ventC");
		suc = document.getElementById("suc");
		pv = document.getElementById("pv");
		PagFilas = document.getElementById("PagFilas");
		PagTotal = document.getElementById("PagTotal");
		//--
		if(vent.value !== "" && PagFilas.value > 0 && suc.value !== "" && pv.value !== ""){
			abrir();
			//pago--
			var arrptipo = "|";
			var arrmonto = "|";
			var arrmoneda = "|";
			var arrcambio = "|";
			var arropera = "|";
			var arrdoc = "|";
			var arrobs = "|";
			//arrays de pago
			for(var i = 1; i <= PagFilas.value; i ++){
				//extrae datos del grid
				pagtipo = document.getElementById("Ttpag"+i).value;
				opera = document.getElementById("Toperador"+i).value;
				doc = document.getElementById("Tboucher"+i).value;
				pagmonto = document.getElementById("Tmonto"+i).value;
				pagmoneda = document.getElementById("Tmoneda"+i).value;
				pagtcamb = document.getElementById("Ttipcambio"+i).value;
				obs = document.getElementById("Tobserva"+i).value;
				//-- crea string a convertir en arrays
				arrptipo+= pagtipo+"|";
				arrmonto+= pagmonto+"|";
				arrmoneda+= pagmoneda+"|";
				arrcambio+= pagtcamb+"|";
				arropera+= opera+"|";
				arrdoc+= doc+"|";
				arrobs+= obs+"|";
			}
			xajax_Grabar_Pago(vent.value,suc.value,pv.value,PagFilas.value,arrptipo,arrmonto,arrmoneda,arrcambio,arrdoc,arropera,arrobs);
		}else{
			if(vent.value === ""){
				vent.className = "form-danger";
			}else{
				vent.className = "form-control";
			}
			if(suc.value === ""){
				suc.className = "form-danger";
			}else{
				suc.className = "form-control";
			}
			if(pv.value === ""){
				pv.className = "form-danger";
			}else{
				pv.className = "form-control";
			}
			swal("Ups!", "Faltan algunos datos del pago \u00F3 hay un movimiento fuera de lugar ...", "warning");
		}	
	}	
		
	
	function VentaPagoJS(tipoP){	
		nfilas = IFdetalle.detalle.filas.value;
		if(nfilas > 0){
			Tmon = document.getElementById("Tmon");
			// manejo del texto del combo moneda
				var Vmontext = Tmon.options[Tmon.selectedIndex].text;
			//--
			Vmon = Tmon.value;
			total = IFdetalle.detalle.ttotal.value;
			pagtotal = document.getElementById("PagTotal").value;
			var Saldo =  parseFloat(total) - parseFloat(pagtotal);
			//Realiza una peticion de contenido a la contenido.php
			$.post("../promts/ventas/pago.php",{mon:Vmon,montex:Vmontext,monto:Saldo,tipo:tipoP}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
		}else{
			swal("Ups!", "No hay articulos para venta...", "info");
		}
	}
				
	function ConfirmVentaJS(){
		nfilas = document.getElementById("PagFilas").value;
		ttotal = parseFloat(IFdetalle.detalle.ttotal.value);
		pagtotal = parseFloat(document.getElementById("PagTotal").value);
		if(nfilas > 0){
			if(ttotal === pagtotal){
				swal({
					text: "\u00BFDesea realizar esta venta?",
					icon: "info",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							VentaJS();
							break;
						default:
						  return;
					}
				});
			}else{
				if(ttotal > pagtotal){
					swal("Ups!", "No ha completado el monto total de pago...", "warning");
				}else{
					swal("Ups!", "El pago es mayor al total de la compra...", "warning");
				}
			}
		}else{
			swal("Ups!", "Faltan los datos del pago...", "warning");
		}
	}
	
	
	function VentaJS(){
		nfilas = IFdetalle.detalle.filas.value;
		pfilas = document.getElementById("PagFilas").value;
		Tmon = document.getElementById("Tmon");
		var moneda = Tmon.options[Tmon.selectedIndex].text;
		fec = document.getElementById("fec");
		cli = document.getElementById("cli");
		nit = document.getElementById("nit");
		nom = document.getElementById("nom");
		vnom = document.getElementById("vnom");
		vcod = document.getElementById("vcod");
		suc = document.getElementById("suc");
		pv = document.getElementById("pv");
		chkfac = document.getElementById("fac");
		fac = (chkfac.checked)?1:0;
		ser = document.getElementById("ser");
		facc = document.getElementById("facc");
		total = IFdetalle.detalle.ttotal;
		stotal = IFdetalle.detalle.stotal;
		tdescuento = IFdetalle.detalle.tdescuento;
		//pago--
		pagtotal = document.getElementById("PagTotal");
		//--
		if(nfilas > 0 && pfilas > 0){
			if(cli.value !== "" && fec.value !== "" && suc.value !== "" && pv.value !== "" && Tmon.value !== ""){
				if((fac == 1 && ser.value !== "" && facc.value !== "" ) || (fac == 0)){
					abrir();
					var bandera = false;
					//pago--
					var arrptipo = "|";
					var arrmonto = "|";
					var arrmoneda = "|";
					var arrcambio = "|";
					var arropera = "|";
					var arrdoc = "|";
					var arrobs = "|";
					//arrays de venta
					var C = 1;
					//arrays de pago
					for(var i = 1; i <= pfilas; i ++){
						//extrae datos del grid
						pagtipo = document.getElementById("Ttpag"+i).value;
						opera = document.getElementById("Toperador"+i).value;
						doc = document.getElementById("Tboucher"+i).value;
						pagmonto = document.getElementById("Tmonto"+i).value;
						obs = document.getElementById("Tobserva"+i).value;
						//-- crea string a convertir en arrays
						arrptipo+= pagtipo+"|";
						arrmonto+= pagmonto+"|";
						arropera+= opera+"|";
						arrdoc+= doc+"|";
						arrobs+= obs+"|";
					}
					//alert(nfilas+","+fac+","+ser.value+","+facc.value+","+cli.value+","+pv.value+","+suc.value+","+fec.value+","+vcod.value+","+stotal.value+","+tdescuento.value+","+total.value);
					xajax_Grabar_Venta(nfilas,fac,ser.value,facc.value,cli.value,pv.value,suc.value,fec.value,vcod.value,stotal.value,tdescuento.value,total.value,Tmon.value,moneda,pfilas,arrptipo,arrmonto,arrdoc,arropera,arrobs,pagtotal.value);
					//alert("paso");
				}else{
					if(ser.value === ""){
						ser.className = "form-danger";
					}else{
						ser.className = "form-control";
					}
					if(facc.value === ""){
						facc.className = "form-danger";
					}else{
						facc.className = "form-control";
					}
					cerrar();
					swal("Ups!", "Debe llenar los datos obligatorios...", "warning");
				}
			}else{
				if(fec.value === ""){
					fec.className = "form-danger";
				}else{
					fec.className = "form-control";
				}
				if(cli.value === ""){
					cli.className = "form-danger";
				}else{
					cli.className = "form-control";
				}
				if(nit.value === ""){
					nit.className = "form-danger";
				}else{
					nit.className = "form-control";
				}
				if(nom.value === ""){
					nom.className = "form-danger";
				}else{
					nom.className = "form-control";
				}
				if(suc.value === ""){
					suc.className = "form-danger";
				}else{
					suc.className = "form-control";
				}
				if(pv.value === ""){
					pv.className = "form-danger";
				}else{
					pv.className = "form-control";
				}
				if(Tmon.value === ""){
					Tmon.className = "form-danger";
				}else{
					Tmon.className = "form-control";
				}
				cerrar();
				swal("Ups!", "Debe llenar los datos obligatorios...", "warning");
			}
		}else{
			cerrar();
			swal("Ups!", "No hay art&iacute;culos o Servicios listados para Venta...", "warning");
		}	
	}
	
	function ConfirmDescargaJS(){
		swal({
			title: "Venta Registrada!",
			text: "\u00BFDesea Descargar Automaticamente a Inventario est(e)(os) Articulo(s)?...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					DescargaJS();
					break;
				default:
					return;
			}
		});
	}
	
	function Limpiar_Campos_Venta(){
		inpbarc = document.getElementById("barc");
		cantlimit = document.getElementById("cantlimit");
		inpcant = document.getElementById("cant");
		inpdesc = document.getElementById("desc");
		//--
		inpAart = document.getElementById("Aart");
		inpSart = document.getElementById("Sart");
		inpart = document.getElementById("art");
		inpartn = document.getElementById("artn");
		inpdesc = document.getElementById("desc");
		inpdsc = document.getElementById("dsc");
		inpprem = document.getElementById("prem");
		inpprec = document.getElementById("prec");
		inpprev = document.getElementById("prev");
		// Despinta campos
		inpcant.className = "form-control";
		inpdesc.className = "form-control";
		inpdsc.className = "form-control";
		inpprem.className = "form-control";
		inpprec.className = "form-control";
		inpprev.className = "form-control";
		// Limpia los campos para un nuevo articulo
		cantlimit.value = "";
		inpAart.value = "";
		inpSart.value = "";
		inpbarc.value = "";
		inpart.value = "";
		inpartn.value = "";
		inpcant.value = "";
		inpdesc.value = "";
		inpdsc.value = "0";
		inpprem.value = "";
		inpprec.value = "";
		inpprev.value = "";
		//-- Select 2 --//
		//document.getElementById("select2-Aart-container").innerHTML = 'Seleccione';
		//document.getElementById("select2-Sart-container").innerHTML = 'Seleccione';
		$(".select2").select2();
		//-- finalizacion
		inpbarc.focus();
	}
	
	function monedaText(){
		var combo = document.getElementById("mon");
		var selected = combo.options[combo.selectedIndex].text;
		//alert(selected);
	}
	
	
	///////////////////------------------ DESCARGA --------------//////////////////////////////							
	function DescargaJS(vent,nfilas){
		suc = document.getElementById("suc");
		clase = "V";
		if(nfilas > 0){
			if(suc.value !== "" && clase !== "" && vent !== ""){
				abrir();
				xajax_Grabar_Descarga(suc.value,clase,vent);
			}else{
				if(suc.value === ""){
					suc.className = "form-danger";
				}else{
					suc.className = "form-control";
				}
				swal("Ups!", "Debe llenar los datos obligatorios...", "warning");
			}
		}else{
			swal("Ups!", "No hay art&iacute;culos para Descargar...", "warning");
		}	
	}
	
	/////////////////------------ CLIENTES  -------------------/////////////
	
	function Cliente(){
		nit = document.getElementById('nit');
		if(nit.value !==""){
			abrir();
			xajax_Show_Cliente(nit.value);
		}
	}
	
	function ResetCli(){
		nom = document.getElementById('nom');
		nit = document.getElementById('nit');
		prov = document.getElementById('cli');
		nom.value = "";
		nit.value = "";
		prov.value = "";
	}
	
	function NewCliente(x){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/new_cliente.php",{nit:x}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function SearchCliente(x){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/busca_cliente.php",{variable:x}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function SearchClienteMascota(x){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/cliente/busca_cliente_mascota.php",{variable:x}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function SeleccionarCliente(fila){
		cod = document.getElementById('Cpcod'+fila);
		nit = document.getElementById('Cpnit'+fila);
		nom = document.getElementById('Cpnom'+fila);
		inpcod = document.getElementById('cli');
		inpnit = document.getElementById('nit');
		inpnom = document.getElementById('nom');
		//---
		inpcod.value = cod.value;
		inpnit.value = nit.value;
		inpnom.value = nom.value;
		cerrar();
		document.getElementById('vcod').focus();
	}
	
	function GrabarCliente(){
		nit = document.getElementById('cnit1');
		nom = document.getElementById('cnom1');
		direc = document.getElementById("cdirec1");
		tel1 = document.getElementById("ctel1");
		tel2 = document.getElementById("ctel2");
		mail = document.getElementById("cmail1");
		
		if(nit.value !=="" && nom.value !=="" && direc.value !== ""){
			abrirMixPromt();
			xajax_Grabar_Cliente(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value);
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
			swal("Ups!", "Debe llenar los Campos Obligatorios...", "warning");
		}
	}
	
	/////////////////------------ BARCODE  -------------------/////////////
	
	function Barcode(){
		barc = document.getElementById('barc').value;
		suc = document.getElementById("suc").value;
		y = (suc !== "")?suc:1;
		
		//alert(barc+","+y);
		if(barc !== ""){
			xajax_Show_Barcode(barc,y);
		}
	}
				
	/////////////////------------ ARTICULO  -------------------/////////////
	
	function Articulo(){
		art = document.getElementById('Aart').value;
		barc = document.getElementById('barc').value;
		suc = document.getElementById("suc").value;
		y = (suc !== "")?suc:1;
		
		//alert(art+","+barc+","+y);
		if(art !=="" || barc !==""){
			xajax_Show_Articulo(art,barc,y);
		}
	}
	
							
	function Ul_Articulo_Carga(n){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/inventario/popart.php",{tipo:n}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#sartlote").html(data);
		});
	}
	
	function ResetArt(){
		art = document.getElementById('art').value = "";
		artn = document.getElementById('artn').value = "";
		barc = document.getElementById('barc').value = "";
		cant = document.getElementById('cant').value = "";
		prev = document.getElementById('prev').value = "";
		exist = document.getElementById('cantlimit').value = "";
		mon = document.getElementById('mon');
		mon.value = "";
		mon.removeAttribute('disabled');
	}
	
	
	
	/////////////////------------ SERVICIO  -------------------/////////////
	
	function Servicio(){
		art = document.getElementById('Sart').value;
		barc = document.getElementById('barc').value;
		
		//alert(art+","+barc);
		if(art !=="" || barc !==""){
			xajax_Show_Servicio(art,barc);
		}
	}
							
	
	function ResetServ(){
		art = document.getElementById('art').value = "";
		artn = document.getElementById('artn').value = "";
		barc = document.getElementById('barc').value = "";
		cant = document.getElementById('cant').value = "";
		prev = document.getElementById('prev').value = "";
		exist = document.getElementById('cantlimit').value = "";
		mon = document.getElementById('mon');
		mon.value = "";
		mon.removeAttribute('disabled');
	}
				
	function SearchServicio(x){
		suc = document.getElementById("suc").value;
		sucX = document.getElementById("sucX").value;
		y = (suc !== "")?suc:sucX;
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/servicio/busca_servicio.php",{formulario:x,empresa:y}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function SeleccionarServicio(fila){
		//-- entregan datos
		art = document.getElementById('Tartn'+fila);
		cod = document.getElementById('Tacod'+fila);
		cant = document.getElementById('Tcant'+fila);
		mon = document.getElementById('Tmon'+fila);
		prev = document.getElementById('Tprev'+fila);
		prev.value = (prev.value === "")?0:prev.value; //valida que no regrese vacio
		prec = document.getElementById('Tprec'+fila);
		prec.value = (prec.value === "")?0:prec.value; //valida que no regrese vacio
		prem = document.getElementById('Tprem'+fila);
		prem.value = (prem.value === "")?0:prem.value; //valida que no regrese vacio
		barc = document.getElementById('Tbarc'+fila);
		//-- reciben datos
		inpart = document.getElementById('artn');
		inpcod = document.getElementById('art');
		inpcant = document.getElementById('cantlimit');
		inpmon = document.getElementById('mon');
		inpprev = document.getElementById('prev');
		inpprec = document.getElementById('prec');
		inpprem = document.getElementById('prem');
		inpbarc = document.getElementById('barc');
		//---
		inpart.value = art.value;
		inpcod.value = cod.value;
		inpcant.value = cant.value;
		inpmon.value = mon.value;
		inpprev.value = prev.value;
		inpprec.value = prec.value;
		inpprem.value = prem.value;
		inpbarc.value = barc.value;
		
		cerrar();
		inpmon.setAttribute('disabled','disabled');
		document.getElementById('cant').focus();
	}
	
	////////------- Historial de Ventas -------/////////////
	
	function Ver_Detalle_Venta(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/ventas/detalle_venta.php",{venta:codigo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function Ver_Detalle_Pagos(codigo){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/ventas/detalle_pagos.php",{venta:codigo}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ReporteHist(){
		suc = document.getElementById('suc');
		pv = document.getElementById('pv');
		tipo = document.getElementById("tip");
		grupo = document.getElementById("gru");
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		sit = document.getElementById("sit");
		cfac = document.getElementById("cfac");
		fac1 = document.getElementById("fac1");
		fac2 = document.getElementById("fac2");
		fac3 = document.getElementById("fac3");
		cfac.value = '';
		if(fac1.checked){
			cfac.value = '';
		}else if(fac2.checked){
			cfac.value = 1;
		}else if(fac3.checked){
			cfac.value = 0;
		}
		
		if(suc.value !=="" || pv.value !=="" || tipo.value !== "" || grupo.value !== "" || fini.value !== "" || ffin.value !== ""){
			myform = document.forms.f1;
			myform.action ="REPhistventa.php";
			myform.submit();
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-info";
			}else{
				tipo.className = "form-control";
			}
			if(grupo.value ===""){
				grupo.className = "form-info";
			}else{
				grupo.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	function ReportePagos(){
		ser = document.getElementById("ser");
		facc = document.getElementById("facc");
		vent = document.getElementById("vent");
		
		if((ser.value !== "" && facc.value !== "") || vent.value !== ""){
			myform = document.forms.f1;
			myform.action ="REPpagos.php";
			myform.submit();
		}else{
			if(vent.value ===""){
				vent.className = "form-info";
			}else{
				vent.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-info";
			}else{
				ser.className = "form-control";
			}
			if(facc.value ===""){
				facc.className = "form-info";
			}else{
				facc.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	function ReporteCredit(){
		suc = document.getElementById('suc');
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(suc.value !=="" || fini.value !== "" || ffin.value !== ""){
			myform = document.forms.f1;
			myform.action ="REPcreditos.php";
			myform.submit();
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	function ReporteBouCheq(){
		suc = document.getElementById('suc');
		tipo = document.getElementById('tipo');
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(suc.value !=="" || tipo.value !=="" || fini.value !== "" || ffin.value !== ""){
			myform = document.forms.f1;
			myform.action ="REPboucheq.php";
			myform.submit();
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-info";
			}else{
				tipo.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	function ReporteAnula(){
		suc = document.getElementById('suc');
		pv = document.getElementById('pv');
		ser = document.getElementById("ser");
		facc = document.getElementById("facc");
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if((ser.value !== "" && facc.value !== "") || suc.value !=="" || pv.value !=="" || fini.value !== "" || ffin.value !== ""){
			myform = document.forms.f1;
			myform.action ="REPanula.php";
			myform.submit();
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-info";
			}else{
				ser.className = "form-control";
			}
			if(facc.value ===""){
				facc.className = "form-info";
			}else{
				facc.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	
	////////------- Cuentas por Cobrar -------/////////////
	
	function BuscarDeuda(){
		suc = document.getElementById('suc');
		tipo = document.getElementById('tipo');
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(suc.value !=="" || tipo.value !=="" || fini.value !== "" || ffin.value !== ""){
			abrir();
			xajax_Buscar_Deudas(suc.value,tipo.value,fini.value,ffin.value);
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-info";
			}else{
				tipo.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	
	function Editar_Credito(cod,vent){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/ventas/editar_credito.php",{codigo:cod,venta:vent}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function ModificarCredito(){
		cod = document.getElementById('codigo');
		autoriza = document.getElementById("autoriza");
		doc = document.getElementById("doc");
		observaciones = document.getElementById("observaciones");
		
		if(cod.value !=="" || autoriza.value !== "" || doc.value !== ""){
			abrirMixPromt();
			xajax_Modificar_Credito(cod.value,autoriza.value,doc.value,observaciones.value);
		}else{
			if(autoriza.value ===""){
				autoriza.className = "form-danger";
			}else{
				autoriza.className = "form-control";
			}
			if(doc.value ===""){
				doc.className = "form-danger";
			}else{
				doc.className = "form-control";
			}
			swal("Ups!", "Debe de llenar los campos obligatorios...", "warning");
		}
	}
	
	
	function Ejecutar_Credito(cod,vent){
		swal({
			title: "\u00BFDesea Ejecutar este Cr\u00E9dito?",
			text: "Se quitara de la lista y se dar\u00E1 por pagado en su totalidad...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					abrir();
					xajax_Ejecutar_Credito(cod,vent);
					break;
				default:
					return;
			}
		});
	}
	
	
	function FacturarAnteriores(){
		filas = parseInt(document.getElementById('chkrows').value);
		var arrvent = "|";
		var arrser = "|";
		var arrnum = "|";
		var arrsubtotal = "|";
		var arrdescuento = "|";
		var arrtotal = "|";
		var arrmoneda = "|";
		var arrtcambio = "|";
		var arrcliente = "|";
		//--
		if(filas > 0){
			///revisa que cliente fue selecciondo primero
			var clibase = 0;
			for (var i = 1; i <= filas; i++){
				chk = document.getElementById('chk'+i);
				if(chk.checked){
					clibase = parseInt(document.getElementById('cli'+i).value); /// establece la base para comparar que todos los codigos de cliente sean iguales
					break;
				}	
			}	
			///// arma las cadenas con codigos
			var cont = 0;
			for (var i = 1; i <= filas; i++){
				chk = document.getElementById('chk'+i);
				if(chk.checked){
					var clicompara = parseInt(document.getElementById('cli'+i).value);/// recibe el codiggo de cliente de cada fila para comparar
						arrvent+= document.getElementById('vent'+i).value+"|";
						arrser+= document.getElementById('ser'+i).value+"|";
						arrnum+= document.getElementById('num'+i).value+"|";
						arrsubtotal+= document.getElementById('subtotal'+i).value+"|";
						arrdescuento+= document.getElementById('descuento'+i).value+"|";
						arrtotal+= document.getElementById('total'+i).value+"|";
						arrmoneda+= document.getElementById('moneda'+i).value+"|";
						arrtcambio+= document.getElementById('tcambio'+i).value+"|";
						arrcliente+= document.getElementById('cli'+i).value+"|";
						cont++;
				}
			}
			if(cont > 0){
				//Realiza una peticion de contenido a la contenido.php
				document.getElementById('filas').value = cont;
				document.getElementById('ventas').value = arrvent;
				document.getElementById('seriesanula').value = arrser;
				document.getElementById('numerosanula').value = arrnum;
				document.getElementById('subtotales').value = arrsubtotal;
				document.getElementById('descuentos').value = arrdescuento;
				document.getElementById('totales').value = arrtotal;
				document.getElementById('monedas').value = arrmoneda;
				document.getElementById('tcambio').value = arrtcambio;
				document.getElementById('clientes').value = arrcliente;
				//--
				myform = document.forms.f2;
				myform.action ="FRMfacturarventas_factura.php";
				myform.submit();
			}else{
				swal("Ups!", "No ha seleccionado ninguna venta...", "info");
			}
		}else{
			swal("Ups!", "No hay ventas listadas para facturar....", "info");
		}
	}
	
	
	function GrabarFacturaAnteriores(){
		filas = document.getElementById("filas").value;
		ventas = document.getElementById("ventas");
		cliente = document.getElementById("cli");
		seriesanula = document.getElementById("seriesanula");
		numerosanula = document.getElementById("numerosanula");
		fecha = document.getElementById("fecha");
		serie = document.getElementById("ser");
		numero = document.getElementById("facc");
		suc = document.getElementById("suc1");
		pv = document.getElementById("pv1");
		
		if(serie.value !== "" && numero.value !== "" && suc.value !== "" && pv.value !== "" && cliente.value !== ""){
			abrir();
			xajax_Grabar_Factura_Anteriores(filas,ventas.value,cliente.value,seriesanula.value,numerosanula.value,fecha.value,serie.value,numero.value,suc.value,pv.value);
		}else{
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
			if(cliente.value ===""){
				document.getElementById("nit").className = "form-danger";
				document.getElementById("nom").className = "form-danger";
			}else{
				document.getElementById("nit").className = "form-control";
				document.getElementById("nom").className = "form-control";
			}
			swal("Ups!", "Debe de llenar los campos obligatorios...", "warning");
		}
	}
	
	
		
	
	function TipoCobro(x){
		row1 = document.getElementById('row1');
		row2 = document.getElementById('row2');
		//--
		if(x === "1"){
			row1.style.display = "block";
			row2.style.display = "none";
		}else if(x === "2"){
			row1.style.display = "none";
			row2.style.display = "block";
		}
	}
	
	function descuento_x_cargos(){
		var total = 0;
		monto = document.getElementById("montp1").value;
		cargo = document.getElementById("cargo1").value;
		tot = document.getElementById("total1");
		cargo = (cargo === "")?0:cargo;
		total = parseFloat(monto)-(parseFloat(monto)*parseFloat(cargo)/100);
		total = total * 100;//-- inicia proceso de redondeo
		total = Math.round(total); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
		total = total/100;//-- finaliza proceso de redondeo
		tot.value = total;
	}
	
	function Confirm_Ejecutar_Cheque_Tarjeta(){	
		filas = document.getElementById("filas").value;
		var total = 0;
		var tipoC = 0;
		var bandera = 0;
		var total;
		var Checks = 0;
		if(filas > 0){
			for(var i = 1; i <= filas; i ++){
				chk = (document.getElementById("chk"+i).checked)?1:0;
				if (chk === 1) {
					//alert(tipoC+","+i);
					tipo = document.getElementById("tipo"+i).value;
					monto = document.getElementById("monto"+i).value;
					total = parseFloat(total) + parseFloat(monto);
					if (Checks === 0) {
						bandera++;
					}else if (tipo === tipoC) {
						bandera++;
					}
					tipoC = tipo;
					Checks++;
				}
			}
			if(Checks > 0){
				//alert(bandera+","+Checks);
				if(bandera === Checks){
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/ventas/ejecutar.php",{Total:total,Tipo:tipoC,Filas:filas}, function(data){
					// Ponemos la respuesta de nuestro script en el DIV recargado
					$("#Pcontainer").html(data);
					});
					abrirModal();
				}else{
					swal("Ups!", "Una o mas cuentas no son del mismo tipo...", "warning");
				}
			}else{
				swal("Ups!", "No ha seleccionado ninguna cuenta...", "info");
			}
		}else{
			swal("Ups!", "No hay cuenta para ejecutar...", "info");
		}
	}
	
	function Ejecutar_Cheque_Tarjeta(){
		nfilas = document.getElementById("tfilas").value;
		cue = document.getElementById("cue1");
		ban = document.getElementById("ban1");
		suc = document.getElementById("suc1");
		caja = document.getElementById("caja1");
		tipo = document.getElementById("tip1");
		monto = document.getElementById("total1");
		doc = document.getElementById("doc1");
		var cont = 1;
		//--
		if(nfilas > 0){
			if((tipo.value == 1 && cue.value !== "" && ban.value !== "") || (tipo.value == 2 && caja.value !== "" && suc.value !== "") && monto.value !== "" && doc.value !== ""){
				abrirMixPromt();
				//Inicializacion de arrays--
				var arrccue = "|";
				var arrven = "|";
				//llenado de arrays
				var C = 1;
				for(var i = 1; i <= nfilas; i ++){
					chk = (document.getElementById("chk"+i).checked)?1:0;
					if (chk === 1) {
						//extrae datos del grid
						ccue = document.getElementById("ccue"+cont).value;
						ven = document.getElementById("ven"+cont).value;
						//-- llena arrays
						arrccue+= ccue+"|";
						arrven+= ven+"|";
						cont++;
					}
				}
				cont--;
				xajax_Ejecutar_Cheque_Tarjeta(cue.value,ban.value,suc.value,caja.value,tipo.value,monto.value,doc.value,cont,arrccue,arrven);
				//alert("paso");
			}else{
				if(cue.value === ""){
					cue.className = "form-danger";
				}else{
					cue.className = "form-control";
				}
				if(ban.value === ""){
					ban.className = "form-danger";
				}else{
					ban.className = "form-control";
				}
				if(suc.value === ""){
					suc.className = "form-danger";
				}else{
					suc.className = "form-control";
				}
				if(caja.value === ""){
					caja.className = "form-danger";
				}else{
					caja.className = "form-control";
				}
				if(doc.value === ""){
					doc.className = "form-danger";
				}else{
					doc.className = "form-control";
				}
				if(monto.value === ""){
					monto.className = "form-danger";
				}else{
					monto.className = "form-control";
				}
				swal("Ups!", "Debe llenar los datos obligatorios...", "warning");
			}
		}else{
			swal("Ups!", "No hay Cuentas por Ejecutar Seleccionadas...", "warning");
		}	
	}
	
	////////------- Anulacion de Ventas -------/////////////
	
	function BuscarAnula(){
		suc = document.getElementById('suc');
		pv = document.getElementById('pv');
		ser = document.getElementById("ser");
		facc = document.getElementById("facc");
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(suc.value !=="" || pv.value !=="" || ser.value !== "" || facc.value !== "" || fini.value !== "" || ffin.value !== ""){
			abrir();
			xajax_Buscar_Anulacion(suc.value,pv.value,ser.value,facc.value,fini.value,ffin.value);
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-info";
			}else{
				ser.className = "form-control";
			}
			if(facc.value ===""){
				facc.className = "form-info";
			}else{
				facc.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	function ConfirmAnular(vent,ini,fin){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/ventas/cambia_sit.php",{cod:vent,fini:ini,ffin:fin}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function CambiarSituacion(){
		just = document.getElementById('just1');
		vent = document.getElementById('vent1').value;
		fini = document.getElementById('fini1').value;
		ffin = document.getElementById("ffin1").value;
		if(just.value !== ""){
			abrirMixPromt();
			xajax_Cambiar_Situacion(vent,fini,ffin);
		}else{
			just.className = "form-danger";
			swal("Ups!", "Debe llenar los Campos Obligatorios...", "warning");
		}
	}				
	
	//funcion de Codigo Articulos	
	function Agrega_Ceros_JS(dato){
	var len = dato.length;
	switch(len){
	case 1: dato = "000"+dato; break;
	case 2: dato = "00"+dato; break;
	case 3: dato = "0"+dato; break;
	}
	return dato;
	}
	
	function Codigo_Art_JS(codigo){
	chunk = codigo.split("A");
	var art = chunk[0]; // articulo
	var gru = chunk[1]; // grupo
	//agrega ceros
	art = Agrega_Ceros_JS(art);
	gru = Agrega_Ceros_JS(gru);
	//arma el codigo
	codigo = art+"A"+gru;
	return codigo;
	}
	
	function ExeTipoCambio(combo){
	var nfilas = document.getElementById("filas").value;
	// manejo del texto del combo moneda
	var montext = combo.options[combo.selectedIndex].text;
	//-- extrae el simbolo de la moneda y tipo de cambio
	monchunk = montext.split("/");
	var Vmond = monchunk[0]; // Simbolo de Moneda
	var Vmons = monchunk[1]; // Simbolo de Moneda
	var Vmonc = monchunk[2]; // Tipo de Cambio
		Vmonc = Vmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
		Vmonc = Vmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
	//--
	mon = document.getElementById("mon").value = combo.value; //-- Selecciona el combo de moneda een la seccion inferior de la venta
	promdesc = document.getElementById("promdesc"); //--
	tfdsc = document.getElementById("tfdsc"); //--
	fdsc = document.getElementById("fdsc"); //--
	
	stotal = document.getElementById("stotal"); //--
	rtotal = document.getElementById("Rtotal"); //-- TOTAL REAL SIN DESCUENTOS
	ttotal = document.getElementById("ttotal"); //-- TOTAL FINAL A FACUTRAR
	spanpromdesc = document.getElementById("spanpromdesc"); //recibe span de promedio de toda la venta 
	spannota = document.getElementById("spannota"); //recibe span de nota
	
	spandscgeneral = document.getElementById("spandscgeneral"); //recibe span de iva de toda la venta 
	spanstotal = document.getElementById("spanstotal"); //recibe span de total + iva de toda la venta 
	spanttotal = document.getElementById("spanttotal"); //recibe span de total + iva de toda la venta 
	//--
	var DescU = 0;
	var STotal = 0;
	var sumTotal = 0;
	var Rtotal = 0;
	for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
	var Dcambiar = 0;
	var Rcambiar = 0;
	spanstot = document.getElementById("spanstot"+i); //recibe span de stot en la fila 
	monc = document.getElementById("monc"+i); //--
	stot = document.getElementById("stot"+i); //--
	rtot = document.getElementById("rtot"+i); //--
	total = document.getElementById("total"); //--
	tdsc = document.getElementById("tdsc"+i); //--
	dsc = document.getElementById("dsc"+i); //--
	///---- descuentos----///
	var descuento = 0;
	if(tdsc.value === "P"){
		descuento = (parseFloat(rtot.value) * (parseFloat(dsc.value)/100));
	}else if(tdsc.value === "M"){
		 descuento = parseFloat(dsc.value);
	}
	//---
	Dcambiar = MonedaTipoCambio(monc.value,Vmonc,descuento);
	DescU += parseFloat(Dcambiar);
	Dcambiar = MonedaTipoCambio(monc.value,Vmonc,stot.value);
	sumTotal += parseFloat(Dcambiar);
	Rcambiar = MonedaTipoCambio(monc.value,Vmonc,rtot.value);
	Rtotal += parseFloat(Rcambiar);
	}
	////// PROCESOS DE REDONDEO ////////
	//-----
	sumTotal = sumTotal * 100;//-- inicia proceso de redondeo
	sumTotal = Math.round(sumTotal); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
	sumTotal = sumTotal/100;//-- finaliza proceso de redondeo
	//--
	Rtotal = Rtotal * 100;//-- inicia proceso de redondeo
	Rtotal = Math.round(Rtotal); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
	Rtotal = Rtotal/100;//-- finaliza proceso de redondeo
	//////////-----------
	//--SUBTOTAL REAL
	var RTOTAL = parseFloat(Rtotal);
	RTOTAL = RTOTAL * 100;//-- inicia proceso de redondeo
	RTOTAL = Math.round(RTOTAL); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
	RTOTAL = RTOTAL/100;//-- finaliza proceso de redondeo
	rtotal.value = RTOTAL;
	//--SUBTOTAL
	spanstotal.innerHTML = Vmons+" "+RTOTAL;
	stotal.value = RTOTAL;
	//-- DESCUENTO GENERAL
	var descuento = 0;
	if(tfdsc.value === "P"){
		descuento = (parseFloat(RTOTAL) * (parseFloat(fdsc.value)/100));
	}else if(tfdsc.value === "M"){
		 descuento = parseFloat(fdsc.value);
	}
	descuento = descuento * 100;//-- inicia proceso de redondeo
	descuento = Math.round(descuento); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
	descuento = descuento/100;//-- finaliza proceso de redondeo
	spandscgeneral.innerHTML = Vmons+" "+descuento;
	//--TOTAL
	var TTOTAL = (parseFloat(Rtotal) - parseFloat(descuento));
	TTOTAL = TTOTAL * 100;//-- inicia proceso de redondeo
	TTOTAL = Math.round(TTOTAL); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
	TTOTAL = TTOTAL/100;//-- finaliza proceso de redondeo
	//alert(TTOTAL);
	spanttotal.innerHTML = Vmons+" "+TTOTAL;
	rtotal.value = RTOTAL;
	ttotal.value = TTOTAL;
	//--
	DescU = DescU * 100;//-- inicia proceso de redondeo
	DescU = Math.round(DescU); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
	DescU = DescU/100;//-- finaliza proceso de redondeo
	promdesc.value = DescU;
	spanpromdesc.innerHTML = DescU+" %";
	//--
	spannota.innerHTML = "<b>NOTA:</b> MONEDA PARA FACTURACI&Oacute;N: <b>"+Vmond+"</b>. TIPO DE CAMBIO "+Vmonc+" x 1";
	}
	
	/////////////////////////////// RE- Impresiones de Facturas /////////////////////////////////////////
	
	
	function BuscarFactura(tipo){
		suc = document.getElementById('suc');
		pv = document.getElementById('pv');
		ser = document.getElementById("ser2");
		facc = document.getElementById("facc2");
		fini = document.getElementById("fini");
		ffin = document.getElementById("ffin");
		
		if(suc.value !=="" || pv.value !=="" || ser.value !== "" || facc.value !== "" || fini.value !== "" || ffin.value !== ""){
			abrir();
			xajax_Buscar_Factura(suc.value,pv.value,ser.value,facc.value,fini.value,ffin.value,tipo);
		}else{
			if(suc.value ===""){
				suc.className = "form-info";
			}else{
				suc.className = "form-control";
			}
			if(pv.value ===""){
				pv.className = "form-info";
			}else{
				pv.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-info";
			}else{
				ser.className = "form-control";
			}
			if(facc.value ===""){
				facc.className = "form-info";
			}else{
				facc.className = "form-control";
			}
			if(fini.value ===""){
				fini.className = "form-info";
			}else{
				fini.className = "form-control";
			}
			if(ffin.value ===""){
				ffin.className = "form-info";
			}else{
				ffin.className = "form-control";
			}
			swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
		}
	}
	
	
	function ReprintCopy(venta){
		myinp = document.getElementById("vent");
		myinp.value = venta;
		myform = document.forms.f1;
		myform.target ="_blank";
		myform.action ="CPREPORTES/REPfactura_copia.php";
		myform.submit();
	}
	
	
	function ReprintOriginal(venta){
		myinp = document.getElementById("vent");
		myinp.value = venta;
		myform = document.forms.f1;
		myform.target ="_blank";
		myform.action ="CPREPORTES/REPfactura_original.php";
		myform.submit();
	}
	
	function GrabarNuevaFactura(){
		vent = document.getElementById('vent');
		suc = document.getElementById('suc');
		pv = document.getElementById('pv');
		facc = document.getElementById('facc');
		ser = document.getElementById("ser");
		abrir();
		if(suc.value !== "" && pv.value !== "" && ser.value !== "" && facc.value !== ""){
			abrir();
			xajax_Grabar_Nueva_Factura(vent.value,ser.value,facc.value,suc.value,pv.value);
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
			if(facc.value ===""){
				facc.className = "form-danger";
			}else{
				facc.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-danger";
			}else{
				ser.className = "form-control";
			}
			swal("Ups!", "Debe llenar los Campos Obligatorios...", "warning");
		}
	}
	
	function ModificarFactura(){
		vent = document.getElementById('vent');
		suc = document.getElementById('suc');
		pv = document.getElementById('pv');
		facc = document.getElementById('facc');
		ser = document.getElementById("ser");
		facante = document.getElementById('facc3');
		serante = document.getElementById("ser3");
		abrir();
		if(suc.value !== "" && pv.value !== "" && ser.value !== "" && facc.value !== ""){
			abrir();
			xajax_Modificar_Factura(vent.value,ser.value,facc.value,serante.value,facante.value,suc.value,pv.value);
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
			if(facc.value ===""){
				facc.className = "form-danger";
			}else{
				facc.className = "form-control";
			}
			if(ser.value ===""){
				ser.className = "form-danger";
			}else{
				ser.className = "form-control";
			}
			swal("Ups!", "Debe llenar los Campos Obligatorios...", "warning");
		}
	}
