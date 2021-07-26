//funciones javascript y validaciones
			function Limpiar(){
				texto = "¿Desea Limpiar la Pagina?";
				acc = "wndow.location.reload();";
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
			
			
			function Asignar_Monto(fila){
				empresa = document.getElementById('suc');
				clase = document.getElementById('clase');
				anio = document.getElementById("anio");
				mes = document.getElementById('mes');
				codigo = document.getElementById("codigo"+fila);
				partida = document.getElementById("partida"+fila);
				reglon = document.getElementById("reglon"+fila);
				alto = document.getElementById("alto"+fila);
				bajo = document.getElementById("bajo"+fila);
				
                    if(reglon.value !=="" && partida.value !== "" && empresa.value !== "" && clase.value !=="" && anio.value !=="" && mes.value !== ""){
                        xajax_Asignar_Monto(codigo.value,reglon.value,partida.value,empresa.value,anio.value,mes.value,alto.value,bajo.value,fila);
                    }else{
                       if(empresa.value ===""){
                            empresa.className = "form-danger";
                        }else{
                            empresa.className = "form-control";
                        }
                        if(anio.value ===""){
                            anio.className = "form-danger";
                        }else{
                            anio.className = "form-control";
                        }
                        if(mes.value ===""){
                            mes.className = "form-danger";
                        }else{
                            mes.className = "form-control";
                        }
                        if(clase.value ===""){
                            clase.className = "form-danger";
                        }else{
                            clase.className = "form-control";
                        }
                        msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
                        msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
                        document.getElementById('lblparrafo').innerHTML = msj;
                    } 
			}
			
			
			
			function val_campo(n){
				var valor = parseFloat(n.value);
				if (valor <= 0 || isNaN(valor)) {
					valor = 0;	
					n.value = valor.formatMoney();
					return;
				}else{
					n.value = valor.formatMoney();
					return;
				}
			}
			
			function valorSumatoria(col){
				var totalA = 0;
				var totalB = 0;
				var filas = document.getElementById("filas").value;
				TA = document.getElementById("TotalA");
				TB = document.getElementById("TotalB");
				for(var i = 1; i <= filas; i++){
					m1 = document.getElementById("montoA"+i).value;
					m2 = document.getElementById("montoB"+i).value;
					m1 = (m1 === "")?0:m1;
					m2 = (m2 === "")?0:m2;
					totalA+= parseFloat(m1);
					totalB+= parseFloat(m2);
				}
				totalA = parseFloat(totalA) * 100;//-- inicia proceso de redondeo
				totalA = Math.round(totalA); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
				totalA = parseFloat(totalA)/100;//-- finaliza proceso de redondeo 
				TA.value = totalA.formatMoney();
				//--
				totalB = parseFloat(totalB) * 100;//-- inicia proceso de redondeo
				totalB = Math.round(totalB); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
				totalB = parseFloat(totalB)/100;//-- finaliza proceso de redondeo 
				TB.value = totalB.formatMoney();
			}
			
			
