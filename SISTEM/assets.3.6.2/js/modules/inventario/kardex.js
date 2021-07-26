//funciones javascript y validaciones
				
			function Set_Empresa(valor){
				suc = document.getElementById('suc');
				suc.value = valor;
			}
			
			
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
				abrir();
				suc = document.getElementById("suc");
				gru = document.getElementById('gru');
				art = document.getElementById('art');
				
				if(suc.value !==""){
					if(art.value !=="" || gru.value !==""){
						//--
						myform = document.forms.f1;
						myform.submit();
						//--
					}else{
						if(art.value ===""){
							art.className = " form-danger";
						}else{
							art.className = " form-control";
						}
						if(gru.value ===""){
							gru.className = " form-danger";
						}else{
							gru.className = " form-control";
						}
						msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if(suc.value ===""){
						suc.className = " form-danger";
					}else{
						suc.className = " form-control";
					}
					msj = '<h5>Debe de seleccionar la empresa de donde revisa el Kardex</h5><br><br>';
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
			
			
			function Ver_Kardex_A(suc,gru,art){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventario/kardex1.php",{empresa:suc,grupo:gru,articulo:art}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			function Ver_Kardex_B(suc,gru,art){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/inventario/kardex2.php",{empresa:suc,grupo:gru,articulo:art}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			

			function Deshabilita_Articulo(art,grup){
				texto = "¿Esta seguro de Deshabilitar este Art\u00E1culo?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Articulo("+grup+","+art+",0)";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Habilita_Articulo(art,grup){
				texto = "¿Esta seguro de habilitar este Art\u00E1culo?";
				acc = "xajax_Situacion_Articulo("+grup+","+art+",1)";
				ConfirmacionJs(texto,acc);
			}
			
						
