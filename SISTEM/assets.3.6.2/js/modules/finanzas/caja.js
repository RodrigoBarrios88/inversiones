//funciones javascript y validaciones
			function Set_Empresa(valor){
				suc = document.getElementById('suc');
				suc.value = valor;
			}
			
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
						
			function Grabar(){
				abrir();
				desc = document.getElementById("desc");
				mon = document.getElementById("mon");
				suc = document.getElementById("suc");
				
				if(desc.value !=="" && mon.value !=="" && suc.value !==""){
					xajax_Grabar_Caja(desc.value,mon.value,suc.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(mon.value ===""){
						mon.className = "form-danger";
					}else{
						mon.className = "form-control";
					}
					if(suc.value ===""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById("cod");
				desc = document.getElementById("desc");
				mon = document.getElementById("mon");
				suc = document.getElementById("suc");
				
				if(cod.value !=="" && desc.value !=="" && mon.value !=="" && suc.value !==""){
					xajax_Modificar_Caja(cod.value,desc.value,mon.value,suc.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(mon.value ===""){
						mon.className = "form-danger";
					}else{
						mon.className = "form-control";
					}
					if(suc.value ===""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}

			function Limpia_campos(){
				//limpia campos
				document.getElementById('cod').value = "";
				document.getElementById('desc').value = "";
				document.getElementById('mon').value = "";
				document.getElementById('suc').value = "";
				document.getElementById("sit").value = "";
			}	
			
			
			function Deshabilita_Caja(cod,suc){
				abrir();
				texto = "Esta seguro de Deshabilitar esta Caja?, No podra ser usado con esta situaci&oacute;n...";
				acc = "xajax_Situacion_Caja("+cod+","+suc+");";
				ConfirmacionJs(texto,acc);
			}
			
			
		/////////////-- REPORTES--------------//////////////////
		
			function ReporteLista(){
				suc = document.getElementById("suc");
				mon = document.getElementById("mon");
				sit = document.getElementById("sit");
				
				if(mon.value !=="" || suc.value !=="" || sit.value !==""){
					myform = document.forms.f1;
					myform.action ="REPlista.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.className = "form-control";
						suc.style.backgroundColor = "E6E6E6";
					}
					if(mon.value ===""){
						mon.className = "form-info";
						mon.style.backgroundColor = "819FF7";
					}else{
						mon.className = "form-control";
						mon.style.backgroundColor = "E6E6E6";
					}
					if(sit.value ===""){
						sit.className = "form-info";
						sit.style.backgroundColor = "819FF7";
					}else{
						sit.className = "form-control";
						sit.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReporteSaldo(){
				mon = document.getElementById("mon");
				suc = document.getElementById("suc");
				
				if(mon.value !=="" || suc.value !==""){
					myform = document.forms.f1;
					myform.action ="REPsaldo.php";
					myform.submit();
				}else{
					if(mon.value ===""){
						mon.className = "form-info";
						mon.style.backgroundColor = "819FF7";
					}else{
						mon.className = "form-control";
						mon.style.backgroundColor = "E6E6E6";
					}
					if(suc.value ===""){
						suc.className = "form-info";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.className = "form-control";
						suc.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<h5>Seleccione al menos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ReporteMovimiento(){
				suc = document.getElementById("suc");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(suc.value !==""){
					if(fini.value !=="" && ffin.value !==""){
						myform = document.forms.f1;
						myform.action ="REPmovimiento.php";
						myform.submit();
					}else{
						if(fini.value ===""){
							fini.className = "form-danger";
							fini.style.backgroundColor = "F8E0E0";
						}else{
							fini.className = "form-control";
							fini.style.backgroundColor = "E6E6E6";
						}
						if(ffin.value ===""){
							ffin.className = "form-danger";
							ffin.style.backgroundColor = "F8E0E0";
						}else{
							ffin.className = "form-control";
							ffin.style.backgroundColor = "E6E6E6";
						}
						msj = '<h5>Seleccione el periodo de fechas a desplegar...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if(suc.value ===""){
						suc.className = "form-info";
						suc.style.backgroundColor = "819FF7";
					}else{
						suc.className = "form-control";
						suc.style.backgroundColor = "E6E6E6";
					}
					abrir();
					msj = '<h5>Seleccione una Empresa...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			