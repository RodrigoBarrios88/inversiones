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
				pv = document.getElementById("pv");
				suc = document.getElementById("suc");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(pv.value !=="" && suc.value !==""){
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
					if(pv.value ===""){
						pv.className = "form-info";
					}else{
						pv.className = "form-control";
					}
					if(suc.value ===""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					msj = '<h5>Seleccione el Punto de Venta (Caja) a consultar...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			
			function Seleccionar_PV(PV,pvnombre,empresa,sucnombre,tipo){
				//alert("entro");
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/PVs/movpv.php",{caj:PV,nom:pvnombre,suc:empresa,sucn:sucnombre,tip:tipo}, function(data){
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
				mon = document.getElementById("mon1");
				doc = document.getElementById("doc1");
				tip = document.getElementById("tip1");
				mot = document.getElementById("mot1");
				fecha = document.getElementById("fecha1");
				
				if(suc.value !="" && caj.value !="" && mov.value !="" && mont.value !="" && doc.value !="" && tip.value !="" && fecha.value !=""){
					var montext = mon.options[mon.selectedIndex].text;
					//-- extrae el simbolo de la moneda y tipo de cambio
					monchunk = montext.split("/");
					var Vmonc = monchunk[2]; // Tipo de Cambio
						Vmonc = Vmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
						Vmonc = Vmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
					//--
					xajax_Grabar_Movimiento_PV(suc.value,caj.value,mov.value,mont.value,mon.value,Vmonc,doc.value,tip.value,mot.value,fecha.value);
				}else{
					if(suc.value ==""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					if(caj.value ==""){
						caj.className = "form-danger";
					}else{
						caj.className = "form-control";
					}
					if(mov.value ==""){
						mov.className = "form-danger";
					}else{
						mov.className = "form-control";
					}
					if(mont.value ==""){
						mont.className = "form-danger";
					}else{
						mont.className = "form-control";
					}
					if(mon.value ==""){
						mon.className = "form-danger";
					}else{
						mon.className = "form-control";
					}
					if(doc.value ==""){
						doc.className = "form-danger";
					}else{
						doc.className = "form-control";
					}
					if(tip.value ==""){
						tip.className = "form-danger";
					}else{
						tip.className = "form-control";
					}
					if(fecha.value ==""){
						fecha.className = "form-danger";
					}else{
						fecha.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
				