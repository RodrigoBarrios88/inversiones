//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "¿Desea Limpiar la Pagina?, perdera los datos escritos...";
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
				$.post("../promts/servicio/get_masa.php",{variable1:n1}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function DownloadFormato(){
				window.location = '../promts/servicio/download_formato.php';
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
				chk = document.getElementById("chkb");
				chkb = (chk.checked === true)?1:0;
				gru = document.getElementById('gru');
				nom = document.getElementById("nom");
				desc = document.getElementById("desc");
				barc = document.getElementById("barc");
				prec = document.getElementById("prec");
				prev = document.getElementById("prev");
				mon = document.getElementById("mon");
				
				if(gru.value !=="" && nom.value !=="" && desc.value !== "" && prec.value !== "" && prev.value !== "" && mon.value !== ""){
				   
					xajax_Grabar_Servicio(gru.value,barc.value,nom.value,desc.value,chkb,prec.value,prev.value,mon.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(gru.value ===""){
						gru.className="form-danger";
					}else{
						gru.className="form-control";
					}
					if(nom.value ===""){
						nom.className="form-danger";
					}else{
						nom.className="form-control";
					}
					if(desc.value ===""){
						desc.className="form-danger";
					}else{
						desc.className="form-control";
					}
					if(prec.value ===""){
						prec.className="form-danger";
					}else{
						prec.className="form-control";
					}
					if(prev.value ===""){
						prev.className="form-danger";
					}else{
						prev.className="form-control";
					}
					if(mon.value ===""){
						mon.className="form-danger";
					}else{
						mon.className="form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				gru = document.getElementById('gru');
				nom = document.getElementById("nom");
				desc = document.getElementById("desc");
				barc = document.getElementById("barc");
				prec = document.getElementById("prec");
				prev = document.getElementById("prev");
				mon = document.getElementById("mon");
				
				if(gru.value !=="" && nom.value !=="" && desc.value !== "" && prec.value !== "" && prev.value !== "" && mon.value !== ""){
						xajax_Modificar_Servicio(cod.value,gru.value,barc.value,nom.value,desc.value,prec.value,prev.value,mon.value);
						//botones
						gra = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(gru.value ===""){
						gru.className="form-danger";
					}else{
						gru.className="form-control";
					}
					if(nom.value ===""){
						nom.className="form-danger";
					}else{
						nom.className="form-control";
					}
					if(desc.value ===""){
						desc.className="form-danger";
					}else{
						desc.className="form-control";
					}
					if(prec.value ===""){
						prec.className="form-danger";
					}else{
						prec.className="form-control";
					}
					if(prev.value ===""){
						prev.className="form-danger";
					}else{
						prev.className="form-control";
					}
					if(mon.value ===""){
						mon.className="form-danger";
					}else{
						mon.className="form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
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

			function Deshabilita_Servicio(ser,grup){
				texto = "¿Esta seguro de Deshabilitar este Servicio?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Servicio("+grup+","+ser+",0)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_Servicio(ser,grup){
				texto = "¿Esta seguro de habilitar este Servicio?";
				acc = "xajax_Situacion_Servicio("+grup+","+ser+",1)";
				ConfirmacionJs(texto,acc);
			}
			
	///////////// Servicios en Masa
			function ConfirmGrabarList(){
				texto = "¿Desea guardar el Listado de Articulos";
				acc = "GrabarMasa();";
				ConfirmacionJs(texto,acc);
			}
			
			function GrabarMasa(){
				filas = document.getElementById('filas').value;
				gru = document.getElementById('gru').value;
				//--
				if(filas > 0){
					arrnombre = new Array([]);
					arrdesc = new Array([]);
					arrprec = new Array([]);
					arrprev = new Array([]);
					arrmon = new Array([]);
					arrtcambio = new Array([]);
					for (var i = 1; i <= filas; i++) {
						arrnombre[i] = document.getElementById('nombre'+i).value;
						arrdesc[i] = document.getElementById('desc'+i).value;
						arrprec[i] = document.getElementById('prec'+i).value;
						arrprev[i] = document.getElementById('prev'+i).value;
						arrmon[i] = document.getElementById('mon'+i).value;
						arrtcambio[i] = document.getElementById('tcambio'+i).value;
					}
					xajax_Grabar_Masa(gru,arrnombre,arrdesc,arrprec,arrprev,arrmon,arrtcambio,filas);
				}else{
					msj = '<h5>No hay filas de registros para ser cargados</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
		////////// REPORTES
		
		function ReporteGrupo(doc){
				myform = document.forms.f1;
				if (doc === 1) {
					myform.action = "REPgrupos.php";
				}else if (doc === 2) {
					myform.action = "EXCELgrupos.php";
				}
				myform.submit();
				
			}
			
			function ReporteServicio(doc){
				myform = document.forms.f1;
				if (doc === 1) {
					myform.action = "REPservicios.php";
				}else if (doc === 2) {
					myform.action = "EXCELservicios.php";
				}
				myform.submit();
				
			}
			