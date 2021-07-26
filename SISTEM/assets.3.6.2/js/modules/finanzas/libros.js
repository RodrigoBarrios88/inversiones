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
			
			
	////////------- Libro de Ventas -------/////////////
	
			function LibroVentas(){
				suc = document.getElementById('suc');
				desde = document.getElementById("desde");
				hasta = document.getElementById("hasta");
				
				if(suc.value !=="" || desde.value !== "" || hasta.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPlibroventas.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = " form-info";
					}else{
						suc.className = " form-control";
					}
					if(desde.value ===""){
						desde.className = " form-info";
					}else{
						desde.className = " form-control";
					}
					if(hasta.value ===""){
						hasta.className = " form-info";
					}else{
						hasta.className = " form-control";
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			
			
	////////------- Libro de Compras -------/////////////
	
			function LibroCompras(){
				suc = document.getElementById('suc');
				desde = document.getElementById("desde");
				hasta = document.getElementById("hasta");
				
				if(suc.value !=="" || desde.value !== "" || hasta.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPlibrocompras.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = " form-info";
					}else{
						suc.className = " form-control";
					}
					if(desde.value ===""){
						desde.className = " form-info";
					}else{
						desde.className = " form-control";
					}
					if(hasta.value ===""){
						hasta.className = " form-info";
					}else{
						hasta.className = " form-control";
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
	
	
	////////------- Libro de Inventario -------/////////////
	
			function LibroInventario(){
				suc = document.getElementById('suc');
				desde = document.getElementById("desde");
				hasta = document.getElementById("hasta");
				
				if(suc.value !=="" || desde.value !== "" || hasta.value !== ""){
					myform = document.forms.f1;
					myform.action ="REPlibroinventario.php";
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = " form-info";
					}else{
						suc.className = " form-control";
					}
					if(desde.value ===""){
						desde.className = " form-info";
					}else{
						desde.className = " form-control";
					}
					if(hasta.value ===""){
						hasta.className = " form-info";
					}else{
						hasta.className = " form-control";
					}
					abrir();
					msj = '<h5>Determinar almenos un criterio de busqueda...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
			