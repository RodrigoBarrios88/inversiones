//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "¿Desea Cancelar?";
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
			
			function PromtCaptura(){
				var n1 = 1;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/articulo/get_masa.php",{variable1:n1}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function DownloadFormato(){
				window.location = '../promts/articulo/download_formato.php';
			}
			
			function ConfirmCargar(){
				abrirMixPromt();
				gru = document.getElementById('gru1');
				doc = document.getElementById('doc');
				
				if(gru.value !=="" && doc.value !== ""){
					cerrar();
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
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function Grabar(){
				abrir();
				gru = document.getElementById('gru');
				marca = document.getElementById('marca');
				nom = document.getElementById("artnom");
				desc = document.getElementById("desc");
				umed = document.getElementById("umed");
				barc = document.getElementById("barc");
				chk = document.getElementById("chkb");
				chkb = (chk.checked === true)?1:0;
				margen = document.getElementById("margen");
				mon = document.getElementById("mon");
				
				if(gru.value !=="" && marca.value !== "" && nom.value !=="" && desc.value !== "" && margen.value !== "" && mon.value !== "" && umed.value !== ""){
				   
					xajax_Grabar_Articulo(gru.value,barc.value,nom.value,desc.value,marca.value,umed.value,chkb,margen.value,mon.value);
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
					if(margen.value ===""){
						margen.className = " form-danger";
					}else{
						margen.className = " form-control";
					}
					if(mon.value ===""){
						mon.className = " form-danger";
					}else{
						mon.className = " form-control";
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
			
			function Modificar(){
				abrir();
				gru = document.getElementById('gru');
				marca = document.getElementById('marca');
				nom = document.getElementById("artnom");
				desc = document.getElementById("desc");
				umed = document.getElementById("umed");
				barc = document.getElementById("barc");
				margen = document.getElementById("margen");
				
				if(gru.value !=="" && marca.value !== "" && nom.value !=="" && desc.value !== "" && margen.value !== "" && umed.value !== ""){
						
						xajax_Modificar_Articulo(cod.value,gru.value,barc.value,nom.value,desc.value,marca.value,umed.value,margen.value);
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
					if(margen.value ===""){
						margen.className = " form-danger";
					}else{
						margen.className = " form-control";
					}
					if(mon.value ===""){
						mon.className = " form-danger";
					}else{
						mon.className = " form-control";
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
			
			function ModPrecio(){
				abrir();
				cod = document.getElementById('cod');
				gru = document.getElementById('gru');
				precio = document.getElementById("precio");
				margen = document.getElementById("margen");
				mon = document.getElementById("mon");
				
				if(cod.value !=="" && gru.value !=="" && precio.value !== "" && margen.value !== "" && mon.value !== ""){
					xajax_Modificar_Precio(cod.value,gru.value,precio.value,margen.value,mon.value);
						//botones
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
				}else{
					if(gru.value ===""){
						gru.className = " form-danger";
					}else{
						gru.className = " form-control";
					}
					if(precio.value ===""){
						precio.className = " form-danger";
					}else{
						precio.className = " form-control";
					}
					if(margen.value ===""){
						margen.className = " form-danger";
					}else{
						margen.className = " form-control";
					}
					if(mon.value ===""){
						mon.className = " form-danger";
					}else{
						mon.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}


			function Limpia_campos(){
				//limpia campos
				document.getElementById('cod').value = "";
				document.getElementById('gru').value = "";
				document.getElementById('artnom').value = "";
				document.getElementById("desc").value = "";
				document.getElementById("marca").value = "";
				document.getElementById("umclase").value = "";
				document.getElementById("umed").value = "";
				document.getElementById("barc").value = "";
				document.getElementById("sit").value = "";
				document.getElementById("prev").value = "";
				document.getElementById("margen").value = "";
				document.getElementById("chkb").checked = true;
				Esconde_Campos(2);
			}

			function Esconde_Campos(n){
				if(n === 1){ //valida si el lote a utilizar es un lote existente
					//esconde el resto de campos para registrar un lote nuevo
					document.getElementById('s1').style.display = "none";
					document.getElementById('s2').style.display = "none";
					document.getElementById('s3').style.display = "none";
					document.getElementById('s4').style.display = "none";
					document.getElementById('s5').style.display = "none";
					document.getElementById('prev').style.display = "none";
				}else{ //valida si el lote a utilizar es un lote nuevo
					//despliega el resto de campos para registrar un lote nuevo
					document.getElementById('s1').style.display = "block";
					document.getElementById('s2').style.display = "block";
					document.getElementById('s3').style.display = "block";
					document.getElementById('s4').style.display = "block";
					document.getElementById('s5').style.display = "block";
					document.getElementById('prev').style.display = "block";
				}
			}		

			function Deshabilita_Articulo(art,grup){
				texto = "Esta seguro de Deshabilitar este Art\u00E1culo?, No podra ser usado con esta situacion...";
				acc = "xajax_Situacion_Articulo("+grup+","+art+",0)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_Articulo(art,grup){
				texto = "Esta seguro de habilitar este Art\u00E1culo?";
				acc = "xajax_Situacion_Articulo("+grup+","+art+",1)";
				ConfirmacionJs(texto,acc);
			}
			
	///////////// Articulos en Masa
			
			function ConfirmGrabarList(){
				texto = "¿Desea guardar el Listado de Articulos";
				acc = "GrabarMasa();";
				ConfirmacionJs(texto,acc);
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
					arrprov = new Array([]);
					arrprem = new Array([]);
					arrprec = new Array([]);
					arrprev = new Array([]);
					arrmon = new Array([]);
					arrtcambio = new Array([]);
					arrcant = new Array([]);
					for (var i = 1; i <= filas; i++) {
						arrnombre[i] = document.getElementById('nombre'+i).value;
						arrdesc[i] = document.getElementById('desc'+i).value;
						arrmarca[i] = document.getElementById('marca'+i).value;
						arrprov[i] = document.getElementById('prov'+i).value;
						arrprem[i] = document.getElementById('prem'+i).value;
						arrprec[i] = document.getElementById('prec'+i).value;
						arrprev[i] = document.getElementById('prev'+i).value;
						arrmon[i] = document.getElementById('mon'+i).value;
						arrtcambio[i] = document.getElementById('tcambio'+i).value;
						arrcant[i] = document.getElementById('cant'+i).value;
					}
					xajax_Grabar_Masa(gru,suc,arrnombre,arrdesc,arrmarca,arrprov,arrprem,arrprec,arrprev,arrmon,arrtcambio,arrcant,filas);
					//alert('entro');
				}else{
					msj = '<h5>No hay filas de registros para ser cargados</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			function ReporteArticulo(){
				var cant;
				n = document.getElementById('cant');
				if (n.value !== "") {
					cant = parseInt(n.value);	
				}else{
					cant = 0;
				}
				if (cant > 5) {
					myform = document.forms.f1;
					myform.action ="REPbarcode.php";
					myform.submit();
				}else{
					abrir();
					msj = '<h5>La cantidad de impresion de etiquetas debe de ser por lo menos de 5...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			
			function CalculaMargen(){
				margen = parseFloat(document.getElementById("margen").value);
				costo = parseFloat(document.getElementById("precost").value);
				if((!isNaN(margen)) && (!isNaN(costo))){
					var precio = ((costo * margen)/100)+costo;
					document.getElementById("precio").value = precio;
				}
				return;
			}
