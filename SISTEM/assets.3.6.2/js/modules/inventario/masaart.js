//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "¿Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.href=\'FRMtarifario.php\'";
				ConfirmacionJs(texto,acc);
			}
			
			function PromtCaptura(){
				var n1 = 1;
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/articulo/get_masa.php",{variable1:n1}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirPromt();
			}
			
			function pageprint(){
				menu = document.getElementById("accmenu");
				menu.style.display="none";
				window.print();
				menu.style.display="block";
			}
						
			function ConfirmGrabarList(){
				texto = "¿Desea guardar el Tarifario";
				acc = "Grabar();";
				ConfirmacionJs(texto,acc);
			}
			
			function ConfirmCargar(){
				myform = document.forms.f1;
				myform.submit();
			}
			
			function Grabar(){
				cerrarPromt();
				abrir();
				creaSql();
				myform = document.forms["formsql"];
				myform.action ="EXEgraba_tarifario.php";
				myform.submit();
				cerrar();
			}
			
			function msjAlert(texto){
				msj = '<span>'+texto+'</span><br><br>';
				msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\'FRMtarifario.php\'" />';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
			
			function compara(){
				abrir();
				var msj;
				var cont = 0;
				val1 = document.getElementById('valida1').value;
				val2 = document.getElementById('valida2').value;
				if((val1 > 0)&&(val2 > 0)){
					for (var i = 3; i <= 364; i++) {
						for (var j = 2; j <= 19; j++) {
							div1 = document.getElementById('DIVF'+i+'C'+j);
							T1 = document.getElementById('F'+i+'C'+j);
							T2 = document.getElementById('T2F'+i+'C'+j)
							if(validarNum(T1)){
								it1 = parseFloat(T1.value);
								it2 = parseFloat(T2.value);
								if(it1 != it2){
									div1.style.borderColor = "#DF3A01";
									div1.style.backgroundColor = "#F4FA58";
									msj = spanlook(T1.value,T2.value);
									document.getElementById('SPF'+i+'C'+j).innerHTML = msj;
									cont++;
								}
							}else{
								letra = da_letras(j);
								msj = '<div>Error en la Celda '+letra+i+'. Este valor no es numerico...</div>';
								msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
								document.getElementById('lblparrafo').innerHTML = msj;
								div1.style.borderColor = "#DF0101";
								div1.style.backgroundColor = "F8E0E0";
								return;
							}
						}
					}
					if(cont > 0){
						msj = '<div>'+cont+' Celdas reportan variaci\u00F3n</div><br>';
						msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}else{
						msj = '<div>No hay variacion entre el tarifario vigente y este nuevo tarifario...</div><br>';
						msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					if((val1 == 0)&&(val2 == 0)){
						msj = '<div>No hay tarifarios vigentes...</div></br>';
						msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}else if((val1 > 0)&&(val2 == 0)){
						msj = '<div>El Tarifario vigente tiene vacia la seccion de flete sencillo...</div></br>';
						msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}else if((val1 > 0)&&(val2 == 0)){
						msj = '<div>El Tarifario vigente tiene vacia la seccion de flete plataforma...</div></br>';
						msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}else{
						msj = '<div>No hay tarifarios vigentes...</div></br>';
						msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}
			}
			
			function creaSql(){
				var Sql1="INSERT INTO det_tarifario (det_tarifarionum,det_tipo,det_destino,det_atla,det_lp,det_sm,det_ds,det_ba,det_chim,det_rancho,det_pq,det_nba) VALUES ";
				var Sql2="INSERT INTO det_tarifario (det_tarifarionum,det_tipo,det_destino,det_atla,det_lp,det_sm,det_ds,det_ba,det_chim,det_rancho,det_pq,det_nba) VALUES ";
				var dest;
				var valor;
				//inicia ciclo que recorre filas	
				for (var i = 3; i <= 364; i++) {
					//el codigo en BD inicia desde 1 en el mismo orden que aparece en la hoja de excel (1 destino por fila)
					dest = (i-2);
					//tarifario tipo 1
						//pide valores de celdas
						atla = document.getElementById('F'+i+'C2').value;
						lp = document.getElementById('F'+i+'C3').value;
						sm = document.getElementById('F'+i+'C4').value;
						ds = document.getElementById('F'+i+'C5').value;
						ba = document.getElementById('F'+i+'C6').value;
						chim = document.getElementById('F'+i+'C7').value;
						ran = document.getElementById('F'+i+'C8').value;
						pq = document.getElementById('F'+i+'C9').value;
						nba = document.getElementById('F'+i+'C10').value;
						//crea sql
						Sql1+= "(X,1,"+dest+","+atla+","+lp+","+sm+","+ds+","+ba+","+chim+","+ran+","+pq+","+nba+")";
						if(i == 364){
							Sql1+= ";";
						}else{
							Sql1+= ",";
						}
					//tarifario tipo 2
						//pide valores de celdas
						atla = document.getElementById('F'+i+'C11').value;
						lp = document.getElementById('F'+i+'C12').value;
						sm = document.getElementById('F'+i+'C13').value;
						ds = document.getElementById('F'+i+'C14').value;
						ba = document.getElementById('F'+i+'C15').value;
						chim = document.getElementById('F'+i+'C16').value;
						ran = document.getElementById('F'+i+'C17').value;
						pq = document.getElementById('F'+i+'C18').value;
						nba = document.getElementById('F'+i+'C19').value;
						//crea sql
						Sql2+= "(X,2,"+dest+","+atla+","+lp+","+sm+","+ds+","+ba+","+chim+","+ran+","+pq+","+nba+")";
						if(i == 364){
							Sql2+= ";";
						}else{
							Sql2+= ",";
						}
				}
				//envia los sql a 2 input para realizar el submit
				document.getElementById('sql1').value = Sql1;
				document.getElementById('sql2').value = Sql2;
				return true;		
			}
			
			function validarNum(n){
				permitidos=/[^0-9.]/;
				if(permitidos.test(n.value)){
					return false;
				}
				return true;
			}
			
			
			function spanlook(val1,val2){
				msj = '<a href = "javascript:void(0)" onclick = "MensajeComparacion('+val1+','+val2+');" ><img src = "../../CONFIG/images/zoom.png" width = "15px;" ></a>';
				return msj;
			}
			
			function MensajeComparacion(val1,val2){
				msj = '<span>Valor anterior: '+val2+', Valor actual: '+val1+' </span><br><br>';
				msj+= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar()" />';
				document.getElementById('lblparrafo').innerHTML = msj;
				abrir();
			}
			
			
			function da_letras(val1){
				var letra = "";
				switch(val1){
					case 1: letra = "A"; break;
					case 2: letra = "B"; break;
					case 3: letra = "C"; break;
					case 4: letra = "D"; break;
					case 5: letra = "E"; break;
					case 6: letra = "F"; break;
					case 7: letra = "G"; break;
					case 8: letra = "H"; break;
					case 9: letra = "I"; break;
					case 10: letra = "J"; break;
					case 11: letra = "K"; break;
					case 12: letra = "L"; break;
					case 13: letra = "M"; break;
					case 14: letra = "N"; break;
					case 15: letra = "O"; break;
					case 16: letra = "P"; break;
					case 17: letra = "Q"; break;
					case 18: letra = "R"; break;
					case 19: letra = "S"; break;
				}
				return letra;
			}
			