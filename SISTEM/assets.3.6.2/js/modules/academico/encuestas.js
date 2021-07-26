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
			
			function TipoTarget(){
				target = document.getElementById('target');
				tipo = document.getElementById('tipotarget');
				
				if(target.value === "SELECT"){
					tipo.removeAttribute("disabled");
					if(target.value !== "" && tipo.value !== ""){
						xajax_Target_Grupos(target.value,tipo.value);
					}
				}else{
					tipo.value = "0";
					tipo.setAttribute("disabled","disabled");
					xajax_Target_Grupos(target.value,tipo.value);
				}
			}
			
			function Grabar(){
				abrir();
				target = document.getElementById('target');
				tipo = document.getElementById('tipotarget');
				titulo = document.getElementById('titulo');
				destinatarios = document.getElementById('destinatarios');
				desc = document.getElementById("desc");
				feclimit = document.getElementById('feclimit');
				
				if(target.value !=="" && titulo.value !=="" && desc.value !== "" && feclimit.value !== "" && destinatarios.value !== ""){
					if (target.value === "SELECT") {
							var filas = parseInt(document.getElementById('gruposrows').value);
							var arrgrupos = Array([]);
							var cuantos = 1;
							for(i = 1; i <= filas; i++){
								chk = document.getElementById("grupos"+i);
								if(chk.checked) {
									arrgrupos[cuantos] = chk.value;
									cuantos++;
								}
							}
							cuantos--; //resta la ultima fila
							if(cuantos > 0) {
								xajax_Grabar_Encuesta(target.value,tipo.value,destinatarios.value,titulo.value,desc.value,feclimit.value,arrgrupos,cuantos);
							}else{
								msj = '<h5>Debe seleccionar almenos un (01) Grupo...</h5><br><br>';
								msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
								document.getElementById('lblparrafo').innerHTML = msj;
							}
					}else{
						var arrgrupos = Array([]);
						var cuantos = 0;
						xajax_Grabar_Encuesta(target.value,tipo.value,destinatarios.value,titulo.value,desc.value,feclimit.value,arrgrupos,cuantos);
					}
				}else{
					if(target.value ===""){
						target.className = "form-danger";
					}else{
						target.className = "form-control";
					}
					if(titulo.value ===""){
						titulo.className = "form-danger";
					}else{
						titulo.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(feclimit.value ===""){
						feclimit.className = "form-danger text-libre";
					}else{
						feclimit.className = "form-control text-libre";
					}
					if(destinatarios.value ===""){
						destinatarios.className = "form-danger text-libre";
					}else{
						destinatarios.className = "form-control text-libre";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				codigo = document.getElementById('codigo');
				titulo = document.getElementById('titulo');
				desc = document.getElementById("desc");
				feclimit = document.getElementById('feclimit');
				destinatarios = document.getElementById('destinatarios');
				
				if(titulo.value !=="" && desc.value !== "" && feclimit.value !== "" && destinatarios.value !== ""){
					xajax_Modificar_Encuesta(codigo.value,titulo.value,desc.value,feclimit.value,destinatarios.value);
				}else{
					if(titulo.value ===""){
						titulo.className = "form-danger";
					}else{
						titulo.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(feclimit.value ===""){
						feclimit.className = "form-danger text-libre";
					}else{
						feclimit.className = "form-control text-libre";
					}
					if(destinatarios.value ===""){
						destinatarios.className = "form-danger text-libre";
					}else{
						destinatarios.className = "form-control text-libre";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function ModificarTarget(){
				abrir();
				target = document.getElementById('target');
				tipo = document.getElementById('tipotarget');
				
				if(target.value !==""){
					if (target.value === "SELECT") {
							var filas = parseInt(document.getElementById('gruposrows').value);
							var arrgrupos = "";
							var cuantos = 0;
							//alert(filas);
							for(i = 1; i <= filas; i++){
								chk = document.getElementById("grupos"+i);
								if(chk.checked) {
									arrgrupos+= chk.value+"|";
									cuantos++;
								}
							}
							if(cuantos > 0) {
								document.getElementById('gruposrows').value = cuantos; //actualiza solo la cantidad de chequeados
								document.getElementById('chequeados').value = arrgrupos; //genera un string tipo array
								Submit();
							}else{
								msj = '<h5>Debe seleccionar almenos un (01) Grupo...</h5><br><br>';
								msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
								document.getElementById('lblparrafo').innerHTML = msj;
							}
					}else{
						Submit();
					}
				}else{
					if(target.value ===""){
						target.className = "form-danger";
					}else{
						target.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function ConfirmEliminar(codigo){
				texto = "Desea Eliminar esta Encuesta? No podra ser contestada ni revisar sus resultados con esta situaci&oacute;n...";
				acc = "xajax_Situacion_Encuesta("+codigo+");";
				ConfirmacionJs(texto,acc);
			}
			
			function ConfirmCerrar(codigo){
				texto = "Desea Cerrar esta Encuesta? Ya no podra ser contestada con esta situaci&oacute;n...";
				acc = "xajax_Cerrar_Encuesta("+codigo+");";
				ConfirmacionJs(texto,acc);
			}
			
			
		//--------- PREGUNTAS ---------------//
			function GrabarPregunta(){
				abrir();
				encuesta = document.getElementById("encuesta");
				pregunta = document.getElementById("pregunta");
				tipo = document.getElementById("tipo");
				
				if(pregunta.value !=="" && tipo.value !==""){
					xajax_Grabar_Pregunta(encuesta.value,pregunta.value,tipo.value);
						//botones
						grab = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						grab.className = 'btn btn-primary hidden';
				}else{
					if(pregunta.value ===""){
						pregunta.className = " form-danger";
					}else{
						pregunta.className = " form-control";
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
			
			function ModificarPregunta(){
				abrir();
				codigo = document.getElementById('codigo');
				encuesta = document.getElementById("encuesta");
				pregunta = document.getElementById("pregunta");
				tipo = document.getElementById("tipo");
				
				if(codigo.value !=="" && pregunta.value !=="" && tipo.value !==""){
					xajax_Modificar_Pregunta(codigo.value,encuesta.value,pregunta.value,tipo.value);
						//botones
						grab = document.getElementById('grab');
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						grab.className = 'btn btn-primary hidden';
				}else{
					if(pregunta.value ===""){
						pregunta.className = " form-danger";
					}else{
						pregunta.className = " form-control";
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
			
			
			function Eliminar_Pregunta(codigo,encuesta){
				texto = "Esta seguro de Deshabilitar esta pregunta?, No podra verse en la encuesta con esta situacion...";
				acc = "xajax_Situacion_Pregunta('"+codigo+"','"+encuesta+"');";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Responder(encuesta,pregunta,persona,tipo,ponderacion,respuesta){
				//texto = "xajax_Grabar_Respuesta('"+encuesta+"','"+pregunta+"','"+persona+"','"+tipo+"','"+ponderacion+"','"+respuesta+"');";
				//acc = "";
				//alert(encuesta+","+pregunta+","+persona+","+tipo+","+ponderacion+","+respuesta);
				texto = "Quiere responder esta pregunta?";
				acc = "xajax_Grabar_Respuesta('"+encuesta+"','"+pregunta+"','"+persona+"','"+tipo+"','"+ponderacion+"','"+respuesta+"');";
				//acc = "xajax_Prueba();";
				ConfirmacionJs(texto,acc);
			}
			
			