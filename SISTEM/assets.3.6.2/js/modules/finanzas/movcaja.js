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
			
			
			function Buscar(){
				abrir();
				mon = document.getElementById("mon");
				suc = document.getElementById("suc");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(mon.value !=="" || suc.value !==""){
					if(fini.value !=="" && ffin.value !==""){
						myform = document.forms.f1;
						myform.submit();
					}else{
						if(fini.value ===""){
							fini.className = "form-danger";
						}else{
							fini.className = "form-control";
						}
						if(ffin.value ===""){
							ffin.className = "form-danger";
						}else{
							ffin.className = "form-control";
						}
						msj = '<h5>Seleccione el periodo de fechas a desplegar...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if(mon.value ===""){
						mon.className = "form-info";
					}else{
						mon.className = "form-control";
					}
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					msj = '<h5>Seleccione al menos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}						
			
			
			function Seleccionar_Caja_Movimientos(codigo){
				cod = document.getElementById("cod");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				if(fini.value !=="" && ffin.value !==""){
					cod.value = codigo;
					myform = document.forms.f1;
					myform.submit();
				}else{
					if(fini.value ===""){
						fini.className = "form-danger";
					}else{
						fini.className = "form-control";
					}
					if(ffin.value ===""){
						ffin.className = "form-danger";
					}else{
						ffin.className = "form-control";
					}
					msj = '<h5>Seleccione el periodo de fechas a desplegar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			
			function Seleccionar_Caja(caja,empresa,sucnombre,tipo){
				//alert("entro");
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/cajas/movcaja.php",{caj:caja,suc:empresa,sucn:sucnombre,tip:tipo}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}	
			
						
			function GrabarMovimiento(){
				abrirMixPromt();
				suc = document.getElementById("suc1");
				caj = document.getElementById("caj1");
				mov = document.getElementById("mov1");
				mont = document.getElementById("mont1");
				doc = document.getElementById("doc1");
				tip = document.getElementById("tip1");
				mot = document.getElementById("mot1");
				fecha = document.getElementById("fecha1");
				
				if(suc.value !=="" && caj.value !=="" && mov.value !=="" && mont.value !=="" && doc.value !=="" && tip.value !=="" && fecha.value !==""){
					xajax_Grabar_Movimiento_Caja(suc.value,caj.value,mov.value,mont.value,doc.value,tip.value,mot.value,fecha.value);
				}else{
					if(suc.value ===""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					if(caj.value ===""){
						caj.className = "form-danger";
					}else{
						caj.className = "form-control";
					}
					if(mov.value ===""){
						mov.className = "form-danger";
					}else{
						mov.className = "form-control";
					}
					if(mont.value ===""){
						mont.className = "form-danger";
					}else{
						mont.className = "form-control";
					}
					if(doc.value ===""){
						doc.className = "form-danger";
					}else{
						doc.className = "form-control";
					}
					if(tip.value ===""){
						tip.className = "form-danger";
					}else{
						tip.className = "form-control";
					}
					if(fecha.value ===""){
						fecha.className = "form-danger";
					}else{
						fecha.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
				