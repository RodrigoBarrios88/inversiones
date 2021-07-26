//funciones javascript y validaciones
						
			function Set_Inicial(empresa,moneda){
				suc = document.getElementById('suc');
				suc.value = empresa;
				mon = document.getElementById('Tmon');
				mon.value = moneda;
			}
						
			function Cancelar(){
				texto = "Desea Cancelar esta transacci&oacute;n?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar(){
				texto = "Desea Cancelar esta transacci&oacute;n?, perdera los datos escritos...";
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
			
			function cerrarProgress(){
				document.getElementById('progress').innerHTML = "";
			}
			
			function BuscarCompra(){
				cod = document.getElementById('cod');
				ref = document.getElementById('ref');
				//--
				if(cod.value !=="" || ref.value !==""){
					abrir();
					xajax_Buscar_Compra(cod.value,ref.value);
				}
			}
								
			function Empresa_CajaJS(valor){
				xajax_Combo_Caja_Empresa(valor,"caja1","scaja1","");
			}
			
			function Num_Cheque(){
				ban = document.getElementById("ban1");
				cue = document.getElementById("cue1");
				
				if(ban.value !=="" && cue.value !==""){
					xajax_Last_Cheque(cue.value,ban.value);
				}
			}
			
			function Valida_Cheque(){
				ban = document.getElementById("ban1");
				cue = document.getElementById("cue1");
				cheque = document.getElementById("obs1");
				
				if(ban.value !=="" && cue.value !==""){
					xajax_Valida_Cheque_Pagado(cue.value,ban.value,cheque.value);
				}else{
					if(suc.value ===""){
						cue.className = "form-warning";
					}else{
						cue.className = "form-control";
					}
					swal("Ups!", "seleccione el numero de cuenta...", "warning");
				}
			}
			
	///////////////////------------------ Venta --------------//////////////////////////////
			function LimpiarCompra(){
				suc = document.getElementById('suc');
				clase = document.getElementById("tipoCompra");
				if(suc.value !=="" && clase.value !== ""){
					texto = "\u00BFDesea limpiar los datos de esta compra?, perdera los datos ingresados en el detalle...";
					acc = "xajax_Limpiar_Fila_Compra('"+clase.value+"',"+suc.value+");";
					ConfirmacionJs(texto,acc);
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					swal("Ups!", "Determinar la empresa a trabajar", "info");
				}
			}
			
								
	///////////////////------------------ Compra --------------//////////////////////////////
	
			function Calcula_Precios(porcent){
				prev = document.getElementById('prev');
				prec = document.getElementById('prec');
				prem = document.getElementById('prem');
				porcent = (porcent === undefined)?0:porcent;
				if(prec.value !==""){
					var sugiere = (parseFloat(porcent) * parseFloat(prec.value)/100) + parseFloat(prec.value);
					sugiere = sugiere * 100;//-- inicia proceso de redondeo
					sugiere = Math.round(sugiere); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
					sugiere = sugiere/100;//-- finaliza proceso de redondeo
					prem.value = sugiere;
					//prev.value = sugiere;
				}
			}
			
			function TipoCompra2(x){
				if(x !== ""){
					xajax_Contenido_Detalle_Compra(x);
				}
			}
			
			function TipoCompra(x){
				row1 = document.getElementById('row1');
				row2 = document.getElementById('row2');
				row3 = document.getElementById('row3');
				row4 = document.getElementById('row4');
				row5 = document.getElementById('row5');
				//--
				if(x === "P"){
					row1.className = 'row';
					row2.className = 'row';
					row3.className = 'row hidden';
					row4.className = 'row hidden';
					row5.className = 'row hidden';
					$(".select2").select2();
				}else if(x === "S"){
					row1.className = 'row hidden';
					row2.className = 'row hidden';
					row3.className = 'row hidden';
					row4.className = 'row';
					row5.className = 'row';
				}else if(x === "U"){
					row1.className = 'row';
					row2.className = 'row hidden';
					row3.className = 'row';
					row4.className = 'row hidden';
					row5.className = 'row hidden';
					$(".select2").select2();
				}else if(x === "E"){
					row1.className = 'row hidden';
					row2.className = 'row hidden';
					row3.className = 'row hidden';
					row4.className = 'row';
					row5.className = 'row';
				}
			}
			
			
			function ImportarProductosProveedor(tipo){
				
				inpprov = document.getElementById("prov");
				inpsuc = document.getElementById("suc");
				if(inpprov.value !== "" && inpsuc.value !== ""){
					abrir();
					xajax_Importar_Productos_Proveedor(inpprov.value,inpsuc.value,tipo);					
				}else{
					if(inpprov.value === ""){
						document.getElementById("nit").className = "form-warning";
						document.getElementById("nom").className = "form-warning";
					}else{
						document.getElementById("nit").className = "form-control";
						document.getElementById("nom").className = "form-control";
					}
					if(inpsuc.value === ""){
						inpsuc.className = "form-warning";
					}else{
						inpsuc.className = "form-control";
					}
					swal("Ups!", "El Proveedor y la Empresa a Facturar deben de estar seleccionadas. Revise los campos obligatorios e intente de nuevo....", "warning");
				}
			}
			
			
			
			function ImportarCompra(){
				codigo = document.getElementById("importar").value;
				tipoCompra = document.getElementById("tipoCompra").value;
				inpsuc = document.getElementById("suc");
				if(codigo !== ""){
					if(inpsuc.value !== ""){
						abrir();
						xajax_Importar_Compra(codigo,tipoCompra,inpsuc.value);
					}else{
						if(inpsuc.value === ""){
							inpsuc.className = "form-danger";
						}else{
							inpsuc.className = "form-control";
						}
						swal("Ups!", "Determinar la empresa a trabajar", "warning");
					}
				}
			}
			
			
			function EditarFilaImportada(codigo,clase,suc){
				//extrae datos del grid
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/compras/editar_importacion.php",{codigo:codigo,clase:clase,suc:suc}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			
			function EditarDetalleTemporal(){
				codigo = document.getElementById("codigoEdit").value;
				clase = document.getElementById("claseEdit").value;
				suc = document.getElementById("sucEdit").value;
				//extrae del prompt
				cant = document.getElementById("cantEdit");
				prec = document.getElementById("precEdit");
				mon = document.getElementById("monEdit");
				tdsc = document.getElementById("tdscEdit");
				dsc = document.getElementById("dscEdit");
				// manejo del texto del combo moneda
					var montext = mon.options[mon.selectedIndex].text;
				//-- extrae el simbolo de la moneda y tipo de cambio
					monchunk = montext.split("/");
					var tcamb = monchunk[2]; // Tipo de Cambio
					tcamb = tcamb.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
					tcamb = tcamb.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
				//--
				if(cant.value !== "" && prec.value !== "" && dsc.value !== ""){
					xajax_Editar_Detalle_Temporal(codigo,clase,suc,cant.value,prec.value,mon.value,tcamb,tdsc.value,dsc.value);
				}else{
					if(cant.value ===""){
						cant.className = "form-danger";
					}else{
						cant.className = "form-control";
					}
					if(prec.value ===""){
						prec.className = "form-danger";
					}else{
						prec.className = "form-control";
					}
					if(dsc.value ===""){
						dsc.className = "form-danger";
					}else{
						dsc.className = "form-control";
					}
					swal("Ups!", "No ha ingresado uno o mas datos de la compra...", "warning");
				}
			}
			
			
			function NewFilaCompra(){
				//descuentos
				tipoCompra = document.getElementById("tipoCompra");
				suc = document.getElementById("suc");
				tfdsc = document.getElementById("tfdsc");
				fdsc = document.getElementById("fdsc");
				//--
				Tmon = document.getElementById("Tmon");
				var moneda = Tmon.options[Tmon.selectedIndex].text;
				var bandera = false;
				// trae los input de ingreso de datos
				inptipo = document.getElementById("tip");
				inppar = document.getElementById("par");
				inpreg = document.getElementById("reg");
				inpdesc = document.getElementById("desc");
				inpbarc = document.getElementById("barc");
				inpart = document.getElementById("art");
				inpartn = document.getElementById("artn");
				inpprec = document.getElementById("prec");
				inpprev = document.getElementById("prev");
				inpprem = document.getElementById("prem");
				inpmon = document.getElementById("mon");
				inptdsc = document.getElementById("tdsc");
				inpdsc = document.getElementById("dsc");
				inpdsc.value = (inpdsc.value !== "")?inpdsc.value:0;
				inpcant = document.getElementById("cant");
				// manejo del texto del combo moneda
					var montext = inpmon.options[inpmon.selectedIndex].text;
				//-- extrae el simbolo de la moneda y tipo de cambio
					monchunk = montext.split("/");
					var tcamb = monchunk[2]; // Tipo de Cambio
					tcamb = tcamb.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
					tcamb = tcamb.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
				//--
				if(inptipo.value !== "" && inppar.value !== "" && inpreg.value !== "" && inpprec.value !== "" && inpmon.value !== "" && inpdsc.value !== "" && inpcant.value !== ""){
					if((inptipo.value == "P" && inpart.value !== "") || (inptipo.value == "S" && inpdesc.value !== "") || (inptipo.value == "U" && inpart.value !== "") || (inptipo.value == "E" && inpdesc.value !== "")){
						//--
						abrir();
						if(inptipo.value != "S" && inptipo.value != "E"){ ///////// realiza limpieza de descripci\u00F3n
							var texto = inpartn.value;
							texto = decode_utf8(texto);
							inpdesc.value = texto.toString();
						}
						xajax_Grid_Fila_Compra(tipoCompra.value,suc.value,inptipo.value,inpreg.value,inppar.value,inpdesc.value,inpart.value,inpcant.value,inpprec.value,inpmon.value,tcamb,inptdsc.value,inpdsc.value);
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
						swal("Ups!", "No ha ingresado uno o mas datos de la compra...", "warning");
					}
				}else{
					if(inptipo.value ===""){
						inptipo.className = "form-danger";
					}else{
						inptipo.className = "form-control";
					}
					if(inpreg.value ===""){
						inpreg.className = "form-danger";
					}else{
						inpreg.className = "form-control";
					}
					if(inpprec.value ===""){
						inpprec.className = "form-danger";
					}else{
						inpprec.className = "form-control";
					}
					if(inpcant.value ===""){
						inpcant.className = "form-danger";
					}else{
						inpcant.className = "form-control";
					}
					if(inpdsc.value ===""){
						inpdsc.className = "form-danger";
					}else{
						inpdsc.className = "form-control";
					}
					swal("Ups!", "No ha ingresado uno o mas datos de la compra...", "warning");
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
				var arrsuc = "|";
				var arrcaja = "|";
				var arrban = "|";
				var arrcue = "|";
				// trae los input de ingreso de datos
					inptipo = document.getElementById("tpag1");
					inpopera = document.getElementById("opera1");
					inpdoc = document.getElementById("bouch1");
					inpmonto = document.getElementById("montp1");
					inpmon = document.getElementById("monP1");
					inpmonFac = document.getElementById("Tmon");
					inpcaja = document.getElementById("caja1");
					inpsuc = document.getElementById("suc1");
					inpban = document.getElementById("ban1");
					inpcue = document.getElementById("cue1");
					inpobs = document.getElementById("obs1");
					spannum = document.getElementById("spanpago"+inptipo.value); //recibe span de stot en la fila 
				//-					
					inpPag = document.getElementById("Pag"+inptipo.value);
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
						if((inptipo.value == 1 && inpcaja.value !== "" && inpsuc.value !== "") || (inptipo.value == 2 && inpopera.value !== "" && inpdoc.value !== "" && inpban.value !== "" && inpcue.value !== "") ||
						   (inptipo.value == 3 && inpopera.value !== "" && inpdoc.value !== "") || (inptipo.value == 4 && inpban.value !== "" && inpcue.value !== "" && inpdoc.value !== "" && inpobs.value !== "") ||
						   (inptipo.value == 5 && inpopera.value !== "" && inpdoc.value !== "") || (inptipo.value == 6 && inpban.value !== "" && inpcue.value !== "" && inpdoc.value !== "" && inpobs.value !== "") ||
						   (inptipo.value == 7 && inpban.value !== "" && inpcue.value !== "" && inpdoc.value !== "" && inpobs.value !== "")){
							
							var iguales = false; //valida si ya existe ese lote en la lista
							var codigo = inptipo.value;
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
										suc = document.getElementById("Tsucur"+i).value;
										caj = document.getElementById("Tcaja"+i).value;
										ban = document.getElementById("Tbanco"+i).value;
										cue = document.getElementById("Tcuenta"+i).value;
										//-- crea string a convertir en arrays
										arrtipo+= tipo+"|";
										arrmonto+= monto+"|";
										arrmoneda+= mon+"|";
										arrcambio+= cambio+"|";
										arropera+= opera+"|";
										arrdoc+= doc+"|";
										arrobs+= obs+"|";
										arrsuc+= suc+"|";
										arrcaja+= caj+"|";
										arrban+= ban+"|";
										arrcue+= cue+"|";
									}
									nfilas++;
									if(inptipo.value === 4){
									// manejo del texto del combo banco
										nombanco = inpban.options[inpban.selectedIndex].text;
									}
									//-- llena el array con los datos en el grid
										arrtipo+= inptipo.value;
										arrmonto+= inpmonto.value;
										arrmoneda+= inpmon.value;
										arrcambio+= Vmonc;
										if(inptipo.value === 4){
										arropera+= nombanco;
										}else{
										arropera+= inpopera.value;
										}
										arrdoc+= inpdoc.value;
										arrobs+= inpobs.value;
										arrsuc+= inpsuc.value;
										arrcaja+= inpcaja.value;
										arrban+= inpban.value;
										arrcue+= inpcue.value;
										
									// ejecuta la funcion de ajax para refrescar el grid
									xajax_Grid_Fila_Compra_Pago(nfilas,arrtipo,arrmonto,arrmoneda,arrcambio,arropera,arrdoc,arrobs,arrsuc,arrcaja,arrban,arrcue,Fmonc);
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
							if(inpcaja.value ===""){
								inpcaja.className = "form-danger";
							}else{
								inpcaja.className = "form-control";
							}
							if(inpban.value ===""){
								inpban.className = "form-danger";
							}else{
								inpban.className = "form-control";
							}
							if(inpcue.value ===""){
								inpcue.className = "form-danger";
							}else{
								inpcue.className = "form-control";
							}
							swal("Ups!", "No ha ingresado uno o mas datos del tipo de pago...", "warning");
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
						if(inpmonFac.value ===""){
							inpmonFac.className = "form-danger";
						}else{
							inpmonFac.className = "form-control";
						}
						swal("Ups!", "No ha ingresado uno o mas datos del tipo de pago...", "warning");
					}
				}else{
					swal("Ups!", "El monto a pagar excede el monto total de la compra...", "warning");
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
				var arrsuc = "|";
				var arrcaja = "|";
				var arrban = "|";
				var arrcue = "|";
				// trae los input de ingreso de datos
					inptipo = document.getElementById("tpag1");
					inpopera = document.getElementById("opera1");
					inpdoc = document.getElementById("bouch1");
					inpmonto = document.getElementById("montp1");
					inpmon = document.getElementById("mon1");
					inpcaja = document.getElementById("caja1");
					inpsuc = document.getElementById("suc1");
					inpban = document.getElementById("ban1");
					inpcue = document.getElementById("cue1");
					inpobs = document.getElementById("obs1");
					spannum = document.getElementById("spanpago"+inptipo.value); //recibe span de stot en la fila 
				//-					
					inpPag = document.getElementById("Pag"+inptipo.value);
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
					if(inptipo.value !== "" && inpmonto.value !== "" && inpmon.value !== ""){
						if((inptipo.value == 1 && inpcaja.value !== "" && inpsuc.value !== "") || (inptipo.value == 2 && inpopera.value !== "" && inpdoc.value !== "" && inpban.value !== "" && inpcue.value !== "") ||
						   (inptipo.value == 3 && inpopera.value !== "" && inpdoc.value !== "") || (inptipo.value == 4 && inpban.value !== "" && inpcue.value !== "" && inpdoc.value !== "" && inpobs.value !== "") ||
						   (inptipo.value == 5 || inptipo.value == 6 && inpopera.value !== "" && inpdoc.value !== "")){
							
								//------------
								var iguales = false; //valida si ya existe ese lote en la lista
								var codigo = inptipo.value;
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
										suc = document.getElementById("Tsucur"+i).value;
										caj = document.getElementById("Tcaja"+i).value;
										ban = document.getElementById("Tbanco"+i).value;
										cue = document.getElementById("Tcuenta"+i).value;
										//-- crea string a convertir en arrays
										arrtipo+= tipo+"|";
										arrmonto+= monto+"|";
										arrmoneda+= mon+"|";
										arrcambio+= cambio+"|";
										arropera+= opera+"|";
										arrdoc+= doc+"|";
										arrobs+= obs+"|";
										arrsuc+= suc+"|";
										arrcaja+= caj+"|";
										arrban+= ban+"|";
										arrcue+= cue+"|";
									}
									nfilas++;
									if(inptipo.value === 4){
									// manejo del texto del combo banco
										nombanco = inpban.options[inpban.selectedIndex].text;
									}
									//-- llena el array con los datos en el grid
										arrtipo+= inptipo.value;
										arrmonto+= inpmonto.value;
										arrmoneda+= inpmon.value;
										arrcambio+= Vmonc;
										if(inptipo.value === 4){
										arropera+= nombanco;
										}else{
										arropera+= inpopera.value;
										}
										arrdoc+= inpdoc.value;
										arrobs+= inpobs.value;
										arrsuc+= inpsuc.value;
										arrcaja+= inpcaja.value;
										arrban+= inpban.value;
										arrcue+= inpcue.value;
										
									// ejecuta la funcion de ajax para refrescar el grid
									abrirMixPromt();
									xajax_Grid_Fila_Compra_Pago(nfilas,arrtipo,arrmonto,arrmoneda,arrcambio,arropera,arrdoc,arrobs,arrsuc,arrcaja,arrban,arrcue,tcambiodia.value);
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
							if(inpcaja.value ===""){
								inpcaja.className = "form-danger";
							}else{
								inpcaja.className = "form-control";
							}
							if(inpban.value ===""){
								inpban.className = "form-danger";
							}else{
								inpban.className = "form-control";
							}
							if(inpcue.value ===""){
								inpcue.className = "form-danger";
							}else{
								inpcue.className = "form-control";
							}
							swal("Ups!", "No ha ingresado uno o mas datos del tipo de pago...", "warning");
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
						swal("Ups!", "No ha ingresado uno o mas datos del tipo de pago...", "warning");
					}
				}else{
					swal("Ups!", "No ha ingresado uno o mas datos del tipo de pago...", "warning");
				}
			}
			
			
			function PromtPagoJS(tipoP){
				Compra = document.getElementById("compC").value;
				saldo = document.getElementById("saldo").value;
				pagtotal = document.getElementById("PagTotal").value;
				pagmonto = parseFloat(saldo) - parseFloat(pagtotal);
				monid = document.getElementById("moneda").value;
				moneda = document.getElementById("montext").value;
				if(saldo > 0){
					if(pagmonto > 0){
						//Realiza una peticion de contenido a la contenido.php
						$.post("../promts/compras/pago2.php",{comp:Compra,montext:moneda,monc:monid,total:saldo,monto:pagmonto,tipo:tipoP}, function(data){
						// Ponemos la respuesta de nuestro script en el DIV recargado
						$("#Pcontainer").html(data);
						});
						abrirModal();
					}else{
						swal("Ups!", "El total del monto a pagar ya esta completo...", "info");
					}
				}else{
					swal("Ups!", "Esta Compra ya esta cancelada en su totalidad...", "info");
				}
			}		
			
			function ConfirmPagoJS(){	
				nfilas = document.getElementById("PagFilas").value;
				saldo = document.getElementById("saldo").value;
				pagtotal = document.getElementById("PagTotal").value;
				if(nfilas > 0){
					if(parseFloat(saldo) >= parseFloat(pagtotal)){
						texto = "Desea registrar este pago?";
						acc = "PagoJS()";
						ConfirmacionJs(texto,acc);
					}else{
						swal("Ups!", "El pago es mayor al saldo del cr\u00E9dito...", "info");
					}
				}else{
					swal("Ups!", "Faltan los datos del pago...", "info");
				}
			}
				

			function PagoJS(){
				compC = document.getElementById("compC").value;
				facsaldo = document.getElementById("saldo").value;
				pagtotal = document.getElementById("PagTotal").value;
				pfilas = document.getElementById("PagFilas").value;
				saldoT = parseFloat(facsaldo) - parseFloat(pagtotal);
				//--
				if(pagtotal > 0 && pfilas > 0){
					//pago--
					var arrptipo = "|";
					var arrmonto = "|";
					var arrmoneda = "|";
					var arrcambio = "|";
					var arropera = "|";
					var arrdoc = "|";
					var arrobs = "|";
					var arrsuc = "|";
					var arrcaja = "|";
					var arrban = "|";
					var arrcue = "|";
					//arrays de pago
					for(var i = 1; i <= pfilas; i ++){
						//extrae datos del grid
						pagtipo = document.getElementById("Ttpag"+i).value;
						opera = document.getElementById("Toperador"+i).value;
						doc = document.getElementById("Tboucher"+i).value;
						pagmonto = document.getElementById("Tmonto"+i).value;
						moneda = document.getElementById("Tmoneda"+i).value;
						tcambio = document.getElementById("Ttipcambio"+i).value;
						obs = document.getElementById("Tobserva"+i).value;
						sucur = document.getElementById("Tsucur"+i).value;
						caja = document.getElementById("Tcaja"+i).value;
						banco = document.getElementById("Tbanco"+i).value;
						cuenta = document.getElementById("Tcuenta"+i).value;
						//-- crea string a convertir en arrays
						arrptipo+= pagtipo+"|";
						arrmonto+= pagmonto+"|";
						arrmoneda+= moneda+"|";
						arrcambio+= tcambio+"|";
						arropera+= opera+"|";
						arrdoc+= doc+"|";
						arrobs+= obs+"|";
						arrsuc+= sucur+"|";
						arrcaja+= caja+"|";
						arrban+= banco+"|";
						arrcue+= cuenta+"|";
					}
					if(saldoT >= 0){
						abrir();
						xajax_Grabar_Pago(compC,pfilas,arrptipo,arrmonto,arrmoneda,arrcambio,arrdoc,arropera,arrobs,arrsuc,arrcaja,arrban,arrcue,pagtotal,facsaldo);
					}else{
						swal("Ups!", "El monto a pagar es mayor al saldo de la deuda...", "info");
					}
				}else{
					swal("Ups!", "El monto a pagar debe ser mayor a 0...", "info");
				}	
			}	
			
			function CompraPagoJS(tipoP){
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
					Saldo = Saldo * 100;//-- inicia proceso de redondeo
					Saldo = Math.round(Saldo); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
					Saldo = Saldo/100;//-- finaliza proceso de redondeo
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/compras/pago.php",{mon:Vmon,montex:Vmontext,monto:Saldo,tipo:tipoP}, function(data){
					// Ponemos la respuesta de nuestro script en el DIV recargado
					$("#Pcontainer").html(data);
					});
					abrirModal();
				}else{
					swal("Ups!", "No hay articulos para Compra...", "info");
				}
			}
			
			function SearchChequePagado(){
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
					Saldo = Saldo * 100;//-- inicia proceso de redondeo
					Saldo = Math.round(Saldo); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
					Saldo = Saldo/100;//-- finaliza proceso de redondeo
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/compras/cheque_pagado.php",{mon:Vmon,montex:Vmontext,monto:Saldo}, function(data){
					// Ponemos la respuesta de nuestro script en el DIV recargado
					$("#Pcontainer").html(data);
					});
					abrirModal();
				}else{
					swal("Ups!", "No hay articulos para Compra...", "info");
				}
			}
			
			
			function ChequePagadoPagoJS(){	
				ban = document.getElementById("ban1");
				cue = document.getElementById("cue1");
				chenum = document.getElementById("chenum1");
				if(ban.value !=="" && cue.value !=="" && chenum.value !== ""){
					Tmon = document.getElementById("Tmon");
					// manejo del texto del combo moneda
						var Vmontext = Tmon.options[Tmon.selectedIndex].text;
					//--
					Vmon = Tmon.value;
					total = document.getElementById("total").value;
					pagtotal = document.getElementById("PagTotal").value;
					var Saldo =  parseFloat(total) - parseFloat(pagtotal);
					Saldo = Saldo * 100;//-- inicia proceso de redondeo
					Saldo = Math.round(Saldo); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
					Saldo = Saldo/100;//-- finaliza proceso de redondeo
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/compras/pago_cheque_pagado.php",{mon:Vmon,montex:Vmontext,monto:Saldo,tipo:7,cheqnum:chenum.value,banco:ban.value,cuenta:cue.value}, function(data){
					// Ponemos la respuesta de nuestro script en el DIV recargado
					$("#Pcontainer").html(data);
					});
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
					if(chenum.value ===""){
						chenum.className = "form-danger";
					}else{
						chenum.className = "form-control";
					}
					swal("Ups!", "Debe llenar los 3 campos de Selecci\u00F3n de Cheque...", "warning");
				}
			}
			
					
			function ConfirmCompraJS(){
				nfilas = document.getElementById("PagFilas").value;
				total = parseFloat(IFdetalle.detalle.ttotal.value);
				pagtotal = document.getElementById("PagTotal").value;
				if(nfilas > 0){
					if(total >= pagtotal){
						texto = "Desea realizar esta Compra o Gasto?";
						acc = "CompraJS()";
						ConfirmacionJs(texto,acc);
					}else{
						swal("Ups!", "El pago es mayor al total de la compra...", "info");
					}
				}else{
					swal("Ups!", "Faltan los datos del pago...", "info");
				}
			}
						
			function CompraJS(){
				nfilas = IFdetalle.detalle.filas.value;
				pfilas = document.getElementById("PagFilas").value;
				lfilas = document.getElementById("LotTotal").value;
				Tmon = document.getElementById("Tmon");
				var moneda = Tmon.options[Tmon.selectedIndex].text;
				prov = document.getElementById("prov");
				nit = document.getElementById("nit");
				nom = document.getElementById("nom");
				clas = document.getElementById("class");
				ref = document.getElementById("ref");
				suc = document.getElementById("suc");
				fec = document.getElementById("fec");
				total = IFdetalle.detalle.ttotal;
				stotal = IFdetalle.detalle.stotal;
				tdescuento = IFdetalle.detalle.tdescuento;
				//pago--
				pagtotal = document.getElementById("PagTotal");
				//--
				if(nfilas > 0){
					if(prov.value !== "" && suc.value !== "" && fec.value !== "" && ref.value !== "" && Tmon.value !== ""){
							//pago--
							var arrptipo = "|";
							var arrmonto = "|";
							var arrmoneda = "|";
							var arrcambio = "|";
							var arropera = "|";
							var arrdoc = "|";
							var arrobs = "|";
							var arrsuc = "|";
							var arrcaja = "|";
							var arrban = "|";
							var arrcue = "|";
							//lotes anclados--
							var arrlote = "|";
							var arrlotart = "|";
							var arrlotgru = "|";
							//-
							var C = 1;
							//arrays de pago
							for(var i = 1; i <= pfilas; i ++){
								//extrae datos del grid
								pagtipo = document.getElementById("Ttpag"+i).value;
								opera = document.getElementById("Toperador"+i).value;
								doc = document.getElementById("Tboucher"+i).value;
								pagmonto = document.getElementById("Tmonto"+i).value;
								obs = document.getElementById("Tobserva"+i).value;
								sucur = document.getElementById("Tsucur"+i).value;
								caja = document.getElementById("Tcaja"+i).value;
								banco = document.getElementById("Tbanco"+i).value;
								cuenta = document.getElementById("Tcuenta"+i).value;
								//-- crea string a convertir en arrays
								arrptipo+= pagtipo+"|";
								arrmonto+= pagmonto+"|";
								arropera+= opera+"|";
								arrdoc+= doc+"|";
								arrobs+= obs+"|";
								arrsuc+= sucur+"|";
								arrcaja+= caja+"|";
								arrban+= banco+"|";
								arrcue+= cuenta+"|";
							}
							//arrays de lotes anclados a la compra
							if(lfilas > 0){
								for(var k = 1; k <= lfilas; k ++){
									//extrae datos del grid
									lote = document.getElementById("TLlot"+k).value;
									lotart = document.getElementById("TLart"+k).value;
									lotgru = document.getElementById("TLgru"+k).value;
									//-- crea string a convertir en arrays
									arrlote+= lote+"|";
									arrlotart+= lotart+"|";
									arrlotgru+= lotgru+"|";
								}
							}
							abrir();
							xajax_Grabar_Compra(nfilas,prov.value,clas.value,ref.value,suc.value,fec.value,stotal.value,tdescuento.value,total.value,Tmon.value,moneda,pfilas,arrptipo,arrmonto,arrdoc,arropera,arrobs,arrsuc,arrcaja,arrban,arrcue,pagtotal.value,lfilas,arrlote,arrlotart,arrlotgru);
							//alert("paso");
					}else{
						if(prov.value === ""){
							prov.className = "form-danger";
						}else{
							prov.className = "form-control";
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
						if(fec.value === ""){
							fec.className = "form-danger";
						}else{
							fec.className = "form-control";
						}
						if(ref.value === ""){
							ref.className = "form-danger";
						}else{
							ref.className = "form-control";
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
					swal("Ups!", "No hay art&iacute;culos o Servicios listados para Compra...", "info");
				}	
			}
						
			function Limpiar_Campos_Compra(){
				inppar = document.getElementById("par");
				inpAart = document.getElementById("Aart");
				inpSart = document.getElementById("Sart");
				inpAbarc = document.getElementById("Abarc");
				inpSbarc = document.getElementById("Sbarc");
				inpbarc = document.getElementById("barc");
				inpart = document.getElementById("art");
				inpartn = document.getElementById("artn");
				inpcant = document.getElementById("cant");
				inpdesc = document.getElementById("desc");
				inpdsc = document.getElementById("dsc");
				inpprem = document.getElementById("prem");
				inpprec = document.getElementById("prec");
				inpprev = document.getElementById("prev");
				// Despinta campos
				inppar.className = "form-control";
				inpcant.className = "form-control";
				inpdesc.className = "form-control";
				inpdsc.className = "form-control";
				inpprem.className = "form-control";
				inpprec.className = "form-control";
				inpprev.className = "form-control";
				//Limpia los campos para un nuevo articulo	
				inpAart.value = "";
				inpSart.value = "";
				inpAbarc.value = "";
				inpSbarc.value = "";
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
			}
			
			function monedaText(){
				var combo = document.getElementById("mon");
				var selected = combo.options[combo.selectedIndex].text;
				alert(selected);
			}
			

	///////////////////------------------ CARGA --------------//////////////////////////////							
			function CargaJS(compra,nfilas){
				suc = document.getElementById("suc");
				prov = document.getElementById("prov");
				if(nfilas > 0){
					if(suc.value !== "" && prov.value !== "" && compra !== ""){
						abrir();
						xajax_Grabar_Carga(suc.value,compra,prov.value);
						//alert("entro");
					}else{
						if(suc.value === ""){
							suc.className = "form-danger";
						}else{
							suc.className = "form-control";
						}
						if(prov.value === ""){
							prov.className = "form-danger";
						}else{
							prov.className = "form-control";
						}
						swal("Ups!", "Debe llenar los datos obligatorios...", "warning");
					}
				}else{
					swal("Ups!", "No hay art&iacute;culos para Descargar...", "info");
				}	
			}
			
			/////////////////------------ PROVEEDOR  -------------------/////////////
			
			function Proveedor(){
				nit = document.getElementById('nit');
				if(nit.value !==""){
					abrir();
					xajax_Show_Proveedor(nit.value);
				}
			}
			
			function Ul_Proveedor_Carga(){
				var x = 0;
				$.post("../promts/inventario/popprov.php",{tipo:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#sprovul").html(data);
				});
			}
			
			function ResetProv(){
				nom = document.getElementById('nom');
				nit = document.getElementById('nit');
				prov = document.getElementById('prov');
				nom.value = "";
				nit.value = "";
				prov.value = "";
			}
			
			function NewProveedor(pnit){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/proveedor/new_proveedor.php",{nit:pnit}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function SearchProveedor(){
				var x = 0;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/proveedor/busca_proveedor.php",{variable:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			/*function BuscarProveedor(){
				abrir();
				nom = document.getElementById('pnom1');
				contac = document.getElementById("pcontac1");
				
				if(nom.value !=="" || contac.value !== ""){
					xajax_Buscar_Proveedor(nom.value,contac.value);
				}else{
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(contac.value ===""){
						contac.className = "form-danger";
					}else{
						contac.className = "form-control";
					}
					msj = '<h5>Determinar almenos un criterio de busqueda (Nombre de la Empresa o Contacto)</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}*/
			
			function SeleccionarProveedor(fila){
				cod = document.getElementById('Ppcod'+fila);
				nit = document.getElementById('Ppnit'+fila);
				nom = document.getElementById('Ppnom'+fila);
				inpcod = document.getElementById('prov');
				inpnit = document.getElementById('nit');
				inpnom = document.getElementById('nom');
				//---
				inpcod.value = cod.value;
				inpnit.value = nit.value;
				inpnom.value = nom.value;
				//document.getElementById('art').focus();
				cerrar();
			}
			
			function GrabarProveedor(){
				nit = document.getElementById('pnit1');
				nom = document.getElementById('pnom1');
				direc = document.getElementById("pdirec1");
				tel1 = document.getElementById("ptel1");
				tel2 = document.getElementById("ptel2");
				contac = document.getElementById("pcontac1");
				telc = document.getElementById("ptelc1");
				mail = document.getElementById("pmail1");
				//alert(nom.value);
				
				if(nit.value !=="" && nom.value !=="" && direc.value !== "" && tel1.value !== "" && contac.value !== ""){
					abrirMixPromt();
					xajax_Grabar_Proveedor(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,contac.value,telc.value);
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
					if(tel1.value ===""){
						tel1.className = "form-danger";
					}else{
						tel1.className = "form-control";
					}
					if(contac.value ===""){
						contac.className = "form-danger";
					}else{
						contac.className = "form-control";
					}
					swal("Ups!", "Debe llenar los datos obligatorios...", "warning");
				}
			}
			
		/////////////////------------ BARCODE  -------------------/////////////
		
			function Barcode(){
				var barc;
				Abarc = document.getElementById('Abarc').value;
				Sbarc = document.getElementById('Sbarc').value;
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				
				if(Abarc !== ""){
					barc = Abarc;
				}else if(Sbarc !== ""){
					barc = Sbarc;
				}else{
					barc = "";
				}
				
				//alert(barc+","+y);
				if(barc !== ""){
					xajax_Show_Barcode(barc,y);
				}
			}
				
		/////////////////------------ ARTICULO  -------------------/////////////
		
			function Articulo(){
				art = document.getElementById('Aart').value;
				barc = document.getElementById('Abarc').value;
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				
				//alert(art+","+barc+","+y);
				if(art !=="" || barc !==""){
					xajax_Show_Articulo(art,barc,y);
				}
			}
			
			
			function Suministro(){
				art = document.getElementById('Sart').value;
				barc = document.getElementById('Sbarc').value;
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				
				//alert(art+","+barc+","+y);
				if(art !=="" || barc !==""){
					xajax_Show_Suministro(art,barc,y);
				}
			}
			
			
			function Ul_Articulo_Carga(n){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inComprario/popart.php",{tipo:n}, function(data){
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
				mon = document.getElementById('mon');
				mon.value = "";
				mon.removeAttribute('disabled');
			}
						
			function SearchArticulo(x){
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/articulo/busca_articulo.php",{formulario:x,empresa:y}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function SearchSuministro(x){
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/suministro/busca_articulo.php",{formulario:x,empresa:y}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function BuscarArticulo(x){
				abrir();
				gru = document.getElementById('gru1');
				marca = document.getElementById('amarca1');
				nom = document.getElementById("anom1");
				desc = document.getElementById("adesc1");
				suc = document.getElementById("suc1");
				
				if(gru.value !=="" || nom.value !=="" || marca.value !== "" || desc.value !== ""){
					xajax_Buscar_Articulo(gru.value,nom.value,desc.value,marca.value,suc.value,x);
				}else{
					if(gru.value ===""){
						gru.className = "form-danger";
					}else{
						gru.className = "form-control";
					}
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(marca.value ===""){
						marca.className = "form-danger";
					}else{
						marca.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					swal("Ups!", "Determinar almenos un criterio de busqueda...", "warning");
				}
			}
			
			
			function BuscarSuministro(x){
				abrir();
				gru = document.getElementById('gru1');
				marca = document.getElementById('amarca1');
				nom = document.getElementById("anom1");
				desc = document.getElementById("adesc1");
				suc = document.getElementById("suc1");
				
				if(gru.value !=="" || nom.value !=="" || marca.value !== "" || desc.value !== ""){
					xajax_Buscar_Suministro(gru.value,nom.value,desc.value,marca.value,suc.value,x);
				}else{
					if(gru.value ===""){
						gru.className = "form-danger";
					}else{
						gru.className = "form-control";
					}
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(marca.value ===""){
						marca.className = "form-danger";
					}else{
						marca.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					swal("Ups!", "Determinar almenos un criterio de busqueda...", "warning");
				}
			}
		
			
			function SeleccionarArticulo(fila){
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
			
			
			function SearchLote(){
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/articulo/busca_articulo.php",{formulario:3,empresa:y}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function SeleccionarLote(fila,i){
				nfilas = parseInt(document.getElementById("LotTotal").value);
				abrir();
				var bandera = false;
				var arrlot = "|";
				var arrart = "|";
				var arrgru = "|";
				//-- recibe datos
				inplote = document.getElementById('Lacod'+fila+'_'+i).value;
				inplote = inplote.split("A"); 
				var lot = parseInt(inplote[0]);
				var art = parseInt(inplote[1]);
				var gru = parseInt(inplote[2]);
				//alert(lot+"-"+art+"-"+gru);
				//---
				for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
					TLlot = parseInt(document.getElementById("TLlot"+i).value);
					TLart = parseInt(document.getElementById("TLart"+i).value);
					TLgru = parseInt(document.getElementById("TLgru"+i).value);
					//alert(codigo +","+ artc);
					if(TLlot === lot && TLart === art && TLgru === gru){ //si ya esta listado y es producto
						cerrar();
						cerrar();
						return;
					}else{
						arrlot+= TLlot+"|";
						arrart+= TLart+"|";
						arrgru+= TLgru+"|";
					}
				}
				nfilas++;
				arrlot+= lot;
				arrart+= art;
				arrgru+= gru;
				//--
				xajax_Selecciona_Lote(nfilas,arrlot,arrart,arrgru);
				cerrar();
			}
		
			
	////////------- Historial de Compras -------/////////////
	
			function BuscarHist(){
				abrir();
				suc = document.getElementById('suc');
				clas = document.getElementById('class');
				cod = document.getElementById('cod');
				doc = document.getElementById('ref');
				prov = document.getElementById("prov");
				nit = document.getElementById("nit");
				nom = document.getElementById("nom");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				sit = document.getElementById("sit");
				
				if(suc.value !=="" || clas.value !=="" || cod.value !== "" || doc.value !== "" || prov.value !== "" || fini.value !== "" || ffin.value !== ""){
					xajax_Buscar_Historial(cod.value,clas.value,prov.value,suc.value,doc.value,fini.value,ffin.value,sit.value);
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					if(clas.value ===""){
						clas.className = "form-info";
					}else{
						clas.className = "form-control";
					}
					if(cod.value ===""){
						cod.className = "form-info";
					}else{
						cod.className = "form-control";
					}
					if(doc.value ===""){
						doc.className = "form-info";
					}else{
						doc.className = "form-control";
					}
					if(nit.value ===""){
						nit.className = "form-info";
					}else{
						nit.className = "form-control";
					}
					if(nom.value ===""){
						nom.className = "form-info";
					}else{
						nom.className = "form-control";
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
			
			
	////////------ Reportes ------------------//////////////
	
			function Ver_Detalle_Compra(comp){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/compras/detalle_compra.php",{compra:comp}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function ReporteAnula(){
				suc = document.getElementById('suc');
				clas = document.getElementById('class');
				cod = document.getElementById('cod');
				doc = document.getElementById('ref');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				sit = document.getElementById("sit");
				
				if(suc.value !=="" || clas.value !=="" || cod.value !== "" || doc.value !== "" || fini.value !== "" || ffin.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPanula.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					if(clas.value ===""){
						clas.className = "form-info";
					}else{
						clas.className = "form-control";
					}
					if(cod.value ===""){
						cod.className = "form-info";
					}else{
						cod.className = "form-control";
					}
					if(doc.value ===""){
						doc.className = "form-info";
					}else{
						doc.className = "form-control";
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
				doc = document.getElementById("ref");
				comp = document.getElementById("cod");
				
				if(doc.value !== "" || comp.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPpagos.php";
					myform.submit();
				}else{
					if(comp.value ===""){
						comp.className = "form-info";
					}else{
						comp.className = "form-control";
					}
					if(doc.value ===""){
						doc.className = "form-info";
					}else{
						doc.className = "form-control";
					}
					swal("Ups!", "Determinar almenos un criterio de busqueda...", "info");
				}
			}
			
			function ReporteCredit(){
				suc = document.getElementById('suc');
				clas = document.getElementById('class');
				cod = document.getElementById('cod');
				doc = document.getElementById('ref');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				sit = document.getElementById("sit");
				
				if(suc.value !=="" || clas.value !=="" || cod.value !== "" || doc.value !== "" || fini.value !== "" || ffin.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPcreditos.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					if(clas.value ===""){
						clas.className = "form-info";
					}else{
						clas.className = "form-control";
					}
					if(cod.value ===""){
						cod.className = "form-info";
					}else{
						cod.className = "form-control";
					}
					if(doc.value ===""){
						doc.className = "form-info";
					}else{
						doc.className = "form-control";
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
				abrir();
				suc = document.getElementById('suc');
				clas = document.getElementById('class');
				cod = document.getElementById('cod');
				doc = document.getElementById('ref');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(suc.value !=="" || clas.value !=="" || cod.value !== "" || doc.value !== "" || fini.value !== "" || ffin.value !== ""){
					xajax_Buscar_Deudas(cod.value,clas.value,suc.value,doc.value,fini.value,ffin.value);
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					if(clas.value ===""){
						clas.className = "form-info";
					}else{
						clas.className = "form-control";
					}
					if(cod.value ===""){
						cod.className = "form-info";
					}else{
						cod.className = "form-control";
					}
					if(doc.value ===""){
						doc.className = "form-info";
					}else{
						doc.className = "form-control";
					}
					if(nit.value ===""){
						nit.className = "form-info";
					}else{
						nit.className = "form-control";
					}
					if(nom.value ===""){
						nom.className = "form-info";
					}else{
						nom.className = "form-control";
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
			
			function Ejecutar_Credito(cod,comp){
				abrir();
				texto = "Desea Ejecutar este Cr&eacute;dito? Se quitara de la lista y se dar&aacute; por pagado en su totalidad...";
				acc = "xajax_Ejecutar_Credito("+cod+","+comp+")";
				ConfirmacionJs(texto,acc);
			}
			
	
			////////------- Anulacion de Ventas -------/////////////

			
			function ConfirmAnular(comp){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/compras/cambia_sit.php",{cod:comp}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			
			function CambiarSituacion(){
				just = document.getElementById('just1');
				comp = document.getElementById('comp1').value;
				if(just.value !== ""){
					cerrarModal();
					xajax_Cambiar_Situacion(comp);
				}else{
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
		
		stotal = document.getElementById("stotal"); //-- subtotal
		tdescuento = document.getElementById("tdescuento"); //-- descuento de la factura
		ttdescuento = document.getElementById("ttdescuento"); //-- tipo de descuento de la factura
		rtotal = document.getElementById("Rtotal"); //-- Total sin descuentos
		ttotal = document.getElementById("total"); //-- total final
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
			tdescuento.value = descuento;
			ttdescuento.value = tfdsc.value;
			spandscgeneral.innerHTML = Vmons+" "+descuento;
			//--TOTAL
			var TTOTAL = (parseFloat(Rtotal) - parseFloat(descuento));
			TTOTAL = TTOTAL * 100;//-- inicia proceso de redondeo
			TTOTAL = Math.round(TTOTAL); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
			TTOTAL = TTOTAL/100;//-- finaliza proceso de redondeo
			//alert(TTOTAL);
			spanttotal.innerHTML = Vmons+" "+TTOTAL;
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
	