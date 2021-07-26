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
						
			function Grabar(){
				abrir();
				dct = document.getElementById('dct');
				dlg = document.getElementById('dlg');
				salario = document.getElementById('salario');
				horas = document.getElementById('horas');
				suc = document.getElementById('suc');
				dep = document.getElementById('dep');
				jer = document.getElementById('jer');
				sub = document.getElementById('sub');
				ind = (document.getElementById("ind").checked)?1:0;
				jer.value = 1000;
				var jerarquia = (ind == 0 && sub.value == "")?"ERROR":"OK";
				
					if(dct.value !== "" && dlg.value !== "" && salario.value !== "" && horas.value !== "" && suc.value !== "" && dep.value !== "" && jerarquia == "OK"){
						xajax_Grabar_Plazas(dct.value,dlg.value,salario.value,horas.value,suc.value,dep.value,jer.value,sub.value,ind);
					}else{
						if(dct.value ===""){
							dct.className = 'form-danger';
						}else{
							dct.className = 'form-control';
						}
						if(dlg.value ===""){
							dlg.className = 'form-danger';
						}else{
							dlg.className = 'form-control';
						}
						if(salario.value ===""){
							salario.className = 'form-danger';
						}else{
							salario.className = 'form-control';
						}
						if(horas.value ===""){
							horas.className = 'form-danger';
						}else{
							horas.className = 'form-control';
						}
						if(suc.value ===""){
							suc.className = 'form-danger';
						}else{
							suc.className = 'form-control';
						}
						if(dep.value ===""){
							dep.className = 'form-danger';
						}else{
							dep.className = 'form-control';
						}
						if(jerarquia == "ERROR"){
							document.getElementById('descsub').className = 'form-danger';
						}else{
							document.getElementById('descsub').className = 'form-control';
						}
						msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						
					}
			}
			
			function Modificar(){
				abrir();
				plaza = document.getElementById('plaza');
				dct = document.getElementById('dct');
				dlg = document.getElementById('dlg');
				salario = document.getElementById('salario');
				horas = document.getElementById('horas');
				suc = document.getElementById('suc');
				dep = document.getElementById('dep');
				jer = document.getElementById('jer');
				sub = document.getElementById('sub');
				ind = (document.getElementById("ind").checked)?1:0;
				jer.value = 1000;
				
				//alert(dct.value+","+dlg.value+","+salario.value+","+horas.value+","+suc.value+","+dep.value+","+jer.value+","+sub.value);
					if(dct.value !== "" && dlg.value !== "" && salario.value !== "" && horas.value !== "" && suc.value !== "" && dep.value !== "" && jer.value !== "" && sub.value !== ""){
						xajax_Modificar_Plazas(plaza.value,dct.value,dlg.value,salario.value,horas.value,suc.value,dep.value,jer.value,sub.value,ind);
					}else{
						if(dct.value ===""){
							dct.className = 'form-danger';
						}else{
							dct.className = 'form-control';
						}
						if(dlg.value ===""){
							dlg.className = 'form-danger';
						}else{
							dlg.className = 'form-control';
						}
						if(salario.value ===""){
							salario.className = 'form-danger';
						}else{
							salario.className = 'form-control';
						}
						if(horas.value ===""){
							horas.className = 'form-danger';
						}else{
							horas.className = 'form-control';
						}
						if(suc.value ===""){
							suc.className = 'form-danger';
						}else{
							suc.className = 'form-control';
						}
						if(dep.value ===""){
							dep.className = 'form-danger';
						}else{
							dep.className = 'form-control';
						}
						if(sub.value ===""){
							sub.className = 'form-danger';
						}else{
							sub.className = 'form-control';
						}
						if(jer.value ===""){
							sub.className = 'form-danger';
						}else{
							sub.className = 'form-control';
						}
						msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						
					}	
			}
			
			
			function CambiarSitConfirm(){
				abrir();
				texto = "Desea realmente quiere quitar a esta persona de la plaza?...";
				acc = "CambiarSit();";
				ConfirmacionJs(texto,acc);
			}
			
			
			function PromtInfoPlaza(cod){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/organizacion/info_plaza.php",{codigo:cod}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirPromt();
			}
			
			function EliminarPlaza(plaza){
				abrir();
				texto = "Desea realmente eliminar esta plaza?...";
				acc = "xajax_Eliminar_Plaza('"+plaza+"');";
				ConfirmacionJs(texto,acc);
			}
			
			
			function OrganigramaAction(n){
				x = document.getElementById("inp"+n).value;
				var img;
				if(x === 1){
					document.getElementById(n).style.display= "none";
					document.getElementById("inp"+n).value = 0;
					img = '<span class="fa fa-plus-circle"></span>';
				}else{
					document.getElementById(n).style.display= "block";
					document.getElementById("inp"+n).value = 1;
					img = '<span class="fa fa-minus-circle"></span>';
				}
				document.getElementById("img"+n).innerHTML = img;
			}
			
			
			function OrganigramaSit(){
				var codigos = document.getElementById("codigos").value;
				var cadena;
				var img;
				cadena = codigos.split(",");
				for(var i = 0; i < cadena.length; i++){
					var elemento = document.getElementById(cadena[i]);
					var status = document.getElementById("inp"+cadena[i]).value;
					var imagen = document.getElementById("img"+cadena[i]);
					if(status === 1){
						elemento.style.display= "block";
						img = '<span class="fa fa-minus-circle"></span>';
					}else{
						elemento.style.display= "none";
						img = '<span class="fa fa-plus-circle"></span>';
					}
					imagen.innerHTML = img;
				}	
			}
			
			
			function SeleccionarPlaza(n){
				var nombre = n.id;
				var cod = nombre.replace("radio", ""); 
				var descripcion = document.getElementById("div"+cod).innerHTML;
				plaza = document.getElementById("plaza");
				desc = document.getElementById("descsub");
				plaza.value = cod;
				desc.value = descripcion;
			}
						
			function AceptarSubord(){
				abrir();
				plaza = document.getElementById("plaza").value;
				jer = document.getElementById("jer").value;
				desc = document.getElementById("descsub").value;
				//alert(plaza+","+jer+","+desc);
				if(plaza !== ''){
					//FORMULARIO QUE RECIBE
					self.opener.document.getElementById("sub").value = plaza;
					self.opener.document.getElementById("jer").value = jer;
					self.opener.document.getElementById("descsub").innerHTML = desc;
					window.close();
				}else{
					msj = '<h5>Debe Seleccionar una Plaza.......</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
									
			function View_Org(){
				abrir();
				var suc = document.getElementById("suc").value;
				var dep = document.getElementById("dep").value;
				
				if(suc !== ''){
					cerrar();
					window.open('FRMorganigramaasig.php?suc='+suc+'&dep='+dep, 'popup', 'width=900,height=600,dependent=0,scrollbars=1');
				}else{
					msj = '<h5>Debe seleccionar una Empresa....</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function Set_plaza_enter(key,inp,dest,property){
				var unicode;
				if (key.charCode){
					unicode=key.charCode;
				}else{
					unicode=key.keyCode;
				}
				//alert(unicode); // Para saber que codigo de tecla presiono , descomentar
				if (unicode === 13){
					abrir();
					xajax_Set_Desc_Plaza(inp.value,dest,property);
				}
				
			}
			
			function Top_Jerarquia(ele,ele2nom,ele3nom,spannom){
				ele2 = document.getElementById(ele2nom);
				ele3 = document.getElementById(ele3nom);
				span = document.getElementById(spannom);
				if(ele.checked){
					ele2.value = 999;
					ele3.value = 1000;
					ele2.setAttribute('disabled','disabled'); 
					span.innerHTML = "";
				}else{
					ele2.value = "";
					ele3.value = "";
					ele2.removeAttribute('disabled'); 
					span.innerHTML = "";
				}
			}
			
			
			function RepOrganigrama(){
				suc = document.getElementById('suc');
				dep = document.getElementById('dep');
				
				if(suc.value !=="" || dep.value !==""){
					myform = document.forms.f1;
					myform.action ="FRMorganigrama.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = 'form-danger';
					}else{
						suc.className = 'form-control';
					}
					if(dep.value ===""){
						dep.className = 'form-danger';
					}else{
						dep.className = 'form-control';
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			//////------ ASIGNACION DE PLAZAS -----------//////////
			
			function GrabarAsignacion(){
				abrir();
				dpi = document.getElementById('dpi');
				nom = document.getElementById('nom');
				ape = document.getElementById('ape');
				descplaza = document.getElementById('descsub');
				plaza = document.getElementById('sub');
				
					if(dpi.value !== "" && plaza.value !== ""){
						xajax_Asignar_Plaza(dpi.value,plaza.value);
					}else{
						if(dpi.value ===""){
							nom.className = 'form-danger';
							ape.className = 'form-danger';
						}else{
							nom.className = 'form-control';
							ape.className = 'form-control';
						}
						if(plaza.value ===""){
							descplaza.className = 'form-danger';
						}else{
							descplaza.className = 'form-control';
						}
						msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						
					}
			}
			
			//////------ Reportes -----------//////////
		
			function ReporteLista(){
				dct = document.getElementById('dct');
				dlg = document.getElementById('dlg');
				suc = document.getElementById('suc');
				dep = document.getElementById('dep');
				sit = document.getElementById("sit");
				
				if(suc.value !=="" || dep.value !=="" || dct.value !== "" || dlg.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPlista.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = 'form-danger';
					}else{
						suc.className = 'form-control';
					}
					if(dep.value ===""){
						dep.className = 'form-danger';
					}else{
						dep.className = 'form-control';
					}
					if(dct.value ===""){
						dct.className = 'form-danger';
					}else{
						dct.className = 'form-control';
					}
					if(dlg.value ===""){
						dlg.className = 'form-danger';
					}else{
						dlg.className = 'form-control';
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
						