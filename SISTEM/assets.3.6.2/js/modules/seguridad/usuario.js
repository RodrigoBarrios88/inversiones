//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
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
				abrir();
				tipo = document.getElementById("tipo");
				nom = document.getElementById("nom");
				mail = document.getElementById("mail");
				tel = document.getElementById("tel");
				usu = document.getElementById("usu");
				pass = document.getElementById("pass");
				cambObj1 = (document.getElementById("cambio1").checked)?1:0;
				cambObj2 = (document.getElementById("cambio2").checked)?1:0;
				if(cambObj1 === 1){ 
					cambio = 1;
				}else if(cambObj2 === 1){ 
					cambio = 0;
				}else{
					cambio = 1;
				}
				//alert(cambio);
				var ValMail = false;
				
				if(nom.value !== "" && tipo.value !==  "" && usu.value !==  "" && pass.value !==  "" && mail.value !==  ""){
					if(mail.value !==  '' || mail.value !==  ' ' || mail.value !==  '  '){
						ValMail = validarEmail(mail.value);
					}else{
						ValMail = true;
					}
					if(ValMail === true){
						xajax_Grabar_Usuario(nom.value,mail.value,tel.value,usu.value,pass.value,tipo.value,cambio);
						//botones
					}else{
						msj = '<h5>Formato de e-mail invalido</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						mail.style.borderColor = "#DF3A01";
						mail.style.backgroundColor = "F7BE81";
					}		
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					if(usu.value ===""){
						usu.className = " form-danger";
					}else{
						usu.className = " form-control";
					}
					if(pass.value ===""){
						pass.className = " form-danger";
					}else{
						pass.className = " form-control";
					}
					if(mail.value ===""){
						mail.className = " form-danger";
					}else{
						mail.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				tipo = document.getElementById("tipo");
				nom = document.getElementById('nom');
				mail = document.getElementById('mail');
				tel = document.getElementById('tel');
				usu = document.getElementById("usu");
				pass = document.getElementById("pass");
				avi = (document.getElementById("avi").checked)?0:1;
				seg = (document.getElementById("seg").checked)?1:0;
				cambObj1 = (document.getElementById("cambio1").checked)?1:0;
				cambObj2 = (document.getElementById("cambio2").checked)?1:0;
				if(cambObj1 === 1){ 
					cambio = 1;
				}else if(cambObj2 === 1){ 
					cambio = 0;
				}else{
					cambio = 1;
				}
				//alert(cambio);
				var ValMail = false;
								
				if(nom.value !== "" && tipo.value !==  ""){
					if(mail.value !==  '' || mail.value !==  ' ' || mail.value !==  '  '){
						ValMail = validarEmail(mail.value);
					}else{
						ValMail = true;
					}
					if(ValMail === true){
						xajax_Modificar_Usuario(cod.value,tipo.value,nom.value,mail.value,tel.value,usu.value,pass.value,avi,seg,cambio);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary';
					}else{
						msj = '<h5>Formato de e-mail invalido</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						mail.className = " form-danger text-libre";
					}			
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function CambiarSit(){
				abrirMixPromt();
				cod = document.getElementById("cod1");
				sit = document.getElementById("sit1");
				
				if(cod.value !==  "" && sit.value !==  ""){
					xajax_CambiaSit_Usuario(cod.value,sit.value);
				}else{
					if(cod.value ===""){
						cod.className = " form-danger";
					}else{
						cod.className = " form-control";
					}
					if(sit.value ===""){
						sit.className = " form-danger";
					}else{
						sit.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}			

			function Buscar(){
				abrir();
				cod = document.getElementById('cod');
				tipo = document.getElementById('tipo');
				nom = document.getElementById('nom');
				usu = document.getElementById('usu');
				
				if(cod.value !== "" || tipo.value !== "" || nom.value !== "" || usu.value !==  ""){
					xajax_Buscar_Usuario(cod.value,tipo.value,nom.value,usu.value);
					//botones
					gra = document.getElementById("gra");
					mod = document.getElementById("mod");
					gra.className = 'btn btn-primary hidden';
					mod.className = 'btn btn-primary';
				}else{
					if(tipo.value ===""){
						tipo.className = " form-info";
					}else{
						tipo.className = " form-control";
					}
					if(nom.value ===""){
						nom.className = " form-info";
					}else{
						nom.className = " form-control";
					}
					if(usu.value ===""){
						usu.className = " form-info";
					}else{
						usu.className = " form-control";
					}
					msj = '<h5>Determinar almenos un criterio de busqueda (Nombre, Empresa o Usuario)</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function Promt_Buscar_Usuarios(cod){
				cerrar();
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/usuario/buscar.php",{ban:cod}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function Promt_Cambia_Sit(cod){
				cerrar();
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/usuario/cambia_sit.php",{usuid:cod}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function Buscar2(acc){
				abrirMixPromt();
				tipo = document.getElementById('tipo1');
				sit = document.getElementById('sit1');
				nom = document.getElementById('nom1');
				usu = document.getElementById('usu1');
					
				if(tipo.value !== "" || nom.value !== "" || usu.value !==  ""){
					xajax_Ver_Usuarios(tipo.value,nom.value,usu.value,sit.value,acc);
				}else{
					if(tipo.value ===""){
						tipo.className = " form-info";
					}else{
						tipo.className = " form-control";
					}
					if(nom.value ===""){
						nom.className = " form-info";
					}else{
						nom.className = " form-control";
					}
					if(usu.value ===""){
						usu.className = " form-info";
					}else{
						usu.className = " form-control";
					}
					msj = '<h5>Determinar almenos un criterio de busqueda (Nombre, Empresa o Usuario)</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
			
			function Seleccionar_UsuarioJs(cod,acc,fila){
				if(acc === 1){
					xajax_Cuadro_Roles_Usuario(cod);
				}else if(acc === 2){
					xajax_Ver_Info_Usuario(cod,fila);
				}else if(acc === 3){
					Promt_Cambia_Sit(cod);
				}else if(acc === 4){
					xajax_Ver_Usu_Perm(cod,fila);
				}else if(acc === 5){
					xajax_Ver_Usu_Hist(cod,fila);
				}
			}
			
			function cerrar_info(fila){
				if(fila > 0){
					xajax_Cerrar_Info(fila);
				}
			}
								
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Roles de Permisos ///////////////////////////////
			
			function AsignarPerm(){
				abrir();
				usu = document.getElementById('usu');
				rol = document.getElementById('rol');
				cant = document.getElementById('cant').value;
				var C = 1;
				if(cant > 0){
					if(usu.value !==  "" && rol.value !==  ""){
						var arrperm = Array([]);
						var arrgrup = Array([]);
						for (var i = 1; i <= cant; i++){
							chk = document.getElementById('chk'+i);
							if(chk.checked){
								perm = document.getElementById('cod'+i).value;
								grup = document.getElementById('gru'+i).value;
								arrperm[C] = perm;
								arrgrup[C] = grup;
								C++;
							}
						}
						C--;//le quita la ultima vuelta al contador...
						if(C > 0){
							xajax_Asignar_Permisos(usu.value,rol.value,arrperm,arrgrup,C);
						}else{
							msj = '<h5>Seleccione los permisos a asignar en este rol...</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						if(usu.value ===""){
							usu.className = " form-danger";
						}else{
							usu.className = " form-control";
						}
						if(rol.value ===""){
							rol.className = " form-danger";
						}else{
							rol.className = " form-control";
						}
						msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						
					}
				}else{
					msj = '<h5>No hay permisos por asignar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}
			
									
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// perfil FRMpassword ///////////////////////////////
			
			function ModificarPass(){
				abrir();
				cod = document.getElementById('cod');
				usu = document.getElementById('usu');
				pass1 = document.getElementById("pass1");
				pass2 = document.getElementById("pass2");
								
				if(cod.value !== "" && usu.value !== "" && pass1.value !==  "" && pass2.value !==  ""){
					if(pass1.value === pass2.value){
						xajax_Modificar_Usuario_Pass(cod.value,usu.value,pass1.value);
					}else{
						pass1.className = " form-danger";
						pass2.className = " form-danger";
						msj = '<h5>La Contrase&ntilde;a y la Confirmaci&oacute;n no son iguales...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if(usu.value ===""){
						usu.className = " form-danger";
					}else{
						usu.className = " form-control";
					}
					if(pass1.value ===""){
						pass1.className = " form-danger";
					}else{
						pass1.className = " form-control";
					}
					if(pass2.value ===""){
						pass2.className = " form-danger";
					}else{
						pass2.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function comprueba_vacios(n,x){
				texto = n.value;
				if(texto === ""){ 
					document.getElementById(x).className="text-warning glyphicon glyphicon-warning-sign";
				}else{
					document.getElementById(x).className="text-success fa fa-check";
					var rojo = 0;
					var amar = 0;
					var verd = 0;
					var seguridad = seguridad_clave(texto);
					seguridad = parseInt(seguridad);
					
					if (seguridad <= 35) {
						rojo = parseInt(seguridad);
						document.getElementById("progress1").style.width = rojo + "%";
						document.getElementById("progress2").style.width = 0 + "%";
						document.getElementById("progress3").style.width = 0 + "%";
					}if (seguridad > 35 && seguridad <= 70) {
						rojo = 35;
						amar = parseInt(seguridad)-35;
						document.getElementById("progress1").style.width = rojo + "%";
						document.getElementById("progress2").style.width = amar + "%";
						document.getElementById("progress3").style.width = 0 + "%";
					}if (seguridad > 70) {
						rojo = 35;
						amar = 35;
						verd = parseInt(seguridad)-70;
						document.getElementById("progress1").style.width = rojo + "%";
						document.getElementById("progress2").style.width = amar + "%";
						document.getElementById("progress3").style.width = verd + "%";
					}
					
				}
			}

			function comprueba_iguales(n1,n2){
				texto1 = n1.value;
				texto2 = n2.value;
				if(texto1 === texto2){
					document.getElementById('pas2').className="text-success fa fa-check";
				}else{
					//alert(texto2);
					if(texto2 === ""){
						document.getElementById('pas2').className="text-warning glyphicon glyphicon-warning-sign";
					}else{
						document.getElementById('pas2').className="text-danger glyphicon glyphicon-remove";
					}
				}
			}
			
			function seguridad_clave(clave){
				var seguridad = 0;
				if(clave.length!== 0){
					if (tiene_numeros(clave) && tiene_letras(clave)){
					     seguridad += 30;
					}
					if (tiene_minusculas(clave) && tiene_mayusculas(clave)){
					     seguridad += 30;
					}
					if (clave.length >= 4 && clave.length <= 5){
					     seguridad += 10;
					}else{
						if (clave.length >= 6 && clave.length <= 8){
						     seguridad += 30;
						}else{
							if (clave.length > 8){
								seguridad += 40;
							}
						}
					}
				}
				return seguridad;           
			}
			
			function comprueba_dias(n){
				num = n.value;
				if(num > 180){
					msj = '<h5>El tiempo para pedir cambio de Contrase&ntilde;a no debe exceder de 6 meses (180 dias)</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					n.value = 180;
					abrir();
				}else if(num < 30){
					msj = '<h5>El tiempo para pedir cambio de Contrase&ntilde;a no debe ser menor a 1 meses calendario (30 dias)</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					n.value = 180;
					abrir();
				}
				return;
			}
			
			
		///////// Pregunta Clave /////////////
		
			function ModificarPreg(){
				abrir();
				cod = document.getElementById('cod');
				usu = document.getElementById('usu');
				preg = document.getElementById("preg");
				resp = document.getElementById("resp");
								
				if(cod.value !== "" && usu.value !== "" && preg.value !==  "" && resp.value !==  ""){
					xajax_Modificar_Usuario_Pregunta(cod.value,usu.value,preg.value,resp.value);
				}else{
					if(preg.value ===""){
						preg.className = " form-danger";
					}else{
						preg.className = " form-control";
					}
					if(resp.value ===""){
						resp.className = " form-danger";
					}else{
						resp.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
		///////// Pregunta Clave /////////////
		
			function ModificarPerfil(){
				abrir();
				cod = document.getElementById('cod');
				nom2 = document.getElementById("nom2");
				mail = document.getElementById("mail");
				tel = document.getElementById("tel");
								
				if(cod.value !==  "" && mail.value !==  "" && tel.value !==  "" && nom2.value !==  ""){
					xajax_Modificar_Usuario_Perfil(cod.value,nom2.value,mail.value,tel.value);
				}else{
					if(nom2.value === ""){
						nom2.className = " form-danger";
					}else{
						nom2.className = " form-control";
					}
					if(mail.value === ""){
						mail.className = " form-danger";
					}else{
						mail.className = " form-control";
					}
					if(tel.value === ""){
						tel.className = " form-info";
					}else{
						tel.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			///////// Fotografia /////////////
			
			function Cargar(){
				nom = document.getElementById("nom");
				doc = document.getElementById("doc");
				abrir();				
				if(doc.value !==  ""){
					exdoc = comprueba_extension(doc.value);
					if(exdoc === 1){
						myform = document.forms.f1;
						myform.submit();
					}else{
						if(exdoc !==  1){
							doc.className = " form-danger";
						}else{
							doc.className = " form-control";
						}
						msj = '<h5>Este archivo no es extencion .jpg \u00F3 .png</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}		
				}else{
					if(doc.value ===""){
						doc.className = " form-danger";
					}else{
						doc.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			///////// Utilitarias /////////////
			
			
			function validarEmail(valor) {
				var filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;	
				if (filtro.test(valor)){
					return true;
				} else {
					return false;
				}
			}
			
			function checkValue(n){
				if(n === 1){ 
					document.getElementById("cambio2").checked = false;
				}else if(n === 2){ 
					document.getElementById("cambio1").checked = false;
				}
			}
			
			
			function msjAlert(texto,pagina){
				msj = "<h5>"+texto+"</h5><br><br>";
				msj+= '<button type="button" class="btn btn-primary" onclick = "window.location=\''+pagina+'\'" ><span class="fa fa-check"></span> Aceptar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
			
			function check_todo_grupo(grupo){
				chkg = document.getElementById("chkg"+grupo);
				glist = document.getElementById("gruplist"+grupo);
				var cadena = glist.value;
				var separador = cadena.split("-");
				var cuantos = separador[1];
				var inicia = (parseInt(separador[1])-parseInt(separador[0]))+1;
				//alert(inicia+"-"+cuantos);
				if(chkg.checked) {
					for(var i = inicia; i <= cuantos; i++){
						document.getElementById("chk"+i).checked = true;
					}
				}else{
					for(var i = inicia; i <= cuantos; i++){
						document.getElementById("chk"+i).checked = false;
					}
				}
			}
			
			
			function comprueba_extension(archivo) {
			   //mierror = "";
			   if (!archivo) {
				  //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
				  // mierror = "No has seleccionado ningún archivo";
				  alert("No archivo");
			   }else{
				  //recupero la extensi\u00F3n de este nombre de archivo
				  extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
				  //alert (extension);
				  //compruebo si la extensi\u00F3n está entre las permitidas
				  permitida = false;
				   if (".jpg" === extension || ".png" === extension) {
					 permitida = true;
				   }
				  if (!permitida) {
					return 0;
				  }else{
					  //todo correcto!
					 return 1;
				  }
			   }
			   return 0;
			} 
			