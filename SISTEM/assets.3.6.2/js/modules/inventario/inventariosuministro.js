//funciones javascript y validaciones
			
			function Set_Empresa(valor){
				suc = document.getElementById('suc');
				suc.value = valor;
			}
			
			function Cancelar(){
				texto = "Desea Cancelar esta transacci\u00F3n?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Limpiar(){
				texto = "Desea Cancelar esta transacci\u00F3n?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function print_vale(val,suc,emp){
				window.open("PRTvale.php?val="+val+"&suc="+suc+"&emp="+emp);
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
			
			function msjAlert(texto,pagina){
				msj = '<h5>'+texto+'</h5><br><br>';
				msj+= '<button type="button" class="btn btn-primary" onclick = "window.location=\''+pagina+'\'" ><span class="fa fa-check"></span> Aceptar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
			
			function cerrarProgress(){
				document.getElementById('progress').innerHTML = "";
			}
	///////////////////------------------ CARGA --------------//////////////////////////////							
			function NewFilaCarga(){
				nfilas = document.getElementById("filas").value;
				abrir();
				var bandera = false;
				var arrbarc = "|";
				var arrartc = "|";
				var arrartn = "|";
				var arrcant = "|";
				var arrproc = "|";
				var arrpronom = "|";
				var arrpronit = "|";
				var arrprem = "|";
				var arrprec = "|";
				var arrprev = "|";
				// trae los input de ingreso de datos
					inpbarc = document.getElementById("barc");
					inpart = document.getElementById("art");
					inpartn = document.getElementById("artn");
					inpcant = document.getElementById("cant");
					inpproc = document.getElementById("prov");
					inppronom = document.getElementById("nom");
					inppronit = document.getElementById("nit");
					inpprem = document.getElementById("prem");
					inpprec = document.getElementById("prec");
					inpprev = document.getElementById("prev");
					//--
					//inpart.value = Codigo_Art_JS(inpart.value); // agrega ceros con javascript para igualar al que viene de php
					//--
				if(inpart.value !== "" && inpcant.value !== "" && inpproc.value !== "" && inppronom.value !== "" &&
					inppronit.value !== "" && inpprem.value !== "" && inpprec.value !== "" && inpprev.value !== ""){
					//--------------
					var codigo = inpart.value;
					
					for(var i = 1; i <= nfilas; i ++){ //inicia ciclo de revision si ya esta listado
						articulo = document.getElementById("artc"+i).value;
						//alert(codigo +","+ articulo);
						if(codigo === articulo){ //si ya esta listado
							ncant = document.getElementById("cant"+i); //recibe input hidden de fila 
							spancant = document.getElementById("spancant"+i); //recibe span de cant en la fila 
							total = parseInt(ncant.value) + parseInt(inpcant.value); //suma las cantidades
							ncant.value = total;
							spancant.innerHTML = total;
							Limpiar_Campos_Carga();
							cerrar();
							return;
						}
					}
					//---------				
					for(var i = 1; i <= nfilas; i ++){
						//extrae datos del grid
						barc = document.getElementById("barc"+i).value;
						artc = document.getElementById("artc"+i).value;
						artn = document.getElementById("artn"+i).value;
						cant = document.getElementById("cant"+i).value;
						proc = document.getElementById("proc"+i).value;
						pronom = document.getElementById("pronom"+i).value;
						pronit = document.getElementById("pronit"+i).value;
						prem = document.getElementById("prem"+i).value;
						prec = document.getElementById("prec"+i).value;
						prev = document.getElementById("prev"+i).value;
						//-- crea string a convertir en arrays
						arrbarc+= barc+"|";
						arrartc+= artc+"|";
						arrartn+= artn+"|";
						arrcant+= cant+"|";
						arrproc+= proc+"|";
						arrpronom+= pronom+"|";
						arrpronit+= pronit+"|";
						arrprem+= prem+"|";
						arrprec+= prec+"|";
						arrprev+= prev+"|";
					}
					nfilas++;
					//trae los datos del formulario de ingreso
						xbarc = inpbarc.value;
						xart = inpart.value;
						xartn = inpartn.value;
						xcant = inpcant.value;
						xproc = inpproc.value;
						xpronom = inppronom.value;
						xpronit = inppronit.value;
						xprem = inpprem.value;
						xprec = inpprec.value;
						xprev = inpprev.value;
					//-- llena el array con los datos en el grid
						arrbarc+= xbarc;
						arrartc+= xart;
						arrartn+= xartn;
						arrcant+= xcant;
						arrproc+= xproc;
						arrpronom+= xpronom;
						arrpronit+= xpronit;
						arrprem+= xprem;
						arrprec+= xprec;
						arrprev+= xprev;
					// ejecuta la funcion de ajax para refrescar el grid
					xajax_Grid_Fila_Carga(nfilas,arrbarc,arrartc,arrartn,arrcant,arrproc,arrpronom,arrpronit,arrprem,arrprec,arrprev);
					Limpiar_Campos_Carga();
				}else{
					if(inpart.value ===""){
						document.getElementById("cntart").className = "text-danger";
					}else{
						document.getElementById("cntart").className = "";
					}
					if(inpcant.value ===""){
						inpcant.className = " form-danger";
					}else{
						inpcant.className = " form-control";
					}
					if(inppronom.value ===""){
						inppronom.className = " form-danger";
					}else{
						inppronom.className = " form-control";
					}
					if(inppronit.value ===""){
						inppronit.className = " form-danger";
					}else{
						inppronit.className = " form-control";
					}
					if(inpprem.value ===""){
						inpprem.className = " form-danger";
					}else{
						inpprem.className = " form-control";
					}
					if(inpprec.value ===""){
						inpprec.className = " form-danger";
					}else{
						inpprec.className = " form-control";
					}
					if(inpprev.value ===""){
						inpprev.className = " form-danger";
					}else{
						inpprev.className = " form-control";
					}
					msj = '<h5>No ha ingresado uno o mas datos de la carga...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function QuitarFilaCarga(x){
				nfilas = document.getElementById("filas").value;
				if(nfilas > 1){
					nfilas = document.getElementById("filas").value;
					abrir();
					var bandera = false;
					var arrbarc = "|";
					var arrartc = "|";
					var arrartn = "|";
					var arrcant = "|";
					var arrproc = "|";
					var arrpronom = "|";
					var arrpronit = "|";
					var arrprem = "|";
					var arrprec = "|";
					var arrprev = "|";
					var C = 1;
					for(var i = 1; i <= nfilas; i ++){
						//extrae datos del grid
						barc = document.getElementById("barc"+i).value;
						artc = document.getElementById("artc"+i).value;
						artn = document.getElementById("artn"+i).value;
						cant = document.getElementById("cant"+i).value;
						proc = document.getElementById("proc"+i).value;
						pronom = document.getElementById("pronom"+i).value;
						pronit = document.getElementById("pronit"+i).value;
						prem = document.getElementById("prem"+i).value;
						prec = document.getElementById("prec"+i).value;
						prev = document.getElementById("prev"+i).value;
						//-- llena arrays
						if(i !== x){
							arrbarc+= barc+"|";
							arrartc+= artc+"|";
							arrartn+= artn+"|";
							arrcant+= cant+"|";
							arrproc+= proc+"|";
							arrpronom+= pronom+"|";
							arrpronit+= pronit+"|";
							arrprem+= prem+"|";
							arrprec+= prec+"|";
							arrprev+= prev+"|";
						}
					}
					nfilas--;
					xajax_Grid_Fila_Carga(nfilas,arrbarc,arrartc,arrartn,arrcant,arrproc,arrpronom,arrpronit,arrprem,arrprec,arrprev);
				}
			}
						
			function Show_Fila_Carga(x){
				//extrae datos del grid
					vartc = document.getElementById("artc"+x).value;
					vartn = document.getElementById("artn"+x).value;
					vcant = document.getElementById("cant"+x).value;
					vpronom = document.getElementById("pronom"+x).value;
					vpronit = document.getElementById("pronit"+x).value;
					vprem = document.getElementById("prem"+x).value;
					vprec = document.getElementById("prec"+x).value;
					vprev = document.getElementById("prev"+x).value;
					//alert(vprev);
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventariosuministro/carga_info.php",{artc:vartc,artn:vartn,cant:vcant,pronom:vpronom,pronit:vpronit,prem:vprem,prec:vprec,prev:vprev,fila:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function ConfirmCargaJS(){
				texto = "Esta seguro de Cargar a Inventario est(e)(os) Articulo(s)?...";
				acc = "CargaJS();";
				ConfirmacionJs(texto,acc);
			}
						
			function CargaJS(){
				abrir();
				nfilas = document.getElementById("filas").value;
				fec = document.getElementById("fec");
				suc = document.getElementById("suc");
				clase = document.getElementById("clase");
				doc = document.getElementById("doc");
				if(nfilas > 0){
					if(fec.value !== "" && suc.value !== "" && clase.value !== "" && doc.value !== ""){
						nfilas = document.getElementById("filas").value;
						var bandera = false;
						var arrbarc = "|";
						var arrartc = "|";
						var arrartn = "|";
						var arrcant = "|";
						var arrproc = "|";
						var arrpronom = "|";
						var arrpronit = "|";
						var arrprem = "|";
						var arrprec = "|";
						var arrprev = "|";
						var C = 1;
						for(var i = 1; i <= nfilas; i ++){
							//extrae datos del grid
							barc = document.getElementById("barc"+i).value;
							artc = document.getElementById("artc"+i).value;
							artn = document.getElementById("artn"+i).value;
							cant = document.getElementById("cant"+i).value;
							proc = document.getElementById("proc"+i).value;
							pronom = document.getElementById("pronom"+i).value;
							pronit = document.getElementById("pronit"+i).value;
							prem = document.getElementById("prem"+i).value;
							prec = document.getElementById("prec"+i).value;
							prev = document.getElementById("prev"+i).value;
							//-- llena arrays
								arrbarc+= barc+"|";
								arrartc+= artc+"|";
								arrartn+= artn+"|";
								arrcant+= cant+"|";
								arrproc+= proc+"|";
								arrpronom+= pronom+"|";
								arrpronit+= pronit+"|";
								arrprem+= prem+"|";
								arrprec+= prec+"|";
								arrprev+= prev+"|";
						}
						//alert(nfilas+","+suc.value+","+clase.value+","+doc.value+","+arrbarc+","+arrartc+","+arrartn+","+arrcant+","+arrproc+","+arrpronom+","+arrpronit+","+arrprem+","+arrprec+","+arrprev);
						xajax_Grabar_Carga(nfilas,fec.value,suc.value,clase.value,doc.value,arrartc,arrartn,arrcant,arrproc,arrpronom,arrpronit,arrprem,arrprec,arrprev);
					}else{
						if(fec.value === ""){
							fec.className = " form-danger";
						}else{
							fec.className = " form-control";
						}
						if(suc.value === ""){
							suc.className = " form-danger";
						}else{
							suc.className = " form-control";
						}
						if(clase.value === ""){
							clase.className = " form-danger";
						}else{
							clase.className = " form-control";
						}
						if(doc.value === ""){
							doc.className = " form-danger";
						}else{
							doc.className = " form-control";
						}
						msj = '<h5>Debe llenar los datos obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<h5>No hay art&iacute;culos para Cargar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			function ConfirmCargaCompraJS(){
				texto = "Esta seguro de Cargar a Inventario est(e)(os) Articulo(s)?...";
				acc = "CargaCompraJS();";
				ConfirmacionJs(texto,acc);
			}
						
			function CargaCompraJS(){
				abrir();
				nfilas = document.getElementById("filas").value;
				suc = document.getElementById("suc");
				clase = document.getElementById("clase");
				doc = document.getElementById("compC");
				fec = document.getElementById("fec");
				if(nfilas > 0){
					if(suc.value !== "" && clase.value !== "" && doc.value !== ""){
						nfilas = document.getElementById("filas").value;
						var bandera = false;
						var arrbarc = "|";
						var arrartc = "|";
						var arrartn = "|";
						var arrcant = "|";
						var arrproc = "|";
						var arrpronom = "|";
						var arrpronit = "|";
						var arrprem = "|";
						var arrprec = "|";
						var arrprev = "|";
						var C = 1;
						for(var i = 1; i <= nfilas; i ++){
							//extrae datos del grid
							barc = document.getElementById("barc"+i).value;
							artc = document.getElementById("artc"+i).value;
							artn = document.getElementById("artn"+i).value;
							cant = document.getElementById("cant"+i).value;
							proc = document.getElementById("proc"+i).value;
							pronom = document.getElementById("pronom"+i).value;
							pronit = document.getElementById("pronit"+i).value;
							prem = document.getElementById("prem"+i).value;
							prec = document.getElementById("prec"+i).value;
							prev = document.getElementById("prev"+i).value;
							//-- llena arrays
								arrbarc+= barc+"|";
								arrartc+= artc+"|";
								arrartn+= artn+"|";
								arrcant+= cant+"|";
								arrproc+= proc+"|";
								arrpronom+= pronom+"|";
								arrpronit+= pronit+"|";
								arrprem+= prem+"|";
								arrprec+= prec+"|";
								arrprev+= prev+"|";
						}
						//alert(nfilas+","+suc.value+","+clase.value+","+doc.value+","+arrbarc+","+arrartc+","+arrartn+","+arrcant+","+arrproc+","+arrpronom+","+arrpronit+","+arrprem+","+arrprec+","+arrprev);
						xajax_Grabar_Carga_Compra(nfilas,fec.value,suc.value,clase.value,doc.value,arrartc,arrartn,arrcant,arrproc,arrpronom,arrpronit,arrprem,arrprec,arrprev);
					}else{
						if(suc.value === ""){
							suc.className = " form-danger";
						}else{
							suc.className = " form-control";
						}
						if(clase.value === ""){
							clase.className = " form-danger";
						}else{
							clase.className = " form-control";
						}
						if(doc.value === ""){
							doc.className = " form-danger";
						}else{
							doc.className = " form-control";
						}
						msj = '<h5>Debe llenar los datos obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<h5>No hay art&iacute;culos para Cargar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}			
			
			function Limpiar_Campos_Carga(){
					inpbarc = document.getElementById("barc");
					inpart = document.getElementById("art");
					inpcant = document.getElementById("cant");
					inpproc = document.getElementById("prov");
					inppronom = document.getElementById("nom");
					inppronit = document.getElementById("nit");
					inpprem = document.getElementById("prem");
					inpprec = document.getElementById("prec");
					inpprev = document.getElementById("prev");
					inpcantlimit = document.getElementById("cantlimit");
					// Despinta campos
						inpbarc.className = " form-control";
						document.getElementById("cntart").className = "";
						inpcant.className = " form-control";
						inppronom.className = " form-control";
						inppronit.className = " form-control";
						inpprem.className = " form-control";
						inpprec.className = " form-control";
						inpprev.className = " form-control";
						inpcantlimit.className = " form-control";
					// Limpia los campos para un nuevo articulo	
						inpbarc.value = "";
						inpart.value = "";
						inpartn.value = "";
						inpcant.value = "";
						inpprem.value = "";
						inpprec.value = "";
						inpprev.value = "";
						inpcantlimit.value = "";
					//--
					$(".select2").select2();
			}
			

	///////////////////------------------ DESCARGA --------------//////////////////////////////							
			function NewFilaDescarga(){
				nfilas = document.getElementById("filas").value;
				abrir();
				var bandera = false;
				var arrbarc = "|";
				var arrartc = "|";
				var arrartn = "|";
				var arrcant = "|";
				// trae los input de ingreso de datos
					inpbarc = document.getElementById("barc");
					inpart = document.getElementById("art");
					inpartn = document.getElementById("artn");
					inpcant = document.getElementById("cant");
					inpclimit = document.getElementById("cantlimit");
					inpclimit.value = (inpclimit.value !== "")?inpclimit.value:0;
					//--
					//inpart.value = Codigo_Art_JS(inpart.value); // agrega ceros con javascript para igualar al que viene de php
					//--
				if(inpart.value !== "" && inpartn.value !== "" && inpcant.value !== ""){
					if(parseInt(inpclimit.value)  >= parseInt(inpcant.value)){
						var iguales = false; //valida si ya existe ese lote en la lista
						var codigo = inpart.value;
						//------------
						for(var i = 1; i <= nfilas; i ++){ //revisa si ya esta listado
							artc = document.getElementById("artc"+i).value;
							//alert(codigo +","+ artc);
							if(codigo === artc){ //si ya esta listado
								ncant = document.getElementById("cant"+i); //recibe input hidden de fila 
								spancant = document.getElementById("spancant"+i); //recibe span de cant en la fila 
								total = parseInt(ncant.value) + parseInt(inpcant.value); //suma las cantidades
								if(parseInt(inpclimit.value)  >= parseInt(total)){ //si hay suficiente existencia con todo sumado
									ncant.value = total;
									spancant.innerHTML = total;
									iguales = true;
									//i = nfilas;
									Limpiar_Campos_Carga();
									cerrar();
									return;
								}else{ //si no hay suficiente existencia con todo sumado
									iguales = true;
									inpcant.className = " form-danger";
									msj = '<h5>No hay existencia suficiente de ese lote de articulos. Existencia : '+inpclimit.value+'. Usted desea '+total+'...</h5><br><br>';
									msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
									document.getElementById('lblparrafo').innerHTML = msj;
									return; //sale de la funcion
								}
							}else{
								iguales = false;
							}
						}
						if(iguales === false){ //verifica que realmente no sea un articulo ya listado
							for(var i = 1; i <= nfilas; i ++){
								//extrae datos del grid
								artc = document.getElementById("artc"+i).value;
								artn = document.getElementById("artn"+i).value;
								cant = document.getElementById("cant"+i).value;
								barc = document.getElementById("barc"+i).value;
								//-- crea string a convertir en arrays
								arrartc+= artc+"|";
								arrartn+= artn+"|";
								arrcant+= cant+"|";
								arrbarc+= barc+"|";
							}
							nfilas++;
							//trae los datos del formulario de ingreso
								xart = inpart.value;
								xartn = inpartn.value;
								xcant = inpcant.value;
								xbarc = inpbarc.value;
							//-- llena el array con los datos en el grid
								arrartc+= xart;
								arrartn+= xartn;
								arrcant+= xcant;
								arrbarc+= xbarc;
							// ejecuta la funcion de ajax para refrescar el grid
							xajax_Grid_Fila_Descarga(nfilas,arrbarc,arrartc,arrartn,arrcant);
							Limpiar_Campos_Carga();
						}
					}else{
						inpcant.className = " form-danger";
						msj = '<h5>No hay existencia suficiente de ese lote de articulos. Existencia : '+inpclimit.value+'. Usted desea '+inpcant.value+'...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if(inpart.value ===""){
						document.getElementById("cntart").className = "text-danger";
					}else{
						document.getElementById("cntart").className = "";
					}
					if(inpartn.value ===""){
						inpartn.className = " form-danger";
					}else{
						inpartn.className = " form-control";
					}
					if(inpcant.value ===""){
						inpcant.className = " form-danger";
					}else{
						inpcant.className = " form-control";
					}
					if(inpbarc.value ===""){
						inpbarc.className = " form-danger";
					}else{
						inpbarc.className = " form-control";
					}
					msj = '<h5>No ha ingresado uno o mas datos de la descarga...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function QuitarFilaDescarga(x){
				nfilas = document.getElementById("filas").value;
				if(nfilas > 1){
					nfilas = document.getElementById("filas").value;
					abrir();
					var arrartc = "|";
					var arrartn = "|";
					var arrcant = "|";
					var arrbarc = "|";
					var C = 1;
					for(var i = 1; i <= nfilas; i ++){
						//extrae datos del grid
						artc = document.getElementById("artc"+i).value;
						artn = document.getElementById("artn"+i).value;
						cant = document.getElementById("cant"+i).value;
						barc = document.getElementById("barc"+i).value;
						//-- llena arrays
						if(i !== x){
							arrartc+= artc+"|";
							arrartn+= artn+"|";
							arrcant+= cant+"|";
							arrbarc+= barc+"|";
						}
					}
					nfilas--;
					xajax_Grid_Fila_Descarga(nfilas,arrbarc,arrartc,arrartn,arrcant);
				}
			}
						
			function Show_Fila_Descarga(x){
				//extrae datos del grid
					vartc = document.getElementById("artc"+x).value;
					vartn = document.getElementById("artn"+x).value;
					vcant = document.getElementById("cant"+x).value;
					vlot = "LOTE EXISTENTE"; 
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventariosuministro/descarga_info.php",{artc:vartc,artn:vartn,cant:vcant,lot:vlot,fila:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function ConfirmDescargaJS(){
				texto = "Esta seguro de Descargar a Inventario est(e)(os) Articulo(s)?...";
				acc = "DescargaJS();";
				ConfirmacionJs(texto,acc);
			}
						
			function DescargaJS(){
				abrir();
				nfilas = document.getElementById("filas").value;
				fec = document.getElementById("fec");
				suc = document.getElementById("suc");
				clase = document.getElementById("clase");
				doc = document.getElementById("doc");
				if(nfilas > 0){
					if(fec.value !== "" && suc.value !== "" && clase.value !== "" && doc.value !== ""){
						nfilas = document.getElementById("filas").value;
						var bandera = false;
						var arrartc = "|";
						var arrartn = "|";
						var arrcant = "|";
						var C = 1;
						for(var i = 1; i <= nfilas; i ++){
							//extrae datos del grid
							artc = document.getElementById("artc"+i).value;
							artn = document.getElementById("artn"+i).value;
							cant = document.getElementById("cant"+i).value;
							//-- llena arrays
								arrartc+= artc+"|";
								arrartn+= artn+"|";
								arrcant+= cant+"|";
						}
						xajax_Grabar_Descarga(nfilas,fec.value,suc.value,clase.value,doc.value,arrartc,arrartn,arrcant);
					}else{
						if(fec.value === ""){
							fec.className = " form-danger";
						}else{
							fec.className = " form-control";
						}
						if(suc.value === ""){
							suc.className = " form-danger";
						}else{
							suc.className = " form-control";
						}
						if(clase.value === ""){
							clase.className = " form-danger";
						}else{
							clase.className = " form-control";
						}
						if(doc.value === ""){
							doc.className = " form-danger";
						}else{
							doc.className = " form-control";
						}
						msj = '<h5>Debe llenar los datos obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<h5>No hay art&iacute;culos para Descargar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			
			function ConfirmDescargaVentaJS(){
				texto = "Esta seguro de Descargar a Inventario est(e)(os) Articulo(s)?...";
				acc = "DescargaVentaJS();";
				ConfirmacionJs(texto,acc);
			}
						
			function DescargaVentaJS(){
				abrir();
				nfilas = document.getElementById("filas").value;
				suc = document.getElementById("suc");
				clase = document.getElementById("clase");
				doc = document.getElementById("ventC");
				fec = document.getElementById("fec");
				if(nfilas > 0){
					if(suc.value !== "" && clase.value !== "" && vent.value !== ""){
						nfilas = document.getElementById("filas").value;
						var bandera = false;
						var arrartc = "|";
						var arrartn = "|";
						var arrcant = "|";
						var C = 1;
						for(var i = 1; i <= nfilas; i ++){
							//extrae datos del grid
							artc = document.getElementById("artc"+i).value;
							artn = document.getElementById("artn"+i).value;
							cant = document.getElementById("cant"+i).value;
							//-- llena arrays
								arrartc+= artc+"|";
								arrartn+= artn+"|";
								arrcant+= cant+"|";
						}
						xajax_Grabar_Descarga_Venta(nfilas,fec.value,suc.value,clase.value,doc.value,arrartc,arrartn,arrcant);
					}else{
						if(suc.value === ""){
							suc.className = " form-danger";
						}else{
							suc.className = " form-control";
						}
						if(clase.value === ""){
							clase.className = " form-danger";
						}else{
							clase.className = " form-control";
						}
						if(doc.value === ""){
							doc.className = " form-danger";
						}else{
							doc.className = " form-control";
						}
						msj = '<h5>Debe llenar los datos obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<h5>No hay art&iacute;culos para Descargar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
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
			
			
			function ResetProv(){
				nom = document.getElementById('nom');
				nit = document.getElementById('nit');
				prov = document.getElementById('prov');
				nom.value = "";
				nit.value = "";
				prov.value = "";
			}
			
			function NewProveedor(nit){
				var x = 0;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/proveedor/new_proveedor.php",{nit:nit}, function(data){
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
				document.getElementById('art').focus();
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
				var ValMail = false;
				
				if(nit.value !=="" && nom.value !=="" && direc.value !== "" && tel1.value !== "" && contac.value !== ""){
					abrirMixPromt();
					xajax_Grabar_Proveedor(nit.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,contac.value,telc.value);
				}else{
					abrirMixPromt();
					if(nit.value ===""){
						nit.className = " form-danger";
					}else{
						nit.className = " form-control";
					}
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(direc.value ===""){
						direc.className = " form-danger";
					}else{
						direc.className = " form-control";
					}
					if(tel1.value ===""){
						tel1.className = " form-danger";
					}else{
						tel1.className = " form-control";
					}
					if(contac.value ===""){
						contac.className = " form-danger";
					}else{
						contac.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
		/////////////////------------ ARTICULO  -------------------/////////////
		
			function Articulo(){
				art = document.getElementById('art').value;
				barc = document.getElementById('barc').value;
				suc = document.getElementById("suc").value;
				sucX = document.getElementById("sucX").value;
				y = (suc !== "")?suc:sucX;
				//alert(art+","+barc+","+y);
				if(art !=="" || barc !==""){
					xajax_Show_Articulo(art,barc,y);
				}
			}
						
						
			function Ul_Articulo_Carga(n){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventariosuministro/popart.php",{tipo:n}, function(data){
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
			}
							
			function NewArticulo(){
				var x = 0;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/suministro/new_articulo.php",{variable:x}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function SearchArticulo(x){
				suc = document.getElementById("suc");
				if(suc.value !== ""){
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/suministro/busca_articulo.php",{formulario:x,empresa:suc.value}, function(data){
					// Ponemos la respuesta de nuestro script en el DIV recargado
					$("#Pcontainer").html(data);
					});
					abrirModal();
				}else{
					abrir();
					suc.className = " form-danger";
					msj = '<h5>Debe Seleccionar una Empresa o Bodega de donde cargar o descargar el inventario</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
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
						gru.className = " form-danger";
					}else{
						gru.className = " form-control";
					}
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(marca.value ===""){
						marca.className = " form-danger";
					}else{
						marca.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
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
				prev.value = (prev.value === "")?0:prev.value; //valida que no regrese vacio
				prec = document.getElementById('Tprec'+fila);
				prec.value = (prec.value === "")?0:prec.value; //valida que no regrese vacio
				prem = document.getElementById('Tprem'+fila);
				prem.value = (prem.value === "")?0:prem.value; //valida que no regrese vacio
				barc = document.getElementById('Tbarc'+fila);
				nit = document.getElementById('Tpnit'+fila);
				prov = document.getElementById('Tpcod'+fila);
				nom = document.getElementById('Tpnom'+fila);
				//-- reciben datos
				inpart = document.getElementById('artn');
				inpcod = document.getElementById('art');
				inpcant = document.getElementById('cantlimit');
				inpmon = document.getElementById('mon');
				inpprev = document.getElementById('prev');
				inpprec = document.getElementById('prec');
				inpprem = document.getElementById('prem');
				inpbarc = document.getElementById('barc');
				inpnit = document.getElementById('nit');
				inpprov = document.getElementById('prov');
				inpnom = document.getElementById('nom');
				//---
				inpart.value = art.value;
				inpcod.value = cod.value;
				inpcant.value = cant.value;
				inpmon.value = mon.value;
				inpprev.value = prev.value;
				inpprec.value = prec.value;
				inpprem.value = prem.value;
				inpbarc.value = barc.value;
				inpnit.value = nit.value;
				inpprov.value = prov.value;
				inpnom.value = nom.value;
				//alert(prev.value+","+prem.value+","+prec.value);
				document.getElementById('cant').focus();
				cerrar();
			}
								
			function GrabarArticulo(){
				abrir();
				gru = document.getElementById('gru1');
				marca = document.getElementById('marca1');
				nom = document.getElementById("artnom1");
				desc = document.getElementById("desc1");
				cumed = document.getElementById("umclase1");
				umed = document.getElementById("umed1");
				barc = document.getElementById("barc1");
				prev = document.getElementById("precio1");
				mon = document.getElementById("mon1");
				chk = document.getElementById("chkb1");
				chkb = (chk.checked === true)?1:0;
				
				if(gru.value !=="" && marca.value !== "" && nom.value !=="" && desc.value !== "" && prev.value !== "" && mon.value !== "" && umed.value !== ""){
				    xajax_Grabar_Articulo(gru.value,barc.value,nom.value,desc.value,marca.value,umed.value,chkb,prev.value,mon.value);
						//botones
						busc = document.getElementById("busc");
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						busc.disabled = false;
						mod.disabled = true;
						gra.disabled = true;
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
					if(marca.value ===""){
						marca.className = " form-danger";
					}else{
						marca.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					if(prev.value ===""){
						prev.className = " form-danger";
					}else{
						prev.className = " form-control";
					}
					if(mon.value ===""){
						mon.className = " form-danger";
					}else{
						mon.className = " form-control";
					}
					if(cumed.value ===""){
						cumed.className = " form-danger";
					}else{
						cumed.className = " form-control";
					}
					if(umed.value ===""){
						umed.className = " form-danger";
					}else{
						umed.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
	
			function ConfirmAnular(Cod,Tipo,Sit){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventariosuministro/cambia_sit.php",{cod:Cod,tipo:Tipo,sit:Sit}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function CambiarSituacion(){
				just = document.getElementById('just1');
				cod = document.getElementById('cod1').value;
				tipo = document.getElementById('tipo1').value;
				sit = document.getElementById("sit1").value;
				abrirMixPromt();
				if(just.value !== ""){
					xajax_Cambiar_Situacion(cod,tipo,sit);
				}else{
					just.className = " form-danger";
					msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
	////////------- Historial de Inventario -------/////////////
	
			function Ver_Detalle_Inventario(inv,tip){
				var n1 = 1;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventariosuministro/detalle_inventario.php",{inventario:inv,tipo:tip}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
	
	//////////---------- Venta ----------------////////
	
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
			
	//////////---------- Compra ----------------////////
	
			function BuscarCompra(){
				comp = document.getElementById('comp');
				doc = document.getElementById('doc');
				//--
				if(comp.value !=="" || doc.value !==""){
					abrir();
					xajax_Buscar_Compra(comp.value,doc.value);
				}
			}
			
	////////------ Reportes ------------------//////////////
	
			function ReporteGrupo(doc){
				myform = document.forms.f1;
				if (doc === 1) {
					myform.action = "REPgrupos.php";
				}else if (doc === 2) {
					myform.action = "EXCELgrupos.php";
				}
				myform.submit();
				
			}
			
			function ReporteArticulo(doc){
				myform = document.forms.f1;
				if (doc === 1) {
					myform.action = "REParticulos.php";
				}else if (doc === 2) {
					myform.action = "EXCELarticulos.php";
				}
				myform.submit();
				
			}
			
			function ReporteCliente(doc){
				myform = document.forms.f1;
				if (doc === 1) {
					myform.action = "REPclientes.php";
				}else if (doc === 2) {
					myform.action = "EXCELclientes.php";
				}
				myform.submit();
				
			}
			
			function ReporteProvee(doc){
				myform = document.forms.f1;
				if (doc === 1) {
					myform.action = "REPproveedores.php";
				}else if (doc === 2) {
					myform.action = "EXCELproveedores.php";
				}
				myform.submit();
				
			}
			
			function ReporteHist(x){
				tipo = document.getElementById('tipo');
				clase = document.getElementById('clase');
				doc = document.getElementById("doc");
				suc = document.getElementById("suc");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(tipo.value !=="" || clase.value !=="" || doc.value !== "" || suc.value !== "" || fini.value !== "" || ffin.value !== ""){
					myform = document.forms.f1;
					if (x === 1) {
						myform.action = "REPhistorial.php";
					}else if (x === 2) {
						myform.action = "EXCELhistorial.php";
					}
					myform.submit();
				}else{
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					if(clase.value ===""){
						clase.className = " form-danger";
					}else{
						clase.className = " form-control";
					}
					if(doc.value ===""){
						doc.className = " form-danger";
					}else{
						doc.className = " form-control";
					}
					if(suc.value ===""){
						suc.className = " form-danger";
					}else{
						suc.className = " form-control";
					}
					if(fini.value ===""){
						fini.className = " form-danger";
					}else{
						fini.className = " form-control";
					}
					if(ffin.value ===""){
						ffin.className = " form-danger";
					}else{
						ffin.className = " form-control";
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function ReporteKardex(doc){
				suc = document.getElementById("suc");
				
				if(suc.value !== ""){
					myform = document.forms.f1;
					if (doc === 1) {
						myform.action = "REPkardex.php";
					}else if (doc === 2) {
						myform.action = "EXCELkardex.php";
					}
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = " form-danger";
					}else{
						suc.className = " form-control";
					}
					abrir();
					msj = '<h5>Debe seleccionar a que empresa pertenece el articulo buscado...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
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
	
	
			