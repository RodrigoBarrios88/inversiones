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
				texto = "&iquest;Desea Cancelar esta transacci\u00F3n?, perdera los datos escritos...";
				acc = "location.href=\'FRMsolicitud.php\'";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar(){
				texto = "&iquest;Desea Cancelar esta transacci\u00F3n?, perdera los datos escritos...";
				acc = "location.href=\'FRMproyecto.php\'";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar2(){
				texto = "&iquest;Desea Limpiar la Pagina?";
				acc = "location.href=\'FRMhistorial.php\'";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar3(){
				texto = "&iquest;Desea Limpiar la Pagina?";
				acc = "location.href=\'FRMcuentaxcob.php\'";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar4(){
				texto = "&iquest;Desea Limpiar la Pagina?";
				acc = "location.href=\'FRManula.php\'";
				ConfirmacionJs(texto,acc);
			}
															
			function Submit(tipo){
				myform = document.forms.f1;
				if(tipo == 1){
					myform.action ="REPvale.php";
				}else if(tipo == 2){
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
			
			function msjAlert(texto,pagina){
				msj = '<span>'+texto+'</span><br><br>';
				msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\''+pagina+'\'" />';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
			
			function cerrarProgress(){
				document.getElementById('progress').innerHTML = "";
			}
			
			function Empresa_CajaJS(valor){
				xajax_Combo_Caja_Empresa(valor,"caja1","scaja1","");
			}
			
			function BuscarProyecto(){
				pro = document.getElementById("cod");
				nit = document.getElementById("nit");
				//--
				if(pro.value !="" || nit.value !=""){
					abrir();
					xajax_Buscar_Proyecto(pro.value,nit.value);
				}
			}
			
	///////////////////------------------ Proyecto --------------//////////////////////////////				
			
			function TipoProyecto(x){
				lb1 = document.getElementById('lb1');
				lb2 = document.getElementById('lb2');
				lb3 = document.getElementById('lb3');
				lb4 = document.getElementById('lb4');
				lb5 = document.getElementById('lb5');
				cnt1 = document.getElementById('cnt1');
				cnt2 = document.getElementById('cnt2');
				cnt3 = document.getElementById('cnt3');
				cantlimit = document.getElementById('cantlimit');
				desc = document.getElementById('desc');
				//--
				inpbarc = document.getElementById("barc");
				inpart = document.getElementById("art");
				inpartn = document.getElementById("artn");
				inpcant = document.getElementById("cant");
				prev = document.getElementById('prev');
				mon = document.getElementById('mon');
				inpbarc.value = "";
				inpart.value = "";
				inpartn.value = "";
				inpcant.value = "";
				prev.value = "";
				desc.value = "";
				mon.value = "";
				mon.removeAttribute('disabled');
				
				if(x == "P"){
					lb1.style.visibility = "visible";
					lb2.style.visibility = "visible";
					lb3.style.visibility = "visible";
					lb3.innerHTML = 'Codigo Prod.: <span class = "requerido">*</span><span class = "busca">*</span>';
					lb4.style.visibility = "visible";
					lb4.innerHTML = 'Articulo: <span class = "requerido">*</span>';
					lb5.style.visibility = "hidden";
					cnt1.style.visibility = "visible";
					cnt2.style.visibility = "visible";
					txt2 = '<input type = "text" class = "text" name = "art" id = "art" onkeyup = "texto(this);KeyEnter(this,Articulo);" />'; 
					txt2+= '<a href = "javascript:void(0);" onclick = "SearchArticulo(1);"  title = "Click para Buscar el Art&iacute;culo" style = "border:none;" >';
					txt2+= '<img width = "25px;" src = "../../CONFIG/images/search1.png" onmouseover = "this.src=\'../../CONFIG/images/search2.png\'" onmouseout = "this.src=\'../../CONFIG/images/search1.png\'" style = "vertical-align:middle;border:none;">';
					txt2+= '</a>';
					cnt2.innerHTML = txt2;
					cnt3.style.visibility = "visible";
					txt3 = '<input type = "text" class = "text" name = "artn" id = "artn" readonly />'; 
					txt3+= '<a href = "javascript:void(0);" onclick = "ResetArt(1);"  title = "Click para Limpiar Campos de Art&iacute;culo" style = "border:none;" >';
					txt3+= '<img src = "../../CONFIG/images/icons/refresh.png" style = "vertical-align:middle;border:none;">';
					txt3+= '</a>';
					cnt3.innerHTML = txt3;
					cantlimit.style.visibility = "visible";
					desc.style.visibility = "hidden";
				}else if(x == "S"){
					lb1.style.visibility = "visible";
					lb2.style.visibility = "hidden";
					lb3.style.visibility = "visible";
					lb3.innerHTML = 'Codigo Serv.: <span class = "requerido">*</span><span class = "busca">*</span>';
					lb4.style.visibility = "visible";
					lb4.innerHTML = 'Servicio: <span class = "requerido">*</span>';
					lb5.style.visibility = "hidden";
					cnt1.style.visibility = "visible";
					cnt2.style.visibility = "visible";
					txt2 = '<input type = "text" class = "text" name = "art" id = "art" onkeyup = "texto(this);KeyEnter(this,Servicio);" />'; 
					txt2+= '<a href = "javascript:void(0);" onclick = "SearchServicio(1);"  title = "Click para Buscar el Servicio" style = "border:none;" >';
					txt2+= '<img width = "25px;" src = "../../CONFIG/images/search1.png" onmouseover = "this.src=\'../../CONFIG/images/search2.png\'" onmouseout = "this.src=\'../../CONFIG/images/search1.png\'" style = "vertical-align:middle;border:none;">';
					txt2+= '</a>';
					cnt2.innerHTML = txt2;
					cnt3.style.visibility = "visible";
					txt3 = '<input type = "text" class = "text" name = "artn" id = "artn" readonly />'; 
					txt3+= '<a href = "javascript:void(0);" onclick = "ResetServ(1);"  title = "Click para Limpiar Campos de Servicio" style = "border:none;" >';
					txt3+= '<img src = "../../CONFIG/images/icons/refresh.png" style = "vertical-align:middle;border:none;">';
					txt3+= '</a>';
					cnt3.innerHTML = txt3;
					cantlimit.style.visibility = "hidden";
					desc.style.visibility = "hidden";
				}else if(x == "O"){
					lb1.style.visibility = "hidden";
					lb2.style.visibility = "hidden";
					lb3.style.visibility = "hidden";
					lb4.style.visibility = "hidden";
					lb5.style.visibility = "visible";
					cnt1.style.visibility = "hidden";
					cnt2.style.visibility = "hidden";
					cnt3.style.visibility = "hidden";
					cantlimit.style.visibility = "hidden";
					desc.style.visibility = "visible";
				}
			}
			
			function NewFilaProyecto(){
				nfilas = document.getElementById("filas").value;
				fac = document.getElementById("fac");
				//descuentos
				tfdsc = document.getElementById("tfdsc");
				fdsc = document.getElementById("fdsc");
				//--
				Tmon = document.getElementById("Tmon");
				var moneda = Tmon.options[Tmon.selectedIndex].text;
				abrir();
				var bandera = false;
				var arrtipo = new Array();
				var arrdesc = new Array();
				var arrbarc = new Array();
				var arrartc = new Array();
				var arrcant = new Array();
				var arrprev = new Array();
				var arrmon = new Array();
				var arrmons = new Array();
				var arrmonc = new Array();
				//descuentos
				var arrtdsc = new Array();
				var arrdsc = new Array();
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
					inpdsc.value = (inpdsc.value != "")?inpdsc.value:0;
					inpcant = document.getElementById("cant");
					spaniva = document.getElementById("spaniva");
					inpclimit = document.getElementById("cantlimit");
					inpclimit.value = (inpclimit.value != "")?inpclimit.value:0;
					//--
					var IVA = 0;
					//--
					//alert(inptipo.value+","+inpprev.value+","+inpmon.value+","+inpdsc.value+","+inpcant.value);
				if(inptipo.value != "" && inpprev.value != "" && inpmon.value != "" && inpdsc.value != "" && inpcant.value != ""){
					if((inptipo.value == "P" && inpart.value != "" && inpartn.value != "") || (inptipo.value == "S" && inpart.value != "" && inpartn.value != "") || (inptipo.value == "O" && inpdesc.value != "")){
						// manejo del texto del combo moneda
						var montext = inpmon.options[inpmon.selectedIndex].text;
						//-- extrae el simbolo de la moneda y tipo de cambio
							monchunk = montext.split("/");
							var Vmons = monchunk[1]; // Simbolo de Moneda
							var Vmonc = monchunk[2]; // Tipo de Cambio
							Vmonc = Vmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
							Vmonc = Vmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
						//--
						//-- Validaciones especificas para cada tipo
						if(inptipo.value == "P"){
							inpart.value = Codigo_Art_JS(inpart.value); // agrega ceros con javascript para igualar al que viene de php
						}else if(inptipo.value == "S"){
							inpart.value = Codigo_Art_JS(inpart.value); // agrega ceros con javascript para igualar al que viene de php
						}else if(inptipo.value == "O"){
							inpclimit.value = inpcant.value; // como es un servicio y no se encuentra registrado en inv. iguala la cantidad limite existente con la cantidad solicitada para que siempre halla existencia
						}
						//--
						if(parseInt(inpclimit.value)  >= parseInt(inpcant.value)){
							var iguales = false; //valida si ya existe ese lote en la lista
							var codigo = inpart.value;
							//------------
							for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
								artc = document.getElementById("artc"+i).value;
								tipc = document.getElementById("tip"+i).value;
								//alert(codigo +","+ artc);
								if(codigo == artc && inptipo.value == "P" && tipc == "P"){ //si ya esta listado y es producto
									ncant = document.getElementById("cant"+i); //recibe input hidden de fila 
									ndsc = document.getElementById("dsc"+i); //recibe input hidden de fila 
									nrtot = document.getElementById("rtot"+i); //recibe input hidden de fila 
									nstot = document.getElementById("stot"+i); //recibe input hidden de fila 
									nprev = document.getElementById("prev"+i); //recibe input hidden de fila 
									nmons = document.getElementById("mons"+i); //recibe input hidden de fila 
									spancant = document.getElementById("spancant"+i); //recibe span de cant en la fila 
									spandsc = document.getElementById("spandsc"+i); //recibe span de dsc en la fila 
									spanstot = document.getElementById("spanstot"+i); //recibe span de stot en la fila 
									tcant = parseInt(ncant.value) + parseInt(inpcant.value); //suma las cantidades
									rtot = parseFloat(nprev.value) * parseFloat(tcant); //suma las cantidades;
									stot = parseFloat(rtot) - ((parseFloat(rtot) * parseFloat(inpdsc.value))/100);
									stot = stot * 100;//-- inicia proceso de redondeo
									stot = Math.round(stot); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
									stot = stot/100;//-- finaliza proceso de redondeo
									
									if(parseInt(inpclimit.value)  >= parseInt(tcant)){ //si hay suficiente existencia con todo sumado
										ncant.value = tcant;
										nrtot.value = rtot;
										nstot.value = stot;
										ndsc.value = inpdsc.value;
										spancant.innerHTML = tcant;
										spandsc.innerHTML = inpdsc.value+" %";
										spanstot.innerHTML = nmons.value+" "+stot;
										//llama la funcion para realizar el cambio de Moneda y sumatoria de totales
										ExeTipoCambio(Tmon);
										iguales = true;
										//i = nfilas;
										Limpiar_Campos_Proyecto();
										cerrar();
										return;
									}else{ //si no hay suficiente existencia con todo sumado
										iguales = true;
										inpcant.style.borderColor = "#DF3A01";
										inpcant.style.backgroundColor = "#F7BE81";
										msj = '<span>No hay existencia suficiente de ese lote de articulos. Existencia : '+inpclimit.value+'. Usted desea '+tcant+'...</span><br><br>';
										msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
										document.getElementById('lblparrafo').innerHTML = msj;
										return; //sale de la funcion
									}
								}else{
									iguales = false;
								}
							}
							if(iguales == false){ //verifica que realmente no sea un articulo ya listado
								for(var i = 1; i <= nfilas; i ++){
									//extrae datos del grid
									tipo = document.getElementById("tip"+i).value;
									desc = document.getElementById("desc"+i).value;
									barc = document.getElementById("barc"+i).value;
									artc = document.getElementById("artc"+i).value;
									cant = document.getElementById("cant"+i).value;
									prev = document.getElementById("prev"+i).value;
									mon = document.getElementById("mon"+i).value;
									mons = document.getElementById("mons"+i).value;
									monc = document.getElementById("monc"+i).value;
									tdsc = document.getElementById("tdsc"+i).value;
									dsc = document.getElementById("dsc"+i).value;
									//-- crea string a convertir en arrays
									arrtipo[i] = tipo;
									arrdesc[i] = desc;
									arrbarc[i] = barc;
									arrartc[i] = artc;
									arrcant[i] = cant;
									arrprev[i] = prev;
									arrtdsc[i] = tdsc;
									arrdsc[i] = dsc;
									arrmon[i] = mon;
									arrmons[i] = mons;
									arrmonc[i] = monc;
								}
								nfilas++;
								//trae los datos del formulario de ingreso
									var xtipo = inptipo.value;
									if(xtipo == "P"){
									 var xdesc = inpartn.value;
									}else if(xtipo == "S"){
									 var xdesc = inpartn.value;
									}else if(xtipo == "O"){
									 var xdesc = inpdesc.value;
									}
									var xbarc = inpbarc.value;
									var xartc = inpart.value;
									var xcant = inpcant.value;
									var xprev = inpprev.value;
									var xtdsc = inptdsc.value;
									var xdsc = inpdsc.value;
									var xmon = inpmon.value;
									var xmons = Vmons;
									var xmonc = Vmonc;
								//-- llena el array con los datos en el grid
									arrtipo[i] = xtipo;
									arrdesc[i] = xdesc;
									arrbarc[i] = xbarc;
									arrartc[i] = xartc;
									arrcant[i] = xcant;
									arrprev[i] = xprev;
									arrtdsc[i] = xtdsc;
									arrdsc[i] = xdsc;
									arrmon[i] = xmon;
									arrmons[i] = xmons;
									arrmonc[i] = xmonc;
									
								// ejecuta la funcion de ajax para refrescar el grid
								//alert(arrtdsc[1]);
								xajax_Grid_Fila_Proyecto(nfilas,moneda,arrcant,arrtipo,arrbarc,arrartc,arrdesc,arrprev,arrmon,arrmons,arrmonc,tfdsc.value,fdsc.value,arrtdsc,arrdsc,IVA);
								Limpiar_Campos_Proyecto();
							}
						}else{
							inpcant.style.borderColor = "#DF3A01";
							inpcant.style.backgroundColor = "#F7BE81";
							msj = '<span>No hay existencia suficiente de ese lote de articulos. Existencia : '+inpclimit.value+'. Usted desea '+inpcant.value+'...</span><br><br>';
							msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						if(inpart.value ==""){
							inpart.style.borderColor = "#DF0101";
							inpart.style.backgroundColor = "819FF7";
						}else{
							inpart.style.borderColor = "#ccc";
							inpart.style.backgroundColor = "#fff";
						}
						if(inpartn.value ==""){
							inpartn.style.borderColor = "#DF0101";
							inpartn.style.backgroundColor = "819FF7";
						}else{
							inpartn.style.borderColor = "#ccc";
							inpartn.style.backgroundColor = "#fff";
						}
						if(inpbarc.value ==""){
							inpbarc.style.borderColor = "#DF0101";
							inpbarc.style.backgroundColor = "819FF7";
						}else{
							inpbarc.style.borderColor = "#ccc";
							inpbarc.style.backgroundColor = "#fff";
						}
						if(inpdesc.value ==""){
							inpdesc.style.borderColor = "#DF0101";
							inpdesc.style.backgroundColor = "819FF7";
						}else{
							inpdesc.style.borderColor = "#ccc";
							inpdesc.style.backgroundColor = "#fff";
						}
						msj = '<span>No ha ingresado uno o mas datos de la venta...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if(inptipo.value ==""){
						inptipo.style.borderColor = "#DF0101";
						inptipo.style.backgroundColor = "819FF7";
					}else{
						inptipo.style.borderColor = "#ccc";
						inptipo.style.backgroundColor = "#fff";
					}
					if(inpprev.value ==""){
						inpprev.style.borderColor = "#DF0101";
						inpprev.style.backgroundColor = "819FF7";
					}else{
						inpprev.style.borderColor = "#ccc";
						inpprev.style.backgroundColor = "#fff";
					}
					if(inpcant.value ==""){
						inpcant.style.borderColor = "#DF0101";
						inpcant.style.backgroundColor = "819FF7";
					}else{
						inpcant.style.borderColor = "#ccc";
						inpcant.style.backgroundColor = "#fff";
					}
					if(inpmon.value ==""){
						inpmon.style.borderColor = "#DF0101";
						inpmon.style.backgroundColor = "819FF7";
					}else{
						inpmon.style.borderColor = "#ccc";
						inpmon.style.backgroundColor = "#fff";
					}
					if(inpdsc.value ==""){
						inpdsc.style.borderColor = "#DF0101";
						inpdsc.style.backgroundColor = "819FF7";
					}else{
						inpdsc.style.borderColor = "#ccc";
						inpdsc.style.backgroundColor = "#fff";
					}
					msj = '<span>No ha ingresado uno o mas datos de la venta...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function QuitarFilaProyecto(x){
				nfilas = document.getElementById("filas").value;
				Tmon = document.getElementById("Tmon");
				fac = document.getElementById("fac");
				var moneda = Tmon.options[Tmon.selectedIndex].text;
				if(nfilas >= 1){
					abrir();
					var bandera = false;
					var arrtipo = new Array();
					var arrdesc = new Array();
					var arrbarc = new Array();
					var arrartc = new Array();
					var arrcant = new Array();
					var arrprev = new Array();
					var arrmon = new Array();
					var arrmons = new Array();
					var arrmonc = new Array();
					//descuentos
					var arrtdsc = new Array();
					var arrdsc = new Array();
					var C = 1;
					//--
					var IVA = (fac.checked)?"V":"F";
					//--
					for(var i = 1; i <= nfilas; i ++){
						//extrae datos del grid
							tipo = document.getElementById("tip"+i).value;
							desc = document.getElementById("desc"+i).value;
							barc = document.getElementById("barc"+i).value;
							artc = document.getElementById("artc"+i).value;
							cant = document.getElementById("cant"+i).value;
							prev = document.getElementById("prev"+i).value;
							mon = document.getElementById("mon"+i).value;
							mons = document.getElementById("mons"+i).value;
							monc = document.getElementById("monc"+i).value;
							tdsc = document.getElementById("tdsc"+i).value;
							dsc = document.getElementById("dsc"+i).value;
								
						//-- llena arrays
						if(i != x){
							arrtipo[C] = tipo;
							arrdesc[C] = desc;
							arrbarc[C] = barc;
							arrartc[C] = artc;
							arrcant[C] = cant;
							arrprev[C] = prev;
							arrtdsc[C] = tdsc;
							arrdsc[C] = dsc;
							arrmon[C] = mon;
							arrmons[C] = mons;
							arrmonc[C] = monc;
							C++;
						}
					}
					nfilas--;
					xajax_Grid_Fila_Proyecto(nfilas,moneda,arrcant,arrtipo,arrbarc,arrartc,arrdesc,arrprev,arrmon,arrmons,arrmonc,tfdsc.value,fdsc.value,arrtdsc,arrdsc,IVA);
				}
			}
			
			
			function NewFilaPago(){
				nfilas = document.getElementById("PagFilas").value;
				abrir();
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
					spanx = (inptipo.value == 3)?2:inptipo.value; // indica que si el pago es con tarjeta de credito lo agregue a t. debito
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
					inpttotal = document.getElementById("ttotal");
					inppagtotal = document.getElementById("PagTotal");
					Dcambiar = MonedaTipoCambio(Vmonc,Fmonc,inpmonto.value);
					Pagtotal = parseFloat(Dcambiar) + parseFloat(inppagtotal.value); //suma las cantidades;
				//****					
				if(parseFloat(Pagtotal) <= parseFloat(inpttotal.value)){	
					if(inptipo.value != "" && inpmonto.value != "" && inpmon.value != "" && inpmonFac.value != ""){
						if((inptipo.value == 1) || (inptipo.value == 2 && inpopera.value != "" && inpdoc.value != "") || (inptipo.value == 3 && inpopera.value != "" && inpdoc.value != "") || (inptipo.value == 4 && inpopera.value != "" && inpdoc.value != "" && inpobs.value != "") || (inptipo.value == 5 && inpopera.value != "" && inpdoc.value != "") || (inptipo.value == 6 && inpopera.value != "" && inpdoc.value != "")){
							
							var iguales = false; //valida si ya existe ese lote en la lista
							var codigo = spanx;
							//------------
								var total = 0;
								for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
									tipoc = document.getElementById("Ttpag"+i).value;
									//alert(codigo +","+ artc);
									if(codigo == tipoc){ //si ya esta listado el pago
										ntcamb = document.getElementById("Ttipcambio"+i); //recibe input hidden de fila ya listada
										nmonto = document.getElementById("Tmonto"+i); //recibe input hidden de fila ya listada
										Dcambiar = MonedaTipoCambio(ntcamb.value,Vmonc,nmonto.value);
										total += parseFloat(Dcambiar); //suma las cantidades;
										iguales = true;
									}
								}
								if(iguales == false){
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
									xajax_Grid_Fila_Proyecto_Pago(nfilas,arrtipo,arrmonto,arrmoneda,arrcambio,arropera,arrdoc,arrobs,Fmonc);
									cerrarPromt();
									
						}else{
							if(inpopera.value ==""){
								inpopera.style.borderColor = "#DF0101";
								inpopera.style.backgroundColor = "819FF7";
							}else{
								inpopera.style.borderColor = "#ccc";
								inpopera.style.backgroundColor = "#fff";
							}
							if(inpdoc.value ==""){
								inpdoc.style.borderColor = "#DF0101";
								inpdoc.style.backgroundColor = "819FF7";
							}else{
								inpdoc.style.borderColor = "#ccc";
								inpdoc.style.backgroundColor = "#fff";
							}
							if(inptipo.value == 4){
								if(inpobs.value ==""){
									inpobs.style.borderColor = "#DF0101";
									inpobs.style.backgroundColor = "819FF7";
								}else{
									inpobs.style.borderColor = "#ccc";
									inpobs.style.backgroundColor = "#fff";
								}
							}
							msj = '<span>No ha ingresado uno o mas datos del proyecto...</span><br><br>';
							msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						if(inptipo.value ==""){
							inptipo.style.borderColor = "#DF0101";
							inptipo.style.backgroundColor = "819FF7";
						}else{
							inptipo.style.borderColor = "#ccc";
							inptipo.style.backgroundColor = "#fff";
						}
						if(inpmonto.value ==""){
							inpmonto.style.borderColor = "#DF0101";
							inpmonto.style.backgroundColor = "819FF7";
						}else{
							inpmonto.style.borderColor = "#ccc";
							inpmonto.style.backgroundColor = "#fff";
						}
						if(inpmon.value ==""){
							inpmon.style.borderColor = "#DF0101";
							inpmon.style.backgroundColor = "819FF7";
						}else{
							inpmon.style.borderColor = "#ccc";
							inpmon.style.backgroundColor = "#fff";
						}
						if(inpmonFac.value ==""){
							inpmonFac.style.borderColor = "#DF0101";
							inpmonFac.style.backgroundColor = "819FF7";
						}else{
							inpmonFac.style.borderColor = "#ccc";
							inpmonFac.style.backgroundColor = "#fff";
						}
						msj = '<span>No ha ingresado uno o mas datos del pago...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<span>El monto a pagar excede el monto total de la compra...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function NewFilaPago2(){
				nfilas = document.getElementById("PagFilas").value;
				abrir();
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
					spanx = (inptipo.value == 3)?2:inptipo.value; // indica que si el pago es con tarjeta de credito lo agregue a t. debito
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
					if(inptipo.value != "" && inpmonto.value != "" && inpmon.value != "" && tcambiodia.value != ""){
						if((inptipo.value == 1) || (inptipo.value == 2 && inpopera.value != "" && inpdoc.value != "") || (inptipo.value == 3 && inpopera.value != "" && inpdoc.value != "") || (inptipo.value == 4 && inpopera.value != "" && inpdoc.value != "" && inpobs.value != "") || (inptipo.value == 5 && inpopera.value != "" && inpdoc.value != "") || (inptipo.value == 6 && inpopera.value != "" && inpdoc.value != "")){
							
							var iguales = false; //valida si ya existe ese lote en la lista
							var codigo = spanx;
							//------------
								var total = 0;
								for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
									tipoc = document.getElementById("Ttpag"+i).value;
									//alert(codigo +","+ artc);
									if(codigo == tipoc){ //si ya esta listado el pago combierte las filas anteriores a la ultima moneda puesta
										ntcamb = document.getElementById("Ttipcambio"+i); //recibe input hidden de fila ya listada
										nmonto = document.getElementById("Tmonto"+i); //recibe input hidden de fila ya listada
										Dcambiar = MonedaTipoCambio(ntcamb.value,Vmonc,nmonto.value);
										total += parseFloat(Dcambiar); //suma las cantidades;
										iguales = true;
									}
								}
								if(iguales == false){
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
									xajax_Grid_Fila_Proyecto_Pago(nfilas,arrtipo,arrmonto,arrmoneda,arrcambio,arropera,arrdoc,arrobs,tcambiodia.value);
									cerrarPromt();
									
						}else{
							if(inpopera.value ==""){
								inpopera.style.borderColor = "#DF0101";
								inpopera.style.backgroundColor = "819FF7";
							}else{
								inpopera.style.borderColor = "#ccc";
								inpopera.style.backgroundColor = "#fff";
							}
							if(inpdoc.value ==""){
								inpdoc.style.borderColor = "#DF0101";
								inpdoc.style.backgroundColor = "819FF7";
							}else{
								inpdoc.style.borderColor = "#ccc";
								inpdoc.style.backgroundColor = "#fff";
							}
							if(inptipo.value == 4){
								if(inpobs.value ==""){
									inpobs.style.borderColor = "#DF0101";
									inpobs.style.backgroundColor = "819FF7";
								}else{
									inpobs.style.borderColor = "#ccc";
									inpobs.style.backgroundColor = "#fff";
								}
							}
							msj = '<span>No ha ingresado uno o mas datos del proyecto...</span><br><br>';
							msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						if(inptipo.value ==""){
							inptipo.style.borderColor = "#DF0101";
							inptipo.style.backgroundColor = "819FF7";
						}else{
							inptipo.style.borderColor = "#ccc";
							inptipo.style.backgroundColor = "#fff";
						}
						if(inpmonto.value ==""){
							inpmonto.style.borderColor = "#DF0101";
							inpmonto.style.backgroundColor = "819FF7";
						}else{
							inpmonto.style.borderColor = "#ccc";
							inpmonto.style.backgroundColor = "#fff";
						}
						if(inpmon.value ==""){
							inpmon.style.borderColor = "#DF0101";
							inpmon.style.backgroundColor = "819FF7";
						}else{
							inpmon.style.borderColor = "#ccc";
							inpmon.style.backgroundColor = "#fff";
						}
						if(tcambiodia.value ==""){
							tcambiodia.style.borderColor = "#DF0101";
							tcambiodia.style.backgroundColor = "819FF7";
						}else{
							tcambiodia.style.borderColor = "#ccc";
							tcambiodia.style.backgroundColor = "#fff";
						}
						msj = '<span>No ha ingresado uno o mas datos del pago...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<span>El monto a pagar excede el monto total de la compra...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function PromtPagoJS(tipoP){	
				Pro = document.getElementById("proC").value;
				vtotal = document.getElementById("factotal").value;
				saldo = document.getElementById("saldo").value;
				pagtotal = document.getElementById("PagTotal").value;
				pagmonto = parseFloat(saldo) - parseFloat(pagtotal)
				moneda = document.getElementById("montext").value;
				monid = document.getElementById("moneda").value;
				if(saldo > 0){
					if(pagmonto > 0){
						//Realiza una peticion de contenido a la contenido.php
						$.post("../promts/ventas/pago2.php",{comp:Pro,montext:moneda,monc:monid,total:vtotal,monto:pagmonto,tipo:tipoP}, function(data){
						// Ponemos la respuesta de nuestro script en el DIV recargado
						$("#Pcontainer").html(data);
						});
						abrirPromt();
					}else{
						abrir();
						msj = '<span>El total del monto a pagar ya esta completo...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					abrir();
					msj = '<span>Esta Compra ya esta cancelada en su totalidad...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ConfirmPagoJS(){	
				nfilas = document.getElementById("PagFilas").value;
				saldo = document.getElementById("saldo").value;
				pagtotal = document.getElementById("PagTotal").value;
				if(nfilas > 0){
					if(parseFloat(saldo) >= parseFloat(pagtotal)){
						texto = "&iquest;Desea registrar este pago?";
						acc = "PagoJS()";
						ConfirmacionJs(texto,acc);
					}else{
						abrir();
						msj = '<span>El pago es mayor al saldo del crédito...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					abrir();
					msj = '<span>Faltan los datos del pago...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}				

			function PagoJS(){
				abrir();
				pro = document.getElementById("proC");
				suc = document.getElementById("suc");
				pv = document.getElementById("pv");
				PagFilas = document.getElementById("PagFilas");
				PagTotal = document.getElementById("PagTotal");
				//--
				if(pro.value != "" && PagFilas.value > 0 && suc.value != "" && pv.value != ""){
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
					xajax_Grabar_Pago(pro.value,suc.value,pv.value,PagFilas.value,arrptipo,arrmonto,arrmoneda,arrcambio,arrdoc,arropera,arrobs);
					
				}else{
					if(pro.value == ""){
						pro.style.borderColor = "#DF0101";
						pro.style.backgroundColor = "819FF7";
					}else{
						pro.style.borderColor = "#ccc";
						pro.style.backgroundColor = "#fff";
					}
					if(suc.value == ""){
						suc.style.borderColor = "#DF0101";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "#fff";
					}
					if(pv.value == ""){
						pv.style.borderColor = "#DF0101";
						pv.style.backgroundColor = "819FF7";
					}else{
						pv.style.borderColor = "#ccc";
						pv.style.backgroundColor = "#fff";
					}
					msj = '<span>Faltan algunos datos del pago \u00F3 hay un movimiento fuera de lugar ...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}	
				
			
			function ProyectoPagoJS(tipoP){	
				nfilas = document.getElementById("filas").value;
				if(nfilas > 0){
					Tmon = document.getElementById("Tmon");
					// manejo del texto del combo moneda
						var Vmontext = Tmon.options[Tmon.selectedIndex].text;
					//--
					Vmon = Tmon.value;
					total = document.getElementById("ttotal").value;
					pagtotal = document.getElementById("PagTotal").value;
					var Saldo =  parseFloat(total) - parseFloat(pagtotal);
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/proyecto/pago.php",{mon:Vmon,montex:Vmontext,monto:Saldo,tipo:tipoP}, function(data){
					// Ponemos la respuesta de nuestro script en el DIV recargado
					$("#Pcontainer").html(data);
					});
					abrirPromt();
				}else{
					abrir();
					msj = '<span>No hay articulos...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
						
			function ConfirmProyectoJS(){
				texto = "&iquest;Desea Registrar este Proyecto?";
				acc = "ProyectoJS()";
				ConfirmacionJs(texto,acc);
			}
			
			
			function ProyectoJS(){
				abrir();
				nfilas = document.getElementById("filas").value;
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
				total = document.getElementById("ttotal");
				Rtotal = document.getElementById("total");
				promdesc = document.getElementById("promdesc");
				//--
				if(nfilas > 0){
					if(cli.value != "" && fec.value != "" && suc.value != "" && pv.value != "" && Tmon.value != ""){
							var bandera = false;
							//proyecto--
							var arrtipo = "|";
							var arrdesc = "|";
							var arrartc = "|";
							var arrcant = "|";
							var arrprev = "|";
							var arrmon = "|";
							var arrmonc = "|";
							var arrstot = "|";
							var arrdsc = "|";
							var arrtot = "|";
							//arrays de proyecto
							var C = 1;
							for(var i = 1; i <= nfilas; i ++){
								//extrae datos del grid
								tipo = document.getElementById("tip"+i).value;
								desc = document.getElementById("desc"+i).value;
								barc = document.getElementById("barc"+i).value;
								artc = document.getElementById("artc"+i).value;
								cant = document.getElementById("cant"+i).value;
								prev = document.getElementById("prev"+i).value;
								mon = document.getElementById("mon"+i).value;
								mons = document.getElementById("mons"+i).value;
								monc = document.getElementById("monc"+i).value;
								stot = document.getElementById("stot"+i).value;
								dsc = document.getElementById("dsc"+i).value;
								rtot = document.getElementById("rtot"+i).value;
								//-- llena arrays
								arrtipo+= tipo+"|";
								arrdesc+= desc+"|";
								arrartc+= artc+"|";
								arrcant+= cant+"|";
								arrprev+= prev+"|";
								arrdsc+= dsc+"|";
								arrmon+= mon+"|";
								arrmonc+= monc+"|";
								arrstot+= stot+"|";
								arrtot+= rtot+"|";
							}
							
							xajax_Grabar_Proyecto(nfilas,cli.value,pv.value,suc.value,fec.value,vcod.value,Rtotal.value,promdesc.value,total.value,
								Tmon.value,moneda,arrcant,arrtipo,arrartc,arrdesc,arrprev,arrmon,arrmonc,arrstot,arrdsc,arrtot);
							//alert("paso");
					}else{
						if(fec.value == ""){
							fec.style.borderColor = "#DF0101";
							fec.style.backgroundColor = "819FF7";
						}else{
							fec.style.borderColor = "#ccc";
							fec.style.backgroundColor = "#fff";
						}
						if(cli.value == ""){
							cli.style.borderColor = "#DF0101";
							cli.style.backgroundColor = "819FF7";
						}else{
							cli.style.borderColor = "#ccc";
							cli.style.backgroundColor = "#fff";
						}
						if(nit.value == ""){
							nit.style.borderColor = "#DF0101";
							nit.style.backgroundColor = "819FF7";
						}else{
							nit.style.borderColor = "#ccc";
							nit.style.backgroundColor = "#fff";
						}
						if(nom.value == ""){
							nom.style.borderColor = "#DF0101";
							nom.style.backgroundColor = "819FF7";
						}else{
							nom.style.borderColor = "#ccc";
							nom.style.backgroundColor = "#fff";
						}
						if(suc.value == ""){
							suc.style.borderColor = "#DF0101";
							suc.style.backgroundColor = "819FF7";
						}else{
							suc.style.borderColor = "#ccc";
							suc.style.backgroundColor = "#fff";
						}
						if(pv.value == ""){
							pv.style.borderColor = "#DF0101";
							pv.style.backgroundColor = "819FF7";
						}else{
							pv.style.borderColor = "#ccc";
							pv.style.backgroundColor = "#fff";
						}
						if(Tmon.value == ""){
							Tmon.style.borderColor = "#DF0101";
							Tmon.style.backgroundColor = "819FF7";
						}else{
							Tmon.style.borderColor = "#ccc";
							Tmon.style.backgroundColor = "#fff";
						}
						msj = '<span>Debe llenar los datos obligatorios...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<span>No hay Art&iacute;culos o Servicios listados para Proyecto...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			function ConfirmDescargaJS(){
				texto = "Proyecto Registrado... &iquest;Desea Descargar Automaticamente a Inventario est(e)(os) Art&iacute;culo(s)?...";
				acc = "DescargaJS();";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar_Campos_Proyecto(){
					inpbarc = document.getElementById("barc");
					inpart = document.getElementById("art");
					inpartn = document.getElementById("artn");
					inpcant = document.getElementById("cant");
					inpdesc = document.getElementById("desc");
					inpmon = document.getElementById("mon");
					inpdsc = document.getElementById("dsc");
					inpprem = document.getElementById("prem");
					inpprec = document.getElementById("prec");
					inpprev = document.getElementById("prev");
					// Despinta campos
						inpbarc.style.borderColor = "#ccc";
						inpbarc.style.backgroundColor = "#fff";
						inpart.style.borderColor = "#ccc";
						inpart.style.backgroundColor = "#fff";
						inpartn.style.borderColor = "#ccc";
						inpartn.style.backgroundColor = "#fff";
						inpcant.style.borderColor = "#ccc";
						inpcant.style.backgroundColor = "#fff";
						inpdesc.style.borderColor = "#ccc";
						inpdesc.style.backgroundColor = "#fff";
						inpmon.style.borderColor = "#ccc";
						inpmon.style.backgroundColor = "#fff";
						inpdsc.style.borderColor = "#ccc";
						inpdsc.style.backgroundColor = "#fff";
						inpprem.style.borderColor = "#ccc";
						inpprem.style.backgroundColor = "#fff";
						inpprec.style.borderColor = "#ccc";
						inpprec.style.backgroundColor = "#fff";
						inpprev.style.borderColor = "#ccc";
						inpprev.style.backgroundColor = "#fff";
					// Limpia los campos para un nuevo articulo	
						inpbarc.value = "";
						inpart.value = "";
						inpartn.value = "";
						inpcant.value = "";
						inpdesc.value = "";
						inpmon.value = "";
						inpdsc.value = "0";
						inpprem.value = "";
						inpprec.value = "";
						inpprev.value = "";
						inpmon.removeAttribute('disabled');
			}
			
			function monedaText(){
				var combo = document.getElementById("mon");
				var selected = combo.options[combo.selectedIndex].text;
				alert(selected);
			}
			

	///////////////////------------------ DESCARGA --------------//////////////////////////////							
			function DescargaJS(pro){
				abrir();
				nfilas = document.getElementById("filas").value;
				suc = document.getElementById("suc");
				clase = "V";
				doc = pro;
				if(nfilas > 0){
					if(suc.value != "" && clase != "" && doc != ""){
						nfilas = document.getElementById("filas").value;
						var bandera = false;
						var arrartc = "|";
						var arrartn = "|";
						var arrcant = "|";
						var C = 1;
						for(var i = 1; i <= nfilas; i ++){
							//extrae datos del grid
							artc = document.getElementById("artc"+i).value;
							artn = document.getElementById("desc"+i).value;
							cant = document.getElementById("cant"+i).value;
							//-- llena arrays
								arrartc+= artc+"|";
								arrartn+= artn+"|";
								arrcant+= cant+"|";
						}
						xajax_Grabar_Descarga(nfilas,suc.value,clase,doc,arrartc,arrartn,arrcant);
					}else{
						if(suc.value == ""){
							suc.style.borderColor = "#DF0101";
							suc.style.backgroundColor = "819FF7";
						}else{
							suc.style.borderColor = "#ccc";
							suc.style.backgroundColor = "#fff";
						}
						msj = '<span>Debe llenar los datos obligatorios...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<span>No hay Art&iacute;culos para Descargar...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			/////////////////------------ CLIENTES  -------------------/////////////
			
			function Cliente(){
				nit = document.getElementById('nit');
				if(nit.value !=""){
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
				abrirPromt();
			}
			
			function SearchCliente(x){
				var x = 0;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/cliente/busca_cliente.php",{variable:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Bigcontainer").html(data);
				});
				abrirBigPromt();
			}
			
			function BuscarCliente(){
				abrir();
				nit = document.getElementById('cnit1');
				nom = document.getElementById("cnom1");
				
				if(nom.value !="" || nit.value != ""){
					xajax_Buscar_Cliente(nit.value,nom.value);
				}else{
					if(nom.value ==""){
						nom.style.borderColor = "#0404B4";
						nom.style.backgroundColor = "819FF7";
					}else{
						nom.style.borderColor = "#ccc";
						nom.style.backgroundColor = "E6E6E6";
					}
					if(nit.value ==""){
						nit.style.borderColor = "#0404B4";
						nit.style.backgroundColor = "819FF7";
					}else{
						nit.style.borderColor = "#ccc";
						nit.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda (Nombre del Cliente o NIT)</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
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
				document.getElementById('vcod').focus();
				cerrarBigPromt();
			}
			
			function GrabarCliente(){
				abrir();
				nit = document.getElementById('cnit1');
				nom = document.getElementById('cnom1');
				direc = document.getElementById("cdirec1");
				tel1 = document.getElementById("ctel1");
				tel2 = document.getElementById("ctel2");
				mail = document.getElementById("cmail1");
				
				if(nit.value !="" && nom.value !="" && direc.value != ""){
					xajax_Grabar_Cliente(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value);
				}else{
					if(nit.value ==""){
						nit.style.borderColor = "#DF0101";
						nit.style.backgroundColor = "F8E0E0";
					}else{
						nit.style.borderColor = "#ccc";
						nit.style.backgroundColor = "E6E6E6";
					}
					if(nom.value ==""){
						nom.style.borderColor = "#DF0101";
						nom.style.backgroundColor = "F8E0E0";
					}else{
						nom.style.borderColor = "#ccc";
						nom.style.backgroundColor = "E6E6E6";
					}
					if(direc.value ==""){
						direc.style.borderColor = "#DF0101";
						direc.style.backgroundColor = "F8E0E0";
					}else{
						direc.style.borderColor = "#ccc";
						direc.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Debe llenar los Campos Obligatorios</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			/////////////////------------ VENDEDOR  -------------------/////////////
			
			function Vendedor(){
				cod = document.getElementById('vcod');
				if(cod.value !=""){
					abrir();
					xajax_Show_Vendedor(cod.value);
				}
			}
			
			function ResetVend(){
				nom = document.getElementById('vnom');
				cod = document.getElementById('vcod');
				nom.value = "";
				cod.value = "";
			}
			
			function SearchVendedor(x){
				var x = 0;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/personal/buscar_vendedor.php",{variable:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Bigcontainer").html(data);
				});
				abrirBigPromt();
			}
			
			function BuscarVendedor(){
				abrir();
				suc = document.getElementById('suc1');
				cod = document.getElementById('Percod1');
				nom = document.getElementById("Pernom1");
				ape = document.getElementById("Perape1");
				
				if(suc.value !="" || cod.value !="" || nom.value !="" || ape.value != ""){
					xajax_Buscar_Vendedor(cod.value,suc.value,nom.value,ape.value);
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(cod.value ==""){
						cod.style.borderColor = "#0404B4";
						cod.style.backgroundColor = "819FF7";
					}else{
						cod.style.borderColor = "#ccc";
						cod.style.backgroundColor = "E6E6E6";
					}
					if(nom.value ==""){
						nom.style.borderColor = "#0404B4";
						nom.style.backgroundColor = "819FF7";
					}else{
						nom.style.borderColor = "#ccc";
						nom.style.backgroundColor = "E6E6E6";
					}
					if(ape.value ==""){
						ape.style.borderColor = "#0404B4";
						ape.style.backgroundColor = "819FF7";
					}else{
						ape.style.borderColor = "#ccc";
						ape.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function SeleccionarPersonal(fila){
				cod = document.getElementById('Pcod'+fila);
				nom = document.getElementById('Pnom'+fila);
				ape = document.getElementById('Pape'+fila);
				inpcod = document.getElementById('vcod');
				inpnom = document.getElementById('vnom');
				//---
				inpcod.value = cod.value;
				inpnom.value = nom.value + " " + ape.value;
				document.getElementById('suc').focus();
				cerrarBigPromt();
			}
			
						
		/////////////////------------ ARTICULO  -------------------/////////////
		
			function Articulo(){
				art = document.getElementById('art').value;
				barc = document.getElementById('barc').value;
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc != "")?suc:sucX;
				
				//alert(art+","+barc+","+y);
				if(art !="" || barc !=""){
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
						
			function SearchArticulo(x){
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc != "")?suc:sucX;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/articulo/busca_articulo.php",{formulario:x,empresa:y}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Bigcontainer").html(data);
				});
				abrirBigPromt();
			}
			
			function BuscarArticulo(x){
				abrir();
				gru = document.getElementById('gru1');
				marca = document.getElementById('amarca1');
				nom = document.getElementById("anom1");
				desc = document.getElementById("adesc1");
				suc = document.getElementById("suc1");
				
				if(gru.value !="" || nom.value !="" || marca.value != "" || desc.value != ""){
					xajax_Buscar_Articulo(gru.value,nom.value,desc.value,marca.value,suc.value,x);
				}else{
					if(gru.value ==""){
						gru.style.borderColor = "#0404B4";
						gru.style.backgroundColor = "819FF7";
					}else{
						gru.style.borderColor = "#ccc";
						gru.style.backgroundColor = "E6E6E6";
					}
					if(nom.value ==""){
						nom.style.borderColor = "#0404B4";
						nom.style.backgroundColor = "819FF7";
					}else{
						nom.style.borderColor = "#ccc";
						nom.style.backgroundColor = "E6E6E6";
					}
					if(marca.value ==""){
						marca.style.borderColor = "#0404B4";
						marca.style.backgroundColor = "819FF7";
					}else{
						marca.style.borderColor = "#ccc";
						marca.style.backgroundColor = "E6E6E6";
					}
					if(desc.value ==""){
						desc.style.borderColor = "#0404B4";
						desc.style.backgroundColor = "819FF7";
					}else{
						desc.style.borderColor = "#ccc";
						desc.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function SeleccionarArticulo(fila){
				//-- entregan datos
				art = document.getElementById('Tartn'+fila);
				cod = document.getElementById('Tacod'+fila);
				cant = document.getElementById('Tcant'+fila);
				mon = document.getElementById('Tmon'+fila);
				prev = document.getElementById('Tprev'+fila);
				prev.value = (prev.value == "")?0:prev.value; //valida que no regrese vacio
				prec = document.getElementById('Tprec'+fila);
				prec.value = (prec.value == "")?0:prec.value; //valida que no regrese vacio
				prem = document.getElementById('Tprem'+fila);
				prem.value = (prem.value == "")?0:prem.value; //valida que no regrese vacio
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
				document.getElementById('cant').focus();
				cerrarBigPromt();
				inpmon.setAttribute('disabled','disabled');
			}
			
	/////////////////------------ SERVICIO  -------------------/////////////
		
			function Servicio(){
				art = document.getElementById('art').value;
				barc = document.getElementById('barc').value;
				
				//alert(art+","+barc+","+y);
				if(art !="" || barc !=""){
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
				y = (suc != "")?suc:sucX;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/servicio/busca_servicio.php",{formulario:x,empresa:y}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Bigcontainer").html(data);
				});
				abrirBigPromt();
			}
			
			function BuscarServicio(x){
				abrir();
				gru = document.getElementById('gru1');
				nom = document.getElementById("anom1");
				desc = document.getElementById("adesc1");
				
				if(gru.value !="" || nom.value !="" || desc.value != ""){
					xajax_Buscar_Servicio(gru.value,nom.value,desc.value);
				}else{
					if(gru.value ==""){
						gru.style.borderColor = "#0404B4";
						gru.style.backgroundColor = "819FF7";
					}else{
						gru.style.borderColor = "#ccc";
						gru.style.backgroundColor = "E6E6E6";
					}
					if(nom.value ==""){
						nom.style.borderColor = "#0404B4";
						nom.style.backgroundColor = "819FF7";
					}else{
						nom.style.borderColor = "#ccc";
						nom.style.backgroundColor = "E6E6E6";
					}
					if(desc.value ==""){
						desc.style.borderColor = "#0404B4";
						desc.style.backgroundColor = "819FF7";
					}else{
						desc.style.borderColor = "#ccc";
						desc.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function SeleccionarServicio(fila){
				//-- entregan datos
				art = document.getElementById('Tartn'+fila);
				cod = document.getElementById('Tacod'+fila);
				cant = document.getElementById('Tcant'+fila);
				mon = document.getElementById('Tmon'+fila);
				prev = document.getElementById('Tprev'+fila);
				prev.value = (prev.value == "")?0:prev.value; //valida que no regrese vacio
				prec = document.getElementById('Tprec'+fila);
				prec.value = (prec.value == "")?0:prec.value; //valida que no regrese vacio
				prem = document.getElementById('Tprem'+fila);
				prem.value = (prem.value == "")?0:prem.value; //valida que no regrese vacio
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
				document.getElementById('cant').focus();
				cerrarBigPromt();
				inpmon.setAttribute('disabled','disabled');
			}
			
	////////------- Historial de Proyectos -------/////////////
	
			function BuscarHist(){
				abrir();
				suc = document.getElementById('suc');
				pv = document.getElementById('pv');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				sit = document.getElementById("sit");
				
				if(suc.value !="" || pv.value !="" || fini.value != "" || ffin.value != ""){
					xajax_Buscar_Historial(suc.value,pv.value,fini.value,ffin.value,sit.value);
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(pv.value ==""){
						pv.style.borderColor = "#0404B4";
						pv.style.backgroundColor = "819FF7";
					}else{
						pv.style.borderColor = "#ccc";
						pv.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReporteHist(){
				suc = document.getElementById('suc');
				pv = document.getElementById('pv');
				ser = document.getElementById("ser");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				sit = document.getElementById("sit");
				nit = document.getElementById("nit");
				
				if(suc.value !="" || pv.value !="" || fini.value != "" || ffin.value != "" || nit.value != ""){
					myform = document.forms.f1;
					myform.action ="REPhistproyecto.php";
					myform.submit();
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(pv.value ==""){
						pv.style.borderColor = "#0404B4";
						pv.style.backgroundColor = "819FF7";
					}else{
						pv.style.borderColor = "#ccc";
						pv.style.backgroundColor = "E6E6E6";
					}
					if(grupo.value ==""){
						grupo.style.borderColor = "#0404B4";
						grupo.style.backgroundColor = "819FF7";
					}else{
						grupo.style.borderColor = "#ccc";
						grupo.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					if(nit.value ==""){
						nit.style.borderColor = "#0404B4";
						nit.style.backgroundColor = "819FF7";
					}else{
						nit.style.borderColor = "#ccc";
						nit.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReportePagos(){
				pro = document.getElementById("pro");
				
				if(pro.value != ""){
					myform = document.forms.f1;
					myform.action ="REPpagos.php";
					myform.submit();
				}else{
					if(pro.value ==""){
						pro.style.borderColor = "#0404B4";
						pro.style.backgroundColor = "819FF7";
					}else{
						pro.style.borderColor = "#ccc";
						pro.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReporteCredit(){
				suc = document.getElementById('suc');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(suc.value !="" || fini.value != "" || ffin.value != ""){
					myform = document.forms.f1;
					myform.action ="REPcreditos.php";
					myform.submit();
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReporteBouCheq(){
				suc = document.getElementById('suc');
				tipo = document.getElementById('tipo');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(suc.value !="" || tipo.value !="" || fini.value != "" || ffin.value != ""){
					myform = document.forms.f1;
					myform.action ="REPboucheq.php";
					myform.submit();
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(tipo.value ==""){
						tipo.style.borderColor = "#0404B4";
						tipo.style.backgroundColor = "819FF7";
					}else{
						tipo.style.borderColor = "#ccc";
						tipo.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReporteAnula(){
				nit = document.getElementById('nit');
				suc = document.getElementById('suc');
				pv = document.getElementById('pv');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(nit.value !="" || suc.value !="" || pv.value !="" || fini.value != "" || ffin.value != ""){
					myform = document.forms.f1;
					myform.action ="REPanula.php";
					myform.submit();
				}else{
					if(nit.value ==""){
						nit.style.borderColor = "#0404B4";
						nit.style.backgroundColor = "819FF7";
					}else{
						nit.style.borderColor = "#ccc";
						nit.style.backgroundColor = "E6E6E6";
					}
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(pv.value ==""){
						pv.style.borderColor = "#0404B4";
						pv.style.backgroundColor = "819FF7";
					}else{
						pv.style.borderColor = "#ccc";
						pv.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
	
	////////------- Cuentas por Cobrar -------/////////////
	
			function BuscarDeuda(){
				abrir();
				suc = document.getElementById('suc');
				tipo = document.getElementById('tipo');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(suc.value !="" || tipo.value !="" || fini.value != "" || ffin.value != ""){
					xajax_Buscar_Deudas(suc.value,tipo.value,fini.value,ffin.value);
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(tipo.value ==""){
						tipo.style.borderColor = "#0404B4";
						tipo.style.backgroundColor = "819FF7";
					}else{
						tipo.style.borderColor = "#ccc";
						tipo.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function TipoCobro(x){
				lb1 = document.getElementById('lbl1');
				lb2 = document.getElementById('lbl2');
				lb3 = document.getElementById('lbl3');
				lb4 = document.getElementById('lbl4');
				cnt1 = document.getElementById('cnt1');
				cnt2 = document.getElementById('cnt2');
				cnt3 = document.getElementById('cnt3');
				cnt4 = document.getElementById('cnt4');
				//--
				if(x == "1"){
					lb1.style.visibility = "visible";
					lb2.style.visibility = "visible";
					lb3.style.visibility = "hidden";
					lb4.style.visibility = "hidden";
					cnt1.style.visibility = "visible";
					cnt2.style.visibility = "visible";
					cnt3.style.visibility = "hidden";
					cnt4.style.visibility = "hidden";
				}else if(x == "2"){
					lb1.style.visibility = "hidden";
					lb2.style.visibility = "hidden";
					lb3.style.visibility = "visible";
					lb4.style.visibility = "visible";
					cnt1.style.visibility = "hidden";
					cnt2.style.visibility = "hidden";
					cnt3.style.visibility = "visible";
					cnt4.style.visibility = "visible";
				}
			}
			
			function descuento_x_cargos(){
				var total = 0;
				monto = document.getElementById("montp1").value;
				cargo = document.getElementById("cargo1").value;
				tot = document.getElementById("total1");
				cargo = (cargo == "")?0:cargo;
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
						if (chk == 1) {
							//alert(tipoC+","+i);
							tipo = document.getElementById("tipo"+i).value;
							monto = document.getElementById("monto"+i).value;
							total = parseFloat(total) + parseFloat(monto);
							if (Checks == 0) {
								bandera++;
							}else if (tipo == tipoC) {
								bandera++;
							}
							tipoC = tipo;
							Checks++;
						}
					}
					if(Checks > 0){
						//alert(bandera+","+Checks);
						if(bandera == Checks){
							//Realiza una peticion de contenido a la contenido.php
							$.post("../promts/proyecto/ejecutar.php",{Total:total,Tipo:tipoC,Filas:filas}, function(data){
							// Ponemos la respuesta de nuestro script en el DIV recargado
							$("#Pcontainer").html(data);
							});
							abrirPromt();
						}else{
							abrir();
							msj = '<span>Una o mas cuentas no son del mismo tipo...</span><br><br>';
							msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						abrir();
						msj = '<span>No ha seleccionado ninguna cuenta...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					abrir();
					msj = '<span>No hay cuenta para ejecutar...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function Ejecutar_Cheque_Tarjeta(cod,pro){
				abrir();
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
					if((tipo.value == 1 && cue.value != "" && ban.value != "") || (tipo.value == 2 && caja.value != "" && suc.value != "") && monto.value != "" && doc.value != ""){
							//Inicializacion de arrays--
							var arrccue = "|";
							var arrpro = "|";
							//llenado de arrays
							var C = 1;
							for(var i = 1; i <= nfilas; i ++){
								chk = (document.getElementById("chk"+i).checked)?1:0;
								if (chk == 1) {
									//extrae datos del grid
									ccue = document.getElementById("ccue"+cont).value;
									pro = document.getElementById("pro"+cont).value;
									//-- llena arrays
									arrccue+= ccue+"|";
									arrpro+= pro+"|";
									cont++;
								}
							}
							cont--;
							xajax_Ejecutar_Cheque_Tarjeta(cue.value,ban.value,suc.value,caja.value,tipo.value,monto.value,doc.value,cont,arrccue,arrpro);
							//alert("paso");
					}else{
						if(cue.value == ""){
							cue.style.borderColor = "#DF0101";
							cue.style.backgroundColor = "819FF7";
						}else{
							cue.style.borderColor = "#ccc";
							cue.style.backgroundColor = "#fff";
						}
						if(ban.value == ""){
							ban.style.borderColor = "#DF0101";
							ban.style.backgroundColor = "819FF7";
						}else{
							ban.style.borderColor = "#ccc";
							ban.style.backgroundColor = "#fff";
						}
						if(suc.value == ""){
							suc.style.borderColor = "#DF0101";
							suc.style.backgroundColor = "819FF7";
						}else{
							suc.style.borderColor = "#ccc";
							suc.style.backgroundColor = "#fff";
						}
						if(caja.value == ""){
							caja.style.borderColor = "#DF0101";
							caja.style.backgroundColor = "819FF7";
						}else{
							caja.style.borderColor = "#ccc";
							caja.style.backgroundColor = "#fff";
						}
						if(doc.value == ""){
							doc.style.borderColor = "#DF0101";
							doc.style.backgroundColor = "819FF7";
						}else{
							doc.style.borderColor = "#ccc";
							doc.style.backgroundColor = "#fff";
						}
						if(monto.value == ""){
							monto.style.borderColor = "#DF0101";
							monto.style.backgroundColor = "819FF7";
						}else{
							monto.style.borderColor = "#ccc";
							monto.style.backgroundColor = "#fff";
						}
						msj = '<span>Debe llenar los datos obligatorios...</span><br><br>';
						msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<span>No hay Cuentas por Ejecutar Seleccionadas...</span><br><br>';
					msj+= '<input type = "button" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
		////////------- Anulacion de Proyectos -------/////////////
	
			function BuscarAnula(){
				abrir();
				suc = document.getElementById('suc');
				pv = document.getElementById('pv');
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(suc.value !="" || pv.value !="" || fini.value != "" || ffin.value != ""){
					xajax_Buscar_Anulacion(suc.value,pv.value,fini.value,ffin.value);
				}else{
					if(suc.value ==""){
						suc.style.borderColor = "#0404B4";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.style.borderColor = "#ccc";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(pv.value ==""){
						pv.style.borderColor = "#0404B4";
						pv.style.backgroundColor = "819FF7";
					}else{
						pv.style.borderColor = "#ccc";
						pv.style.backgroundColor = "E6E6E6";
					}
					if(ser.value ==""){
						ser.style.borderColor = "#0404B4";
						ser.style.backgroundColor = "819FF7";
					}else{
						ser.style.borderColor = "#ccc";
						ser.style.backgroundColor = "E6E6E6";
					}
					if(facc.value ==""){
						facc.style.borderColor = "#0404B4";
						facc.style.backgroundColor = "819FF7";
					}else{
						facc.style.borderColor = "#ccc";
						facc.style.backgroundColor = "E6E6E6";
					}
					if(fini.value ==""){
						fini.style.borderColor = "#0404B4";
						fini.style.backgroundColor = "819FF7";
					}else{
						fini.style.borderColor = "#ccc";
						fini.style.backgroundColor = "E6E6E6";
					}
					if(ffin.value ==""){
						ffin.style.borderColor = "#0404B4";
						ffin.style.backgroundColor = "819FF7";
					}else{
						ffin.style.borderColor = "#ccc";
						ffin.style.backgroundColor = "E6E6E6";
					}
					msj = '<span>Determinar almenos un criterio de busqueda...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ConfirmAnular(pro,ini,fin){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/proyecto/cambia_sit.php",{cod:pro,fini:ini,ffin:fin}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirPromt();
			}
			
			
			function CambiarSituacion(){
				just = document.getElementById('just1');
				pro = document.getElementById('pro1').value;
				fini = document.getElementById('fini1').value;
				ffin = document.getElementById("ffin1").value;
				abrir();
				if(just.value != ""){
					cerrarPromt();
					xajax_Cambiar_Situacion(pro,fini,ffin);
				}else{
					just.style.borderColor = "#DF0101";
					just.style.backgroundColor = "819FF7";
					msj = '<span>Debe llenar los Campos Obligatorios...</span><br><br>';
					msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick = "cerrar();" />';
					document.getElementById('lblparrafo').innerHTML = msj;
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
		rtotal = document.getElementById("Rtotal"); //--
		ttotal = document.getElementById("ttotal"); //--
		spanpromdesc = document.getElementById("spanpromdesc"); //recibe span de promedio de toda la venta 
		spannota = document.getElementById("spannota"); //recibe span de nota
		
		spandscgeneral = document.getElementById("spandscgeneral"); //recibe span de iva de toda la venta 
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
			tdsc = document.getElementById("tdsc"+i); //--
			dsc = document.getElementById("dsc"+i); //--
			///---- descuentos----///
			var descuento = 0;
			if(tdsc.value == "P"){
				descuento = (parseFloat(rtot.value) * (parseFloat(dsc.value)/100));
			}else if(tdsc.value == "M"){
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
			var STOTAL = parseFloat(sumTotal);
			STOTAL = STOTAL * 100;//-- inicia proceso de redondeo
			STOTAL = Math.round(STOTAL); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
			STOTAL = STOTAL/100;//-- finaliza proceso de redondeo
			spanstotal.innerHTML = Vmons+" "+STOTAL;
			stotal.value = STOTAL;
			//-- DESCUENTO GENERAL
			var descuento = 0;
			if(tfdsc.value == "P"){
				descuento = (parseFloat(sumTotal) * (parseFloat(fdsc.value)/100));
			}else if(tfdsc.value == "M"){
			        descuento = parseFloat(fdsc.value);
			}
			descuento = descuento * 100;//-- inicia proceso de redondeo
			descuento = Math.round(descuento); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
			descuento = descuento/100;//-- finaliza proceso de redondeo
			spandscgeneral.innerHTML = Vmons+" "+descuento;
			//--TOTAL
			var TTOTAL = (parseFloat(sumTotal) - parseFloat(descuento));
			TTOTAL = TTOTAL * 100;//-- inicia proceso de redondeo
			TTOTAL = Math.round(TTOTAL); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
			TTOTAL = TTOTAL/100;//-- finaliza proceso de redondeo
			spanttotal.innerHTML = Vmons+" "+TTOTAL;
			ttotal.value = TTOTAL;
			//--
			DescU = DescU * 100;//-- inicia proceso de redondeo
			DescU = Math.round(DescU); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
			DescU = DescU/100;//-- finaliza proceso de redondeo
			promdesc.value = DescU;
			spanpromdesc.innerHTML = DescU+" %";
			//--
			spannota.innerHTML = "<b>NOTA:</b> MONEDA PARA COTIZACI&Oacute;N: <b>"+Vmond+"</b>. TIPO DE CAMBIO "+Vmonc+" x 1";
	}
	
	
			