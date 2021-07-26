//funciones javascript y validaciones

			function Set_Inicial(){
				cant = document.getElementsByName("dataTables-example_length");
				cant.value = 50;
				//alert(cant.value);
			}
			
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
				dia = document.getElementById('dia');
				tipo = document.getElementById("tipo");
				pensum = document.getElementById("pensum");
				nivel = document.getElementById("nivel");
				ini = document.getElementById("ini");
				fin = document.getElementById("fin");
				
				if(dia.value !=="" && tipo.value !=="" && pensum.value !=="" && nivel.value !=="" && ini.value !=="" && fin.value !==""){
				   xajax_Grabar_Periodo(dia.value,tipo.value,pensum.value,nivel.value,ini.value,fin.value);
				}else{
					if(dia.value ===""){
						dia.className = " form-danger";
					}else{
						dia.className = " form-control";
					}
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					if(pensum.value ===""){
						pensum.className = " form-danger";
					}else{
						pensum.className = " form-control";
					}
					if(nivel.value ===""){
						nivel.className = " form-danger";
					}else{
						nivel.className = " form-control";
					}
					if(ini.value ===""){
						ini.className = " form-danger";
					}else{
						ini.className = " form-control";
					}
					if(fin.value ===""){
						fin.className = " form-danger";
					}else{
						fin.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				dia = document.getElementById('dia');
				tipo = document.getElementById("tipo");
				pensum = document.getElementById("pensum");
				nivel = document.getElementById("nivel");
				horini = document.getElementById("horini");
				minini = document.getElementById("minini");
				horfin = document.getElementById("horfin");
				minfin = document.getElementById("minfin");
				
				if(dia.value !=="" && tipo.value !=="" && pensum.value !=="" && nivel.value !=="" && ini.value !=="" && fin.value !==""){
					xajax_Modificar_Periodo(cod.value,dia.value,tipo.value,pensum.value,nivel.value,ini.value,fin.value);
				}else{
					if(dia.value ===""){
						dia.className = " form-danger";
					}else{
						dia.className = " form-control";
					}
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					if(pensum.value ===""){
						pensum.className = " form-danger";
					}else{
						pensum.className = " form-control";
					}
					if(nivel.value ===""){
						nivel.className = " form-danger";
					}else{
						nivel.className = " form-control";
					}
					if(ini.value ===""){
						ini.className = " form-danger";
					}else{
						ini.className = " form-control";
					}
					if(fin.value ===""){
						fin.className = " form-danger";
					}else{
						fin.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function GrabarPerGrado(){
				abrir();
				dia = document.getElementById('dia');
				tipo = document.getElementById("tipo");
				pensum = document.getElementById("pensum");
				nivel = document.getElementById("nivel");
				grado = document.getElementById("grado");
				ini = document.getElementById("ini");
				fin = document.getElementById("fin");
				
				if(dia.value !=="" && tipo.value !=="" && pensum.value !=="" && nivel.value !=="" && grado.value !=="" && ini.value !=="" && fin.value !==""){
				   xajax_Grabar_Periodo_Grado(dia.value,tipo.value,pensum.value,nivel.value,grado.value,ini.value,fin.value);
				}else{
					if(dia.value ===""){
						dia.className = " form-danger";
					}else{
						dia.className = " form-control";
					}
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					if(pensum.value ===""){
						pensum.className = " form-danger";
					}else{
						pensum.className = " form-control";
					}
					if(nivel.value ===""){
						nivel.className = " form-danger";
					}else{
						nivel.className = " form-control";
					}
					if(grado.value ===""){
						grado.className = " form-danger";
					}else{
						grado.className = " form-control";
					}
					if(ini.value ===""){
						ini.className = " form-danger";
					}else{
						ini.className = " form-control";
					}
					if(fin.value ===""){
						fin.className = " form-danger";
					}else{
						fin.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function ModificarPerGrado(){
				abrir();
				cod = document.getElementById('cod');
				dia = document.getElementById('dia');
				tipo = document.getElementById("tipo");
				pensum = document.getElementById("pensum");
				nivel = document.getElementById("nivel");
				grado = document.getElementById("grado");
				horini = document.getElementById("horini");
				minini = document.getElementById("minini");
				horfin = document.getElementById("horfin");
				minfin = document.getElementById("minfin");
				
				if(dia.value !=="" && tipo.value !=="" && pensum.value !=="" && nivel.value !=="" && grado.value !=="" && ini.value !=="" && fin.value !==""){
					xajax_Modificar_Periodo_Grado(cod.value,dia.value,tipo.value,pensum.value,nivel.value,grado.value,ini.value,fin.value);
				}else{
					if(dia.value ===""){
						dia.className = " form-danger";
					}else{
						dia.className = " form-control";
					}
					if(tipo.value ===""){
						tipo.className = " form-danger";
					}else{
						tipo.className = " form-control";
					}
					if(pensum.value ===""){
						pensum.className = " form-danger";
					}else{
						pensum.className = " form-control";
					}
					if(nivel.value ===""){
						nivel.className = " form-danger";
					}else{
						nivel.className = " form-control";
					}
					if(grado.value ===""){
						grado.className = " form-danger";
					}else{
						grado.className = " form-control";
					}
					if(ini.value ===""){
						ini.className = " form-danger";
					}else{
						ini.className = " form-control";
					}
					if(fin.value ===""){
						fin.className = " form-danger";
					}else{
						fin.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
			function Deshabilita_Periodo(cod,dia){
				texto = "Esta seguro de Deshabilitar este Periodo?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Periodo("+cod+","+dia+")";
				ConfirmacionJs(texto,acc);
			}
			
			
	///////////// Horarios ////////
			function ExecuteHorario(){
				fini = document.getElementById('fini');
				ffin = document.getElementById('ffin');
				
				if(fini.value !=="" && ffin.value !==""){
					myform = document.forms.f1;
					myform.action ="EXEhorario.php";
					myform.submit();
				}else{
					abrir();
					if(fini.value ===""){
						fini.className = " form-danger";
					}else{
						fini.className = " form-control";
					}
					if(ffin.value ===""){
						ffin.className = " form-danger";
					}else{
						ffin.className = " form-control";
					}
					
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
		///////////// Horarios ////////////
		
			
			function Combo_Tipo_Periodo(){
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				if(pensum.value !==""){
					xajax_Nivel_Tipo_Periodo(pensum.value,nivel.value,'tipo','divtipo',"Submit();");
				}
			}
			
			function Combo_Grado(){
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				if(pensum.value !==""){
					xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Combo_Seccion();");
				}
			}
			
			function Combo_Seccion(){
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById("grado");
				tipo = document.getElementById("tipo");
				if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && tipo.value !== ""){
					xajax_Grado_Seccion(pensum.value,nivel.value,grado.value,tipo.value,'seccion','divseccion','Submit();');
				}
			}
			
			function Combo_Grado_Materia_Seccion(){
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById('grado');
				tipo = document.getElementById('tipo');
				if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && tipo.value !== ""){
					xajax_Grado_Materia_Seccion(pensum.value,nivel.value,grado.value,tipo.value,'materia','divmateria','seccion','divseccion',"","");
				}
			}
			
			
			
			function Asignar_Horario(fila){
				//--
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById("grado");
				tipo = document.getElementById("tipo");
				seccion = document.getElementById("seccion");
				//--
				dia = document.getElementById("dia");
				hini = document.getElementById("hini"+fila);
				periodo = document.getElementById("periodo"+fila);
				codigo = document.getElementById("codigo"+fila);
				existe = document.getElementById("existe"+fila);
				//--
				materia = document.getElementById("materia"+fila);
				maestro = document.getElementById("maestro"+fila);
				aula = document.getElementById("aula"+fila);
				//--
				spancheck = document.getElementById("spancheck"+fila);
				spancheck.title = "Transaccion en proceso...";
				spancheck.className = 'btn btn-warning btn-xs';
				spancheck.innerHTML = '<span class="glyphicon glyphicon-hourglass"></span>';
				
				if(pensum.value !=="" && nivel.value !== "" && grado.value !== "" && tipo.value !== "" && seccion.value !== "" && dia.value !== ""){
					if(periodo.value !== "" && materia.value !== "" && maestro.value !== "" && aula.value !== ""){
						if (codigo.value !== "" && existe.value == 1) {
                            xajax_Modificar_Horario(codigo.value,periodo.value,dia.value,hini.value,pensum.value,nivel.value,grado.value,seccion.value,materia.value,maestro.value,aula.value,fila);
                        }else{
						    xajax_Grabar_Horario(periodo.value,dia.value,hini.value,pensum.value,nivel.value,grado.value,seccion.value,materia.value,maestro.value,aula.value,fila);
                        }
					}	
				}else{
					if(pensum.value ===""){
						pensum.className = "form-danger";
					}else{
						pensum.className = "form-control";
					}
					if(nivel.value ===""){
						nivel.className = "form-danger";
					}else{
						nivel.className = "form-control";
					}
					if(grado.value ===""){
						grado.className = "form-danger";
					}else{
						grado.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(seccion.value ===""){
						seccion.className = "form-danger";
					}else{
						seccion.className = "form-control";
					}
					if(dia.value ===""){
						dia.className = "form-danger";
					}else{
						dia.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ConfirmEliminarHorario(fila){
				texto = "Este es un periodo ya programado.   Pero puede eliminarlo de la programacion si desea. Desea desprogramarlo?";
				acc = "EliminarHorario("+fila+");";
				ConfirmacionJs(texto,acc);
			}
			
			function EliminarHorario(fila){
				//--
				codigo = document.getElementById("codigo"+fila);
				existe = document.getElementById("existe"+fila);
				//--
				spancheck = document.getElementById("spancheck"+fila);
				spancheck.title = "Transaccion en proceso...";
				spancheck.className = 'btn btn-warning btn-xs';
				spancheck.innerHTML = '<span class="glyphicon glyphicon-hourglass"></span>';
				
				if(codigo.value !== "" && existe.value == 1){
                    xajax_Eliminar_Horario(codigo.value,fila);
                }else{
					msj = '<h5>Hay algun error en la programacion, por favor refresque la pagina y vuelva a intentar esta accion...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}