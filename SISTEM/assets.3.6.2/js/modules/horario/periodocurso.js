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
				curso = document.getElementById("curso");
				ini = document.getElementById("ini");
				fin = document.getElementById("fin");
				
				if(dia.value !=="" && tipo.value !=="" && curso.value !=="" && ini.value !=="" && fin.value !==""){
				   xajax_Grabar_Periodo(dia.value,tipo.value,curso.value,ini.value,fin.value);
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
					if(curso.value ===""){
						curso.className = " form-danger";
					}else{
						curso.className = " form-control";
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
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				dia = document.getElementById('dia');
				tipo = document.getElementById("tipo");
				curso = document.getElementById("curso");
				horini = document.getElementById("horini");
				minini = document.getElementById("minini");
				horfin = document.getElementById("horfin");
				minfin = document.getElementById("minfin");
				
				if(dia.value !=="" && tipo.value !=="" && curso.value !=="" && ini.value !=="" && fin.value !==""){
					xajax_Modificar_Periodo(cod.value,dia.value,tipo.value,curso.value,ini.value,fin.value);
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
					if(curso.value ===""){
						curso.className = " form-danger";
					}else{
						curso.className = " form-control";
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
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
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
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
		///////////// Horarios ////////////
			
			function Asignar_Horario(fila){
				//--
				curso = document.getElementById('curso');
				//--
				dia = document.getElementById("dia");
				hini = document.getElementById("hini"+fila);
				periodo = document.getElementById("periodo"+fila);
				codigo = document.getElementById("codigo"+fila);
				existe = document.getElementById("existe"+fila);
				//--
				maestro = document.getElementById("maestro"+fila);
				aula = document.getElementById("aula"+fila);
				cupo = document.getElementById("cupo"+fila);
				//--
				spancheck = document.getElementById("spancheck"+fila);
				spancheck.title = "Transaccion en proceso...";
				spancheck.className = 'btn btn-warning btn-xs';
				spancheck.innerHTML = '<span class="glyphicon glyphicon-hourglass"></span>';
				
				if(curso.value !=="" && dia.value !== ""){
					if(periodo.value !== "" && maestro.value !== "" && aula.value !== "" && cupo.value !== ""){
						if (codigo.value !== "" && existe.value == 1) {
                            xajax_Modificar_Horario(codigo.value,periodo.value,dia.value,hini.value,curso.value,maestro.value,aula.value,cupo.value,fila);
                        }else{
						    xajax_Grabar_Horario(periodo.value,dia.value,hini.value,curso.value,maestro.value,aula.value,cupo.value,fila);
                        }
					}	
				}else{
					if(curso.value ===""){
						curso.className = "form-danger";
					}else{
						curso.className = "form-control";
					}
					if(dia.value ===""){
						dia.className = "form-danger";
					}else{
						dia.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			function ConfirmEliminarHorario(fila){
				texto = "Este es un periodo ya programado. Pero puede eliminarlo de la programacion si desea. Desea desprogramarlo?";
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
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}