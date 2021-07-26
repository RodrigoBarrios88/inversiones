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
				suc = document.getElementById("suc");
				
				if(desc.value !="" && suc.value !=""){
					xajax_Grabar_PV(desc.value,suc.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(desc.value ==""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(suc.value ==""){
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
				suc = document.getElementById("suc");
				
				if(cod.value !="" && desc.value !="" && suc.value !=""){
					xajax_Modificar_PV(cod.value,desc.value,suc.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(desc.value ==""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(suc.value ==""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function BuscarSaldos(){
				abrir();
				pv = document.getElementById("pv");
				suc = document.getElementById("suc");
				
				if(pv.value !="" && suc.value !=""){
					xajax_Buscar_Saldo_PV(pv.value,suc.value);
					//botones
					gra = document.getElementById("gra");
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary';
					gra.className = 'btn btn-primary hidden';
				}else{
					if(pv.value ==""){
						pv.className = "form-info";
					}else{
						pv.className = "form-control";
					}
					if(suc.value ==""){
						suc.className = "form-info";
					}else{
						suc.className = "form-control";
					}
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}

			
			function Deshabilita_PV(cod,suc){
				texto = "Esta seguro de Deshabilitar este Punto de Venta?, No podra ser usado con esta situaci&oacute;n...";
				acc = "xajax_Situacion_PV("+cod+","+suc+",0)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_PV(cod,suc){
				texto = "Esta seguro de habilitar este Punto de Venta?";
				acc = "xajax_Situacion_PV("+cod+","+suc+",1)";
				ConfirmacionJs(texto,acc);
			}
			