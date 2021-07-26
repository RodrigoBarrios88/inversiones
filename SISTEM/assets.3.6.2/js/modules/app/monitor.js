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
				cui = document.getElementById('cui');
				nom = document.getElementById('nom');
				ape = document.getElementById("ape");
				mail = document.getElementById('mail');
				tel = document.getElementById("tel");
				
				if(cui.value !="" && nom.value !="" && ape.value != "" && tel.value != "" && mail.value != ""){
					xajax_Grabar_Monitor(cui.value,nom.value,ape.value,tel.value,mail.value);
				}else{
					if(cui.value ==""){
						cui.className = "form-danger";
					}else{
						cui.className = "form-control";
					}
					if(nom.value ==""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(ape.value ==""){
						ape.className = "form-danger";
					}else{
						ape.className = "form-control";
					}
					if(tel.value ==""){
						tel.className = "form-danger";
					}else{
						tel.className = "form-control";
					}
					if(mail.value ==""){
						mail.className = "form-danger text-libre";
					}else{
						mail.className = "form-control text-libre";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cui = document.getElementById('cui');
				nom = document.getElementById('nom');
				ape = document.getElementById("ape");
				mail = document.getElementById('mail');
				tel = document.getElementById("tel");
				
				if(nom.value !="" && ape.value != "" && tel.value != "" && mail.value != ""){
					xajax_Modificar_Monitor(cui.value,nom.value,ape.value,tel.value,mail.value);
				}else{
					if(nom.value ==""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(ape.value ==""){
						ape.className = "form-danger";
					}else{
						ape.className = "form-control";
					}
					if(tel.value ==""){
						tel.className = "form-danger";
					}else{
						tel.className = "form-control";
					}
					if(mail.value ==""){
						mail.className = "form-danger text-libre";
					}else{
						mail.className = "form-control text-libre";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			

			function Deshabilita_Monitor(cui){
				texto = "&iquest;Esta seguro de Inhabilitar este(a) Monitor?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Monitor('"+cui+"',2)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_Monitor(cui){
				texto = "&iquest;Esta seguro de Re-Activar este(a) Monitor?";
				acc = "xajax_Situacion_Monitor('"+cui+"',1)";
				ConfirmacionJs(texto,acc);
			}
			
			function Busca_Grupos_Monitor(cui,area){
				if (cui != "") {
					xajax_Grupos_Monitor(cui,area);
				}
			}
			
			function Asigna_Grupos_Monitor(){
				abrir();
				cui = document.getElementById("cui");
				area = document.getElementById("area");
				filas =  document.getElementById("xasignarrows").value;
				if(filas > 0) {
					if(cui.value) {
						arrgrupos = new Array();
						var cuantos = 0;
						for(i = 1; i <= filas; i++){
							chk = document.getElementById("xasignar"+i);
							if(chk.checked) {
								arrgrupos[cuantos] = chk.value;
								cuantos++;
							}
						}
						if(cuantos > 0) {
							xajax_Graba_Monitor_Grupos(cui.value,area.value,arrgrupos,cuantos);
						}else{
							msj = '<h5>Debe seleccionar almenos un (01) Grupo...</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						msj = '<h5>Debe seleccionar almenos un (01) Monitor...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}	
				}else{
					msj = '<h5>Debe seleccionar almenos un (01) Grupo...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			
			function Quitar_Grupos_Monitor(){
				abrir();
				cui = document.getElementById("cui");
				area = document.getElementById("area");
				filas =  document.getElementById("asignadosrows").value;
				if(filas > 0) {
					if(area.value) {
						arrgrupos = new Array();
						var cuantos = 0;
						for(i = 1; i <= filas; i++){
							chk = document.getElementById("asignados"+i);
							if(chk.checked) {
								arrgrupos[cuantos] = chk.value;
								cuantos++;
							}
						}
						if(cuantos > 0) {
							xajax_Quitar_Monitor_Grupos(cui.value,area.value,arrgrupos,cuantos);
						}else{
							msj = '<h5>Debe seleccionar almenos un (01) Grupo...</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
						}
					}else{
						msj = '<h5>Debe seleccionar almenos el area...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}	
				}else{
					msj = '<h5>Debe seleccionar almenos un (01) Grupo...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			