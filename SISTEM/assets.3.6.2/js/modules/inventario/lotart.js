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
			
			function Buscar(){
				cod = document.getElementById("cod");
				gru = document.getElementById("gru");
				art = document.getElementById("art");
				
				if(gru.value !=="" && suc.value !==""){
					myform = document.forms.f1;
					myform.submit();
				}else{
					abrir();
						if(suc.value ===""){
							suc.className = " form-info";
						}else{
							suc.className = " form-control";
						}
						if(gru.value ===""){
							gru.className = " form-info";
						}else{
							gru.className = " form-control";
						}
						msj = '<h5>Debe Seleccionar un articulo inventariado en alguna empresa...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						art.value="";
				}
			}
						
					
			function Modificar(){
				abrir();
				cod = document.getElementById("cod");
				gru = document.getElementById("gru");
				art = document.getElementById("art");
				prov = document.getElementById("prov");
				nit = document.getElementById("nit");
				nom = document.getElementById("nom");
				prem = document.getElementById("prem");
				prec = document.getElementById("prec");
				prev = document.getElementById("prev");
				
				if(cod.value !==""){
					if(gru.value !=="" && art.value !==""  && prov.value !=="" && prem.value !=="" && prec.value !=="" && prev.value !==""){
						xajax_Modificar_Lote(cod.value,gru.value,art.value,prov.value,prec.value,prev.value,prem.value);
			
					}else{
						if(cod.value ===""){
							cod.className = " form-danger";
						}else{
							cod.className = " form-control";
						}
						if(gru.value ===""){
							gru.className = " form-danger";
						}else{
							gru.className = " form-control";
						}
						if(art.value ===""){
							art.className = " form-danger";
						}else{
							art.className = " form-control";
						}
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
						if(prem.value ===""){
							prem.className = " form-danger";
						}else{
							prem.className = " form-control";
						}
						if(prec.value ===""){
							prec.className = " form-danger";
						}else{
							prec.className = " form-control";
						}
						if(prev.value ===""){
							prev.className = " form-danger";
						}else{
							prev.className = " form-control";
						}
						msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						
					}
				}else{
					msj = '<h5>Error de Traslaci\u00F3n de datos, refresque la pagina e intente de nuevo...</h5><br><br>';
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
				cerrar();
			}
			
			function GrabarProveedor(){
				nit = document.getElementById("pnit1");
				nom = document.getElementById("pnom1");
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
			
			function CalculaMargen(){
				margen = parseFloat(document.getElementById("marg").value);
				costo = parseFloat(document.getElementById("prem").value);
				if((!isNaN(margen)) && (!isNaN(costo))){
					var precio = ((costo * margen)/100)+costo;
					document.getElementById("prec").value = precio;
				}
				return;
			}
			