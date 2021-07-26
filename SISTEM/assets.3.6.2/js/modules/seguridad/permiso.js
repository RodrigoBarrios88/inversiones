//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Submit(tipo){
				myform = document.forms.f1;
				if(tipo === 1){
					myform.action ="REPpermiso.php";
				}else if(tipo === 2){
					myform.action ="REPpermisoexe.php";
				}
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
				gru = document.getElementById('gru');
				desc = document.getElementById('desc');
				clv = document.getElementById('clv');
				
				if(gru.value !== "" && desc.value !== "" && clv.value !== ""){
					xajax_Grabar_Permiso(gru.value,desc.value,clv.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(gru.value ===""){
						gruclassName = " form-danger";
					}else{
						gruclassName = " form-control";
					}
					if(desc.value ===""){
						descclassName = " form-danger";
					}else{
						descclassName = " form-control";
					}
					if(clv.value ===""){
						clvclassName = " form-danger";
					}else{
						clvclassName = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById('cod');
				gru = document.getElementById('gru');
				desc = document.getElementById('desc');
				clv = document.getElementById('clv');
				
				if(cod.value !=="" && gru.value !== "" && desc.value !== "" && clv.value !== ""){
					xajax_Modificar_Permiso(cod.value,gru.value,desc.value,clv.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
				}else{
					if(gru.value ===""){
						gruclassName = " form-danger";
					}else{
						gruclassName = " form-control";
					}
					if(desc.value ===""){
						descclassName = " form-danger";
					}else{
						descclassName = " form-control";
					}
					if(clv.value ===""){
						clvclassName = " form-danger";
					}else{
						clvclassName = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Dashbord(){
				gru = document.getElementById('gru');
				desc = document.getElementById('desc');
				clv = document.getElementById('clv');
				xajax_Dashbord_Permiso(gru.value,desc.value,clv.value);
			}
			